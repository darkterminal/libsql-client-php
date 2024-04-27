<?php

namespace Darkterminal\LibSQL\Providers;

use Darkterminal\LibSQL\Utils\Exceptions\LibsqlError;
use Darkterminal\LibSQLPHPExtension\LibSQLPHP;
use Darkterminal\LibSQLPHPExtension\Responses\LibSQLPHPClientResult;
use Darkterminal\LibSQLPHPExtension\Responses\Transaction;
use Darkterminal\LibSQLPHPExtension\Utils\TransactionBehavior;

/**
 * LocalClient provides functionality to interact with a local LibSQL database.
 *
 * This class allows establishing connections, executing SQL queries, managing transactions,
 * and performing other database operations on a local LibSQL database.
 *
 * @package Darkterminal\LibSQL\Providers
 */
class LocalClient
{
    /**
     * @var LibSQLPHP The LibSQLPHP instance representing the database connection.
     */
    protected LibSQLPHP $db;

    /**
     * @var string The path to the local database file.
     */
    protected string $path;

    /**
     * @var int|null The optional flags to use when opening the database file.
     */
    protected int|null $flags;

    /**
     * @var string The encryption key used to access the database file.
     */
    protected string $encryptionKey;

    /**
     * Sets up the LocalClient with the provided configuration.
     *
     * @param string $path The path to the local database file.
     * @param int|null $flags Optional flags to use when opening the database file.
     * @param string $encryptionKey The encryption key used to access the database file.
     * @return void
     */
    public function setup(string $path, int|null $flags, string $encryptionKey = ""): void
    {
        $this->path = $path;
        $this->flags = $flags;
        $this->encryptionKey = $encryptionKey;
        $this->db = new LibSQLPHP($this->path, $this->flags, $this->encryptionKey);
    }

    /**
     * Establishes a connection to the local LibSQL database.
     *
     * @return bool True if the connection is successful, false otherwise.
     */
    public function connect(): bool
    {
        return $this->db->is_connected();
    }

    /**
     * Executes an SQL query on the local database.
     *
     * @param string $sql The SQL query to execute.
     * @param array $params Optional parameters to bind to the query.
     * @return LibSQLPHPClientResult The result of the query execution.
     */
    public function execute(string $sql, array $params = []): LibSQLPHPClientResult
    {
        return $this->db->client_exec($sql, $params);
    }

    /**
     * Executes a batch of SQL queries on the local database.
     *
     * @param string $sql The batch of SQL queries to execute.
     * @return void
     */
    public function batch(string $sql): void
    {
        $this->db->execute_batch($sql);
    }

    /**
     * Initiates a transaction on the local database.
     *
     * @param string $mode The transaction mode: 'write', 'read', or 'deferred'.
     * @return Transaction The transaction object representing the initiated transaction.
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
     * Closes the connection to the local LibSQL database.
     *
     * @return void
     */
    public function close(): void
    {
        $this->db->close();
    }

    /**
     * Retrieves the version of the local LibSQL database.
     *
     * @return string The version of the local LibSQL database.
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
