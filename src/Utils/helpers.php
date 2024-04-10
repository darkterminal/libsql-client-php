<?php

use Darkterminal\LibSQL\Types\Authority;
use Darkterminal\LibSQL\Types\Config;
use Darkterminal\LibSQL\Types\ExpandedConfig;
use Darkterminal\LibSQL\Types\ExpandedScheme;
use Darkterminal\LibSQL\Types\KeyValue;
use Darkterminal\LibSQL\Types\Query;
use Darkterminal\LibSQL\Types\Uri;
use Darkterminal\LibSQL\Types\UserInfo;
use Darkterminal\LibSQL\Utils\Exceptions\LibsqlError;

// Regular Expression for parsing URI
const URI_RE = '/^(?<scheme>[A-Za-z][A-Za-z.+-]*):(\/\/(?<authority>[^\/?#]*))?(?<path>[^?#]*)(\?(?<query>[^#]*))?(#(?<fragment>.*))?$/';

// Regular Expression for parsing authority part of URL
const AUTHORITY_RE = '/^((?<username>[^:]*)(:(?<password>.*))?@)?((?<host>[^:\[\]]*)|(\[(?<host_br>[^\[\]]*)\]))(:(?<port>[0-9]*))?$/';

const SUPPORTED_URL_LINK = "https://github.com/libsql/libsql-client-php#supported-urls";

/**
 * Convert transaction mode to BEGIN statement.
 *
 * @param string $mode The transaction mode.
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

function expandConfig(Config $config, bool $preferHttp): ExpandedConfig
{
    if (!is_array($config)) {
        throw new TypeError('Expected client configuration as object, got ' . gettype($config));
    }

    $tls = $config['tls'] ?? null;
    $authToken = $config['authToken'] ?? null;
    $encryptionKey = $config['encryptionKey'] ?? null;
    $syncUrl = $config['syncUrl'] ?? null;
    $syncInterval = $config['syncInterval'] ?? null;

    if ($config['url'] === ':memory:') {
        return ExpandedConfig::create(
            ExpandedScheme::file,
            false,
            null,
            ':memory:',
            $authToken,
            $encryptionKey,
            $syncUrl,
            $syncInterval
        );
    }

    $uri = parseUri($config['url']);
    foreach ($uri->query->pairs as $pair) {
        $key = $pair->key;
        $value = $pair->value;
        if ($key === 'authToken') {
            $authToken = $value !== '' ? $value : null;
        } elseif ($key === 'tls') {
            if ($value === '0') {
                $tls = false;
            } elseif ($value === '1') {
                $tls = true;
            } else {
                throw new LibsqlError('Unknown value for the "tls" query argument: ' . json_encode($value) . '. Supported values are "0" and "1"', "URL_INVALID");
            }
        } else {
            throw new LibsqlError('Unknown URL query parameter ' . json_encode($key), "URL_PARAM_NOT_SUPPORTED");
        }
    }

    $uriScheme = strtolower($uri->scheme);
    if ($uriScheme === 'libsql') {
        if ($tls === false) {
            if ($uri->authority->port === null) {
                throw new LibsqlError('A "libsql:" URL with ?tls=0 must specify an explicit port', "URL_INVALID");
            }
            $scheme = $preferHttp ? ExpandedScheme::http : ExpandedScheme::ws;
        } else {
            $scheme = $preferHttp ? ExpandedScheme::https : ExpandedScheme::wss;
        }
    } elseif (in_array($uriScheme, [ExpandedScheme::http, ExpandedScheme::ws])) {
        $scheme = $uriScheme;
        $tls ??= false;
    } elseif (in_array($uriScheme, [ExpandedScheme::https, ExpandedScheme::wss, ExpandedScheme::file])) {
        $scheme = $uriScheme;
    } else {
        throw new LibsqlError(
            'The client supports only "libsql:", "wss:", "ws:", "https:", "http:" and "file:" URLs, got ' . json_encode($uri->scheme . ":") . '. For more information, please read ' . SUPPORTED_URL_LINK,
            "URL_SCHEME_NOT_SUPPORTED"
        );
    }

    if ($uri->fragment !== null) {
        throw new LibsqlError('URL fragments are not supported: ' . json_encode("#" . $uri->fragment), "URL_INVALID");
    }

    return new ExpandedConfig(
        $scheme,
        $tls ?? true,
        $uri->authority,
        $uri->path,
        $authToken,
        $encryptionKey,
        $syncUrl,
        $syncInterval
    );
}

/**
 * Parse a URI string and return a Uri object.
 *
 * @param string $text The URI string to parse.
 * @return Uri An object containing the parsed components of the URI.
 * @throws LibsqlError If the URI is not in a valid format.
 */
function parseUri(string $text): Uri
{
    $match = [];
    preg_match(URI_RE, $text, $match);
    if (empty($match)) {
        throw new LibsqlError("The URL is not in a valid format", "URL_INVALID");
    }

    $groups = [
        'scheme' => $match['scheme'] ?? '',
        'authority' => $match['authority'] ?? '',
        'path' => $match['path'] ?? '',
        'query' => $match['query'] ?? '',
        'fragment' => $match['fragment'] ?? ''
    ];

    $scheme = $groups['scheme'];
    $authority = !empty($groups['authority']) ? parseAuthority($groups['authority']) : null;
    $path = percentDecode($groups['path']);
    $query = !empty($groups['query']) ? parseQuery($groups['query']) : null;
    $fragment = percentDecode($groups['fragment']);

    return Uri::create($scheme, $authority, $path, $query, $fragment);
}

/**
 * Parse authority part of URL and return an Authority object.
 *
 * @param string $text The authority part of the URL.
 * @return Authority An object containing host, port, and userInfo components.
 * @throws LibsqlError If the authority part of the URL is not in a valid format.
 */
function parseAuthority(string $text): Authority
{
    $match = [];
    preg_match(AUTHORITY_RE, $text, $match);
    if (empty($match)) {
        throw new LibsqlError("The authority part of the URL is not in a valid format", "URL_INVALID");
    }

    $groups = [
        'username' => $match['username'] ?? '',
        'password' => $match['password'] ?? '',
        'host' => $match['host'] ?? '',
        'host_br' => $match['host_br'] ?? '',
        'port' => $match['port'] ?? ''
    ];

    $host = percentDecode($groups['host_br'] !== '' ? $groups['host_br'] : $groups['host']);
    $port = !empty($groups['port']) ? (int)$groups['port'] : null;
    $username = !empty($groups['username']) ? percentDecode($groups['username']) : null;
    $password = !empty($groups['password']) ? percentDecode($groups['password']) : null;
    $userInfo = UserInfo::create($username, $password);

    return Authority::create($host, $port, $userInfo);
}

/**
 * Function parseQuery
 *
 * Parses the query string of a URI and returns a Query object.
 *
 * @param string $text The query string to parse.
 * @return Query The parsed query.
 */
function parseQuery(string $text): Query
{
    $sequences = explode("&", $text);
    $pairs = [];
    foreach ($sequences as $sequence) {
        if ($sequence === "") {
            continue;
        }

        $splitIdx = strpos($sequence, "=");
        if ($splitIdx === false) {
            $key = $sequence;
            $value = "";
        } else {
            $key = substr($sequence, 0, $splitIdx);
            $value = substr($sequence, $splitIdx + 1);
        }

        $pairs[] = KeyValue::create(percentDecode(str_replace("+", " ", $key)), percentDecode(str_replace("+", " ", $value)));
    }
    return Query::create($pairs);
}

/**
 * Function percentDecode
 *
 * Decodes a percent-encoded string.
 *
 * @param string $text The string to decode.
 * @return string The decoded string.
 * @throws LibsqlError If the URL component has invalid percent encoding.
 */
function percentDecode(string $text): string
{
    try {
        return rawurldecode($text);
    } catch (\Exception $e) {
        throw new LibsqlError("URL component has invalid percent encoding: " . $e->getMessage(), "URL_INVALID", null, $e);
    }
}

/**
 * Function encodeBaseUrl
 *
 * Encodes the components of a URI and returns a URL object.
 *
 * @param string $scheme The scheme of the URI.
 * @param Authority|null $authority The authority of the URI.
 * @param string $path The path of the URI.
 * @return string The encoded URL object.
 * @throws LibsqlError If the URL requires authority.
 */
function encodeBaseUrl(string $scheme, ?Authority $authority, string $path): string
{
    if ($authority === null) {
        throw new LibsqlError("URL with scheme $scheme: requires authority (the \"//\" part)", "URL_INVALID");
    }

    $schemeText = $scheme . ":";

    $hostText = encodeHost($authority->host);
    $portText = encodePort($authority->port);
    $userInfoText = encodeUserInfo($authority->userInfo);
    $authorityText = "//" . $userInfoText . $hostText . $portText;

    $pathText = $path !== "" && substr($path, 0, 1) !== "/" ? "/" . $path : $path;
    $pathText = implode("/", array_map("rawurlencode", explode("/", $pathText)));

    return parse_url($schemeText . $authorityText . $pathText);
}

/**
 * Function encodeHost
 *
 * Encodes the host component of a URI.
 *
 * @param string $host The host to encode.
 * @return string The encoded host.
 */
function encodeHost(string $host): string
{
    return strpos($host, ":") !== false ? "[" . rawurlencode($host) . "]" : rawurlencode($host);
}

/**
 * Function encodePort
 *
 * Encodes the port component of a URI.
 *
 * @param int|null $port The port to encode.
 * @return string The encoded port.
 */
function encodePort(?int $port): string
{
    return $port !== null ? ":" . $port : "";
}

/**
 * Function encodeUserInfo
 *
 * Encodes the userInfo component of a URI.
 *
 * @param UserInfo|null $userInfo The userInfo to encode.
 * @return string The encoded userInfo.
 */
function encodeUserInfo(?UserInfo $userInfo): string
{
    if ($userInfo === null) {
        return "";
    }

    $usernameText = rawurlencode($userInfo->username);
    $passwordText = $userInfo->password !== null ? ":" . rawurlencode($userInfo->password) : "";
    return $usernameText . $passwordText . "@";
}
