# HttpResponse

The `HttpResponse` class represents an HTTP response from LibSQL Server. It contains properties such as the baton identifier, base URL, and HTTP result sets. This class provides methods to create an HttpResponse object, convert it to an array or JSON string, fetch results, and handle errors.

## Instanciated

The constructor initializes a new `HttpResponse` instance with the provided parameters - `$baton`, `$base_url`, and `$results`. It assigns these parameters to the corresponding properties of the class. _(Leave this alone!)_

```php
public function __construct(
    public string|null $baton,
    public string|null $base_url,
    public array|HttpResultSets $results
)
```
## Create "static" Method

Creates a new instance of the `HttpResponse` class.

```php
public static function create(
    string|null $baton,
    string|null $base_url,
    array|HttpResultSets $results
): self
```

**Example Usage**

```php
$data = map_results($response->getBody());
return HttpResponse::create($data['baton'], $data['base_url'], $data['results']);
```

## toArray

Converts the result set to an associative array representation. It includes the baton, base URL, and the results converted to an array using the `objectToArray()` function.

```php
public function toArray(): array
```

## toObject

Converts the result set to a JSON-encoded string representation. It internally uses the `toArray()` method to convert the result set to an associative array before encoding it as JSON.

```php
public function toObject(): string
```

## first

Retrieve the first result set from the query execution.

Returns a new instance of the current class containing the first result set obtained from the executed query. It converts the internal result object to an array and extracts the first element to create a new instance.

```php
public function first(): self
```

**Example Usage**

```php
$query = HttpStatement::create(sql: 'SELECT name, id FROM users LIMIT 5');
$results = $db->execute(query: $query);
$results->first();
```

## fetch

Fetch the result set from the query execution.

Retrieves the result set from the executed query and returns it in the specified format. It converts the internal result object to an array and switches based on the provided type parameter to determine the format of the returned data.

```php
public function fetch(int $type = LibSQLResult::FETCH_ASSOC): array|string
```

**Example Usage**

```php
$query = HttpStatement::create(sql: 'SELECT name, id FROM users LIMIT 5');
$results = $db->execute(query: $query);
echo $results->fetch(type: LibSQLResult::FETCH_OBJ) . PHP_EOL;
```
