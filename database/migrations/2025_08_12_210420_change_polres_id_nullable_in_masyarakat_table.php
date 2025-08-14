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
        Schema::table('masyarakat', function (Blueprint $table) {
            $table->unsignedBigInteger('polsek_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('masyarakat', function (Blueprint $table) {
            $table->unsignedBigInteger('polsek_id')->nullable(false)->change();
        });
    }
};
