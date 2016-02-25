<?php namespace App\Http\Controllers\administracion_sistema\personal_transporte;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\PersonalTransporte;

class AdsPersonalTransporteController extends Controller {

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
		return view('administracion_sistema/personal_transporte/main');
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
		$nuevo = new PersonalTransporte; // Preparamos un registro vacio para la tabla Local
		$nuevo->nombre_personal = $request->get('nombre_personal');
		$nuevo->licencia_personal = $request->get('licencia_personal');
		$nuevo->id_transporte = $request->get('transporte')['id'];
		$nuevo->save();
       
        return \Response::json(array(
            'datos' => PersonalTransporte::with(['Transporte'])->get()
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
		$nuevo = PersonalTransporte::find($id);
		$nuevo->nombre_personal = $request->get('nombre_personal');
		$nuevo->licencia_personal = $request->get('licencia_personal');
		$nuevo->id_transporte = $request->get('transporte')['id'];
		/* $nuevo->id_transporte = $request->get('id_transporte'); */
		$nuevo->save();
		
        return \Response::json(array(
            'datos' => PersonalTransporte::with(['Transporte'])->get()
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
		$guiasalida = PersonalTransporte::find($id);
		$guiasalida -> delete();

        return \Response::json(array(
            'datos' => PersonalTransporte::with(['Transporte'])->get()
        ));
	}


	public function getAll(){
        return \Response::json(array(
            'datos' => PersonalTransporte::with(['Transporte'])->get()
        ));
	}
	
	public function getAllByEmpresa($id_empresa){
        return \Response::json(array(
            'datos' => PersonalTransporte::where('id_transporte','=',$id_empresa)->get()
        ));
	}

}
