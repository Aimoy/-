<?php
/**
 * Created by PhpStorm.
 * User: wanghaolin
 * Date: 2018/7/2
 * Time: 上午11:29
 */

namespace manage\models\statistics\service\article;

use manage\config\constant\Information;
use manage\library\BizException;
use manage\library\Validation;
use manage\models\statistics\bo\Article;

class Type
{

    public function execute($data)
    {
        $valid = new Validation($data);
        $valid->add_rules('start_day','required');
        $valid->add_rules('end_day','required');
        if (!$valid->validate()) {
            throw new BizException(BizException::PARAM_ERROR );
        }

        $static = new Article();
        $start = strtotime($data["start_day"]);
        $end = strtotime($data["end_day"]);
        $result = $static->getTypeData($start,$end);
        foreach ($result as $k => $v){
            $result[$k]['name'] = Information::$typeInfo[$v['tag_id']]['typeName'];
        }
        return $result;
    }

}