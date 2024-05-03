<?php

use Darkterminal\LibSQL\LibSQL;

require_once __DIR__ . '/../../vendor/autoload.php';

$config = [
    "url" => "file:database.db",
    "authToken" => getenv('TURSO_DATABASE_TOKEN'),
    "syncUrl" => getenv('TURSO_DATABASE_URL'),
    "syncInterval" => 5,
    "read_your_writes" => true
];

$db = new LibSQL($config);

if ($db->connect()) {
    echo "Connection Establised!" . PHP_EOL;
    echo "--- ". $db->version() ." ---" . PHP_EOL;
}
$db->close();
