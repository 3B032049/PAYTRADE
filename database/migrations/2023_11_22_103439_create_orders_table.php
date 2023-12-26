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
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('seller_id');
            $table->integer('status');
            $table->date('date');
            $table->integer('score')->nullable();
            $table->string('comment')->nullable();
            $table->integer('pay');
            $table->integer('price');
            $table->string('receiver');
            $table->string('receiver_phone');
            $table->string('receiver_address');
            $table->integer('card_number')->nullable();
            $table->integer('pay_code')->nullable();
            $table->integer('year')->nullable();
            $table->integer('month')->nullable();
            $table->integer('day')->nullable();
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
