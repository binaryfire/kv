<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Enums\HttpStatusEnum;
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
            return $this->createValidationErrorResponse('Key is required');
        }

        // Check for lowercase snake_case format
        if (!preg_match('/^[a-z0-9]+(_[a-z0-9]+)*$/', $key)) {
            return $this->createValidationErrorResponse('Key must be in lowercase snake_case format');
        }
        
        return null;
    }

    /**
     * Create a validation error response
     */
    private function createValidationErrorResponse(string $message): Response
    {
        $status = HttpStatusEnum::bad_request;

        return Response::plaintext("Error {$status->value}: $message")
            ->withStatus($status->value);
    }    
}
