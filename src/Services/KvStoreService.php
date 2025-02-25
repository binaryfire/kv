<?php

declare(strict_types=1);

namespace App\Services;

use React\Promise\PromiseInterface;

class KvStoreService
{
    public function __construct(private SqliteService $sqlite)
    {
    }

    /**
     * Initialize the key-value store
     */
    public function initialize(): void
    {
        $this->sqlite->query(
            'CREATE TABLE IF NOT EXISTS kv (
                key TEXT PRIMARY KEY, 
                value TEXT
            )'
        )->then(null, function (\Exception $e) {
            echo "KV Store initialization error: " . $e->getMessage() . PHP_EOL;
        });
    }

    /**
     * Set a value in the key-value store
     *
     * @param string $key The key
     * @param string $value The value
     * @return PromiseInterface A promise that resolves when the operation completes
     */
    public function set(string $key, string $value): PromiseInterface
    {
        return $this->delete($key)->then(
            function () use ($key, $value) {
                $statement = 'INSERT INTO kv (key, value) VALUES (?, ?)';
                return $this->sqlite->query($statement, [$key, $value]);
            }
        );
    }

    /**
     * Get a value from the key-value store
     *
     * @param string $key The key
     * @return PromiseInterface A promise that resolves with the query result
     */
    public function get(string $key): PromiseInterface
    {
        $statement = 'SELECT value FROM kv WHERE key = ?';
        return $this->sqlite->query($statement, [$key]);
    }

    /**
     * Delete a key from the key-value store
     *
     * @param string $key The key to delete
     * @return PromiseInterface A promise that resolves when the operation completes
     */
    public function delete(string $key): PromiseInterface
    {
        $statement = 'DELETE FROM kv WHERE key = ?';
        return $this->sqlite->query($statement, [$key]);
    }

    /**
     * List all keys in the key-value store
     *
     * @return PromiseInterface A promise that resolves with the query result
     */
    public function listKeys(): PromiseInterface
    {
        $statement = 'SELECT key FROM kv ORDER BY key ASC';
        return $this->sqlite->query($statement);
    }    
}
