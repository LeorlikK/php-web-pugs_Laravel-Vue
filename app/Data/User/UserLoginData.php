<?php

declare(strict_types=1);

namespace App\Data\User;

use App\Models\User;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Password;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

class UserLoginData extends Data
{
    public function __construct(
        #[Required, StringType, Email, Min(3), Max(70), Exists(User::class)]
        public string $email,
        #[Required, Password(min: 8, letters: true, mixedCase: true, numbers: true, symbols: true)]
        public string $password,
    ) {
    }

    public static function messages(...$args): array
    {
        return [

        ];
    }
}
