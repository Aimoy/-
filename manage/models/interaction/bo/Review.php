<?php
/**
 * Created by PhpStorm.
 * User: charlie
 * Date: 2018/4/8
 * Time: 下午2:03
 */

namespace manage\models\interaction\bo;

use manage\models\BaseBo;
use manage\models\interaction\dao\Reply as ReplyDao;
use manage\models\interaction\dao\Comment as CommentDao;

class Review extends BaseBo
{

    protected $commentDao;
    protected $replyDao;

    public function __construct()
    {
        $this->replyDao = new ReplyDao();
        $this->commentDao = new CommentDao();
    }

    public function getWarningList($page,$pageSize,$startDate,$endDate)
    {
        return $this->replyDao->getWarningList($page,$pageSize,$startDate,$endDate,"created_at desc");
    }

    public function getWarningListCount($startDate,$endDate)
    {
        return $this->replyDao->getWarningListCount($startDate,$endDate);
    }

    public function updateCommentHiddenInIds($ids,$isHidden)
    {
        return $this->commentDao->updateHiddenInIds($ids,$isHidden);
    }

    public function updateReplyHiddenInIds($ids,$isHidden)
    {
        return $this->replyDao->updateHiddenInIds($ids,$isHidden);
    }

    public function updateArticleLikeNum($id,$num)
    {
        $info = new \manage\models\information\dao\InfoPublish();
        return $info->updateLikeCount($id,$num);
    }

    public function updateCommentLikeNum($id,$num)
    {
        return $this->commentDao->updateLikeNum($id,$num);
    }

    public function updateReplyLikeNum($id,$num)
    {
        return $this->replyDao->updateLikeNum($id,$num);
    }

}