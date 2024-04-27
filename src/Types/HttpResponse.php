<?php

namespace Darkterminal\LibSQL\Types;

use Darkterminal\LibSQL\Traits\MapResults;
use Darkterminal\LibSQL\Utils\Exceptions\LibsqlError;

/**
 * Represents an HTTP response from LibSQL Server with necessary data.
 */
class HttpResponse
{
    use MapResults;

    /**
     * Constructs a new HttpResponse instance.
     *
     * @param string|null $baton The baton identifier.
     * @param string|null $base_url The base URL for the HTTP response.
     * @param array|HttpResultSets $results The HTTP result sets.
     */
    public function __construct(
        public string|null $baton,
        public string|null $base_url,
        public array|HttpResultSets $results
    ) {
        $this->baton = $baton;
        $this->base_url = $base_url;
        $this->results = $results;
    }

    /**
     * Creates a new HttpResponse instance.
     *
     * This method creates a new instance of the HttpResponse class.
     *
     * @param string|null $baton The baton identifier.
     * @param string|null $base_url The base URL for the HTTP response.
     * @param array|HttpResultSets $results The HTTP result sets.
     * @return self The created HttpResponse instance.
     */
    public static function create(
        string|null $baton,
        string|null $base_url,
        array|HttpResultSets $results
    ): self {
        return new self($baton, $base_url, $results);
    }


    /**
     * Convert the result set to an associative array.
     *
     * This method converts the result set to an associative array representation.
     * It includes the baton, base URL, and the results converted to an array using the `objectToArray()` function.
     *
     * @return array An associative array representation of the result set containing baton, base URL, and results.
     */
    public function toArray(): array
    {
        return [
            'baton' => $this->baton,
            'base_url' => $this->base_url,
            'results' => \objectToArray($this->results)
        ];
    }


    /**
     * Convert the result set to a JSON-encoded string.
     *
     * This method converts the result set to a JSON-encoded string representation.
     * It internally uses the `toArray()` method to convert the result set to an associative array
     * before encoding it as JSON.
     *
     * @return string The JSON-encoded string representation of the result set.
     */
    public function toObject(): string
    {
        return \json_encode($this->toArray());
    }


    /**
     * Retrieve the first result set from the query execution.
     *
     * This method returns a new instance of the current class containing the first result set
     * obtained from the executed query. It converts the internal result object to an array and
     * extracts the first element to create a new instance.
     *
     * @return self A new instance of the current class containing the first result set.
     */
    public function first(): self
    {
        $data = \objectToArray($this->results);
        $result = \current($data);
        return new self(
            $this->baton,
            $this->base_url,
            HttpResultSets::create(
                $result['cols'],
                $result['rows'],
                $result['affected_row_count'],
                $result['last_insert_rowid'],
                $result['replication_index']
            )
        );
    }

    /**
     * Fetch the result set from the query execution.
     *
     * This method retrieves the result set from the executed query and returns it in the specified format.
     * It converts the internal result object to an array and switches based on the provided type parameter
     * to determine the format of the returned data.
     *
     * @param int $type The type of fetch operation. Default is LibSQLResult::FETCH_ASSOC.
     * @return array|string The result set in the specified format.
     * @throws LibsqlError When an undefined fetch option is provided.
     */
    public function fetch(int $type = LibSQLResult::FETCH_ASSOC): array|string
    {
        $results = objectToArray($this->results);
        switch ($type) {
            case LibSQLResult::FETCH_ASSOC:
                return $this->fetchArray($results);
                break;
            case LibSQLResult::FETCH_OBJ:
                return $this->fetchObject($results);
                break;
            default:
                throw new LibsqlError("Error Undefined fetch options", "UNDEFINED_FETCH_OPTIONS");
                break;
        }
    }
}
