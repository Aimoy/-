<?php
/**
 * Created by PhpStorm.
 * User: charlie
 * Date: 2018/4/8
 * Time: 上午11:29
 */

namespace manage\models\information\service\publish;

use manage\config\constant\Information;
use manage\library\BizException;
use manage\library\Validation;

class Index
{

    /**
     * desc:获取已发布信息列表
     * @param $data
     * @return array|false
     * @throws BizException
     */
    public function execute($data)
    {
        $valid = new Validation($data);
        $valid->add_rules('page', 'integer', 'egt:1');
        $valid->add_rules('pageNum', 'integer', 'egt:1');
        $valid->add_rules('rangeType', 'in[1,2,3,4]');
        $valid->add_rules('typeId', 'integer', 'egt:1');

        if (!empty($data['typeId']) && !isset(Information::$typeInfo[$data['typeId']])) {
            throw new BizException(BizException::INFO_TYPE_NOT_EXIST);
        }
        if (!$valid->validate()) {
            throw new BizException(0, $valid->getErrorMsg(), BizException::PARAM_ERROR);
        }

        $publishBo = new \manage\models\information\bo\Publish();

        $data = $publishBo->getPagination($data);

        $sourceName = [Information::INFO_EXTERNAL_CRAWL=>'外部抓取',Information::INFO_INTERNAL_EDIT=>'内部编辑'];
        foreach ($data['result'] as $key => $info) {
            $data['result'][$key]['type_name'] = Information::getTypeNameById($info['type_id']);
            $data['result'][$key]['come_from_name'] = $sourceName[$info['come_from']];
            unset($data['result'][$key]['content']);
        }

        return $data;
    }

}