<?php


namespace app\commands;

use Pheanstalk\Pheanstalk;
use yii\console\Controller;

class QueueJobController extends Controller
{
    public static $beanstalk;

    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub

        $beanstalkConf = \Yii::$app->components['beanstalk'];
        self::$beanstalk = new Pheanstalk($beanstalkConf['hostname'], $beanstalkConf['port']);
    }

    public function actionDelayUpdate()
    {
//        $n=11;
        while (true) {
            $data = $this->reserve('test');
            var_dump($data);
            //TODO  process biz
        }

        return true;
    }


    private function reserve($channel, $processTime = 30)
    {
        $job = self::$beanstalk->watch($channel)
            ->ignore('default')
            ->reserve($processTime);

        $jobData = null;
        if ($job) {
            $jobData = $job->getData();
            self::$beanstalk->delete($job);
        }

        return $jobData;
    }

}