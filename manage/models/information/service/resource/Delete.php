<?php
/**
 * Created by PhpStorm.
 * User: charlie
 * Date: 2018/05/29
 * Time: 上午11:29
 */

namespace manage\models\information\service\resource;

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

        $resourceBo = new \manage\models\information\bo\Resource();
        $result = $resourceBo->deleteByIds($data['ids']);

        if ($result === false) {
            throw new BizException(BizException::INFO_DELETE_FAIL);
        }
        return $result;
    }

}