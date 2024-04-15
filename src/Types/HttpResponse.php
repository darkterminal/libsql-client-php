<?php

namespace Darkterminal\LibSQL\Types;

use Darkterminal\LibSQL\Traits\MapResults;
use Darkterminal\LibSQL\Utils\Exceptions\LibsqlError;
use LibSQLResult;

/**
 * Represents an HTTP response from LibSQL Server with necessary data.
 */
class HttpResponse
{
    use MapResults;
    /**
     * @var string The baton identifier.
     */
    public string|null $baton;

    /**
     * @var string The base URL for the HTTP response.
     */
    public string|null $base_url;

    /**
     * @var array|HttpResultSets The HTTP result sets.
     */
    public array|HttpResultSets $results;

    /**
     * Constructs a new HttpResponse instance.
     *
     * @param string|null $baton The baton identifier.
     * @param string|null $base_url The base URL for the HTTP response.
     * @param array|HttpResultSets $results The HTTP result sets.
     */
    public function __construct(
        string|null $baton,
        string|null $base_url,
        array|HttpResultSets $results
    ) {
        $this->baton = $baton;
        $this->base_url = $base_url;
        $this->results = $results;
    }

    /**
     * Creates a new HttpResponse instance.
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
     * Converts the HttpResponse instance to an array.
     *
     * @return array The array representation of the HttpResponse instance.
     */
    public function toArray(): array
    {
        return [
            'baton' => $this->baton,
            'base_url' => $this->base_url,
            'results' => $this->results
        ];
    }

    /**
     * Converts the HttpResponse instance to a JSON string.
     *
     * @return string The JSON representation of the HttpResponse instance.
     */
    public function toObject(): string
    {
        return \json_encode($this->toArray());
    }

    public function first(): self
    {
        $result = \current($this->results);
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
     * Fetch the results in the specified format.
     *
     * @param LibSQLResult $type (Optional) The format in which to fetch the results. Default is LibSQLResult::FETCH_ASSOC.
     *
     * @return array|string The fetched results.
     *
     * @throws LibsqlError If an undefined fetch option is provided.
     */
    public function fetch(LibSQLResult $type = LibSQLResult::FETCH_ASSOC): array|string
    {
        $result = \current($this->results);
        switch ($type) {
            case LibSQLResult::FETCH_ASSOC:
                return $this->fetchArray($result);
                break;
            case LibSQLResult::FETCH_OBJ:
                return $this->fetchObject($result);
                break;

            default:
                throw new LibsqlError("Error Undefined fetch options", "UNDEFINED_FETCH_OPTIONS");
                break;
        }
    }

}
