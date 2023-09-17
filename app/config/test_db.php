<?php

$db = require __DIR__ . '/db.php';

$db['dsn'] .= '_test';

return $db;
