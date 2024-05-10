<?php

namespace Darkterminal\LibSQL\Types;

/**
 * Represents a set of HTTP result data.
 */
class HttpResultSets
{
    /**
     * @var array The columns of the result set.
     */
    public array $cols;

    /**
     * @var array The rows of the result set.
     */
    public array $rows;

    /**
     * @var int The number of affected rows.
     */
    public int $affected_row_count;

    /**
     * @var int The last inserted row ID.
     */
    public int|null $last_insert_rowid;

    /**
     * @var int The replication index.
     */
    public int|string $replication_index;

    /**
     * Constructs a new HttpResultSets instance.
     *
     * @param array $cols The columns of the result set.
     * @param array $rows The rows of the result set.
     * @param int $affected_row_count The number of affected rows.
     * @param int|null $last_insert_rowid The last inserted row ID.
     * @param int|string $replication_index The replication index.
     */
    public function __construct(
        array $cols,
        array $rows,
        int $affected_row_count,
        int|null $last_insert_rowid,
        int|string $replication_index
    ) {
        $this->cols = $cols;
        $this->rows = $rows;
        $this->affected_row_count = $affected_row_count;
        $this->last_insert_rowid = $last_insert_rowid;
        $this->replication_index = $replication_index;
    }

    /**
     * Creates a new HttpResultSets instance.
     *
     * @param array $cols The columns of the result set.
     * @param array $rows The rows of the result set.
     * @param int $affected_row_count The number of affected rows.
     * @param int $last_insert_rowid The last inserted row ID.
     * @param int $replication_index The replication index.
     * @return self The created HttpResultSets instance.
     */
    public static function create(
        array $cols,
        array $rows,
        int $affected_row_count,
        int|null $last_insert_rowid,
        int|string $replication_index
    ): self {
        return new self($cols, $rows, $affected_row_count, $last_insert_rowid, $replication_index);
    }

    /**
     * Converts the HttpResultSets instance to an array.
     *
     * @return array The array representation of the HttpResultSets instance.
     */
    public function toArray(): array
    {
        return [
            'cols' => $this->cols,
            'rows' => $this->rows,
            'affected_row_count' => $this->affected_row_count,
            'last_insert_rowid' => $this->last_insert_rowid,
            'replication_index' => $this->replication_index,
        ];
    }

    /**
     * Converts the HttpResultSets instance to a JSON string.
     *
     * @return string The JSON representation of the HttpResultSets instance.
     */
    public function toObject(): string
    {
        return \json_encode($this->toArray());
    }
}
