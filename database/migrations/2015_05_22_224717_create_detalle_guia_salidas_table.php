<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalleGuiaSalidasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ts_detalleguiasalida', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('id_GuiaSalida')->unsigned();
			$table->foreign('id_GuiaSalida')->references('id')->on('ts_guiasalidas');
			$table->integer('ts_Productos_id_Producto')->unsigned();
			$table->foreign('ts_Productos_id_Producto')->references('id')->on('ts_productos');
			$table->integer('n_CantProducto')->nullable();
			$table->integer('id_UnidadMedida')->unsigned();
			$table->foreign('id_UnidadMedida')->references('id')->on('ts_unidadesmedida');
			$table->string('s_DetDetalleGuiaSalida',150)->nullable();
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
		Schema::drop('ts_detalleguiasalida');
	}

}
