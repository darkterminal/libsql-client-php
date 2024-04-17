# HttpResponse

Represents an HTTP response from LibSQL Server with necessary data.

## Namespace:
- Darkterminal\LibSQL\Types

## Uses:
- MapResults trait
- HttpResultSets class
- LibsqlError exception

## Properties:
- **baton** (string|null) - The baton identifier.
- **base_url** (string|null) - The base URL for the HTTP response.
- **results** (array|HttpResultSets) - The HTTP result sets.

## Methods:
- **public** - `__construct`
Description: Constructs a new HttpResponse instance.
Parameters:
  - baton (string|null) - The baton identifier.
  - base_url (string|null) - The base URL for the HTTP response.
  - results (array|HttpResultSets) - The HTTP result sets.

- **public static** - `create`
Description: Creates a new HttpResponse instance.
Parameters:
  - baton (string|null) - The baton identifier.
  - base_url (string|null) - The base URL for the HTTP response.
  - results (array|HttpResultSets) - The HTTP result sets.

- **public** - `toArray`
Description: Convert the HttpResponse instance to an array.
Returns: The array representation of the HttpResponse instance.

- **public** - `toObject`
Description: Converts the HttpResponse instance to a JSON string.
Returns: The JSON representation of the HttpResponse instance.

- **public** - `first`
Description: Returns the first result from the HTTP response.
Returns: A new HttpResponse instance containing the first result.

- **public** - `fetch`
Description: Fetches the results in the specified format.
Parameters:
  - type (int) (Optional) - The format in which to fetch the results. Default is LibSQLResult::FETCH_ASSOC.
Returns: The fetched results.
Throws: LibsqlError if an undefined fetch option is provided.

---

## Overview:
The `HttpResponse` class represents an HTTP response from LibSQL Server. It contains properties such as the baton identifier, base URL, and HTTP result sets. This class provides methods to create an HttpResponse object, convert it to an array or JSON string, fetch results, and handle errors.
