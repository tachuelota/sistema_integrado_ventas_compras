<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoPersonalsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ts_tipopersonal', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('s_DescTipoPersonal',255)->nullable();
			$table->string('s_DetalleTipoPersonal',100)->nullable();
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
		Schema::drop('ts_tipopersonal');
	}

}
