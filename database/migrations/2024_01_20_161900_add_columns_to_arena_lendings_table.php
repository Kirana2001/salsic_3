<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToArenaLendingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('arena_lendings', function (Blueprint $table) {
            $table->time('start_time')->after('end_date');
            $table->time('end_time')->after('start_time');
            $table->string('jenis_kegiatan')->after('end_time');
            $table->string('nama_kegiatan')->after('jenis_kegiatan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('arena_lendings', function (Blueprint $table) {
            $table->dropColumn('start_time');
            $table->dropColumn('end_time');
            $table->dropColumn('jenis_kegiatan');
            $table->dropColumn('nama_kegiatan');
        });
    }
}
