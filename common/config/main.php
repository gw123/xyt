<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language' => 'zh-CN', //主要是这个地方，设置默认语言
    'components' => [
        'log' => [
            'targets' => [
                'file' => [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['trace', 'info','error', 'warning'],
                    'categories' => ['yii\*'],
                ],
            ],
        ],
        'logger'=>[
            'class' => 'common\utils\Log',
            'serverURL'=>'xytschool.com:8080',
            'token'=>'17ky',
            'forbidden'=>false
        ],
        'task'=>[
            'class' => 'common\utils\Task',
            'serverUrl'=>'192.168.30.128',
            'port'=>'6379',
            'authPassword'=>'gao123456'
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=database.com;dbname=edu',
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8',
        ],
        'kdb' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=database.com;dbname=caiji',
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'sphinx' => [
            'class' => 'yii\sphinx\Connection',
            'dsn' => 'mysql:host=192.168.30.128;port=9309;',
            'username' => '',
            'password' => '',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'itemTable' => 'auth_item',
            'assignmentTable' => 'auth_assignment',
            'itemChildTable' => 'auth_item_child',
        ],
        'view' => [
            'class' => 'yii\web\View',
        ],

    ]

];