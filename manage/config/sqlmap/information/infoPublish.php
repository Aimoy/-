<?php
/**
 * Created by PhpStorm.
 * User: charlie
 * Date: 2018/4/8
 * Time: 下午3:54
 */

/*

CREATE TABLE `info_published` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '已发布文章ID',
  `type_id` int(4) unsigned NOT NULL DEFAULT '0' COMMENT '分类ID',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
  `content` varchar(255) NOT NULL DEFAULT '' COMMENT 'mongo.edu_toutiao.wait._id',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '信息内容简述（将信息内容截取前50个字放入此字段中）',
  `coverage` varchar(511) NOT NULL DEFAULT '' COMMENT '文章封面,ossURI多个以逗号分隔',
  `origin_link` varchar(255) NOT NULL DEFAULT '' COMMENT '原始链接',
  `source` varchar(20) NOT NULL DEFAULT '1' COMMENT '来源网站名称',
  `come_from` tinyint(4) unsigned NOT NULL DEFAULT '1' COMMENT '来源（1：外部抓取；2：内部编辑）',
  `share_count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '分享转发数',
  `like_count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '点赞推荐数',
  `comment_count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '评论数',
  `status` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '信息状态（0：正常；1：删除；2：下架）',
  `tag` varchar(32) NOT NULL DEFAULT '' COMMENT '信息的标签（多个用逗号分隔）',
  `creator` varchar(64) NOT NULL COMMENT '创建人',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `display_type` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '列表展示类型 1:无图 2:一张大图 3:左图右文 4:视频5:三张图片',
  `video_uri` varchar(255) NOT NULL DEFAULT '' COMMENT 'oss视频uri',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='已发布信息列表';

 */
return [

    'sql_get_list_by_page' => 'SELECT #COLUMN# FROM info_published LIMIT :offset , :pageNum',

    'sql_get_total_count' => 'SELECT count(id) as count FROM `info_published`',

    'sql_get_info_by_id' => 'SELECT  #COLUMN# FROM info_published WHERE `id`=:id',

    'sql_delete_info_by_id' => 'DELETE FROM info_published WHERE `id`=:id',

    'sql_update_status_by_id' => 'UPDATE info_published SET `status` =:status WHERE id=:id',

    'sql_update_info_by_id' => 'UPDATE info_published SET `type_id`=:type_id,`title`=:title,`content`=:content,`coverage`=:coverage,`source`=:source,`share_count`=:share_count,`like_count`=:like_count,`comment_count`=:comment_count,`read_count`=:read_count,`tag`=:tag,`updated_at`=:updated_at,`display_type`=:display_type,`video_uri`=:video_uri,`created_at`=:created_at,`status` =:status WHERE `id`=:id',

    'sql_insert_info' => 'INSERT into info_published(`type_id`,`title`,`content`,`description`,`coverage`,`origin_link`,`source`,`come_from`,`share_count`,`like_count`,`comment_count`,`status`,`tag`,`creator`,`created_at`,`display_type`,`video_uri`) VALUES(:type_id,:title,:content,:description,:coverage,:origin_link,:source,:come_from,:share_count,:like_count,:comment_count,:status,:tag,:creator,:created_at,:display_type,:video_uri)',

    'sql_update_like_Count' => 'UPDATE info_published SET like_count=like_count+:like_count,updated_at=:updated_at WHERE id=:id',

    'sql_get_source_list' => 'SELECT DISTINCT `source` FROM `info_published`'
];