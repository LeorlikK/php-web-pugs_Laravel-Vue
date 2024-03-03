<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Http\Request;

class PaginateService
{
    public int $page;

    public function __construct(Request $request)
    {
        $pageNumber = intval($request->input('page'));
        $this->page = $pageNumber > 0 ? $pageNumber : 1;
    }
}
