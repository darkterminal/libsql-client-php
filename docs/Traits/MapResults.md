The `MapResults` trait provides methods to map results from JSON data to arrays or JSON objects. Here's a breakdown of its components:

### Trait: MapResults

This trait provides methods to map results from JSON data to arrays or JSON objects.

#### Methods:

1. `fetchArray($json: string|array): array`
    - Fetches the results as an array.
    - Parameters:
        - `$json` (string|array): The JSON data containing the results.
    - Returns: `array` - The results mapped as an array.

2. `fetchObject($json: string|array): string`
    - Fetches the results as a JSON object.
    - Parameters:
        - `$json` (string|array): The JSON data containing the results.
    - Returns: `string` - The results mapped as a JSON object.

#### Overview:

- The `fetchArray` method takes JSON data as input and returns the results mapped as an array.
- The `fetchObject` method takes JSON data as input and returns the results mapped as a JSON object.
- The `_results` method is a private helper method used internally to parse the JSON data and extract the results. It iterates over each row and column of the results and constructs an array of rows with column names as keys and column values as values.

### Usage Example:

```php
use Darkterminal\LibSQL\Traits\MapResults;

class MyClass {
    use MapResults;

    public function processResults($json) {
        // Fetch results as an array
        $resultsArray = $this->fetchArray($json);

        // Fetch results as a JSON object
        $resultsObject = $this->fetchObject($json);

        // Additional functionality...
    }
}
```

This trait can be used within classes that need to process JSON data containing query results. It provides methods to easily convert the results into arrays or JSON objects for further manipulation or serialization.
