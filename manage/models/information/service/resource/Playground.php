<?php
/**
 * Created by PhpStorm.
 * User: zhouqing
 * Date: 2018/5/9
 * Time: 上午11:29
 */

namespace manage\models\information\service\resource;

use manage\library\BizException;
use manage\library\HtmlContent;
use manage\library\mongoDB\MongoDB;
use yii\mongodb\Query;

class Playground
{

    /**
     * desc:批量将资源池(mongodb)的文章添加到待发布(mysql)中
     * @param $data array
     * @return array|false|int
     * @throws BizException
     */
    public function execute($data)
    {
        if ($_GET['awesome'] !== 'awesome') {
            return '密码错误';
        }
        $mgd = (new MongoDB('published'));
        $mg = (new Query())->from('published');
        $contentArr = $mg->all();
        $res = count($contentArr);
        foreach ($contentArr as $vv) {
            $content = HtmlContent::removeStyleFromImage($vv['content']);
            $_id = $vv['_id']->__toString();
            $code = $mgd->updateContentById($_id, $content);
            $res--;
        }
        return $res;
    }

}