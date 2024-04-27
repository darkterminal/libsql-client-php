<?php

use Darkterminal\LibSQL\LibSQL;
use Darkterminal\LibSQL\Types\HttpStatement;

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

// Batch Query Example
$stmts = [
    HttpStatement::create(sql: 'INSERT INTO users (name, age) VALUES (?, ?)', args: ["Ramons", 32]),
    HttpStatement::create(sql: 'INSERT INTO users (name, age) VALUES (?, ?)', args: ["Georgia", 43])
];
$results = $db->batch(queries: $stmts);
print_r($results);
