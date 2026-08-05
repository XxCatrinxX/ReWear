<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('order_messages', function (Blueprint $table) {
            $table->enum('sender_role', ['buyer', 'seller'])->after('user_id')->default('buyer');
            $table->timestamp('read_at')->nullable()->after('message');
        });
    }

    public function down(): void
    {
        Schema::table('order_messages', function (Blueprint $table) {
            $table->dropColumn(['sender_role', 'read_at']);
        });
    }
};
