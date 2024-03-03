<?php

declare(strict_types=1);

namespace App\Data\User;

use App\Models\Role;
use App\Models\User;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\References\RouteParameterReference;

class UserUpdateData extends Data
{
    public function __construct(
        #[Nullable, StringType, Min(1), Max(50), MapInputName('first_name'), MapOutputName('first_name')]
        public ?string $firstName,
        #[Nullable, StringType, Min(1), Max(50), MapInputName('last_name'), MapOutputName('last_name')]
        public ?string $lastName,
        #[Nullable, StringType, Email, Min(3), Max(50), Unique(User::class, ignore: new RouteParameterReference(
            'user',
            'id'
        ))]
        public ?string $email,
        #[Nullable, StringType, Min(1), Max(150)]
        public ?string $photo,
        #[Nullable, IntegerType, Exists(Role::class, 'id'), MapInputName('role_id'), MapOutputName('role_id')]
        public ?int $roleId,
    ) {
    }

    public function exceptProperties(): array
    {
        return [
            'firstName' => is_null($this->firstName),
            'lastName' => is_null($this->lastName),
            'email' => is_null($this->email),
            'photo' => is_null($this->photo),
            'roleId' => is_null($this->roleId)
        ];
    }
}
