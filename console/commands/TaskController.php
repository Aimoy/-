<?php


namespace app\commands;


use yii\console\Controller;
class TaskController extends Controller


{

    /**
     * 添加命令行任务控制器，为后期跑任务做准备
     * @param string $message 命令行参数
     */

    public function actionIndex($message = 'hello world')


    {


        echo $message . "\n";


    }


}