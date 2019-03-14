<?php

namespace manage\controllers\oss;


class MediaController extends \manage\controllers\MyController
{

    /**
     * 客户端向服务器上传文件完成之后, oss会想这个url方post请求
     * post 参数详见  manage/library/Oss.php line 42
     * @return \yii\web\Response
     */
    public function actionCallback()
    {
        $param['format'] = $this->post('format');
        $param['bucket'] = $this->post('bucket');
        $param['mime_type'] = $this->post('mime_type');
        $param['uri'] = $this->post('uri');
        $param['size'] = $this->post('size');
        $param['creator'] = $this->post('creator', '');
        return $this->_doFunction($param);
    }


    public function actionWx()
    {
        $url = $this->get('wx');
        $ch = curl_init();
        $httpheader = array(
            'Host' => 'mmbiz.qpic.cn',
            'Connection' => 'keep-alive',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'no-cache',
            'Accept' => 'textml,application/xhtml+xml,application/xml;q=0.9,image/webp,/;q=0.8',
            'User-Agent' => 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.89 Safari/537.36',
            'Accept-Encoding' => 'gzip, deflate, sdch',
            'Accept-Language' => 'zh-CN,zh;q=0.8,en;q=0.6,zh-TW;q=0.4'
        );
        $options = array(
            CURLOPT_HTTPHEADER => $httpheader,
            CURLOPT_URL => $url,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_RETURNTRANSFER => true
        );
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        curl_close($ch);
        header('Content-type: image/jpg');
        echo $result;
        exit;
    }

}