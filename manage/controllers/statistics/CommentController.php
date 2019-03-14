<?php
/***************************************************************************
  *
  * Copyright (c) 2018 sunlands.com, Inc. All Rights Reserved
  *
  ***************************************************************************/



/**
  * file CommentController.php
  * author xiaoai (xiaoai@sunlands.com )
  * date 2018-07-15
  *
  **/
namespace manage\controllers\statistics;

class CommentController  extends \manage\controllers\MyController{
    /**
    * desc : 获取分栏目的日，周，月的发布评论pv，uv，人均评论
    */
    public function actionPost()
    {
        $param = [];
        $param["type"] = $this->get("type");// 统计时间类型 1 日,2周,3月
        $param["tag_id"] = $this->get("tag_id");// 栏目类型[0-9]

        return $this->_doFunction($param);
    }

    /**
    * desc : 获取分栏目的日，周，月的回复评论pv，uv
    */
    public function actionReply()
    {
        $param = [];
        $param["type"] = $this->get("type");// 统计时间类型 1 日,2周,3月
        $param["tag_id"] = $this->get("tag_id");// 栏目类型[0-9]

        return $this->_doFunction($param);
    }

    /**
    * desc : 获取分栏目的日，周，月的评论点赞的pv，uv
    */
    public function actionLike()
    {
        $param = [];
        $param["type"] = $this->get("type");// 统计时间类型 1 日,2周,3月
        $param["tag_id"] = $this->get("tag_id");// 栏目类型[0-9]

        return $this->_doFunction($param);
    }

    /**
    * desc : 获取按照事件类型，pv/uv进行排序的日榜/周榜/月榜
    */
    public function actionSort()
    {
        $param = [];
        $param["actiontype"] = $this->get("actiontype");// 操作事件类型（例：0：发起咨询事件，1：咨询未授权事件，2：咨询授权事件）
        $param["timetype"] = $this->get("timetype");// 排序时间 （例: 0:当日时间，1：周，2：月）
        $param["type"] = $this->get("type");// pv,uv排序类型（例：0：按照PV进行排行，1：按照uv进行排行）

        return $this->_doFunction($param);
    }

    /**
    * desc : 按照时间和文章ID进行查询
    */
    public function actionSearch()
    {
        $param = [];
        $param["articleid"] = $this->get("articleid");// 文章ID（例articleid：21341）
        $param["start_day"] = $this->get("start_day");// 查询的起始时间
        $param["end_day"] = $this->get("end_day");// 查询的结束时间

        return $this->_doFunction($param);
    }

    /**
    * desc : 获取分栏目的日，周，月的查看评论详情的pv，uv
    */
    public function actionDetail()
    {
        $param = [];
        $param["type"] = $this->get("type");// 统计时间类型 1 日,2周,3月
        $param["tag_id"] = $this->get("tag_id");// 栏目类型[0-9]

        return $this->_doFunction($param);
    }

}