<?php

namespace Darkterminal\LibSQL\Types;

use Darkterminal\LibSQL\Providers\HttpClient;
use Darkterminal\LibSQL\Utils\Mods;

class HttpTransaction extends HttpClient
{
    protected $baton;

    public function __construct(string $mode)
    {
        $request = $this->_createRequest(\LIBSQL_EXECUTE, Mods::transactionModeToBegin($mode));
        $response = $this->runQuery($this->_makeRequest($request, false), true);
        $data = map_results($response->getBody());
        $this->baton = $data['baton'];
        return $this;
    }

    /**
     * Add a transaction to the transaction batch.
     *
     * @param HttpStatement $query The HTTP statement to add to the transaction.
     *
     * @return self The current instance of HttpClient.
     */
    public function addTransaction(HttpStatement $query): self
    {
        \array_push($this->collectors, $this->_createRequest(\LIBSQL_EXECUTE, $query->sql, $query->args, $query->named_args));
        return $this;
    }

    /**
     * End the current transaction batch and commit the transactions.
     *
     * @return HttpResponse The HTTP response containing the results of the transaction batch.
     */
    public function endTransaction(): HttpResponse
    {
        \array_push($this->collectors, $this->_rawCommit());
        $response = $this->runQuery($this->_makeRequest($this->collectors, true, $this->baton), true);
        $data = map_results($response->getBody());
        return HttpResponse::create($data['baton'], $data['base_url'], $data['results']);
    }

    /**
     * Rollback the current transaction.
     */
    public function rollback(): void
    {
        $this->runQuery($this->_makeRequest($this->_createRequest(\LIBSQL_EXECUTE, 'ROLLBACK'), true, $this->baton));
    }

    protected function _rawRollback(): array
    {
        return $this->_createRequest(\LIBSQL_EXECUTE, 'ROLLBACK');
    }

    /**
     * Commit the current transaction.
     */
    public function commit(): void
    {
        $this->runQuery($this->_makeRequest($this->_createRequest(\LIBSQL_EXECUTE, 'COMMIT'), true, $this->baton));
    }

    protected function _rawCommit(): array
    {
        return $this->_createRequest(\LIBSQL_EXECUTE, 'COMMIT');
    }
}
