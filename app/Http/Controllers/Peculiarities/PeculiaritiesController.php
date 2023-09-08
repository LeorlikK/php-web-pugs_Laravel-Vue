<?php

namespace App\Http\Controllers\Peculiarities;

use App\Http\Controllers\Controller;
use App\Http\Resources\PeculiaritiesResource;
use App\Models\Peculiarities;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PeculiaritiesController extends Controller
{
    public function peculiarities(): array
    {
        $peculiarities = Peculiarities::find(1);
        return PeculiaritiesResource::make($peculiarities)->resolve();
    }

    public function care(): array
    {
        $care = Peculiarities::find(2);
        return PeculiaritiesResource::make($care)->resolve();
    }

    public function nutrition(): array
    {
        $nutrition = Peculiarities::find(3);
        return PeculiaritiesResource::make($nutrition)->resolve();
    }

    public function health(): array
    {
        $health = Peculiarities::find(4);
        return PeculiaritiesResource::make($health)->resolve();
    }

    public function paddock(): array
    {
        $paddock = Peculiarities::find(5);
        return PeculiaritiesResource::make($paddock)->resolve();
    }
}
