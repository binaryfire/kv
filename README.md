# KV Store

A lightweight, high-performance key-value store with HTTP API. Built with ReactPHP and SQLite.

## Overview

This project provides a simple, performant and resource-efficient key-value store that can be easily deployed alongside microservices and Docker containers. It offers a straightforward HTTP API for storing and retrieving data with minimal overhead.

## Features

*   RESTful HTTP API
*   Persistent storage via SQLite
*   Low resource usage (typical memory usage ~35MB, negligible CPU usage)
*   Simple GET/PUT/DELETE operations

## Getting started

### Running with Docker

Run the container with default settings:

```
docker run --name kv -p 8080:8080 binaryfire/kv:latest
```

For data persistence, map the database directory to a volume:

```
docker run --name kv -p 8080:8080 -v kv-database:/var/www/database binaryfire/kv:latest
```

## API routes

| Method | Route | Description |
| --- | --- | --- |
| GET | / | List all keys |
| GET | /{key} | Get value for key |
| PUT | /{key} | Set value for key |
| DELETE | /{key} | Delete key |

## API format

The API uses plain text instead of JSON for both requests and responses, making it easier to use in scripts and with command-line tools.

When retrieving a value, the raw value is returned without any formatting. When listing all keys, each key is returned on a new line. 

## Usage examples

List all keys:

```
curl http://localhost:8080/
```

Get a specific value:

```
curl http://localhost:8080/my_key
```

Set a value (or overwrite existing value):

```
curl -X PUT -d "my value" http://localhost:8080/my_key
```

Delete a key:

```
curl -X DELETE http://localhost:8080/my_key
```

## Key format requirements

All keys must be in lowercase `snake_case` format:

*   Must contain only lowercase letters and numbers
*   Words separated by underscores
*   Example: `user_settings`, `api_key_1`

## Building locally from source

```
./build.sh
```

This will create Docker images tagged with the current timestamp and 'latest'.