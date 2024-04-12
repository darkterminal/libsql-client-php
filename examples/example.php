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

$query = HttpStatement::create('SELECT * FROM users WHERE name = :name OR age = $age OR weight = @weight', [
    'name' => 'Turso',
    'age' => 30,
    'weight' => 51.02
]);
$results = $db->client->execute($query, true);
print_r($results);
