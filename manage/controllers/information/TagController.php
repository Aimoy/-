<?php
/***************************************************************************
 *
 * Copyright (c) 2018 sunlands.com, Inc. All Rights Reserved
 *
 ***************************************************************************/



/**
 * file TagController.php
 * author zhouqing (zhouqing@sunlands.com )
 * date 2018-06-05
 *
 **/
namespace manage\controllers\information;

class TagController  extends \manage\controllers\MyController{
    /**
     * desc : 获取文章的tag
     */
    public function actionIndex()
    {
        $param = [];

        return $this->_doFunction($param);
    }

    /**

     * desc : 获取文章的tag
     */
    public function actionV2Index()
    {
        $param = [];
        $param["type_id"] = $this->get("type_id",0);// 分类ID,默认显示全部tag

        return $this->_doFunction($param);
    }

    /**
     * desc : 标签管理分页列表
     */
    public function actionPagination()
    {
        $param = [];
        $param["tag_name"] = $this->get("tag_name");// 标签名称
        $param["type_id"] = $this->get("type_id");// 分类ID
        $param["is_default"] = $this->get("is_default");// 1:默认显示 0:不显示
        $param["page"] = $this->get("page",1);// 页码
        $param["pageNum"] = $this->get("pageNum",10);// 每页显示数量

        return $this->_doFunction($param);
    }

    /**
     * desc : 标签详情
     */
    public function actionView()
    {
        $param = [];
        $param["id"] = $this->get("id");// 标签ID

        return $this->_doFunction($param);
    }

    /**

     * desc : 标签编辑
     */
    public function actionUpdate()
    {
        $param = [];
        $param["id"] = $this->post("id");// 标签ID

        $param["remark"] = $this->post("remark",'');// 备注
        $param["is_default"] = $this->post("is_default",1);// 是否默认显示 1:是 0:否
        $param["type_id"] = $this->post("type_id");// 分类ID
        $param["tag_name"] = $this->post("tag_name");// 标签名称

        return $this->_doFunction($param);
    }

    /**
     * desc : 标签创建
     */
    public function actionAdd()
    {
        $param = [];
        $param["tag_name"] = $this->post("tag_name");// 标签名称
        $param["remark"] = $this->post("remark");// 标签名称

        $param["type_json"] = $this->post("type_json");// json示例:{"1":0,"4":1},分类ID为1不是默认,标签ID4是默认

        return $this->_doFunction($param);
    }

    /**
     * desc : 标签删除
     */
    public function actionDelete()
    {
        $param = [];
        $param["ids"] = $this->post("ids");// 标签ID,多个以英文分隔

        return $this->_doFunction($param);
    }

}