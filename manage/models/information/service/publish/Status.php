<?php
/**
 * Created by PhpStorm.
 * User: charlie
 * Date: 2018/4/8
 * Time: 上午11:29
 */

namespace manage\models\information\service\publish;

use manage\library\BizException;
use manage\library\Validation;
use manage\models\information\bo\Publish;
use manage\models\information\dao\InfoPublish;

/**
 * 改变已发布文章状态
 * Class Status
 * @package manage\models\information\service\publish
 */
class Status
{

    public function execute(array $data): int
    {
        $valid = new Validation($data);
        $valid->add_rules('id', 'required', 'integer');
        $valid->add_rules('status', 'required', 'in[0,1,2]');

        if (!$valid->validate()) {
            throw new BizException(0, $valid->getErrorMsg(), BizException::PARAM_ERROR);
        }

        $publishDao = new InfoPublish();
        $publishInfo = $publishDao->getInfoById($data['id']);

        if(!$publishInfo) {
            throw new BizException(BizException::INFO_IS_NOT_EXIST);
        }
        $result = (new Publish())->updateInfoStatus($data['id'], $data['status']);

        if ($result === false) {
            throw new BizException(BizException::INFO_STATUS_CHANGE_FAIL);
        }
        return $result ?? 0;
    }

}