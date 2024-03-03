<?php

declare(strict_types=1);

namespace App\Common;

class UserRole
{
    public const string USER = 'user';
    public const string MODER = 'moder';
    public const string ADMIN = 'admin';

    public const array ROLES = [
        [
            'name' => self::ADMIN,
            'label' => 'Администратор'
        ],
        [
            'name' => self::USER,
            'label' => 'Пользователь'
        ],
        [
            'name' => self::MODER,
            'label' => 'Модератор'
        ],
    ];
}
