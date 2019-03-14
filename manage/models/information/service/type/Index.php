<?php
/**
 * Created by PhpStorm.
 * User: charlie
 * Date: 2018/4/8
 * Time: 上午11:29
 */

namespace manage\models\information\service\type;

use manage\config\constant\Information;

class Index
{

    /**
     * desc:获取信息类型列表
     * @param $data
     * @return array|false
     */
    public function execute($data)
    {
        $data = Information::$typeInfo;
        $temp = [];
        foreach ($data as $key => $vo) {
            if ($key !== 0) {
                $vo['id'] = $key;
                $temp[] = $vo;
            }
        }
        return $temp;
    }

}