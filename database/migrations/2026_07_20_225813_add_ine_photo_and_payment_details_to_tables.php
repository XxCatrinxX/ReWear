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
        Schema::table('users', function (Blueprint $table) {
            $table->string('ine_photo')->nullable()->after('avatar');
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->string('card_type')->nullable()->after('method'); // credit, debit
            $table->string('bank_name')->nullable()->after('card_type'); // BBVA, Santander, Banorte, etc.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('ine_photo');
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['card_type', 'bank_name']);
        });
    }
};
