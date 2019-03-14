<?php
/**
 * Created by PhpStorm.
 * User: zhouqing
 * Date: 2018/05/07
 * Time: 下午3:54
 */

return [

    'sql_get_by_id' => 'SELECT #COLUMN# FROM version_control WHERE id=:id LIMIT 1',

    'sql_get_count_by_id' => 'SELECT count(1) as count FROM version_control WHERE id=:id',

    'sql_get_total' => 'SELECT count(1) as count FROM version_control',

    'sql_get_count_by_version' => 'SELECT count(1) as count FROM version_control WHERE version=:version',

    'sql_update_by_id' => 'UPDATE version_control SET version=:version,status=:status,remark=:remark,updated_at=:updated_at WHERE id=:id',

    'sql_delete_by_ids'=> 'DELETE FROM version_control WHERE id IN (:ids)',

    'sql_get_all_list' => 'SELECT #COLUMN# FROM version_control ORDER BY created_at DESC LIMIT :limit',


];