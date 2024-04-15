# Class: Uri

Represents a Uniform Resource Identifier (URI) object.

### Properties:

- `$scheme` (string): The scheme component of the URI.
- `$authority` (Authority|null): The authority component of the URI.
- `$path` (string): The path component of the URI.
- `$query` (Query|null): The query component of the URI.
- `$fragment` (string|null): The fragment component of the URI.

### Constructor

```php
__construct(
    string $scheme,
    ?Authority $authority = null,
    string $path = '',
    ?Query $query = null,
    ?string $fragment = ''
)
```

#### Parameters:
- `$scheme` (string): The scheme component of the URI.
- `$authority` (Authority|null): The authority component of the URI (default: `null`).
- `$path` (string): The path component of the URI (default: `''`).
- `$query` (Query|null): The query component of the URI (default: `null`).
- `$fragment` (string|null): The fragment component of the URI (default: `''`).

### Static Method: create

```php
public static function create(
    string $scheme,
    ?Authority $authority = null,
    string $path = '',
    ?Query $query = null,
    ?string $fragment = ''
): self
```

Creates a new `Uri` instance.

#### Parameters:
- `$scheme` (string): The scheme component of the URI.
- `$authority` (Authority|null): The authority component of the URI (default: `null`).
- `$path` (string): The path component of the URI (default: `''`).
- `$query` (Query|null): The query component of the URI (default: `null`).
- `$fragment` (string|null): The fragment component of the URI (default: `''`).

#### Returns:
- (`Uri`): The created `Uri` instance.

### Method: toArray

```php
public function toArray(): array
```

Converts the `Uri` instance to an associative array.

#### Returns:
- (array): An array representation of the `Uri` instance.

### Method: toObject

```php
public function toObject(): string
```

Converts the `Uri` instance to a JSON string.

#### Returns:
- (string): The JSON representation of the `Uri` instance.
