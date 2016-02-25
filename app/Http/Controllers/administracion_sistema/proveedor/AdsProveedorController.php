<?php namespace App\Http\Controllers\administracion_sistema\proveedor;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Proveedor;

class AdsProveedorController extends Controller {

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
		return view('administracion_sistema/proveedor/main');
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
		$nuevo = new Proveedor; /* Preparamos un registro vacio para la tabla Local */
		$nuevo->razon_social = $request->get('razon_social');
		$nuevo->ruc = $request->get('ruc');
		$nuevo->direccion = $request->get('direccion');
		$nuevo->telefono = $request->get('telefono');
		$nuevo->email = $request->get('email');
		$nuevo->save();

        return \Response::json(array(
            'datos' => Proveedor::all() /* Sin modal */
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
		$nuevo = Proveedor::find($id);
		$nuevo->razon_social = $request->get('razon_social');
		$nuevo->ruc = $request->get('ruc');
		$nuevo->direccion = $request->get('direccion');
		$nuevo->telefono = $request->get('telefono');
		$nuevo->email = $request->get('email');
		$nuevo->save();
		
        return \Response::json(array(
            'datos' => Proveedor::all() /* Para el combo se cambia a : */
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
		$guiasalida = Proveedor::find($id);
		$guiasalida -> delete();

        return \Response::json(array(
            'datos' => Proveedor::all()
            /* 'datos' => Proveedor::with(['Transporte'])->get() */
        ));
	}

	public function getAll(){
        return \Response::json(array(
            'datos' => Proveedor::orderBy('ts_proveedor.razon_social')->get()
        ));
	}

	public function getDirecFiscal(Request $request){
		$id_proveedor = $request->get('id_proveedor');
		
        return \Response::json(array(
            'datos' => Proveedor::find($id_proveedor)
        ));
	}
}
