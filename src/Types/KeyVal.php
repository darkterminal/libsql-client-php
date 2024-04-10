<?php

namespace Darkterminal\LibSQL\Types;

/**
 * Class KeyValue
 *
 * Represents a key-value pair in a query string.
 */
class KeyValue
{
    public function __construct(
        public string $key,
        public string $value
    ) {
        $this->key = $key;
        $this->value = $value;
    }

    public static function create(
        string $key,
        string $value
    ): self
    {
        return new self($key, $value);
    }

    /**
     * Convert the KeyValue object to an array.
     *
     * @return array An array representation of the KeyValue object.
     */
    public function toArray(): array
    {
        return [
            'key' => $this->key,
            'value' => $this->value,
        ];
    }
}
