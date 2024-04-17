### `URI_RE`

**Description:** Regular expression pattern for parsing URIs.

**Value:** `'/^(?<scheme>[A-Za-z][A-Za-z.+-]*):(\/\/(?<authority>[^\/?#]*))?(?<path>[^?#]*)(\?(?<query>[^#]*))?(#(?<fragment>.*))?$/`

---

### `AUTHORITY_RE`

**Description:** Regular expression pattern for parsing the authority part of a URL.

**Value:** `'/^((?<username>[^:]*)(:(?<password>.*))?@)?((?<host>[^:\[\]]*)|(\[(?<host_br>[^\[\]]*)\]))(:(?<port>[0-9]*))?$/`

---

### `SUPPORTED_URL_LINK`

**Description:** Link to the documentation page for supported URLs.

**Value:** `"https://github.com/libsql/libsql-client-php#supported-urls"`

---

### `TURSO`

**Description:** A constant with the value `'turso.io'`.

**Value:** `'turso.io'`

---

### `PIPE_LINE_ENDPOINT`

**Description:** Endpoint for pipeline operations.

**Value:** `'/v3/pipeline'`

---

### `VERSION_ENDPOINT`

**Description:** Endpoint for version information.

**Value:** `'/version'`

---

### `HEALTH_ENDPOINT`

**Description:** Endpoint for health status.

**Value:** `'/health'`

---

### `LIBSQL_CLOSE`, `LIBSQL_EXECUTE`, `LIBSQL_BATCH`, `LIBSQL_SEQUENCE`, `LIBSQL_DESCRIBE`, `LIBSQL_STORE_SQL`, `LIBSQL_GET_AUTO_COMMIT`

**Description:** Constants representing different operations for LibSQL.

**Values:** `'close'`, `'execute'`, `'bath'`, `'sequence'`, `'describe'`, `'store_sql'`, `'get_autocommit'`
