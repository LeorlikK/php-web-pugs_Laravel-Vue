<?php

namespace App\Http\Controllers\Nurseries;

use App\Http\Controllers\Controller;
use App\Http\Resources\NurseriesResource;
use App\Models\Nurseries;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class NurseriesController extends Controller
{
    public function index(?string $page=null): AnonymousResourceCollection
    {
        $perPage = 10;
        $page = (int) $page ?? 1;

        $nurseries = Nurseries::query()->paginate($perPage, '*', 'page', $page);

        return NurseriesResource::collection($nurseries);
    }
}
