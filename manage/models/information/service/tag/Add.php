<?php
/**
 * Created by PhpStorm.
 * User: zhouqing
 * Date: 2018/4/8
 * Time: 上午11:29
 */

namespace manage\models\information\service\tag;

use manage\library\BizException;
use manage\library\Validation;
use manage\models\information\bo\Tag;

class Add
{


    public function execute($data)
    {
        $valid = new Validation($data);
        $valid->add_rules('tag_name', 'required', 'mb_length[1,255]');
        $valid->add_rules('remark', 'mb_length[0,255]');
        $valid->add_rules('type_json', 'required', 'length[1,512]');

        if (!$valid->validate()) {
            throw new BizException(0, $valid->getErrorMsg(), BizException::PARAM_ERROR);
        }

        $tagBo = new Tag();
        return $tagBo->addTagType($data['tag_name'], $data['remark'], $data['type_json']);
    }

}