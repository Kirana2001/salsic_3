<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnBidangIdToPaemudaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pemudas', function (Blueprint $table) {
            $table->unsignedBigInteger('bidang_id')->after('cabor_id');
            $table->unsignedBigInteger('cabor_id')->nullable()->change();
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
            $table->dropColumn('bidang_id');
            $table->unsignedBigInteger('cabor_id')->change();
        });
    }
}
