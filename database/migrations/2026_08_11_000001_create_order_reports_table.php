<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Comprador que reporta
            $table->enum('type', ['producto', 'envio', 'otro'])->default('envio');
            $table->string('reason');
            $table->text('description');
            $table->enum('status', ['pendiente', 'en_revision', 'resuelto', 'desestimado'])->default('pendiente');
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_reports');
    }
};
