<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms', function (Blueprint $table) {
            $table->increments('id');

            $table->string('descricao_destinatario');
            $table->string('texto', 160);
            $table->string('numero_destinatario', 11);
            $table->integer('usuario_id')->unsigned();
            $table->integer('lote_sms_id')->unsigned()->nullable();

            $table->integer('created_at')->unsigned();
            $table->integer('updated_at')->unsigned();

            $table->foreign('usuario_id')->references('id')->on('users');
            $table->foreign('lote_sms_id')->references('id')->on('lote_sms');

            $table->index('descricao_destinatario');
            $table->index('texto');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sms');
    }
}
