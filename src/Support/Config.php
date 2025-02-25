<?php

declare(strict_types=1);

namespace App\Support;

use App\Exceptions\ConfigException;

class Config
{
    protected static array $config = [];

    /**
     * Load the configuration array.
     * Used in public/index.php
     */
    public static function load(array $config): void
    {
        static::$config = $config;
    }

    /**
     * Get a configuration value by key.
     */
    public static function get(string $key, $default = null): mixed
    {
        $segments = explode('.', $key);
        $value = static::$config;

        foreach ($segments as $segment) {
            if (is_array($value) && array_key_exists($segment, $value)) {
                $value = $value[$segment];
            } else {
                return $default;
            }
        }

        return $value;
    }

    /**
     * Get a configuration value by key or fail if it does not exist.
     */
    public static function getOrFail(string $key): mixed
    {
        $value = static::get($key);

        if ($value === null) {
            throw new ConfigException("Configuration value for key '$key' not found.");
        }

        return $value;
    }
}