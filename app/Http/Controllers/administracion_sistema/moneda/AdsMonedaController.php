<?php namespace App\Http\Controllers\administracion_sistema\moneda;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Moneda;

class AdsMonedaController extends Controller {

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
		return view('administracion_sistema/moneda/main');
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
		$nuevo = new Moneda; /* Preparamos un registro vacio para la tabla Local */
		$nuevo->nombre_moneda = $request->get('nombre_moneda');
		$nuevo->save();

        return \Response::json(array(
            'datos' => Moneda::all() /* Sin modal */
            /* 'datos' => Comprobante::with(['Transporte'])->get() */
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
		$nuevo = Moneda::find($id);
		$nuevo->nombre_moneda = $request->get('nombre_moneda');
		$nuevo->save();
		
        return \Response::json(array(
            'datos' => Moneda::all() /* Para el combo se cambia a : */
            /* 'datos' => Comprobante::with(['Transporte'])->get() */
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
		$guiasalida = Moneda::find($id);
		$guiasalida -> delete();

        return \Response::json(array(
            'datos' => Moneda::all()
            /* 'datos' => Moneda::with(['Transporte'])->get() */
        ));
	}

	public function getAll(){
        return \Response::json(array(
            'datos' => Moneda::all()
            /* 'datos' => Comprobante::with(['Transporte'])->get() */
        ));
	}
}
