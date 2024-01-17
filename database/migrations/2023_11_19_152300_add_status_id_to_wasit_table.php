<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusIdToWasitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wasit', function (Blueprint $table) {
            $table->unsignedBigInteger('status_id')->nullable()->after('cabor_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wasit', function (Blueprint $table) {
            $table->dropColumn('status_id');
        });
    }
}
