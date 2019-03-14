<?php
/**
 * Created by PhpStorm.
 * User: wanghaolin
 * Date: 2018/6/19
 * Time: 下午3:54
 */


return [

    'sql_insert_send' => 'INSERT INTO `send_record`(`title`,`description`,`creator`,`url`,`url_id`,`openids`,`type`,`send_time`,`publish_time`) VALUES(:title,:description,:creator,:url,:url_id,:openids,:type,:send_time,:publish_time)',

    'sql_update_send' => 'UPDATE `send_record` SET `title`=:title,`description`=:description,`creator`=:creator,`url`=:url,`url_id`=:url_id,`openids`=:openids,`type`=:type,`send_time`=:send_time,`publish_time`=:publish_time WHERE id=:id',

    'sql_get_send'=>'SELECT #COLUMN# from `send_record` where id=:id',

    'sql_update_send_num' => 'UPDATE `send_record` SET `send_num`=:send_num WHERE id=:id',

    'sql_delete_send' => 'DELETE FROM `send_record` WHERE id=:id',

];