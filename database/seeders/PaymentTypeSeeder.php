<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class PaymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $arrData = [
            [
                'name' => 'Cheque',
                'abbreviation' => 'Chq',
            ],
            [
                'name' => 'Credit Card',
                'abbreviation' => 'VISA',
            ],
            [
                'name' => 'Interact',
                'abbreviation' => 'Interact',
            ],
            [
                'name' => 'Cash',
                'abbreviation' => 'Cash',
            ]
        ];
        DB::table('payment_types')->insert($arrData);
    }
}
