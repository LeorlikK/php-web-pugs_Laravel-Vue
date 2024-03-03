<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Service\Contracts\EncryptContract;
use App\Service\EncryptLibService;
use Closure;
use Illuminate\Config\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class Encrypt
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $config = App::make(Repository::class);
        App::bind(EncryptContract::class, EncryptLibService::class);

        $encryptService = App::make(EncryptContract::class);

        if ($config->get('app.debug')) {
            $encryptData = $encryptService->encrypt($request->all());
            $decryptData = $encryptService->decrypt($encryptData);
        } else {
            $decryptData = $encryptService->decrypt(...$request->all());
        }

        $request->replace($decryptData);

        return $next($request);
    }
}
