<?php
/**
 * Created by PhpStorm.
 * User: zhouqing
 * Date: 2018/6/19
 * Time: 下午8:27
 */

namespace manage\models\screenshot\service\index;

use manage\library\BizException;
use manage\library\phantomjs\ScreenShot;
use manage\library\Validation;
use yii\db\Query;

class Shot
{

    public function execute($data)
    {

        $valid = new Validation($data);
        $valid->add_rules('article_id', 'required', 'integer');
        $valid->add_rules('post_id', 'required', 'integer');
        $valid->add_rules('page', 'required');
        if (!$valid->validate()) {
            throw new BizException(BizException::PARAM_ERROR);
        }
        if (empty($data['user_id'])) {
            $user_id = \Yii::$app->user->identity->id;
        } else {
            $user_id = $data['user_id'];
        }
        $page = $data['page'];
        $article_id = $data['article_id'];
        $post_id = $data['post_id'];

        $h5url = \Yii::$app->params['screen_shot_h5'];
        $url = "{$h5url}?article_id={$article_id}&user_id={$user_id}&page={$page}&post_id={$post_id}";
        $filename = "{$page}_{$article_id}_{$post_id}_{$user_id}.png";
        $filename = str_ireplace('/', '_', $filename);

        $result = $this->_isScreenShotInOss($filename);
        if ($result === false) {
            $phantomjs = new ScreenShot();
            return $phantomjs->screenShotThenSaveToOss($url, $filename);
        }

        return $result;
    }

    private function _isScreenShotInOss($filename)
    {
        $row = (new Query())->from('media')->andWhere(['uri' => $filename])->one();
        if (empty($row)) {
            return false;
        }
        $image_oss_host = \Yii::$app->params['oss_corveray'];
        return "{$image_oss_host}{$filename}";
    }
}