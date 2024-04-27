<?php

use Darkterminal\LibSQL\LibSQL;

require_once __DIR__ . '/../../vendor/autoload.php';

$config = [
    'url' => 'libsql://127.0.0.1:8001',
    'authToken' => getenv('LIBSQL_PHP_FA_TOKEN'),
    'tls' => false
];

$db = new LibSQL($config);

if ($db->connect()) {
    echo "Connection Establised!" . PHP_EOL;
    echo "--- " . $db->version() . " ---" . PHP_EOL;
}


// Simple Query and Parameter Binding Example
$query = "
UPDATE users SET name = 'Turso DB' WHERE id = 1;
UPDATE users SET name = 'ducktermin;
";
$result = $db->executeMultiple($query);
print_r($result);
