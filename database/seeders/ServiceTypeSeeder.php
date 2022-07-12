<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ServiceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $arrData = [
            [
                'name' => 'REGULAR',
                'abbreviation' => 'REG',
            ],
            [
                'name' => 'SAME DAY',
                'abbreviation' => 'S DAY',
            ],
            [
                'name' => 'RUSH',
                'abbreviation' => 'RUSH',
            ],
            [
                'name' => 'OVER-NIGHT',
                'abbreviation' => 'O/N',
            ],
            [
                'name' => 'DIRECT',
                'abbreviation' => 'DIR',
            ],
            [
                'name' => 'APPOINTMENT',
                'abbreviation' => 'APPT',
            ],
            [
                'name' => 'OTHER',
                'abbreviation' => 'OTHER',
            ],
            [
                'name' => 'EXPEDITE',
                'abbreviation' => 'EXPD',
            ],
            [
                'name' => 'STORAGE',
                'abbreviation' => 'STOR',
            ],
            [
                'name' => 'PACKING',
                'abbreviation' => 'PACK',
            ]
        ];
        DB::table('service_types')->insert($arrData);
    }
}
