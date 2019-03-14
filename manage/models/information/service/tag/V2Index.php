<?php
/**
 * Created by PhpStorm.
 * User: charlie
 * Date: 2018/4/8
 * Time: 上午11:29
 */

namespace manage\models\information\service\tag;

use manage\library\BizException;
use manage\library\Validation;
use manage\models\information\bo\Tag;

class V2Index
{

    /**
     * desc:tag列表
     * @param $data
     * @return array|false
     */
    public function execute($data)
    {
        $valid = new Validation($data);
        $valid->add_rules('type_id', 'required', 'integer', 'gt:0');
        if (!$valid->validate()) {
            throw new BizException(0, $valid->getErrorMsg(), BizException::PARAM_ERROR);
        }
        $tagBo = new Tag();

        return $tagBo->getListV2(intval($data['type_id']));
    }

}