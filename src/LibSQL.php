<?php

namespace Darkterminal\LibSQL;

use Darkterminal\LibSQL\Providers\HttpClient;
use Darkterminal\LibSQL\Providers\LocalClient;
use Darkterminal\LibSQL\Providers\RemoteReplicaClient;
use Darkterminal\LibSQL\Types\ExpandedScheme;
use Darkterminal\LibSQL\Types\HttpResponse;
use Darkterminal\LibSQL\Types\HttpStatement;
use Darkterminal\LibSQL\Types\HttpTransaction;
use Darkterminal\LibSQL\Utils\Exceptions\LibsqlError;
use Darkterminal\LibSQL\Utils\Mods;
use Darkterminal\LibSQLPHPExtension\Responses\LibSQLPHPClientResult;
use Darkterminal\LibSQLPHPExtension\Responses\Transaction;

/**
 * The main class for interacting with the LibSQL service.
 *
 * This class provides functionality for creating an HTTP client and Local client based on the provided configuration.
 * It supports different URL schemes such as "file:", "libsql:", "https:", and "http:".
 * It also handles errors related to unsupported URL schemes and TLS configurations.
 */
class LibSQL
{
    /**
     * @var HttpClient $httpProvider The HTTP client provider.
     */
    protected HttpClient $httpProvider;

    /**
     * @var LocalClient $localProvider The local client provider.
     */
    protected LocalClient $localProvider;

    /**
     * @var RemoteReplicaClient $remoteReplicaProvicer The Remote Replica client provider
     */
    protected RemoteReplicaClient $remoteReplicaProvider;

    /**
     * @var string $mode The current connection mode (either "Remote" or "Local").
     */
    protected string $mode;

    /**
     * Constructs a new LibSQL instance.
     * 
     * **Example Local Connection**
     * 
     * ```
     * $config = [
     *  "url" => "file:database.db",
     *  "flags" => LIBSQLPHP_OPEN_READWRITE | LIBSQLPHP_OPEN_CREATE,
     *  "encryptionKey" => ""
     * ];
     *
     * $db = new LibSQL($config);
     * $db->connect();
     * ```
     * 
     * **Example Remote Connection**
     * 
     * ```
     * $config = [
     *     'url' => 'libsql://127.0.0.1:8001', // libsql://database-origanization.turso.io
     *     'authToken' => getenv('LIBSQL_PHP_FA_TOKEN'),
     *     'tls' => false
     * ];
     * 
     * $db = new LibSQL($config);
     * ```
     *
     * @param array $config The configuration array for the LibSQL service.
     * @throws LibsqlError If there is an error creating the HTTP client.
     */
    public function __construct(array $config)
    {
        $configBuilder = Mods::expandConfig($config, true);

        if ($configBuilder->scheme === ExpandedScheme::file && !empty($configBuilder->authToken) && !empty($configBuilder->syncUrl)) {
            $this->remoteReplicaProvider = new RemoteReplicaClient(
                $configBuilder->path,
                $configBuilder->authToken,
                $configBuilder->syncUrl,
                $configBuilder->syncInterval,
                $configBuilder->read_your_writes
            );
            $this->mode = 'RemoteReplica';
        } else if (in_array($configBuilder->scheme, [ExpandedScheme::http, ExpandedScheme::https]) && !empty($configBuilder->authToken)) {
            if ($configBuilder->scheme !== ExpandedScheme::https && $configBuilder->scheme !== ExpandedScheme::http) {
                throw new LibsqlError(
                    'The HTTP client supports only "libsql:", "https:" and "http:" URLs, got ' . $configBuilder->scheme,
                    "URL_SCHEME_NOT_SUPPORTED",
                );
            }

            if ($configBuilder->scheme === ExpandedScheme::http && $configBuilder->tls) {
                throw new LibsqlError('A "http:" URL cannot opt into TLS by using ?tls=1', "URL_INVALID");
            } else if ($configBuilder->scheme === ExpandedScheme::https && !$configBuilder->tls) {
                throw new LibsqlError('A "https:" URL cannot opt out of TLS by using ?tls=0', "URL_INVALID");
            }

            $url = Mods::encodeBaseUrl($configBuilder->scheme, $configBuilder->authority, $configBuilder->path);
            $this->httpProvider = new HttpClient();
            $this->httpProvider->setup($url, $configBuilder->authToken);
            $this->mode = 'Remote';
        } else if ($configBuilder->scheme === ExpandedScheme::file && !empty($configBuilder->flags) && !empty($configBuilder->path)) {
            $this->localProvider = new LocalClient();
            $this->localProvider->setup($configBuilder->path, $configBuilder->flags, $configBuilder->encryptionKey);
            $this->mode = "Local";
        } else {
            throw new LibsqlError('Invalid Connection! Only support Remote and Local connection', 'ERR_INVALID_CONNECTION');
        }
    }

    /**
     * Checking connection mode
     *
     * @return string
     */
    public function connectionMode(): string
    {
        return $this->mode;
    }

    /**
     * Establishes a connection to the database.
     *
     * @throws LibsqlError Thrown if the connection mode is not recognized.
     *
     * @return bool True if the connection is successfully established, false otherwise.
     */
    public function connect(): bool
    {
        switch ($this->mode) {
            case REMOTE:
                return $this->httpProvider->connect();
                break;
            case LOCAL:
                return $this->localProvider->connect();
                break;
            case REMOTE_REPLICA:
                return $this->remoteReplicaProvider->connect();
                break;
            default:
                throw new LibsqlError("Connection mode is not found", "ERR_MODE_NOT_FOUND");
                break;
        }
    }

    /**
     * Retrieves the version information of the database.
     *
     * @throws LibsqlError Thrown if the connection mode is not recognized.
     *
     * @return string The version information of the database.
     */
    public function version(): string
    {
        switch ($this->mode) {
            case REMOTE:
                return $this->httpProvider->version();
                break;
            case LOCAL:
                return $this->localProvider->version();
                break;
            case REMOTE_REPLICA:
                return $this->remoteReplicaProvider->version();
                break;
            default:
                throw new LibsqlError("Connection mode is not found", "ERR_MODE_NOT_FOUND");
                break;
        }
    }

    /**
     * Executes a query.
     * 
     * ### NOTE: Use _Named Paramaters_ is recommended
     * 
     * 
     * **Parameters**
     * 
     * **$query**
     * - _HttpStatement_ - **[Remote Only]** Parameter used for Remote connection only - [Ref:HttpStatement](https://github.com/darkterminal/libsql-client-php/blob/main/src/Types/HttpStatement.php)
     * - _string_ - **[Local only]** Parameter used for Local connection only
     * 
     * **$baton**
     * - _string_ - **[Remote Only]** The baton value for the query.
     * 
     * **$params**
     * - _array_ - **[Local Only]** Parameters for the query.
     * 
     * **Return**
     * 
     * - _HttpResponse_ - **[Remote Only]** instance of HttpResponse for remote mode - [Ref:HttpResponse](https://github.com/darkterminal/libsql-client-php/blob/main/src/Types/HttpResponse.php)
     * - _bool_ - **[Local Only]** Parameters for the query.
     * 
     * **Remote Usage Example**
     * 
     * ```
     * $query = HttpStatement::create(sql: 'SELECT name, id FROM users LIMIT 5');
     * $results = $db->execute(query: $query);
     * echo $results->fetch(type: LibSQLResult::FETCH_OBJ) . PHP_EOL;
     * ```
     * 
     * **Local Usage Example**
     * 
     * ```
     * $result = $db->execute(query: "INSERT INTO users (name) VALUES (?)", params: ['Belina Bogge']);
     * var_dump($result);
     * ```
     *
     * @param string|HttpStatement $query The query to execute, either a string or an instance of HttpStatement.
     * @param string $baton (Optional) The baton value for the query.
     * @param array $params (Optional) Parameters for the query.
     *
     * @throws LibsqlError Thrown if the connection mode is not recognized.
     *
     * @return LibSQLPHPClientResult|HttpResponse True if successful for local mode; otherwise, an instance of HttpResponse for remote mode. - [Ref:Executes a Query](https://github.com/darkterminal/libsql-php-ext/blob/main/docs/LibSQL.md#executes-a-query)
     */
    public function execute(string|HttpStatement $query, string $baton = '', ?array $params = []): LibSQLPHPClientResult|HttpResponse
    {
        switch ($this->mode) {
            case REMOTE:
                return $this->httpProvider->execute($query, $baton);
                break;
            case LOCAL:
                return $this->localProvider->execute($query, $params);
                break;
            case REMOTE_REPLICA:
                return $this->remoteReplicaProvider->execute($query, $params);
                break;
            default:
                throw new LibsqlError("Connection mode is not found", "ERR_MODE_NOT_FOUND");
                break;
        }
    }

    /**
     * Executes a batch of queries.
     * 
     * ### NOTE: Remote Only
     * 
     * Mode Options Available:
     * - deferred (default)
     * - write
     * - read
     * 
     * Everyting is in lower-case or you can use **TransactionMode** Class Constants
     * 
     * **Example - [Ref:Example](https://docs.turso.tech/sdk/http/reference#interactive-query)**
     * 
     * ```
     * $stmts = [
     *     HttpStatement::create(sql: 'INSERT INTO users (name, age) VALUES (?, ?)', args: ["Ramons", 32]),
     *     HttpStatement::create(sql: 'INSERT INTO users (name, age) VALUES (?, ?)', args: ["Georgia", 43])
     * ];
     * $results = $db->batch(queries: $stmts);
     * print_r($results);
     * ```
     *
     * @param array $queries The array of queries to execute.
     * @param string $mode (Optional) The transaction behavior mode. Default is "deferred"
     *
     * @throws LibsqlError Thrown if the function is called for a local mode connection.
     *
     * @return HttpResponse The HTTP response containing the result of the batch execution. - [Ref:HttpResponse](https://github.com/darkterminal/libsql-client-php/blob/main/src/Types/HttpResponse.php)
     */
    public function batch(array $queries, string $mode = "deferred"): HttpResponse
    {
        if (in_array($this->mode, [LOCAL, REMOTE_REPLICA])) {
            throw new LibsqlError("This function only for Remote (HTTP) provider", "INVALID_FUNCTION_CALL");
        }

        return $this->httpProvider->batch($queries, $mode);
    }

    /**
     * Executes a batch of queries.
     * 
     * ### NOTE: Local Only
     * 
     * **Example - [Ref:Execute Batch](https://github.com/tursodatabase/libsql/blob/main/libsql/src/local/connection.rs#L116-L137)**
     * 
     * ```
     * $db->execute_batch("
     *  BEGIN;
     *  CREATE TABLE foo(x INTEGER);
     *  CREATE TABLE bar(y TEXT);
     *  COMMIT;
     * ");
     * ```
     *
     * @param string $query The batch query to execute.
     *
     * @throws LibsqlError Thrown if the function is called for a remote mode connection.
     *
     * @return void
     */
    public function execute_batch(string $query): void
    {
        if ($this->mode === REMOTE) {
            
        }

        switch ($this->mode) {
            case LOCAL:
                $this->localProvider->batch($query);
                break;
            case REMOTE_REPLICA:
                $this->remoteReplicaProvider->batch($query);
                break;
            default:
                throw new LibsqlError("This function only for Local (FILE) provider", "INVALID_FUNCTION_CALL");
                break;
        }
    }

    /**
     * Executes multiple SQL queries in a single HTTP request.
     * 
     * ### NOTE: Remote Only
     * 
     * **Example*
     * 
     * ```
     * $query = "
     * UPDATE users SET name = 'Turso DB' WHERE id = 1;
     * UPDATE users SET name = 'ducktermin;
     * ";
     * $result = $db->executeMultiple($query);
     * print_r($result);
     * ```
     * Refs:
     * - [Ref:http.ts Implementation](https://github.com/tursodatabase/libsql-client-ts/blob/main/packages/libsql-client/src/http.ts#L124-L140)
     * - [Ref:HRANA_3_SPEC](https://github.com/tursodatabase/libsql/blob/main/docs/HRANA_3_SPEC.md#L844)
     *
     * @param string $query The SQL queries to execute.
     *
     * @throws LibsqlError Thrown if the function is called for a local mode connection.
     *
     * @return string The response from executing the queries.
     */
    public function executeMultiple(string $query): string
    {
        if (in_array($this->mode, [LOCAL, REMOTE_REPLICA])) {
            throw new LibsqlError("This function only for Remote (HTTP) provider", "INVALID_FUNCTION_CALL");
        }

        return $this->httpProvider->executeMultiple($query);
    }

    /**
     * Initiates a transaction for executing SQL queries either remotely or locally.
     * 
     * ### NOTE: Remote and Local Used - **Recommended Read Ref:Link below**
     * 
     * Mode Options Available:
     * - deferred (default: in Local)
     * - write (default: in Remote)
     * - read
     * 
     * **Example - Remote Usage**
     * 
     * ```
     * // Start a new transaction
     * $transaction = $db->transaction();
     * 
     * // Add the first SQL statement to the transaction
     * if (true) {
     *     $transaction->addTransaction(HttpStatement::create("UPDATE users SET name = 'Turso DB' WHERE id = 1"));
     * } else {
     *     // If a condition is not met, rollback the transaction and exit
     *     $transaction->rollback();
     *     exit();
     * }
     * 
     * // Add the second SQL statement to the transaction
     * if (true) {
     *     $transaction->addTransaction(HttpStatement::create("UPDATE users SET name = 'darkterminal' WHERE id = 2"));
     * } else {
     *     // If another condition is not met, rollback the transaction and exit
     *     $transaction->rollback();
     *     exit();
     * }
     * 
     * // End the transaction (commit changes)
     * $result = $transaction->endTransaction();
     * print_r($result);
     * ```
     * 
     * **Example - Local Usage**
     * 
     * ```
     * $operations_successful = false;
     * $tx = $db->transaction(TransactionBehavior::Deferred);
     * $tx->exec("INSERT INTO users (name) VALUES (?)", ["Emanuel"]);
     * $tx->exec("INSERT INTO users (name) VALUES (?)", ["Darren"]);
     * 
     * if ($operations_successful) {
     *     $tx->commit();
     *     echo "Commit the changes" . PHP_EOL;
     * } else {
     *     $tx->rollback();
     *     echo "Rollback the changes" . PHP_EOL;
     * }
     * ```
     * 
     * **Return**
     * - _**HttpTransaction**_ - The return class when using **Remote Connection** [Ref:HttpTransaction](https://github.com/darkterminal/libsql-client-php/blob/main/src/Types/HttpTransaction.php)
     * - _**Transaction**_ - The return class when using **Local Connection** - [Ref:Transaction](https://github.com/darkterminal/libsql-php-ext/blob/main/php-src/Responses/Transaction.php)
     *
     * @param string $mode The transaction mode. Defaults to 'write'.
     *
     * @throws LibsqlError Thrown if the connection mode is not recognized.
     *
     * @return HttpTransaction|Transaction An instance of HttpTransaction for remote connections or Transaction for local connections.
     */
    public function transaction(string $mode = 'write'): HttpTransaction|Transaction
    {
        switch ($this->mode) {
            case REMOTE:
                return $this->httpProvider->transaction($mode);
                break;
            case LOCAL:
                return $this->localProvider->transaction($mode);
                break;
            case REMOTE_REPLICA:
                return $this->remoteReplicaProvider->transaction($mode);
                break;
            default:
                throw new LibsqlError("Connection mode is not found", "ERR_MODE_NOT_FOUND");
                break;
        }
    }

    /**
     * Synchronizes the database.
     * 
     * ### NOTE: This Only Support for RemoteReplica and LocalReplica - [Ref:Builder Details](https://github.com/tursodatabase/libsql/blob/main/libsql/src/database/builder.rs#L8-L25)
     *
     * @throws LibsqlError Thrown if sync is called in Remote (HTTP) or Local (FILE) mode.
     *
     * @return int
     */
    public function sync(): int
    {
        if ($this->mode === LOCAL || $this->mode === REMOTE) {
            throw new LibsqlError("sync not supported in Remote (HTTP) or Local (FILE) mode", "SYNC_NOT_SUPPORTED");
        }

        return $this->remoteReplicaProvider->sync();
    }

    /**
     * Closes the database connection.
     *
     * @throws LibsqlError Thrown if the connection mode is not recognized.
     *
     * @return void
     */
    public function close(): void
    {
        switch ($this->mode) {
            case REMOTE:
                $this->httpProvider->close();
                break;
            case LOCAL:
                $this->localProvider->close();
                break;
            case REMOTE_REPLICA:
                $this->remoteReplicaProvider->close();
                break;
            default:
                throw new LibsqlError("Connection mode is not recognized", "ERR_MODE_NOT_FOUND");
                break;
        }
    }
}
