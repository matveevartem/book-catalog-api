<?php

return [
    'components' => [
        'cache' => [
            'class' => 'yii\redis\Cache',
            'redis' => [
                'hostname' => '172.72.54.3',
                'port' => 6379,
                'database' => 0,
            ]
        ],
    ],
    'params' => [
        'redisHostname' => '172.72.54.3', // redis host
    ],

];