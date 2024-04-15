# Class: HierPart

Represents the hierarchical part of a Uniform Resource Identifier (URI).

### Constructor

```php
__construct(
    ?Authority $authority,
    string $path
)
```

#### Parameters:
- `$authority` (Authority|null): An instance of the `Authority` class representing the authority part of the URI (nullable).
- `$path` (string): The path part of the URI.

### Static Method: create

```php
public static function create(
    ?Authority $authority,
    string $path
): self
```

Creates a new `HierPart` instance.

#### Parameters:
- `$authority` (Authority|null): An instance of the `Authority` class representing the authority part of the URI (nullable).
- `$path` (string): The path part of the URI.

#### Returns:
- (`HierPart`): A new `HierPart` instance.

### Method: toArray

```php
public function toArray(): array
```

Converts the `HierPart` object to an associative array.

#### Returns:
- (array): An array representation of the `HierPart` object.

### Method: toObject

```php
public function toObject(): string
```

Converts the `HierPart` object to a JSON string.

#### Returns:
- (string): The JSON representation of the `HierPart` object.

---

This documentation provides an overview of the `HierPart` class, including its constructor, static method, and methods, facilitating ease of use for developers integrating the class into their projects.
