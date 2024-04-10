<?php

namespace Darkterminal\LibSQL\Types;

/**
 * Class UserInfo
 *
 * Represents the userInfo part of a URI authority.
 */
class UserInfo
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
     * Convert the UserInfo object to an array.
     *
     * @return array An array representation of the UserInfo object.
     */
    public function toArray(): array
    {
        return [
            'username' => $this->username,
            'password' => !empty($this->password) ? $this->password : null
        ];
    }
}
