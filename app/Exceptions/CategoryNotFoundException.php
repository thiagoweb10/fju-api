<?php

namespace App\Exceptions;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use Exception;

class CategoryNotFoundException extends Exception
{
    public function render(Request $request): JsonResponse
    {
        return response()->json([

            'error' => true,
            'message' => $this->getMessage() ?? 'Categoria não encontrada.'
        ], 404, [],JSON_UNESCAPED_UNICODE);
    }
}