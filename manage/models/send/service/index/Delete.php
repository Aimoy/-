<?php
/**
 * Created by PhpStorm.
 * User: wanghaolin
 * Date: 2018/6/22
 * Time: 上午11:29
 */

namespace manage\models\send\service\index;

use manage\library\BizException;
use manage\library\Validation;

class Delete
{


    public function execute($data)
    {
        $valid = new Validation($data);
        $valid->add_rules('id','required','integer','gt:0');

        if (!$valid->validate()) {
            throw new BizException(BizException::PARAM_ERROR );
        }


        $indexBo = new \manage\models\send\bo\Index();
        $result = $indexBo->sendDelete($data['id']);
        if($result){
            return true;
        }
    }

}