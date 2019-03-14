<?php
/**
 * Created by PhpStorm.
 * User: charlie
 * Date: 2018/4/8
 * Time: 上午11:29
 */

namespace manage\models\interaction\service\agree;

use manage\library\BizException;
use manage\library\Validation;

class UpdateLike
{

    public function execute($data)
    {
        $valid = new Validation($data);
        $valid->add_rules('id','integer','required','gt:0');
        $valid->add_rules('type','integer','required');
        $valid->add_rules('num','integer','required','gt:0');
        if (!$valid->validate()) {
            throw new BizException(BizException::PARAM_ERROR );
        }

        $result = [];
        $reviewBo = new \manage\models\interaction\bo\Review();
        if($data['type'] == 1){         //文章
            $reviewBo->updateArticleLikeNum($data['id'],$data['num']);
        }elseif($data['type'] == 2){    //评论
            $reviewBo->updateCommentLikeNum($data['id'],$data['num']);
        }elseif ($data['type'] == 3){   //回复
            $reviewBo->updateReplyLikeNum($data['id'],$data['num']);
        }
        return $result;
    }

}