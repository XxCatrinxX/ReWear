<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->decimal('pending_balance', 10, 2)->default(0)->after('is_seller');
            $table->decimal('available_balance', 10, 2)->default(0)->after('pending_balance');
            $table->string('clabe', 18)->nullable()->after('available_balance');
            $table->string('bank_name', 100)->nullable()->after('clabe');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['pending_balance', 'available_balance', 'clabe', 'bank_name']);
        });
    }
};
