<?php

namespace Darkterminal\LibSQL\Providers;

use Darkterminal\LibSQL\Utils\Exceptions\LibsqlError;
use Darkterminal\LibSQLPHPExtension\LibSQLPHP;
use Darkterminal\LibSQLPHPExtension\Responses\LibSQLPHPClientResult;
use Darkterminal\LibSQLPHPExtension\Responses\Transaction;
use Darkterminal\LibSQLPHPExtension\Utils\TransactionBehavior;

/**
 * Represents a client for interacting with a remote replica database.
 */
class RemoteReplicaClient
{
    private LibSQLPHP $db;

    /**
     * Constructor.
     * 
     * Initializes a new instance of the RemoteReplicaClient class.
     *
     * @param string $path The path to the remote replica database.
     * @param string $authToken The authentication token for accessing the remote replica.
     * @param string $syncUrl The URL for syncing data with the remote replica.
     * @param int $syncInterval The interval (in seconds) for syncing data. Default: 5 seconds.
     * @param bool $read_your_writes Enable read-your-writes consistency. Default: true.
     */
    public function __construct(
        protected string $path,
        protected string $authToken,
        protected string $syncUrl,
        protected int $syncInterval = 5,
        protected bool $read_your_writes = true,
    ) {
        $this->path = $path;
        $this->authToken = $authToken;
        $this->syncUrl = $syncUrl;
        $this->syncInterval = $syncInterval;
        $this->read_your_writes = $read_your_writes;
        $this->db = new LibSQLPHP(
            path: $this->path,
            url: $this->syncUrl,
            token: $this->authToken,
            sync_interval: $this->syncInterval,
            read_your_writes: $this->read_your_writes
        );
    }

    /**
     * Checks if the client is connected to the remote replica database.
     *
     * @return bool True if connected, false otherwise.
     */
    public function connect(): bool
    {
        return $this->db->is_connected();
    }

    /**
     * Executes a SQL query on the remote replica database.
     *
     * @param string $sql The SQL query to execute.
     * @param array $params The parameters for the SQL query.
     * @return LibSQLPHPClientResult The result of the query execution.
     */
    public function execute(string $sql, array $params = []): LibSQLPHPClientResult
    {
        return $this->db->client_exec($sql, $params);
    }

    /**
     * Executes a batch of SQL queries on the remote replica database.
     *
     * @param string $sql The batch of SQL queries to execute.
     * @return void
     */
    public function batch(string $sql): void
    {
        $this->db->execute_batch($sql);
    }

    /**
     * Starts a transaction on the remote replica database.
     *
     * @param string $mode The mode of the transaction ('write', 'read', or 'deferred').
     * @return Transaction The transaction object.
     */
    public function transaction(string $mode): Transaction
    {
        switch ($mode) {
            case 'write':
                $mode = TransactionBehavior::Immediate;
                break;
            case 'read':
                $mode = TransactionBehavior::ReadOnly;
                break;
            case 'deferred':
                $mode = TransactionBehavior::Deferred;
                break;
        }

        return $this->db->transaction($mode);
    }

    /**
     * Closes the connection to the remote replica database.
     *
     * @return void
     */
    public function close(): void
    {
        $this->db->close();
    }

    /**
     * Syncs data with the remote replica database.
     *
     * @return int The result of the sync operation (0 for success, non-zero for failure).
     */
    public function sync(): int
    {
        $exec = $this->db->sync();
        return $exec === 0;
    }

    /**
     * Retrieves the version of the remote replica database.
     *
     * @return string The version of the remote replica database.
     *
     * @throws LibsqlError If an error occurs while retrieving the version.
     */
    public function version(): string
    {
        try {
            return $this->db->version();
        } catch (\Exception $e) {
            throw new LibsqlError($e->getMessage(), "ERR_GET_VERSION");
        }
    }
}
