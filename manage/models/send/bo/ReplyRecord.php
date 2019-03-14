<?php
/**
 * Created by PhpStorm.
 * User: charlie
 * Date: 2018/4/8
 * Time: 下午2:03
 */

namespace manage\models\send\bo;


use manage\models\BaseBo;
use manage\models\send\dao\ReplyRecord as ReplyRecordDao;

class ReplyRecord extends BaseBo
{

    private $replyRecordDao;

    public function __construct()
    {
        $this->replyRecordDao = new ReplyRecordDao();
    }

    public function getTotal($title)
    {
        return $this->replyRecordDao->getTotal($title);
    }

    public function getAllList($title,$page,$pageSize)
    {
        return $this->replyRecordDao->getAllList($title,$page,$pageSize);
    }




}