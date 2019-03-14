<?php
/**
 * Created by PhpStorm.
 * User: zhouqing
 * Date: 2018/05/07
 * Time: 下午3:54
 */

return [


    'sql_get_media_by_uri' => 'SELECT  #COLUMN# FROM `media` WHERE uri=:uri',

    'sql_insert_info' => 'INSERT into `media` (`uri`,`size`,`format`,`mime_type`,`bucket`,`creator`) VALUES(:uri,:size,:format,:mime_type,:bucket,:creator)',

];