<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/16
 * Time: 13:59
 */

namespace manage\models\statistics\service\comment;

use manage\library\BizException;
use manage\library\Validation;
use manage\models\statistics\bo\Comment;

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


        $static = new Comment();
        switch ($data["actiontype"])
        {
            case 1:
                $result = $static->getPostSort($data['timetype'],$data['type']);
                break;
            case 2:
                $result = $static->getLikeSort($data['timetype'],$data['type']);
                break;
        }
        $length = count($result);
        for ($x = 0; $x < $length; $x++) {
            $article_id = $result[$x]["article_id"];
            $title_array = $static->getTitle($article_id);
            $result[$x]["title"] = $title_array["title"];
        }
        return $result;

    }

}