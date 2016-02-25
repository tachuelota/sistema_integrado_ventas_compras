<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVentaDetallesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ts_ventasdetalle', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('id_VtaCab')->unsigned();
			$table->foreign('id_VtaCab')->references('id')->on('ts_VentasCabecera');
			$table->integer('id_Producto')->unsigned();
			$table->foreign('id_Producto')->references('id')->on('ts_productos');
			$table->integer('n_CantProducto')->nullable();
			$table->double('n_PrecioUnitarioVentaProducto',11,2)->nullable();
			$table->integer('id_UnidadMedida')->unsigned();
			$table->foreign('id_UnidadMedida')->references('id')->on('ts_unidadesmedida');
			$table->string('s_DetalleVentasDetalle',150)->nullable();
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
		Schema::drop('ts_ventasdetalle');
	}

}
