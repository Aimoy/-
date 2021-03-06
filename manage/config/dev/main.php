<?php
$params = array_merge(
    require __DIR__ . '/../../../common/config/params.php',
    require __DIR__ . '/params.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'manage\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=edu_toutiao',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8mb4',
        ],
        'request' => [
            'csrfParam' => '_csrf-backend',
            'enableCsrfValidation' => false,
            'cookieValidationKey' => 'dxc4dS9qoR2TwzBaO-OpoKyUZIsUAbPG',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'user' => [
            'identityClass' => 'common\models\UserManage',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'suffix' => '',
            'rules' => [
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => 'localhost',
            'port' => 6379,
            'database' => 0,
        ],
        'beanstalk' => [
            'class' => 'Pheanstalk\Pheanstalk',
            'hostname' => '127.0.0.1',
            'port' => 11300
        ],
        'mongodb' => [
            'class' => 'yii\mongodb\Connection',
            'dsn' => 'mongodb://127.0.0.1:27017/edu_toutiao',
        ],
        'oss' => [
            'class' => 'manage\library\Oss',
            'accessKeyId' => 'LTAII8iH9ai8SxUu',
            'accessKeySecret' => 'iGEJ6vuPjUtUz7F1zUb0FoCfSdHVKC',
            'callbackUrl' => 'http://47.95.121.88:8777/oss/media/callback',//DEPLOY::
            'endpoint' => 'oss-cn-beijing.aliyuncs.com',
            'endpointInternal' => 'oss-cn-beijing-internal.aliyuncs.com',
            'bucket' => 'wh-toutiao-test',//默认bucket
            'tokenExpireInSecond' => 300,
            'maxSize' => 1024 * 1024 * 20,//默认大小限制
            'imageMaxSize' => 1024 * 1024 * 5,//上传图片大小限制
            'videoMaxSize' => 1024 * 1024 * 100,//上传视频大小限制
            'bucketImage' => 'wh-toutiao-test',//图片bucket
            'bucketVideo' => 'wh-toutiao-test',//视频bucket
            'imageHost' => 'https://tt-toutiao.ministudy.com',//cname到阿里云OSS地址,突破微信封锁
            'videoHost' => 'https://tt-toutiao.ministudy.com' //cname到阿里云OSS地址,突破微信封锁
        ],
        'phantomjs' => [
            'class' => 'manage\library\phantomjs\ScreenShot',
            'h5url' => 'http://toutiaomanage.mac.ministudy.com/index.php/screenshot/index/view',//截图h5页面地址
            'phantomjs_path' => '/usr/local/bin/phantomjs'//phantomjs 二进制文件绝对路径
        ],
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'params' => $params
];