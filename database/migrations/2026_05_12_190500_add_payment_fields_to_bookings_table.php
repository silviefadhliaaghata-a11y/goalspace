<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('payment_reference')->nullable()->after('kode_booking');
            $table->timestamp('payment_deadline')->nullable()->after('payment_reference');
            $table->timestamp('payment_verified_at')->nullable()->after('payment_deadline');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'payment_reference',
                'payment_deadline',
                'payment_verified_at'
            ]);
        });
    }
};