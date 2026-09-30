<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('multiple_choices', function (Blueprint $table) {
            $table->id();
            // Relasi ke tugas utama
            $table->foreignId('assignment_id')->constrained()->cascadeOnDelete();

            // Soal dan Pilihan
            $table->text('question');
            $table->string('option_a');
            $table->string('option_b');
            $table->string('option_c');
            $table->string('option_d');

            // Kunci Jawaban (A / B / C / D)
            $table->enum('correct_answer', ['a', 'b', 'c', 'd']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('multiple_choices');
    }
};
