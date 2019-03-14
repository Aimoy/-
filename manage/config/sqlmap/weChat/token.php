<?php
/**
 * Created by PhpStorm.
 * User: wanghaolin
 * Date: 2018/6/11
 * Time: 17:00
 */

return [

    'sql_get_by_time' => 'SELECT #COLUMN# FROM wechat_token WHERE NOW() < expires_in-10 ORDER BY expires_in DESC LIMIT 1',

    'sql_insert_token' => 'LOCK TABLES wechat_token write;INSERT INTO wechat_token(access_token,expires_in) VALUES (:access_token,:expires_in);UNLOCK tables;',

];
