<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuariosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ts_usuarios', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('id_Personal')->unsigned();
			$table->foreign('id_Personal')->references('id')->on('ts_personal');
			$table->integer('id_PerfilUsuario')->unsigned();
			$table->foreign('id_PerfilUsuario')->references('id')->on('ts_perfilusuarios');
			$table->string('s_LoginUsuario',45)->nullable();
			$table->string('p_PasswordUsuario',150)->nullable();
			$table->rememberToken();
			$table->string('s_DetalleUsuario',150)->nullable();
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
		Schema::drop('ts_usuarios');
	}

}
