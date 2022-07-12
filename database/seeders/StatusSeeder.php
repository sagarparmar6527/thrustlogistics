<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $arrData = [
            ['name' => 'Draft'],
            ['name' => 'Submitted'],
            ['name' => 'Dispatched'],
            ['name' => 'Delivered'],
            ['name' => 'Invoiced'],
            ['name' => 'Canceled'],
            ['name' => 'Ready']
        ];
        DB::table('statuses')->insert($arrData);
    }
}
