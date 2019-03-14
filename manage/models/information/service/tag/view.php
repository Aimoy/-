<?php
/**
 * Created by PhpStorm.
 * User: zhouqing
 * Date: 2018/4/8
 * Time: 上午11:29
 */

namespace manage\models\information\service\tag;

use manage\models\information\bo\Tag;

class View
{


    public function execute($data)
    {
        $tagBo = new Tag();
        $id = intval($data['id']);
        return $tagBo->getById($id);
    }

}