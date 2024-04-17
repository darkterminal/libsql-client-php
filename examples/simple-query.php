<?php

use Darkterminal\LibSQL\LibSQL;
use Darkterminal\LibSQL\Types\HttpStatement;
use Darkterminal\LibSQL\Types\LibSQLResult;

require_once __DIR__ . '/../vendor/autoload.php';

$config = [
    'url' => 'libsql://127.0.0.1:8001',
    'tls' => false
];

$db = new LibSQL($config);

if ($db->connect()) {
    echo "Connection Establised!" . PHP_EOL;
    echo "--- ". $db->version() ." ---" . PHP_EOL;
}


// Simple Query and Parameter Binding Example
$query = HttpStatement::create('SELECT name, id FROM users LIMIT 5');
$results = $db->execute($query);
echo $results->fetch(LibSQLResult::FETCH_OBJ) . PHP_EOL;
// print_r($results->fetch(LibSQLResult::FETCH_ASSOC));
