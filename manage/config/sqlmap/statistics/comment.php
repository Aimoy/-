<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/16
 * Time: 0:47
 */


return[
    'get_post'=>'SELECT stat_at,tag_id,SUM(post_pv) as pv,SUM(post_uv) as uv from stat_comment_view_day where stat_at>=:start AND stat_at<=:end AND tag_id=:tag_id GROUP BY stat_at ',

    'get_reply'=>'SELECT stat_at,tag_id,SUM(reply_pv) as pv,SUM(reply_uv) as uv from stat_comment_view_day where stat_at>=:start AND stat_at<=:end AND tag_id=:tag_id GROUP BY stat_at ',

    'get_detail'=>'SELECT stat_at,tag_id,SUM(comment_detail_pv) as pv,SUM(comment_detail_uv) as uv from stat_comment_view_day where stat_at>=:start AND stat_at<=:end AND tag_id=:tag_id GROUP BY stat_at ',

    'get_like'=>'SELECT stat_at,tag_id,SUM(like_pv) as pv,SUM(like_uv) as uv from stat_comment_view_day where stat_at>=:start AND stat_at<=:end AND tag_id=:tag_id GROUP BY stat_at ',

    'get_post_by_pv'=>"SELECT SUM(post_pv) as pv,article_id from stat_comment_view_day where stat_at>=:start AND stat_at<=:end GROUP BY article_id ORDER BY pv DESC LIMIT 10",

    'get_post_by_uv'=>"SELECT SUM(post_uv) as uv,article_id from stat_comment_view_day where stat_at>=:start AND stat_at<=:end GROUP BY article_id ORDER BY uv DESC LIMIT 10",

    'get_like_sort_by_pv'=>"SELECT SUM(like_pv) as pv,article_id from stat_article_view_day where stat_at>=:start AND stat_at<=:end GROUP BY article_id ORDER BY pv DESC LIMIT 10",

    'get_like_sort_by_uv'=>"SELECT SUM(like_uv) as uv,article_id from stat_comment_view_day where stat_at>=:start AND stat_at<=:end GROUP BY article_id ORDER BY uv DESC LIMIT 10",

    'get_title_by_id'=>'SELECT title from info_published WHERE id=:id',

    'get_detail_by_day'=>'SELECT article_id,comment_detail_uv as uv,comment_detail_pv as pv,stat_at from stat_comment_view_day WHERE stat_at>=:start AND stat_at<=:end AND article_id=:article_id',

    'get_data_by_article'=>'SELECT article_id,stat_at,post_uv,post_pv,like_uv,like_pv from stat_comment_view_day WHERE stat_at>=:start AND stat_at<=:end AND article_id=:id'
];