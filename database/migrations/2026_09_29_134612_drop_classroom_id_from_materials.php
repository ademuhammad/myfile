<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('materials', function (Blueprint $table) {
            // Menghapus foreign key terlebih dahulu (agar tidak error)
            $table->dropForeign(['classroom_id']);

            // Lalu menghapus kolomnya
            $table->dropColumn('classroom_id');
        });
    }

    public function down()
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->foreignId('classroom_id')->nullable()->constrained()->cascadeOnDelete();
        });
    }
};
