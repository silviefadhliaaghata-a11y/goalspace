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
    Schema::create('lapangans', function (Blueprint $table) {
        $table->id();
        $table->string('nama');
        $table->string('jenis')->nullable();
        $table->decimal('harga', 12, 0)->default(0);
        $table->text('deskripsi')->nullable();
        $table->string('status')->default('Tersedia');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lapangans');
    }
};
