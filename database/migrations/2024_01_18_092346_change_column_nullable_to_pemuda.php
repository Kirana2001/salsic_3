<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnNullableToPemuda extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pemudas', function (Blueprint $table) {
            $table->string('village')->nullable()->change();
            $table->string('district')->nullable()->change();
            $table->string('subdistrict')->nullable()->change();
            $table->string('all_member')->nullable()->change();
            $table->string('male_member')->nullable()->change();
            $table->string('female_member')->nullable()->change();
            $table->string('document')->nullable()->change();
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
            $table->string('village')->change();
            $table->string('district')->change();
            $table->string('subdistrict')->change();
            $table->string('all_member')->change();
            $table->string('male_member')->change();
            $table->string('female_member')->change();
            $table->string('document')->change();
        });
    }
}
