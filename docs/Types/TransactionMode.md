# Class: TransactionMode

The `TransactionMode` class provides constants representing transaction modes for database operations.

### Constants:

- `write` (string): Represents the write transaction mode.
- `read` (string): Represents the read transaction mode.
- `deferred` (string): Represents the deferred transaction mode.

These constants define different transaction modes for database operations, allowing developers to specify the appropriate mode for their transactions.

### Method: checker

```php
public static function checker(string $mode): string
```

Checks if the given transaction mode is valid.

#### Parameters:
- `$mode` (string): The transaction mode to check.

#### Returns:
- (string): The validated transaction mode.

#### Throws:
- `LibsqlError`: If an invalid transaction mode is provided.

This method ensures that only valid transaction modes are accepted and throws an error if an invalid mode is provided.
