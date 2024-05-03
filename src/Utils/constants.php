<?php

define('URI_RE', '/^(?<scheme>[A-Za-z][A-Za-z.+-]*):(\/\/(?<authority>[^\/?#]*))?(?<path>[^?#]*)(\?(?<query>[^#]*))?(#(?<fragment>.*))?$/');

define('AUTHORITY_RE', '/^((?<username>[^:]*)(:(?<password>.*))?@)?((?<host>[^:\[\]]*)|(\[(?<host_br>[^\[\]]*)\]))(:(?<port>[0-9]*))?$/');

define('SUPPORTED_URL_LINK', "https://github.com/libsql/libsql-client-php#supported-urls");

define('TURSO', 'turso.io');

define('PIPE_LINE_ENDPOINT', '/v3/pipeline');
define('VERSION_ENDPOINT', '/version');
define('HEALTH_ENDPOINT', '/health');

define('LIBSQL_CLOSE', 'close');
define('LIBSQL_EXECUTE', 'execute');
define('LIBSQL_BATCH', 'bath');
define('LIBSQL_SEQUENCE', 'sequence');
define('LIBSQL_DESCRIBE', 'describe');
define('LIBSQL_STORE_SQL', 'store_sql');
define('LIBSQL_GET_AUTO_COMMIT', 'get_autocommit');

define('REMOTE', 'Remote');
define('REMOTE_REPLICA', 'RemoteReplica');
define('LOCAL', 'Local');
