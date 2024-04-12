<?php

namespace Darkterminal\LibSQL\Types;

/**
 * Configuration object for createClient.
 *
 * The client supports libsql:, http:/https:, ws:/wss: and file: URL. For more information,
 * please refer to the project README:
 *
 * https://github.com/libsql/libsql-client-php#supported-urls
 */
class Config
{
    /**
     * Constructor.
     * @param string $url The database URL.
     * @param string|null $authToken Authentication token for the database.
     * @param string|null $encryptionKey Encryption key for the database.
     * @param string|null $syncUrl URL of a remote server to synchronize database with.
     * @param int|null $syncInterval Sync interval in seconds.
     * @param bool|null $tls Enables or disables TLS for libsql: URLs.
     */
    public function __construct(
        public string $url,
        public ?string $authToken = null,
        public ?string $encryptionKey = null,
        public ?string $syncUrl = null,
        public ?int $syncInterval = null,
        public ?bool $tls = null
    ) {
        $this->url = $url;
        $this->authToken = $authToken;
        $this->encryptionKey = $encryptionKey;
        $this->syncUrl = $syncUrl;
        $this->syncInterval = $syncInterval;
        $this->tls = $tls;
    }

    public static function create(
        string $url,
        ?string $authToken = null,
        ?string $encryptionKey = null,
        ?string $syncUrl = null,
        ?int $syncInterval = null,
        ?bool $tls = null
    ): self {
        return new self(
            $url,
            $authToken,
            $encryptionKey,
            $syncUrl,
            $syncInterval,
            $tls
        );
    }

    /**
     * Convert the Config to an array.
     * @return array The Config properties as an array.
     */
    public function toArray(): array
    {
        return [
            'url' => $this->url,
            'authToken' => $this->authToken,
            'encryptionKey' => $this->encryptionKey,
            'syncUrl' => $this->syncUrl,
            'syncInterval' => $this->syncInterval,
            'tls' => $this->tls,
        ];
    }

    /**
     * Converts the HttpResponse instance to a JSON string.
     *
     * @return string The JSON representation of the HttpResponse instance.
     */
    public function toObject(): string
    {
        return \json_encode($this->toArray());
    }
}
