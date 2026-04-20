<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('metode_pembayaran')->nullable()->after('status');
            $table->string('bukti_pembayaran')->nullable()->after('metode_pembayaran');
            $table->text('catatan_pembayaran')->nullable()->after('bukti_pembayaran');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'metode_pembayaran',
                'bukti_pembayaran',
                'catatan_pembayaran',
            ]);
        });
    }
};