<?php
/**
 * Created by PhpStorm.
 * User: xiaoai
 * Date: 2018/7/11
 * Time: 15:21
 */
namespace manage\models\statistics\bo;

use manage\models\BaseBo;
class Consult extends BaseBo
{
    public $consult;
    public function __construct()
    {
        $this->consult = new \manage\models\statistics\dao\Consult();
    }

    public function getconsultyes($type,$tag_id)
    {
        $timeArray = $this->getTime($type);
        $result = $this->consult->get_consultyes($timeArray["start_day"], $timeArray["end_day"],$tag_id);
        $length = count($result);
        for ($x = 0; $x < $length; $x++) {
            $result[$x]["stat_at"] =date("Y-m-d",$result[$x]["stat_at"]);
        }
        return $result;
    }
    public function getconsultno($type,$tag_id)
    {
        $timeArray = $this->getTime($type);
        $result = $this->consult->get_consultno($timeArray["start_day"], $timeArray["end_day"],$tag_id);
        $length = count($result);
        for ($x = 0; $x < $length; $x++) {
            $result[$x]["stat_at"] =date("Y-m-d",$result[$x]["stat_at"]);}
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
    public function getConsult($type,$tag_id)
    {
        $timeArray = $this->getTime($type);
        $result = $this->consult->getConsult($timeArray["start_day"], $timeArray["end_day"],$tag_id);
        $length = count($result);
        for ($x = 0; $x < $length; $x++) {
            $result[$x]["stat_at"] = date("Y-m-d", $result[$x]["stat_at"]);
        }
        return $result;

    }



    public function getConsultData($timeType, $type)
    {
        $timeArray = $this->getTime($timeType);
        if ($type == 1) {   //表示是按照pv进行排行
            $result = $this->consult->get_consult_by_pv($timeArray["start_day"], $timeArray["end_day"]);
        } else { //表示按照uv进行排行
            $result = $this->consult->get_consult_by_uv($timeArray["start_day"], $timeArray["end_day"]);
        }
        return $result;
    }
    public function getConsultyesData($timeType,$type)
    {
        $timeArray = $this->getTime($timeType);
        if ($type) {   //表示是按照pv进行排行
            $result = $this->consult->get_consultyes_by_pv($timeArray["start_day"], $timeArray["end_day"]);
        }
        return $result;
    }
    public function getConsultnoData($timeType,$type)
    {
        $timeArray = $this->getTime($timeType);
        if ($type) {   //表示是按照pv进行排行
            $result = $this->consult->get_consultno_by_pv($timeArray["start_day"], $timeArray["end_day"]);
        }
        return $result;
    }
    public function getTitle($article_id)
    {
        $result = $this->consult->get_title_by_article_id($article_id);
        return $result;
    }
    public function getconsultSearch($article_id,$start_day,$stop_day)
    {
        $start = strtotime($start_day);
        $end = strtotime($stop_day);
        $result = $this->consult->get_data_by_id_time($article_id,$start,$end);
        return $result;
    }
    public function getSearch_byauth($article_id,$start_day,$stop_day)
    {
        $start = strtotime($start_day);
        $end = strtotime($stop_day);
        $result = $this->consult->get_data_by_auth($article_id,$start,$end);
        return $result;
    }
    public function getSearch_byunauth($article_id,$start_day,$stop_day)
    {
        $start = strtotime($start_day);
        $end = strtotime($stop_day);
        $result = $this->consult->get_data_by_unauth($article_id,$start,$end);
        return $result;
    }

}

