<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoteSmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lote_sms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descricao', 50);
            $table->integer('usuario_id')->unsigned();

            $table->integer('created_at')->unsigned();
            $table->integer('updated_at')->unsigned();

            $table->foreign('usuario_id')->references('id')->on('users');

            $table->index('descricao');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('lote_sms');
    }
}
