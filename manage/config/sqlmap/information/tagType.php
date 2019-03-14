<?php
/**
 * Created by PhpStorm.
 * User: zhouqing
 * Date: 2018/4/8
 * Time: 下午3:54
 */


return [

    'sql_get_by_tag_id_type_id' => 'SELECT `tag_type`.`id` FROM `tag_type`  WHERE `tag_id`=:tag_id AND `type_id`=:type_id',

    'sql_get_by_id' => 'SELECT `tag_type`.`id`,`tag_type`.`tag_id`,`tag_type`.`type_id`,`tag_type`.`remark`,`tag_type`.`is_default`,`tag`.`tag_name` FROM `tag_type` INNER JOIN `tag` ON `tag`.`id`=`tag_type`.`tag_id`  WHERE `tag_type`.`id`=:id',

    'sql_tag_type_insert' => 'INSERT INTO `tag_type` (`tag_id`,`type_id`,`remark`,`is_default`) VALUES(:tag_id,:type_id,:remark,:is_default)',

    'sql_update_by_id' => 'UPDATE `tag_type` SET `tag_id`=:tag_id,`type_id`=:type_id,`remark`=:remark,`is_default`=:is_default,`updated_at`=CURRENT_TIME WHERE `id`=:id',

    'sql_delete_tag_type_by_ids' => 'DELETE FROM `tag_type` WHERE `id` in (:ids)',

    'sql_get_row_from_type_id_tag_id' => 'SELECT `id` FROM `tag_type`  WHERE `tag_id`=:tag_id AND `type_id`=:type_id',


];