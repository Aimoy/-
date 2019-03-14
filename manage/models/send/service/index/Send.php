<?php
/**
 * Created by PhpStorm.
 * User: wanghaolin
 * Date: 2018/6/25
 * Time: 17:53
 */

namespace manage\models\send\service\index;

use manage\library\BizException;
use manage\library\Validation;

class Send
{


    public function execute($data)
    {
        $valid = new Validation($data);
        $valid->add_rules('id','required','integer','gt:0');


        if (!$valid->validate()) {
            throw new BizException(BizException::PARAM_ERROR );
        }

        $indexBo = new \manage\models\send\bo\Index();

        $send_detail = $indexBo->getSendDetail($data['id']);
        if(!$send_detail){
            throw new BizException(BizException::SEND_NOT_EXIST);
        }
        //已经推送过了，不能在推送
        if($send_detail['send_num'] >0 ){
            throw new BizException(BizException::SEND_FINISH_FAIL);
        }

        $result = $indexBo->sendNow($data['id']);
        if($result){
            //更新推送方式和时间
            $indexBo->sendUpdate($send_detail['id'],$send_detail['description'],$send_detail['title'],$send_detail['creator'],$send_detail['url'],$send_detail['url_id'],$send_detail['openids'],1,date('Y-m-d H:i:s'),$send_detail['publish_time']);
            return true;
        }
    }

}