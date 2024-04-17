# HttpStatement

Represents an HTTP statement with SQL and optional arguments.

## Namespace:
- Darkterminal\LibSQL\Types

## Uses:
- None

## Properties:
- **sql** (string) - The SQL statement.
- **args** (array|null) - The optional arguments for the SQL statement.
- **named_args** (bool|null) - Indicates whether the arguments are named or positional.

## Methods:
- **public** - `__construct`
Description: Constructs a new HttpStatement instance.
Parameters:
  - sql (string) - The SQL statement.
  - args (array|null) - The optional arguments for the SQL statement.
  - named_args (bool|null) - Indicates whether the arguments are named or positional.

- **public static** - `create`
Description: Creates a new HttpStatement instance.
Parameters:
  - sql (string) - The SQL statement.
  - args (array|null) - The optional arguments for the SQL statement.
  - named_args (bool|null) - Indicates whether the arguments are named or positional.

- **public** - `toArray`
Description: Convert the HttpStatement instance to an array.
Returns: The array representation of the HttpStatement instance.

- **public** - `toObject`
Description: Converts the HttpStatement instance to a JSON string.
Returns: The JSON representation of the HttpStatement instance.

---

## Overview:
The `HttpStatement` class represents an HTTP statement with SQL and optional arguments. It contains properties such as the SQL statement, optional arguments, and whether the arguments are named or positional. This class provides methods to create an HttpStatement object, convert it to an array or JSON string.
