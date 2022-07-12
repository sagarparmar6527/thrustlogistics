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
        Schema::create('payables', function (Blueprint $table) {
            $table->id();
            $table->integer('is_carrier')->default(0);
            $table->string('company')->length(50);
            $table->string('contact')->length(50)->nullable();
            $table->string('phone')->length(30)->nullable();
            $table->string('phone_other')->length(30)->nullable();
            $table->string('fax')->length(30)->nullable();
            $table->string('email')->length(30)->nullable();
            $table->text('comments')->nullable();
            $table->string('address')->length(50)->nullable();
            $table->string('address2')->length(50)->nullable();
            $table->string('city')->length(50)->nullable();
            $table->string('state')->length(30)->nullable();
            $table->string('postal')->length(10)->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->integer('bill_sameasmailing')->default(1);
            $table->string('bill_address')->length(50)->nullable();
            $table->string('bill_address2')->length(50)->nullable();
            $table->string('bill_city')->length(50)->nullable();
            $table->string('bill_state')->length(50)->nullable();
            $table->string('bill_postal')->length(10)->nullable();
            $table->unsignedBigInteger('bill_country_id')->nullable();
            $table->unsignedBigInteger('currency_id')->default(0);
            $table->integer('deleted_by')->nullable();
            $table->softDeletes();

            // $table->foreign('country_id')
            // ->references('id')->on('countries')
            // ->onDelete('cascade');

            // $table->foreign('bill_country_id')
            //     ->references('id')->on('countries')
            //     ->onDelete('cascade');

            // $table->foreign('currency_id')
            //     ->references('id')->on('currencies')
            //     ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payables');
    }
};
