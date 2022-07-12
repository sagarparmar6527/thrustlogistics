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
        Schema::create('order_carriers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->default(0);
            $table->unsignedBigInteger('order_id')->default(0);
            $table->unsignedBigInteger('carrier_id')->default(0);
            $table->string('carrier_contact')->length(50)->nullable();
            $table->string('carrier_phone')->length(30)->nullable();
            $table->string('carrier_fax')->length(30)->nullable();
            $table->string('carrier_equipment')->length(50)->nullable();
            $table->text('from_instructions')->nullable();
            $table->string('to_company')->length(50)->nullable();
            $table->string('to_contact')->length(50)->nullable();
            $table->string('to_phone')->length(30)->nullable();
            $table->string('to_address')->length(50)->nullable();
            $table->string('to_address2')->length(50)->nullable();
            $table->string('to_city')->length(50)->nullable();
            $table->string('to_state')->length(50)->nullable();
            $table->string('to_postal')->length(50)->nullable();
            $table->integer('to_country_id')->nullable();
            $table->date('to_date')->nullable();
            $table->text('to_instructions')->nullable();
            $table->decimal('agreed_price',10,2)->nullable();
            $table->integer('agreed_price_currency')->default(0);
            $table->integer('is_all_inclusive')->default(1);
            $table->integer('dispatched')->default(0);
            $table->dateTime('dispatched_time')->nullable();
            $table->integer('payment_id')->default(0); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_carriers');
    }
};
