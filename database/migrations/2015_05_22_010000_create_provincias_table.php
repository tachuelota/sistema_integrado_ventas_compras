<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProvinciasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ts_gen_prov', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('s_nom_prov',200)->nullable();
			$table->integer('id_dep')->unsigned();
			$table->foreign('id_dep')->references('id')->on('ts_gen_dep');
			$table->string('s_DetalleGenProv',150)->nullable();
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
		Schema::drop('ts_gen_prov');
	}

}
