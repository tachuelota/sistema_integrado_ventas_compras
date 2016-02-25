<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDistritosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ts_gen_dist', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('s_nom_dist',200)->nullable();
			$table->integer('id_prov')->unsigned();
			$table->foreign('id_prov')->references('id')->on('ts_gen_prov');
			$table->string('s_DetalleGenDist',150)->nullable();
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
		Schema::drop('ts_gen_dist');
	}

}
