<?php namespace App\Http\Controllers\administracion_sistema\transporte;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Transporte;

class AdsTransporteController extends Controller {

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
		return view('administracion_sistema/transporte/main');

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
		//
		$nuevo = new Transporte;//Preparamos un registro vacio para la tabla Local
		$nuevo->razon_social = $request->get('razon_social');
		$nuevo->ruc = $request->get('ruc');
		$nuevo->save();

        return \Response::json(array(
            'datos' => Transporte::all()
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
		//
		$nuevo = Transporte::find($id);
		$nuevo->razon_social = $request->get('razon_social');
		$nuevo->ruc = $request->get('ruc');
		$nuevo->save();
		
        return \Response::json(array(
            'datos' => Transporte::all()
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
		$guiasalida = Transporte::find($id);
		$guiasalida -> delete();

        return \Response::json(array(
            'datos' => Transporte::all()
        ));
	}

	public function getAll(){
        return \Response::json(array(
            'datos' => Transporte::orderBy('ts_transporte.razon_social')->get()
        ));
	}
}
