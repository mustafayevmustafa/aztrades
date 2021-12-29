<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            CitySeeder::class,
            CountrySeeder::class,
            ExpensesTypeSeeder::class,
            UserSeeder::class,
        ]);
    }
}
