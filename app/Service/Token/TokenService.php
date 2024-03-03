<?php

declare(strict_types=1);

namespace App\Service\Token;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Config\Repository;
use Laravel\Sanctum\NewAccessToken;

class TokenService
{
    public function __construct(private Repository $config)
    {
    }

    public function createToken(User $user, string $role): NewAccessToken
    {
        return $user->createToken(
            $this->config->get('sanctum.settings.token_name'),
            ['role:' . $role],
            Carbon::now()->addMinutes($this->config->get('sanctum.settings.token_expiration'))
        );
    }
}
