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
        Schema::table('siswas', function (Blueprint $table) {
            // Add columns if they don't exist
            if (!Schema::hasColumn('siswas', 'nama')) {
                $table->string('nama')->nullable();
            }
            if (!Schema::hasColumn('siswas', 'nis')) {
                $table->string('nis')->unique()->nullable();
            }
            if (!Schema::hasColumn('siswas', 'jurusan')) {
                $table->string('jurusan')->nullable();
            }
            if (!Schema::hasColumn('siswas', 'tempat_magang')) {
                $table->string('tempat_magang')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            $table->dropColumn(['nama', 'nis', 'jurusan', 'tempat_magang']);
        });
    }
};
