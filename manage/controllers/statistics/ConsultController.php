<?php
/***************************************************************************
  *
  * Copyright (c) 2018 sunlands.com, Inc. All Rights Reserved
  *
  ***************************************************************************/



/**
  * file ConsultController.php
  * author xiaoai (xiaoai@sunlands.com )
  * date 2018-07-11
  *
  **/
namespace manage\controllers\statistics;

class ConsultController  extends \manage\controllers\MyController{
    /**
    * desc : 获取发起咨询的当日，一周，一月的pv，uv
    */
    public function actionConsultgo()
    {
        $param = [];
        $param["type"] = $this->get("type");// 统计时间类型 1 日,2周,3月
        $param["tag_id"]=$this->get("tag_id"); //栏目类型
        return $this->_doFunction($param);
    }

    /**
    * desc : 获取按照事件类型，pv/uv进行排序的日榜/周榜/月榜
    */
    public function actionSort()
    {
        $param = [];
        $param["actiontype"] = $this->get("actiontype");// 操作事件类型（例：0：发起咨询事件，1：咨询未授权事件，2：咨询授权事件）
        $param["timetype"] = $this->get("timetype");//时间类型（例: 0:当日时间，1：周，2：月）("timeType",int);// Noo
        $param["type"] = $this->get("type");// pv,uv排序类型（例：0：按照PV进行排行，1：按照uv进行排行）

        return $this->_doFunction($param);
    }

    /**
    * desc : 咨询授权的pv，uv
    */
    public function actionConsultyes()
    {
        $param = [];
        $param["type"] = $this->get("type");// 统计时间类型 1 日,2周,3月
        $param["tag_id"]=$this->get("tag_id"); //栏目类型

        return $this->_doFunction($param);
    }

    /**
    * desc : 咨询未授权的pv，uv
    */
    public function actionConsultno()
    {
        $param = [];
        $param["type"] = $this->get("type");// 统计时间类型 1 日,2周,3月
        $param["tag_id"]=$this->get("tag_id"); //栏目类型

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
        $param["actiontype"] =$this->get("actiontype"); //被查询的事件
        return $this->_doFunction($param);
    }

}