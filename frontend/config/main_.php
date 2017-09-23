<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/params.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'defaultRoute' => 'index/index',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        'view' => [
            'class' => 'yii\web\View',
            'renderers' => [
                'twig' => [
                    'class' => 'yii\twig\ViewRenderer',
                    'cachePath' => '@runtime/Twig/cache',
                    // Array of twig options:
                    'options' => [
                        'auto_reload' => true,
                    ],
                    'globals' => [
                        'html' => ['class' => '\yii\helpers\Html'],
                        'name' => 'Carsten',
                        'GridView' => ['class' => '\yii\grid\GridView'],
                        'Block' => ['class' => '\yii\grid\GridView'],
                    ],
                    'uses' => ['yii\bootstrap'],
                    'functions' => [
                        'truncate' => '\yii\helpers\StringHelper::truncate',
                        new \Twig_SimpleFunction('rot14', 'str_rot13'),
                        'callable_add_*' => function ($symbols, $val) {
                            return $val . $symbols;
                        },
                        'sum' => function ($a, $b) {
                            return $a + $b;
                        },
                        'block_show'=>'\frontend\twig\BlockExtension::showBlock1',
                    ],
                    'filters' => [
                        'jsonEncode' => '\yii\helpers\Json::htmlEncode',
                        new \Twig_SimpleFilter('rot13', 'str_rot13'),
                        'callable_rot13' => function($string) {
                            return str_rot13($string);
                        },
                        'add_*' => function ($symbols, $val) {
                            return $val . $symbols;
                        }
                    ],
                ],
                'php' => [
                    'class' => 'yii\smarty\ViewRenderer',
                    //'cachePath' => '@runtime/Smarty/cache',
                ],
            ],
        ],

    ],
    'params' => $params,
];


if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment

//    $config['bootstrap'][] = 'debug';
//    $config['modules']['debug'] = [
//        'class' => 'yii\debug\Module',
//    ];
//    $config['bootstrap'][] = 'gii';
//    $config['modules']['gii'] = [
//        'class' => 'yii\gii\Module',
//    ];
}
