<?php
/***************************************************************************
 *
 * Copyright (c) 2018 sunlands.com, Inc. All Rights Reserved
 *
 ***************************************************************************/



/**
 * file VersionController.php
 * author duanwei (duanwei@sunlands.com )
 * date 2018-06-20
 *
 **/
namespace manage\controllers\setting;

class VersionController  extends \manage\controllers\MyController{
    /**
     * desc : 版本列表
     */
    public function actionIndex()
    {
        $param = [];
        $param["page"] = $this->get("page");// page
        $param["pageSize"] = $this->get("pageSize");// pageSize

        return $this->_doFunction($param);
    }

    /**
     * desc : 版本列表
     */
    public function actionInfo()
    {
        $param = [];
        $param["id"] = $this->get("id");// id

        return $this->_doFunction($param);
    }

    /**
     * desc : 添加
     */
    public function actionAdd()
    {
        $param = [];
        $param["version"] = $this->post("version");// 版本号
        $param["status"] = $this->post("status");// 0未审核，1审核中
        $param["remark"] = $this->post("remark");// 备注

        return $this->_doFunction($param);
    }

    /**
     * desc : 更新
     */
    public function actionUpdate()
    {
        $param = [];
        $param["id"] = $this->post("id");// id
        $param["version"] = $this->post("version");// 版本号
        $param["status"] = $this->post("status");// 0未审核，1审核中
        $param["remark"] = $this->post("remark");// 备注

        return $this->_doFunction($param);
    }

    /**
     * desc : 删除
     */
    public function actionDelete()
    {
        $param = [];
        $param["ids"] = $this->post("ids");// ids

        return $this->_doFunction($param);
    }

}