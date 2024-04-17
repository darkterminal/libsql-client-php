# Query

Represents the query part of a URI.

## Namespace:
- Darkterminal\LibSQL\Types

## Uses:
- None

## Properties:
- **pairs** (array) - An array of key-value pairs representing the query parameters.

## Methods:
- **public** - `__construct`
Description: Constructs a new Query instance.
Parameters:
  - pairs (array) - An array of key-value pairs representing the query parameters.

- **public static** - `create`
Description: Creates a new Query instance.
Parameters:
  - pairs (array) - An array of key-value pairs representing the query parameters.

- **public** - `toArray`
Description: Convert the Query object to an array.
Returns: An array representation of the Query object.

- **public** - `toObject`
Description: Converts the Query instance to a JSON string.
Returns: The JSON representation of the Query instance.

---

## Overview:
The `Query` class represents the query part of a URI. It contains a property `pairs`, which is an array of key-value pairs representing the query parameters. This class provides methods to create a Query object, convert it to an array or JSON string.
