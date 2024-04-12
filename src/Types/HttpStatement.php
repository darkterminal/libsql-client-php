<?php

namespace Darkterminal\LibSQL\Types;

/**
 * Represents an HTTP statement with SQL and optional arguments.
 */
class HttpStatement
{
    /**
     * @var string The SQL statement.
     */
    public string $sql;

    /**
     * @var array|null The optional arguments for the SQL statement.
     */
    public ?array $args;

    /**
     * Constructs a new HttpStatement instance.
     *
     * @param string $sql The SQL statement.
     * @param array|null $args The optional arguments for the SQL statement.
     */
    public function __construct(
        string $sql,
        ?array $args = []
    ) {
        $this->sql = $sql;
        $this->args = $args;
    }

    /**
     * Creates a new HttpStatement instance.
     *
     * @param string $sql The SQL statement.
     * @param array|null $args The optional arguments for the SQL statement.
     * @return self The created HttpStatement instance.
     */
    public static function create(
        string $sql,
        ?array $args = []
    ): self {
        return new self($sql, $args);
    }

    /**
     * Converts the HttpStatement instance to an array.
     *
     * @return array The array representation of the HttpStatement instance.
     */
    public function toArray(): array
    {
        return [
            'sql' => $this->sql,
            'args' => $this->args
        ];
    }

    /**
     * Converts the HttpStatement instance to a JSON string.
     *
     * @return string The JSON representation of the HttpStatement instance.
     */
    public function toObject(): string
    {
        return \json_encode($this->toArray());
    }
}
