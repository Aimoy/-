<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/16
 * Time: 0:33
 */
namespace manage\models\statistics\service\comment;
use manage\config\constant\Information;
use manage\library\BizException;
use manage\library\Validation;
use manage\models\statistics\bo\Comment;
class Post{
    public function execute($data)
    {
        $valid = new Validation($data);
        $valid->add_rules('type','required');
        $valid->add_rules('tag_id','required');
        if (!$valid->validate()) {
            throw new BizException(BizException::PARAM_ERROR );
        }

        $static = new Comment();
        $result = $static->getPost($data['type'],$data['tag_id']);
        foreach ($result as $k => $v){
            $result[$k]['name'] = Information::$typeInfo[$v['tag_id']]['typeName'];
        }
        return $result;
    }
}