<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubdistrictToPemudasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pemudas', function (Blueprint $table) {
            $table->string('subdistrict')->default(null)->after('village');
            $table->string('nik')->default(null)->after('leader');
            $table->string('phone')->default(null)->after('nik');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pemudas', function (Blueprint $table) {
            $table->dropColumn('status_id');
            $table->dropColumn('nik');
            $table->dropColumn('phone');
        });
    }
}
