<?php namespace App\Http\Controllers\administracion_sistema\tipo_cambio_moneda;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\TipoCambioMoneda;

use Illuminate\Support\Facades\DB;

class AdsTipoCambioController extends Controller {

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
		return view('administracion_sistema/tipo_cambio_moneda/main');
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
		$fecha;

		$nuevo = new TipoCambioMoneda; // Preparamos un registro vacio para la tabla Local
		$nuevo->id_moneda = 2;

		if($request->get('fecha') == 'HOY'){
			$fecha = date("Y-m-d");
		}
		else{
			$fecha = $request->get('fecha');
		}

		$nuevo->fecha = $fecha;
		$nuevo->valor_compra = $request->get('valor_compra');
		$nuevo->valor_venta = $request->get('valor_venta');
		$nuevo->save();
       
        return \Response::json(array(
            'datos' => TipoCambioMoneda::all()
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
		// $nuevo = TipoCambioMoneda::find($id);
		// $nuevo->id_moneda = 2;
		// $nuevo->fecha = date("Y-m-d");
		// $nuevo->valor_compra = $request->get('valor_compra');
		// $nuevo->valor_venta = $request->get('valor_venta');
		// $nuevo->save();
       
  //       return \Response::json(array(
  //           'datos' => TipoCambioMoneda::all()
  //       ));
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
		$guiasalida = TipoCambioMoneda::find($id);
		$guiasalida -> delete();

        return \Response::json(array(
            'datos' => TipoCambioMoneda::all()
        ));
	}

	/* Listar registros */
	public function getAll(){
        return \Response::json(array(
            'datos' => TipoCambioMoneda::all()
        ));
	}

	/* Listar registros */
	public function getRowTipoCambioToday(){
        return \Response::json(array(
            'datos' => DB::table('ts_tipocambiomoneda')->where('fecha', date("Y-m-d"))->pluck('valor_venta')
        ));
	}
}