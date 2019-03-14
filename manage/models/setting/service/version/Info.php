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

class Info
{


    public function execute($data)
    {
        $valid = new Validation($data);
        $valid->add_rules('id', 'required', 'integer', 'egt:1');
        if (!$valid->validate()) {
            throw new BizException(BizException::PARAM_ERROR);
        }

        $versionBo = new \manage\models\setting\bo\Version();
        $record = $versionBo->getById($data['id']);
        if($record){
            return $record;
        }
        throw new BizException(BizException::VERSION_NOT_EXISTS);

    }



}