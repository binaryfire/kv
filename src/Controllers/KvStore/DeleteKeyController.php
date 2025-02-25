<?php

declare(strict_types=1);

namespace App\Controllers\KvStore;

use App\Concerns\ValidatesKvStore;
use App\Enums\HttpStatusEnum;
use App\Exceptions\KvStoreException;
use App\Services\KvStoreService;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Message\Response;

class DeleteKeyController
{
    use ValidatesKvStore;

    public function __construct(private KvStoreService $kvStore)
    {
    }

    /**
     * Handle the request
     */
    public function __invoke(ServerRequestInterface $request)
    {
        $key = $request->getAttribute('key') ?? '';

        $validationError = $this->validateKeyOrError($key);
        if ($validationError !== null) {
            return $validationError;
        }

        return $this->kvStore->delete($key)->then(
            function () {
                return Response::plaintext('')->withStatus(HttpStatusEnum::no_content->value);
            },

            function (KvStoreException $e) {
                error_log("Error deleting key: " . $e->getMessage());
                return Response::plaintext('')->withStatus(HttpStatusEnum::internal_server_error->value);
            }
        );
    }
}
