<?php

$config['bootstrap'] = $config['bootstrap'] ?? [];
$config['bootstrap'][] = 'app\modules\v1\Bootstrap';

$config['modules'] = $config['modules'] ?? [];
$config['modules']['v1'] = [
        'class' => '\app\modules\v1\Module',
];

$config['components']['request']['parsers'] = $config['components']['request']['parsers'] ?? [];
$config['components']['request']['parsers']['application/json'] = 'yii\web\JsonParser';
$config['components']['bookfinder'] = 'app\modules\v1\components\BookFinder';

$config['components']['urlManager']['rules'][] = [
    'class' => yii\rest\UrlRule::class,
    'pluralize'=>false,
    'prefix' => 'v1',
    'controller' => [
        'book' => 'v1/book',
        'books' => 'v1/book',
        'author' => 'v1/author',
        'authors' => 'v1/author',
        'language' => 'v1/language',
        'languages' => 'v1/language',
        'genre' => 'v1/genre',
        'genres' => 'v1/genre',
    ],
    'tokens' => [
        '{id}' => '<id:\\d+>',
        '{text}' => '<text:\\w+>',
        '{author}' => '<author:\\w+>',
        '{language}' => '<language:\\w+>',
        '{genre}' => '<genre:\\d+>',
        '{pages}' => '<pages:\\w+>',
    ],
    //'pluralize' => false,
    'extraPatterns' => [
        'POST' => 'create',
        'PUT {id}' => 'update',
        'PATCH {id}' => 'update',
        'DELETE {id}' => 'delete',
        'GET {id}' => 'view',
        'GET' => 'index',
    ],
];
