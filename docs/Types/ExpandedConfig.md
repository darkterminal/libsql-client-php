# Class: ExpandedConfig

Represents an expanded configuration object.

### Constructor

```php
__construct(
    string $scheme,
    bool $tls = false,
    ?Authority $authority = null,
    string $path,
    ?string $authToken = null,
    ?string $syncUrl = null,
    ?int $syncInterval = null
)
```

#### Parameters:
- `$scheme` (string): The scheme part of the URI.
- `$tls` (bool): Indicates whether TLS is enabled (default: false).
- `$authority` (Authority|null): An instance of the `Authority` class representing the authority part of the URI (nullable).
- `$path` (string): The path part of the URI.
- `$authToken` (string|null): Authentication token for the configuration (nullable).
- `$syncUrl` (string|null): URL of a remote server to synchronize with (nullable).
- `$syncInterval` (int|null): Sync interval in seconds (nullable).

### Static Method: create

```php
public static function create(
    string $scheme,
    bool $tls = false,
    ?Authority $authority,
    string $path,
    ?string $authToken = null,
    ?string $syncUrl = null,
    ?int $syncInterval = null
): self
```

Creates a new `ExpandedConfig` instance.

#### Parameters:
- `$scheme` (string): The scheme part of the URI.
- `$tls` (bool): Indicates whether TLS is enabled (default: false).
- `$authority` (Authority|null): An instance of the `Authority` class representing the authority part of the URI (nullable).
- `$path` (string): The path part of the URI.
- `$authToken` (string|null): Authentication token for the configuration (nullable).
- `$syncUrl` (string|null): URL of a remote server to synchronize with (nullable).
- `$syncInterval` (int|null): Sync interval in seconds (nullable).

#### Returns:
- (`ExpandedConfig`): A new `ExpandedConfig` instance.

### Method: toArray

```php
public function toArray(): array
```

Converts the `ExpandedConfig` object to an associative array.

#### Returns:
- (array): An array representation of the `ExpandedConfig` object.

### Method: toObject

```php
public function toObject(): string
```

Converts the `ExpandedConfig` object to a JSON string.

#### Returns:
- (string): The JSON representation of the `ExpandedConfig` object.
