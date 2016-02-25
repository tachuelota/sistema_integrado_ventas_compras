<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ts_productos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('id_TipoProducto')->unsigned();
			$table->foreign('id_TipoProducto')->references('id')->on('ts_tipoproductos');
			$table->string('s_ImgProducto',250)->nullable();
			$table->string('s_CodigoProducto',45)->nullable();
			$table->string('s_PlazoEntregaProducto',45)->nullable();
			$table->string('s_NombreProducto',200)->nullable();
			$table->double('n_PrecioMinProducto',11,2)->nullable();
			$table->double('n_PrecioMaxProducto',11,2)->nullable();
			$table->double('n_PrecioEspecialProducto',11,2)->nullable();
			$table->double('n_PrecioFabProducto',11,2)->nullable();
			$table->double('n_PrecioRemateProducto',11,2)->nullable();
			$table->char('s_ParaVentaProducto')->nullable();
			$table->char('s_ActivoProducto')->nullable();
			$table->string('s_RefInternaProducto',200)->nullable();
			$table->string('s_EstadoProducto',45)->nullable();
			$table->string('s_GarantiaProducto',45)->nullable();
			$table->string('s_DetalleProducto',150)->nullable();
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
		Schema::drop('ts_productos');
	}

}
