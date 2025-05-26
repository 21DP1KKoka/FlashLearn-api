<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class ApiException extends Exception
{
    /**
     * @return JsonResponse
     */
    public function render(): JsonResponse {
        return response()->json([
            'message' => $this->getMessage(),
        ], $this->getCode());
    }
}
