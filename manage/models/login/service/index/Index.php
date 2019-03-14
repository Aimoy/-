<?php
/**
 * Created by PhpStorm.
 * User: charlie
 * Date: 2018/4/8
 * Time: 上午11:29
 */

namespace manage\models\login\service\index;

use linslin\yii2\curl\Curl;
use manage\library\BizException;
use manage\library\Cache;
use manage\library\Validation;

class Index
{


    public function execute($data)
    {
        $valid = new Validation($data);
        $valid->add_rules('username','required');
        $valid->add_rules('password','required');
        if (!$valid->validate()) {
            throw new BizException(BizException::PARAM_ERROR );
        }

        if(YII_ENV != 'prod' && $data['username']=="admin" && $data['password']=="admin")
        {
            $token = \Yii::$app->security->generateRandomString();
            $userInfo = [];
            $userInfo['account'] = '管理员';
            $userInfo['realName'] = '管理员';
            $userInfo['avatar'] = 'https://img.tdf.ministudy.com/avatar/151727760286090200.jpg';
            $userInfo['token'] = $token;

            $cache = new Cache();
            $cache->set('login.login.admin_info', -1, json_encode($userInfo));
            $cache->set('login.login.user_login', $token, -1);

            return $userInfo;
        }

        $curl = new Curl();
        $response = $curl->setPostParams(['username'=>$data['username'],'password'=>$data['password']])->post(\Yii::$app->params['singer']."/rest/admin-login");
        if($res = json_decode($response,true))
        {
            if(isset($res['code']) && $res['code']==100000){
                $token = \Yii::$app->security->generateRandomString();
                $cache = new Cache();
                $cache->set('login.login.admin_info', $res['item']['id'], json_encode($res['item']));
                $cache->set('login.login.user_login', $token, $res['item']['id']);
                $userInfo = [];
                $userInfo['account'] = $res['item']['account'];
                $userInfo['avatar'] = $res['item']['avatar'];
                $userInfo['token'] = $token;

                return $userInfo;
            }else{
                throw new BizException(BizException::LOGIN_FAIL );
            }
        }
        throw new BizException(BizException::LOGIN_FAIL );
    }

}