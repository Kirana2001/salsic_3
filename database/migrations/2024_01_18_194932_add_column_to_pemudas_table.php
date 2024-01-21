<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToPemudasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pemudas', function (Blueprint $table) {
            $table->string('secretary')->default(null)->after('leader');
            $table->string('treasurer')->default(null)->after('secretary');
            $table->string('description')->default(null)->after('address');
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
            $table->dropColumn('secretary');
            $table->dropColumn('treasurer');
            $table->dropColumn('description');
        });
    }
}
