<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Enums\HttpStatusEnum;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Message\Response;
use React\Promise\PromiseInterface;

class PlainTextErrorResponseMiddleware
{
    public function __invoke(ServerRequestInterface $request, callable $next)
    {
        $response = $next($request);

        return match (true) {
            $response instanceof PromiseInterface => $response->then(fn (ResponseInterface $response) => $this->handle($response)),
            $response instanceof \Generator => (fn () => $this->handle(yield from $response))(),
            default => $this->handle($response),
        };
    }

    private function handle(ResponseInterface $response): ResponseInterface
    {
        $statusCode = $response->getStatusCode();

        // Status 400 is used for validation errors and should be excluded
        if ($statusCode >= 401) {
            $statusEnum = HttpStatusEnum::tryFrom($statusCode);
            
            $description = $statusEnum ? $statusEnum->getDescription() : 'Error';
            $errorMessage = "Error {$statusCode}: {$description}";
            
            return new Response(
                $statusCode,
                ['Content-Type' => 'text/plain'],
                $errorMessage
            );
        }
        
        return $response;
    }
}
