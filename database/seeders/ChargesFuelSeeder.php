<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ChargesFuelSeeder extends Seeder
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
                'name' => '@ 3% CHARGE',
                'percent' => 3.0,
            ],
            [
                'name' => '@ 4% CHARGE',
                'percent' => 4.0,
            ],
            [
                'name' => '@ 5% CHARGE',
                'percent' => 5.0,
            ],
            [
                'name' => '@ 6% CHARGE',
                'percent' => 6.0,
            ],
            [
                'name' => '@ 7% CHARGE',
                'percent' => 7.0,
            ],
            [
                'name' => '@ 8% CHARGE',
                'percent' => 8.0,
            ],
            [
                'name' => '@ 9% CHARGE',
                'percent' => 9.0,
            ],
            [
                'name' => '@ 10% CHARGE',
                'percent' => 10.0,
            ],
            [
                'name' => '@ 11% CHARGE',
                'percent' => 11.0,
            ],
            [
                'name' => '@ 12% CHARGE',
                'percent' => 12.0,
            ],
            [
                'name' => '@ 13% CHANGE',
                'percent' => 13.0,
            ],
            [
                'name' => '@ 14% CHANGE',
                'percent' => 14.0,
            ],
            [
                'name' => '@ 15% CHANGE',
                'percent' => 15.0,
            ],
            [
                'name' => '@ 16% CHANGE',
                'percent' => 16.0,
            ],
            [
                'name' => '@ 17% CHANGE',
                'percent' => 17.0,
            ],
            [
                'name' => '@ 18% CHANGE',
                'percent' => 18.0,
            ],
            [
                'name' => '@ 19% CHANGE',
                'percent' => 19.0,
            ],
            [
                'name' => '@ 20% CHANGE',
                'percent' => 20.0,
            ],
            [
                'name' => '@ 21% CHARGE',
                'percent' => 21.0,
            ],
            [
                'name' => '@ 22% CHARGE',
                'percent' => 22.0,
            ],
            [
                'name' => '@ 23% CHARGE',
                'percent' => 23.0,
            ],
            [
                'name' => '@ 24% CHARGE',
                'percent' => 24.0,
            ],
            [
                'name' => '@ 25% CHARGE',
                'percent' => 25.0,
            ],
            [
                'name' => '@ 26% CHARGE',
                'percent' => 26.0,
            ],
            [
                'name' => '@ 27% CHARGE',
                'percent' => 27.0,
            ],
            [
                'name' => '@ 28% CHARGE',
                'percent' => 28.0,
            ],
            [
                'name' => '@ 29% CHARGE',
                'percent' => 29.0,
            ],
            [
                'name' => '@ 30% CHARGE',
                'percent' => 30.0,
            ]
        ];
        DB::table('charges_fuels')->insert($arrData);
    }
}
