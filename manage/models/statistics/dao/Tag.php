<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/10
 * Time: 16:25
 */
namespace manage\models\statistics\dao;

use manage\models\BaseDao;
class Tag extends  BaseDao
{
    //栏目浏览的pv，uv，staytime_average
    public function getView($tag_id,$start_day,$end_day){
        $params = [
            'tag_id'=>$tag_id,
             'start_day'=>$start_day,
            'end_day'=>$end_day
        ];
        $result = $this->queryExecute('statistics.tag.get_view_by_day', $params)->queryAll();
        return $result;
    }

    //栏目的曝光的pv，uv，exposure_average
    public function getExposure($tag_id,$start_day,$end_day){
        $params = [
            'tag_id'=>$tag_id,
            'start_day'=>$start_day,
            'end_day'=>$end_day
        ];
        $result = $this->queryExecute('statistics.tag.get_exposure_by_day', $params)->queryAll();
        return $result;
    }
    //栏目的下拉操作的pv，uv，down_average
    public function getDown($tag_id,$start_day,$end_day){
        $params = [
            'tag_id'=>$tag_id,
            'start_day'=>$start_day,
            'end_day'=>$end_day
        ];
        $result = $this->queryExecute('statistics.tag.get_down_by_day', $params)->queryAll();
        return $result;
    }
    //栏目的上拉操作的pv，uv，down_average
    public function getUp($tag_id,$start_day,$end_day){
        $params = [
            'tag_id'=>$tag_id,
            'start_day'=>$start_day,
            'end_day'=>$end_day
        ];
        $result = $this->queryExecute('statistics.tag.get_up_by_day', $params)->queryAll();
        return $result;
    }


}