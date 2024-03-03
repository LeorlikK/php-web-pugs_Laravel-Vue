<?php

declare(strict_types=1);

namespace App\Data\User;

use App\Models\Role;
use App\Models\User;
use App\Services\PasswordService;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Data;

class UserCreateData extends Data
{
    public function __construct(
        #[Required, StringType, Min(1), Max(50), MapInputName('first_name'), MapOutputName('first_name')]
        public string $firstName,
        #[Required, StringType, Min(1), Max(50), MapInputName('last_name'), MapOutputName('last_name')]
        public string $lastName,
        #[Required, StringType, Email, Min(3), Max(50), Unique(User::class)]
        public string $email,
        #[Nullable, StringType, Min(1), Max(150)]
        public ?string $photo,
        #[Required, IntegerType, Exists(Role::class, 'id'), MapInputName('role_id'), MapOutputName('role_id')]
        public int $roleId,
        public string $password = '',
    ) {
        $this->password = PasswordService::generateRandomPassword();
    }

    public function exceptProperties(): array
    {
        return [
            'photo' => is_null($this->photo)
        ];
    }
}
