<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/12
 * Time: 15:34
 */
namespace manage\models\statistics\service\consult;

use manage\library\BizException;
use manage\library\Validation;
use manage\models\statistics\bo\Consult;
class Search{
    public function execute($data)
    {
        $valid = new Validation($data);

        $valid->add_rules('articleid','required');
        $valid->add_rules('start_day','required');
        $valid->add_rules('end_day','required');
        $valid->add_rules('actiontype','required');
        if (!$valid->validate()) {
            throw new BizException(BizException::PARAM_ERROR );
        }

        $static = new Consult();
        switch ($data["actiontype"])
        {
            case 1: //表示是咨询事件的查询pv，uv
//                $static->getconsultSearch()
                $result = $static->getconsultSearch($data['articleid'],$data['start_day'],$data['end_day']);
                break;
            case 2:
                $result = $static->getSearch_byauth($data['articleid'],$data['start_day'],$data['end_day']);
                break;
            case 3:
                $result = $static->getSearch_byunauth($data['articleid'],$data['start_day'],$data['end_day']);
                break;
        }
        $length = count($result);
        for ($x = 0; $x < $length; $x++) {
            $result[$x]['stat_at'] = date("Y-m-d ", $result[$x]['stat_at']);
            $article_id = $data['articleid'];
            $title_array = $static->getTitle($article_id);
            $result[$x]["title"] = $title_array["title"];
        }
        return $result;
    }
}



