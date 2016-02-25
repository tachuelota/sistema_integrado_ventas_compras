<?php namespace App\Http\Middleware;

use Closure;
use App\User;
use Illuminate\Support\Facades\Session;

class check_user_status {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		
		if( User::find( Session::get('usuario')[0]->id )->s_DetalleUsuario == "false" ){
			return redirect('/auth/logout');
		}
		else{
			return $next($request);
		}

	}

}
