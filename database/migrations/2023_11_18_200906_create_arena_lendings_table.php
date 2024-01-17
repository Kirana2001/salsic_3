<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArenaLendingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arena_lendings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->date('application_date');
            $table->string('name');
            $table->string('nik');
            $table->string('phone');
            $table->string('email');
            $table->text('address');
            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedBigInteger('arena_id');
            $table->unsignedBigInteger('status_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('arena_lendings');
    }
}
