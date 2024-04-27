# HttpStatement

The `HttpStatement` class represents an HTTP statement with SQL and optional arguments. It contains properties such as the SQL statement, optional arguments, and whether the arguments are named or positional. This class provides methods to create an HttpStatement object, convert it to an array or JSON string.

## Instanciated

Constructs a new `HttpStatement` instance. _(Leave this alone!)_

```php
public function __construct(
    public string $sql,
    public ?array $args = [],
    public ?bool $named_args = false
)
```
## Create "static" Method

Creates a new `HttpStatement` instance.

```php
public static function create(
    string $sql,
    ?array $args = [],
    ?bool $named_args = false
): self
```

**Example Usage**

```php
$query = HttpStatement::create(sql: 'SELECT name, id FROM users LIMIT 5');

// or

$stmts = [
    HttpStatement::create(sql: 'INSERT INTO users (name, age) VALUES (?, ?)', args: ["Ramons", 32]),
    HttpStatement::create(sql: 'INSERT INTO users (name, age) VALUES (?, ?)', args: ["Georgia", 43])
];
```

## toArray

Converts the `HttpStatement` instance to an array.

```php
public function toArray(): array
```

## toObject

Converts the `HttpStatement` instance to a JSON string.

```php
public function toObject(): string
```
