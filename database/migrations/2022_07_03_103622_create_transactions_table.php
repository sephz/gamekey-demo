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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->uuid('transaction_id');
            $table->foreignId('key_id')->constrained('keys');
            $table->foreignId('merchant_id')->constrained('merchants');
            $table->foreignId('buyer_id')->constrained('users');
            $table->string('key',80);
            $table->string('currency',3)->default('MYR');
            $table->unsignedInteger('total_paid');
            $table->unsignedInteger('commission');
            $table->string('cc_name');
            $table->string('cc_last',4);
            $table->string('status',25)->default('PENDING');
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
