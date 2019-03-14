<?php
/***************************************************************************
 *
 * Copyright (c) 2018 sunlands.com, Inc. All Rights Reserved
 *
 ***************************************************************************/


/**
 * file IndexController.php
 * author zhouqing (zhouqing@sunlands.com )
 * date 2018-06-19
 *
 **/

namespace manage\controllers\screenshot;

use manage\models\information\bo\Publish;

class IndexController extends \manage\controllers\MyController
{

    public $layout = false;

    /**
     * 废弃
     * desc : 微信小程序截图
     */
//    public function actionShot()
//    {
//        $param = [];
//        $param["page"] = $this->get("page");// 必须是已经发布的小程序存在的页面（否则报错），例如 "pages/index/index" ,根路径前不要填加'/',不能携带参数（参数请放在scene字段里），如果不填写这个字段，默认跳主页面
//        $param["article_id"] = $this->get("article_id");//文章ID
//        $param["post_id"] = $this->get("post_id");//帖子ID
//        return $this->_doFunction($param);
//    }

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


    /**
     * desc : 获取微信小程序对应page的二维码
     */
//    public function actionQr()
//    {
//        $param = [];
//        $param["article_id"] = $this->get("article_id");//文章ID
//        $param["user_id"] = $this->get("user_id");//用户ID
//        $param["post_id"] = $this->get("post_id");//帖子ID
//        $param["page"] = $this->get("page");// 必须是已经发布的小程序存在的页面（否则报错），例如 "pages/index/index" ,根路径前不要填加'/',不能携带参数（参数请放在scene字段里），如果不填写这个字段，默认跳主页面
//        $param["width"] = $this->get("width");// 二维码宽度
//
//        return $this->_doFunction($param);
//    }

}