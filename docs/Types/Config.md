# Config

Configuration object for createClient.

The client supports `libsql:`, `http:`/`https`:, `ws:`/`wss:` and `file:` URL. For more information, please refer to the project README:
[Supported Urls](https://github.com/libsql/libsql-client-php#supported-urls)

## Namespace:
- Darkterminal\LibSQL\Types

## Uses:
None

## Properties:
- **url** (string) - The database URL.
- **authToken** (string|null) - Authentication token for the database.
- **encryptionKey** (string|null) - Encryption key for the database.
- **syncUrl** (string|null) - URL of a remote server to synchronize database with.
- **syncInterval** (int|null) - Sync interval in seconds.
- **tls** (bool|null) - Enables or disables TLS for libsql: URLs.

## Methods:
- **public** - `__construct`
Description: Constructs a new Config object.
Parameters:
  - url (string) - The database URL.
  - authToken (string|null) - Authentication token for the database.
  - encryptionKey (string|null) - Encryption key for the database.
  - syncUrl (string|null) - URL of a remote server to synchronize database with.
  - syncInterval (int|null) - Sync interval in seconds.
  - tls (bool|null) - Enables or disables TLS for libsql: URLs.

- **public static** - `create`
Description: Creates a new Config object.
Parameters:
  - url (string) - The database URL.
  - authToken (string|null) - Authentication token for the database.
  - encryptionKey (string|null) - Encryption key for the database.
  - syncUrl (string|null) - URL of a remote server to synchronize database with.
  - syncInterval (int|null) - Sync interval in seconds.
  - tls (bool|null) - Enables or disables TLS for libsql: URLs.

- **public** - `toArray`
Description: Convert the Config object to an array.
Returns: The Config properties as an array.

- **public** - `toObject`
Description: Converts the Config instance to a JSON string.
Returns: The JSON representation of the Config instance.

---

## Overview:
The `Config` class represents a configuration object for creating a client. It contains properties such as the database URL, authentication token, encryption key, synchronization URL, synchronization interval, and TLS flag. This class provides methods to create a Config object, convert it to an array, and serialize it to JSON.
