<?php
/**
 * Created by PhpStorm.
 * User: xiaoai
 * Date: 2018/7/11
 * Time: 16:33
 */
return[
    'get_consult_by_time'=>'SELECT stat_at,tag_id,SUM(consult_pv) as consult_pv,SUM(consult_uv) as consult_uv from stat_article_view_day where stat_at>=:start AND stat_at<=:end AND tag_id=:tag_id GROUP BY stat_at ',

    'get_sort_by_pv'=>"SELECT SUM(consult_pv) as consult_pv,article_id from stat_article_view_day where stat_at>=:start AND stat_at<=:end GROUP BY article_id ORDER BY consult_pv DESC LIMIT 10",

    'get_sort_by_uv'=>"SELECT SUM(consult_uv) as consult_uv,article_id from stat_article_view_day where stat_at>=:start AND stat_at<=:end GROUP BY article_id ORDER BY consult_uv DESC LIMIT 10",

    'get_yes_sort_by_pv'=>"SELECT SUM(auth_num) as auth_pv,article_id from stat_article_view_day where stat_at>=:start AND stat_at<=:end GROUP BY article_id ORDER BY auth_pv DESC LIMIT 10",

    'get_no_sort_by_pv'=>"SELECT SUM(unauth_num) as unauth_pv,article_id from stat_article_view_day where stat_at>=:start AND stat_at<=:end GROUP BY article_id ORDER BY unauth_pv DESC LIMIT 10",

    'get_title_by_id'=>'SELECT title from info_published WHERE id=:id',

    'get_consultyes'=>'SELECT  stat_at,tag_id,SUM(auth_num) as consultyes_pv from stat_article_view_day where stat_at>=:start AND stat_at<=:end AND tag_id=:tag_id GROUP BY stat_at',

    'get_consultno'=>'SELECT  stat_at,tag_id,SUM(unauth_num) as consultno_pv from stat_article_view_day where stat_at>=:start AND stat_at<=:end AND tag_id=:tag_id GROUP BY stat_at',

    'get_data_by_article'=>'SELECT article_id,SUM(consult_pv) as consult_pv,SUM(consult_uv) as consult_uv,stat_at from stat_article_view_day where stat_at>=:start AND stat_at<=:end AND article_id=:id GROUP BY stat_at ',

    'get_data_by_auth'=>'SELECT article_id,SUM(auth_num) as auth_pv,stat_at from stat_article_view_day where stat_at>=:start AND stat_at<=:end AND article_id=:id GROUP BY stat_at ',

    'get_data_by_unauth'=>'SELECT article_id,SUM(unauth_num) as unauth_pv,stat_at from stat_article_view_day where stat_at>=:start AND stat_at<=:end AND article_id=:id GROUP BY stat_at ',
];