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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->length(50);
            $table->string('username')->length(25);
            $table->string('email')->nullable();
            $table->string('password')->length(100)->nullable();
            $table->boolean('is_system')->default(0);
            $table->unsignedBigInteger('customer_id')->default(0);
            $table->string('permission')->default('[]')->comment("Data entry","Invoicing","Manage Users");
            $table->boolean('is_block')->default(0);
            $table->dateTime('last_visit')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->softDeletes();
            $table->integer('deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
