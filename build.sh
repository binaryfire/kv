#!/bin/bash
set -e

# Build timestamp for versioned tags
TIMESTAMP=$(date +%s)

echo "Building KV Store Docker image..."
docker build . -t kv:$TIMESTAMP -t kv:latest

echo "Image built successfully!"
echo "Run with: docker run --name kv -p 8080:8080 kv:latest"