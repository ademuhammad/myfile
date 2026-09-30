<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('submissions', function (Blueprint $table) {
            $table->json('pg_answers')->nullable()->after('code_snippet'); // Menyimpan pilihan siswa
            $table->integer('pg_score')->nullable()->after('pg_answers'); // Menyimpan nilai PG otomatis
        });
    }

    public function down()
    {
        Schema::table('submissions', function (Blueprint $table) {
            $table->dropColumn(['pg_answers', 'pg_score']);
        });
    }
};
