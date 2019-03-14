<?php
/**
 * Created by PhpStorm.
 * User: wanghaolin
 * Date: 2018/7/2
 * Time: 16:05
 */
return [
    'get_sum_by_day'=>'SELECT SUM(view_pv) as pv,SUM(view_uv) as uv from stat_article_view_day where stat_at>=:start AND stat_at<=:end ',

    'get_type_by_day'=>'SELECT tag_id,SUM(view_pv) as pv,SUM(view_uv) as uv from stat_article_view_day where stat_at>=:start AND stat_at<=:end  GROUP BY tag_id',

    'get_sort_pv_by_day'=>'SELECT article_id,SUM(view_pv) as pv from stat_article_view_day where stat_at=:day GROUP BY article_id ORDER BY pv DESC LIMIT 10',

    'get_sort_pv_by_week'=>'SELECT article_id,SUM(view_pv) as pv from stat_article_view_day where stat_at>=:start AND stat_at<=:end GROUP BY article_id ORDER BY pv DESC LIMIT 10',

    'get_sort_pv_by_month'=>'SELECT article_id,SUM(view_pv) as pv from stat_article_view_day where stat_at>=:start AND stat_at<=:end GROUP BY article_id ORDER BY pv DESC LIMIT 10',

//    'get_sort_uv_by_day'=>'SELECT article_id,SUM(view_uv) as uv from stat_article_view_day where stat_at=:day GROUP BY article_id ORDER BY uv DESC LIMIT 10',

//    'get_sort_uv_by_week'=>'SELECT article_id,SUM(view_uv) as uv from stat_article_view_day where stat_at>=:start AND stat_at<=:end GROUP BY article_id ORDER BY uv DESC LIMIT 10',

//    'get_sort_uv_by_month'=>'SELECT article_id,SUM(view_uv) as uv from stat_article_view_day where stat_at>=:start AND stat_at<=:end GROUP BY article_id ORDER BY uv DESC LIMIT 10',

    'get_detail_by_day'=>'SELECT article_id,view_uv,view_pv,like_pv,like_uv,share_pv,share_uv,stat_at,stay_time_uv as stay_time from stat_article_view_day where stat_at>=:start AND stat_at<=:end AND article_id=:article_id',

    'get_like_by_day'=>'SELECT tag_id,stat_at,SUM(like_pv) as like_pv,SUM(like_uv) as like_uv from stat_article_view_day where stat_at=:day AND tag_id=:tag_id',

    'get_like_by_history'=>'SELECT tag_id,stat_at,SUM(like_pv) as like_pv,SUM(like_uv) as like_uv from stat_article_view_day where stat_at>=:start AND stat_at<=:end AND tag_id=:tag_id GROUP BY stat_at',

    'get_share_by_day'=>'SELECT tag_id,SUM(share_pv) as share_pv,SUM(share_uv) as share_uv from stat_article_view_day where stat_at=:day AND tag_id=:tag_id',

    'get_share_by_history'=>'SELECT tag_id,stat_at,SUM(share_pv) as share_pv,SUM(share_uv) as share_uv from stat_article_view_day where stat_at>=:start AND stat_at<=:end AND tag_id=:tag_id GROUP BY stat_at',

    'get_viewsort_by_pv'=>'SELECT article_id,SUM(view_pv) as pv from stat_article_view_day where  stat_at>=:start AND stat_at<=:end GROUP BY article_id ORDER BY pv DESC LIMIT 10',

    'get_viewsort_by_uv'=>'SELECT article_id,SUM(view_uv) as uv from stat_article_view_day where  stat_at>=:start AND stat_at<=:end GROUP BY article_id ORDER BY uv DESC LIMIT 10',

    'get_sharesort_by_pv'=>'SELECT article_id,SUM(share_pv) as pv from stat_article_view_day where  stat_at>=:start AND stat_at<=:end GROUP BY article_id ORDER BY pv DESC LIMIT 10',

    'get_sharesort_by_uv'=>'SELECT article_id,SUM(share_uv) as uv from stat_article_view_day where  stat_at>=:start AND stat_at<=:end GROUP BY  article_id ORDER BY uv DESC LIMIT 10',

    'get_likesort_by_pv'=>'SELECT article_id,SUM(like_pv) as pv from stat_article_view_day where  stat_at>=:start AND stat_at<=:end GROUP BY article_id ORDER BY pv DESC LIMIT 10',

    'get_sharesort_by_uv'=>'SELECT article_id,SUM(like_uv) as uv from stat_article_view_day where  stat_at>=:start AND stat_at<=:end GROUP BY  article_id ORDER BY uv DESC LIMIT 10',

    'get_title_by_id'=>'SELECT title from info_published WHERE id=:id',

];
