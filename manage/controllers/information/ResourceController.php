<?php
/***************************************************************************
 *
 * Copyright (c) 2018 sunlands.com, Inc. All Rights Reserved
 *
 ***************************************************************************/



/**
 * file ResourceController.php
 * author zhouqing (zhouqing@sunlands.com )
 * date 2018-05-30
 *
 **/
namespace manage\controllers\information;

class ResourceController  extends \manage\controllers\MyController{
    /**
     * desc : 抓取文章列表,`status:0:正常 1:已发布`
     */
    public function actionIndex()
    {
        $param = [];
        $param["page"] = $this->get("page");// 文章id
        $param["pageNum"] = $this->get("pageNum");// 文章id
        $param["source"] = $this->get("source", '');// 爬取文章来源
        $param["rangeType"] = $this->get("rangeType", '');// 1:一天,2:一周,3:一月 4:一年
        $param["typeId"] = $this->get("typeId", 0);// 文章分类ID

        return $this->_doFunction($param);
    }

    /**
     * desc : 查看抓取文章的详情
     */
    public function actionView()
    {
        $param = [];
        $param["id"] = $this->get("id");// 列表中_id字段

        return $this->_doFunction($param);
    }

    /**
     * desc : 抓取文章列表筛选来源下拉列表
     */
    public function actionSourceList()
    {
        $param = [];

        return $this->_doFunction($param);
    }

    /**
     * desc : 抓取文章详情编辑
     */
    public function actionUpdate()
    {
        $param = [];
        $param["_id"] = $this->post("_id");// 文章抓取_id
        $param["type_id"] = $this->post("type_id",1);// 文章类型ID
        $param["title"] = $this->post("title");// 文章标题
        $param["content"] = $this->post("content");// 文章正文
        $param["coverage"] = $this->post("coverage");// 多张图片以逗号分隔
        $param["tag"] = $this->post("tag");// 文章标签名称,多个以逗号分隔,没有使用空字符串
        $param["display_type"] = $this->post("display_type");// 文章展示样式 1:无图 2:一张大图 3:左图右文 4:视频 5:三张图片
        $param["video_uri"] = $this->post("video_uri");// 文章视频URI
        $param["source"] = $this->post("source");// 来源
        $param["created_at"] = $this->post("created_at");// 时间eg:2018-09-11 11:11:23

        return $this->_doFunction($param);
    }

    /**
     * desc : 抓取文章编辑之后再发布
     */
    public function actionPublish()
    {
        $param = [];
        $param["id"] = $this->post("id");// 文章_id

        return $this->_doFunction($param);
    }

    /**
     * desc : 抓取文章删除
     */
    public function actionDelete()
    {
        $param = [];
        $param["ids"] = $this->post("ids");// _id多个以英文逗号分隔

        return $this->_doFunction($param);
    }

    /**
     * desc : 抓取池标记文章编辑
     */
    public function actionMarkEdited()
    {
        $param = [];
        $param["id"] = $this->post("id");// 列表中返回的_id

        return $this->_doFunction($param);
    }


    public function actionPlayground()
    {
        return $this->_doFunction([]);
    }
}