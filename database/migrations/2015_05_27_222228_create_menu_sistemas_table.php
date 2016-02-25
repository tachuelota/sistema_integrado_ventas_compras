<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuSistemasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ts_menusistema', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('n_MenuParent')->nullable();
			$table->string('v_NombreMenu',255)->nullable();
			$table->string('v_LineaControlMenu',255)->nullable();
			$table->integer('n_OrdenMenu')->nullable();
			$table->string('s_IconoMenu',25)->nullable();
			$table->string('s_DetalleMenuSistema',250)->nullable();
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
		Schema::drop('ts_menusistema');
	}

}
