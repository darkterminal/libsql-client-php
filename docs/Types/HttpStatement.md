# Class: HttpStatement

Represents an HTTP statement with SQL and optional arguments.

### Properties:

- `$sql` (string): The SQL statement.
- `$args` (array|null): The optional arguments for the SQL statement.
- `$named_args` (bool|null): Indicates whether the arguments for the SQL statement are named.

### Constructor

```php
__construct(
    string $sql,
    ?array $args = [],
    ?bool $named_args = false
)
```

#### Parameters:
- `$sql` (string): The SQL statement.
- `$args` (array|null): The optional arguments for the SQL statement (default: `[]`).
- `$named_args` (bool|null): Indicates whether the arguments for the SQL statement are named (default: `false`).

### Static Method: create

```php
public static function create(
    string $sql,
    ?array $args = [],
    ?bool $named_args = false
): self
```

Creates a new `HttpStatement` instance.

#### Parameters:
- `$sql` (string): The SQL statement.
- `$args` (array|null): The optional arguments for the SQL statement (default: `[]`).
- `$named_args` (bool|null): Indicates whether the arguments for the SQL statement are named (default: `false`).

#### Returns:
- (`HttpStatement`): The created `HttpStatement` instance.

### Method: toArray

```php
public function toArray(): array
```

Converts the `HttpStatement` instance to an associative array.

#### Returns:
- (array): The array representation of the `HttpStatement` instance.

### Method: toObject

```php
public function toObject(): string
```

Converts the `HttpStatement` instance to a JSON string.

#### Returns:
- (string): The JSON representation of the `HttpStatement` instance.
