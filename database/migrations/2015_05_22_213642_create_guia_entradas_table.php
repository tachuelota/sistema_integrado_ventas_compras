<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuiaEntradasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ts_guiaentradas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('n_idTipoLocalOrigen')->nullable();
			$table->integer('n_idTipoLocalDestino')->nullable();
			$table->date('d_FechaGuiaEntrada')->nullable();
			$table->string('s_DetDetalleGuiaEntrada')->nullable();
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
		Schema::drop('ts_guiaentradas');
	}

}
