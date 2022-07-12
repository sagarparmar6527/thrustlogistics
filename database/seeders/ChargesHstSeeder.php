<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ChargesHstSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $arrData = [
            [
                'name' => 'NONE',
                'percent' => 0.0,
            ],
            [
                'name' => '7% HST',
                'percent' => 7.0,
            ],
            [
                'name' => '6% HST',
                'percent' => 6.0,
            ],
            [
                'name' => '5% HST',
                'percent' => 5.0,
            ],
            [
                'name' => '13% HST',
                'percent' => 13.0,
            ]
            ];
        DB::table('charges_hsts')->insert($arrData);
    }
}
