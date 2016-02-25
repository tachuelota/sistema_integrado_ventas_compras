<?php namespace App\Http\Controllers\administracion_sistema\motivo_traslado;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\MotivoTraslado;

class AdsMotivoTrasladoController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	public function __construct()
	{
		$this->middleware('auth');
	}
	
	public function index()
	{
		return view('administracion_sistema/motivo_traslado/main');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	* Store a newly created resource in storage.
	*
	* @return Response
	*/

	public function store(Request $request)
	{
		$nuevo = new MotivoTraslado; // Preparamos un registro vacio para la tabla Local
		$nuevo->nombre_motivoTraslado = $request->get('nombre_motivoTraslado');
		$nuevo->save();
       
        return \Response::json(array(
            'datos' => MotivoTraslado::all()
        ));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$nuevo = MotivoTraslado::find($id);
		$nuevo->nombre_motivoTraslado = $request->get('nombre_motivoTraslado');
		$nuevo->save();
		
        return \Response::json(array(
            'datos' => MotivoTraslado::all()
        ));	
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$guiasalida = MotivoTraslado::find($id);
		$guiasalida -> delete();

        return \Response::json(array(
            'datos' => MotivoTraslado::all()
        ));
	}

	/* Listar registros */
	public function getAll(){
        return \Response::json(array(
            'datos' => MotivoTraslado::all() /* El nombre "MotivoTraslado" corresponde al nombre del modelo */
        ));
	}

}
