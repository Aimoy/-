<?php
/**
 * Created by PhpStorm.
 * User: wanghaolin
 * Date: 2018/6/20
 * Time: 下午4:10
 */

return [

    'sql_get_by_user_id' => 'SELECT `openid` FROM `user` WHERE id=:user_id LIMIT 1',

    'sql_get_by_openid' => 'SELECT `id` FROM `user` WHERE openid=:openid LIMIT 1',

];
