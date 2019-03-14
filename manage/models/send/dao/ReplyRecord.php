<?php
/**
 * Created by PhpStorm.
 * User: duanwei
 * Date: 2018/6/20
 * Time: 下午3:47
 */

namespace manage\models\send\dao;

use manage\models\BaseDao;

class ReplyRecord extends BaseDao
{
    protected $_tableName = "send_record_reply";
    protected $_column = 'id,title,reply_time,created_at,updated_at';

    public function init()
    {
        $this->column = $this->_column;
        parent::init();
    }

    public function getTotal($title)
    {
        $result = $this->prepareSql('send.replyRecord.sql_get_total', [])
            ->where(['condition'=>$title ? "title like '%".$title."%'" : 1])
            ->find();
        return $result['count'];
    }

    public function getAllList($title,$page,$pageSize)
    {
        $result = $this->prepareSql('send.replyRecord.sql_get_send_record_reply_list', [])
            ->where(['condition'=>$title ? "title like '%".$title."%'" : 1])
            ->paginate($page,$pageSize)->select();
        return $result;
    }

}