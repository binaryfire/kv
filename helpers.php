<?php

declare(strict_types=1);

if (!function_exists('base_path')) {
    /**
     * Get the base path of the project.
     */
    function base_path(string $path = ''): string
    {
        $base = __DIR__;

        if ($path) {
            $trimmed = ltrim(trim($path), DIRECTORY_SEPARATOR);
            return $base . ($trimmed ? DIRECTORY_SEPARATOR . $trimmed : '');
        }
        return $base;
    }
}
