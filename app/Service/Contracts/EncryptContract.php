<?php

declare(strict_types=1);

namespace App\Services\Contracts;

interface EncryptContract
{
    public function encrypt($value, $serialize = true);
    public function decrypt($payload, $unserialize = true);
}
