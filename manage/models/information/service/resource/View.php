<?php
/**
 * Created by PhpStorm.
 * User: charlie
 * Date: 2018/4/8
 * Time: 上午11:29
 */

namespace manage\models\information\service\resource;

use manage\library\BizException;
use manage\library\HtmlContent;
use manage\library\Validation;
use manage\models\information\bo\Tag as TagBo;

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
        $valid->add_rules('id','required');
        $valid->add_rules('id', 'length[1,24]');

        if (!$valid->validate()) {
            throw new BizException(0, $valid->getErrorMsg(), BizException::PARAM_ERROR);
        }

        //$table = 'information';
        //$table/collection 变量已近在 model/dao 里面定义了,这里就不配置.

        $resourceBo = new \manage\models\information\bo\Resource();
        $resourceInfo = $resourceBo->getInfoById($data['id']);

        $resourceInfo = (new TagBo())->convertTags($resourceInfo);

        if(!$resourceInfo) {
            throw new BizException(BizException::INFO_IS_NOT_EXIST);
        }
        $resourceInfo['content'] = HtmlContent::removeStyleFromImage($resourceInfo['content']);
        return $resourceInfo;
    }

}