<?php
/***************************************************************************
  *
  * Copyright (c) 2018 sunlands.com, Inc. All Rights Reserved
  *
  ***************************************************************************/



/**
  * file TypeController.php
 * author zhouqing (zhouqing@sunlands.com )
 * date 2018-05-25
  *
  **/
namespace manage\controllers\information;

class TypeController  extends \manage\controllers\MyController{
    /**
     * desc : 获取type列表
    */
    public function actionIndex()
    {
        $param = [];

        return $this->_doFunction($param);
    }

}