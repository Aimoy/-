<?php
/***************************************************************************
 *
 * Copyright (c) 2018 sunlands.com, Inc. All Rights Reserved
 *
 ***************************************************************************/



/**
 * file ReviewController.php
 * author duanwei (duanwei@sunlands.com )
 * date 2018-05-23
 *
 **/
namespace manage\controllers\interaction;

class ReviewController  extends \manage\controllers\MyController{
    /*
    * desc : 警报回复列表
    */
    public function actionWarningList()
    {
        $param = [];
        $param["page"] = $this->get("page");// page
        $param["pageSize"] = $this->get("pageSize");// pageSize

        return $this->_doFunction($param);
    }

    /*
    * desc : 处理异常回复
    */
    public function actionHandleWarning()
    {
        $param = [];
        $param["arr"] = $this->post("arr");// 评论或者回复id,数组[['id':1,'type':2]]

        return $this->_doFunction($param);
    }

}