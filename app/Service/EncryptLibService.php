<?php

declare(strict_types=1);

namespace App\Service;

use App\Service\Contracts\EncryptContract;
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
