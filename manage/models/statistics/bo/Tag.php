<?php
/**
 * Created by PhpStorm.
 * User: xiaoai
 * Date: 2018/7/10
 * Time: 16:23
 */

namespace manage\models\statistics\bo;


use manage\models\BaseBo;

class Tag extends BaseBo
{

    public function getview($tag_id, $type)
    {
        $tag = new \manage\models\statistics\dao\Tag();
        switch ($type) {
            case 1:
                //把时间转换成时间戳
                $start_day = strtotime(date('Y-m-d', strtotime(time())));
                $end_day = strtotime(date("Y-m-d", strtotime(time())));
                break;
            case 2:
                $end_day = strtotime(date('Y-m-d')) + 24 * 3600;
                $start_day = $end_day - 7 * 24 * 3600;
                break;
            case 3:
                $end_day = strtotime(date('Y-m-d')) + 24 * 3600;
                $start_day = $end_day - 30 * 24 * 3600;
                break;
        }
        $result = $tag->getView($tag_id, $start_day, $end_day);
        return $result;
    }
    public function getexposure($tag_id,$type)
    {
        $tag = new \manage\models\statistics\dao\Tag();
        switch ($type) {
            case 1:
                //把时间转换成时间戳
                $start_day = strtotime(date('Y-m-d', strtotime(time())));
                $end_day = strtotime(date("Y-m-d", strtotime(time())));
                break;
            case 2:
                $end_day = strtotime(date('Y-m-d')) + 24 * 3600;
                $start_day = $end_day - 7 * 24 * 3600;
                break;
            case 3:
                $end_day = strtotime(date('Y-m-d')) + 24 * 3600;
                $start_day = $end_day - 30 * 24 * 3600;
                break;
        }
        $result = $tag->getExposure($tag_id, $start_day, $end_day);
        $length = count($result);
        for ($x = 0; $x < $length; $x++) {

            if($result[$x]["exposure_uv"] == 0) {
                $result[$x]["exposure_average"] = 0;
            }else {

                $result[$x]["exposure_average"] = ceil($result[$x]["exposure_pv"] / $result[$x]["exposure_uv"]);
            }
        }
        return $result;

    }
    public function getdown($tag_id,$type)
    {
        $tag = new \manage\models\statistics\dao\Tag();
        switch ($type) {
            case 1:
                //把时间转换成时间戳
                $start_day = strtotime(date('Y-m-d', strtotime(time())));
                $end_day = strtotime(date("Y-m-d", strtotime(time())));
                break;
            case 2:
                $end_day = strtotime(date('Y-m-d')) + 24 * 3600;
                $start_day = $end_day - 7 * 24 * 3600;
                break;
            case 3:
                $end_day = strtotime(date('Y-m-d')) + 24 * 3600;
                $start_day = $end_day - 30 * 24 * 3600;
                break;
        }
        $result = $tag->getDown($tag_id, $start_day, $end_day);
        $length = count($result);
        for ($x = 0; $x < $length; $x++) {

            if($result[$x]["down_uv"] == 0) {
                $result[$x]["down_average"] = 0;
            }else {

                $result[$x]["down_average"] = ceil($result[$x]["down_pv"] / $result[$x]["down_uv"]);
            }
        }
        return $result;
    }
    public function getup($tag_id,$type)
    {
        $tag = new \manage\models\statistics\dao\Tag();
        switch ($type) {
            case 1:
                //把时间转换成时间戳
                $start_day = strtotime(date('Y-m-d', strtotime(time())));
                $end_day = strtotime(date("Y-m-d", strtotime(time())));
                break;
            case 2:
                $end_day = strtotime(date('Y-m-d')) + 24 * 3600;
                $start_day = $end_day - 7 * 24 * 3600;
                break;
            case 3:
                $end_day = strtotime(date('Y-m-d')) + 24 * 3600;
                $start_day = $end_day - 30 * 24 * 3600;
                break;
        }
        $result = $tag->getUp($tag_id, $start_day, $end_day);
        $length = count($result);
        for ($x = 0; $x < $length; $x++) {

            if($result[$x]["up_uv"] == 0) {
                $result[$x]["up_average"] = 0;
            }else {

                $result[$x]["up_average"] = ceil($result[$x]["up_pv"] / $result[$x]["up_uv"]);
            }
        }
        return $result;
    }
}
