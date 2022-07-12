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
        Schema::create('addressbooks', function (Blueprint $table) {
            $table->id();
            $table->string('address_name')->length(50);
            $table->unsignedBigInteger('customer_id')->default(0);
            $table->string('company')->length(50);
            $table->string('contact')->length(50)->nullable();
            $table->string('phone')->length(30)->nullable();
            $table->string('address')->length(50)->nullable();
            $table->string('address2')->length(50)->nullable();
            $table->string('city')->length(50)->nullable();
            $table->string('state')->length(50)->nullable();
            $table->string('postal')->length(10)->default(10);
            $table->unsignedBigInteger('country_id')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->softDeletes();

            // $table->foreign('customer_id')
            //     ->references('id')->on('customers')
            //     ->onDelete('cascade');
            // $table->foreign('country_id')
            //     ->references('id')->on('countries')
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
        Schema::dropIfExists('addressbooks');
    }
};
