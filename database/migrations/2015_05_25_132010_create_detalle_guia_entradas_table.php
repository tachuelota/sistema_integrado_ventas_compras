<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalleGuiaEntradasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ts_detalleguiaentrada', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('id_GuiaEntrada')->unsigned();
			$table->foreign('id_GuiaEntrada')->references('id')->on('ts_guiaentradas');
			$table->integer('id_Producto')->unsigned();
			$table->foreign('id_Producto')->references('id')->on('ts_productos');
			$table->integer('n_CantProducto')->nullable();
			$table->string('ts_DetalleGuiaEntrada',45)->nullable();
			$table->integer('id_UnidadMedida')->unsigned();
			$table->foreign('id_UnidadMedida')->references('id')->on('ts_unidadesmedida');
			$table->string('s_DetalleDetGuiaEntrada',150)->nullable();
			$table->integer('n_CodUsuCrea')->nullable();
			$table->integer('n_CodUsuUltMod')->nullable();
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
		Schema::drop('ts_detalleguiaentrada');
	}

}
