<?php
/**
 * Created by PhpStorm.
 * User: charlie
 * Date: 2018/4/8
 * Time: 下午3:54
 */


return [

    'sql_get_list' => 'SELECT #COLUMN# FROM tag',
    'sql_get_list_v2' => 'SELECT `tag`.`id`,`tag_type`.`is_default`,`tag`.`tag_name` FROM `tag` INNER JOIN `tag_type` ON `tag_type`.`tag_id` = `tag`.`id` WHERE `tag_type`.`type_id` = :type_id',

    'sql_insert_tag' => 'INSERT INTO `tag`(`tag_name`,`creator`) VALUES(:tag_name,:creator)',

    'sql_get_tag_by_name' => 'SELECT #COLUMN# FROM `tag` WHERE `tag_name`=:tag_name'
];