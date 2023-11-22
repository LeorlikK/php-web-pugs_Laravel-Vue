<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestUsersSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        for ($i = 0; $i < 50; $i++) {
            $index = '_' . $i;
            User::create([
                'login' => 'leorlik' . $index,
                'email' => "leorlik$index@ya.ru",
                'role' => ['admin', 'user', 'moder'][random_int(0, 2)],
                'email_verified_at' => now(),
                'password' => Hash::make('Pristxolidc2013'),
                'avatar' => 'images/avatars/avatar_default.png',
                'banned' => [true, false][random_int(0, 1)],
                'remember_token' => null,
            ]);
        }
    }
}
