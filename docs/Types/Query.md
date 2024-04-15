# Class: Query

Represents the query part of a Uniform Resource Identifier (URI).

### Properties:

- `$pairs` (array): An array of key-value pairs representing the query parameters.

### Constructor

```php
__construct(
    array $pairs
)
```

#### Parameters:
- `$pairs` (array): An array of key-value pairs representing the query parameters.

### Static Method: create

```php
public static function create(
    array $pairs
): self
```

Creates a new `Query` instance.

#### Parameters:
- `$pairs` (array): An array of key-value pairs representing the query parameters.

#### Returns:
- (`Query`): The created `Query` instance.

### Method: toArray

```php
public function toArray(): array
```

Converts the `Query` instance to an associative array.

#### Returns:
- (array): An array representation of the `Query` instance.

### Method: toObject

```php
public function toObject(): string
```

Converts the `Query` instance to a JSON string.

#### Returns:
- (string): The JSON representation of the `Query` instance.
