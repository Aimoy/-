<?php
/**
 * Created by PhpStorm.
 * User: duanwei
 * Date: 2018/4/19
 * Time: 下午4:10
 */

return [

    'sql_get_by_id' => 'SELECT #COLUMN# FROM comment WHERE id=:id LIMIT 1',

    'sql_get_count_by_id' => 'SELECT count(1) as count FROM comment WHERE id=:id',

    'sql_update_reply_ids' => 'UPDATE comment SET reply_ids=:reply_ids,updated_at=:updated_at WHERE id=:id',

    'sql_update_reply_num' => 'UPDATE comment SET reply_num=reply_num+:reply_num,updated_at=:updated_at WHERE id=:id',

    'sql_update_like_num' => 'UPDATE comment SET like_num=like_num+:like_num,updated_at=:updated_at WHERE id=:id',

    'sql_update_hidden_in_ids' => 'UPDATE comment SET is_hidden=:is_hidden,updated_at=:updated_at WHERE id in (:ids)'

];
