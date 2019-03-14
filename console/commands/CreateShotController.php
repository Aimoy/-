<?php


namespace app\commands;

use manage\library\BizException;
use manage\library\QueueJob;
use Predis\Client;
use yii\console\Controller;
use yii\db\Query;

class CreateShotController extends Controller
{

    public function actionIndex()
    {
        //$dome_article_set_key = 'screenshot_ed_article_ids';
        $fail_log_key = 'screenshot_fail_log';

        $redis = $this->pRedis();
        $q = new Query();
        $article_ids = $q->from('info_published')->select('id')->where(['status' => 0])->all();
        $tempIds = array_column($article_ids, 'id');
        foreach ($tempIds as $article_id) {

            try {
                $res = QueueJob::addQueueJobOfGenerateArticleOssContentImage($article_id);
            } catch (BizException $e) {
                $redis->hset($fail_log_key, $article_id, $e->getMessage());
            }
        }
    }

    public function actionDoJob()
    {
        while (true) {
            $res = QueueJob::doQueueJobOfGenerateArticleOssContentImage();
            print_r($res);
        }
    }

    private function pRedis()
    {
        $redisConf = \Yii::$app->components['redis'];
        $config = [
            'host' => $redisConf['hostname'],
            'port' => $redisConf['port'],
            'database' => $redisConf['database']
        ];
        if (isset($redisConf['password'])) {
            $config['password'] = $redisConf['password'];
        }

        $redis = new Client($config);

        return $redis;

    }

    public function actionShot222($article_id)
    {

        /** @var ScreenShot $phantomjs */
        $phantomjs = \Yii::$app->phantomjs;

        $res = $phantomjs->shotArticleContentThenUploadToOss($article_id);
        print_r($res);
    }


}