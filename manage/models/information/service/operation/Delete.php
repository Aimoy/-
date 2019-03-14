<?php
/**
 * Created by PhpStorm.
 * User: charlie
 * Date: 2018/4/8
 * Time: 上午11:29
 */

namespace manage\models\information\service\operation;

use manage\library\BizException;
use manage\library\Validation;

class Delete
{


    public function execute($data)
    {
        $valid = new Validation($data);
        $valid->add_rules('ids', 'required');

        if (!$valid->validate()) {
            throw new BizException(0, $valid->getErrorMsg(), BizException::PARAM_ERROR);
        }

        $indexBo = new \manage\models\information\bo\Operation();
        $ids = explode(',', $data['ids']);
        $result = $indexBo->deleteInfoByIds($ids);
        if($result == 0) {
            throw new BizException(BizException::INFO_DELETE_FAIL);
        }
        return $result;
    }

}