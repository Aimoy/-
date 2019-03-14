<?php
/**
 * Created by PhpStorm.
 * User: wanghaolin
 * Date: 2018/6/19
 * Time: 下午2:34
 */

namespace manage\models\send\dao;
use manage\models\BaseDao;
use yii\db\Query;


class Send extends BaseDao
{

    private $_column = 'id, title,creator,description,url,url_id,openids,type,send_num,send_time,publish_time,updated_at,created_at';


    public function init()
    {
        $this->column = $this->_column;
        parent::init();
    }


    public function sendAdd($title,$description,$creator,$url,$url_id,$openids,$type,$send_time,$publish_time)
    {
        $params = [];
        $params['title'] = $title;
        $params['creator'] = $creator;
        $params['description'] = $description;
        $params['url'] = $url;
        $params['url_id'] = $url_id;
        $params['openids'] = $openids;
        $params['type'] = $type;
        $params['send_time'] = $send_time;
        $params['publish_time'] = $publish_time;
        $result = $this->writeExecute('send.send.sql_insert_send',$params);
        if ($result > 0) {
            $result = $this->getInsertId();
        }
        return $result;
    }

    public function sendUpdate($id,$description,$title,$creator,$url,$url_id,$openids,$type,$send_time,$publish_time)
    {
        $params = [];
        $params['id'] = $id;
        $params['title'] = $title;
        $params['creator'] = $creator;
        $params['description'] = $description;
        $params['url'] = $url;
        $params['url_id'] = $url_id;
        $params['openids'] = $openids;
        $params['type'] = $type;
        $params['send_time'] = $send_time;
        $params['publish_time'] = $publish_time;
        $result = $this->writeExecute('send.send.sql_update_send',$params);
        return $result;
    }

    public function getSendDetail($id){
        $params = [];
        $params['id'] = $id;
        $result = $this->queryExecute('send.send.sql_get_send', $params)->queryOne();
        return $result;
    }

    public function updateSendNum($id,$send_num){
        $params = [];
        $params['id'] = $id;
        $params['send_num'] = $send_num;
        $result = $this->writeExecute('send.send.sql_update_send_num', $params);
        return $result;
    }

    public function getOpenidByUserId($user_id){
        $params = [];
        $params['user_id'] = $user_id;
        $result = $this->queryExecute('send.user.sql_get_by_user_id', $params)->queryOne();
        return $result;
    }

    public function getUserIdByOpenid($openid){
        $params = [];
        $params['openid'] = $openid;
        $result = $this->queryExecute('send.user.sql_get_by_openid', $params)->queryOne();
        return $result;
    }


    public function getAllList($title,$created_at,$page,$pageNum){

        $offset = ($page - 1) * $pageNum;
        $query = (new Query())->from('send_record')->orderBy(['id' => SORT_DESC])->offset($offset)->limit($pageNum);

        if($title && $created_at){
            $start = $created_at;
            $end = date('Y-m-d H:i:s',strtotime($created_at)+24*3600);
            $query->andWhere(['like','title',$title])->andWhere(['>=','created_at',$start])->andWhere(['<=','created_at',$end]);
        }elseif($title){
            $query->andWhere(['like','title',$title]);
        }elseif($created_at){
            $start = $created_at;
            $end = date('Y-m-d H:i:s',strtotime($created_at)+24*3600);
            $query->andWhere(['>=','created_at',$start])->andWhere(['<=','created_at',$end]);
        }
        $result['result'] = $query->all();
        $result['count'] = $query->count();

        return $result;
    }

    public function sendDelete($id){
        $params = [];
        $params['id'] = $id;
        $result = $this->writeExecute('send.send.sql_delete_send', $params);
        return $result;
    }

}