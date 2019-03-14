<?php
/**
 * Created by PhpStorm.
 * User: charlie
 * Date: 2018/4/8
 * Time: 上午11:29
 */

namespace manage\models\information\service\resource;

use manage\library\BizException;
use manage\library\Validation;


class Index
{

    /**
     * desc:获取资源池信息列表
     * @param $data
     * @return array|false
     * @throws BizException
     */
    public function execute($data)
    {
        $valid = new Validation($data);
        $valid->add_rules('page', 'required', 'integer', 'egt:1');
        $valid->add_rules('pageNum', 'required', 'integer', 'egt:1');
        $valid->add_rules('source', 'mb_length[1,255]');
        $valid->add_rules('rangeType', 'in[1,2,3,4]');
        $valid->add_rules('typeId', 'integer');

        if (!$valid->validate()) {
            throw new BizException(0, $valid->getErrorMsg(), BizException::PARAM_ERROR);
        }

        $resourceBo = new \manage\models\information\bo\Resource();
        $list = $resourceBo->getPagination($data);

        return $list;
    }

}