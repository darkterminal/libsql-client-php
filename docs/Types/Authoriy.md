# Authority

Represents the authority part of a URI.

## Namespace:
- Darkterminal\LibSQL\Types

## Uses:
- UserInfo

## Properties:
- **host** (string) - The host part of the authority.
- **port** (int|null) - The port part of the authority, or null if not specified.
- **userInfo** (UserInfo|null) - The user information part of the authority, or null if not specified.

## Methods:
- **public** - `__construct`
Description: Constructs a new Authority object.
Parameters:
  - host (string) - The host part of the authority.
  - port (int|null) - The port part of the authority, or null if not specified.
  - userInfo (UserInfo|null) - The user information part of the authority, or null if not specified.

- **public static** - `create`
Description: Creates a new Authority object.
Parameters:
  - host (string) - The host part of the authority.
  - port (int|null) - The port part of the authority, or null if not specified.
  - userInfo (UserInfo|null) - The user information part of the authority, or null if not specified.

- **public** - `toArray`
Description: Convert the Authority object to an array.
Returns: An array representation of the Authority object.

- **public** - `toObject`
Description: Converts the Authority instance to a JSON string.
Returns: The JSON representation of the Authority instance.

---

## Overview:
The `Authority` class represents the authority part of a URI. It contains properties such as the host, port, and user information. This class provides methods to create an Authority object, convert it to an array, and serialize it to JSON.
