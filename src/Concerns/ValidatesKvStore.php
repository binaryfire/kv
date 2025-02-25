<?php

declare(strict_types=1);

namespace App\Concerns;

use React\Http\Message\Response;

trait ValidatesKvStore
{
    /**
     * Validate a key and return an error response if invalid
     * 
     * @param string $key The key to validate
     * @return Response|null Returns a Response if validation fails, null if passes
     */
    private function validateKeyOrError(string $key): ?Response
    {
        if (empty($key)) {
            return Response::plaintext('Key is required')->withStatus(400);
        }

        // Check for lowercase snake_case format
        if (!preg_match('/^[a-z0-9]+(_[a-z0-9]+)*$/', $key)) {
            return Response::plaintext('Key must be in lowercase snake_case format')->withStatus(400);
        }
        
        return null;
    }
}
