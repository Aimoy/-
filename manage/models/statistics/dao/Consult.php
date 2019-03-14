<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/11
 * Time: 15:26
 */
namespace manage\models\statistics\dao;

namespace manage\models\statistics\dao;

use manage\models\BaseDao;

class Consult extends BaseDao
{
//    function __construct(array $config = [])
//    {
//        parent::__construct($config);
//    }

    //咨询操作的总pv、vu
    public function getConsult($start_day, $end_day,$tag_id)
    {
        $params = [
            'start' => $start_day,
            'end' => $end_day,
            'tag_id' => $tag_id
        ];
        $result = $this->queryExecute('statistics.consult.get_consult_by_time', $params)->queryAll();
        return $result;
    }

    //按照事件以及时间获取排行榜数据
    public function get_consult_by_pv($start_day, $end_day)
    {
        $params = [
            'start' => $start_day,
            'end' => $end_day
        ];
        $result = $this->queryExecute('statistics.consult.get_sort_by_pv', $params)->queryAll();
        return $result;
    }

    public function get_consult_by_uv($start_day, $end_day)
    {
        $params = [
            'start' => $start_day,
            'end' => $end_day
        ];
        $result = $this->queryExecute('statistics.consult.get_sort_by_uv', $params)->queryAll();
        return $result;
    }

    public function get_consultyes_by_pv($start_day, $end_day)
    {
        $params = [
            'start' => $start_day,
            'end' => $end_day
        ];
        $result = $this->queryExecute('statistics.consult.get_yes_sort_by_pv', $params)->queryAll();
        return $result;
    }

    public function get_consultno_by_pv($start_day, $end_day)
    {
        $params = [
            'start' => $start_day,
            'end' => $end_day
        ];
        $result = $this->queryExecute('statistics.consult.get_no_sort_by_pv', $params)->queryAll();
        return $result;
    }

    public function get_title_by_article_id($article_id)
    {
        $params = [
            'id' => $article_id

        ];
//        echo $params["id"];die();
        $result = $this->queryExecute('statistics.consult.get_title_by_id', $params)->queryOne();
        return $result;
    }

    public function get_consultyes($start_day, $end_day,$tag_id)
    {
        $params = [
            'start' => $start_day,
            'end' => $end_day,
            'tag_id' => $tag_id
        ];
        $result = $this->queryExecute('statistics.consult.get_consultyes', $params)->queryAll();
//        var_dump($result);die();
        return $result;
    }
    public function get_consultno($start_day, $end_day,$tag_id)
    {
        $params = [
            'start' => $start_day,
            'end' => $end_day,'tag_id' => $tag_id
        ];
        $result = $this->queryExecute('statistics.consult.get_consultno', $params)->queryAll();
//        var_dump($result);die();
        return $result;
    }
    public function get_data_by_id_time($article_id,$start,$end)
    {
        $params = [
            'start' => $start,
            'end' => $end,
            'id'=>$article_id
        ];
        $result = $this->queryExecute('statistics.consult.get_data_by_article', $params)->queryAll();
//        var_dump($result);die()
        return $result;
    }
    public function get_data_by_auth($article_id,$start,$end)
    {
        $params = [
            'start' => $start,
            'end' => $end,
            'id'=>$article_id
        ];
        $result = $this->queryExecute('statistics.consult.get_data_by_auth', $params)->queryAll();
//        var_dump($result);die()
        return $result;
    }
    public function get_data_by_unauth($article_id,$start,$end)
    {
        $params = [
            'start' => $start,
            'end' => $end,
            'id'=>$article_id
        ];
        $result = $this->queryExecute('statistics.consult.get_data_by_unauth', $params)->queryAll();
//        var_dump($result);die()
        return $result;
    }
}