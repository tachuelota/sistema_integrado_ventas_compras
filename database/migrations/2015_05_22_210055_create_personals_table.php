<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonalsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ts_personal', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('id_TipoPersonal')->unsigned();
			$table->foreign('id_TipoPersonal')->references('id')->on('ts_tipopersonal');
			$table->integer('id_dist')->unsigned();
			$table->foreign('id_dist')->references('id')->on('ts_gen_dist');
			$table->string('s_ApellidoPatPersonal',150)->nullable();
			$table->string('s_ApellidoMatPersonal',150)->nullable();
			$table->string('s_NombresPersonal',255)->nullable();
			$table->string('s_DireccionPersonal',255)->nullable();
			$table->string('s_DetallePersonal',150)->nullable();
			$table->string('s_TelfFijoPersonal',255)->nullable();
			$table->string('s_TelfMovilPersonal',50)->nullable();
			$table->string('s_EmailPerPersonal',100)->nullable();
			$table->string('s_EmailInstPersonal',100)->nullable();
			$table->string('s_RutaFotoPersonal',150)->nullable();
			$table->string('s_ObsPersonal',150)->nullable();
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
		Schema::drop('ts_personal');
	}

}
