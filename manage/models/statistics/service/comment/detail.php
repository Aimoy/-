<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/16
 * Time: 1:07
 */
namespace manage\models\statistics\service\comment;
use manage\config\constant\Information;
use manage\library\BizException;
use manage\library\Validation;
use manage\models\statistics\bo\Comment;
class Detail{
    public function execute($data)
    {
        $valid = new Validation($data);
        $valid->add_rules('type','required');
        $valid->add_rules('tag_id','required');
        if (!$valid->validate()) {
            throw new BizException(BizException::PARAM_ERROR );
        }

        $static = new Comment();
        $result = $static->getDetail($data['type'],$data['tag_id']);
        foreach ($result as $k => $v){
            $result[$k]['name'] = Information::$typeInfo[$v['tag_id']]['typeName'];
        }
        return $result;
    }
}