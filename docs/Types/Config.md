# Class: Config

Configuration object for creating a client.

The client supports `libsql:`, `http:/https:`, `ws:/wss:`, and `file:` URLs. For more information, please refer to the project README: [libsql-client-php Supported URLs](https://github.com/libsql/libsql-client-php#supported-urls).

### Constructor

```php
__construct(
    string $url,
    ?string $authToken = null,
    ?string $encryptionKey = null,
    ?string $syncUrl = null,
    ?int $syncInterval = null,
    ?bool $tls = null
)
```

#### Parameters:
- `$url` (string): The database URL.
- `$authToken` (string|null): Authentication token for the database (nullable).
- `$encryptionKey` (string|null): Encryption key for the database (nullable).
- `$syncUrl` (string|null): URL of a remote server to synchronize the database with (nullable).
- `$syncInterval` (int|null): Sync interval in seconds (nullable).
- `$tls` (bool|null): Enables or disables TLS for `libsql:` URLs (nullable).

### Static Method: create

```php
public static function create(
    string $url,
    ?string $authToken = null,
    ?string $encryptionKey = null,
    ?string $syncUrl = null,
    ?int $syncInterval = null,
    ?bool $tls = null
): self
```

Creates a new `Config` instance.

#### Parameters:
- `$url` (string): The database URL.
- `$authToken` (string|null): Authentication token for the database (nullable).
- `$encryptionKey` (string|null): Encryption key for the database (nullable).
- `$syncUrl` (string|null): URL of a remote server to synchronize the database with (nullable).
- `$syncInterval` (int|null): Sync interval in seconds (nullable).
- `$tls` (bool|null): Enables or disables TLS for `libsql:` URLs (nullable).

#### Returns:
- (`Config`): A new `Config` instance.

### Method: toArray

```php
public function toArray(): array
```

Converts the `Config` object to an associative array.

#### Returns:
- (array): The `Config` properties as an array.

### Method: toObject

```php
public function toObject(): string
```

Converts the `Config` object to a JSON string.

#### Returns:
- (string): The JSON representation of the `Config` object.
