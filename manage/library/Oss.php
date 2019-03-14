<?php
/**
 * Created by PhpStorm.
 * User: zhouqing
 * Date: 18/5/4
 * Time: 15:35
 */

namespace manage\library;


/**
 * 阿里云oss 客户端直接上传文件 服务器产生token 和 设置服务器回调地址
 * 参考阿里云文档: https://help.aliyun.com/document_detail/31927.html?spm=a2c4g.11186623.6.634.LZ4dIj
 * oss 发送的我们服务器的参数文档 https://help.aliyun.com/document_detail/31989.html?spm=a2c4g.11186623.6.908.oX8n7k
 * 客户端使用方法 https://help.aliyun.com/document_detail/31927.html?spm=a2c4g.11186623.6.634.LZ4dIj 详见demo代码
 * POST-FORM API https://help.aliyun.com/document_detail/31988.html?spm=a2c4g.11186623.6.908.31LqCG
 * Class Oss
 * @package manage\library
 */
class Oss
{
    public $accessKeyId;
    public $accessKeySecret;

    public $bucket;
    public $bucketImage;
    public $bucketVideo;

    public $endpoint;
    public $endpointInternal;
    public $callbackUrl;
    public $tokenExpireInSecond = 180;
    public $maxSize = 1024 * 1024 * 100;
    public $imageMaxSize;
    public $videoMaxSize;

    public $imageHost;
    public $videoHost;

    const WX_IMAGE_HOST = 'mmbiz.qpic.cn';

    /**
     * 客户端请求oss上传token
     * @param string $type image/video/fetch
     * @param null $dir oss bucket中的文件夹路径
     * @return array
     * @throws BizException
     */
    public function generateToken(string $type = 'image', string $dir = null, $creator = 'temp-user'): array
    {
        //date_default_timezone_set('Asia/Shanghai');

        $dir = $dir ?: date('Y_m_d');

        switch ($type) {
            case 'shot':
                $this->bucket = $this->bucketImage;
                $this->maxSize = 1024 * 1024 * 10;
                break;
            case 'image':
                $this->bucket = $this->bucketImage;
                $this->maxSize = $this->imageMaxSize;
                break;
            case 'video':
                $this->bucket = $this->bucketVideo;
                $this->maxSize = $this->videoMaxSize;
                break;
            case 'fetch':
                //服务器内部调用
                $this->maxSize = $this->imageMaxSize;
                $this->bucket = $this->bucketImage;
                break;
            default:
                throw new BizException(BizException::SELF_DEFINE, 'oss产生token方法参数错误', BizException::SELF_DEFINE);
        }
        //将变量$id设成AccessKeyId，$key设置成AccessKeySecret。
        //$id= '6MKOqxGiGU4AUk44';
        //$key= 'ufu7nS8kS59awNihtjSonMETLI0KLy';
        //$host设置成 bucket+endpoint
        $host = "https://{$this->bucket}.{$this->endpoint}";
        //$callbackUrl = "http://oss-demo.aliyuncs.com:23450";


        $callback_param = array(
            'callbackUrl' => $this->callbackUrl,
            'callbackBody' => 'bucket=${bucket}&uri=${object}&size=${size}&mime_type=${mimeType}&format=${imageInfo.format}&creator=' . $creator,
            'callbackBodyType' => "application/x-www-form-urlencoded"
        );
        $callback_string = json_encode($callback_param);
        $base64_callback_body = base64_encode($callback_string);

        $now = time();
        //$expire = 30; //设置该policy超时时间是10s. 即这个policy过了这个有效时间，将不能访问
        $end = $now + $this->tokenExpireInSecond;
        $expiration = self::gmt_iso8601($end);

        //$dir = 'user-dir/';
        //最大文件大小.用户可以自己设置
        $condition = array(0 => 'content-length-range', 1 => 0, 2 => $this->maxSize);
        $conditions[] = $condition;

        //表示用户上传的数据,必须是以$dir开始, 不然上传会失败,这一步不是必须项,只是为了安全起见,防止用户通过policy上传到别人的目录
        if ($type != 'fetch') {
            //video image 限制当天日期做文件夹
            //fetch 就不限制文件夹
            $start = array(0 => 'starts-with', 1 => '$key', 2 => $dir);
            $conditions[] = $start;
        } else {
            //TODO::先使用oss的外部地址,服务器上在使用oss内部地址
            //$host = "http://{$this->bucket}.{$this->endpointInternal}";
            $dir = '';
        }


        $arr = array('expiration' => $expiration, 'conditions' => $conditions);
        //echo json_encode($arr);
        //return;
        $policy = json_encode($arr);
        $base64_policy = base64_encode($policy);
        $string_to_sign = $base64_policy;
        $signature = base64_encode(hash_hmac('sha1', $string_to_sign, $this->accessKeySecret, true));

        $response = array();
        $response['accessid'] = $this->accessKeyId;
        $response['host'] = $host;
        $response['policy'] = $base64_policy;
        $response['signature'] = $signature;
        $response['expire_timestamp'] = $end;
        $response['expire_time'] = $expiration;
        $response['server_time'] = date('Y-m-d H:i:s');

        $response['callback'] = $base64_callback_body;
        //这个参数是设置用户上传指定的前缀
        $response['dir'] = $dir;
        //echo json_encode($response);
        $response['maxSize'] = $this->maxSize;
        return $response;
    }

    /**
     * 时间格式化帮助函数
     * @param $time
     * @return string
     */
    static private function gmt_iso8601($time): string
    {
        $dtStr = date("c", $time);
        $mydatetime = new \DateTime($dtStr);
        $expiration = $mydatetime->format(\DateTime::ISO8601);
        $pos = strpos($expiration, '+');
        $expiration = substr($expiration, 0, $pos);
        return $expiration . "Z";
    }

    public function getOssImageHost(): string
    {
        return "{$this->bucketImage}.{$this->endpoint}";
    }

    /**
     * 下载图片到oss
     * @param string $image_src
     * @return string 返回https oss 地址
     * @throws BizException
     */
    public function fetchImageSrcToOss(string $image_src): string
    {
        $image_src = self::filterImgUrl($image_src);
        if (empty($image_src)) {
            //不复制图片
            return '';
        }
        $ossKey = self::parseImageUrlToUniquePath($image_src);
        if (empty($ossKey)) {
            //oss 不复制图片
            return '';
        }
        $runtimeDir = \Yii::getAlias('@runtime');
        $downloadedImagePath = $runtimeDir . '/' . $ossKey;

        try {
            $imageFile = $this->getImageContent($image_src);
        } catch (\Exception $e) {
            throw new BizException(0, 'sunlands服务器:::下载图片失败,请重新编辑更换图片', BizException::SELF_DEFINE);
        }

        //服务器没有扩展 下面一行被注释
        //$file_info = new \finfo(FILEINFO_MIME_TYPE);
        $mime_type = 'image/jpeg';
        $res = file_put_contents($downloadedImagePath, $imageFile);
        unset($imageFile);
        if ($res === false) {
            throw new BizException(BizException::SELF_DEFINE, '图片下载写入centos-yii2-临时目录失败', BizException::SELF_DEFINE);
        }
        $file = new \CURLFile($downloadedImagePath, $mime_type, $ossKey);
        $creator = \Yii::$app->user->identity->realName;
        $tokenArray = $this->generateToken('fetch', null, $creator);
        $url = $tokenArray['host'];
        $postData = [
            'key' => $ossKey,
            'policy' => $tokenArray['policy'],
            'OSSAccessKeyId' => $tokenArray['accessid'],
            'success_action_status' => '200',
            'signature' => $tokenArray['signature'],
            'callback' => $tokenArray['callback'],
            'file' => $file
        ];
        $ossUrl = self::phpCurlPostWithFile($url, $postData);
        @unlink($downloadedImagePath);
        return $ossUrl;
    }

    /**
     * php curl 向oss发送文件上传
     * @param string $url
     * @param array $data
     * @return mixed
     */
    static function phpCurlPostWithFile(string $url, array $data): string
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SAFE_UPLOAD, true); // required as of PHP 5.6.0
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
        $res = curl_exec($ch);
        $res = json_decode($res);
        curl_close($ch);
        if (empty($res) || $res->code != 0) {
            return '';
        } else {
            return $res->data->url;
        }
    }

    /**
     * 过滤不需要转存到oss的图片,图片地址进行清理
     * @param string $url
     * @return string
     */
    static function filterImgUrl(string $url): string
    {
        //uri地址过滤
        if (stripos($url, 'http') === false) {
            return '';
        }
        $middleManApi = \Yii::$app->params['imageMiddleManApi'];
        //清除图片中转地址
        $url = str_ireplace($middleManApi, '', $url);
        /** @var Oss $oss */
        $oss = \Yii::$app->oss;
        $ossHost = preg_replace('#https?://#', '', $oss->imageHost);

        //对尚德oss地址过滤 不转存到oss
        return stripos($url, $ossHost) === false ? $url : '';

    }

    /**
     * 把图片地址转换成 unique uri 地址 同时确保占用长度最小, 和微信图片一一对应
     * @param string $url
     * @return string
     */
    static function parseImageUrlToUniquePath(string $url): string
    {
        /** @var Oss $oss */
        $oss = \Yii::$app->oss;
        $host = parse_url($url, PHP_URL_HOST);
        $urlPath = parse_url($url, PHP_URL_PATH);
        $urlPath = trim($urlPath, '/');

        if (stripos($host, 'qpic.cn') !== false) {
            //微信图片
            $paths = explode('/', $urlPath);
            $path_count = count($paths);
            if ($path_count < 2) {
                //微信图片地址错误,不镜像
                return '';
            }
            $ff = str_ireplace('mmbiz_', '', $paths[0]);
            return "$paths[1].$ff";
        } elseif (stripos($oss->getOssImageHost(), $host) !== false) {
            //sunlands oss 图片
            return '';
        } else {
            //其他网站图片host+path进行base64
            $temp = $host . $urlPath;
            return base64_encode($temp);
        }
    }

    /**
     * 封面地址转换成oss地址
     * @param string $coverage
     * @return array
     */
    public function convertCoveragesToUrls(string $coverage): array
    {
        $tempArray = explode(',', $coverage);
        $temp = [];
        foreach ($tempArray as $uri) {
            if (stripos($uri, 'http') === false) {
                $temp[] = "{$this->imageHost}/$uri";
            } else {
                $temp[] = trim($uri);
            }
        }
        return $temp;
    }

    /**
     * 封面图片转换成以逗号分隔url地址
     * @param string $coverage
     * @return string
     */
    public function convertCoveragesToUrlsString(string $coverage): string
    {
        $arr = $this->convertCoveragesToUrls($coverage);
        return implode(',', $arr);
    }

    public function getImageContent($url){
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
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_RETURNTRANSFER => true
        );
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}
