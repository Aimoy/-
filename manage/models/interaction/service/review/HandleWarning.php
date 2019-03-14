<?php
/**
 * Created by PhpStorm.
 * User: charlie
 * Date: 2018/4/8
 * Time: 上午11:29
 */

namespace manage\models\interaction\service\review;

use manage\library\BizException;
use manage\library\Validation;

class HandleWarning
{

    public function execute($data)
    {
        $valid = new Validation($data);
        $valid->add_rules('arr','required');
        if (!$valid->validate()) {
            throw new BizException(BizException::PARAM_ERROR );
        }
        //$data['arr'] = json_decode($data['arr'],true);

        $ids1 = $data['arr'] ? array_values(array_filter(array_map(function($v){if($v['type']==1){return $v['id'];}},$data['arr']))) : [];
        $ids2 = $data['arr'] ? array_values(array_filter(array_map(function($v){if($v['type']==2){return $v['id'];}},$data['arr']))) : [];
        $reviewBo = new \manage\models\interaction\bo\Review();
        if($ids1){         //1异常评论
            $reviewBo->updateCommentHiddenInIds($ids1,0);
        }
        if($ids2){    //2异常回复
            $reviewBo->updateReplyHiddenInIds($ids2,0);
        }
        return true;
    }

}