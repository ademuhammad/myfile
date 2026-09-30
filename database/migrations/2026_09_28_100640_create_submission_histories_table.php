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
    Schema::create('submission_histories', function (Blueprint $table) {
        $table->id();
        $table->foreignId('submission_id')->constrained()->cascadeOnDelete();
        $table->string('file_path')->nullable();
        $table->text('code_snippet')->nullable();
        $table->timestamps(); // Mencatat kapan perubahan ini dilakukan
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submission_histories');
    }
};
