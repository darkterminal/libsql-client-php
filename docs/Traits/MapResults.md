# MapResults

This trait provides methods to map results from JSON data to arrays or JSON objects.

## Namespace:
- Darkterminal\LibSQL\Traits

## Uses:
- Darkterminal\LibSQL\Types\HttpResultSets

## Methods:
- protected - fetchArray
Description: Fetch the results as an array.
Link: [None]
Parameters:
    - $data (string|array|HttpResultSets): The JSON data containing the results.
- protected - fetchObject
Description: Fetch the results as a JSON object.
Link: [None]
Parameters:
    - $data (string|array|HttpResultSets): The JSON data containing the results.
- private - _results
Description: Parse the JSON data and extract the results.
Link: [None]
Parameters:
    - $data (string|array|HttpResultSets): The JSON data containing the results.

---

## Overview:
The `MapResults` trait provides methods to fetch the results from JSON data either as an array or a JSON object. It includes the following methods:

- **fetchArray**: Fetches the results as an array.
- **fetchObject**: Fetches the results as a JSON object.
- **_results**: Private method to parse the JSON data and extract the results.

The trait is used for mapping results within the `LibSQL` library and depends on the `HttpResultSets` type.
