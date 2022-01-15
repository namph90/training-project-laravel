<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id',11);
            $table->integer('team_id')->length(11);
            $table->string('email', 128);
            $table->string('password', 64);
            $table->string('first_name', 128);
            $table->string('last_name', 128);
            $table->char('gerder', 1);
            $table->date('birthday');
            $table->string('address', 256);
            $table->string('avatar', 128);
            $table->integer('salary')->length(11);
            $table->char('position', 1);
            $table->char('status', 1);
            $table->char('type_of_work', 1);
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
        Schema::dropIfExists('employees');
    }
}
