<?php
/**
 * Created by PhpStorm.
 * User: charlie
 * Date: 2018/4/8
 * Time: 上午11:29
 */

namespace manage\models\information\service\tag;

use manage\models\information\bo\Tag;

class Index
{

    /**
     * desc:tag列表
     * @param $data
     * @return array|false
     */
    public function execute($data)
    {
        $tagBo = new Tag();

        return $tagBo->getList();
    }

}