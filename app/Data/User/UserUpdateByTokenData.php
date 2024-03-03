<?php

declare(strict_types=1);

namespace App\Data\User;

use Illuminate\Auth\AuthManager;
use Illuminate\Support\Facades\App;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Rule;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

class UserUpdateByTokenData extends Data
{
    public function __construct(
        #[Nullable, StringType, Min(1), Max(50), MapInputName('first_name'), MapOutputName('first_name')]
        public ?string $firstName,
        #[Nullable, StringType, Min(1), Max(50), MapInputName('last_name'), MapOutputName('last_name')]
        public ?string $lastName,
        public ?string $email,
        #[Nullable, StringType, Min(1), Max(150)]
        public ?string $photo,
    ) {
    }

    public function exceptProperties(): array
    {
        return [
            'firstName' => is_null($this->firstName),
            'lastName' => is_null($this->lastName),
            'email' => is_null($this->email),
            'photo' => is_null($this->photo),
        ];
    }

    public static function rules(): array
    {
        $auth = App::make(AuthManager::class);
        $id = $auth->user()->id;

        return [
            'email' => [new Nullable(), new StringType(), new Email(), new Min(3), new Max(150),
                new Rule("unique:users,email,$id"),
            ],
        ];
    }
}
