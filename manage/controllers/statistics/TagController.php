<?php
/***************************************************************************
  *
  * Copyright (c) 2018 sunlands.com, Inc. All Rights Reserved
  *
  ***************************************************************************/



/**
  * file TagController.php
  * author xiaoai (xiaoai@sunlands.com )
  * date 2018-07-10
  *
  **/
namespace manage\controllers\statistics;

class TagController  extends \manage\controllers\MyController{
    /**
    * desc : 获取每个栏目的当日，一周，一月的浏览pv，uv，人均时长
    */
    public function actionView()
    {
        $param = [];
        $param["tag_id"] = $this->get("tag_id",0);// 栏目id（0-9）默认0为推荐
        $param["type"] = $this->get("type");// 统计时间类型 1 日,2周,3月

        return $this->_doFunction($param);
    }

    /**
    * desc : 获取栏目的列表内容曝光uv，pv，人均曝光量
    */
    public function actionExposure()
    {
        $param = [];
        $param["tag_id"] = $this->get("tag_id",0);// 栏目id（0-9）默认0为推荐
        $param["type"] = $this->get("type");// 统计时间类型 1 日,2周,3月

        return $this->_doFunction($param);
    }

    /**
    * desc : 下拉刷新的pv，uv，人均下拉次数
    */
    public function actionDown()
    {
        $param = [];
        $param["tag_id"] = $this->get("tag_id",0);// 栏目id（0-9）默认0为推荐
        $param["type"] = $this->get("type");// 统计时间类型 1 日,2周,3月

        return $this->_doFunction($param);
    }

    /**
    * desc : 上拉刷新的pv，uv，人均上拉数次
    */
    public function actionUp()
    {
        $param = [];
        $param["tag_id"] = $this->get("tag_id",0);// 栏目id（0-9）默认0为推荐
        $param["type"] = $this->get("type");// 统计时间类型 1 日,2周,3月

        return $this->_doFunction($param);
    }

}