<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnNullableToPemudas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pemudas', function (Blueprint $table) {
            $table->string('founding_date')->nullable()->change();
            $table->string('nik')->nullable()->change();
            $table->string('city')->nullable()->change();
            $table->string('province')->nullable()->change();
            $table->string('image')->nullable()->change();
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
            $table->string('founding_date')->change();
            $table->string('nik')->change();
            $table->string('city')->change();
            $table->string('province')->change();
            $table->string('image')->change();
        });
    }
}
