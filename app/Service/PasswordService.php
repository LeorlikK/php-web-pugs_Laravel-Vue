<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Str;

class PasswordService
{
    public static function generateRandomPassword(int $length = 16): string
    {
        $customSymbols = [
            chr(random_int(65, 90)),
            chr(random_int(97, 122)),
        ];

        $length = max($length, 8) - count($customSymbols);
        $password = Str::password($length, letters: true, numbers: true, symbols: true);

        foreach ($customSymbols as $symbol) {
            $password .= $symbol;
        }

        return str_shuffle($password);
    }
}
