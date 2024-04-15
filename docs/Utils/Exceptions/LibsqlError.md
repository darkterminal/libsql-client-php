# Class: LibsqlError

Error thrown by the LibSQL client.

### Properties:

- `$code` (string): Machine-readable error code.
- `$rawCode` (int|null): Raw numeric error code.

### Constructor

```php
__construct(
    string $message,
    string $code,
    ?int $rawCode = null,
    ?Throwable $cause = null
)
```

Constructs a new `LibsqlError` instance.

#### Parameters:
- `$message` (string): The error message.
- `$code` (string): The machine-readable error code.
- `$rawCode` (int|null): The raw numeric error code (default: `null`).
- `$cause` (Throwable|null): The cause of the error (default: `null`).

### Overview:

- This class represents an error thrown by the LibSQL client.
- It extends the base PHP `Exception` class.
- It provides additional properties to store error codes and numeric error codes.
- The constructor logs the error message using the `Logging` trait.
