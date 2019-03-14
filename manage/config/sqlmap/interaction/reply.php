<?php
/**
 * Created by PhpStorm.
 * User: duanwei
 * Date: 2018/4/19
 * Time: 下午4:10
 */

return [

    'sql_get_by_id' => 'SELECT #COLUMN# FROM reply WHERE id=:id LIMIT 1',

    'sql_get_count_by_id' => 'SELECT count(1) as count FROM reply WHERE id=:id',

    'sql_update_reply_ids' => 'UPDATE reply SET reply_ids=:reply_ids,updated_at=:updated_at WHERE id=:id',

    'sql_get_warning_list' => 'SELECT id,content,article_id,comment_id,user_id,nickname,thumb_img,created_at FROM reply WHERE is_hidden=1 AND created_at BETWEEN :start_date AND :end_date UNION SELECT id,content,article_id,0 as comment_id,user_id,nickname,thumb_img,created_at FROM comment WHERE is_hidden=1 AND created_at BETWEEN :start_date AND :end_date ORDER BY :order LIMIT :limit',

    'sql_get_warning_list_count' => 'SELECT count(1) as count FROM (SELECT id,content,article_id,comment_id,user_id,nickname,thumb_img,created_at FROM reply WHERE is_hidden=1 AND created_at BETWEEN :start_date AND :end_date UNION SELECT id,content,article_id,0 as comment_id,user_id,nickname,thumb_img,created_at FROM comment WHERE is_hidden=1 AND created_at BETWEEN :start_date AND :end_date) as tmp',

    'sql_update_like_num' => 'UPDATE reply SET like_num=like_num+:like_num,updated_at=:updated_at WHERE id=:id',

    'sql_update_hidden_in_ids' => 'UPDATE reply SET is_hidden=:is_hidden,updated_at=:updated_at WHERE id in (:ids)'

];
