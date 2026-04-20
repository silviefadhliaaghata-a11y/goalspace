<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('kode_booking')->nullable()->unique()->after('id');
            $table->timestamp('checked_in_at')->nullable()->after('kode_booking');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['kode_booking', 'checked_in_at']);
        });
    }
};