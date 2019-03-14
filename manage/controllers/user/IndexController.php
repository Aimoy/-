<?php
namespace manage\controllers\user;

use manage\controllers\MyController;

/**
 * Site controller
 */
class IndexController extends MyController
{


    public function actionIndex()
    {
        $user = \Yii::$app->user->identity;
        var_dump($user->id,$user->username);die;
    }

}
