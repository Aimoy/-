<?php
/**
 * Created by PhpStorm.
 * User: charlie
 * Date: 2018/4/8
 * Time: 上午11:29
 */

namespace manage\models\information\service\resource;

use manage\config\constant\Information;
use manage\library\BizException;
use manage\library\Validation;

class Update
{

    public function execute($data)
    {

        $create_at = $data['created_at'];
        if (strlen($create_at) > 10) {
            $ts = strtotime($create_at);
            $data['created_at'] = date('Y-m-d H:i:s', $ts);
        }


        $valid = new Validation($data);
        $valid->add_rules('_id', 'required', 'length[1,30]');
        $valid->add_rules('type_id', 'required', 'integer', 'gt:0');
        $valid->add_rules('title', 'required', 'mb_length[1,255]');
        $valid->add_rules('source', 'required', 'length[1,255]');
        $valid->add_rules('content', 'required');
        $valid->add_rules('coverage', 'length[0,1024]');
        $valid->add_rules('tag', 'required', 'mb_length[1,255]');
        $valid->add_rules('display_type', 'required', 'in[1,2,3,4,5]');
        $valid->add_rules('created_at', 'required', 'mysqlDatetime');

        if ($data['display_type'] == 4) {
            $valid->add_rules('video_uri', 'required', 'length[1,255]');
        }
        if ($data['display_type'] != 1) {
            $valid->add_rules('coverage', 'required');
        }
        if (!$valid->validate()) {
            throw new BizException(0, $valid->getErrorMsg(), BizException::PARAM_ERROR);
        }
        if ($data['display_type'] == 4 && empty($data['video_uri'])) {
            throw new BizException(0, '视频类型文章,视频地址是必填', BizException::PARAM_ERROR);
        }
        if (stripos($data['tag'], '，') !== false) {
            throw new BizException(0, 'tag分隔符必须是英文半角逗号', BizException::PARAM_ERROR);
        }

        if (!isset(Information::$typeInfo[$data['type_id']])) {
            throw new BizException(BizException::INFO_TYPE_NOT_EXIST);
        }
        $resourceBo = new \manage\models\information\bo\Resource();


        $result = $resourceBo->updateById($data);

        if ($result === false) {
            throw new BizException(BizException::INFO_UPDATE_FAIL);
        }
        return $result;
    }

}