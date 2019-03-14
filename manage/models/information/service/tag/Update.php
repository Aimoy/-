<?php
/**
 * Created by PhpStorm.
 * User: zhouqing
 * Date: 2018/4/8
 * Time: 上午11:29
 */

namespace manage\models\information\service\tag;

use manage\config\constant\Information;
use manage\library\BizException;
use manage\library\Validation;
use manage\models\information\bo\Tag;

class Update
{

    /**
     * desc:tag列表
     * @param $data
     * @return array|false
     */
    public function execute($data)
    {
        $valid = new Validation($data);
        $valid->add_rules('tag_name', 'required', 'mb_length[1,255]');
        $valid->add_rules('remark', 'mb_length[0,255]');
        $valid->add_rules('is_default', 'required', 'in[0,1]');
        $valid->add_rules('type_id', 'required', 'integer', 'gt:0');
        if (!$valid->validate()) {
            throw new BizException(0, $valid->getErrorMsg(), BizException::PARAM_ERROR);
        }
        if (!isset(Information::$typeInfo[$data['type_id']])) {
            throw new BizException(0, 'type_id错误', BizException::PARAM_ERROR);
        }
        $res = (new Tag())->updateById($data['id'], $data['tag_name'], $data['remark'], $data['is_default'],
            $data['type_id']);
        return $res;
    }

}