<?php

$config['controllerMap'] = $config['controllerMap'] ?? [];
$config['controllerMap']['books'] = app\modules\v1\commands\BookController::class;

$config['modules'] = $config['modules'] ?? [];
$config['modules']['v1'] = [
        'class' => '\app\modules\v1\Module',
];
