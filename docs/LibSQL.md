# Class: LibSQL

The main class for interacting with the LibSQL service.

### Constructor

```php
__construct(
    array $config
) throws LibsqlError
```

Constructs a new `LibSQL` instance.

#### Parameters:
- `$config` (array): The configuration array for the LibSQL service.

#### Throws:
- `LibsqlError`: If there is an error creating the HTTP client.

### Method: createClient

```php
protected function createClient(
    ExpandedConfig $config
) throws LibsqlError
```

Creates the HTTP client based on the expanded configuration.

#### Parameters:
- `$config` (ExpandedConfig): The expanded configuration object.

#### Throws:
- `LibsqlError`: If the URL scheme is not supported or if there is an issue with the TLS configuration.

### Overview:

- This class provides functionality for creating an HTTP client based on the provided configuration.
- It supports different URL schemes such as "libsql:", "https:", and "http:".
- It handles errors related to unsupported URL schemes and TLS configurations.
