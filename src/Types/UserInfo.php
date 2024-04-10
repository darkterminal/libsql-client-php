<?php

namespace Darkterminal\LibSQL\Types;

/**
 * Class Userinfo
 *
 * Represents the userinfo part of a URI authority.
 */
class Userinfo
{
    public function __construct(
        public string $username,
        public ?string $password = '',
    ) {
        $this->username = $username;
        $this->password = $password;
    }

    public static function create(
        string $username,
        ?string $password = ''
    ): self
    {
        return new self($username, $password);
    }

    /**
     * Convert the Userinfo object to an array.
     *
     * @return array An array representation of the Userinfo object.
     */
    public function toArray(): array
    {
        return [
            'username' => $this->username,
            'password' => !empty($this->password) ? $this->password : null
        ];
    }
}
