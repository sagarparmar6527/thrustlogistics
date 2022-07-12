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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->integer('created_by')->default(0);
            $table->dateTime('created_time')->nullable();
            $table->unsignedBigInteger('currency_id')->default(0);
            $table->string('invoice_no')->length(50)->nullable();
            $table->date('invoice_date')->nullable();
            $table->unsignedBigInteger('invoice_category')->default(0);
            $table->unsignedBigInteger('invoice_payable_id')->default(0);
            $table->unsignedBigInteger('invoice_carrier_id')->default(0);
            $table->text('invoice_orders');
            $table->char('invoice_tax_type')->length(3)->default('GST');
            $table->decimal('invoice_tax',10,2)->default(0);
            $table->decimal('invoice_total',10,2)->default(0);
            $table->text('invoice_comments')->nullable();
            $table->integer('is_paid')->default(0);
            $table->unsignedBigInteger('paid_by')->default(0);
            $table->dateTime('paid_time')->nullable();
            $table->string('paid_chq')->length(50)->nullable();
            $table->date('paid_chq_date')->nullable();
            $table->text('paid_comments')->nullable();
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
        Schema::dropIfExists('payments');
    }
};
