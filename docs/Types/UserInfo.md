# Class: UserInfo

Represents the userInfo part of a Uniform Resource Identifier (URI) authority.

### Properties:

- `$username` (string|null): The username component of the userInfo part.
- `$password` (string|null): The password component of the userInfo part.

### Constructor

```php
__construct(
    string|null $username,
    ?string $password = ''
)
```

#### Parameters:
- `$username` (string|null): The username component of the userInfo part.
- `$password` (string|null): The password component of the userInfo part (default: `''`).

### Static Method: create

```php
public static function create(
    string|null $username,
    ?string $password = ''
): self
```

Creates a new `UserInfo` instance.

#### Parameters:
- `$username` (string|null): The username component of the userInfo part.
- `$password` (string|null): The password component of the userInfo part (default: `''`).

#### Returns:
- (`UserInfo`): The created `UserInfo` instance.

### Method: toArray

```php
public function toArray(): array
```

Converts the `UserInfo` instance to an associative array.

#### Returns:
- (array): An array representation of the `UserInfo` instance.

### Method: toObject

```php
public function toObject(): string
```

Converts the `UserInfo` instance to a JSON string.

#### Returns:
- (string): The JSON representation of the `UserInfo` instance.
