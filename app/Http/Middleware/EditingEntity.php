<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\Page;
use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\Exceptions\MissingAbilityException;
use Symfony\Component\HttpFoundation\Response;

class EditingEntity
{
    /**
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     * @throws MissingAbilityException
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var Page $page */
        $page = $request->route('page');
        if (!$page) {
            throw new ModelNotFoundException();
        }

        if (!in_array(Auth::user()?->role->id, $page->roles->pluck('id')->toArray(), true)) {
            throw new MissingAbilityException();
        }

        return $next($request);
    }
}
