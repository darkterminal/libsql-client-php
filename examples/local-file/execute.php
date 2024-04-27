<?php

use Darkterminal\LibSQL\LibSQL;

require_once __DIR__ . '/../../vendor/autoload.php';

$config = [
    "url" => "file:database.db",
    "flags" => LIBSQLPHP_OPEN_READWRITE | LIBSQLPHP_OPEN_CREATE,
    "encryptionKey" => ""
];

$db = new LibSQL($config);

if ($db->connect()) {
    echo "Connection Establised!" . PHP_EOL;
    echo "--- ". $db->version() ." ---" . PHP_EOL;

    $result = $db->execute(query: "INSERT INTO users (name) VALUES (?)", params: ['Belina Bogge']);
    var_dump($result);
}
$db->close();
