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
        'sendTimeout' => 5, // колл-во секунд для ожидания ответа от url
        'redirectCount' => 5, // кол-во редиректов при запросе к url
        'queryCount' => 500, // кол-во запросов перед блокировкой url
        'timePeriod' => 24 * 3600, // время в минутах для изменения времени последнего обновления
        'redisHostname' => '172.72.54.3', // redis host
    ],

];