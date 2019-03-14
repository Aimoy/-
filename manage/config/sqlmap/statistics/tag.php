<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/10
 * Time: 16:32
 */
return [
    'get_view_by_day'=>'SELECT stat_at,stay_time_uv as staytime_average,view_pv as view_pv,view_uv as view_uv from stat_tag_view_day where stat_at>=:start_day AND stat_at<=:end_day AND tag_id=:tag_id GROUP BY stat_at',
    'get_exposure_by_day'=>'SELECT stat_at,exposure_sum as exposure_pv,view_uv as exposure_uv from stat_tag_view_day where tag_id=:tag_id AND stat_at>=:start_day AND stat_at<=:end_day GROUP BY stat_at',
    'get_down_by_day'=>'SELECT stat_at,down_manual_pv as down_pv,down_uv as down_uv from stat_tag_view_day where tag_id=:tag_id AND stat_at>=:start_day AND stat_at<=:end_day GROUP BY stat_at',
    'get_up_by_day'=> 'SELECT stat_at,up_pv as up_pv,up_uv as up_uv from stat_tag_view_day where tag_id=:tag_id AND stat_at>=:start_day AND stat_at<=:end_day GROUP BY stat_at'
    ];