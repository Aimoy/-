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

class Search
{

    public function execute($data)
    {
        $valid = new Validation($data);
        $valid->add_rules('article_id','required');
        $valid->add_rules('start_day','required');
        $valid->add_rules('end_day','required');

        if (!$valid->validate()) {
            throw new BizException(BizException::PARAM_ERROR );
        }

        $static = new Article();
        $start_day = strtotime(date('Y-m-d',strtotime($data['start_day'])));
        $end_day = strtotime(date('Y-m-d',strtotime($data['end_day'])));
        $result = $static->getDetailData($start_day,$end_day,$data['article_id']);
        return $result;
    }

}