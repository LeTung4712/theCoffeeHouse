<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->nullable()->default("");
            $table->integer('user_id');
            $table->string('user_name');
            $table->string('mobile_no');
            $table->integer('state')->nullable()->default(0);
            $table->string('address');
            $table->text('note')->nullable();
            $table->integer('total_price');
            $table->string('shipcost');
            $table->string('payment_method')->nullable()->default("");
            $table->datetime('order_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
