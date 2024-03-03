<?php

declare(strict_types=1);

namespace App\Service\Contracts;

interface EncryptContract
{
    public function encrypt($value, $serialize = true);
    public function decrypt($payload, $unserialize = true);
}
