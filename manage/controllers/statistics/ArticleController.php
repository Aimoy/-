<?php
/***************************************************************************
 *
 * Copyright (c) 2018 sunlands.com, Inc. All Rights Reserved
 *
 ***************************************************************************/



/**
 * file ArticleController.php
 * author wanghaolin (wanghaolin@sunlands.com )
 * date 2018-07-05
 *
 **/
namespace manage\controllers\statistics;

class ArticleController  extends \manage\controllers\MyController{
    /**
     * desc : 获取总pv,uv
     */
    public function actionSum()
    {
        $param = [];
        $param["start_day"] = $this->get("start_day");// 日期（例：2018-07-02）
        $param["end_day"] = $this->get("end_day");// 日期（例：2018-07-02）

        return $this->_doFunction($param);
    }

    /**
     * desc : 获取类别pv,uv
     */
    public function actionType()
    {
        $param = [];
        $param["start_day"] = $this->get("start_day");// 日期（例：2018-07-02）
        $param["end_day"] = $this->get("end_day");// 日期（例：2018-07-02）

        return $this->_doFunction($param);
    }

    /**
     * desc : 排行榜
     */
    public function actionSort()
    {
        $param = [];
        $param["type"] = $this->get("type");// 排序类型 1 pv 2 uv
        $param["timetype"] = $this->get("timetype");// 排序时间 1日榜 2周榜 3月榜
        $param["actiontype"] = $this->get("actiontype"); //事件类型
        return $this->_doFunction($param);
    }

    /**
     * desc : 文章点赞统计
     */
    public function actionLike()
    {
        $param = [];
        $param["type"] = $this->get("type");// 统计时间类型 1 日,2周,3月
        $param["tag_id"] = $this->get("tag_id"); //栏目id （例：1）

        return $this->_doFunction($param);
    }

    /**
     * desc : 文章分享统计
     */
    public function actionShare()
    {
        $param = [];
        $param["type"] = $this->get("type");// 统计时间类型 1 日,2周,3月
        $param["tag_id"] = $this->get("tag_id"); //栏目id （例：1）

        return $this->_doFunction($param);
    }

    /**
     * desc : 查询指定文章
     */
    public function actionSearch()
    {
        $param = [];
        $param["article_id"] = $this->get("article_id");// 文章id
        $param["start_day"] = $this->get("start_day");// 开始日期
        $param["end_day"] = $this->get("end_day");// 结束日期


        return $this->_doFunction($param);
    }

}