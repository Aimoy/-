<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/11
 * Time: 17:21
 */
namespace manage\models\statistics\service\consult;

use manage\library\BizException;
use manage\library\Validation;
use manage\models\statistics\bo\Consult;
class Sort{
    public function execute($data)
    {
        $valid = new Validation($data);
        $valid->add_rules("actiontype","required","integer","between[1,3]");
        $valid->add_rules("timetype","required","integer","between[1,3]");
        $valid->add_rules("type","required","integer","between[1,2]");
        if (!$valid->validate()) {
            throw new BizException(BizException::PARAM_ERROR );
        }

        $static = new Consult();

        switch ($data["actiontype"])
        {
            case 1:
                $result = $static->getConsultData($data['timetype'],$data['type']);
                break;
            case 2:
                $result=$static->getConsultyesData($data['timetype'],$data['type']);
                break;
            case 3:
                $result = $static->getConsultnoData($data['timetype'],$data['type']);
                break;
        }
        $length = count($result);
        for ($x = 0; $x < $length; $x++) {
            $article_id = $result[$x]["article_id"];
            $title_array = $static->getTitle($article_id);
//            var_dump($title_array);die();
            $result[$x]["title"] = $title_array["title"];
        }
        return $result;
    }
}