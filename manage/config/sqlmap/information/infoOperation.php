<?php
/**
 * Created by PhpStorm.
 * User: charlie
 * Date: 2018/4/8
 * Time: 下午3:54
 */


/*

CREATE TABLE `info_operation` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '待发布文章ID',
  `type_id` int(4) unsigned NOT NULL DEFAULT '0' COMMENT '分类ID',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
  `content` varchar(255) NOT NULL DEFAULT '' COMMENT '内容',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '信息内容简述（将信息内容截取前50个字放入此字段中）',
  `coverage` varchar(511) NOT NULL DEFAULT '' COMMENT '文章封面,ossURI多个以逗号分隔',
  `origin_link` varchar(255) NOT NULL DEFAULT '' COMMENT '信息原始链接',
  `source` varchar(20) NOT NULL DEFAULT '' COMMENT '信息来源网站名称',
  `come_from` tinyint(4) unsigned NOT NULL DEFAULT '1' COMMENT '信息来源（1：外部抓取；2：内部编辑）',
  `status` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '信息状态（0：待发布；1：已发布）',
  `tag` varchar(32) NOT NULL DEFAULT '' COMMENT '信息的标签（多个用逗号分隔）',
  `creator` varchar(64) NOT NULL COMMENT '创建人',
  `display_type` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '列表展示类型 1:无图 2:一张大图 3:左图又文 4:视频5:三张图片',
  `video_uri` varchar(255) NOT NULL COMMENT 'oss视频uri',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=553 DEFAULT CHARSET=utf8mb4 COMMENT='待发布信息列表';

*/



return [

    'sql_get_list_by_page' => 'SELECT #COLUMN# FROM `info_operation` LIMIT :offset , :pageNum',

    'sql_get_total_count' => 'SELECT count(id) as count FROM `info_operation`',

    'sql_get_info_by_id' => 'SELECT  #COLUMN# FROM `info_operation` WHERE `id`=:id',

    'sql_get_info_by_ids' => 'SELECT  #COLUMN# FROM `info_operation` WHERE `id` in (:ids)',

    'sql_update_status_by_id' => 'UPDATE `info_operation` SET `status` =:infoStatus WHERE `id`=:id',

    'sql_delete_info_by_id' => 'DELETE FROM `info_operation` WHERE `id`=:id',

    'sql_delete_info_by_ids' => 'DELETE FROM `info_operation` WHERE `id` in (:ids)',

    'sql_update_info_by_id' => 'UPDATE `info_operation` SET `type_id`=:type_id, `title`=:title, `content`=:content, `description`=:description, `coverage`=:coverage, `origin_link`=:origin_link, `source`=:source, `tag`=:tag, `creator`=:creator, `display_type`=:display_type, `video_uri`=:video_uri, `updated_at`=:updated_at,`created_at`=:created_at  WHERE `id`=:id',

    'sql_insert_info' => 'INSERT into `info_operation` (`type_id`,`title`,`content`,`description`,`coverage`,`origin_link`,`source`,`status`,`tag`,`creator`,`display_type`,`video_uri`) VALUES(:type_id,:title,:content,:description,:coverage,:origin_link,:source,:status,:tag,:creator,:display_type,:video_uri)',

    'sql_get_source_list' => 'SELECT DISTINCT `source` FROM `info_operation` WHERE `status` <> 1'

];
