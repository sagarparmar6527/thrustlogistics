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
        Schema::create('ipayments', function (Blueprint $table) {
            $table->id();
            $table->integer('created_by')->default(0);
            $table->dateTime('created_datetime')->nullable();
            $table->integer('payment_type_id')->default(0);
            $table->date('payment_date')->nullable();
            $table->string('payment_desc')->length(50)->nullable();
            $table->text('payment_comments')->nullable();
            $table->integer('customer_id')->default(0);
            $table->integer('paid_currency_id')->default(0);
            $table->decimal('paid_amt',10,2)->default(0);
            $table->integer('deleted_by')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ipayments');
    }
};
