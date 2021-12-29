<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExpensesTypeSeeder extends Seeder
{
    public function run()
    {
        DB::table('expenses_types')->insert([
            [
                'name' => 'Sürücü xərcləri',
                'key'  => 'driver_cost'
            ],
            [
                'name' => 'Gömrük Xərci',
                'key'  => 'custom_cost'
            ],
            [
                'name' => 'Tədarük Xərci',
                'key'  => 'supply_cost'
            ],
            [
                'name' => 'Bazar Xərci',
                'key'  => 'market_cost'
            ],
            [
                'name' => 'Digər Xərc',
                'key'  => 'other_cost'
            ],
            [
                'name' => 'Maya Dəyəri',
                'key'  => 'cost'
            ]
        ]);
    }
}
