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
use manage\library\HtmlContent;
use manage\library\Oss;
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
        $valid->add_rules('id', 'required', 'integer', 'gt:0');
        if (!$valid->validate()) {
            throw new BizException(0, $valid->getErrorMsg(), BizException::PARAM_ERROR);
        }

        $publishBo = new \manage\models\information\bo\Publish();
        $publishInfo = $publishBo->getInfoById($data['id']);


        /** @var Oss $oss */
        $oss = \Yii::$app->oss;

        $sourceName = [Information::INFO_EXTERNAL_CRAWL=>'外部抓取',Information::INFO_INTERNAL_EDIT=>'内部编辑'];
        if($publishInfo) {
            $publishInfo['type_name'] = Information::getTypeNameById($publishInfo['type_id']);
            $publishInfo['come_from_name'] = $sourceName[$publishInfo['come_from']];
            $publishInfo = (new TagBo())->convertTags($publishInfo);
            $publishInfo['coverage'] = $oss->convertCoveragesToUrlsString($publishInfo['coverage']);
            $content = $publishInfo['content_html'] ?? '';
            $content = HtmlContent::removeStyleFromImage($content);
            $publishInfo['image_srcs'] = HtmlContent::extractImageFromContent($content);
            //$publishInfo['content_html'] = $content;
        }
        return $publishInfo;
    }

}