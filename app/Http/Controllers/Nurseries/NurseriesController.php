<?php

namespace App\Http\Controllers\Nurseries;

use App\Http\Controllers\Controller;
use App\Http\Resources\NurseriesResource;
use App\Models\Nurseries;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class NurseriesController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $perPage = 10;
        $page = (int) $request->input('page') ?? 1;

        $nurseries = Nurseries::query()->paginate($perPage, '*', 'page', $page);

        return NurseriesResource::collection($nurseries);
    }
}
