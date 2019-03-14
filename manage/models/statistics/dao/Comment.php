<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/16
 * Time: 0:43
 */
namespace manage\models\statistics\dao;

namespace manage\models\statistics\dao;

use manage\models\BaseDao;

class Comment extends BaseDao
{
//    function __construct(array $config = [])
//    {
//        parent::__construct($config);
//    }

    //咨询操作的总pv、vu
    public function getPost($start_day, $end_day, $tag_id)
    {
        $params = [
            'start' => $start_day,
            'end' => $end_day,
            'tag_id' => $tag_id
        ];
        $result = $this->queryExecute('statistics.comment.get_post', $params)->queryAll();
        return $result;
    }

    public function getLike($start_day, $end_day, $tag_id)
    {
        $params = [
            'start' => $start_day,
            'end' => $end_day,
            'tag_id' => $tag_id
        ];
        $result = $this->queryExecute('statistics.comment.get_like', $params)->queryAll();
        return $result;
    }

    public function getDetail($start_day, $end_day, $tag_id)
    {
        $params = [
            'start' => $start_day,
            'end' => $end_day,
            'tag_id' => $tag_id
        ];
        $result = $this->queryExecute('statistics.comment.get_detail', $params)->queryAll();
        return $result;
    }

    //按照事件以及时间获取排行榜数据
    public function get_post_by_pv($start_day, $end_day)
    {
        $params = [
            'start' => $start_day,
            'end' => $end_day
        ];
        $result = $this->queryExecute('statistics.comment.get_post_by_pv', $params)->queryAll();
        return $result;
    }

    public function get_post_by_uv($start_day, $end_day)
    {
        $params = [
            'start' => $start_day,
            'end' => $end_day
        ];
        $result = $this->queryExecute('statistics.comment.get_post_by_uv', $params)->queryAll();
        return $result;
    }

    public function get_like_by_pv($start_day, $end_day)
    {
        $params = [
            'start' => $start_day,
            'end' => $end_day
        ];
        $result = $this->queryExecute('statistics.comment.get_like_sort_by_pv', $params)->queryAll();
        return $result;
    }


    public function get_like_by_uv($start_day, $end_day)
    {
        $params = [
            'start' => $start_day,
            'end' => $end_day
        ];
        $result = $this->queryExecute('statistics.comment.get_like_sort_by_uv', $params)->queryAll();
        return $result;
    }


    public function get_title_by_article_id($article_id)
    {
        $params = [
            'id' => $article_id

        ];
//        echo $params["id"];die();
        $result = $this->queryExecute('statistics.comment.get_title_by_id', $params)->queryOne();
        return $result;
    }

    public function getReply($start_day, $end_day, $tag_id)
    {
        $params = [
            'start' => $start_day,
            'end' => $end_day,
            'tag_id' => $tag_id
        ];
        $result = $this->queryExecute('statistics.comment.get_reply', $params)->queryAll();
//        var_dump($result);die();
        return $result;
    }

    public function get_data_by_id_time($article_id, $start, $end)
    {
        $params = [
            'start' => $start,
            'end' => $end,
            'id' => $article_id
        ];
        $result = $this->queryExecute('statistics.comment.get_data_by_article', $params)->queryAll();
//        var_dump($result);die();
        return $result;
    }

    public function getDetailData($start,$end,$article_id)
    {
        $params = [
            'start'=>$start,
            'end'=>$end,
            'article_id'=>$article_id,
        ];
        $result = $this->queryExecute('statistics.comment.get_detail_by_day', $params)->queryAll();
        return $result;

    }
}