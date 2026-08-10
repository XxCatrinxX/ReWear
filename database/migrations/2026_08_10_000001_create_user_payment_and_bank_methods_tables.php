<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_payment_methods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('card_type'); // credito / debito
            $table->string('card_brand')->default('Visa'); // Visa, Mastercard, Amex
            $table->string('bank_name')->default('Banco'); // BBVA, Citibanamex, etc.
            $table->string('cardholder_name');
            $table->string('last_four', 4);
            $table->string('expiration'); // MM/AA
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });

        Schema::create('user_bank_methods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('bank_name');
            $table->string('clabe', 18);
            $table->string('account_holder');
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_bank_methods');
        Schema::dropIfExists('user_payment_methods');
    }
};
