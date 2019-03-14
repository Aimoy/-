<?php
/**
 * Created by PhpStorm.
 * User: duanwei
 * Date: 2018/4/27
 * Time: 下午2:19
 */

return [

    'user_login' => [
        'key' => 'manage_token:%s', //
        'exp' => 12*60*60,
    ],
    'admin_info'=> [
        'key' => 'admin_info:%s', //
        'exp' => 24*60*60,
    ]
];