<?php
/***************************************************************************
 *
 * Copyright (c) 2018 sunlands.com, Inc. All Rights Reserved
 *
 ***************************************************************************/



/**
 * file IndexController.php
 * author duanwei (duanwei@sunlands.com )
 * date 2018-05-24
 *
 **/
namespace manage\controllers\login;

class IndexController  extends \manage\controllers\MyController{
    /*
    * desc : 管理后台登录
    */
    public function actionIndex()
    {
        $param = [];
        $param["username"] = $this->post("username");// 用户名
        $param["password"] = $this->post("password");// 密码

        return $this->_doFunction($param);
    }

    /*
    * desc : 注销
    */
    public function actionLogout()
    {
        $param = [];

        return $this->_doFunction($param);
    }

}