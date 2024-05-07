# SDK Quickstart Guide

Before you start using this SDK, read this requirements.

## Requirements

- Linux or Darwin OS (_Don't ask Windows please... out of my plan_)
- C/C++ Compiler
- jq
- Rust Installed
- PHP Installed
- FFI Extension is Enabled (_Why? I read the C header definition from wrapper_)

Or, you can't used this SDK.

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
    "encryptionKey" => ""
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
    'url' => 'libsql://127.0.0.1:8001', // libsql://database-org.turso.io
    'authToken' => getenv('LIBSQL_PHP_FA_TOKEN'), // your turso db token here
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
```

## Read more
- [LibSQL PHP SDK](LibSQL.md)
- [Local Example](https://github.com/darkterminal/libsql-client-php/tree/main/examples/local-file)
- [Remote Example](https://github.com/darkterminal/libsql-client-php/tree/main/examples/remote-http-sqld)
