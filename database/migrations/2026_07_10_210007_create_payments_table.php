<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->string('transaction_id')->nullable()->unique();
            $table->enum('method', ['simulado', 'tarjeta', 'transferencia', 'efectivo'])->default('simulado');
            $table->enum('status', ['pendiente', 'completado', 'fallido', 'reembolsado'])->default('pendiente');
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('MXN');
            $table->json('gateway_response')->nullable();  // Para futuras pasarelas reales
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->index('order_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
