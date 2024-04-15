# Trait: HttpClient

The `HttpClient` trait provides functionality to interact with HTTP resources, including executing HTTP requests and handling responses.

### Properties:

- `$http` (Client): The Guzzle HTTP client.
- `$timeout` (int|float): The timeout duration for HTTP requests.
- `$url` (string): The base URL for HTTP requests.
- `$authToken` (string|null): The authentication token for accessing the URL.
- `$headers` (array): The headers for HTTP requests.
- `$baton` (string): The baton string.
- `$collectors` (array): An array to collect requests.

### Methods:

1. `setup(string $url, string|null $authToken = null, int|float $timeout = 2.0): void`
    - Initializes a new `HttpClient` instance.
2. `connect(): bool|LibsqlError`
    - Connects to the HTTP server.
3. `execute(HttpStatement $query, string $baton = ''): HttpResponse`
    - Executes an HTTP statement.
4. `batch(array $queries, string $mode = 'deferred'): HttpResponse`
    - Executes a batch of HTTP statements.
5. `startTransaction(string $mode = 'write'): self`
    - Starts a transaction with the specified mode.
6. `addTransaction(HttpStatement $query): self`
    - Adds a transaction to the transaction batch.
7. `endTransaction(): HttpResponse`
    - Ends the current transaction batch and commits the transactions.
8. `rollback(): void`
    - Rolls back the current transaction.
9. `commit(): void`
    - Commits the current transaction.
10. `close(): void`
    - Closes the HTTP client connection.

### Overview:

- This trait encapsulates functionality to interact with HTTP resources, including sending requests and handling responses.
- It provides methods for executing HTTP statements, executing batches of statements, and managing transactions.
- The `HttpClient` trait uses Guzzle HTTP client for sending HTTP requests.
- It includes methods for connecting to the HTTP server, executing HTTP statements, and managing transactions such as starting, committing, and rolling back transactions.
