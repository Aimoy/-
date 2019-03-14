<?php
/**
 * Created by PhpStorm.
 * User: wanghaolin
 * Date: 2018/7/2
 * Time: 下午2:03
 */

namespace manage\models\statistics\bo;


use manage\models\BaseBo;

class Article extends BaseBo
{

    public function getSum($start,$end)
    {
        $article = new \manage\models\statistics\dao\Article();
        $result = $article->getSum($start,$end);
        return $result;
    }
    public function getTime($timeType)
    {
        $timeArray = [];
        switch ($timeType) {
            case 1:
                //把时间转换成时间戳
                $timeArray["start_day"] = strtotime(date('Y-m-d', strtotime(time())));
                $timeArray["end_day"] = strtotime(date("Y-m-d", strtotime(time())));
                break;
            case 2:
                $timeArray["end_day"] = strtotime(date('Y-m-d')) + 24 * 3600;
                $timeArray["start_day"] = $timeArray["end_day"] - 7 * 24 * 3600;
                break;
            case 3:
                $timeArray["end_day"] = strtotime(date('Y-m-d')) + 24 * 3600;
                $timeArray["start_day"] = $timeArray["end_day"] - 30 * 24 * 3600;
                break;
        }
        return $timeArray;
    }

    public function getSortData($type,$timeType)
            {
                $article = new \manage\models\statistics\dao\Article();
                $result = [];
                if($type==1){
                    switch ($timeType){
                        case 1:
                            $day = strtotime(date('Y-m-d'));
                            $result = $article->getSortPvDay($day);
                            break;
                        case 2:
                            $end = strtotime(date('Y-m-d'))+24*3600;
                            $start = $end - 7*24*3600;
                            $result = $article->getSortPvWeek($start,$end);
                            break;
                        case 3:
                            $end = strtotime(date('Y-m-d'))+24*3600;
                            $start = $end - 30*24*3600;
                            $result = $article->getSortPvMonth($start,$end);
                            break;
                    }
        }else{
            switch ($timeType){
                case 1:
                    $day = strtotime(date('Y-m-d'));
                    $result = $article->getSortUvDay($day);
                    break;
                case 2:
                    $end = strtotime(date('Y-m-d'))+24*3600;
                    $start = $end - 7*24*3600;
                    $result = $article->getSortUvWeek($start,$end);
                    break;
                case 3:
                    $end = strtotime(date('Y-m-d'))+24*3600;
                    $start = $end - 30*24*3600;
                    $result = $article->getSortUvMonth($start,$end);
                    break;
            }
        }

        return $result;
    }

    public function getTypeData($start,$end)
    {
        $article = new \manage\models\statistics\dao\Article();
        $result = $article->getTypeData($start,$end);
        return $result;
    }

    public function getShareData($type,$tag_id)
    {
        $article = new \manage\models\statistics\dao\Article();
        $result = [];
        switch ($type){
            case 1:
                $day = strtotime(date('Y-m-d'));
                $result = $article->getShareData($day,$tag_id);
                break;
            case 2:
                $end = strtotime(date('Y-m-d'))+24*3600;
                $start = $end - 7*24*3600;
                $result = $article->getShareHistoryData($start,$end,$tag_id);
                $length = count($result);
                for ($x = 0; $x < $length; $x++) {
                    $result[$x]["stat_at"] =date("Y-m-d",$result[$x]["stat_at"]);
                    if($result[$x]["share_uv"] == 0) {
                        $result[$x]["share_average"] = 0;
                    }else {

                        $result[$x]["share_average"] = ceil($result[$x]["share_pv"] / $result[$x]["share_uv"]);
                    }
                }
                break;
            case 3:
                $end = strtotime(date('Y-m-d'))+24*3600;
                $start = $end - 30*24*3600;
                $result = $article->getShareHistoryData($start,$end,$tag_id);
                $length = count($result);
//                var_dump($result);die();
                for ($x = 0; $x < $length; $x++) {
                    $result[$x]["stat_at"] =date("Y-m-d",$result[$x]["stat_at"]);
                    if($result[$x]["share_uv"] == 0) {
                        $result[$x]["share_average"] = 0;
                    }else {

                        $result[$x]["share_average"] = ceil($result[$x]["share_pv"] / $result[$x]["share_uv"]);
                    }
                }
                break;

        }
        return $result;
    }
    public function getTitle($article_id)
    {
        $article = new \manage\models\statistics\dao\Article();
        $result = $article->get_title_by_article_id($article_id);
        return $result;
    }

    public function getLikeData($type,$tag_id)
    {
        $article = new \manage\models\statistics\dao\Article();
        $result = [];
        switch ($type){
            case 1:
                $day = strtotime(date('Y-m-d'));
                $result = $article->getLikeData($day,$tag_id);
                break;
            case 2:
                $end = strtotime(date('Y-m-d'))+24*3600;
                $start = $end - 7*24*3600;
                $result = $article->getLikeHistoryData($start,$end,$tag_id);
                $length = count($result);
                for ($x = 0; $x < $length; $x++) {
                    $result[$x]["stat_at"] =date("Y-m-d",$result[$x]["stat_at"]);
                    if($result[$x]["like_uv"] == 0) {
                        $result[$x]["like_average"] = 0;
                    }else {

                        $result[$x]["like_average"] = ceil($result[$x]["like_pv"] / $result[$x]["like_uv"]);
                    }
                }
                break;
            case 3:
                $end = strtotime(date('Y-m-d'))+24*3600;
                $start = $end - 30*24*3600;
                $result = $article->getLikeHistoryData($start,$end,$tag_id);
                $length = count($result);
                for ($x = 0; $x < $length; $x++) {
                    $result[$x]["stat_at"] =date("Y-m-d",$result[$x]["stat_at"]);
                    if($result[$x]["like_uv"] == 0) {
                        $result[$x]["like_average"] = 0;
                    }else {
                        $result[$x]["like_average"] = ceil($result[$x]["like_pv"] / $result[$x]["like_uv"]);
                    }
                }
                break;

        }
        return $result;
    }

    public function getDetailData($start,$end,$article_id)
    {
        $article = new \manage\models\statistics\dao\Article();
        $consult = new \manage\models\statistics\dao\Consult();
        $result = $article->getDetailData($start,$end,$article_id);
        $length = count($result);
        for ($x = 0; $x < $length; $x++) {
            $result[$x]['stat_at'] = date("Y-m-d ", $result[$x]['stat_at']);
            $title_array = $consult->get_title_by_article_id($article_id);
            $result[$x]["title"] = $title_array["title"];
        }
        return $result;
    }
    public function getviewsort($timetype,$type)
    {
        $article = new \manage\models\statistics\dao\Article();
        $timeArray = $this->getTime($timetype);
        if ($type == 1) {   //表示是按照pv进行排行
            $result = $article->get_viewsort_by_pv($timeArray["start_day"], $timeArray["end_day"]);
        } else { //表示按照uv进行排行
            $result = $article->get_viewsort_by_uv($timeArray["start_day"], $timeArray["end_day"]);
        }
        $length = count($result);
        for ($x = 0; $x < $length; $x++) {
            $article_id = $result[$x]["article_id"];
            $title_array = $article->get_title_by_article_id($article_id);
//            var_dump($title_array);die();
            $result[$x]["title"] = $title_array["title"];
        }
        return $result;
    }
    public function getsharesort($timetype,$type)
    {
        $article = new \manage\models\statistics\dao\Article();
        $timeArray = $this->getTime($timetype);
        if ($type == 1) {   //表示是按照pv进行排行
            $result = $article->get_sharesort_by_pv($timeArray["start_day"], $timeArray["end_day"]);
        } else { //表示按照uv进行排行
            $result = $article->get_sharesort_by_uv($timeArray["start_day"], $timeArray["end_day"]);
        }
        $length = count($result);
        for ($x = 0; $x < $length; $x++) {
            $article_id = $result[$x]["article_id"];
//            var_dump($article);die();
//            echo $article_id;die();
            $title_array = $article->get_title_by_article_id($article_id);
//            var_dump($title_array);die();
            $result[$x]["title"] = $title_array["title"];
        }
        return $result;
    }
    public function getlikesort($timetype,$type)
    {
        $article = new \manage\models\statistics\dao\Article();
        $timeArray = $this->getTime($timetype);
        if ($type == 1) {   //表示是按照pv进行排行
            $result = $article->get_likesort_by_pv($timeArray["start_day"], $timeArray["end_day"]);
        } else { //表示按照uv进行排行
            $result = $article->get_likesort_by_uv($timeArray["start_day"], $timeArray["end_day"]);
        }
        $length = count($result);
        for ($x = 0; $x < $length; $x++) {
            $article_id = $result[$x]["article_id"];
            $title_array = $article->get_title_by_article_id($article_id);
//            var_dump($title_array);die();
            $result[$x]["title"] = $title_array["title"];
        }
        return $result;
    }

}