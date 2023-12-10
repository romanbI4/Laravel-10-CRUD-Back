<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class PermissionException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json([
            'errors' => [
                'user' => 'Current logged in user is not allowed to edit this company.'
            ]
        ], 403);
    }
}
