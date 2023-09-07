<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Nurseries;
use Illuminate\Database\Seeder;

class TestNurseriesSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Nurseries::factory(50)->create();
    }
}
