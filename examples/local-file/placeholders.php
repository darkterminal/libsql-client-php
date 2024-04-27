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

    $result = $db->execute(query: "SELECT * FROM users");
    var_dump($result->toArray());
}
$db->close();
