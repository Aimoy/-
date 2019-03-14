<?php
/**
 * Created by PhpStorm.
 * User: charlie
 * Date: 2018/4/8
 * Time: 下午2:34
 */

namespace manage\models\interaction\dao;

use manage\models\BaseDao;

class Reply extends BaseDao
{
    protected  $_tableName = "reply";
    protected  $_column = 'id,content,user_id,nickname,thumb_img,comment_id,like_num,reply_ids,is_hidden,created_at,updated_at';

    public function init()
    {
        $this->column = $this->_column;
        parent::init();
    }

    public function create($commentId,$userId,$content,$nickname,$thumbImg)
    {
        $params = ['comment_id'=>$commentId,'content' => $content,'user_id'=>$userId,'nickname'=>$nickname,'thumb_img'=>$thumbImg];
        $result = $this->insertReturnId($this->_tableName,$params);
        return $result;
    }

    public function getById($id)
    {
        $params = ['id' => $id];
        $result = $this->prepareSql('interaction.reply.sql_get_by_id', $params)->find();
        return $result;
    }

    public function updateReplyIds($id,$replyIds)
    {
        $params = ['id' => $id,'reply_ids'=>$replyIds,'updated_at'=>date("Y-m-d H:i:s")];
        $result = $this->writeExecute('interaction.reply.sql_update_reply_ids', $params);
        return $result;
    }

    public function updateLikeNum($id,$num)
    {
        $params = ['id' => $id,'like_num'=>$num,'updated_at'=>date("Y-m-d H:i:s")];
        $result = $this->writeExecute('interaction.reply.sql_update_like_num', $params);
        return $result;
    }

    public function getWarningList($page,$pageSize,$startDate,$endDate,$order="created_at desc")
    {
        $params = ['start_date'=>$startDate,'end_date'=>$endDate];
        $result = $this->prepareSql('interaction.reply.sql_get_warning_list', $params)->order($order)->paginate($page,$pageSize)->select();
        return $result;
    }

    public function getWarningListCount($startDate,$endDate)
    {
        $params = ['start_date'=>$startDate,'end_date'=>$endDate];
        $result = $this->prepareSql('interaction.reply.sql_get_warning_list_count', $params)->find();
        return $result['count'];
    }

    public function updateHiddenInIds($ids,$isHidden)
    {
        $params = ['ids' => $ids,'is_hidden'=>$isHidden,'updated_at'=>date("Y-m-d H:i:s")];
        $result = $this->prepareSql('interaction.reply.sql_update_hidden_in_ids', $params)->executeWrite();
        return $result;
    }

}