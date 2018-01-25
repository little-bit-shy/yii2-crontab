<?php
/**
 * 在实践中，你通常要用美观的URL并采取有优势的HTTP动词。
 * 例如，请求POST /users意味着访问user/create动作。
 * 这可以很容易地通过配置urlManager应用程序组件来完成 如下所示：
 */

return [
    'enablePrettyUrl' => true,
    'enableStrictParsing' => true,
    'showScriptName' => false,
//    'rules' => [
//        [
//            'class' => 'yii\rest\UrlRule',
//            'controller' => [
//                'v1/user',
//            ],
//        ],
//    ],
    'rules' => [
        //通用rules
        '<module:[\w-]+>/<controller:[\w-]+>/index/<page:\d+>' => '<module>/<controller>/index',
        '<module:[\w-]+>/<controller:[\w-]+>/<id:\d+>' => '<module>/<controller>/view',
        '<module:[\w-]+>/<controller:[\w-]+>/<action:[\w-]+>' => '<module>/<controller>/<action>',
    ]
];
/**
 * 相比于URL管理的Web应用程序，
 * 上述主要的新东西是通过RESTful API 请求yii\rest\UrlRule。
 * 这个特殊的URL规则类将会 建立一整套子URL规则来支持路由和URL创建的指定的控制器。
 * 例如， 上面的代码中是大致按照下面的规则:
 * [
 * 'PUT,PATCH users/<id>' => 'user/update',
 * 'DELETE users/<id>' => 'user/delete',
 * 'GET,HEAD users/<id>' => 'user/view',
 * 'POST users' => 'user/create',
 * 'GET,HEAD users' => 'user/index',
 * 'users/<id>' => 'user/options',
 * 'users' => 'user/options',
 * ]
 *
 * 您可以通过配置 only 和 except 选项来明确列出哪些行为支持，
 * 哪些行为禁用。例如，
 * [
 * 'class' => 'yii\rest\UrlRule',
 * 'controller' => 'user',
 * 'except' => ['delete', 'create', 'update'],
 * ],
 *
 * 您也可以通过配置 patterns 或 extraPatterns 重新定义现有的模式或添加此规则支持的新模式。
 * 例如，通过末端 GET /users/search 可以支持新行为 search， 按照如下配置 extraPatterns 选项，
 * [
 * 'class' => 'yii\rest\UrlRule',
 * 'controller' => 'user',
 * 'extraPatterns' => [
 * 'GET search' => 'search',
 * ],
 * ]
 *
 * nginx相关配置
 * server {
 * listen 888;
 * server_name localhost;
 * autoindex on;
 * #直接输入域名进入的目录和默认解析的文件
 * location / {
 * index index.php;
 * try_files $uri $uri/ /index.php?r=$uri&$args;
 * root /usr/local/nginx/www/vhost/www/myself/yii2-rest/web/;
 * }
 *
 * #解析.php的文件
 * location ~ \.php$ {
 * fastcgi_pass 127.0.0.1:9000;
 * fastcgi_param SCRIPT_FILENAME /usr/local/nginx/www/vhost/www/myself/yii2-rest/web/$fastcgi_script_name;
 * include fastcgi_params;
 * }
 * }
 */
