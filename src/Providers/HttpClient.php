<?php

namespace Darkterminal\LibSQL\Providers;

use Darkterminal\LibSQL\Types\HttpResponse;
use Darkterminal\LibSQL\Types\HttpStatement;
use Darkterminal\LibSQL\Types\HttpTransaction;
use Darkterminal\LibSQL\Types\TransactionMode;
use Darkterminal\LibSQL\Utils\Exceptions\LibsqlError;
use Darkterminal\LibSQL\Utils\Mods;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;

/**
 * Class HttpClient
 *
 * The HttpClient class provides functionality to interact with HTTP resources,
 * including executing HTTP requests and handling responses.
 *
 * @package Darkterminal\LibSQL
 */
class HttpClient
{
    /**
     * The HTTP client instance used for making requests.
     *
     * @var Client
     */
    protected Client $http;

    /**
     * The timeout duration for HTTP requests.
     *
     * @var int|float
     */
    protected int|float $timeout;

    /**
     * The base URL for HTTP requests.
     *
     * @var string
     */
    protected string $url;

    /**
     * The authentication token used for HTTP requests, if applicable.
     *
     * @var string|null
     */
    protected string|null $authToken;

    /**
     * The headers to be included in HTTP requests.
     *
     * @var array
     */
    protected array $headers;

    /**
     * The baton for tracking requests, if applicable.
     *
     * @var string
     */
    protected string $baton = '';

    /**
     * The collectors used for collecting data from requests.
     *
     * @var array
     */
    protected array $collectors = [];

    /**
     * HttpClient Setup.
     *
     * Initializes a new HttpClient instance.
     *
     * @param string $url The base URL for HTTP requests.
     * @param string|null $authToken (Optional) The authentication token for accessing the URL.
     *
     * @throws LibsqlError If attempting to use a remote (turso) database without providing a token.
     */
    public function setup(string $url, string|null $authToken = null, int|float $timeout = 2.0)
    {
        // Check if attempting to use a remote (turso) database without providing a token
        if (\strpos($url, \TURSO) !== false && \is_null($authToken)) {
            throw new LibsqlError("Trying to use remote (turso) database without using token", "INVALID_REMOTE_CONNECTION");
        }

        $this->url = $url;
        $this->authToken = $authToken;
        $this->timeout = $timeout;

        $this->initializeHttp();
    }

    /**
     * Initializes the HTTP client with the specified headers and options.
     */
    private function initializeHttp(): void
    {
        $this->headers = [
            'Content-Type' => 'Application/json'
        ];
        if (!empty($this->authToken)) {
            $this->headers['Authorization'] = 'Bearer ' . $this->authToken;
        }

        // Initialize Guzzle HTTP client
        $this->http = new Client([
            'base_uri' => $this->url,
            'timeout'  => $this->timeout,
            'headers' => $this->headers
        ]);
    }

    /**
     * Connect to the HTTP server.
     *
     * @return bool|LibsqlError True if connection is successful, otherwise a LibsqlError instance.
     * @throws LibsqlError If connection fails.
     */
    public function connect(): bool|LibsqlError
    {
        try {
            // Send a health check request to the server
            $request = new Request('GET', \HEALTH_ENDPOINT, $this->headers);
            $response = $this->http->send($request);
            return $response->getStatusCode() === 200;
        } catch (\Throwable $e) {
            // If connection fails, throw a LibsqlError
            throw new LibsqlError("Connection failed! " . $e->getMessage(), "CONNECTION_ERROR");
        }
    }

    /**
     * Execute an HTTP statement.
     * This method follow @link [Turso - Simple Query](https://docs.turso.tech/sdk/http/reference#simple-query)
     *
     * @param HttpStatement $query The HTTP statement to execute.
     * @param string $baton (Optional) The baton string.
     *
     * @return HttpResponse The HTTP response containing the results of the execution.
     *
     * @throws LibsqlError If there is an error in the execution of the statement.
     */
    public function execute(HttpStatement $query, string $baton = ''): HttpResponse
    {
        // Create request payload
        $payload = $this->_createRequest(\LIBSQL_EXECUTE, $query->sql, $query->args, $query->named_args);
        $request = (!empty($baton)) ? $this->_makeRequest($payload, false, $baton) : $this->_makeRequest($payload);

        // Send POST request
        $response = $this->runQuery($request, true);

        // Process response and return HttpResponse object
        $data = map_results($response->getBody());
        return HttpResponse::create($data['baton'], $data['base_url'], $data['results']);
    }

    /**
     * Execute a batch of HTTP statements.
     * This method follow @link [Turso - Interactive Query](https://docs.turso.tech/sdk/http/reference#interactive-query)
     *
     * @param array $queries The array of HTTP statements to execute.
     * @param string $mode (Optional) The transaction mode read, write, or deferred. Default is 'deferred'.
     *
     * @return HttpResponse The HTTP response containing the results of the batch execution.
     *
     * @throws LibsqlError If there is an error in the batch execution.
     */
    public function batch(array $queries, string $mode = 'deferred'): HttpResponse
    {
        try {
            // Check if the transaction mode is valid
            TransactionMode::checker($mode);

            // Create the start transaction request
            $startTransaction = $this->_createRequest(\LIBSQL_EXECUTE, Mods::transactionModeToBegin($mode));

            // Initialize the batch payload
            $batchPayload = [];

            // Iterate through each statement and add it to the batch payload
            foreach ($queries as $stmt) {
                /** @var HttpStatement $stmt */
                \array_push($batchPayload, $this->_createRequest(\LIBSQL_EXECUTE, $stmt->sql, $stmt->args, $stmt->named_args));
            }

            // Add a commit request to the batch payload
            \array_push($batchPayload, $this->_createRequest(\LIBSQL_EXECUTE, 'COMMIT'));

            // Execute the batch request asynchronously
            return $this->http->postAsync(\PIPE_LINE_ENDPOINT, [
                'json' => $this->_makeRequest($startTransaction, false)
            ])->then(
                function (ResponseInterface $res) use ($batchPayload) {
                    // Handle the response from the start transaction request
                    $beginResult = map_results($res->getBody());
                    $trx = HttpResponse::create($beginResult['baton'], $beginResult['base_url'], $beginResult['results']);

                    // Execute the batch payload asynchronously
                    return $this->http->postAsync(\PIPE_LINE_ENDPOINT, [
                        'json' => $this->_makeRequest($batchPayload, true, $trx->baton)
                    ])->then(
                        function (ResponseInterface $res) {
                            // Handle the response from the batch execution
                            $transactionResults = map_results($res->getBody());
                            return HttpResponse::create($transactionResults['baton'], $transactionResults['base_url'], $transactionResults['results']);
                        },
                        function (RequestException $e) {
                            // Handle request exceptions during batch execution
                            throw new LibsqlError($e->getRequest()->getMethod() . " - " . $e->getMessage(), "INVALID_BATCH_TRANSACTION");
                        }
                    )->wait();
                },
                function (RequestException $e) {
                    $this->_close();
                    // Handle request exceptions during start transaction
                    throw new LibsqlError($e->getRequest()->getMethod() . ' - ' . $e->getMessage(), "INVALID_START_TRANSACTION");
                }
            )->wait();
        } catch (\Throwable $e) {
            $this->_close();
            // If execution fails, throw a LibsqlError
            throw new LibsqlError($e->getMessage(), "BATCH_TRANSACTION_TERMINATED");
        }
    }

    /**
     * Execute multiple SQL statements in sequence.
     * This method follow @link [Hrana Over HTTP - Sequence](https://github.com/tursodatabase/libsql/blob/main/docs/HRANA_3_SPEC.md#execute-a-sequence-of-sql-statements-1)
     *
     * @param string $sql The SQL statements to execute.
     *
     * @return string
     *
     * @throws LibsqlError If execution fails.
     */
    public function executeMultiple(string $sql): string
    {
        try {
            $payload = $this->_createSequenceRequest(\str_replace(["\r", "\n", "\r\n"], '', $sql));
            $response = $this->http->post(\PIPE_LINE_ENDPOINT, [
                'json' => $this->_makeRequest($payload)
            ]);
            return $response->getBody();
        } catch (\Throwable $e) {
            $this->_close();
            // If execution fails, throw a LibsqlError
            throw new LibsqlError($e->getMessage(), "MULTIPLE_EXEC_ERROR");
        }
    }

    /**
     * Start a transaction with the specified mode.
     *
     * @param string $mode (Optional) The transaction mode read, write, and deferred. Default is 'write'.
     *
     * @return self The current instance of HttpClient.
     *
     * @throws LibsqlError If there is an error starting the transaction.
     */
    public function transaction(string $mode = 'write'): HttpTransaction
    {
        TransactionMode::checker($mode);
        return new HttpTransaction($mode);
    }

    /**
     * Close the HTTP client connection.
     */
    public function close(): void
    {
        $this->runQuery($this->_makeRequest($this->_close()));
    }

    public function version(): string
    {
        $response = $this->http->get(\VERSION_ENDPOINT);
        return $response->getBody();
    }

    /**
     * Run an HTTP query with the provided payload.
     *
     * @param array $payload The payload for the HTTP query.
     * @param bool $trace (Optional) Whether to return the raw response without mapping results. Default is false.
     *
     * @return HttpResponse|ResponseInterface The HTTP response containing the results of the query, or the raw response if trace is true.
     */
    protected function runQuery(array $payload, bool $trace = false): HttpResponse|ResponseInterface
    {
        $response = $this->http->post(\PIPE_LINE_ENDPOINT, [
            'json' => $payload
        ]);

        if ($trace === false) {
            $data = map_results($response->getBody());
            return HttpResponse::create($data['baton'], $data['base_url'], $data['results']);
        }

        return $response;
    }

    /**
     * Create a payload for making a request.
     *
     * @param array $data The data to include in the payload.
     * @param bool $close (Optional) Whether to include a close request. Default is true.
     * @param string $baton (Optional) The baton string.
     *
     * @return array The payload for the request.
     */
    protected function _makeRequest(array $data, bool $close = true, string $baton = ''): array
    {
        // Initialize the payload with the "requests" key
        $payload = [
            'requests' => \sizeof($data) >= 3 ? $data : [$data]
        ];

        // Add the close request if needed
        if ($close) {
            $payload['requests'][] = $this->_close();
        }

        // Add the baton if provided
        if (!empty($baton)) {
            $payload["baton"] = $baton;
        }

        return $payload;
    }

    /**
     * Create a request array for closing the connection.
     *
     * @return array The request array for closing the connection.
     */
    protected function _close(): array
    {
        return ["type" => \LIBSQL_CLOSE];
    }

    /**
     * Create a request array for execution with the provided SQL statement and arguments.
     *
     * @param string $type The type statement to execute.
     * @param string $sql The SQL statement to execute.
     * @param array|null $args (Optional) The arguments for the SQL statement.
     * @param bool|null $named_args (Optional) Whether the arguments are named or positional.
     *
     * @return array The request array for execution.
     */
    protected function _createRequest(
        string $type = \LIBSQL_EXECUTE,
        string $sql,
        ?array $args = [],
        ?bool $named_args = false
    ): array {
        // Initialize the execute request array
        $executeRequest = [
            "type" => $type,
            "stmt" => [
                "sql" => $sql
            ]
        ];

        // Determine if arguments are positional or named and set accordingly
        if ($named_args === false && !empty($args)) {
            $executeRequest["stmt"]["args"] = $this->_argumentsGenerator($args);
        }

        if ($named_args === true) {
            $executeRequest["stmt"]["named_args"] = $this->_namedArgumentsGenerator($args);
        }

        return $executeRequest;
    }

    protected function _createSequenceRequest(
        string $sql,
        int|null $sql_id = null
    ): array {
        // Initialize the execute request array
        $executeRequest = [
            "type" => \LIBSQL_SEQUENCE,
            "sql" => $sql
        ];

        if (!empty($sql_id)) {
            $executeRequest['sql_id'] = $sql_id;
        }

        return $executeRequest;
    }

    /**
     * Generate arguments array for the HTTP request payload.
     *
     * @param mixed $args The arguments to be processed.
     *
     * @return array The generated arguments array.
     * @throws LibsqlError If an invalid argument type is encountered.
     */
    protected function _argumentsGenerator($args): array
    {
        $argsArray = [];

        // Iterate through each argument and generate the appropriate representation
        foreach ($args as $arg) {
            $type = $this->_typeParser($arg);

            // Handle special cases for certain argument types
            if ($type === 'blob') {
                $arg = \base64_encode($arg);
            } else if ($type === 'float') {
                // Convert argument to float if it's of type 'float'
                \settype($arg, 'float');
            } else if ($type === 'integer') {
                // Ensure integer values are represented as strings
                $arg = "$arg";
            }

            // Add argument to the array with its type and value
            $argsArray[] = [
                "type" => $type,
                "value" => $arg
            ];
        }

        return $argsArray;
    }

    /**
     * Generate named arguments array for the HTTP request payload.
     *
     * @param array $args The named arguments to be processed.
     *
     * @return array The generated named arguments array.
     * @throws LibsqlError If an invalid argument type is encountered.
     */
    protected function _namedArgumentsGenerator(array $args): array
    {
        $argsArray = [];

        // Iterate through each named argument and generate the appropriate representation
        foreach ($args as $name => $value) {
            $type = $this->_typeParser($value);

            // Handle special cases for certain argument types
            if ($type === 'blob') {
                $value = \base64_encode($value);
            } else if ($type === 'float') {
                // Convert argument to float if it's of type 'float'
                \settype($value, 'float');
            } else if ($type === 'integer') {
                // Ensure integer values are represented as strings
                $value = "$value";
            }

            // Add named argument to the array with its name, type, and value
            $argsArray[] = [
                "name" => $name,
                "value" => [
                    "type" => $type,
                    "value" => $value
                ]
            ];
        }

        return $argsArray;
    }

    /**
     * Parse the type of the value.
     *
     * @param mixed $value The value to determine the type for.
     *
     * @return string The type of the value.
     * @throws LibsqlError If the type of the value cannot be determined or is invalid.
     */
    protected function _typeParser(mixed $value): string
    {
        // Check the type of the value using the provided function
        $type = Mods::checkColumnType($value);

        // Throw an error if the type is unknown
        if ($type === 'unknown') {
            throw new LibsqlError(
                "Invalid arguments types. The type field within each arg corresponds to the column datatype and can be one of the following: null, integer, float, text, or blob.",
                "INVALID_TYPE_ARGUMENT"
            );
        }

        return $type;
    }
}
