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
        public ?int $flags,
        public ?string $encryptionKey,
        public ?bool $tls = false,
        public ?Authority $authority = null,
        public ?string $path,
        public ?string $authToken = null,
        public ?string $syncUrl = null,
        public ?int $syncInterval = null,
        public ?bool $read_your_writes = true
    ) {
        $this->scheme = $scheme;
        $this->flags = $flags;
        $this->encryptionKey = $encryptionKey;
        $this->tls = $tls;
        $this->authority = $authority;
        $this->path = $path;
        $this->authToken = $authToken;
        $this->syncUrl = $syncUrl;
        $this->syncInterval = $syncInterval;
        $this->read_your_writes = $read_your_writes;
    }

    public static function create(
        string $scheme,
        ?int $flags,
        ?string $encryptionKey = "",
        ?bool $tls = false,
        ?Authority $authority,
        ?string $path,
        ?string $authToken = null,
        ?string $syncUrl = null,
        ?int $syncInterval = null,
        ?bool $read_your_writes = true
    ): self {
        return new self(
            $scheme,
            $flags,
            $encryptionKey,
            $tls,
            $authority,
            $path,
            $authToken,
            $syncUrl,
            $syncInterval,
            $read_your_writes
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
            'flags' => $this->flags,
            'encryptionKey' => $this->encryptionKey,
            'tls' => $this->tls,
            'authority' => $this->authority ? $this->authority->toArray() : null,
            'path' => $this->path,
            'authToken' => $this->authToken,
            'syncUrl' => $this->syncUrl,
            'syncInterval' => $this->syncInterval,
            'read_your_writes' => $this->read_your_writes,
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
