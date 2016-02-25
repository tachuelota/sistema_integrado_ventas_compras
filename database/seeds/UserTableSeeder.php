<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder{

	public function run()
	{
		\DB::table('ts_usuarios')->insert(array(
			'id_Personal'	=> 3,
			'id_PerfilUSuario'	=> 4,
			's_LoginUSuario'	=> 'ecuadrao',
			'p_PasswordUsuario' => \Hash::make('ecuadrao')
		));
	}
}