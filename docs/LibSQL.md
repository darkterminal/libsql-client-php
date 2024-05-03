# LibSQL

The main class for interacting with the LibSQL service. This class provides functionality for creating an HTTP client and Local client based on the provided configuration. It supports different URL schemes such as "file:", "libsql:", "https:", and "http:". It also handles errors related to unsupported URL schemes and TLS configurations.

## Instanciated

This constructor initializes a new instance of LibSQL based on the provided configuration. It supports both local and remote connections.

For a **local connection**, an example configuration includes specifying a file URL along with flags for opening the database file. Encryption key can also be provided if needed.

For a **remote connection**, the configuration includes the URL of the remote server, an authentication token, and an optional TLS flag.

The constructor throws a `LibsqlError` if there's an issue creating the HTTP client or if the provided URL scheme is not supported. It distinguishes between remote and local connections and sets up the appropriate provider accordingly.

```php
public function __construct(array $config)
```

**Parameters:**

- `$config`: The configuration array for the LibSQL service.

**Example Local Connection**

```php
<?php
$config = [
    "url" => "file:database.db",
    "flags" => LIBSQLPHP_OPEN_READWRITE | LIBSQLPHP_OPEN_CREATE,
    "encryptionKey" => ""
];

$db = new LibSQL($config);
```

**Example Remote Connection**

```php
<?php
$config = [
    'url' => 'libsql://127.0.0.1:8001', // libsql://database-origanization.turso.io
    'authToken' => getenv('LIBSQL_PHP_FA_TOKEN'),
    'tls' => false
];

$db = new LibSQL($config);
```

**Example Remote Replica Connection**

```php
$config = [
    "url" => "file:database.db",
    "authToken" => getenv('TURSO_DATABASE_TOKEN'),
    "syncUrl" => getenv('TURSO_DATABASE_URL'),
    "syncInterval" => 5,
    "read_your_writes" => true
];

$db = new LibSQL($config);
```

## Connection

This method `connect()` establishes a connection to the database based on the mode set during the initialization of the LibSQL instance. It throws a `LibsqlError` if the connection mode is not recognized.

For a remote connection, it delegates the connection task to the HTTP provider's `connect()` method. For a local connection, it uses the local provider's `connect()` method.

If the connection mode is neither remote nor local, it throws an error indicating that the connection mode is not found.

**Return**
- `bool` - If `true` connection is establish, `false` connection failed.

```php
public function connect(): bool
```

## Version

This method `version()` retrieves the version information of the database based on the connection mode set during the initialization of the LibSQL instance. If the connection mode is not recognized, it throws a `LibsqlError`.

For a remote connection, it delegates the task to the HTTP provider's `version()` method. For a local connection, it uses the local provider's `version()` method.

If the connection mode is neither remote nor local, it throws an error indicating that the connection mode is not found.

```php
public function version(): string
```

**Return**
- `string` The version information of the database.

## Executes a Query

This method `execute()` allows you to execute a query either locally or remotely based on the connection mode set during the initialization of the LibSQL instance. It supports both local and remote execution.

For a remote execution, you can provide an instance of `HttpStatement` representing the query along with an optional baton value. The method returns an instance of `HttpResponse` containing the result of the execution.

For a local execution, you provide the query as a string and optionally an array of parameters. It returns true if the execution is successful.

If the connection mode is neither remote nor local, it throws an error indicating that the connection mode is not found.

```php
public function execute(string|HttpStatement $query, string $baton = '', array $params = []): LibSQLPHPClientResult|HttpResponse
```

> **NOTE: Use _Named Paramaters_ is recommended**

**Remote Parameters**

- `$query`
    - `HttpStatement` - **[Remote Only]** Parameter used for Remote connection only - [Ref:HttpStatement](https://github.com/darkterminal/libsql-client-php/blob/main/src/Types/HttpStatement.php) / Doc: [Doc:HttpStatement](https://github.com/darkterminal/libsql-client-php/blob/main/docs/Types/HttpStatement.md)
- `$baton`
    - `string` - **[Remote Only]** The baton value for the query.

**Remote Return**

- `HttpResponse` - **[Remote Only]** instance of `HttpResponse` for remote mode - [Ref:HttpResponse](https://github.com/darkterminal/libsql-client-php/blob/main/src/Types/HttpResponse.php) / Doc: [Doc:HttpResponse](https://github.com/darkterminal/libsql-client-php/blob/main/docs/Types/HttpResponse.md)

**Remote Usage Example**

```php
$query = HttpStatement::create(sql: 'SELECT name, id FROM users LIMIT 5');
$results = $db->execute(query: $query);
echo $results->fetch(type: LibSQLResult::FETCH_OBJ) . PHP_EOL;
```

**Local Paramaters**

- `$query`
    - `string` - **[Local only]** Parameter used for Local connection only
- `$params`
    - `array` - **[Local Only]** Parameters for the query.

**Local Return**

- `LibSQLPHPClientResult` - **[Local Only]** Parameters for the query. - [Ref:LibSQLPHPClientResult](https://github.com/darkterminal/libsql-php-ext/blob/main/src/Responses/LibSQLPHPClientResult.php)

**Local Usage Example**

```php
$result = $db->execute(query: "INSERT INTO users (name) VALUES (?)", params: ['Belina Bogge']);
var_dump($result);
```

## (Remote) Executes a batch of queries

> 💡 **NOTE: THIS INTERACTIVE TRANSACTIONS HAVE HIGHER LATENCY** <br/><br/>
> _In this operation, you will send as many HTTP Requests as the total array you defined. If the batch array has 2 rows of values as in the example, then this operation will send 2 HTTP Requests._

This method `batch()` executes a batch of queries **exclusively for remote connections**. It supports different transaction behavior modes such as deferred (default), write, and read.

The method expects an array of HTTP statements representing the queries to execute. Each HTTP statement should be created using the `HttpStatement::create()` method, specifying the SQL query and any parameters.

An optional `$mode` parameter allows you to specify the transaction behavior mode, with the default being "deferred". You can use lowercase mode names or constants from the `TransactionMode` class.

It's important to note that this method is only available for remote (HTTP) connections. If called for a local connection, it will throw a `LibsqlError`.

The method returns an HTTP response containing the result of the batch execution. You can refer to the [Ref:HttpResponse](https://github.com/darkterminal/libsql-client-php/blob/main/src/Types/HttpResponse.php) class for more information on the structure of the response.

```php
public function batch(array $queries, string $mode = "deferred"): HttpResponse
```

> 💡 **NOTE: Remote Only**

**Parameters**
- `$querys` - The array of queries to execute.
- `$mode` - (Optional) The transaction behavior mode. Default is "deferred"

Mode Options Available:
- deferred (default)
- write
- read

Everyting is in lower-case or you can use `TransactionMode` Class Constants

**Return**
- `HttpResponse` - The HTTP response containing the result of the batch execution. - [Ref:HttpResponse](https://github.com/darkterminal/libsql-client-php/blob/main/src/Types/HttpResponse.php)

**Example - [Ref:Example](https://docs.turso.tech/sdk/http/reference#interactive-query)**

```php
$stmts = [
    HttpStatement::create(sql: 'INSERT INTO users (name, age) VALUES (?, ?)', args: ["Ramons", 32]),
    HttpStatement::create(sql: 'INSERT INTO users (name, age) VALUES (?, ?)', args: ["Georgia", 43])
];
$results = $db->batch(queries: $stmts);
print_r($results);
```

## (Local) Executes a batch of queries

This method `execute_batch()` executes a batch of queries exclusively for local (file) connections. It allows you to execute multiple SQL statements in a single batch.

The method expects a string parameter `$query`, which represents the batch query to execute. This query can contain multiple SQL statements separated by semicolons.

It's important to note that this method is only available for local (file) connections. If called for a remote connection, it will throw a `LibsqlError`.

The method does not return any value (void), as it simply executes the batch query.

```php
public function execute_batch(string $query): void
```


**Example**

```php
<?php
$db->execute_batch("
    BEGIN;
    CREATE TABLE foo(x INTEGER);
    CREATE TABLE bar(y TEXT);
    COMMIT;
");
```

## Executes multiple SQL queries in a single HTTP request

This method `executeMultiple()` allows you to execute multiple SQL queries in a single HTTP request, specifically designed for remote connections only.

The method expects a string parameter `$query`, which represents the SQL queries to execute. These queries should be separated by semicolons.

It's important to note that this method is only available for remote (HTTP) connections. If called for a local connection, it will throw a `LibsqlError`.

The method returns a string containing the response from executing the queries.

```php
public function executeMultiple(string $query): string
```

**Example**

```php
<?php
$query = "
UPDATE users SET name = 'Turso DB' WHERE id = 1;
UPDATE users SET name = 'ducktermin;
";
$result = $db->executeMultiple($query);
print_r($result);
```
Refs:
- [Ref:http.ts Implementation](https://github.com/tursodatabase/libsql-client-ts/blob/main/packages/libsql-client/src/http.ts#L124-L140)
- [Ref:HRANA_3_SPEC](https://github.com/tursodatabase/libsql/blob/main/docs/HRANA_3_SPEC.md#L844)

## Initiates a transaction for executing SQL queries either remotely or locally

This method `transaction()` initiates a transaction for executing SQL queries either remotely or locally, depending on the connection mode set during initialization. It supports different transaction modes such as deferred, write, and read.

For **remote usage**, you can start a new transaction using `$db->transaction()`, then add SQL statements using `addTransaction()`, and finally end the transaction using `endTransaction()`.

For **local usage**, you can specify the transaction mode (defaulting to 'deferred') and then execute SQL statements using `exec()`. You can then commit the changes using `commit()` or rollback using `rollback()` based on the success of the operations.

Here's an example of both remote and local usage:

```php
// Remote Usage
$transaction = $db->transaction();
$transaction->addTransaction(HttpStatement::create("UPDATE users SET name = 'Turso DB' WHERE id = 1"));
$transaction->addTransaction(HttpStatement::create("UPDATE users SET name = 'darkterminal' WHERE id = 2"));
$result = $transaction->endTransaction();
print_r($result);

// Local Usage
$tx = $db->transaction(TransactionBehavior::Deferred);
$tx->exec("INSERT INTO users (name) VALUES (?)", ["Emanuel"]);
$tx->exec("INSERT INTO users (name) VALUES (?)", ["Darren"]);

if ($operations_successful) {
    $tx->commit();
    echo "Commit the changes" . PHP_EOL;
} else {
    $tx->rollback();
    echo "Rollback the changes" . PHP_EOL;
}
```

The method returns an instance of `HttpTransaction` for remote connections and `Transaction` for local connections.

## Synchronizes the database

This method `sync()` synchronizes the database, but it's only supported for **RemoteReplica** and **LocalReplica**. If called in Remote (HTTP) or Local (FILE) mode, it will throw a `LibsqlError`.

## Close the database connection

This method `close()` is responsible for closing the database connection, whether it's a remote (HTTP) connection or a local (FILE) connection. If the connection mode is not recognized, it throws a `LibsqlError`.

