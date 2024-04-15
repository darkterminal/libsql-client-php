The `Logging` trait provides logging functionality for error messages. Here's a breakdown of its components:

### Trait: Logging

This trait provides logging functionality for error messages.

#### Methods:

1. `log($message: mixed): void`
    - Logs a message to the error log file.
    - Parameters:
        - `$message` (mixed): The message to log.
    - Returns: `void`

2. `checkAndCreateDirectoryAndFile(): string`
    - Checks and creates the directory and error log file if they don't exist.
    - Returns: `string` - The path to the error log file.

#### Overview:

- The `log` method is used to log a message to the error log file. It appends the current timestamp to the message before writing it to the log file.
- The `checkAndCreateDirectoryAndFile` method is a helper method used internally to ensure that the directory and error log file exist. If they don't exist, it creates them.
- The error log file is located in the `~/.libsql-php/errors.log` directory.

### Usage Example:

```php
use Darkterminal\LibSQL\Traits\Logging;

class MyClass {
    use Logging;

    public function exampleFunction() {
        // Log an error message
        $this->log("An error occurred: Something went wrong.");

        // Additional functionality...
    }
}
```

This trait can be used within classes that require logging functionality for error handling. It provides a convenient way to log error messages to a dedicated log file.
