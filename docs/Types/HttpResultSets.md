# HttpResultSets

Represents a set of HTTP result data.

## Namespace:
- Darkterminal\LibSQL\Types

## Uses:
- None

## Properties:
- **cols** (array) - The columns of the result set.
- **rows** (array) - The rows of the result set.
- **affected_row_count** (int) - The number of affected rows.
- **last_insert_rowid** (int|null) - The last inserted row ID.
- **replication_index** (int|string) - The replication index.

## Methods:
- **public** - `__construct`
Description: Constructs a new HttpResultSets instance.
Parameters:
  - cols (array) - The columns of the result set.
  - rows (array) - The rows of the result set.
  - affected_row_count (int) - The number of affected rows.
  - last_insert_rowid (int|null) - The last inserted row ID.
  - replication_index (int|string) - The replication index.

- **public static** - `create`
Description: Creates a new HttpResultSets instance.
Parameters:
  - cols (array) - The columns of the result set.
  - rows (array) - The rows of the result set.
  - affected_row_count (int) - The number of affected rows.
  - last_insert_rowid (int|null) - The last inserted row ID.
  - replication_index (int|string) - The replication index.

- **public** - `toArray`
Description: Convert the HttpResultSets instance to an array.
Returns: The array representation of the HttpResultSets instance.

- **public** - `toObject`
Description: Converts the HttpResultSets instance to a JSON string.
Returns: The JSON representation of the HttpResultSets instance.

---

## Overview:
The `HttpResultSets` class represents a set of HTTP result data. It contains properties such as the columns, rows, affected row count, last inserted row ID, and replication index. This class provides methods to create an HttpResultSets object, convert it to an array or JSON string.
