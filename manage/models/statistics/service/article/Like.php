<?php
/**
 * Created by PhpStorm.
 * User: wanghaolin
 * Date: 2018/7/2
 * Time: 上午11:29
 */

namespace manage\models\statistics\service\article;

use manage\library\BizException;
use manage\library\Validation;
use manage\models\statistics\bo\Article;

class Like
{

    public function execute($data)
    {
        $valid = new Validation($data);
        $valid->add_rules('type','required');
        $valid->add_rules('tag_id','required');
        if (!$valid->validate()) {
            throw new BizException(BizException::PARAM_ERROR );
        }

        $static = new Article();

        $result = $static->getLikeData($data['type'],$data['tag_id']);
        return $result;
    }

}