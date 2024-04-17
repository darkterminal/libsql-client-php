# HierPart

Represents the hierarchical part of a URI.

## Namespace:
- Darkterminal\LibSQL\Types

## Uses:
- Authority

## Properties:
- **authority** (Authority|null) - The authority part of the hierarchical part, or null if not specified.
- **path** (string) - The path part of the hierarchical part.

## Methods:
- **public** - `__construct`
Description: Constructs a new HierPart object.
Parameters:
  - authority (Authority|null) - The authority part of the hierarchical part, or null if not specified.
  - path (string) - The path part of the hierarchical part.

- **public static** - `create`
Description: Creates a new HierPart object.
Parameters:
  - authority (Authority|null) - The authority part of the hierarchical part, or null if not specified.
  - path (string) - The path part of the hierarchical part.

- **public** - `toArray`
Description: Convert the HierPart object to an array.
Returns: An array representation of the HierPart object.

- **public** - `toObject`
Description: Converts the HierPart instance to a JSON string.
Returns: The JSON representation of the HierPart instance.

---

## Overview:
The `HierPart` class represents the hierarchical part of a URI. It contains properties such as the authority and the path. This class provides methods to create a HierPart object, convert it to an array, and serialize it to JSON.
