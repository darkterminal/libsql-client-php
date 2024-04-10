<?php

namespace Darkterminal\LibSQL\Types;

/**
 * Class Uri
 *
 * Represents a URI object.
 */
class Uri
{
    public function __construct(
        public string $scheme,
        public ?Authority $authority = null,
        public string $path = '',
        public ?Query $query = null,
        public ?string $fragment = ''
    ) {
        $this->scheme = $scheme;
        $this->authority = $authority;
        $this->path = $path;
        $this->query = $query;
        $this->fragment = $fragment;
    }

    public static function create(
        string $scheme,
        ?Authority $authority = null,
        string $path = '',
        ?Query $query = null,
        ?string $fragment = ''
    ): self
    {
        return new self(
            $scheme,
            $authority,
            $path,
            $query,
            $fragment
        );
    }

    /**
     * Convert the Uri object to an array.
     *
     * @return array An array representation of the Uri object.
     */
    public function toArray(): array
    {
        return [
            'scheme' => $this->scheme,
            'authority' => !empty($this->authority) ? $this->authority->toArray() : null,
            'path' => $this->path,
            'query' => !empty($this->query) ? $this->query->toArray() : null,
            'fragment' => $this->fragment
        ];
    }
}
