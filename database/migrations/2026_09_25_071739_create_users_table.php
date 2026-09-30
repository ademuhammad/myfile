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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');

            // Sistem Login & Identifikasi
            $table->string('username')->unique(); // Bisa diisi NIS siswa atau NIP guru
            $table->string('email')->unique()->nullable(); // Nullable agar siswa tanpa email tetap bisa didaftarkan

            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            // Profil & Hak Akses
            $table->string('foto')->nullable(); // Akan menyimpan path file (misal: 'uploads/profil/siswa1.jpg')
            $table->enum('role', ['guru', 'siswa'])->default('siswa');

            // Relasi ke tabel classrooms (dari langkah sebelumnya)
            $table->foreignId('classroom_id')->nullable()->constrained('classrooms')->nullOnDelete();

            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
