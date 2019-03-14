<?php
/**
 * Created by PhpStorm.
 * User: charlie
 * Date: 2018/6/20
 * Time: 上午11:45
 */

namespace manage\library;

use manage\library\phantomjs\ScreenShot;
use Pheanstalk\Pheanstalk;
use yii\db\Exception;

class QueueJob
{
    /** @var  Pheanstalk */
    public static $beanstalk;

    /**
     * @param $channel 通道，按功能区分
     * @param $value  消息体数据，主要是业务处理数据，大小<=64kb
     * @param int $delayTime 为0即为即时消息，>0为延迟队列，单位为s
     * @param int $priority 优先级，默认即可
     * @param int $reservedTimeout 消费超时节点转移，单节点默认即可
     */
    public static function add($channel, $value, $delayTime = 0, $priority = 0, $reservedTimeout = 3)
    {
        self::init();
        $id = self::$beanstalk->useTube($channel)->put(json_encode($value), $priority, $delayTime, $reservedTimeout);
        return $id;
        //获取任务
//        $job = self::$beanstalk->peek($id);
//        //查看任务状态
//        print_r(self::$beanstalk->statsJob($job));
    }

    public static function init()
    {
        $beanstalkConf = \Yii::$app->components['beanstalk'];
        self::$beanstalk = new Pheanstalk($beanstalkConf['hostname'], $beanstalkConf['port']);
    }

    /**
     * @param $channel 通道
     * @param int $processTime 处理超时时间
     * @return mixed
     */
    public static function reserve($channel, $processTime = 3)
    {
        $job = self::$beanstalk->watch($channel)
            ->ignore('default')
            ->reserve($processTime);

        $jobData = $job->getData();
        self::$beanstalk->delete($job);

        return $jobData;
    }


    /**
     * @param $id 消息id
     */
    public static function del($id){
        self::init();
        $job = self::$beanstalk->peek($id);
        self::$beanstalk->delete($job);
    }


    /**
     * 添加已发布文章队列任务
     * @param $article_id
     * @return int
     */
    public static function addQueueJobOfGenerateArticleOssContentImage($article_id)
    {
        self::init();
        $res = self::$beanstalk->useTube('phantomjs_oss')->put($article_id);
        \Yii::info($article_id . '添加队列任务成功:queueJobId:' . $res);
        return $res;
    }

    /** 执行文章截图queue任务 */
    public static function doQueueJobOfGenerateArticleOssContentImage()
    {
        self::init();
        $job = self::$beanstalk->watch('phantomjs_oss')->ignore('default')->reserve();
        if ($job === false) {
            return false;
        }

        $article_id = $job->getData();
        /** @var ScreenShot $phantomjs */
        $phantomjs = \Yii::$app->phantomjs;
        try {
            $res = $phantomjs->shotArticleContentThenUploadToOss($article_id);
            if ($res->code == 0) {
                self::$beanstalk->delete($job);
                \Yii::info('队列任务执行:phantomjs截图失败:文章ID:' . $article_id . json_encode($res->data));
            } else {
                \Yii::warning('执行队列任务:phantomjs截图失败:文章ID:' . $article_id . json_encode($res->data));
            }
            return $res->data;
        } catch (Exception $e) {
            \Yii::error($e->getMessage());
        }
        return false;
    }

}
