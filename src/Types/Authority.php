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
        public ?Userinfo $userinfo
    ) {
        $this->host = $host;
        $this->port = $port;
        $this->userinfo = $userinfo;
    }

    public static function create(
        string $host,
        ?int $port,
        ?Userinfo $userinfo
    ): self
    {
        return new self($host, $port, $userinfo);
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
            'userinfo' => !empty($this->userinfo) ? $this->userinfo->toArray() : null
        ];
    }
}
