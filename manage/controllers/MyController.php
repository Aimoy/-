<?php
/**
 * Created by PhpStorm.
 * User: charlie
 * Date: 2018/4/3
 * Time: 下午8:58
 */
namespace manage\controllers;

use manage\library\BizException;
use Yii;
use yii\web\Controller;

class MyController extends Controller
{
    /** @var  \yii\web\Request */
    protected $request;
    protected $route;
    protected $env;

    public function init()
    {
        parent::init();
        //{{host}}/information/resource/index?pageNum=
        //修复导致$_GET['pageNum'] 为空字符串,yii get 方法不能赋默认值
        //$_GET = array_filter($_GET);
        $this->request = Yii::$app->request;
        $this->route = $this->module->requestedRoute;


        $this->executeMiddleware();
    }

    private function executeMiddleware()
    {

        $middleConf = require SHARE.'middleware.php';
        if (!$middleConf)
            return null;

        list($module, $controller, $action) = explode('/', $this->route);

        if(!isset($middleConf[$module]))
            return null;
        $exceptArr = $middleConf[$module]['controller'];
        if (in_array($controller, array_keys($exceptArr))) {
            if (!$exceptArr[$controller])
                return null;
            if (in_array($action, $exceptArr[$controller]))
                return null;
        }

        if (in_array($controller, $exceptArr) || in_array($action, $exceptArr))
            return null;

        $moduleRules = $middleConf[$module]['rules'];

        try {
            foreach ($moduleRules as $v) {
                call_user_func(array(new $v, 'handle'), $this->request);
            }

        } catch (BizException $e) {
            exit($this->r($e->getCode(),  $e->getMessage(), null )->send());

        }

    }

    protected function get($name, $default = null)
    {
        return $this->request->get($name, $default);
    }

    protected function post($name, $default = null)
    {
        return $this->request->post($name, $default);
    }

    protected function _doFunction($param, $jsonp = false, $callback = 'callback')
    {
        list($module, $controller, $action) = explode('/', $this->route);

        $action = stripos($action, '-') ?
            array_reduce(explode('-',$action), function($v1, $v2) {
            return ucfirst($v1).ucfirst($v2);}) : $action;

        $spaceArr = explode("\\",$this->module->controllerNamespace);
        $spaceName = isset($spaceArr[0]) ? $spaceArr[0] : "";
        $className = "\\".$spaceName."\\models\\".$module."\\service\\".$controller."\\".ucfirst($action);

        $service = new $className();
        $result = null;
        try{
            $result = $service->execute($param);

        }catch( \Exception $e) {

            //todo errorCode <99999 为系统异常 需要报警
            if (YII_ENV == 'dev') {
                $result = $e->getTraceAsString();
            }

            return $this->r($e->getCode(),  $e->getMessage(), $result );
        }

        return $this->r( 0,  'success', $result );
    }

    public function r($code, $msg, $data)
    {
        if( ! is_array($data) ) {
            $newData['result'] = $data;
            $data = $newData;
        }

        $res = [
            'code' => intval($code),
            'msg'  => $msg,
            'data' => $data,
        ];

        return $this->asJson($res);

//        return new JsonResponse($res,200,[], JSON_UNESCAPED_UNICODE);
//        return new JsonResponse($res,200);
    }

}