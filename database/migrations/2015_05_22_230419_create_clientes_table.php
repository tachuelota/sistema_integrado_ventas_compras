<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ts_clientes', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('id_TipoCliente')->unsigned();
			$table->foreign('id_TipoCliente')->references('id')->on('ts_tipoclientes');
			$table->string('s_DirCliente',150)->nullable();
			$table->string('s_RucCliente',16)->nullable();
			$table->string('s_RazonSocialCliente',155)->nullable();
			$table->string('s_NombreCliente',150)->nullable();
			$table->string('s_ApePatCliente',150)->nullable();
			$table->string('s_ApeMatCliente',150)->nullable();
			$table->string('s_ContactoCliente',180)->nullable();
			$table->string('s_TelefonoCliente',45)->nullable();
			$table->string('s_TelefonoContactoCliente',45)->nullable();
			$table->string('s_EmailCliente',150)->nullable();
			$table->string('s_EmailContactoCliente',150)->nullable();
			$table->integer('id_dist')->unsigned();
			$table->foreign('id_dist')->references('id')->on('ts_gen_dist');
			$table->string('s_DetalleCliente',150)->nullable();
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
		Schema::drop('ts_clientes');
	}

}
