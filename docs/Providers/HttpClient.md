# HttpClient

The `HttpClient` trait provides functionality to interact with HTTP resources, including executing HTTP requests and handling responses.

## Namespace:
- `Darkterminal\LibSQL\Providers`

## Uses:
- `Darkterminal\LibSQL\Types\HttpResponse`
- `Darkterminal\LibSQL\Types\HttpStatement`
- `Darkterminal\LibSQL\Types\TransactionMode`
- `Darkterminal\LibSQL\Utils\Exceptions\LibsqlError`
- `GuzzleHttp\Client`
- `GuzzleHttp\Exception\RequestException`
- `GuzzleHttp\Psr7\Request`
- `Psr\Http\Message\ResponseInterface`

## Properties:
- `$http`: Client
- `$timeout`: int|float
- `$url`: string
- `$authToken`: string|null
- `$headers`: array
- `$baton`: string
- `$collectors`: array

## Methods:

### protected function setup(string $url, string|null $authToken = null, int|float $timeout = 2.0)
**Description:** Initializes a new HttpClient instance.

**Link:** N/A

**Parameters:**
- `$url`: The base URL for HTTP requests.
- `$authToken` (Optional): The authentication token for accessing the URL.
- `$timeout`: The timeout duration for HTTP requests.

### public function connect(): bool|LibsqlError
**Description:** Connects to the HTTP server.

**Link:** N/A

### public function execute(HttpStatement $query, string $baton = ''): HttpResponse
**Description:** Executes an HTTP statement.

**Link:** [Turso - Simple Query](https://docs.turso.tech/sdk/http/reference#simple-query)

**Parameters:**
- `$query`: The HTTP statement to execute.
- `$baton` (Optional): The baton string.

### public function batch(array $queries, string $mode = 'deferred'): HttpResponse
**Description:** Executes a batch of HTTP statements.

**Link:** [Turso - Interactive Query](https://docs.turso.tech/sdk/http/reference#interactive-query)

**Parameters:**
- `$queries`: The array of HTTP statements to execute.
- `$mode` (Optional): The transaction mode (read, write, or deferred).

### public function executeMultiple(string $sql): void
**Description:** Executes multiple SQL statements in sequence.

**Link:** [Hrana Over HTTP - Sequence](https://github.com/tursodatabase/libsql/blob/main/docs/HRANA_3_SPEC.md#execute-a-sequence-of-sql-statements-1)

**Parameters:**
- `$sql`: The SQL statements to execute.

### public function startTransaction(string $mode = 'write'): self
**Description:** Starts a transaction with the specified mode.

**Link:** N/A

**Parameters:**
- `$mode` (Optional): The transaction mode (read, write, or deferred).

### public function addTransaction(HttpStatement $query): self
**Description:** Adds a transaction to the transaction batch.

**Link:** N/A

**Parameters:**
- `$query`: The HTTP statement to add to the transaction.

### public function endTransaction(): HttpResponse
**Description:** Ends the current transaction batch and commits the transactions.

**Link:** N/A

### public function rollback(): void
**Description:** Rolls back the current transaction.

**Link:** N/A

### public function commit(): void
**Description:** Commits the current transaction.

**Link:** N/A

### public function close(): void
**Description:** Closes the HTTP client connection.

**Link:** N/A

### public function version(): string
**Description:** Retrieves the version from the HTTP server.

**Link:** N/A

### protected function runQuery(array $payload, bool $trace = false): HttpResponse|ResponseInterface
**Description:** Runs an HTTP query with the provided payload.

**Link:** N/A

**Parameters:**
- `$payload`: The payload for the HTTP query.
- `$trace` (Optional): Whether to return the raw response without mapping results.

### private function _makeRequest(array $data, bool $close = true, string $baton = ''): array
**Description:** Creates a payload for making a request.

**Link:** N/A

**Parameters:**
- `$data`: The data to include in the payload.
- `$close` (Optional): Whether to include a close request.
- `$baton` (Optional): The baton string.

### private function _close(): array
**Description:** Creates a request array for closing the connection.

**Link:** N/A

### private function _createRequest(string $type = \LIBSQL_EXECUTE, string $sql, ?array $args = [], ?bool $named_args = false): array
**Description:** Creates a request array for execution with the provided SQL statement and arguments.

**Link:** N/A

**Parameters:**
- `$type`: The type statement to execute.
- `$sql`: The SQL statement to execute.
- `$args` (Optional): The arguments for the SQL statement.
- `$named_args` (Optional): Whether the arguments are named or positional.

### private function _argumentsGenerator($args): array
**Description:** Generates arguments array for the HTTP request payload.

**Link:** N/A

**Parameters:**
- `$args`: The arguments to be processed.

### private function _namedArgumentsGenerator(array $args): array
**Description:** Generates named arguments array for the HTTP request payload.

**Link:** N/A

**Parameters:**
- `$args`: The named arguments to be processed.

### private function _typeParser(mixed $value): string
**Description:** Parses the type of the value.

**Link:** N/A

**Parameters:**
- `$value`: The value to determine the type for.
