<?php
/**
 * Created by PhpStorm.
 * User: duanwei
 * Date: 2018/4/19
 * Time: 下午4:10
 */

return [

    'sql_get_by_id' => 'SELECT #COLUMN# FROM send_record_reply WHERE id=:id LIMIT 1',

    'sql_get_total' => 'SELECT count(1) as count FROM send_record_reply WHERE :condition',

    'sql_get_send_record_reply_list'=> 'SELECT #COLUMN# FROM send_record_reply WHERE :condition ORDER BY created_at DESC LIMIT :limit',
];
