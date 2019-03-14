<?php
/**
 * Created by PhpStorm.
 * User: wanghaolin
 * Date: 2018/7/2
 * Time: 下午2:34
 */

namespace manage\models\statistics\dao;

use manage\models\BaseDao;

class Article extends BaseDao
{
    //总pv、vu
    public function getSum($start,$end)
    {
        $params = [
            'start'=>$start,
            'end'=>$end,

        ];
        $result = $this->queryExecute('statistics.article.get_sum_by_day', $params)->queryOne();
        return $result;
    }
    //分类pv、vu
    public function getTypeData($start,$end)
    {
        $params = [
            'start'=>$start,
            'end'=>$end
        ];
        $result = $this->queryExecute('statistics.article.get_type_by_day', $params)->queryAll();
        return $result;
    }
    //文章pv日排行
    public function getSortPvDay($day)
    {
        $params = [
            'day'=>$day
        ];
        $result = $this->queryExecute('statistics.article.get_sort_pv_by_day', $params)->queryAll();
        return $result;
    }
    //文章pv周排行
    public function getSortPvWeek($start,$end)
    {
        $params = [
            'start'=>$start,
            'end'=>$end,
        ];
        $result = $this->queryExecute('statistics.article.get_sort_pv_by_week', $params)->queryAll();
        return $result;
    }
    //文章pv月排行
    public function getSortPvMonth($start,$end)
    {
        $params = [
            'start'=>$start,
            'end'=>$end,
        ];
        $result = $this->queryExecute('statistics.article.get_sort_pv_by_month', $params)->queryAll();
        return $result;
    }
    //文章uv日排行
    public function getSortUvDay($day)
    {
        $params = [
            'day'=>$day
        ];
        $result = $this->queryExecute('statistics.article.get_sort_uv_by_day', $params)->queryAll();
        return $result;
    }
    //文章uv周排行
    public function getSortUvWeek($start,$end)
    {
        $params = [
            'start'=>$start,
            'end'=>$end,
        ];
        $result = $this->queryExecute('statistics.article.get_sort_uv_by_week', $params)->queryAll();
        return $result;
    }
    //文章uv月排行
    public function getSortUvMonth($start,$end)
    {
        $params = [
            'start'=>$start,
            'end'=>$end,
        ];
        $result = $this->queryExecute('statistics.article.get_sort_uv_by_month', $params)->queryAll();
        return $result;
    }
    //分享pv、vu
    public function getShareData($day,$tag_id)
    {
        $params = [
            'day'=>$day,
            'tag_id'=>$tag_id
        ];
        $result = $this->queryExecute('statistics.article.get_share_by_day', $params)->queryAll();
        return $result;
    }
    //分享pv、vu历史
    public function getShareHistoryData($start,$end,$tag_id)
    {
        $params = [
            'start'=>$start,
            'end'=>$end,
            'tag_id'=>$tag_id
        ];
        $result = $this->queryExecute('statistics.article.get_share_by_history', $params)->queryAll();
        return $result;
    }
    //点赞pv、vu
    public function getLikeData($day,$tag_id)
    {
        $params = [
            'day'=>$day,
            'tag_id'=>$tag_id
        ];
        $result = $this->queryExecute('statistics.article.get_like_by_day', $params)->queryAll();
        var_dump($result);die();
        return $result;
    }
    //点赞pv、vu历史
    public function getLikeHistoryData($start,$end,$tag_id)
    {
        $params = [
            'start'=>$start,
            'end'=>$end,
            'tag_id'=>$tag_id
        ];
        $result = $this->queryExecute('statistics.article.get_like_by_history', $params)->queryAll();
        return $result;
    }
    //指定文章
    public function getDetailData($start,$end,$article_id)
    {
        $params = [
            'start'=>$start,
            'end'=>$end,
            'article_id'=>$article_id,
        ];
        $result = $this->queryExecute('statistics.article.get_detail_by_day', $params)->queryAll();
        return $result;

    }
    public function get_viewsort_by_pv($start,$end)
    {
        $params = [
            'start'=>$start,
            'end'=>$end,
        ];
        $result = $this->queryExecute('statistics.article.get_viewsort_by_pv', $params)->queryAll();
        return $result;
    }
    public function get_viewsort_by_uv($start,$end)
    {
        $params = [
            'start'=>$start,
            'end'=>$end,
        ];
        $result = $this->queryExecute('statistics.article.get_viewsort_by_uv', $params)->queryAll();
        return $result;
    }
    public function get_sharesort_by_pv($start,$end)
    {
        $params = [
            'start'=>$start,
            'end'=>$end,
        ];
        $result = $this->queryExecute('statistics.article.get_sharesort_by_pv', $params)->queryAll();
        return $result;
    }
    public function get_sharesort_by_uv($start,$end)
    {
        $params = [
            'start'=>$start,
            'end'=>$end,
        ];
        $result = $this->queryExecute('statistics.article.get_sharesort_by_uv', $params)->queryAll();
        return $result;
    }
    public function get_likesort_by_pv($start,$end)
    {
        $params = [
            'start'=>$start,
            'end'=>$end,
        ];
        $result = $this->queryExecute('statistics.article.get_likesort_by_pv', $params)->queryAll();
        return $result;
    }
    public function get_likesort_by_uv($start,$end)
    {
        $params = [
            'start'=>$start,
            'end'=>$end,
        ];
        $result = $this->queryExecute('statistics.article.get_viewsort_by_uv', $params)->queryAll();
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
}