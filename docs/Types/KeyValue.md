# Class: KeyValue

Represents a key-value pair in a query string.

### Properties:

- `$key` (string): The key of the key-value pair.
- `$value` (string): The value of the key-value pair.

### Constructor

```php
__construct(
    string $key,
    string $value
)
```

#### Parameters:
- `$key` (string): The key of the key-value pair.
- `$value` (string): The value of the key-value pair.

### Static Method: create

```php
public static function create(
    string $key,
    string $value
): self
```

Creates a new `KeyValue` instance.

#### Parameters:
- `$key` (string): The key of the key-value pair.
- `$value` (string): The value of the key-value pair.

#### Returns:
- (`KeyValue`): The created `KeyValue` instance.

### Method: toArray

```php
public function toArray(): array
```

Converts the `KeyValue` instance to an associative array.

#### Returns:
- (array): The array representation of the `KeyValue` instance.

### Method: toObject

```php
public function toObject(): string
```

Converts the `KeyValue` instance to a JSON string.

#### Returns:
- (string): The JSON representation of the `KeyValue` instance.
