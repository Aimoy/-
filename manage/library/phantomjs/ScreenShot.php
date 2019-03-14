<?php

namespace manage\library\phantomjs;

use manage\library\BizException;

class ScreenShot
{
    /** @var string 获取phantomjs 参数中 js文件的决定路径 */
    private $js_path;
    /** @var bool|string 获取php 有777权限的临时文件目录 */
    private $temp_dir;

    public $h5url;

    public $phantomjs_path;
    function __construct()
    {
        $dir = __DIR__;
        $this->js_path = "{$dir}/script.js";
        /** @var bool|string 获取php 有777权限的临时文件目录 */
        $this->temp_dir = \Yii::getAlias('@runtime');

    }

    /**
     * 只截取分享稳重标题正文 不包含二维码
     */
    public function shotArticleContentThenUploadToOss($article_id): \stdClass
    {
        $url = "{$this->h5url}?article_id={$article_id}&post_id=0";
        $filename = "article_{$article_id}.jpg";

        //if ($result === false) {
        $json = $this->screenShotThenSaveToOss($url, $filename);
        $json->h5url = $url;
        return $json;
        //}
    }


    /**
     * 截图并上传
     * @param string $url
     * @param string $filename
     * @return \stdClass
     * @throws BizException
     */
    public function screenShotThenSaveToOss(string $url, string $filename = 'temp.jpg'): \stdClass
    {
        //输出图片的路径
        $outputFilePath = "{$this->temp_dir}/$filename";
        //执行的phantomjs命令
        // 必须是绝对路径/usr/local/bin/phantomjs
        $cmd = "{$this->phantomjs_path} {$this->js_path} '$url' '$outputFilePath' ";
        //捕捉不到phantomjs命令输出结果
        exec($cmd, $output);
        //检查截图文件是否存在
        $isShotImgaeExist = file_exists($outputFilePath);
        if (!$isShotImgaeExist) {
            throw new BizException(0, implode(',', $output), BizException::SELF_DEFINE);
        }
        if (in_array('page load failed!', $output)) {
            throw new BizException(0, implode(',', $output), BizException::SELF_DEFINE);
        }
        //保存截图到oss
        $result = $this->postScreenShotImageToOss($outputFilePath, $filename);
        $result->phantomjs_log = $output;
        //删除临时文件夹的截图图片
        @unlink($outputFilePath);
        return $result;
    }


    /**
     * 上传截图到阿里云直传oss
     * @param string $screenshot_path
     * @param $ossKey
     * @return \stdClass
     * @throws BizException
     */
    public function postScreenShotImageToOss(string $screenshot_path, $ossKey): \stdClass
    {

        $oss = \Yii::$app->oss;
        $creator = 'shooter';
        $tokenArray = $oss->generateToken('shot', 'contentshot', $creator);

        $file = new \CURLFile($screenshot_path, 'image/jpg', 'file');
        $url = $tokenArray['host'];
        $postData = [
            'key' => "{$tokenArray['dir']}/$ossKey",
            'policy' => $tokenArray['policy'],
            'OSSAccessKeyId' => $tokenArray['accessid'],
            'success_action_status' => '200',
            'signature' => $tokenArray['signature'],
            'callback' => $tokenArray['callback'],
            'file' => $file
        ];
        $ch = curl_init();
        //$data = array('name' => 'Foo', 'file' => '@/home/user/test.png');
        curl_setopt($ch, CURLOPT_URL, $url);
        // Disable SSL verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SAFE_UPLOAD, true); // required as of PHP 5.6.0
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);

        $body = curl_exec($ch);
        $res = json_decode($body);
        curl_close($ch);
        if (empty($res) || $res->code != 0) {
            throw new BizException(0, '截图上传oss失败:' . $body, BizException::SELF_DEFINE);
        } else {
            return $res;
        }
    }
}

