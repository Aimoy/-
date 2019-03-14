<?php
/***************************************************************************
 *
 * Copyright (c) 2018 sunlands.com, Inc. All Rights Reserved
 *
 ***************************************************************************/



/**
 * file IndexController.php
 * author wanghaolin (wanghaolin@sunlands.com )
 * date 2018-06-26
 *
 **/
namespace manage\controllers\send;

class IndexController  extends \manage\controllers\MyController{
    /**
     * desc : 新增推送
     */
    public function actionAdd()
    {
        $param = [];
        $param["title"] = $this->post("title");// 文章标题
        $param["description"] = $this->post("description");// 文章摘要
        $param["url"] = $this->post("url");// 推送链接
        $param["url_id"] = $this->post("url_id",'0');// 推送内容id
        $param["openids"] = $this->post("openids",'');// 指定推送的openid用逗号分隔
        $param["type"] = $this->post("type");// 推送方式 1手动 2自动
        $param["send_time"] = $this->post("send_time",'');// 发送时间
        $param["publish_time"] = $this->post("publish_time");// 发布时间

        return $this->_doFunction($param);
    }

    /**
     * desc : 修改推送
     */
    public function actionUpdate()
    {
        $param = [];
        $param["id"] = $this->post("id");// 消息id
        $param["title"] = $this->post("title");// 文章标题
        $param["description"] = $this->post("description");// 文章摘要
        $param["url"] = $this->post("url");// 推送链接
        $param["url_id"] = $this->post("url_id",'0');// 推送内容id
        $param["openids"] = $this->post("openids",'');// 指定推送的openid用逗号分隔
        $param["type"] = $this->post("type");// 推送方式 1手动 2自动
        $param["send_time"] = $this->post("send_time",'');// 发送时间
        $param["publish_time"] = $this->post("publish_time");// 发布时间

        return $this->_doFunction($param);
    }

    /**
     * desc : 推送列表
     */
    public function actionIndex()
    {
        $param = [];
        $param["page"] = $this->get("page");// 页数
        $param["pageNum"] = $this->get("pageNum");// 每页数量
        $param["created_at"] = $this->get("created_at",'');// 创建时间
        $param["title"] = $this->get("title",'');// 标题

        return $this->_doFunction($param);
    }

    /**
     * desc : 删除推送
     */
    public function actionDelete()
    {
        $param = [];
        $param["id"] = $this->post("id");// 消息id

        return $this->_doFunction($param);
    }

    /**
     * desc : 立即推送
     */
    public function actionSend()
    {
        $param = [];
        $param["id"] = $this->post("id");// 消息id

        return $this->_doFunction($param);
    }

    /**
     * desc : 推送详情
     */
    public function actionDetail()
    {
        $param = [];
        $param["id"] = $this->post("id");// 消息id

        return $this->_doFunction($param);
    }

}