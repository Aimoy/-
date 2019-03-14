<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/16
 * Time: 14:41
 */
namespace manage\models\statistics\service\comment;

use manage\library\BizException;
use manage\library\Validation;
use manage\models\statistics\bo\Comment;

class Search
{

    public function execute($data)
    {
        $valid = new Validation($data);
        $valid->add_rules('articleid','required');
        $valid->add_rules('start_day','required');
        $valid->add_rules('end_day','required');

        if (!$valid->validate()) {
            throw new BizException(BizException::PARAM_ERROR );
        }

        $static = new Comment();
        $start_day = strtotime(date('Y-m-d',strtotime($data['start_day'])));
        $end_day = strtotime(date('Y-m-d',strtotime($data['end_day'])));
        $result = $static->getCommentSearch($start_day,$end_day,$data['articleid']);
        $length = count($result);
        for ($x = 0; $x < $length; $x++) {
            $result[$x]['stat_at'] = date("Y-m-d ", $result[$x]['stat_at']);
            $article_id = $data['articleid'];
            $title_array = $static->getTitle($article_id);
            $result[$x]["title"] = $title_array["title"];
        }
        return $result;
    }

}