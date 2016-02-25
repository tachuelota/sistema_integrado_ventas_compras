<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartamentosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ts_gen_dep', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('s_nom_dep',200)->nullable();
			$table->string('s_zona',100)->nullable();
			$table->string('s_DetalleGenDep',150)->nullable();
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
		Schema::drop('ts_gen_dep');
	}

}
