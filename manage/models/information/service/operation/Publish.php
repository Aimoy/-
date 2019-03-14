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
use manage\library\QueueJob;
use manage\library\Validation;
use yii;

class Publish
{


    public function execute($data)
    {
        $valid = new Validation($data);
        $valid->add_rules('id', 'required', 'integer', 'egt:1', 'length[1,20]');


        if (!$valid->validate()) {
            throw new BizException(0, $valid->getErrorMsg(), BizException::PARAM_ERROR);
        }

        $infoWaitBo = new \manage\models\information\bo\Operation();
        $waitInfo = $infoWaitBo->getInfoById($data['id']);

        if ($waitInfo['status'] == Information::INFO_STATUS_PUBLISH) {
            throw new BizException(BizException::INFO_IS_PUBLISHED);
        }

        if (empty($waitInfo['tag'])) {
            throw new BizException(0, '标签不能为空', BizException::PARAM_ERROR);
        }
        if (!isset(Information::$typeInfo[$waitInfo['type_id']])) {
            throw new BizException(0, '分类不能为空', BizException::PARAM_ERROR);
        }
        if ($waitInfo['status'] == 1) {
            throw new BizException(0, '文章已发布,不能重复发布', BizException::PARAM_ERROR);
        }


        $publishBo = new \manage\models\information\bo\Publish();;
        $trans = Yii::$app->db->beginTransaction();
        try {
            //设置待发布文章为已发布
            $result = $infoWaitBo->updateInfoStatus($data['id']);
            $result = $publishBo->insertInfo(
                $waitInfo['type_id'],
                $waitInfo['title'],
                $waitInfo['content_html'],
                '',//文章描述已没有
                $waitInfo['coverage'],
                $waitInfo['origin_link'],
                $waitInfo['source'],
                2, 0, 0, 0, 0,
                $waitInfo['tag'],
                $waitInfo['creator'],
                $waitInfo['display_type'],
                $waitInfo['video_uri'],
                $waitInfo['created_at']
            );
            //添加文章到推荐redis里面
            $publishBo->addInfoRecommendIds($result, $waitInfo['tag']);
            $trans->commit();
        } catch (\Exception $e) {
            $trans->rollBack();
            throw $e;
        }
        if ($result > 0) {
            QueueJob::addQueueJobOfGenerateArticleOssContentImage($result);
        }
        return $result;
    }

}