<?php
/***************************************************************************
 *
 * Copyright (c) 2018 sunlands.com, Inc. All Rights Reserved
 *
 ***************************************************************************/



/**
 * file AgreeController.php
 * author duanwei (duanwei@sunlands.com )
 * date 2018-05-16
 *
 **/
namespace manage\controllers\interaction;

class AgreeController  extends \manage\controllers\MyController{
    /*
    * desc : 修改点赞数
    */
    public function actionUpdateLike()
    {
        $param = [];
        $param["id"] = $this->post("id");// 对象id
        $param["type"] = $this->post("type");// 1文章，2评论，3回复
        $param["num"] = $this->post("num");// 修改后的点赞数

        return $this->_doFunction($param);
    }

}