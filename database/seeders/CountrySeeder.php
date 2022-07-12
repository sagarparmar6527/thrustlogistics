<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $arrData = [
            [
                'name' => 'Canada',
            ],
            [
                'name' => 'USA',
            ],
            [
                'name' => 'Mexico',
            ]
        ];
        DB::table('countries')->insert($arrData);
    }
}
