<?php
/***************************************************************************
 *
 * Copyright (c) 2018 sunlands.com, Inc. All Rights Reserved
 *
 ***************************************************************************/



/**
 * file OperationController.php
 * author zhouqing (zhouqing@sunlands.com )
 * date 2018-05-25
 *
 **/
namespace manage\controllers\information;

class OperationController extends \manage\controllers\MyController
{
    /**
     * desc : 获取运营文章列表列表
     */
    public function actionIndex()
    {
        $param = [];
        $param["source"] = $this->get("source");// 运营来源
        $param["rangeType"] = $this->get("rangeType");// 时间范围 1:一天,2:一周,3:一月 4:一年
        $param["typeId"] = $this->get("typeId");// 分类ID
        $param["page"] = $this->get("page", 1);// 页码
        $param["pageNum"] = $this->get("pageNum", 10);// 每页显示数量

        return $this->_doFunction($param);
    }

    /**
     * desc : 获取运营文章来源(部门)的列表
     */
    public function actionSourceList()
    {
        $param = [];

        return $this->_doFunction($param);
    }

    /**
     * desc : 获取运营文章创建
     */
    public function actionAdd()
    {
        $param = [];
        $param["type_id"] = $this->post("type_id");// 文章分类ID
        $param["title"] = $this->post("title");// 文章标题
        $param["content_html"] = $this->post("content_html");// 文章正文
        $param["video_uri"] = $this->post("video_uri");// 视频URI
        $param["coverage"] = $this->post("coverage");// 文章封面uri/url,多张以逗号分隔
        $param["origin_link"] = $this->post("origin_link", '');// 原始地址
        $param["source"] = $this->post("source");// 来源(尚德部门)
        $param["tag"] = $this->post("tag");// 文章标签名称,多个以逗号分隔,没有使用空字符串
        $param["display_type"] = $this->post("display_type");// 显示样式 1:无图 2:一张大图 3:左图右文 4:视频 5:三张图片

        return $this->_doFunction($param);
    }

    /**
     * desc : 运营文章编辑
     */
    public function actionUpdate()
    {
        $param = [];
        $param["id"] = $this->post("id");// 运营池文章ID
        $param["type_id"] = $this->post("type_id");// 文章分类ID
        $param["title"] = $this->post("title");// 文章标题
        $param["content_html"] = $this->post("content_html");// 文章正文
        $param["video_uri"] = $this->post("video_uri", '');// 视频URI
        $param["coverage"] = $this->post("coverage");// 文章封面uri/url,多张以逗号分隔
        $param["origin_link"] = $this->post("origin_link", '');// 文章原始地址
        $param["source"] = $this->post("source");// 来源(尚德部门)
        $param["tag"] = $this->post("tag");// 文章标签名称,多个以逗号分隔,没有使用空字符串
        $param["display_type"] = $this->post("display_type");// 显示样式 1:无图 2:一张大图 3:左图右文 4:视频 5:三张图片
        $param["created_at"] = $this->post("created_at");// 时间eg:2018-09-11 11:11:23

        return $this->_doFunction($param);
    }

    /**
     * desc : 获取运营文章详情
     */
    public function actionView()
    {
        $param = [];
        $param["id"] = $this->get("id");// 运营文章ID

        return $this->_doFunction($param);
    }

    /**
     * desc : 运营文章发布
     */
    public function actionPublish()
    {
        $param = [];
        $param["id"] = $this->post("id");// 运营池文章ID

        return $this->_doFunction($param);
    }

    /**
     * desc : 运营文章发布软删除(批量)
     */
    public function actionDelete()
    {
        $param = [];
        $param["ids"] = $this->post("ids");// 运营池文章ID,多个以英文逗号分隔

        return $this->_doFunction($param);
    }

}