<?php

use Darkterminal\LibSQL\LibSQL;
use Darkterminal\LibSQL\Types\HttpStatement;
use Darkterminal\LibSQL\Types\LibSQLResult;

require_once __DIR__ . '/../../vendor/autoload.php';

$config = [
    'url' => 'libsql://127.0.0.1:8001',
    'authToken' => getenv('LIBSQL_PHP_FA_TOKEN'),
    'tls' => false
];

$db = new LibSQL($config);

if ($db->connect()) {
    echo "Connection Establised!" . PHP_EOL;
    echo "--- ". $db->version() ." ---" . PHP_EOL;
}


// Simple Query
$query = HttpStatement::create(sql: 'SELECT name, id FROM users LIMIT 5');
$results = $db->execute(query: $query);
echo $results->fetch(type: LibSQLResult::FETCH_OBJ) . PHP_EOL;
// print_r($results->fetch(type: LibSQLResult::FETCH_ASSOC));
