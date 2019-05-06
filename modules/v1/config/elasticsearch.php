<?php

if (YII_ENV_PROD) {
    return [
        'class' => \app\models\elasticsearch\Connection::className(),
        'autodetectCluster' => false,
        'nodes' => [
            [
                'protocol' => 'https',
                'http_address' => '192.168.253.133:9200',
            ],
            [
                'protocol' => 'https',
                'http_address' => '192.168.253.131:9200',
            ],
            [
                'protocol' => 'https',
                'http_address' => '192.168.253.132:9200',
            ],
        ],
        'auth' => [
            'username' => 'elastic',
            'password' => 'asdfgh'
        ]
    ];
} else if (YII_ENV_TEST) {
    return [
        'class' => \app\models\elasticsearch\Connection::className(),
        'autodetectCluster' => false,
        'nodes' => [
            [
                'protocol' => 'https',
                'http_address' => '192.168.253.133:9200',
            ],
            [
                'protocol' => 'https',
                'http_address' => '192.168.253.131:9200',
            ],
            [
                'protocol' => 'https',
                'http_address' => '192.168.253.132:9200',
            ],
        ],
        'auth' => [
            'username' => 'elastic',
            'password' => 'asdfgh'
        ]
    ];
} else if (YII_ENV_DEV) {
    return [
        'class' => \app\models\elasticsearch\Connection::className(),
        'autodetectCluster' => false,
        'nodes' => [
            [
                'protocol' => 'https',
                'http_address' => '192.168.253.133:9200',
            ],
            [
                'protocol' => 'https',
                'http_address' => '192.168.253.131:9200',
            ],
            [
                'protocol' => 'https',
                'http_address' => '192.168.253.132:9200',
            ],
        ],
        'auth' => [
            'username' => 'elastic',
            'password' => 'asdfgh'
        ]
    ];
}
