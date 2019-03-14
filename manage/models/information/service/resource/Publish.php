<?php
/**
 * Created by PhpStorm.
 * User: zhouqing
 * Date: 2018/5/22
 * Time: 上午11:29
 */

namespace manage\models\information\service\resource;

use manage\config\constant\Information;
use manage\library\BizException;
use manage\library\QueueJob;
use manage\library\Validation;
use manage\models\information\bo\Resource;

class Publish
{


    public function execute($data)
    {
        $valid = new Validation($data);
        $valid->add_rules('id', 'required', 'length[20,30]');
        if (!$valid->validate()) {
            throw new BizException(0, $valid->getErrorMsg(), BizException::PARAM_ERROR);
        }
        $resourceBo = new Resource();
        $resourcInfo = $resourceBo->getInfoById($data['id']);
        if (empty($resourcInfo)) {
            throw new BizException(0, '无效文章ID(_id)', BizException::PARAM_ERROR);
        }
        if (empty($resourcInfo['tag'])) {
            throw new BizException(0, 'tag标签不能为空文,或者章编辑未保存成功', BizException::PARAM_ERROR);
        }
        if (!isset(Information::$typeInfo[$resourcInfo['type_id']])) {
            throw new BizException(0, 'type_id分类不能为空,或者章编辑未保存成功', BizException::PARAM_ERROR);
        }
        if ($resourcInfo['status'] == 1) {
            throw new BizException(0, '文章已发布,不能重复发布', BizException::PARAM_ERROR);
        }
        $resourcInfo['creator'] = \Yii::$app->user->identity->realName;

        $res = $resourceBo->publishSpiderArticle($resourcInfo);


        if ($res > 0) {

            $res = QueueJob::addQueueJobOfGenerateArticleOssContentImage($res);
        }


        return $res;
    }

}