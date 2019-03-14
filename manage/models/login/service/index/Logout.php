<?php
/**
 * Created by PhpStorm.
 * User: charlie
 * Date: 2018/4/8
 * Time: 上午11:29
 */

namespace manage\models\login\service\index;

use manage\library\Cache;

class Logout
{

    public function execute($data)
    {
        $token = \Yii::$app->request->getHeaders()->get('Authorization');
        $cache = new Cache();
        if($token && $cache->exists('login.login.user_login',$token))
        {
            $cache->del('login.login.user_login',$token);
        }
        return true;
    }

}