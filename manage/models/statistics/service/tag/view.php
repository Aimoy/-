<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/10
 * Time: 16:08
 */

namespace manage\models\statistics\service\tag;

use manage\library\BizException;
use manage\library\Validation;
use manage\models\statistics\bo\Tag;
use manage\config\constant\Information;

class View
{

    public function execute($data)
    {
        $valid = new Validation($data);
        $valid->add_rules('tag_id',"integer","between[0,9]");
        $valid->add_rules("type","integer","between[1,3]","required");
        if (!$valid->validate()) {
            throw new BizException(BizException::PARAM_ERROR );
        }
        $static = new Tag();
        $result = $static->getview($data['tag_id'],$data['type']);
        $length = count($result);
        for ($x = 0; $x < $length; $x++) {
            $result[$x]['stat_at'] = date("Y-m-d ", $result[$x]['stat_at']);
        }
        foreach ($result as $k => $v){
            $result[$k]['name'] = Information::$typeInfo[$v['tag_id']]['typeName'];
        }
        return $result;
    }




}