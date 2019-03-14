<?php

namespace manage\library;

class BizException extends \Exception
{

    // 10000~99999为系统异常预留
    //10010000开始，每隔10000一个功能模块
    //系统类型错误
    const INTER_ERROR = 10010000;
    const PARAM_ERROR = 10010001;
    const SYSTEM_NET_ERROR = 10010002;
    const OP_ERROR = 10010003;
    const OP_REMOTE = 10010004;
    const NOT_RIGHTS = 10010005;
    const CONFIG_NOT_EXIST = 10010006;

    const INFO_PUBLISH_FAIL = 10020000;
    const INFO_IS_PUBLISHED = 10020001;
    const INFO_IS_NOT_EXIST = 10020002;
    const INFO_DELETE_FAIL = 10020003;
    const INFO_UPDATE_FAIL = 10020004;
    const INFO_HAVE_SENSITIVE_WORDS = 10020005;
    const INFO_ADD_FAIL = 10020006;
    const INFO_TYPE_NOT_EXIST = 10020007;
    const INFO_CANCEL_FAIL = 10020008;
    const INFO_STATUS_CHANGE_FAIL = 10020009;
    const INFO_RESOURCE_ADD_WAIT_PART = 10020010;
    const INFO_UPDATE_MONGO_CONTENT_FAIL = 10020011;
    const INFO_CAN_NOT_BE_PUBLISHED = 10020012;
    const INFO_CAN_NOT_UPDATE_FOR_PUBLISHED = 10020013;

    //登录模块
    const TOKEN_FAIL = 10030001;
    const SESSION_FAIL = 10030002;
    const TOKEN_BEARER_MISSED = 10030003;
    const LOGIN_FAIL = 10030004;


    //图片视频上传
    const OSS_UPLOAD_FILE_FAIL = 10040000;
    const OSS_MEDIA_ADD_FAIL = 10040001;




    //版本
    const VERSION_NOT_EXISTS = 10060001;
    const VERSION_CREATE_FAIL = 10060002;
    const VERSION_UPDATE_FAIL = 10060003;
    const VERSION_CONFLICT = 10060004;


    //自定义信息
    const SELF_DEFINE = 10000000;

    //推送模块
    const SEND_TIME_FAIL = 10050001;
    const SEND_FINISH_FAIL = 10050002;
    const SEND_NOT_EXIST = 10050003;

    public static $msgs = array(
        self::SELF_DEFINE => '',
        self::INTER_ERROR => '未知错误',
        self::PARAM_ERROR => '参数错误',
        self::SYSTEM_NET_ERROR => '网络错误',
        self::OP_ERROR => '操作失败',
        self::OP_REMOTE => '',
        self::NOT_RIGHTS => '无权限',
        self::CONFIG_NOT_EXIST => '配置文件不存在',

        self::INFO_PUBLISH_FAIL => '文章发布失败',
        self::INFO_IS_PUBLISHED => '文章已发布,不能重复发布',
        self::INFO_IS_NOT_EXIST => '文章不存在',
        self::INFO_DELETE_FAIL => '文章删除失败',
        self::INFO_UPDATE_FAIL => '文章更新失败',
        self::INFO_HAVE_SENSITIVE_WORDS => '文章包含敏感词',
        self::INFO_ADD_FAIL => '文章添加失败',
        self::INFO_TYPE_NOT_EXIST => '此类型不存在',
        self::INFO_CANCEL_FAIL => '文章下架失败',
        self::INFO_STATUS_CHANGE_FAIL => '修改文章状态失败',

        self::TOKEN_FAIL => 'invalid token',
        self::TOKEN_BEARER_MISSED => '没有Bearer Auth Token',
        self::LOGIN_FAIL => '登录失败',

        self::SESSION_FAIL => 'no login',
        self::OSS_UPLOAD_FILE_FAIL => '文件通过OSS-callback方式上传失败',
        self::OSS_MEDIA_ADD_FAIL => 'Oss回调写入media表失败',
        self::INFO_RESOURCE_ADD_WAIT_PART => '资源池文章部分添加,重复添加被忽略',
        self::INFO_UPDATE_MONGO_CONTENT_FAIL => '更新mongodb文章正文失败',
        self::INFO_CAN_NOT_BE_PUBLISHED => '文章不能发布',
        self::INFO_CAN_NOT_UPDATE_FOR_PUBLISHED => '文章已经被发布,请移步已发布板块中继续编辑',


        self::SEND_TIME_FAIL => '推送时间小于当前时间',
        self::SEND_FINISH_FAIL => '已经推送过了，不能修改',
        self::SEND_NOT_EXIST => '推送消息不存在',

        self::VERSION_NOT_EXISTS => '版本不存在',
        self::VERSION_CREATE_FAIL => '版本添加失败',
        self::VERSION_UPDATE_FAIL => '版本更新失败',
        self::VERSION_CONFLICT => '版本号冲突',

    );

    public function __construct($code, $param = "", $realCode = 0)
    {
        if ($realCode <= 0) {
            $this->code = $code;
        } else {
            $this->code = $realCode;
            $this->message = $param;
            return;
        }

        $this->message = self::getErrorMsg($code);
    }

    public static function getErrorMsg($errCode)
    {
        if (isset(self::$msgs[$errCode])) {
            return self::$msgs[$errCode];
        } else {
            return self::$msgs[self::INTER_ERROR];
        }
    }
}


