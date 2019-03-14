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

class Index
{


    public function execute($data)
    {
        $valid = new Validation($data);
        $valid->add_rules('page', 'required','integer', 'gt:0');
        $valid->add_rules('pageSize', 'required','integer', 'egt:1');
        if (!$valid->validate()) {
            throw new BizException(BizException::PARAM_ERROR);
        }
        $result = ['count'=>0,'page'=>$data['page'],'pageSize'=>$data['pageSize'],'list'=>[]];

        $versionBo = new \manage\models\setting\bo\Version();
        $result['count'] = $versionBo->getTotal();
        if($result['count']>0){
            $result['list'] =  $versionBo->getAllList($data['page'],$data['pageSize']);
        }
        return $result;
    }



}