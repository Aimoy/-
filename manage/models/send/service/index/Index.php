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

class Index
{


    public function execute($data)
    {
        $valid = new Validation($data);
        $valid->add_rules('page','required','integer','gt:0');
        $valid->add_rules('pageNum','required','integer','gt:0');

        if (!$valid->validate()) {
            throw new BizException(BizException::PARAM_ERROR );
        }

        $result = ['count'=>0,'page'=>$data['page'],'pageNum'=>$data['pageNum'],'result'=>[]];
        $sendBo =  new \manage\models\send\bo\Index();

        $ret =  $sendBo->getAllList($data['title'],$data['created_at'],$data['page'],$data['pageNum']);
        $result['result'] = $ret['result'];
        $result['count'] = $ret['count'];

        return $result;
    }

}