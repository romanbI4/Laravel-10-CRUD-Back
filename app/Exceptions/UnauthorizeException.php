<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class UnauthorizeException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json([
            'errors' => [
                'credentials' => 'Invalid credentials.'
            ]
        ], 401);
    }
}
