<?php
/**
 * Created by PhpStorm.
 * User: zhouqing
 * Date: 2018/05/07
 * Time: 上午15:29
 */

namespace manage\models\oss\service\media;


use manage\library\BizException;
use manage\library\Oss;
use manage\library\Validation;
use manage\models\oss\bo\Media;

class Callback
{
    public function execute($data)
    {
        $valid = new Validation($data);
        $valid->add_rules('uri', 'required');
        if (!$valid->validate()) {
            throw new BizException(BizException::OSS_UPLOAD_FILE_FAIL);
        }
        $mediaBo = new Media();
        $dataDB = $mediaBo->findByOssKey($data);
        if (empty($dataDB)) {
            $result = $mediaBo->insertInfo($data);
            if ($result < 1) {
                throw new BizException(BizException::OSS_MEDIA_ADD_FAIL);
            }
        }

        /** @var Oss $oss */
        $oss = \Yii::$app->oss;

        if ($data['bucket'] == $oss->bucketImage) {
            $host = $oss->imageHost;
        }
        if ($data['bucket'] == $oss->bucketVideo) {
            $host = $oss->videoHost;
        }
        $data['oss_host'] = $host;
        $data['url'] = "{$host}/{$data['uri']}";
        return $data;
    }

}