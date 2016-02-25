<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocalsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ts_locales', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('id_TipoLocal')->unsigned();
			$table->foreign('id_TipoLocal')->references('id')->on('ts_tipo_locales');
			$table->string('s_DireccionLocal',150)->nullable();
			$table->string('s_AliasLocal',45)->nullable();
		    $table->integer('id_dist')->unsigned();
		    $table->foreign('id_dist')->references('id')->on('ts_gen_dist');
			$table->string('s_DetalleLocale',150)->nullable();
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
		Schema::drop('ts_locales');
	}
}
