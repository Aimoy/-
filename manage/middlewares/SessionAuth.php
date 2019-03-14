<?php

namespace manage\middlewares;
use manage\library\BizException;
use yii\web\Request;
/**
 * Created by PhpStorm.
 * User: duanwei
 * Date: 2018/4/13
 * Time: 下午2:26
 */

class SessionAuth implements MiddlewareImp
{

    public function handle()
    {
        \Yii::$app->user->enableSession = true;
        \Yii::$app->user->enableAutoLogin = true;

        if(\Yii::$app->user->enableSession && \Yii::$app->user->isGuest){   //session
            throw new BizException(BizException::SESSION_FAIL);
        }
        return true;
    }


}