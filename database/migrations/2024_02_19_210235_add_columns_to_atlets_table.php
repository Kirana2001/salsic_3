<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToAtletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('atlets', function (Blueprint $table) {
            $table->string('nis')->after('school');
            $table->string('weight')->after('phone');
            $table->string('height')->after('weight');
            $table->string('kk_img')->after('image');
            $table->string('kartu_pelajar')->after('kk_img');
            $table->string('akte')->after('kartu_pelajar');
            $table->string('raport')->after('akte');
            $table->string('sertif_penghargaan')->after('raport');
            $table->string('sertif_kejuaraan')->after('sertif_penghargaan');
            $table->string('keterangan')->after('sertif_kejuaraan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('atlets', function (Blueprint $table) {
            $table->dropColumn('nis');
            $table->dropColumn('weight');
            $table->dropColumn('height');
            $table->dropColumn('kk_img');
            $table->dropColumn('kartu_pelajar');
            $table->dropColumn('akte');
            $table->dropColumn('raport');
            $table->dropColumn('sertif_penghargaan');
            $table->dropColumn('sertif_kejuaraan');
            $table->dropColumn('keterangan');
        });
    }
}
