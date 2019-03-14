<?php
/**
 * Created by PhpStorm.
 * User: wanghaolin
 * Date: 2018/6/19
 * Time: 15:59
 */

namespace manage\models\send\bo;


use manage\library\Cache;
use manage\library\QueueJob;
use manage\library\ConfigParse;
use manage\models\BaseBo;
use manage\models\send\dao\Send;

class Index extends BaseBo
{

    public function sendAdd($title,$description,$creator,$url,$url_id,$openids,$type,$send_time,$publish_time)
    {
        $result = (new Send())->sendAdd($title,$description,$creator,$url,$url_id,$openids,$type,$send_time,$publish_time);

        //入库成功后，并且是自动方式 则 写入延迟队列
        if($result && $type==2){
            $channel = ConfigParse::parseQueue('delayjob.send_task');
            $data = [
                'task_id'=>$result
            ];
            $delaytime = strtotime($send_time) - time();
            if($delaytime<0){
                $delaytime = 0;
            }
            $queen_id = QueueJob::add($channel['channel'], $data, $delaytime);
            $redis = new Cache();
            //将队列id和task_id关系存起来，用于修改和删除
            $redis->set('user.send.send_task',$result,$queen_id);
        }


        return $result;
    }

    public function sendUpdate($id,$description,$title,$creator,$url,$url_id,$openids,$type,$send_time,$publish_time)
    {
        $result = (new Send())->sendupdate($id,$description,$title,$creator,$url,$url_id,$openids,$type,$send_time,$publish_time);
        //更新推送时间
        if($result && $type==2){
            $redis = new Cache();
            $queen_id = $redis->get('user.send.send_task',$id);
            if($queen_id){
                $redis->del('user.send.send_task',$id);
                QueueJob::del($queen_id);
            }
            $channel = ConfigParse::parseQueue('delayjob.send_task');
            $data = [
                'task_id'=>$id
            ];
            $delaytime = strtotime($send_time) - time();
            if($delaytime<0){
                $delaytime = 0;
            }
            $queen_id = QueueJob::add($channel['channel'], $data, $delaytime);
            //将队列id和task_id关系存起来，用于修改和删除
            $redis->set('user.send.send_task',$id,$queen_id);

        }
        return $result;
    }

    public function getSendDetail($id)
    {
        return (new Send())->getSendDetail($id);
    }

    public function updateSendNum($id,$send_num)
    {
        return (new Send())->updateSendNum($id,$send_num);
    }

    public function getOpenidByUserId($user_id)
    {
        return (new Send())->getOpenidByUserId($user_id);
    }

    public function getUserIdByOpenid($openid)
    {
        return (new Send())->getUserIdByOpenid($openid);
    }


    public function getAllList($title,$created_at,$page,$pageNum)
    {
        return (new Send())->getAllList($title,$created_at,$page,$pageNum);
    }

    public function sendDelete($id)
    {
        $result = (new Send())->sendDelete($id);
        $redis = new Cache();
        $queen_id = $redis->get('user.send.send_task',$id);
        if($queen_id){
            $redis->del('user.send.send_task',$id);
            QueueJob::del($queen_id);
        }
        return $result;
    }

    //获取用户有效的formid
    public function getUserFormid($user_id){
        $cache = new \manage\library\Cache();
        while( $formid_key = $cache->rpop('user.user.user_formid_list',$user_id) ){
            $formid = $cache->get('user.user.user_formid',substr($formid_key,12));
            $cache->del('user.user.user_formid',substr($formid_key,12));//取出之后即可删除
            if($formid){
                return $formid;
            }
        }
        return false;
    }

    public function delTaskId($send_id){
        $cache = new \manage\library\Cache();
        $cache->del('user.send.send_task',$send_id);
    }

    public function scan($num,$arr){
        $cache = new \manage\library\Cache();
        $result = $cache->scan($num,$arr);
        return $result;
    }

    public function sendNow($id){
        $redis = new Cache();
        $queen_id = $redis->get('user.send.send_task',$id);
        if($queen_id){
            $redis->del('user.send.send_task',$id);
            QueueJob::del($queen_id);
        }
        $channel = ConfigParse::parseQueue('delayjob.send_task');
        $data = [
            'task_id'=>$id
        ];
        $delaytime = 0;
        $queen_id = QueueJob::add($channel['channel'], $data, $delaytime);
        $redis->set('user.send.send_task',$id,$queen_id);
        if($queen_id){
            return true;
        }
    }

}