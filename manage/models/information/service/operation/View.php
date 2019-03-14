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
use manage\models\information\bo\Tag;

class View
{

    /**
     * desc:获取某条信息详情
     * @param $data
     * @return array|false
     * @throws BizException
     */
    public function execute($data)
    {
        $valid = new Validation($data);
        $valid->add_rules('id', 'integer', 'gt:0', 'length[1,11]');

        if (!$valid->validate()) {
            throw new BizException(0, $valid->getErrorMsg(), BizException::PARAM_ERROR);
        }
        $indexBo = new \manage\models\information\bo\Operation();
        $waitInfo = $indexBo->getInfoById($data['id']);

        $waitInfo = (new Tag())->convertTags($waitInfo);

        $waitInfo['type_name'] = Information::getTypeNameById($waitInfo['type_id']);
        return $waitInfo;
    }

}