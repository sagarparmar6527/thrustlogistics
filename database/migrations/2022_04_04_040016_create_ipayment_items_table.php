<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ipayment_items', function (Blueprint $table) {
            $table->id();
            $table->integer('payment_id')->default(0);
            $table->integer('invoice_id')->default(0);
            $table->decimal('paid_amount',10,2)->default(0);
            $table->decimal('paid_exch_rate',7,6)->default('1.000000');
            $table->decimal('invoice_amount',10,2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ipayment_items');
    }
};
