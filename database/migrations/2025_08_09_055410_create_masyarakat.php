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
        Schema::create('masyarakat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('polres_id')->constrained('polres')->onDelete('cascade');
            $table->foreignId('polsek_id')->constrained('polsek')->onDelete('cascade');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->string('nama');
            $table->string('nik');
            $table->string('alamat');
            $table->string('foto_ktp');
            $table->integer('jumlah_beras');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('masyarakat');
    }
};
