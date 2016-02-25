<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerfilMenusTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ts_perfilmenu', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('id_Menu')->unsigned();
			$table->foreign('id_Menu')->references('id')->on('ts_menusistema');
			$table->string('s_LineaPrinc',255)->nullable();
			$table->string('s_DetalleUsuarioMenu',150)->nullable();
			$table->integer('id_PerfilUsuario')->unsigned();
			$table->foreign('id_PerfilUsuario')->references('id')->on('ts_perfilusuarios');
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
		Schema::drop('ts_perfilmenu');
	}

}
