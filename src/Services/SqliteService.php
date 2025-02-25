<?php

declare(strict_types=1);

namespace App\Services;

use Clue\React\SQLite\DatabaseInterface;
use Clue\React\SQLite\Factory;
use React\Promise\PromiseInterface;

class SqliteService
{
    private DatabaseInterface $db;

    public function __construct(private string $dbFile)
    {
    }

    /**
     * Initialize SQLite database
     */
    public function initialize(): void
    {
        // Ensure database exists
        $dir = dirname($this->dbFile);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        if (!file_exists($this->dbFile)) {
            touch($this->dbFile);
        }

        // Create database connection
        $factory = new Factory();
        $this->db = $factory->openLazy($this->dbFile);

        // Apply optimizations
        $this->query('PRAGMA journal_mode = WAL');
        $this->query('PRAGMA synchronous = NORMAL');
        $this->query('PRAGMA auto_vacuum = INCREMENTAL');
    }

    /**
     * Get the database connection
     */    
    public function getConnection(): DatabaseInterface
    {
        return $this->db;
    }

    /**
     * Execute a query against the database
     * 
     * @param string $query The SQL query to execute
     * @param array $params The parameters to bind to the query
     * @return PromiseInterface<Result> A promise that resolves with the query result
     */
    public function query(string $query, array $params = []): PromiseInterface
    {
        return $this->db->query($query, $params);
    }
}
