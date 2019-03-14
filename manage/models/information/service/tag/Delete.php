<?php
/**
 * Created by PhpStorm.
 * User: zhouqing
 * Date: 2018/4/8
 * Time: 上午11:29
 */

namespace manage\models\information\service\tag;

use manage\library\BizException;
use manage\library\Validation;
use manage\models\information\bo\Tag;

class Delete
{


    public function execute($data)
    {
        $valid = new Validation($data);
        $valid->add_rules('ids', 'required');
        if (!$valid->validate()) {
            throw new BizException(0, $valid->getErrorMsg(), BizException::PARAM_ERROR);
        }
        $tagBo = new Tag();

        return $tagBo->deleteTagTypeByIds($data['ids']);
    }

}