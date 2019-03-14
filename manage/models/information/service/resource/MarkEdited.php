<?php
/**
 * Created by PhpStorm.
 * User: zhouqing
 * Date: 2018/05/30
 * Time: 上午11:29
 */

namespace manage\models\information\service\resource;

use manage\library\BizException;
use manage\library\Validation;

/**
 * 标记已读
 * Class MarkEdited
 * @package manage\models\information\service\resource
 */
class MarkEdited
{

    public function execute($data)
    {
        $valid = new Validation($data);
        $valid->add_rules('id', 'required');

        if (!$valid->validate()) {
            throw new BizException(0, $valid->getErrorMsg(), BizException::PARAM_ERROR);
        }

        $resourceBo = new \manage\models\information\bo\Resource();
        $result = $resourceBo->markEdited($data['id']);

        if ($result === false) {
            throw new BizException(BizException::INFO_DELETE_FAIL);
        }
        return $result;
    }

}