# Helpers

### `transactionModeToBegin(string $mode): string`

**Description:** Converts a transaction mode to a corresponding BEGIN statement.

**Parameters:**
- `$mode` (string): The transaction mode.

**Returns:** string

**Throws:** `\RangeException` if an unknown transaction mode is provided.

---

### `expandConfig(array $config, bool $preferHttp): ExpandedConfig`

**Description:** Expands the provided client configuration into an `ExpandedConfig` object.

**Parameters:**
- `$config` (array): The client configuration array.
- `$preferHttp` (bool): Whether to prefer HTTP over WebSocket.

**Returns:** `ExpandedConfig`

**Throws:** `TypeError` if the provided configuration is not an array, `LibsqlError` if there is an error in the configuration or unsupported URL scheme.

---

### `parseUri(string $text): Uri`

**Description:** Parses a URI string and returns a `Uri` object.

**Parameters:**
- `$text` (string): The URI string to parse.

**Returns:** `Uri`

**Throws:** `LibsqlError` if the URI is not in a valid format.

---

### `parseAuthority(string $text): Authority`

**Description:** Parses the authority part of a URL and returns an `Authority` object.

**Parameters:**
- `$text` (string): The authority part of the URL.

**Returns:** `Authority`

**Throws:** `LibsqlError` if the authority part of the URL is not in a valid format.

---

### `parseQuery(string $text): Query`

**Description:** Parses the query string of a URI and returns a `Query` object.

**Parameters:**
- `$text` (string): The query string to parse.

**Returns:** `Query`

---

### `percentDecode(string $text): string`

**Description:** Decodes a percent-encoded string.

**Parameters:**
- `$text` (string): The string to decode.

**Returns:** string

**Throws:** `LibsqlError` if the URL component has invalid percent encoding.

---

### `encodeBaseUrl(string $scheme, ?Authority $authority, string $path): array|string|int|false|null`

**Description:** Encodes the components of a URI and returns a URL object.

**Parameters:**
- `$scheme` (string): The scheme of the URI.
- `$authority` (Authority|null): The authority of the URI.
- `$path` (string): The path of the URI.

**Returns:** array|string|int|false|null

**Throws:** `LibsqlError` if the URL requires authority.

---

### `encodeHost(string $host): string`

**Description:** Encodes the host component of a URI.

**Parameters:**
- `$host` (string): The host to encode.

**Returns:** string

---

### `encodePort(?int $port): string`

**Description:** Encodes the port component of a URI.

**Parameters:**
- `$port` (int|null): The port to encode.

**Returns:** string

---

### `encodeUserInfo(?UserInfo $userInfo): string`

**Description:** Encodes the userInfo component of a URI.

**Parameters:**
- `$userInfo` (UserInfo|null): The userInfo to encode.

**Returns:** string

---

### `is_base64(string $data): bool`

**Description:** Checks if a string is base64 encoded.

**Parameters:**
- `$data` (string): The string to check.

**Returns:** bool

---

### `checkColumnType(mixed $column): string`

**Description:** Determines the type of a given column value.

**Parameters:**
- `$column` (mixed): The column value to check.

**Returns:** string

---

### `map_results(string $data): array`

**Description:** Maps JSON data to a structured format.

**Parameters:**
- `$data` (string): The JSON data to be mapped.

**Returns:** array

**Throws:** `LibsqlError` if there is an error in the JSON data.

---

### `objectToArray($object)`

**Description:** Recursively converts an object to an array.

**Parameters:**
- `$object`: The object to convert.

**Returns:** mixed (array)
