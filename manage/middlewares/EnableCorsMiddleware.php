<?php
/**
 * Created by PhpStorm.
 * User: ericzhou
 * Date: 18/5/21
 * Time: 15:05
 */

namespace manage\middlewares;

class EnableCorsMiddleware implements MiddlewareImp
{
    /**
     * 添加跨域中间件
     */
    public function handle()
    {
        header('Access-Control-Allow-Origin:*');
        header("Access-Control-Allow-Headers: Authorization, Origin, X-Requested-With, Content-Type, Accept");
        header("Access-Control-Allow-Methods: OPTIONS, GET, PUT, POST, DELETE");
        header('Access-Control-Max-Age: 3600');
        $request = \Yii::$app->request;
        if ($request->isOptions) {
            exit();
        }

    }
}