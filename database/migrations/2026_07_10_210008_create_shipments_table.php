<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->string('carrier')->nullable();          // DHL, Fedex, Estafeta, etc.
            $table->string('tracking_number')->nullable();
            $table->enum('status', [
                'preparando',
                'recolectado',
                'en_transito',
                'en_sucursal',
                'entregado',
                'fallido',
            ])->default('preparando');
            $table->string('estimated_delivery')->nullable();
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->json('tracking_history')->nullable();   // Para futuras APIs de rastreo
            $table->timestamps();

            $table->index('order_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
