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
        Schema::table('user_profile', function (Blueprint $table) {
            // Hapus kolom 'age'
            $table->dropColumn('satker');

            // Tambah kolom polres_id dan polsek_id sebagai foreign key
            $table->unsignedBigInteger('polres_id')->after('user_id')->nullable();
            $table->unsignedBigInteger('polsek_id')->after('user_id')->nullable();

            // Buat foreign key constraint
            $table->foreign('polres_id')->references('id')->on('polres')->onDelete('set null');
            $table->foreign('polsek_id')->references('id')->on('polsek')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_profile', function (Blueprint $table) {
            // Drop foreign keys dulu
            $table->dropForeign(['polres_id']);
            $table->dropForeign(['polsek_id']);

            // Drop kolom foreign key
            $table->dropColumn(['polres_id', 'polsek_id']);

            // Tambah kolom satker kembali
            $table->string('satker');
        });
    }
};
