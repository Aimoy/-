<?php
/**
 * Created by PhpStorm.
 * User: duanwei
 * Date: 2018/6/20
 * Time: 上午11:50
 */

namespace manage\models\setting\service\version;

use manage\library\BizException;
use manage\library\Validation;

class Delete
{


    public function execute($data)
    {
        $valid = new Validation($data);
        $valid->add_rules('ids', 'required');
        if (!$valid->validate()) {
            throw new BizException(BizException::PARAM_ERROR);
        }

        $versionBo = new \manage\models\setting\bo\Version();
        return $versionBo->delete($data['ids']);
    }



}