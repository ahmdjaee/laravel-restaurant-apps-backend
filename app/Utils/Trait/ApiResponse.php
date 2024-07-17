<?php

namespace App\Utils\Trait;

use Illuminate\Http\Exceptions\HttpResponseException;

trait ApiResponse
{
    public function apiResponse($data, $message = null, $statusCode = 200)
    {
        return response()->json([
            'data' => $data,
            'message' => $message
        ], $statusCode);
    }
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
