<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnderecosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enderecos', function (Blueprint $table) {
			$table->engine = 'InnoDB';
            $table->increments('id');
			$table->string('rua', 255);
			$table->string('numero', 255);
			$table->string('cidade', 255);
			$table->string('estado', 255);
			$table->string('pais', 255);
			$table->integer('cliente_id')->unsigned();
			$table->foreign('cliente_id')
				->references('id')
				->on('clientes')
				->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enderecos');
    }
}
