<?php
/**
 * Created by PhpStorm.
 * User: wanghaolin
 * Date: 2018/7/2
 * Time: 上午11:29
 */

namespace manage\models\statistics\service\article;

use manage\library\BizException;
use manage\library\Validation;
use manage\models\statistics\bo\Article;

class Sort
{

    public function execute($data)
    {
        $valid = new Validation($data);
        $valid->add_rules('type','required');
        $valid->add_rules('timetype','required');
        $valid->add_rules('actiontype','required');
        if (!$valid->validate()) {
            throw new BizException(BizException::PARAM_ERROR );
        }

//        $title = new \manage\models\statistics\bo\Consult();
        $static = new Article();
        switch ($data["actiontype"])
        {
            case 1:
                $result = $static->getviewsort($data['timetype'],$data['type']);
                break;
            case 2:
                $result=$static->getsharesort($data['timetype'],$data['type']);
                break;
            case 3:
                $result = $static->getlikesort($data['timetype'],$data['type']);
                break;
        }
        return $result;
    }

}