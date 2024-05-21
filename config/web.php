<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'discover-a-drink',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'modules' => [
        'v1' => [
            'class' => 'app\modules\v1\Module',
        ],
    ],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
        '@web' => dirname(dirname(__DIR__)) . '/web'
    ],
    'defaultRoute' => 'consumer/index',
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 's3dXsgmYFWs_pQwiXGdVF6BW9YVqI_yh',
            'csrfCookie' => ['httpOnly' => true, 'secure' => true],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity', 'httpOnly' => true, 'secure' => true],
            'authTimeout' => 60 * 60 * 24 * 7,
            'enableSession' => true,
        ],
        'cookies' => [
            'class' => 'yii\web\Cookie',
            'httpOnly' => true,
            'secure' => true
        ],
        'session' => [
            'name' => 'discover',
            'class' => 'yii\web\DbSession',
            'db' => 'db',
            'sessionTable' => 'sessions',
            'cookieParams' => ['httponly' => true, 'lifetime' => 60 * 60 * 24 * 7, 'secure' => true, 'sameSite' => yii\web\Cookie::SAME_SITE_STRICT],
            'timeout' => 60 * 60 * 24 * 7, //session expire
            'useCookies' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'enableSwiftMailerLogging' => false,
            'useFileTransport' => false, //set this property to false to send mails to real email addresses
            'viewPath' => '../mail',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => $params['emailHost'],
                'port' => $params['smtpPort'],
                'username' => $params['smtpUser'],
                'password' => $params['smtpPass'],
                'encryption' => $params['encryption'],
                // 'ssl'=>['allow_self_signed'=> true,'verify_peer_name'=>false],
            ],
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
        'db' => $db,
        'api' => [
            'class' => 'app\components\Api',
        ],
        'cms' => [
            'class' => 'app\components\Cms',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [],
        ],
        'formatter' => [
            'dateFormat' => 'dd.mm.yyyy',
            'decimalSeparator' => ',',
            'thousandSeparator' => ' ',
            'currencyCode' => 'EUR',
        ],
        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'js' => [YII_DEBUG ? 'https://code.jquery.com/jquery-3.6.0.js' : 'https://code.jquery.com/jquery-3.6.0.min.js'],
                    'jsOptions' => ['type' => 'text/javascript'],
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    // 'css' => [
                    //     'bootstrap.css' => 'css/bootstrap.css'
                    // ],
                    'cssOptions' => ['type' => 'text/css'],
                ]
            ]
        ],
        'html2pdf' => [
            'class' => 'yii2tech\html2pdf\Manager',
            'viewPath' => '@app/views/',
            'converter' => [
                'class' => 'yii2tech\html2pdf\converters\Wkhtmltopdf',
                'defaultOptions' => [
                    'pageSize' => 'letter',
                    'enable-local-file-access' => true,
                    'margin-bottom' => 0,
                    'margin-left' => 0,
                    'margin-right' => 0,
                    'margin-top' => 0,
                ],
            ],
        ],
    ],
    'params' => $params,
];

// if (YII_ENV_DEV) {
//     $config['bootstrap'][] = 'debug';
//     $config['modules']['debug'] = [
//         'class' => 'yii\debug\Module',
//         'allowedIPs' => ['111.125.217.243'],
//     ];

//     $config['bootstrap'][] = 'gii';
//     $config['modules']['gii'] = [
//         'class' => 'yii\gii\Module',
//         'allowedIPs' => ['111.125.217.243'],
//     ];
// }

function p($str)
{
    echo "<pre>";
    print_r($str);

    echo "</pre>";
}
return $config;
