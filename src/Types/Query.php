<?php

namespace Darkterminal\LibSQL\Types;

/**
 * Class Query
 *
 * Represents the query part of a URI.
 */
class Query
{
    public function __construct(public array $pairs)
    {
        $this->pairs = $pairs;
    }

    public static function create(array $pairs): self
    {
        return new self($pairs);
    }

    /**
     * Convert the Query object to an array.
     *
     * @return array An array representation of the Query object.
     */
    public function toArray(): array
    {
        return ['pairs' => $this->pairs];
    }

    /**
     * Converts the Query instance to a JSON string.
     *
     * @return string The JSON representation of the Query instance.
     */
    public function toObject(): string
    {
        return \json_encode($this->toArray());
    }
}
