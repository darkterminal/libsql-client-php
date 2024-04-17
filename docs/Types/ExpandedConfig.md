# ExpandedConfig

Represents an expanded configuration object.

## Namespace:
- Darkterminal\LibSQL\Types

## Uses:
- Authority

## Properties:
- **scheme** (string) - The scheme part of the configuration.
- **tls** (bool) - Indicates whether TLS is enabled.
- **authority** (Authority|null) - The authority part of the configuration, or null if not specified.
- **path** (string) - The path part of the configuration.
- **authToken** (string|null) - Authentication token for the configuration.
- **syncUrl** (string|null) - URL of a remote server to synchronize configuration with.
- **syncInterval** (int|null) - Sync interval in seconds.

## Methods:
- **public** - `__construct`
Description: Constructs a new ExpandedConfig object.
Parameters:
  - scheme (string) - The scheme part of the configuration.
  - tls (bool) - Indicates whether TLS is enabled.
  - authority (Authority|null) - The authority part of the configuration, or null if not specified.
  - path (string) - The path part of the configuration.
  - authToken (string|null) - Authentication token for the configuration.
  - syncUrl (string|null) - URL of a remote server to synchronize configuration with.
  - syncInterval (int|null) - Sync interval in seconds.

- **public static** - `create`
Description: Creates a new ExpandedConfig object.
Parameters:
  - scheme (string) - The scheme part of the configuration.
  - tls (bool) - Indicates whether TLS is enabled.
  - authority (Authority|null) - The authority part of the configuration, or null if not specified.
  - path (string) - The path part of the configuration.
  - authToken (string|null) - Authentication token for the configuration.
  - syncUrl (string|null) - URL of a remote server to synchronize configuration with.
  - syncInterval (int|null) - Sync interval in seconds.

- **public** - `toArray`
Description: Convert the ExpandedConfig object to an array.
Returns: An array representation of the ExpandedConfig object.

- **public** - `toObject`
Description: Converts the ExpandedConfig instance to a JSON string.
Returns: The JSON representation of the ExpandedConfig instance.

---

## Overview:
The `ExpandedConfig` class represents an expanded configuration object. It contains properties such as the scheme, TLS flag, authority, path, authentication token, synchronization URL, and synchronization interval. This class provides methods to create an ExpandedConfig object, convert it to an array, and serialize it to JSON.
