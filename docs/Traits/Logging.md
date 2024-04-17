# Logging

This trait provides logging functionality for error messages.

## Namespace:
- Darkterminal\LibSQL\Traits

## Methods:
- public - log
Description: Log a message to the error log file.
Link: [None]
Parameters:
    - $message (mixed): The message to log.
- protected - checkAndCreateDirectoryAndFile
Description: Check and create the directory and error log file if they don't exist.
Link: [None]
Parameters:
    - None

---

## Overview:
The `Logging` trait provides two methods:
- **log**: Logs a message to the error log file. It takes a message as input and appends it to the log file along with a timestamp.
- **checkAndCreateDirectoryAndFile**: Checks if the directory and error log file exist. If they don't exist, it creates them. It returns the path to the error log file.

This trait is used for logging error messages within the `LibSQL` library.
