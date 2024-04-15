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

// Simple Query and Parameter Binding Example
$query = HttpStatement::create('SELECT * FROM users WHERE name = :name', [
    'name' => 'Turso',
], true);
$results = $db->execute($query);
print_r($results);
