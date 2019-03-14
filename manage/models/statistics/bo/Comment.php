<?php
/**
 * Created by PhpStorm.
 * User: xiaoai
 * Date: 2018/7/15
 * Time: 00:21
 */
namespace manage\models\statistics\bo;

use manage\models\BaseBo;
class Comment extends BaseBo
{
    public $consult;
    public function __construct()
    {
        $this->consult = new \manage\models\statistics\dao\Comment();
    }

    public function getPost($type,$tag_id)
    {
        $timeArray = $this->getTime($type);
        $result = $this->consult->getPost($timeArray["start_day"], $timeArray["end_day"],$tag_id);
        $length = count($result);
        for ($x = 0; $x < $length; $x++) {
            $result[$x]["stat_at"] =date("Y-m-d",$result[$x]["stat_at"]);
            if($result[$x]["uv"] == 0){
                $result[$x]["post_average"] = 0;
            }else{

                $result[$x]["post_average"] =  ceil($result[$x]["pv"] /  $result[$x]["uv"]);
            }
        }
        return $result;
    }
    public function getReply($type,$tag_id)
    {
        $timeArray = $this->getTime($type);
        $result = $this->consult->getReply($timeArray["start_day"], $timeArray["end_day"],$tag_id);
        $length = count($result);
        for ($x = 0; $x < $length; $x++) {
            $result[$x]["stat_at"] =date("Y-m-d",$result[$x]["stat_at"]);}
        return $result;
    }

    public function getLike($type,$tag_id)
    {
        $timeArray = $this->getTime($type);
        $result = $this->consult->getLike($timeArray["start_day"], $timeArray["end_day"],$tag_id);
        $length = count($result);
        for ($x = 0; $x < $length; $x++) {
            $result[$x]["stat_at"] =date("Y-m-d",$result[$x]["stat_at"]);
          if($result[$x]["uv"] == 0){
              $result[$x]["like_average"] = 0;
          }else{

              $result[$x]["like_average"] =  ceil($result[$x]["pv"] /  $result[$x]["uv"]);
          }
        }
        return $result;
    }

    public function getDetail($type,$tag_id)
    {
        $timeArray = $this->getTime($type);
        $result = $this->consult->getDetail($timeArray["start_day"], $timeArray["end_day"],$tag_id);
        $length = count($result);
        for ($x = 0; $x < $length; $x++) {
            $result[$x]["stat_at"] =date("Y-m-d",$result[$x]["stat_at"]);
            if($result[$x]["uv"] == 0){
                $result[$x]["detail_average"] = 0;
            }else{

                $result[$x]["detail_average"] =  ceil($result[$x]["pv"] /  $result[$x]["uv"]);
            }
        }
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



    public function getPostSort($timeType, $type)
    {
        $timeArray = $this->getTime($timeType);
        if ($type == 1) {   //表示是按照pv进行排行
            $result = $this->consult->get_post_by_pv($timeArray["start_day"], $timeArray["end_day"]);
        } else { //表示按照uv进行排行
            $result = $this->consult->get_post_by_uv($timeArray["start_day"], $timeArray["end_day"]);
        }
        return $result;
    }
    public function getLikeSort($timeType,$type)
    {
        $timeArray = $this->getTime($timeType);
        if ($type) {   //表示是按照pv进行排行
            $result = $this->consult->get_like_by_pv($timeArray["start_day"], $timeArray["end_day"]);
        }else { //表示按照uv进行排行
            $result = $this->consult->get_like_by_uv($timeArray["start_day"], $timeArray["end_day"]);
        }
        return $result;
    }

    public function getCommentSearch($start_day,$end_day,$article_id)
    {
        $start = strtotime($start_day);
        $end = strtotime($end_day);
        $result = $this->consult->get_data_by_id_time($article_id,$start,$end);
        return $result;
    }
    public function getTitle($article_id)
    {
        $result = $this->consult->get_title_by_article_id($article_id);
        return $result;
    }

    public function getDetailData($start,$end,$article_id)
    {
        $article = new \manage\models\statistics\dao\Comment();
        $consult = new \manage\models\statistics\dao\Comment();
        $result = $article->getDetailData($start,$end,$article_id);
        $length = count($result);
        for ($x = 0; $x < $length; $x++) {
            $result[$x]['stat_at'] = date("Y-m-d ", $result[$x]['stat_at']);
            $title_array = $consult->get_title_by_article_id($article_id);
            $result[$x]["title"] = $title_array["title"];
        }
        return $result;
    }

}

