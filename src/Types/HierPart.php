<?php

namespace Darkterminal\LibSQL\Types;

/**
 * Class HierPart
 *
 * Represents the hierarchical part of a URI.
 */
class HierPart
{
    public function __construct(
        public ?Authority $authority,
        public string $path
    ) {
        $this->authority = $authority;
        $this->path = $path;
    }

    public static function create(
        ?Authority $authority,
        string $path
    ): self
    {
        return new self($authority, $path);
    }

    /**
     * Convert the HierPart object to an array.
     *
     * @return array An array representation of the HierPart object.
     */
    public function toArray(): array
    {
        return [
            'authority' => !empty($this->authority) ? $this->authority->toArray() : null,
            'path' => $this->path
        ];
    }
}
