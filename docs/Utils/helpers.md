# Helpers

## Constants

### Regular Expression for parsing URI
```php
define('URI_RE', '/^(?<scheme>[A-Za-z][A-Za-z.+-]*):(\/\/(?<authority>[^\/?#]*))?(?<path>[^?#]*)(\?(?<query>[^#]*))?(#(?<fragment>.*))?$/');
```
This regular expression is used to parse a URI (Uniform Resource Identifier) into its components: scheme, authority, path, query, and fragment. It captures each component using named groups for easy access.

- `(?<scheme>[A-Za-z][A-Za-z.+-]*)`: Captures the scheme part of the URI, which consists of letters, dots, hyphens, and plus signs.
- `:\/\/(?<authority>[^\/?#]*)`: Captures the authority part of the URI, which includes the username, password, host, and port.
- `(?<path>[^?#]*)`: Captures the path component of the URI.
- `\?(?<query>[^#]*)`: Captures the query component of the URI.
- `#(?<fragment>.*)`: Captures the fragment component of the URI.

### Regular Expression for parsing authority part of URL
```php
define('AUTHORITY_RE', '/^((?<username>[^:]*)(:(?<password>.*))?@)?((?<host>[^:\[\]]*)|(\[(?<host_br>[^\[\]]*)\]))(:(?<port>[0-9]*))?$/');
```
This regular expression is used to parse the authority part of a URL, which typically contains the username, password, host, and port.

- `(?<username>[^:]*)(:(?<password>.*))?@`: Captures the username and an optional password separated by a colon, followed by an "@" symbol.
- `((?<host>[^:\[\]]*)|(\[(?<host_br>[^\[\]]*)\]))`: Captures the host part of the URL, which can be either a regular hostname or an IPv6 address enclosed in square brackets.
- `(:(?<port>[0-9]*))?`: Captures the port number, if present, preceded by a colon.

### Constants
```php
define('SUPPORTED_URL_LINK', "https://github.com/libsql/libsql-client-php#supported-urls");
define('TURSO', 'turso.io');
define('PIPE_LINE_ENDPOINT', '/v3/pipeline');
```
These are constants used in the code:
- `SUPPORTED_URL_LINK`: Represents a URL linking to a specific section of a GitHub repository.
- `TURSO`: Represents a domain name.
- `PIPE_LINE_ENDPOINT`: Represents a specific endpoint ("/v3/pipeline") for an API.

### ExpandedConfig

This PHP function `transactionModeToBegin` takes a transaction mode as input and returns the corresponding SQL BEGIN statement. Let's document it:

```php
/**
 * Convert transaction mode to BEGIN statement.
 *
 * @param string $mode The transaction mode. Supported values are "write", "read", and "deferred".
 * @return string The corresponding BEGIN statement.
 * @throws \RangeException If an unknown transaction mode is provided.
 */
function transactionModeToBegin(string $mode): string
{
    switch ($mode) {
        case "write":
            return "BEGIN IMMEDIATE";
        case "read":
            return "BEGIN TRANSACTION READONLY";
        case "deferred":
            return "BEGIN DEFERRED";
        default:
            throw new \RangeException('Unknown transaction mode, supported values are "write", "read" and "deferred"');
    }
}
```

### Description:
This function converts a given transaction mode into the appropriate SQL BEGIN statement.

### Parameters:
- `$mode` (string): The transaction mode to be converted. Supported values are "write", "read", and "deferred".

### Return:
- (string): The corresponding SQL BEGIN statement.

### Throws:
- `\RangeException`: If an unknown transaction mode is provided.

### Example Usage:
```php
try {
    $beginStatement = transactionModeToBegin("write");
    echo $beginStatement; // Outputs: "BEGIN IMMEDIATE"
} catch (\RangeException $e) {
    echo "Error: " . $e->getMessage();
}
```

This documentation provides clear guidance on how to use the function, what parameters it accepts, what it returns, and under what conditions it throws an exception.

### parseUri

Here's the documentation for the `parseUri` function:

```php
/**
 * Parse a URI string and return a Uri object.
 *
 * @param string $text The URI string to parse.
 * @return Uri An object containing the parsed components of the URI.
 * @throws LibsqlError If the URI is not in a valid format.
 */
function parseUri(string $text): Uri
{
    // Attempt to match the URI components using a regular expression
    $match = [];
    preg_match(URI_RE, $text, $match);

    // If no match is found, throw an error
    if (empty($match)) {
        throw new LibsqlError("The URL is not in a valid format", "URL_INVALID");
    }

    // Extract the matched groups
    $groups = [
        'scheme' => $match['scheme'] ?? '',
        'authority' => $match['authority'] ?? '',
        'path' => $match['path'] ?? '',
        'query' => $match['query'] ?? '',
        'fragment' => $match['fragment'] ?? ''
    ];

    // Parse individual components of the URI
    $scheme = $groups['scheme'];
    $authority = !empty($groups['authority']) ? parseAuthority($groups['authority']) : null;
    $path = percentDecode($groups['path']);
    $query = !empty($groups['query']) ? parseQuery($groups['query']) : null;
    $fragment = percentDecode($groups['fragment']);

    // Create and return a Uri object with the parsed components
    return Uri::create($scheme, $authority, $path, $query, $fragment);
}
```

### Description:
This function parses a URI string and returns a Uri object containing its components.

### Parameters:
- `$text` (string): The URI string to parse.

### Return:
- (Uri): An object containing the parsed components of the URI.

### Throws:
- `LibsqlError`: If the URI is not in a valid format.

### Example Usage:
```php
try {
    $uri = parseUri("https://example.com/path?query=value#fragment");
    echo $uri->getScheme(); // Outputs: "https"
    echo $uri->getAuthority()->getHost(); // Outputs: "example.com"
    // Access other components as needed
} catch (LibsqlError $e) {
    echo "Error: " . $e->getMessage();
}
```

This documentation provides guidance on using the function, its parameters, return value, and error handling.
