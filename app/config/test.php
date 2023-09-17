<?php
$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/test_db.php';
(\Dotenv\Dotenv::createUnsafeImmutable(__DIR__ . '/../'))->load();
/**
 * Application configuration shared by all test types
 */
return [
    'id' => 'basic-tests',
    'basePath' => dirname(__DIR__),
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'language' => 'en-US',
    'modules' => [
        'api' => [
            'class' => '\app\modules\v1\Module',
        ],
    ],
    'components' => [
        'db' => $db,
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
            'useFileTransport' => true,
            'messageClass' => 'yii\symfonymailer\Message'
        ],
        'assetManager' => [
            'basePath' => __DIR__ . '/../web/assets',
        ],
        'urlManager' => [
            'enablePrettyUrl'     => true,
            'showScriptName'      => false,
            'enableStrictParsing' => true,
            'rules'               => [
                ['class' => 'yii\rest\UrlRule', 'controller' => 'book'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'author'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'language'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'genre'],
                'POST loans' => 'loan/borrow',
                'GET loans' => 'loan/index'
            ],
        ],
        'user' => [
            'identityClass' => 'app\models\User',
        ],
        'request' => [
            'cookieValidationKey' => 'test',
            'enableCsrfValidation' => false,
            // but if you absolutely need it set cookie domain to localhost
            /*
            'csrfCookie' => [
                'domain' => 'localhost',
            ],
            */
        ],
    ],
    'params' => $params,
];
