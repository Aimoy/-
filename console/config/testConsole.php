<?php

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning', 'info'],
                ],
            ],
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=172.16.225.17;dbname=edu_toutiao',
            'username' => 'qatest',
            'password' => 'C79sa26129D!',
            'charset' => 'utf8mb4',
        ],
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => '172.16.225.17',
            'port' => 6379,
            'database' => 0,
        ],
        'beanstalk' => [
            'class' => 'Pheanstalk\Pheanstalk',
            'hostname' => '172.16.225.17',
            'port' => 11300
        ],
        'mongodb' => [
            'class' => 'yii\mongodb\Connection',
            'dsn' => 'mongodb://172.16.225.17:27017/edu_toutiao',
        ],
        'oss' => [
            'class' => 'manage\library\Oss',
            'accessKeyId' => 'LTAII8iH9ai8SxUu',
            'accessKeySecret' => 'iGEJ6vuPjUtUz7F1zUb0FoCfSdHVKC',
            'callbackUrl' => 'http://183.84.12.16/oss/media/callback',//应用服务器回调地址
            'endpoint' => 'oss-cn-beijing.aliyuncs.com',
            'endpointInternal' => 'oss-cn-beijing-internal.aliyuncs.com',
            'tokenExpireInSecond' => 300,//300s后过期
            'maxSize' => 1024 * 1024 * 20,//默认大小限制
            'imageMaxSize' => 1024 * 1024 * 5,//上传图片大小限制
            'videoMaxSize' => 1024 * 1024 * 100,//上传视频大小限制
            'bucket' => 'wh-toutiao-test',//默认bucket
            'bucketImage' => 'wh-toutiao-test',//图片bucket
            'bucketVideo' => 'wh-toutiao-test',//视频bucket
            'imageHost' => 'https://tt-toutiao.ministudy.com',//cname到阿里云OSS地址,突破微信封锁
            'videoHost' => 'https://tt-toutiao.ministudy.com' //cname到阿里云OSS地址,突破微信封锁
        ],
        'phantomjs' => [
            'class' => 'manage\library\phantomjs\ScreenShot',
            'h5url' => 'http://www.toutiao-manage-api.com/screenshot/index/view',//截图h5页面地址
            'phantomjs_path' => '/usr/local/bin/phantomjs'//phantomjs 二进制文件绝对路径
        ],
    ],
    'params' => [
        'singer' => 'http://47.93.226.77:8080',
        'weapp'=>[
            'appId'=>'wx18efce761ef613ed',
            'appSecret'=>'64307daf2206880289703c09ed01a143',
        ],
    ]
    /*
    'controllerMap' => [
        'fixture' => [ // Fixture generation command line.
            'class' => 'yii\faker\FixtureController',
        ],
    ],
    */
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
