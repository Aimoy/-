<?php

namespace manage\controllers\oss;


class UploadController extends \manage\controllers\MyController
{

    /**
     * desc : 客户端上传文件到OSS之前需要向服务器请求,oss上传token相关东西
     */
    public function actionToken()
    {
        $param['type'] = $this->get('type', 'image');//文件上传类型,image,video
        return $this->_doFunction($param);
    }

    /**
     * 客户端向服务器上传文件完成之后, oss会想这个url方post请求,如果上传成功,这个接口返回的json会通过oss服务器转发给客户端
     * post 参数详见  manage/library/OssTokenAndCallback.php line 42
     * @return \yii\web\Response
     */
    public function actionCallback()
    {
        $param['type'] = $this->get('type');//文件上传类型,image,video,content
        return $this->_doFunction($param);
    }
}