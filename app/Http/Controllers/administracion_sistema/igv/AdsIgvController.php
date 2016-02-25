<?php namespace App\Http\Controllers\administracion_sistema\igv;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Igv;

class AdsIgvController extends Controller {

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
		return view('administracion_sistema/igv/main');
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
		// SETEAR TODOS LOS IGV EXISTENTES A FALSE
		$array_igv = Igv::all();
		foreach ($array_igv as $key => $value) {
			$igv_modif = Igv::find($value->id);
			$igv_modif->estado = 'false';
			$igv_modif->save();
		}

		$nuevo = new Igv; // Preparamos un registro vacio para la tabla Local
		$nuevo->valor_igv = $request->get('valor_igv');
		$nuevo->estado = 'true';
		$nuevo->save();
       
        return \Response::json(array(
            'datos' => Igv::all()
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

		// SETEAR TODOS LOS IGV EXISTENTES A FALSE
		$array_igv = Igv::all();
		foreach ($array_igv as $key => $value) {
			$igv_modif = Igv::find($value->id);
			$igv_modif->estado = 'false';
			$igv_modif->save();
		}

		$nuevo = Igv::find($id);
		$nuevo->estado = 'true';
		$nuevo->save();
		
        return \Response::json(array(
            'datos' => Igv::all()
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
		//
		$guiasalida = Igv::find($id);
		$guiasalida -> delete();

        return \Response::json(array(
            'datos' => Igv::all()
        ));
	}

	/* Listar registros */
	public function getAll(){
        return \Response::json(array(
            'datos' => Igv::all()
        ));
	}

}
