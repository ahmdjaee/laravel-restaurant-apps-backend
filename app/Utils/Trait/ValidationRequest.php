<?php

namespace App\Utils\Trait;
use Illuminate\Http\Exceptions\HttpResponseException;

trait ValidationRequest
{
    public function validationRequest(string $message, int $statusCode)
    {
        throw new HttpResponseException(response([
            'errors' => [
                'message' => [
                    $message
                ]
            ]
        ], $statusCode));
    }
}
