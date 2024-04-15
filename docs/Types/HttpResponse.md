# Class: HttpResponse

Represents an HTTP response from LibSQL Server with necessary data.

### Properties:

- `$baton` (string|null): The baton identifier.
- `$base_url` (string|null): The base URL for the HTTP response.
- `$results` (array|HttpResultSets): The HTTP result sets.

### Constructor

```php
__construct(
    string|null $baton,
    string|null $base_url,
    array|HttpResultSets $results
)
```

#### Parameters:
- `$baton` (string|null): The baton identifier.
- `$base_url` (string|null): The base URL for the HTTP response.
- `$results` (array|HttpResultSets): The HTTP result sets.

### Static Method: create

```php
public static function create(
    string|null $baton,
    string|null $base_url,
    array|HttpResultSets $results
): self
```

Creates a new `HttpResponse` instance.

#### Parameters:
- `$baton` (string|null): The baton identifier.
- `$base_url` (string|null): The base URL for the HTTP response.
- `$results` (array|HttpResultSets): The HTTP result sets.

#### Returns:
- (`HttpResponse`): The created `HttpResponse` instance.

### Method: toArray

```php
public function toArray(): array
```

Converts the `HttpResponse` instance to an associative array.

#### Returns:
- (array): The array representation of the `HttpResponse` instance.

### Method: toObject

```php
public function toObject(): string
```

Converts the `HttpResponse` instance to a JSON string.

#### Returns:
- (string): The JSON representation of the `HttpResponse` instance.

### Method: first

```php
public function first(): self
```

Gets the first result from the HTTP response.

#### Returns:
- (`HttpResponse`): A new `HttpResponse` instance containing the first result.

### Method: fetch

```php
public function fetch(LibSQLResult $type = LibSQLResult::FETCH_ASSOC): array|string
```

Fetches the results in the specified format.

#### Parameters:
- `$type` (LibSQLResult) (Optional): The format in which to fetch the results. Default is `LibSQLResult::FETCH_ASSOC`.

#### Returns:
- (array|string): The fetched results.

#### Throws:
- `LibsqlError`: If an undefined fetch option is provided.
