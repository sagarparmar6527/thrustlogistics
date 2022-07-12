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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->date('invoice_date'); 
            $table->integer('invoice_user')->default('0'); 
            $table->unsignedBigInteger('customer_id')->default(0);
            $table->unsignedBigInteger('currency_id')->default(0);
            $table->char('tax_type')->default('GST');
            $table->decimal('charge_hst',10,2)->default(0);
            $table->decimal('charge_gst',10,2)->default(0);
            $table->decimal('charge_fuel',10,2)->default(0);
            $table->decimal('charge_total',10,2)->default(0);
            $table->integer('terms')->length(3)->default(30);
            $table->integer('printed')->default(0);
            $table->dateTime('printed_time')->nullable();
            $table->decimal('paid_amt',10,2)->nullable();
            $table->decimal('credit_amt',10,2)->nullable();
            $table->integer('credit_by')->nullable();
            $table->dateTime('credit_time')->nullable();
            $table->integer('withdrawn')->default(0);
            $table->text('withdrawn_comments')->nullable();
            $table->integer('withdrawn_by')->nullable();
            $table->dateTime('withdrawn_time')->nullable();
            $table->softDeletes();
            $table->integer('deleted_by')->nullable();

            // $table->foreign('customer_id')
            //     ->references('id')->on('customers')
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
        Schema::dropIfExists('invoices');
    }
};
