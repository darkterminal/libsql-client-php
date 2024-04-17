# LibSQL

The main class for interacting with the LibSQL service.

## Namespace:
- `Darkterminal\LibSQL`

## Uses:
- `Darkterminal\LibSQL\Providers\HttpClient`
- `Darkterminal\LibSQL\Types\ExpandedConfig`
- `Darkterminal\LibSQL\Types\ExpandedScheme`
- `Darkterminal\LibSQL\Utils\Exceptions\LibsqlError`

## Properties:
- None

## Methods:

### public function __construct(array $config)
**Description:** Constructs a new LibSQL instance.

**Link:** N/A

**Parameters:**
- `$config`: The configuration array for the LibSQL service.

### protected function createClient(ExpandedConfig $config): void
**Description:** Creates the HTTP client based on the expanded configuration.

**Link:** N/A

**Parameters:**
- `$config`: The expanded configuration object.
