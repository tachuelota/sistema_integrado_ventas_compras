<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVentaCabecerasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ts_ventascabecera', function(Blueprint $table)
		{
			$table->increments('id');
			$table->date('d_FechaVenta')->nullable();
			$table->date('d_HoraVenta')->nullable();
			$table->integer('id_Usuario')->unsigned();
			$table->foreign('id_Usuario')->references('id')->on('ts_usuarios');
			$table->integer('id_Cliente')->unsigned();
			$table->foreign('id_Cliente')->references('id')->on('ts_clientes');
			$table->integer('id_Local')->unsigned();
			$table->foreign('id_Local')->references('id')->on('ts_locales');
			$table->string('s_DetalleVentaCabecera',150)->nullable();
			$table->integer('n_venta_por_mayor')->unsigned();
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
		Schema::drop('ts_ventascabecera');
	}

}
