<?php
/**
 * Created by PhpStorm.
 * User: duanwei
 * Date: 2018/6/20
 * Time: 下午3:38
 */

namespace manage\models\send\service\reply;

use manage\library\BizException;

use manage\library\Validation;

class Index
{
    public function execute($data)
    {
        $valid = new Validation($data);

        if (!$valid->validate()) {
            throw new BizException(BizException::PARAM_ERROR);
        }
        $result = ['count'=>0,'page'=>$data['page'],'pageSize'=>$data['pageSize'],'list'=>[]];
        $replySendBo =  new \manage\models\send\bo\ReplyRecord();
        $result['count'] = $replySendBo->getTotal($data['title']);
        if($result['count']>0){
            $result['list'] =  $replySendBo->getAllList($data['title'],$data['page'],$data['pageSize']);
        }
        return $result;

    }

}