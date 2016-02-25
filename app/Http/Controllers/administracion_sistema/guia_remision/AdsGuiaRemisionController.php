<?php namespace App\Http\Controllers\administracion_sistema\guia_remision;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\GuiaRemision;
use App\Models\GuiaRemisionDetalle;
use App\Models\ComprobanteVenta;
use App\Models\Producto;
use App\Models\Kardex;

use Illuminate\Support\Facades\DB;

class AdsGuiaRemisionController extends Controller {

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
		return view('administracion_sistema/guia_remision/main');
	}


	public function main_compra()
	{
		return view('administracion_sistema/guia_remision/main_compra');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('administracion_sistema/guia_remision/create_guiaRemision');
	}

	public function create_compra()
	{
		return view('administracion_sistema/guia_remision/create_guiaRemision_compra');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		// dd($request->get('detalle'));
		$cabecera = $request->get('cabecera');
		$id_tipo_comprobante = $request->get('compra_venta');
		try {
			DB::beginTransaction();



			$filtro_existencia = '';
			// FILTRO --- EXISTE OTRO COMPROBANTE CON LA MISMA SERIE, NUMERO, CLIENTE Y FECHA
			if(DB::table('ts_guiaremision')
					->where('serie_guiaRemision', $cabecera['serie'])
					->where('numero_guiaRemision', $cabecera['numero'])
					->where('id_tipoComprobante', $id_tipo_comprobante)
					// ->where('id_cliente', $cabecera['cliente']['id_cliente_seleccionado'])
		            ->join('ts_detallecliente', 'ts_detallecliente.id', '=', 'ts_guiaremision.id_detalle_cliente')
					->pluck('ts_guiaremision.id') != null)
			{
				$filtro_existencia = 'EXISTE';
			}
			// FIN FILTRO --- EXISTE OTRO COMPROBANTE CON LA MISMA SERIE, NUMERO, CLIENTE Y FECHA

			if($filtro_existencia=='EXISTE')
			{ // EXISTE COMPROBANTE DE VENTA, NO GUARDAMOS NADA

				return \Response::json(array(
						'datos' => 'duplicidad'
					));	
			}
			else
			{ //SE EJECUTA NORMALMENTE PORQUE NO EXISTE COMPROBANTE DE VENTA
				if($cabecera['boolean_asociar'] == true){ // CUANDO SE ASOCIA CON UNA FACTURA DE VENTA
					$nuevaCabecera = new GuiaRemision;
					$nuevaCabecera->id_tipoComprobante = $id_tipo_comprobante;
					$nuevaCabecera->serie_guiaRemision = $cabecera['serie'];
					$nuevaCabecera->numero_guiaRemision = $cabecera['numero'];
					$nuevaCabecera->fecha_traslado = $cabecera['fecha'];
					$nuevaCabecera->punto_partida = strtoupper($cabecera['punto_partida']);
					if($id_tipo_comprobante == 3){ //SI ES GUIA REMISION - VENTA
						$nuevaCabecera->id_detalle_cliente = $cabecera['cliente']['id_direccion_seleccionada'];
					}
					else if($id_tipo_comprobante == 4){ //SI ES GUIA REMISION - COMPRA
						$nuevaCabecera->id_proveedor = $cabecera['proveedor']['id'];
					}
					$nuevaCabecera->id_motivoTraslado = $cabecera['motivo']['id'];
					$nuevaCabecera->id_personalTransporte = $cabecera['personal_transporte']['id'];
					$nuevaCabecera->id_unidad_Transporte = $cabecera['unidad_transporte']['id'];
					$nuevaCabecera->id_comprobanteVenta = $cabecera['id_comprobanteVenta'];
					$nuevaCabecera->save();
					$id_cabecera = $nuevaCabecera->id;

					$guiaRemision = ComprobanteVenta::find($cabecera['id_comprobanteVenta']);
					$guiaRemision->id_guiaRemision = $id_cabecera;
					$guiaRemision->save();

					$detalle = $request->get('detalle');

					foreach ($detalle as $key => $value) {

						$nuevaDetalle = new GuiaRemisionDetalle;
						$nuevaDetalle->id_guiaRemision = $id_cabecera;
						$nuevaDetalle->id_producto = $value['id_producto'];
						$nuevaDetalle->unidades = $value['unidades'];
						$nuevaDetalle->peso = $value['peso'];
						$nuevaDetalle->save();
					}

				}
				else { //STORE NORMAL
					$nuevaCabecera = new GuiaRemision;
					$nuevaCabecera->id_tipoComprobante = $id_tipo_comprobante;
					$nuevaCabecera->serie_guiaRemision = $cabecera['serie'];
					$nuevaCabecera->numero_guiaRemision = $cabecera['numero'];
					$nuevaCabecera->fecha_traslado = $cabecera['fecha'];
					$nuevaCabecera->punto_partida = strtoupper($cabecera['punto_partida']);
					$nuevaCabecera->punto_llegada = strtoupper($cabecera['punto_llegada']);
					if($id_tipo_comprobante == 3){ //SI ES GUIA REMISION - VENTA
						$nuevaCabecera->id_detalle_cliente = $cabecera['cliente']['id_direccion_seleccionada'];
					}
					else if($id_tipo_comprobante == 4){ //SI ES GUIA REMISION - COMPRA
						$nuevaCabecera->id_proveedor = $cabecera['proveedor']['id'];
					}
					$nuevaCabecera->id_motivoTraslado = $cabecera['motivo']['id'];

					// dd($cabecera['personal_transporte']['id']);
					// if($cabecera['personal_transporte']['id']=='undefined'){
						// $nuevaCabecera->id_personalTransporte = $cabecera['personal_transporte']['id'];
						// $nuevaCabecera->id_unidad_Transporte = $cabecera['unidad_transporte']['id'];
					// }
					$nuevaCabecera->id_personalTransporte = $cabecera['personal_transporte']['id'];
					$nuevaCabecera->id_unidad_Transporte = $cabecera['unidad_transporte']['id'];
					$nuevaCabecera->save();
					$id_cabecera = $nuevaCabecera->id;

					$detalle = $request->get('detalle');

					foreach ($detalle as $key => $value) {

						$nuevaDetalle = new GuiaRemisionDetalle;
						$nuevaDetalle->id_guiaRemision = $id_cabecera;
						$nuevaDetalle->id_producto = $value['id_producto'];
						$nuevaDetalle->unidades = $value['cantidad'];
						$nuevaDetalle->peso = $value['peso'];
						$nuevaDetalle->save();

						if($id_tipo_comprobante == 4){ //SI ES GUIA REMISION - COMPRA

							$kardex = new Kardex;
							$kardex->id_comprobante = $id_cabecera;
							$kardex->tipo_comprobante = 'GUIA REMISION COMPRA';
							$kardex->abreviatura_tipo_documento = 'GR';
							$kardex->serie_comprobante = $cabecera['serie'];
							$kardex->numero_comprobante = $cabecera['numero'];
							$kardex->id_producto = $value['id_producto'];
							$kardex->cantidad_movimiento = $value['peso'];
							$kardex->precio_unitario_movimiento = null;
							$kardex->fecha_registro = $cabecera['fecha'];
							$kardex->tipo_movimiento = 'ENTRADA';
							$kardex->save();
						}
					}
				}
				

				DB::commit();

				return \Response::json(array(
						'datos' => 'correcto'
					));	
			}

		} catch (Exception $e) {
			DB::rollBack();
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
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
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
	}

	public function getRowBySerieNumero(Request $request){
		// dd($request->get('guia'));
		if($request->get('guia')['compra_venta'] == 'VENTA'){
			return \Response::json(array(
	            'datos' => GuiaRemision::with(['GuiaRemisionDetalle.Producto','ClienteDetalle.Cliente','Igv'])->where('ts_guiaremision.id_tipoComprobante',3)->where('ts_guiaremision.serie_guiaRemision','=',$request->get('guia')['serie'])->where('ts_guiaremision.numero_guiaRemision','=',$request->get('guia')['numero'])->get()
	        ));
			
		}else if($request->get('guia')['compra_venta'] == 'COMPRA'){
	        return \Response::json(array(
	            'datos' => GuiaRemision::with(['GuiaRemisionDetalle.Producto','Proveedor','Igv'])->where('ts_guiaremision.id_tipoComprobante',4)->where('ts_guiaremision.serie_guiaRemision','=',$request->get('guia')['serie'])->where('ts_guiaremision.numero_guiaRemision','=',$request->get('guia')['numero'])->get()
	        ));

		}

	}

	public function getAllVenta(){
		return \Response::json(array(
            'datos' => GuiaRemision::with(['GuiaRemisionDetalle.Producto','ClienteDetalle.Cliente','Igv'])->where('ts_guiaremision.id_tipoComprobante',3)->get()
        ));

	}

	public function getAllCompra(){
		return \Response::json(array(
            'datos' => GuiaRemision::with(['GuiaRemisionDetalle.Producto','Proveedor','Igv'])->where('ts_guiaremision.id_tipoComprobante',4)->get()
        ));

	}

	public function getAllPartida(){

        return \Response::json(array(
            'datos' => GuiaRemision::groupBy('punto_partida')->get()
        ));;

	}

	public function getAllLlegada(){

        return \Response::json(array(
            'datos' => GuiaRemision::groupBy('punto_llegada')->get()
        ));;

	}

}
