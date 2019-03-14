<?php


namespace app\commands;

use yii\console\Controller;
use SensitiveService\SensitiveWord;

class LoadWordLibController extends Controller
{

    /**
     *  加载本地词库
     */
    public function actionIndex()
    {
        $redisConf = \Yii::$app->components['redis'];
        $config = [
            'hostname'=>$redisConf['hostname'],
            'port'=>$redisConf['port'],
            'database'=>$redisConf['database']
        ];

        $sensitiveService = SensitiveWord::getInstance($config);
        $sensitiveService->clear();
        $sensitiveService->loadWordLib();
    }

    /**
     * 加载指定文件
     */
    public function actionFile()
    {
        $files = func_get_args();
        $redisConf = \Yii::$app->components['redis'];
        $config = [
            'hostname'=>$redisConf['hostname'],
            'port'=>$redisConf['port'],
            'database'=>$redisConf['database']
        ];
        $sensitiveService = SensitiveWord::getInstance($config);
        $sensitiveService->loadWordLib($files);
    }

    /**
     * 清除
     */
    public function actionClear()
    {
        $redisConf = \Yii::$app->components['redis'];
        $config = [
            'hostname'=>$redisConf['hostname'],
            'port'=>$redisConf['port'],
            'database'=>$redisConf['database']
        ];

        $sensitiveService = SensitiveWord::getInstance($config);
        $sensitiveService->clear();
    }


}