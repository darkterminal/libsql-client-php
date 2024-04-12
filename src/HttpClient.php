<?php

namespace Darkterminal\LibSQL;

use Darkterminal\LibSQL\Types\HttpResponse;
use Darkterminal\LibSQL\Types\HttpStatement;
use Darkterminal\LibSQL\Utils\Exceptions\LibsqlError;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

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
    protected Client $http;
    protected int|float $timeout = 2.0;
    protected string $url;
    protected string|null $authToken;
    protected array $headers = [];

    /**
     * HttpClient constructor.
     *
     * Initializes a new HttpClient instance.
     *
     * @param string $url The base URL for HTTP requests.
     * @param string|null $authToken (Optional) The authentication token for accessing the URL.
     *
     * @throws LibsqlError If attempting to use a remote (turso) database without providing a token.
     */
    public function __construct(string $url, string|null $authToken = null)
    {
        // Check if attempting to use a remote (turso) database without providing a token
        if (\strpos($url, \TURSO) !== false && \is_null($authToken)) {
            throw new LibsqlError("Trying to use remote (turso) database without using token", "INVALID_REMOTE_CONNECTION");
        }

        $this->url = $url;
        $this->authToken = $authToken;

        // Set headers including Authorization if authToken is provided
        if (!empty($this->authToken)) {
            $this->headers = [
                'Authorization' => 'Bearer ' . $this->authToken,
                'Content-Type' => 'Application/json'
            ];
        }

        // Initialize Guzzle HTTP client
        $this->http = new Client([
            'base_uri' => $this->url,
            'timeout'  => $this->timeout,
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
            $request = new Request('GET', '/health', $this->headers);
            $response = $this->http->send($request);
            $code = $response->getStatusCode();
            return $code === 200;
        } catch (\Throwable $e) {
            // If connection fails, throw a LibsqlError
            throw new LibsqlError("Connection failed!", "CONNECTION_ERROR", $e->getCode());
        }
    }

    /**
     * Execute an HTTP statement.
     *
     * @param HttpStatement $stmt The HTTP statement object containing SQL and arguments.
     * @param bool $named_args (Optional) Whether the arguments are named.
     *
     * @return HttpResponse|LibsqlError The HTTP response or a LibsqlError if execution fails.
     * @throws LibsqlError If execution fails.
     */
    public function execute(HttpStatement $stmt, bool $named_args = false): HttpResponse
    {
        try {
            // Create request payload
            $payload = $this->_createRequest($stmt->sql, $stmt->args, $named_args);

            // Send POST request
            $response = $this->http->post(\PIPE_LINE_ENDPOINT, [
                'headers' => $this->headers,
                'json' => $payload
            ]);

            // Process response and return HttpResponse object
            $data = \map_results($response->getBody());
            return HttpResponse::create($data['baton'], $data['base_url'], $data['results']);
        } catch (\Throwable $e) {
            // If execution fails, throw a LibsqlError
            throw new LibsqlError("Execution is failed!", "QUERY_OPERATION_ERROR", $e->getCode());
        }
    }

    /**
     * Create an HTTP request payload.
     *
     * @param string $sql The SQL statement to be executed.
     * @param array|null $args (Optional) The arguments for the SQL statement.
     * @param bool $named_args (Optional) Whether the arguments are named.
     *
     * @return array The HTTP request payload.
     */
    private function _createRequest(string $sql, ?array $args = [], bool $named_args = false): array
    {
        $json = [
            "requests" => []
        ];

        $executeRequest = [
            "type" => "execute",
            "stmt" => [
                "sql" => $sql
            ]
        ];

        // Determine if arguments are positional or named and set accordingly
        if ($named_args === false && !empty($args)) {
            $executeRequest["stmt"]["args"] = $this->_argumentsGenerator($args);
        } else {
            $executeRequest["stmt"]["named_args"] = $this->_namedArgumentsGenerator($args);
        }

        // Add execute request and close request to the payload
        $json["requests"][] = $executeRequest;
        $json["requests"][] = ["type" => "close"];

        return $json;
    }

    /**
     * Generate arguments array for the HTTP request payload.
     *
     * @param mixed $args The arguments to be processed.
     *
     * @return array The generated arguments array.
     * @throws LibsqlError If an invalid argument type is encountered.
     */
    private function _argumentsGenerator($args): array
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
    private function _namedArgumentsGenerator(array $args): array
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
    private function _typeParser(mixed $value): string
    {
        // Check the type of the value using the provided function
        $type = \checkColumnType($value);

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
