<?php

declare(strict_types=1);

namespace App\Controllers\KvStore;

use App\Enums\HttpStatusEnum;
use App\Exceptions\KvStoreException;
use App\Services\KvStoreService;
use React\Http\Message\Response;

class ListKeysController
{
    public function __construct(private KvStoreService $kvStore)
    {
    }

    /**
     * Handle the request
     */
    public function __invoke()
    {
        return $this->kvStore->listKeys()->then(
            function ($result) {
                if (empty($result->rows)) {
                     return Response::plaintext('');
                }
                
                // Format keys as a plain text list, one per line
                $keys = array_column($result->rows, 'key');
                $response = implode("\n", $keys);
                
                return Response::plaintext($response);
            },

            function (KvStoreException $e) {
                error_log("Error listing keys: " . $e->getMessage());
                Response::plaintext('')->withStatus(HttpStatusEnum::internal_server_error->value);
                }
        );
    }
}