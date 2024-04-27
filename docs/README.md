# Introduction LibSQL Client PHP

> _Keywords: Doc, Ref the link tags that will redirect you into (Doc) documentation and (Ref) the code._

This is the first **LibSQL Client for PHP** that can interact with **LibSQL** server natively via the **LibSQL PHP Extension** which is written with Rust C Binding and communicates with PHP via FFI.

The **LibSQL Client PHP** is a versatile library designed to facilitate interactions with both local and remote **LibSQL** databases from **PHP** applications. It abstracts the complexities of establishing connections, executing queries, managing transactions, and synchronizing databases, providing a unified API that supports various URL schemes including "`file:`", "`libsql:`", "`https:`", and "`http:`". The library caters to different operational modes, namely Remote and Local, allowing for seamless database operations across different environments.

For remote connections, it leverages HTTP clients to communicate with LibSQL servers, supporting functionalities like executing batch queries, managing transactions with different behaviors (e.g., deferred, write, read), and executing multiple SQL queries in a single HTTP request. For local connections, it interfaces with local database files, offering capabilities to execute queries, perform batch operations, and manage transactions directly on the local file system.

The library ensures robust error handling, throwing LibsqlError exceptions for unsupported URL schemes, TLS configuration issues, and other operational errors. It also provides a sync method for database synchronization in specific configurations, although this feature is not supported in basic Remote (HTTP) or Local (FILE) modes.

Here's a quick overview of its key features:

- **Connection Management**: Establishes connections to both local and remote databases with flexible configuration options.
- **Query Execution**: Supports executing SQL queries, with special considerations for named parameters in remote connections.
- **Batch Operations**: Enables executing a batch of queries in a single operation, particularly useful for remote connections.
- **Transaction Management**: Facilitates starting, managing, and committing transactions with customizable behaviors.
- **Synchronization**: Offers a synchronization mechanism for databases configured for replication, though with mode-specific limitations.
- **Error Handling**: Robustly handles errors and operational exceptions, ensuring clear feedback on issues like unsupported configurations or operational failures.

This library stands out for its adaptability and ease of use, making it a valuable tool for PHP developers working with LibSQL databases in varied environments.

## Table of Contents

This table of contents is sorted hierarchically based on the _Main Class_ to its derivatives to make it easier for readers to understand the process that runs the **LibSQL Client PHP**.

1. [LibSQL](LibSQL.md) - The main class for interacting with the **LibSQL** service
    - 1.1 - [Instanciated](LibSQL.md#instanciated) - Initializes a new instance of **LibSQL**
    - 1.2 - [Connection](LibSQL.md#connection) - Establishes a connection to the database
    - 1.3 - [Version](LibSQL.md#version) - Retrieves the version information of the database
    - 1.4 - [Executes a Query](LibSQL.md#executes-a-query) - Allows you to execute a query either locally or remotely
    - 1.5 - [(Remote) Executes a Batch of Queries](LibSQL.md#remote-executes-a-batch-of-queries) - Executes a batch of queries **exclusively for remote connections**
    - 1.6 - [(Local) Executes a Batch of Queries](LibSQL.md#local-executes-a-batch-of-queries) - Executes a batch of queries exclusively for local (file) connections
    - 1.7 - [Executes Multiple](LibSQL.md#executes-multiple-sql-queries-in-a-single-http-request) - Allows you to execute multiple SQL queries in a single HTTP request
    - 1.8 - [Transaction](LibSQL.md#initiates-a-transaction-for-executing-sql-queries-either-remotely-or-locally) - Initiates a transaction for executing SQL queries either remotely or locally
    - 1.9 - [Sync](LibSQL.md#synchronizes-the-database) - Synchronizes the database
    - 1.0.1 - [Close](LibSQL.md#close-the-database-connection) - Close the database connection
2. Providers
    - 2.1 - [HttpClient](Providers/HttpClient.md) - The `HttpClient` class provides functionality to interact with HTTP resources
    - 2.2 - [LocalClient](Providers/LocalClient.md) - The `LocalClient` class provides functionality to interact with Local file database
