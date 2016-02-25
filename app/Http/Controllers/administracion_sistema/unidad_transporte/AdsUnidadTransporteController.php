<?php namespace App\Http\Controllers\administracion_sistema\unidad_transporte;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\UnidadTransporte;

class AdsUnidadTransporteController extends Controller {

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
		return view('administracion_sistema/unidad_transporte/main');
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
		// dd($request);
		$nuevo = new UnidadTransporte;//Preparamos un registro vacio para la tabla Local
		$nuevo->marca = $request->get('marca');
		$nuevo->placa = $request->get('placa');
		$nuevo->ci_mtc = $request->get('ci_mtc');
		$nuevo->id_transporte = $request->get('transporte')['id'];
		$nuevo->save();

        return \Response::json(array(
            /* 'datos' => UnidadTransporte::all() */ /* Sin modal */
            'datos' => UnidadTransporte::with(['Transporte'])->get()
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

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$nuevo = UnidadTransporte::find($id);
		$nuevo->marca = $request->get('marca');
		$nuevo->placa = $request->get('placa');
		$nuevo->ci_mtc = $request->get('ci_mtc');
		$nuevo->id_transporte = $request->get('transporte')['id'];
		/* $nuevo->id_transporte = $request->get('id_transporte'); */
		$nuevo->save();
		
        return \Response::json(array(
            /* 'datos' => UnidadTransporte::all() */ /* Para el combo se cambia a : */
            'datos' => UnidadTransporte::with(['Transporte'])->get()
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
		$guiasalida = UnidadTransporte::find($id);
		$guiasalida -> delete();

        return \Response::json(array(
            'datos' => UnidadTransporte::with(['Transporte'])->get()
        ));
	}

	public function getAll(){
        return \Response::json(array(
            'datos' => UnidadTransporte::with(['Transporte'])->orderBy('ts_unidadtransporte.marca')->get()
        ));
	}
	public function getAllByEmpresa($id_empresa){
        return \Response::json(array(
            'datos' => UnidadTransporte::where('id_transporte','=',$id_empresa)->orderBy('ts_unidadtransporte.marca')->get()
        ));
	}
}
