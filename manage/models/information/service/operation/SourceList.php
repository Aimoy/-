<?php
/**
 * Created by PhpStorm.
 * User: zhouqing
 * Date: 2018/5/21
 * Time: 上午11:29
 */

namespace manage\models\information\service\operation;

use manage\models\information\bo\Operation;


class SourceList
{

    /**
     * 获取爬虫的来源列表(爬取公众号列表)
     */
    public function execute($data)
    {
        $list = (new Operation())->getSourceList();
        return array_column($list, 'source');
    }
}