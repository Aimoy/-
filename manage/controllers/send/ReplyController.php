<?php
/***************************************************************************
 *
 * Copyright (c) 2018 sunlands.com, Inc. All Rights Reserved
 *
 ***************************************************************************/



/**
 * file ReplyController.php
 * author duanwei (duanwei@sunlands.com )
 * date 2018-06-20
 *
 **/
namespace manage\controllers\send;

class ReplyController  extends \manage\controllers\MyController{
    /**
     * desc : 回复推送列表
     */
    public function actionIndex()
    {
        $param = [];
        $param["title"] = $this->get("title",'');// title
        $param["page"] = $this->get("page");// page
        $param["pageSize"] = $this->get("pageSize");// pageSize

        return $this->_doFunction($param);
    }

}