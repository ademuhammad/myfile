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
    // Tambah kolom topik di tabel materials
    Schema::table('materials', function (Blueprint $table) {
        $table->string('topic')->nullable()->after('title');
    });

    // Buat tabel pivot untuk relasi Many-to-Many
    Schema::create('classroom_material', function (Blueprint $table) {
        $table->id();
        $table->foreignId('classroom_id')->constrained()->cascadeOnDelete();
        $table->foreignId('material_id')->constrained()->cascadeOnDelete();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('materials', function (Blueprint $table) {
            //
        });
    }
};
