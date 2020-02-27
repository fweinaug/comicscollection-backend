<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-api',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
        'response' => [
            'formatters' => [
                \yii\web\Response::FORMAT_JSON => [
                    'class' => 'yii\web\JsonResponseFormatter',
                    'prettyPrint' => YII_DEBUG, // use "pretty" output in debug mode
                    'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
                ],
            ],
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-api', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the api
            'name' => 'advanced-api',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'logFile' => '@runtime/logs/profile.log',
                    'logVars' => [],
                    'levels' => ['profile'],
                    'categories' => ['yii\db\Command::query', 'yii\db\Command::execute'],
                    'prefix' => function($message) {
                        return '';
                    }
                ]
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule', 'controller' => 'comic',
                    'extraPatterns' => [
                        'GET <id>/issues' => 'issues',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule', 'controller' => 'issue',
                    'extraPatterns' => [
                        'PUT <id>/settings' => 'settings',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'image',
                    'extraPatterns' => [
                        'GET <id>/thumbnail' => 'thumbnail',
                    ],
                ],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'publisher'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'profile'],
            ],
        ],
    ],
    'params' => $params,
];
