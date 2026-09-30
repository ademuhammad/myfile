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
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_id')->constrained('assignments')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); // Siswa pengumpul
            $table->string('file_path')->nullable();
            $table->longText('code_snippet')->nullable(); // Jika paste kodingan langsung
            $table->integer('grade')->nullable();
            $table->text('feedback')->nullable();
            $table->timestamps(); // created_at ini sekaligus bertindak sebagai submitted_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};
