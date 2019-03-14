<?php
/**
 * Created by PhpStorm.
 * User: wanghaolin
 * Date: 2018/4/24
 * Time: 13:11
 */

return [

    'sql_get_agree_status' => 'SELECT id FROM agree WHERE type_id=:type_id AND type=:type AND user_id=:user_id',

    'sql_get_agree_status_in_ids' => 'SELECT type_id FROM agree WHERE type_id IN (:type_id) AND type=:type AND user_id=:user_id',

    'sql_add_agree' => 'INSERT INTO  agree (`user_id`,`type_id`,`type`,`nickname`,`avatarUrl`) VALUES(:user_id,:type_id,:type,:nickname,:avatarUrl)',

    'sql_del_agree' => 'DELETE FROM agree WHERE type_id=:type_id AND type=:type AND user_id=:user_id',

    'sql_get_comment_user_by_page'=>'SELECT #COLUMN# FROM agree WHERE type_id=:type_id AND type=:type LIMIT :offset,:pageNum',
];