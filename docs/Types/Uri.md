# Uri

Represents a URI object.

## Namespace:
- Darkterminal\LibSQL\Types

## Uses:
- None

## Properties:
- **scheme** (string) - The scheme part of the URI.
- **authority** (Authority|null) - The authority part of the URI.
- **path** (string) - The path part of the URI.
- **query** (Query|null) - The query part of the URI.
- **fragment** (string|null) - The fragment part of the URI.

## Methods:
- **public** - `__construct`
Description: Constructs a new Uri instance.
Parameters:
  - scheme (string) - The scheme part of the URI.
  - authority (Authority|null) - The authority part of the URI.
  - path (string) - The path part of the URI.
  - query (Query|null) - The query part of the URI.
  - fragment (string|null) - The fragment part of the URI.

- **public static** - `create`
Description: Creates a new Uri instance.
Parameters:
  - scheme (string) - The scheme part of the URI.
  - authority (Authority|null) - The authority part of the URI.
  - path (string) - The path part of the URI.
  - query (Query|null) - The query part of the URI.
  - fragment (string|null) - The fragment part of the URI.

- **public** - `toArray`
Description: Convert the Uri object to an array.
Returns: An array representation of the Uri object.

- **public** - `toObject`
Description: Converts the Uri instance to a JSON string.
Returns: The JSON representation of the Uri instance.

---

## Overview:
The `Uri` class represents a URI object. It contains properties such as the scheme, authority, path, query, and fragment parts of the URI. This class provides methods to create a Uri object, convert it to an array or JSON string.
