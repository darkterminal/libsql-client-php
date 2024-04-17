# TransactionMode

The TransactionMode class provides constants representing transaction modes for database operations.

## Namespace:
- Darkterminal\LibSQL\Types

## Uses:
- ReflectionClass from PHP Standard Library
- LibsqlError exception

## Properties:
None

## Methods:
- **public static** - `checker`
Description: Checks if the given transaction mode is valid.
Parameters:
  - mode (string) - The transaction mode to check.
Returns: The valid transaction mode if it exists.
Throws: LibsqlError if the transaction mode is not supported.

## Constants:
- **write** (string) - Represents the write transaction mode.
- **read** (string) - Represents the read transaction mode.
- **deferred** (string) - Represents the deferred transaction mode.

---

## Overview:
The `TransactionMode` class provides constants representing transaction modes for database operations, including write, read, and deferred. It also provides a `checker` method to validate transaction modes. If an invalid transaction mode is provided, it throws a `LibsqlError` exception.
