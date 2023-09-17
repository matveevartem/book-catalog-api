<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'pgsql:host=' . getenv('DB') .';port=' . getenv('DB_PORT') . ';dbname=' . getenv('DB_NAME'),
    'username' => getenv('DB_USERNAME'),
    'password' => getenv('DB_PASSWORD'),
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
