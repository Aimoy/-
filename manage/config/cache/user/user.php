<?php
/**
 * Created by PhpStorm.
 * User: charlie
 * Date: 2018/4/8
 * Time: 下午3:54
 */

return [
    'user_info'=> [
        'key' => 'user_info:%s', //
        'exp' => 24*60*60,
    ],
    'user_read_history'=>[
        'key'=>'user_read_history:%s'
    ],
    'user_formid'=>[
        'key'=>'user_formid:%s',
        'exp'=>7*24*3600,
    ],
    'user_formid_list'=>[
        'key'=>'user_formid_list:%s',
    ],
];