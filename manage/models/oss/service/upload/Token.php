<?php
/**
 * Created by PhpStorm.
 * User: zhouqing
 * Date: 2018/05/03
 * Time: 上午15:29
 */

namespace manage\models\oss\service\upload;


use manage\library\Oss;

class Token
{

    public $array = [];

    public function execute($data)
    {
        /** @var Oss $oss */
        $oss = \Yii::$app->oss;
        $creator = \Yii::$app->user->identity->realName;

        $response = $oss->generateToken($data['type'], null, $creator);

        return $response;
    }

}