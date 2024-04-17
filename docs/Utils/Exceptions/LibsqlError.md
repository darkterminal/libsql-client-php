# LibsqlError

Error thrown by the client.

## Namespace:
- Darkterminal\LibSQL\Utils\Exceptions

## Uses:
- Darkterminal\LibSQL\Traits\Logging

## Properties:
- **code**: string
    Machine-readable error code.
- **rawCode**: int|null
    Raw numeric error code.

## Methods:
- public - __construct
Description: Constructor.
Link: [None]
Parameters:
    - $message (string): The error message.
    - $code (string): The machine-readable error code.
    - $rawCode (int|null): The raw numeric error code.
    - $cause (Throwable|null): The cause of the error.

---

## Overview:
The `LibsqlError` class represents an error thrown by the client. It extends the built-in PHP `\Exception` class and includes the trait `Logging` from the namespace `Darkterminal\LibSQL\Traits`. It provides properties to store a machine-readable error code and a raw numeric error code. The constructor initializes the error message, error code, raw code, and the cause of the error if provided.
