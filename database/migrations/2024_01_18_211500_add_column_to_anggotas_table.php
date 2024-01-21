<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToAnggotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('anggotas', function (Blueprint $table) {
            $table->string('user_id')->after('id');
            $table->string('pemuda_id')->after('name');
            $table->string('tgl_lahir')->after('nik');
            $table->string('tmp_lahir')->after('tgl_lahir');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('anggotas', function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->dropColumn('pemuda_id');
            $table->dropColumn('tgl_lahir');
            $table->dropColumn('tmp_lahir');
        });
    }
}
