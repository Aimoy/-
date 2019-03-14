<?php
/***************************************************************************
 *
 * Copyright (c) 2018 sunlands.com, Inc. All Rights Reserved
 *
 ***************************************************************************/



/**
 * file PublishController.php
 * author zhouqing (zhouqing@sunlands.com )
 * date 2018-05-25
 *
 **/
namespace manage\controllers\information;

class PublishController  extends \manage\controllers\MyController{
    /**
     * desc : 已发布文章列表
     */
    public function actionIndex()
    {
        $param = [];
        $param["page"] = $this->get("page", 1);// 文章id
        $param["pageNum"] = $this->get("pageNum", 10);// 文章id
        $param["source"] = $this->get("source");// 爬取文章来源
        $param["rangeType"] = $this->get("rangeType");// 1:一天,2:一周,3:一月,4:一年
        $param["typeId"] = $this->get("typeId");// 文章分类

        return $this->_doFunction($param);
    }

    /**
     * desc : 查看已发布文章详情
     */
    public function actionView()
    {
        $param = [];
        $param["id"] = $this->get("id");// 文章id

        return $this->_doFunction($param);
    }

    /**
     * desc : 已发布文章的来源列表
     */
    public function actionSourceList()
    {
        $param = [];

        return $this->_doFunction($param);
    }

    /**
     * desc : 已发布文章的来源列表(编辑的时候同时把文章设置成下架状态)
     */
    public function actionUpdate()
    {
        $param = [];
        $param["id"] = $this->post("id");// 文章ID
        $param["type_id"] = $this->post("type_id");// 文章分类ID
        $param["content_html"] = $this->post("content_html");// 文章正文
        $param["coverage"] = $this->post("coverage");// 文章封面uri/url,多张以逗号分隔
        $param["source"] = $this->post("source");// 文章来源
        $param["like_count"] = $this->post("like_count");// 点赞数量
        $param["comment_count"] = $this->post("comment_count");// 评论数量
        $param["read_count"] = $this->post("read_count");// 阅读数量
        $param["tag"] = $this->post("tag");// 文章标签名称,多个以逗号分隔,没有使用空字符串
        $param["display_type"] = $this->post("display_type");// 显示样式 1:无图 2:一张大图 3:左图右文 4:视频 5:三张图片
        $param["video_uri"] = $this->post("video_uri");// 视频的URI; display_type=4 必选
        $param["share_count"] = $this->post("share_count");// 分享数量
        $param["title"] = $this->post("title");// 文章数量
        $param["created_at"] = $this->post("created_at");// 时间eg:2018-09-11 11:11:23

        return $this->_doFunction($param);
    }

    /**
     * desc : 修改文章状态(发布/下架)
     */
    public function actionStatus()
    {
        $param = [];
        $param["id"] = $this->post("id");// 文章id
        $param["status"] = $this->post("status");// 文章状态:0:正常；1:删除；2:下架

        return $this->_doFunction($param);
    }

}