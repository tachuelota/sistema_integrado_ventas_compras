<?php namespace App\Http\Controllers\administracion_sistema\cliente;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\ClienteDetalle;

use Illuminate\Support\Facades\DB;

class AdsClienteController extends Controller {

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
		return view('administracion_sistema/cliente/main');
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
		// $cliente_existente = Cliente::where('ruc',$request->get('ruc'))->get();
		$cliente_existente = DB::table('ts_cliente')->where('ruc', $request->get('ruc'))->pluck('id');

		if($cliente_existente == null){
			$agente_retenedor = $request->get('agente_retenedor');
			$cliente = new Cliente;
			$cliente->razon_social = $request->get('razon_social');
			$cliente->ruc = $request->get('ruc');
			if($agente_retenedor == null) $agente_retenedor = false;
			$cliente->agente_retenedor = json_encode($agente_retenedor);
			$cliente->save();

			$clienteDetalle_1 = new ClienteDetalle;
			$clienteDetalle_1->direccion_cliente = $request->get('direccion_principal');
			$clienteDetalle_1->id_indicadorDireccion = 1;
			$clienteDetalle_1->id_cliente = $cliente->id;
			$clienteDetalle_1->save();

			$clienteDetalle_2 = new ClienteDetalle;
			$clienteDetalle_2->direccion_cliente = $request->get('direccion_secundaria');
			$clienteDetalle_2->id_indicadorDireccion = 2;
			$clienteDetalle_2->id_cliente = $cliente->id;
			$clienteDetalle_2->save();

	        return \Response::json(array(
	            'datos' => DB::select('SELECT
										 	c.id
										 	, c.razon_social
										 	, c.ruc
											, (SELECT dc.id_cliente FROM ts_detallecliente dc WHERE dc.id_cliente = c.id AND dc.id_indicadorDireccion = 1) AS id_cliente
											, (SELECT dc.id FROM ts_detallecliente dc WHERE dc.id_cliente = c.id AND dc.id_indicadorDireccion = 1) AS id_direccion_principal
											, (SELECT dc.direccion_cliente FROM ts_detallecliente dc WHERE dc.id_cliente = c.id AND dc.id_indicadorDireccion = 1) AS direccion_principal
											, (SELECT dc.id FROM ts_detallecliente dc WHERE dc.id_cliente = c.id AND dc.id_indicadorDireccion = 2) AS id_direccion_secundaria
											, (SELECT dc.direccion_cliente FROM ts_detallecliente dc WHERE dc.id_cliente = c.id AND dc.id_indicadorDireccion = 2) AS direccion_secundaria
										 	, c.agente_retenedor
										FROM ts_cliente c
										WHERE c.deleted_at IS NULL')
	        ));
		}
		else{
			return \Response::json(array(
	            'datos' => 'existe'
	        ));
		}
		
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
		// $clienteDetalle = ClienteDetalle::where('id_cliente',$id)->get();
		// dd();

		$cliente = Cliente::find($id);
		$cliente->razon_social = $request->get('razon_social');
		$cliente->ruc = $request->get('ruc');
		$cliente->agente_retenedor = $request->get('agente_retenedor');
		$cliente->save();

		$clienteDetalle_1 = ClienteDetalle::find($request->get('id_direccion_principal'));
		$clienteDetalle_1->direccion_cliente = $request->get('direccion_principal');
		$clienteDetalle_1->id_indicadorDireccion = 1;
		$clienteDetalle_1->id_cliente = $cliente->id;
		$clienteDetalle_1->save();

		$clienteDetalle_2 = ClienteDetalle::find($request->get('id_direccion_secundaria'));
		$clienteDetalle_2->direccion_cliente = $request->get('direccion_secundaria');
		$clienteDetalle_2->id_indicadorDireccion = 2;
		$clienteDetalle_2->id_cliente = $cliente->id;
		$clienteDetalle_2->save();

        return \Response::json(array(
            'datos' => DB::select('SELECT
									 	c.id
									 	, c.razon_social
									 	, c.ruc
										, (SELECT dc.id_cliente FROM ts_detallecliente dc WHERE dc.id_cliente = c.id AND dc.id_indicadorDireccion = 1) AS id_cliente
										, (SELECT dc.id FROM ts_detallecliente dc WHERE dc.id_cliente = c.id AND dc.id_indicadorDireccion = 1) AS id_direccion_principal
										, (SELECT dc.direccion_cliente FROM ts_detallecliente dc WHERE dc.id_cliente = c.id AND dc.id_indicadorDireccion = 1) AS direccion_principal
										, (SELECT dc.id FROM ts_detallecliente dc WHERE dc.id_cliente = c.id AND dc.id_indicadorDireccion = 2) AS id_direccion_secundaria
										, (SELECT dc.direccion_cliente FROM ts_detallecliente dc WHERE dc.id_cliente = c.id AND dc.id_indicadorDireccion = 2) AS direccion_secundaria
									 	, c.agente_retenedor
									FROM ts_cliente c
									WHERE c.deleted_at IS NULL')
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
		
		$cliente = Cliente::find($id);
		$cliente -> delete();

        return \Response::json(array(
            'datos' => DB::select('SELECT
									 	c.id
									 	, c.razon_social
									 	, c.ruc
										, (SELECT dc.id_cliente FROM ts_detallecliente dc WHERE dc.id_cliente = c.id AND dc.id_indicadorDireccion = 1) AS id_cliente
										, (SELECT dc.id FROM ts_detallecliente dc WHERE dc.id_cliente = c.id AND dc.id_indicadorDireccion = 1) AS id_direccion_principal
										, (SELECT dc.direccion_cliente FROM ts_detallecliente dc WHERE dc.id_cliente = c.id AND dc.id_indicadorDireccion = 1) AS direccion_principal
										, (SELECT dc.id FROM ts_detallecliente dc WHERE dc.id_cliente = c.id AND dc.id_indicadorDireccion = 2) AS id_direccion_secundaria
										, (SELECT dc.direccion_cliente FROM ts_detallecliente dc WHERE dc.id_cliente = c.id AND dc.id_indicadorDireccion = 2) AS direccion_secundaria
									 	, c.agente_retenedor
									FROM ts_cliente c
									WHERE c.deleted_at IS NULL')
        ));
	}

	public function getAll(){
        // return \Response::json(array(
        //     'datos' => DB::table('ts_cliente')
        //     			->select(
        //     					'id'
        //     					, 'razon_social'
        //     					,'ruc'
        //     					, DB::table('ts_detallecliente')->select('direccion_cliente')->where('id_cliente','=','1')->where('id_indicadorDireccion','=','1')->get()
        //     					)->get()
        // ));

        return \Response::json(array(
            'datos' => DB::select('SELECT
									 	c.id
									 	, c.razon_social
									 	, c.ruc
										, (SELECT dc.id_cliente FROM ts_detallecliente dc WHERE dc.id_cliente = c.id AND dc.id_indicadorDireccion = 1) AS id_cliente
										, (SELECT dc.id FROM ts_detallecliente dc WHERE dc.id_cliente = c.id AND dc.id_indicadorDireccion = 1) AS id_direccion_principal
										, (SELECT dc.direccion_cliente FROM ts_detallecliente dc WHERE dc.id_cliente = c.id AND dc.id_indicadorDireccion = 1) AS direccion_principal
										, (SELECT dc.id FROM ts_detallecliente dc WHERE dc.id_cliente = c.id AND dc.id_indicadorDireccion = 2) AS id_direccion_secundaria
										, (SELECT dc.direccion_cliente FROM ts_detallecliente dc WHERE dc.id_cliente = c.id AND dc.id_indicadorDireccion = 2) AS direccion_secundaria
									 	, c.agente_retenedor
									FROM ts_cliente c
									WHERE c.deleted_at IS NULL')
        ));
	}

	public function getDirecFiscal(Request $request){
		$id_cliente = $request->get('id_cliente');
		
        return \Response::json(array(
            'datos' => DB::select('SELECT
									 	dc.id
									 	, dc.direccion_cliente
									 	, dc.id_indicadorDireccion
									 	, dc.id_cliente
									FROM ts_detallecliente dc
									WHERE dc.deleted_at IS NULL AND dc.id_indicadorDireccion = 1 AND dc.id_cliente ='.$id_cliente)
        ));
	}
}
