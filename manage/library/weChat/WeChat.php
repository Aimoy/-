<?php
/**
 * Created by PhpStorm.
 * User: duanwei
 * Date: 2018/6/19
 * Time: 上午11:23
 */
namespace manage\library\weChat;

use linslin\yii2\curl\Curl;
use manage\library\BizException;
use manage\library\ConfigParse;
use Predis\Client;
use yii\db\Command;

class WeChat extends Command{

    public static $retry=0; //重试次数

    const METHOD_GET = "GET";
    const METHOD_POST = "POST";

    const ACCESS_TOKEN = "access_token";

    public static function getRedis()
    {
        $redisConf = \Yii::$app->components['redis'];
        $config = [
            'host' => $redisConf['hostname'],
            'port' => $redisConf['port'],
            'database' => $redisConf['database'],

        ];
        if (isset($redisConf['password']))
            $config['password'] = $redisConf['password'];

        return new Client($config);
    }

    public static function getAccessToken()
    {
        $redis = self::getRedis();
        if($accessToken = $redis->get(self::ACCESS_TOKEN))
        {
            return $accessToken;
        }else{
            $record = \Yii::$app->db->createCommand(ConfigParse::parseSql('weChat.token.sql_get_by_time','*'))
                ->queryOne();
            if($record == false){
                return self::requestToken();
            }
            $redis->set(self::ACCESS_TOKEN,$record['access_token']);
            $redis->expire(self::ACCESS_TOKEN,strtotime($record['expires_in'])-time());
            return $record['access_token'];
        }
    }

    /**
     * 微信专用curl
     * @param $method
     * @param $url
     * @param array $postData
     * @return bool|mixed
     */
    public static function curlWeChat($method,$url,$postData=[])
    {
        $originUrl = $url;
        if(strstr($url,":access_token"))
        {
            $url = str_replace(":access_token",self::getAccessToken(),$url);
        }
        if($method == self::METHOD_GET){
            $curl = new Curl();
            $response = $curl->setGetParams($postData)->get($url);
        }elseif($method == self::METHOD_POST){
            $curl = new Curl();
            if(is_array($postData)){
                $response = $curl->setPostParams($postData)->post($url);
            }else{
                $response = $curl->setRawPostData($postData)->post($url);
            }

        }else{
            return false;
        }
        if($data = json_decode($response,true)){
            if(isset($data['errcode']) && $data['errcode'] == 40001){
                $record = \Yii::$app->db->createCommand(ConfigParse::parseSql('weChat.token.sql_get_by_time','*'))
                    ->queryOne();
                if(isset($record['access_token']) && $record['access_token'] != self::getAccessToken()){    //如果redis存的和db最新不一致，则刷新redis
                    $redis = self::getRedis();
                    $redis->set(self::ACCESS_TOKEN,$record['access_token']);
                    $redis->expire(self::ACCESS_TOKEN,strtotime($record['expires_in'])-time());

                    return call_user_func(__NAMESPACE__ .'\WeChat::curlWeChat',$method,$originUrl,$postData);
                }else{  //如果不存在可用的或者最新的也失效，则刷新
                    self::$retry++;
                    if(self::$retry <=1){
                        self::requestToken();
                        return call_user_func(__NAMESPACE__ .'\WeChat::curlWeChat',$method,$originUrl,$postData);
                    }
                }
            }
        }
        return $response;
    }

    private static function requestToken()
    {
        $response = self::curlWeChat(self::METHOD_GET,"https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".\Yii::$app->params['weapp']['appId']."&secret=".\Yii::$app->params['weapp']['appSecret']);
        $data=json_decode($response,true);
        if (isset($data['access_token'])) {
            $params = ['access_token'=>$data['access_token'],'expires_in'=>date("Y-m-d H:i:s",time()+$data['expires_in'])];
            \Yii::$app->db->createCommand(ConfigParse::parseSql('weChat.token.sql_insert_token'))->bindValues($params)->execute();
            $redis = self::getRedis();
            $redis->set(self::ACCESS_TOKEN,$data['access_token']);
            $redis->expire(self::ACCESS_TOKEN,$data['expires_in']-300);
            return $data['access_token'];
        }
        return "";
    }

    public static function getQrCode($scene,$page,$width)
    {
        $response = self::curlWeChat(self::METHOD_POST,"https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=:access_token",json_encode(['scene'=>$scene,'page'=>$page,'width'=>$width]));
        return $response;
    }

    public static function getQrCodeBase64($scene, $page, $width = 430)
    {
        $binString = WeChat::getQrCode($scene, $page, $width);
        if ($data = json_decode($binString)) {
            throw new BizException(0, $data->errmsg, BizException::SELF_DEFINE);
        }
        $base64 = 'data:image/png' . ';base64,' . base64_encode($binString);
        return $base64;
    }


}