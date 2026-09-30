<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('sub_assignments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('assignment_id')->constrained()->cascadeOnDelete();
        $table->string('title'); // Contoh: "Soal Pilihan Ganda", "Tugas Ngoding"
        $table->text('description')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_assignments');
    }
};
