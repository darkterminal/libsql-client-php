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

// Start a new transaction
$transaction = $db->startTransaction();

// Add the first SQL statement to the transaction
if (true) {
    $transaction->addTransaction(HttpStatement::create("UPDATE users SET name = 'Turso DB' WHERE id = 1"));
} else {
    // If a condition is not met, rollback the transaction and exit
    $transaction->rollback();
    exit();
}

// Add the second SQL statement to the transaction
if (true) {
    $transaction->addTransaction(HttpStatement::create("UPDATE users SET name = 'darkterminal' WHERE id = 2"));
} else {
    // If another condition is not met, rollback the transaction and exit
    $transaction->rollback();
    exit();
}

// End the transaction (commit changes)
$result = $transaction->endTransaction();
print_r($result);
