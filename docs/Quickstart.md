# SDK Quickstart Guide

## Installation

```bash
composer require darkterminal/libsql-client-php
```

## Local Usage

```php
<?php

use Darkterminal\LibSQL\LibSQL;

require_once 'vendor/autoload.php';

$config = [
    "url" => "file:database.db", // use in-memory database with :memory:
    "flags" => LIBSQLPHP_OPEN_READWRITE | LIBSQLPHP_OPEN_CREATE,
    "encryptionKey" => "" // optional
];

$db = new LibSQL($config);

if ($db->connect()) {
    echo "Connection Establised!" . PHP_EOL;
    echo "--- ". $db->version() ." ---" . PHP_EOL;
}
$db->close();
```

## Remote Usage

```php
<?php

use Darkterminal\LibSQL\LibSQL;
use Darkterminal\LibSQL\Types\HttpStatement;
use Darkterminal\LibSQL\Types\LibSQLResult;

require_once 'vendor/autoload.php';

$config = [
    'url' => getenv('TURSO_DATABASE_URL'), // libsql://database-org.turso.io
    'authToken' => getenv('LIBSQL_PHP_FA_TOKEN'), // your turso db token here
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
```

## Remote Replica Connection

```php
$config = [
    "url" => "file:database.db",
    "authToken" => getenv('TURSO_DATABASE_TOKEN'),
    "syncUrl" => getenv('TURSO_DATABASE_URL'),
    "syncInterval" => 5, // optional, default is 5 second
    "read_your_writes" => true // optional, default is true
];

$db = new LibSQL($config);
```

## Read more
- [LibSQL PHP SDK](LibSQL.md)
- [Local Example](https://github.com/darkterminal/libsql-client-php/tree/main/examples/local-file)
- [Remote Example](https://github.com/darkterminal/libsql-client-php/tree/main/examples/remote-http)
- [Remote Replica Example](https://github.com/darkterminal/libsql-client-php/tree/main/examples/remote-http)
