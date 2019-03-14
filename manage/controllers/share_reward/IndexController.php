<?php
/***************************************************************************
 *
 * Copyright (c) 2018 sunlands.com, Inc. All Rights Reserved
 *
 ***************************************************************************/


/**
 *
 * 帮助文档
 * https://blog.csdn.net/jiqiren122424629/article/details/53300641
 * https://note.guotianyu.cn/PHP/61.html
 *
 *
 * file IndexController.php
 * author zhouqing (zhouqing@sunlands.com )
 * date 2018-06-27
 *
 **/

namespace manage\controllers\share_reward;

use manage\models\information\bo\Publish;

class IndexController extends \manage\controllers\MyController
{

    public $layout = false;


    /**
     * desc : 渲染分享页面(前端无关)
     */
    public function actionView()
    {
        $article_id = $this->get("article_id");// 文章ID
        $post_id = $this->get("post_id");// 帖子ID

        $publishedBo = new Publish();

        $infoArr = $publishedBo->getInfoById($article_id);

        return $this->render('@manage/views/manage/screen_shot_view.php', $infoArr);
    }

    public function actionWx()
    {
        //scope=snsapi_base 实例
        $appid = '你的AppId';
        $redirect_uri = urlencode('http://你的域名/getUserInfo.php');
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=$redirect_uri&response_type=code&scope=snsapi_base&state=1#wechat_redirect";
        header("Location:" . $url);
    }

    public function actionGetUserInfo()
    {
        $appid = "你的AppId";
        $secret = "你的AppSecret";
        $code = $_GET["code"];

//第一步:取全局access_token
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$secret";
        $token = $this->_getWxJson($url);

//第二步:取得openid
        $oauth2Url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$secret&code=$code&grant_type=authorization_code";
        $oauth2 = $this->_getWxJson($oauth2Url);

//第三步:根据全局access_token和openid查询用户信息
        $access_token = $token["access_token"];
        $openid = $oauth2['openid'];
        $get_user_info_url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid=$openid&lang=zh_CN";
        $userinfo = $this->_getWxJson($get_user_info_url);
    }

    private function _getWxJson($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        return json_decode($output, true);
    }


}