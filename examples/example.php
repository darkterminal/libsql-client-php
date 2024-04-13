<?php

use Darkterminal\LibSQL\LibSQL;
use Darkterminal\LibSQL\Types\HttpStatement;

require_once __DIR__ . '/../vendor/autoload.php';

$config = [
    'url' => 'libsql://127.0.0.1:8001',
    'tls' => false
];

$db = new LibSQL($config);

if ($db->client->connect()) {
    echo "Connection Establised!" . PHP_EOL;
}

// Batch Query Example
$stmts = [
    HttpStatement::create('INSERT INTO users (name, age, weight) VALUES (?, ?, ?)', ["Ika", 10, 25.5]),
    HttpStatement::create('INSERT INTO users (name, age, weight) VALUES (?, ?, ?)', ["Biku", 6, 19.45])
];
$results = $db->client->batch($stmts);
print_r($results);

// Simple Query and Parameter Binding Example
// $query = HttpStatement::create('SELECT * FROM users WHERE name = :name OR age = $age OR weight = @weight', [
//     'name' => 'Turso',
//     'age' => 30,
//     'weight' => 51.02
// ], true);
// $results = $db->client->execute($query);
// print_r($results);
