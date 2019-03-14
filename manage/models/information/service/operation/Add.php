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

class Add
{

    public function execute($data)
    {
        $valid = new Validation($data);
        $valid->add_rules('type_id', 'required', 'integer', 'gtlt[0,100]');
        $valid->add_rules('title', 'required', 'mb_length[1,255]');
        $valid->add_rules('coverage', 'length[0,1024]');
        $valid->add_rules('origin_link', 'length[1,255]');
        $valid->add_rules('source', 'required', 'mb_length[0,20]');
        $valid->add_rules('tag', 'required', 'length[0,255]');
        $valid->add_rules('display_type', 'required', 'in[1,2,3,4,5]');
        if ($data['display_type'] == 4) {
            $valid->add_rules('video_uri', 'required', 'length[1,255]');
        } else {
            //非视频文章正文可不能为空
            $data['video_uri'] = '';
            $valid->add_rules('content_html', 'required');
        }
        if ($data['display_type'] != 1) {
            $valid->add_rules('coverage', 'required');
        }
        if (!$valid->validate()) {
            throw new BizException(0, $valid->getErrorMsg(), BizException::PARAM_ERROR);
        }
        if(!isset(Information::$typeInfo[$data['type_id']])) {
            throw new BizException(BizException::INFO_TYPE_NOT_EXIST);
        }

        if (stripos($data['tag'], '，') !== false) {
            throw new BizException(0, 'tag分隔符必须是英文半角逗号', BizException::PARAM_ERROR);
        }

        $indexBo = new \manage\models\information\bo\Operation();

        $creator = \Yii::$app->user->identity->realName;
        //type_id如果是多个要以逗号分隔
        $result = $indexBo->insertInfo(
            $data['type_id'],
            $data['title'],
            $data['content_html'],
            '',
            $data['coverage'],
            $data['origin_link'],
            $data['source'],
            0,
            $data['tag'],
            $creator,
            $data['display_type'],
            $data['video_uri']
        );
        if($result == 0) {
            throw new BizException(BizException::INFO_ADD_FAIL);
        }
        return $result;
    }

}