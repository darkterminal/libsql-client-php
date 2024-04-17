<?php

namespace Darkterminal\LibSQL;

use Darkterminal\LibSQL\Providers\HttpClient;
use Darkterminal\LibSQL\Types\ExpandedConfig;
use Darkterminal\LibSQL\Types\ExpandedScheme;
use Darkterminal\LibSQL\Utils\Exceptions\LibsqlError;

/**
 * The main class for interacting with the LibSQL service.
 *
 * This class provides functionality for creating an HTTP client based on the provided configuration.
 * It supports different URL schemes such as "libsql:", "https:", and "http:".
 * It also handles errors related to unsupported URL schemes and TLS configurations.
 */
class LibSQL
{
    use HttpClient;
    /**
     * Constructs a new LibSQL instance.
     *
     * @param array $config The configuration array for the LibSQL service.
     * @throws LibsqlError If there is an error creating the HTTP client.
     */
    public function __construct(array $config)
    {
        $this->createClient(expandConfig($config, true));
    }

    /**
     * Creates the HTTP client based on the expanded configuration.
     *
     * @param ExpandedConfig $config The expanded configuration object.
     * @throws LibsqlError If the URL scheme is not supported or if there is an issue with the TLS configuration.
     */
    protected function createClient(ExpandedConfig $config): void
    {
        if ($config->scheme !== ExpandedScheme::file) {
            if ($config->scheme !== ExpandedScheme::https && $config->scheme !== ExpandedScheme::http) {
                throw new LibsqlError(
                    'The HTTP client supports only "libsql:", "https:" and "http:" URLs, got ' . $config->scheme,
                    "URL_SCHEME_NOT_SUPPORTED",
                );
            }

            if ($config->scheme === ExpandedScheme::http && $config->tls) {
                throw new LibsqlError('A "http:" URL cannot opt into TLS by using ?tls=1', "URL_INVALID");
            } else if ($config->scheme === ExpandedScheme::https && !$config->tls) {
                throw new LibsqlError('A "https:" URL cannot opt out of TLS by using ?tls=0', "URL_INVALID");
            }

            $url = encodeBaseUrl($config->scheme, $config->authority, $config->path);
            $this->setup($url, $config->authToken);
        } else {
            throw new LibsqlError('The "file" uri is not supported yet!', "FILE_INVALID");
        }
    }
}
