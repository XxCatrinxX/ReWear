<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Adds missing columns to the order_reports table that was
     * created with an incomplete migration.
     */
    public function up(): void
    {
        Schema::table('order_reports', function (Blueprint $table) {
            if (!Schema::hasColumn('order_reports', 'order_id')) {
                $table->foreignId('order_id')->after('id')->constrained()->onDelete('cascade');
            }
            if (!Schema::hasColumn('order_reports', 'user_id')) {
                $table->foreignId('user_id')->after('order_id')->constrained()->onDelete('cascade');
            }
            if (!Schema::hasColumn('order_reports', 'type')) {
                $table->string('type')->default('envio')->after('user_id');
            }
            if (!Schema::hasColumn('order_reports', 'reason')) {
                $table->string('reason')->after('type');
            }
            if (!Schema::hasColumn('order_reports', 'description')) {
                $table->text('description')->after('reason');
            }
            if (!Schema::hasColumn('order_reports', 'status')) {
                $table->enum('status', ['pendiente', 'en_revision', 'resuelto', 'desestimado'])
                      ->default('pendiente')
                      ->after('description');
            }
            if (!Schema::hasColumn('order_reports', 'admin_notes')) {
                $table->text('admin_notes')->nullable()->after('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_reports', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
            $table->dropForeign(['user_id']);
            $table->dropColumn(['order_id', 'user_id', 'type', 'reason', 'description', 'status', 'admin_notes']);
        });
    }
};
