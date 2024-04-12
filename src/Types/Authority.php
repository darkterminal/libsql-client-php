<?php

namespace Darkterminal\LibSQL\Types;

/**
 * Class Authority
 *
 * Represents the authority part of a URI.
 */
class Authority
{
    public function __construct(
        public string $host,
        public ?int $port,
        public ?UserInfo $userInfo
    ) {
        $this->host = $host;
        $this->port = $port;
        $this->userInfo = $userInfo;
    }

    public static function create(
        string $host,
        ?int $port,
        ?UserInfo $userInfo
    ): self
    {
        return new self($host, $port, $userInfo);
    }

    /**
     * Convert the Authority object to an array.
     *
     * @return array An array representation of the Authority object.
     */
    public function toArray(): array
    {
        return [
            'host' => $this->host,
            'port' => !empty($this->port) ? $this->port : null,
            'userInfo' => !empty($this->userInfo) ? $this->userInfo->toArray() : null
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
