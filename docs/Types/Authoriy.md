# Class: Authority

Represents the authority part of a Uniform Resource Identifier (URI).

### Constructor

```php
__construct(
    string $host,
    ?int $port,
    ?UserInfo $userInfo
)
```

#### Parameters:
- `$host` (string): The hostname or IP address of the authority.
- `$port` (int|null): The port number of the authority (nullable).
- `$userInfo` (UserInfo|null): An optional instance of the `UserInfo` class representing user information associated with the authority.

### Static Method: create

```php
public static function create(
    string $host,
    ?int $port,
    ?UserInfo $userInfo
): self
```

Creates a new `Authority` instance.

#### Parameters:
- `$host` (string): The hostname or IP address of the authority.
- `$port` (int|null): The port number of the authority (nullable).
- `$userInfo` (UserInfo|null): An optional instance of the `UserInfo` class representing user information associated with the authority.

#### Returns:
- (`Authority`): A new `Authority` instance.

### Method: toArray

```php
public function toArray(): array
```

Converts the `Authority` object to an associative array.

#### Returns:
- (array): An array representation of the `Authority` object.

### Method: toObject

```php
public function toObject(): string
```

Converts the `Authority` object to a JSON string.

#### Returns:
- (string): The JSON representation of the `Authority` object.
