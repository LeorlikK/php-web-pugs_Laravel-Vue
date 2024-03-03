<?php

declare(strict_types=1);

namespace App\Data\User;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\Validation\CurrentPassword;
use Spatie\LaravelData\Attributes\Validation\Password;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

class UserResetData extends Data
{
    public function __construct(
        #[Required, CurrentPassword('api'), MapInputName('old_password')]
        public string $oldPassword,
        #[Required, Password(min: 8, letters: true, mixedCase: true, numbers: true, symbols: true), MapInputName('new_password')]
        public string $newPassword,
    ) {
    }

    public static function messages(...$args): array
    {
        return [

        ];
    }
}
