<?php
/**
 * Created by PhpStorm.
 * User: charlie
 * Date: 2018/4/8
 * Time: 上午11:29
 */

namespace manage\models\information\service\operation;

use manage\config\constant\Information;
use manage\library\BizException;
use manage\library\Validation;

class Index
{

    /**
     * desc:获取待发布信息列表
     * @param $data
     * @return array|false
     * @throws BizException
     */
    public function execute($data)
    {
        $valid = new Validation($data);
        $valid->add_rules('page', 'integer', 'gt:0');
        $valid->add_rules('pageNum', 'integer', 'egt:1');
        $valid->add_rules('rangeType', 'integer', 'gtlt[0,5]');
        $valid->add_rules('typeId', 'integer', 'gtlt[0,100]');
        //$valid->add_rules('source', 'integer','gt:0');

        if (!$valid->validate()) {
            throw new BizException(0, $valid->getErrorMsg(), BizException::PARAM_ERROR);
        }
        if (!empty($data['typeId']) && !isset(Information::$typeInfo[$data['typeId']])) {
            throw new BizException(BizException::INFO_TYPE_NOT_EXIST);
        }
        $indexBo = new \manage\models\information\bo\Operation();
        $data = $indexBo->getOperationArticlePagination($data['page'], $data['pageNum'], $data['rangeType'],
            $data['typeId'],
            $data['source']);

        foreach ($data['result'] as $key => $info) {
            $typeName = Information::getTypeNameById($info['type_id']);
            $data['result'][$key]['type_name'] = $typeName;
        }
        return $data;
    }

}