<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $arrData = [
            [
                'name' => 'Canadian dollars',
                'code' => 'CAD',
            ],
            [
                'name' => 'US dollars',
                'code' => 'USD',
            ]
        ];
        DB::table('currencies')->insert($arrData);
    }
}
