<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function successResponse(mixed $data = null): JsonResponse
    {
        return new JsonResponse(
            [
                'success' => true,
                'data' => $data,
                'status_code' => 0,
            ]
        );
    }
}
