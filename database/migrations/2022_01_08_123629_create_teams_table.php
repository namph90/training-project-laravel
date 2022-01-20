<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->increments('id', 11);
            $table->string('name', 128);
            $table->char('del_flag', 1)->default('0');
            $table->integer('ins_id')->length(11);
            $table->integer('upd_id')->length(11)->nullable();
            $table->dateTime('ins_datetime');
            $table->dateTime('upd_datetime')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teams');
    }
}
