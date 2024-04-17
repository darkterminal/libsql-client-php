# UserInfo

Represents the userInfo part of a URI authority.

## Namespace:
- Darkterminal\LibSQL\Types

## Uses:
- None

## Properties:
- **username** (string|null) - The username part of the userInfo.
- **password** (string|null) - The password part of the userInfo.

## Methods:
- **public** - `__construct`
Description: Constructs a new UserInfo instance.
Parameters:
  - username (string|null) - The username part of the userInfo.
  - password (string|null) - The password part of the userInfo.

- **public static** - `create`
Description: Creates a new UserInfo instance.
Parameters:
  - username (string|null) - The username part of the userInfo.
  - password (string|null) - The password part of the userInfo.

- **public** - `toArray`
Description: Convert the UserInfo object to an array.
Returns: An array representation of the UserInfo object.

- **public** - `toObject`
Description: Converts the UserInfo instance to a JSON string.
Returns: The JSON representation of the UserInfo instance.

---

## Overview:
The `UserInfo` class represents the userInfo part of a URI authority. It contains properties such as the username and password. This class provides methods to create a UserInfo object, convert it to an array or JSON string.
