<?php
/**
 * Created by PhpStorm.
 * User: charlie
 * Date: 2018/4/8
 * Time: 下午2:34
 */

namespace manage\models\interaction\dao;

use manage\models\BaseDao;

class Comment extends BaseDao
{
    protected  $_tableName = "comment";
    protected  $_column = 'id,content,user_id,nickname,thumb_img,article_id,like_num,reply_num,reply_ids,is_hidden,created_at,updated_at';

    public function init()
    {
        $this->column = $this->_column;
        parent::init();
    }

    public function getById($id)
    {
        $params = ['id' => $id];
        $result = $this->prepareSql('interaction.comment.sql_get_by_id', $params)->find();
        return $result;
    }

    public function create($userId,$articleId,$content,$nickname,$thumbImg)
    {
        $params = ['content' => $content,'user_id'=>$userId,'nickname'=>$nickname,'thumb_img'=>$thumbImg,'article_id'=>$articleId];
        $result = $this->insertReturnId($this->_tableName,$params);
        return $result;
    }

    public function updateReplyIds($id,$replyIds)
    {
        $params = ['id' => $id,'reply_ids'=>$replyIds,'updated_at'=>date("Y-m-d H:i:s")];
        $result = $this->writeExecute('interaction.comment.sql_update_reply_ids', $params);
        return $result;
    }

    public function updateReplyNum($id,$num)
    {
        $params = ['id' => $id,'reply_num'=>$num,'updated_at'=>date("Y-m-d H:i:s")];
        $result = $this->writeExecute('interaction.comment.sql_update_reply_num', $params);
        return $result;
    }

    public function updateLikeNum($id,$num)
    {
        $params = ['id' => $id,'like_num'=>$num,'updated_at'=>date("Y-m-d H:i:s")];
        $result = $this->writeExecute('interaction.comment.sql_update_like_num', $params);
        return $result;
    }

    public function updateHiddenInIds($ids,$isHidden)
    {
        $params = ['ids' => $ids,'is_hidden'=>$isHidden,'updated_at'=>date("Y-m-d H:i:s")];
        $result = $this->prepareSql('interaction.comment.sql_update_hidden_in_ids', $params)->executeWrite();
        return $result;
    }
}