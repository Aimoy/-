<?php
/**
 * Created by PhpStorm.
 * User: wanghaolin
 * Date: 2018/6/19
 * Time: 上午11:29
 */

namespace manage\models\send\service\index;

use manage\library\BizException;
use manage\library\Validation;

class Update
{


    public function execute($data)
    {
        $valid = new Validation($data);
        $valid->add_rules('id','required','integer','gt:0');
        $valid->add_rules('title','required','mb_length[1,255]');
        $valid->add_rules('description','required','mb_length[1,255]');
        $valid->add_rules('url','required','mb_length[1,255]');
        $valid->add_rules('url_id','required','integer');
        $valid->add_rules('type','required','in[1,2]');
        $valid->add_rules('publish_time','required');

        $data['creator'] = \Yii::$app->user->identity->realName;

        if($data['type']==1){
            $data['send_time'] = date('Y-m-d H:i:s');
        }else{
            $valid->add_rules('send_time','required');
        }

        if (!$valid->validate()) {
            throw new BizException(BizException::PARAM_ERROR );
        }

        $indexBo = new \manage\models\send\bo\Index();

        $send_detail = $indexBo->getSendDetail($data['id']);
        if(!$send_detail){
            throw new BizException(BizException::SEND_NOT_EXIST);
        }
        //已经推送过了，不能修改
        if($send_detail['send_num'] >0 ){
            throw new BizException(BizException::SEND_FINISH_FAIL);
        }
        //发送提交的时间不能比当前时间小
        if(strtotime($data['send_time'])< time()-30){
            throw new BizException(BizException::SEND_TIME_FAIL);
        }

        $result = $indexBo->sendUpdate($data['id'],$data['description'],$data['title'],$data['creator'],$data['url'],$data['url_id'],$data['openids'],$data['type'],$data['send_time'],$data['publish_time']);
        if($result){
            return true;
        }
    }

}