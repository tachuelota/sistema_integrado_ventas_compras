<?php namespace App\Http\Controllers\administracion_sistema\color;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Color;

class AdsColorController extends Controller {

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
		return view('administracion_sistema/color/main');
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
		$nuevo = new Color; // Preparamos un registro vacio para la tabla Local
		$nuevo->nombre_color = $request->get('nombre_color');
		$nuevo->save();
       
        return \Response::json(array(
            'datos' => Color::all()
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
		$nuevo = Color::find($id);
		$nuevo->nombre_color = $request->get('nombre_color');
		$nuevo->save();
		
        return \Response::json(array(
            'datos' => Color::all()
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
		$guiasalida = Color::find($id);
		$guiasalida -> delete();

        return \Response::json(array(
            'datos' => Color::all()
        ));
	}

	/* Listar registros */
	public function getAll(){
        return \Response::json(array(
            'datos' => Color::orderBy('ts_color.nombre_color')->get()
        ));
	}

}
