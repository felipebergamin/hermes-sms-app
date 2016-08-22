<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListaBrancaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lista_branca', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descricao', 40);
            $table->enum('tipo', ['cpf', 'cnpj', 'celular']);
            $table->string('valor', 14);
            $table->integer('created_at')->unsigned();
            $table->integer('updated_at')->unsigned();
            $table->integer('usuario_id')->unsigned();

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
        Schema::drop('lista_branca');
    }
}
