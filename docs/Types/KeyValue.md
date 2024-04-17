# KeyValue

Represents a key-value pair in a query string.

## Namespace:
- Darkterminal\LibSQL\Types

## Uses:
- None

## Properties:
- **key** (string) - The key of the key-value pair.
- **value** (string) - The value of the key-value pair.

## Methods:
- **public** - `__construct`
Description: Constructs a new KeyValue instance.
Parameters:
  - key (string) - The key of the key-value pair.
  - value (string) - The value of the key-value pair.

- **public static** - `create`
Description: Creates a new KeyValue instance.
Parameters:
  - key (string) - The key of the key-value pair.
  - value (string) - The value of the key-value pair.

- **public** - `toArray`
Description: Convert the KeyValue object to an array.
Returns: An array representation of the KeyValue object.

- **public** - `toObject`
Description: Converts the KeyValue instance to a JSON string.
Returns: The JSON representation of the KeyValue instance.

---

## Overview:
The `KeyValue` class represents a key-value pair in a query string. It contains properties such as the key and value. This class provides methods to create a KeyValue object, convert it to an array or JSON string.
