<?php

namespace manage\middlewares;

use manage\library\BizException;

/**
 * Created by PhpStorm.
 * User: zhouqing
 * Date: 2018/05/17
 * Time: 下午11:26
 */
class BearerTokenAuthMiddleware implements MiddlewareImp
{
    public $header_name = 'Authorization';

    public function handle()
    {
        \Yii::$app->user->enableSession = false;

        $request = \Yii::$app->request;
        $accessToken = $request->getHeaders()->get($this->header_name);
        $accessToken = trim(str_ireplace('Bearer', '', $accessToken));

        if (empty($accessToken)) {
            throw new BizException(BizException::TOKEN_BEARER_MISSED);
        }

        $identity = \Yii::$app->user->loginByAccessToken($accessToken);
        if ($identity !== null) {
            return $identity;
        }
        throw new BizException(BizException::TOKEN_FAIL);
    }


}