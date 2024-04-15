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
}

// Batch Query Example
$stmts = [
    HttpStatement::create('INSERT INTO users (name, age, weight) VALUES (?, ?, ?)', ["Buku", 25, 45.5]),
    HttpStatement::create('INSERT INTO users (name, age, weight) VALUES (?, ?, ?)', ["Bahu", 26, 64.45])
];
$results = $db->batch($stmts);
print_r($results);
