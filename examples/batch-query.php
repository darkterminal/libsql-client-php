<?php

use Darkterminal\LibSQL\LibSQL;
use Darkterminal\LibSQL\Types\HttpStatement;

require_once __DIR__ . '/../vendor/autoload.php';

$config = [
    'url' => 'libsql://127.0.0.1:8001',
    'tls' => false
];

$db = new LibSQL($config);

if ($db->connect()) {
    echo "Connection Establised!" . PHP_EOL;
    echo "--- " . $db->version() . " ---" . PHP_EOL;
}

// Batch Query Example
$stmts = [
    HttpStatement::create('INSERT INTO users (name, age, weight) VALUES (?, ?, ?)', ["Ramons", 32, 45.5]),
    HttpStatement::create('INSERT INTO users (name, age, weight) VALUES (?, ?, ?)', ["Georgia", 43, 64.45])
];
$results = $db->batch($stmts);
print_r($results);
