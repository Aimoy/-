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

class Add
{


    public function execute($data)
    {
        $valid = new Validation($data);
        $valid->add_rules('version', 'required','length[0,255]');
        $valid->add_rules('status', 'required', 'length[0,64]');
        $valid->add_rules('remark', 'mb_length[0,128]');
        if (!$valid->validate()) {
            throw new BizException(BizException::PARAM_ERROR);
        }

        $versionBo = new \manage\models\setting\bo\Version();
        if($versionBo->existByVersion($data['version'])){
            throw new BizException(BizException::VERSION_CONFLICT);
        }
        $recordId = $versionBo->add($data['version'],$data['status'],$data['remark']);
        if($recordId){
            return $versionBo->getById($recordId);
        }
        throw new BizException(BizException::VERSION_CREATE_FAIL);


    }



}