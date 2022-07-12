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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->dateTime('order_datetime')->useCurrent();
            $table->unsignedBigInteger('customer_id')->default(0);
            $table->string('ref_number')->length(50)->nullable();
            $table->text('comments')->nullable();
            $table->string('from_company')->length(50)->nullable();
            $table->string('from_contact')->length(50)->nullable();
            $table->string('from_phone')->length(50)->nullable();
            $table->string('from_address')->length(50)->nullable();
            $table->string('from_address2')->length(50)->nullable();
            $table->string('from_city')->length(50)->nullable();
            $table->string('from_state')->length(50)->nullable();
            $table->string('from_postal')->length(50)->nullable();
            $table->unsignedSmallInteger('from_country_id')->nullable();
            $table->date('from_date')->nullable();
            $table->string('to_company')->length(50)->nullable();
            $table->string('to_contact')->length(50)->nullable();
            $table->string('to_phone')->length(50)->nullable();
            $table->string('to_address')->length(50)->nullable();
            $table->string('to_address2')->length(50)->nullable();
            $table->string('to_city')->length(50)->nullable();
            $table->string('to_state')->length(50)->nullable();
            $table->string('to_postal')->length(50)->nullable();
            $table->unsignedBigInteger('to_country_id')->nullable();
            $table->date('to_date')->nullable();
            $table->string('pcs')->length(50)->nullable();
            $table->string('weight')->length(50)->nullable();
            $table->decimal('value',10,2)->default(0);
            $table->string('content')->length(50)->nullable();
            $table->unsignedBigInteger('service_id')->default(0);
            $table->decimal('service_charge',10,2)->default(0);
            $table->string('adjustments')->length(150)->nullable();
            $table->decimal('adjustments_charge')->default(0);
            $table->unsignedBigInteger('hst_id')->default(0);
            $table->decimal('hst_charge',10,2)->default(0);
            $table->unsignedSmallInteger('gst_id')->default(0);
            $table->decimal('gst_charge',10,2)->default(0);
            $table->unsignedBigInteger('fuel_id')->default(0);
            $table->decimal('fuel_charge',10,2)->default(0);
            $table->decimal('total_charges',10,2)->default(0);
            $table->unsignedBigInteger('currency_id')->default(0);
            $table->integer('is_local')->default(0);
            $table->integer('is_domestic')->default(0);
            $table->integer('is_international')->default(0);
            $table->integer('is_prepaid')->default(0);
            $table->integer('is_ground')->default(0);
            $table->integer('is_collect')->default(0);
            $table->integer('is_air')->default(0);
            $table->integer('is_thirdparty')->default(0);
            $table->integer('is_insurance')->default(0);
            $table->integer('is_cod')->default(0);
            $table->decimal('cod_amt',10,2)->default(0);
            $table->string('lading_shiperno')->length(50)->nullable();
            $table->string('lading_customerno')->length(50)->nullable();
            $table->string('lading_orderno')->length(50)->nullable();
            $table->string('lading_noteno')->length(50)->nullable();
            $table->string('lading_acsprono')->length(50)->nullable();
            $table->text('lading_pcs')->nullable();
            $table->text('lading_desc')->nullable();
            $table->text('lading_weight')->nullable();
            $table->text('lading_dim')->nullable();
            $table->string('pod_info')->length(50)->nullable();
            $table->dateTime('pod_datetime')->nullable();
            $table->unsignedBigInteger('status_id')->default(1);
            $table->integer('is_invoice_ready')->default(0);
            $table->integer('is_invoice_rush')->default(0);
            $table->unsignedBigInteger('invoice_id')->nullable();
            $table->integer('checked_out')->nullable();
            $table->dateTime('checked_out_time')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->softDeletes();
            $table->text('deleted_comments')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
