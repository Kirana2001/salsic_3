<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToPelatihTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pelatih', function (Blueprint $table) {
            $table->string('no_kk')->after('image');
            $table->string('gender')->after('no_kk');
            $table->string('province')->after('gender');
            $table->string('city')->after('province');
            $table->string('school')->after('city');
            $table->string('email')->after('school');
            $table->string('no_rek')->after('email');
            $table->string('bank')->after('no_rek');
            $table->string('lini')->after('bank');
            $table->string('klasifikasi')->after('lini');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pelatih', function (Blueprint $table) {
            $table->dropColumn('no_kk');
            $table->dropColumn('gender');
            $table->dropColumn('province');
            $table->dropColumn('city');
            $table->dropColumn('school');
            $table->dropColumn('email');
            $table->dropColumn('no_rek');
            $table->dropColumn('bank');
            $table->dropColumn('lini');
            $table->dropColumn('klasifikasi');
        });
    }
}
