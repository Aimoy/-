<?php
/**
 * Created by PhpStorm.
 * User: zhouqing
 * Date: 2018/05/03
 * Time: 下午2:03
 */

namespace manage\models\oss\bo;


use manage\models\BaseBo;

class Media extends BaseBo
{

    public function insertInfo($data)
    {
        //TODO::需不要验证URI字段的唯一性?
        return (new \manage\models\oss\dao\Media())->insertInfo(
            $data['uri'],
            $data['format'],
            $data['mime_type'],
            $data['size'],
            $data['bucket'],
            $data['creator']
        );
    }

    public function findByOssKey($data)
    {
        return (new \manage\models\oss\dao\Media())->getMediaByKey($data['uri']);
    }
}
