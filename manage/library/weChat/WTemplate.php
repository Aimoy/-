<?php
/**
 * Created by PhpStorm.
 * User: duanwei
 * Date: 2018/6/21
 * Time: 上午11:11
 */

namespace manage\library\weChat;

class WTemplate {

    const TEMPLATE_REPLY = "7QdxLaKCqBNHNXVFEN7qspnCSSwhEWB9_k1xDgUHPug";
    const TEMPLATE_ARTICLE = "4w09Nlwd5MdQ4Qrsb2DzLYtBkmYp1QbP7Tuqj_JwiWI";
    //const TEMPLATE_ARTICLE = "Qb9_kX111xeTLLJg5YVVrIxPD7K__G-OZHpVVQQLbCY";

    /**
     * 获取模版列表
     * @param $page
     * @param $pageSize
     * @return array
     */
    public static function getList($page,$pageSize)
    {
        $offset = $page>=1 ? ($page-1)*$pageSize : 0;
        $accessToken = WeChat::getAccessToken();
        $response = WeChat::curlWeChat(WeChat::METHOD_GET,"https://api.weixin.qq.com/cgi-bin/wxopen/template/list?access_token=".$accessToken,$offset,$pageSize);
        $response = json_decode($response,true);
        if(isset($response['errcode']) && $response['errcode'] == 0)
        {
            return $response['list'];
        }
        return [];
    }

    public static function pushReplyMessage($openid,$commentId,$formId,$content,$replyTime,$remark="")
    {

        $data = [];
        $data['touser'] = $openid;
        $data['template_id'] = self::TEMPLATE_REPLY;
        $data['page'] = "/pages/reply/reply?commentId=".$commentId;
        $data['form_id'] = $formId;
        $data['data']['keyword1']['value'] = $content;
        $data['data']['keyword2']['value'] = $replyTime;
        $data['data']['keyword3']['value'] = $remark;
        $response = json_decode(WeChat::curlWeChat(WeChat::METHOD_POST,"https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=:access_token",json_encode($data)),true);
        if(isset($response['errcode']) && $response['errcode']==0)
        {
            return true;
        }
        return false;

    }

    public static function pushArticle($openid,$url='pages/article/article',$url_id,$formId,$title,$sendTime,$summary)
    {
        $data = [];
        $data['touser'] = $openid;
        $data['template_id'] = self::TEMPLATE_ARTICLE;
        if($url_id){
            $data['page'] = $url."?article_id=".$url_id;
        }else{
            $data['page'] = $url;
        }

        $data['form_id'] = $formId;
        $data['data']['keyword1']['value'] = $title;
        $data['data']['keyword2']['value'] = $sendTime;
        $data['data']['keyword3']['value'] = $summary;
        $response = json_decode(WeChat::curlWeChat(WeChat::METHOD_POST,"https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=:access_token",json_encode($data)),true);
        if(isset($response['errcode']) && $response['errcode']==0)
        {
            return true;
        }
        return false;
    }
}