<?php

namespace Darkterminal\LibSQL\Types;

use Darkterminal\LibSQL\Types\Authority;

/**
 * Class ExpandedConfig
 *
 * Represents an expanded configuration object.
 */
class ExpandedConfig
{
    public function __construct(
        public string $scheme,
        public bool $tls = false,
        public ?Authority $authority = null,
        public string $path,
        public ?string $authToken = null,
        public ?string $syncUrl = null,
        public ?int $syncInterval = null
    ) {
        $this->scheme = $scheme;
        $this->tls = $tls;
        $this->authority = $authority;
        $this->path = $path;
        $this->authToken = $authToken;
        $this->syncUrl = $syncUrl;
        $this->syncInterval = $syncInterval;
    }

    public static function create(
        string $scheme,
        bool $tls = false,
        ?Authority $authority,
        string $path,
        ?string $authToken = null,
        ?string $syncUrl = null,
        ?int $syncInterval = null
    ): self {
        return new self(
            $scheme,
            $tls,
            $authority,
            $path,
            $authToken,
            $syncUrl,
            $syncInterval
        );
    }

    /**
     * Convert the ExpandedConfig object to an array.
     *
     * @return array An array representation of the ExpandedConfig object.
     */
    public function toArray(): array
    {
        return [
            'scheme' => $this->scheme,
            'tls' => $this->tls,
            'authority' => $this->authority ? $this->authority->toArray() : null,
            'path' => $this->path,
            'authToken' => $this->authToken,
            'syncUrl' => $this->syncUrl,
            'syncInterval' => $this->syncInterval,
        ];
    }

    /**
     * Converts the ExpandedConfig instance to a JSON string.
     *
     * @return string The JSON representation of the ExpandedConfig instance.
     */
    public function toObject(): string
    {
        return \json_encode($this->toArray());
    }
}
