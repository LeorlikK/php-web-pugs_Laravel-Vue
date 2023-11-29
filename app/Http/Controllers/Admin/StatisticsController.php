<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Service\StatisticsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function index(StatisticsService $service): JsonResponse
    {
        $fullStatistics = $service->fullStatistics();

        return response()->json($fullStatistics);
    }
}
