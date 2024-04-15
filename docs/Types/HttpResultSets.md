# Class: HttpResultSets

Represents a set of HTTP result data.

### Properties:

- `$cols` (array): The columns of the result set.
- `$rows` (array): The rows of the result set.
- `$affected_row_count` (int): The number of affected rows.
- `$last_insert_rowid` (int|null): The last inserted row ID.
- `$replication_index` (int|string): The replication index.

### Constructor

```php
__construct(
    array $cols,
    array $rows,
    int $affected_row_count,
    int|null $last_insert_rowid,
    int|string $replication_index
)
```

#### Parameters:
- `$cols` (array): The columns of the result set.
- `$rows` (array): The rows of the result set.
- `$affected_row_count` (int): The number of affected rows.
- `$last_insert_rowid` (int|null): The last inserted row ID.
- `$replication_index` (int|string): The replication index.

### Static Method: create

```php
public static function create(
    array $cols,
    array $rows,
    int $affected_row_count,
    int|null $last_insert_rowid,
    int|string $replication_index
): self
```

Creates a new `HttpResultSets` instance.

#### Parameters:
- `$cols` (array): The columns of the result set.
- `$rows` (array): The rows of the result set.
- `$affected_row_count` (int): The number of affected rows.
- `$last_insert_rowid` (int|null): The last inserted row ID.
- `$replication_index` (int|string): The replication index.

#### Returns:
- (`HttpResultSets`): The created `HttpResultSets` instance.

### Method: toArray

```php
public function toArray(): array
```

Converts the `HttpResultSets` instance to an associative array.

#### Returns:
- (array): The array representation of the `HttpResultSets` instance.

### Method: toObject

```php
public function toObject(): string
```

Converts the `HttpResultSets` instance to a JSON string.

#### Returns:
- (string): The JSON representation of the `HttpResultSets` instance.
