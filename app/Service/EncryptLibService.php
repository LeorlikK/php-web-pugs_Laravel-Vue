<?php

declare(strict_types=1);

namespace App\Services;

use App\Services\Contracts\EncryptContract;
use Maize\Encryptable\Encryption;

class EncryptLibService implements EncryptContract
{
    public function encrypt($value, $serialize = true)
    {
        return Encryption::php()->encrypt(json_encode($value), $serialize);
    }

    public function decrypt($payload, $unserialize = true)
    {
        return json_decode(Encryption::php()->decrypt($payload, $unserialize), true);
    }
}
