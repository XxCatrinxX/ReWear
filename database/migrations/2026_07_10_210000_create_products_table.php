<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->foreignId('category_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->string('title', 200);
            $table->string('slug', 220)->unique();
            $table->text('description');
            $table->string('brand', 100)->nullable();
            $table->string('size', 20)->nullable();    // XS, S, M, L, XL, XXL, etc.
            $table->string('color', 50)->nullable();
            $table->enum('condition', ['nuevo', 'como_nuevo', 'bueno', 'aceptable'])->default('bueno');
            $table->decimal('price', 10, 2);
            $table->unsignedSmallInteger('stock')->default(1);
            $table->boolean('is_sold')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->string('cover_image')->nullable();  // Imagen principal para listing
            $table->timestamps();
            $table->softDeletes();

            $table->index(['is_active', 'is_sold']);
            $table->index('category_id');
            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
