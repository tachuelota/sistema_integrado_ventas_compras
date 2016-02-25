<?php namespace App\Http\Controllers\administracion_sistema\comprobante_venta;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\ComprobanteVenta;
use App\Models\ComprobanteDetalleVenta;
use App\Models\GuiaRemision;
use App\Models\GuiaRemisionDetalle;
use App\Models\Producto;
use App\Models\DetallePago;
use App\Models\Nota;
use App\Models\DetalleNota;
use App\Models\RelacionLetras;
use App\Models\RelacionNotas;
use App\Models\KardexProducto;
use App\Models\Kardex;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class AdsComprobanteVentaController extends Controller {

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
		return view('administracion_sistema/comprobante_venta/main');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$tipo_cambio = DB::table('ts_tipocambiomoneda')->where('fecha', date("Y-m-d"))->pluck('valor_venta');
		if($tipo_cambio == null){
			return redirect('AdsTipoCambioMoneda');	
		}
		return view('administracion_sistema/comprobante_venta/create_comprobanteVenta');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		$cabecera = $request->get('cabecera');
		$cabecera_guia = $request->get('cabecera_guia');
		$tipo_cambio_compra_fecha_seleccionada = DB::table('ts_tipocambiomoneda')->where('fecha', date("Y-m-d",strtotime($cabecera['fecha'])))->pluck('valor_venta');
		$id_igv = DB::table('ts_igv')->where('estado', 'true')->pluck('id');
		$incluido_igv_activo = DB::table('ts_igv')->where('estado', 'true')->pluck('valor_igv');

		// DB::transaction(function(){
		try {
			DB::beginTransaction();



			$filtro_existencia = '';
			$filtro_existencia_nota = '';
			// FILTRO --- EXISTE OTRO COMPROBANTE CON LA MISMA SERIE, NUMERO, CLIENTE Y FECHA
			if(DB::table('ts_comprobanteventa')
					->where('serie_comprobante', $cabecera['serie'])
					->where('numero_comprobante', $cabecera['numero'])
					// ->where('id_cliente', $cabecera['cliente']['id_cliente_seleccionado'])
					// ->where('fecha', $cabecera['fecha'])
		            ->join('ts_detallecliente', 'ts_detallecliente.id', '=', 'ts_comprobanteventa.id_detalle_cliente')
					->pluck('ts_comprobanteventa.id') != null)
			{
				$filtro_existencia = 'EXISTE';
			}
			// FIN FILTRO --- EXISTE OTRO COMPROBANTE CON LA MISMA SERIE, NUMERO, CLIENTE Y FECHA

			// FILTRO --- EXISTE OTRA NOTA CON LA MISMA SERIE, NUMERO Y FECHA
			if(DB::table('ts_nota')
					->where('serie_nota', $cabecera['serie'])
					->where('numero_nota', $cabecera['numero'])
					// ->where('id_cliente', $cabecera['cliente']['id_cliente_seleccionado'])
					// ->where('fecha', $cabecera['fecha'])
		            // ->join('ts_detallecliente', 'ts_detallecliente.id', '=', 'ts_detalle_nota.id_detalle_cliente')
					->pluck('ts_nota.id') != null)
			{
				$filtro_existencia_nota = 'EXISTE';
			}
			// FIN FILTRO --- EXISTE OTRA NOTA CON LA MISMA SERIE, NUMERO Y FECHA


			if($filtro_existencia=='EXISTE')
			{ // EXISTE COMPROBANTE DE VENTA, NO GUARDAMOS NADA
				return \Response::json(array(
						'datos' => 'duplicidad'
					));	
			}
			else if($filtro_existencia_nota=='EXISTE')
			{ // EXISTE NOTA, NO GUARDAMOS NADA
				return \Response::json(array(
						'datos' => 'duplicidad_nota'
					));	
			}
			else
			{ //SE EJECUTA NORMALMENTE PORQUE NO EXISTE COMPROBANTE DE VENTA
				if($cabecera['boolean_asociar'] == true){ // CUANDO SE ASOCIA CON UNA GUIA
					// dd($request->get('cabecera'));
					$nuevaCabecera = new ComprobanteVenta;
					$nuevaCabecera->id_tipoComprobante = 2;
					$nuevaCabecera->serie_comprobante = $cabecera['serie'];
					$nuevaCabecera->numero_comprobante = $cabecera['numero'];
					$nuevaCabecera->orden_compra = $cabecera['orden_compra'];
					$nuevaCabecera->fecha = $cabecera['fecha'];
					$id_tipo_cambio = DB::table('ts_tipocambiomoneda')->where('fecha', $cabecera['fecha'])->pluck('id');
					$nuevaCabecera->id_tipoCambio = $id_tipo_cambio;
					$nuevaCabecera->id_moneda = $cabecera['moneda']['id'];
					$nuevaCabecera->id_detalle_cliente = $cabecera['cliente']['id_direccion_seleccionada'];
					$nuevaCabecera->id_igv = $id_igv;
					$nuevaCabecera->total_comprobante = $cabecera['total'];
					$nuevaCabecera->monto_retencion = $cabecera['retencion'];
					// $nuevaCabecera->id_guiaRemision = ;
					$nuevaCabecera->save();
					$id_cabecera = $nuevaCabecera->id;
					foreach ($cabecera['id_guiasRemision'] as $key => $value) {
						$guiaRemision = GuiaRemision::find($value);
						$guiaRemision->id_comprobanteVenta = $id_cabecera;
						$guiaRemision->save();
					};
					

					$detalle = $request->get('detalle');

					foreach ($detalle as $key => $value) {

						// APLICANDO IGV INCLUIDO A PRECIO UNITARIO DE PRODUCTO
						// $valor_dividir = $incluido_igv_activo+1;
						// $value['precio'] = $value['precio']/$valor_dividir;

						
						$producto = Producto::find($value['id_producto']);


						// TRANSFORMANDO PRECIO UNITARIO - DE DOLARES A SOLES
						$precio_venta_soles = 0;
						if($cabecera['moneda']['id'] == 2){
							$precio_venta_soles = $value['precio']*$tipo_cambio_compra_fecha_seleccionada;
						}
						else if($cabecera['moneda']['id'] == 1){
							$precio_venta_soles = $value['precio'];
						}

						$kardex = new Kardex;
						$kardex->id_comprobante = $id_cabecera;
						$kardex->tipo_comprobante = 'FACTURA VENTA';
						$kardex->abreviatura_tipo_documento = 'FT';
						$kardex->serie_comprobante = $cabecera['serie'];
						$kardex->numero_comprobante = $cabecera['numero'];
						$kardex->id_producto = $value['id_producto'];
						$kardex->cantidad_movimiento = $value['unidades'];
						$kardex->precio_unitario_movimiento = $producto->precio_unitario;
						$kardex->fecha_registro = $cabecera['fecha'];
						$kardex->tipo_movimiento = 'SALIDA';
						$kardex->save();


						$producto->stock = $producto->stock - $value['unidades'];
						$producto->save();

						$nuevaDetalle = new ComprobanteDetalleVenta;
						$nuevaDetalle->id_comprobanteVenta = $id_cabecera;
						$nuevaDetalle->id_producto = $value['id_producto'];
						$nuevaDetalle->unidades = $value['unidades'];
						$nuevaDetalle->precio_unitario = $value['precio'];
						$nuevaDetalle->save();
					}
				}
				else{ // STORE NORMAL
					// dd($cabecera);
					$nuevaCabecera = new ComprobanteVenta;
					$nuevaCabecera->id_tipoComprobante = 2;
					$nuevaCabecera->serie_comprobante = $cabecera['serie'];
					$nuevaCabecera->numero_comprobante = $cabecera['numero'];
					$nuevaCabecera->orden_compra = $cabecera['orden_compra'];
					$nuevaCabecera->fecha = $cabecera['fecha'];
					$id_tipo_cambio = DB::table('ts_tipocambiomoneda')->where('fecha', $cabecera['fecha'])->pluck('id');
					$nuevaCabecera->id_tipoCambio = $id_tipo_cambio;
					$nuevaCabecera->id_moneda = $cabecera['moneda']['id'];
					$nuevaCabecera->id_detalle_cliente = $cabecera['cliente']['id_direccion_seleccionada'];
					$nuevaCabecera->id_igv = $id_igv;
					$nuevaCabecera->total_comprobante = $cabecera['total'];
					$nuevaCabecera->monto_retencion = $cabecera['retencion'];
					$nuevaCabecera->save();
					$id_cabecera = $nuevaCabecera->id;


					// dd($cabecera_guia);
					foreach ($cabecera_guia as $key => $value) {
						if($cabecera_guia[$key]['generar_guia'] == true){
							// REGISTRAR CABECERA GUIAREMISION
							$nuevaCabecera_guia = new GuiaRemision;
							$nuevaCabecera_guia->id_tipoComprobante = 3;
							$nuevaCabecera_guia->serie_guiaRemision = $cabecera_guia[$key]['serie'];
							$nuevaCabecera_guia->numero_guiaRemision = $cabecera_guia[$key]['numero'];
							$nuevaCabecera_guia->fecha_traslado = $cabecera_guia[$key]['fecha'];
							$nuevaCabecera_guia->punto_partida = strtoupper($cabecera_guia[$key]['punto_partida']);
							$nuevaCabecera_guia->punto_llegada = strtoupper($cabecera_guia[$key]['punto_llegada']);
							$nuevaCabecera_guia->id_detalle_cliente = $cabecera['cliente']['id_direccion_seleccionada'];
							$nuevaCabecera_guia->id_motivoTraslado = $cabecera_guia[$key]['motivo']['id'];

							$nuevaCabecera_guia->id_personalTransporte = $cabecera_guia[$key]['personal_transporte']['id'];
							$nuevaCabecera_guia->id_unidad_Transporte = $cabecera_guia[$key]['unidad_transporte']['id'];
							$nuevaCabecera_guia->id_comprobanteVenta = $id_cabecera;
							$nuevaCabecera_guia->save();
							$id_cabecera_guia = $nuevaCabecera_guia->id;

							foreach ($cabecera_guia[$key]['detalle_guia'] as $key_guia => $value_guia) {
								// REGISTRAR DETALLE DE GUIA
								$nuevaDetalle_guia = new GuiaRemisionDetalle;
								$nuevaDetalle_guia->id_guiaRemision = $id_cabecera_guia;
								$nuevaDetalle_guia->id_producto = $value_guia['id_producto'];						
								if($value_guia['producto'] != $value_guia['nombre_producto']){
									$nuevaDetalle_guia->nombre_producto = $value_guia['nombre_producto'];
								}
								$nuevaDetalle_guia->unidades = $value_guia['cantidad'];
								$nuevaDetalle_guia->peso = $value_guia['peso'];
								$nuevaDetalle_guia->save();
							}


						}
					}

					

					$detalle = $request->get('detalle');
					// dd($detalle);
					foreach ($detalle as $key => $value) {

						// APLICANDO IGV INCLUIDO A PRECIO UNITARIO DE PRODUCTO
						// $valor_dividir = $incluido_igv_activo+1;
						// $value['precio'] = $value['precio']/$valor_dividir;

						$producto = Producto::find($value['id_producto']);

						$kardex = new KardexProducto;
						$kardex->nombre_tipo_documento = 'FT';
						$kardex->id_producto = $value['id_producto'];
						$kardex->stock_anterior = $producto->stock;
						$kardex->precio_unitario_anterior = $producto->precio_unitario;
						$kardex->stock_actualizado = $producto->stock - $value['cantidad'];
						$kardex->precio_unitario_actualizado = $value['precio'];
						$kardex->cantidad_salida = $value['cantidad'];
						$kardex->cantidad_entrada = 0;
						$kardex->fecha_registro = $cabecera['fecha'];
						$kardex->serie_comprobante = $cabecera['serie'];
						$kardex->numero_comprobante = $cabecera['numero'];
						$kardex->save();


						// TRANSFORMANDO PRECIO UNITARIO - DE DOLARES A SOLES
						$precio_venta_soles = 0;
						if($cabecera['moneda']['id'] == 2){
							$precio_venta_soles = $value['precio']*$tipo_cambio_compra_fecha_seleccionada;
						}
						else if($cabecera['moneda']['id'] == 1){
							$precio_venta_soles = $value['precio'];
						}

						$kardex = new Kardex;
						$kardex->id_comprobante = $id_cabecera;
						$kardex->tipo_comprobante = 'FACTURA VENTA';
						$kardex->abreviatura_tipo_documento = 'FT';
						$kardex->serie_comprobante = $cabecera['serie'];
						$kardex->numero_comprobante = $cabecera['numero'];
						$kardex->id_producto = $value['id_producto'];
						$kardex->cantidad_movimiento = $value['cantidad'];
						$kardex->precio_unitario_movimiento = $precio_venta_soles;
						$kardex->fecha_registro = $cabecera['fecha'];
						$kardex->tipo_movimiento = 'SALIDA';
						$kardex->save();

						$producto->stock = $producto->stock - $value['cantidad'];
						$producto->save();
						
						$nuevaDetalle = new ComprobanteDetalleVenta;
						$nuevaDetalle->id_comprobanteVenta = $id_cabecera;
						$nuevaDetalle->id_producto = $value['id_producto'];
						if(DB::table('ts_producto')->where('id', $value['id_producto'])->pluck('nombre_producto') != $value['nombre_producto']){
							$nuevaDetalle->nombre_producto = $value['nombre_producto'];
						}
						$nuevaDetalle->unidades = $value['cantidad'];
						$nuevaDetalle->precio_unitario = $value['precio'];
						$nuevaDetalle->save();
					}

				}

				// total de comprobante, metiendo a una variable
				$total_final = $cabecera['total'];

				// GUARDANDO DETALLE DE NOTA
				$nota = $request->get('nota');
				$nota_detalle = $request->get('nota_detalle');
				// dd($nota);
				if($nota['tipo_nota']['id'] != null){
					// $total_final = $nota['total_nota'];

					$nuevaNota = new Nota;
					$nuevaNota->id_detalle_cliente = $cabecera['cliente']['id_direccion_seleccionada'];
					$nuevaNota->id_motivo_nota = $nota['motivo_nota']['id'];
					$nuevaNota->id_tipo_nota = $nota['tipo_nota']['id'];
					$nuevaNota->id_moneda = $cabecera['moneda']['id'];
					$nuevaNota->serie_nota = $nota['serie_nota'];
					$nuevaNota->numero_nota = $nota['numero_nota'];
					$nuevaNota->fecha = $nota['fecha_emision'];
					$nuevaNota->monto_subtotal = $nota['monto_subtotal'];
					$nuevaNota->monto_igv = $nota['monto_igv'];
					$nuevaNota->monto_total = $nota['monto_total'];
					$nuevaNota->afecta = 'VENTA';
					$nuevaNota->save();

					foreach ($nota_detalle as $key => $value_nota_detalle) {
						$nuevaNotaDetalle = new DetalleNota;
						$nuevaNotaDetalle->id_nota = $nuevaNota->id;
						if($value_nota_detalle['id_producto']){
							$nuevaNotaDetalle->id_producto = $value_nota_detalle['id_producto'];
							$nuevaNotaDetalle->nombre_producto = $value_nota_detalle['nombre_producto'];
							$nuevaNotaDetalle->merma = $value_nota_detalle['merma'];
						}
						else {
							$nuevaNotaDetalle->descripcion = $value_nota_detalle['nombre_producto'];
						}
						$nuevaNotaDetalle->cantidad = $value_nota_detalle['cantidad'];
						$nuevaNotaDetalle->precio_unitario = $value_nota_detalle['precio_nota'];
						$nuevaNotaDetalle->save();

						$relacion_nota = new RelacionNotas;
						$relacion_nota->id_comprobanteVenta = $id_cabecera;
						$relacion_nota->id_nota = $nuevaNota->id;
						$relacion_nota->save();


						if($value_nota_detalle['producto']){
							$kardex_nota = new Kardex;
							$kardex_nota->id_comprobante = $nuevaNota->id;
							$kardex_nota->serie_comprobante = $nota['serie_nota'];
							$kardex_nota->numero_comprobante = $nota['numero_nota'];
							$kardex_nota->id_producto = $value_nota_detalle['id_producto'];
							$kardex_nota->cantidad_movimiento = $value_nota_detalle['cantidad'] + $value_nota_detalle['merma'];
							$kardex_nota->precio_unitario_movimiento = $value_nota_detalle['precio_nota'];
							$kardex_nota->fecha_registro = $cabecera['fecha'];
							if($nota['tipo_nota']['id'] == 1){
								$kardex_nota->tipo_comprobante = 'NOTA DEBITO VENTA';
								$kardex_nota->abreviatura_tipo_documento = 'ND';
								$kardex_nota->tipo_movimiento = 'SALIDA';
							} else if($nota['tipo_nota']['id'] == 2){
								$kardex_nota->tipo_comprobante = 'NOTA CREDITO VENTA';
								$kardex_nota->abreviatura_tipo_documento = 'NC';
								$kardex_nota->tipo_movimiento = 'ENTRADA';
							}
							$kardex_nota->save();
						}
					}

				}
				
				
				// GUARDANDO DETALLE DE FINANZAS
				$finanzas = $request->get('finanzas');
				// dd($monto_por_letra);
				// dd($finanzas);
				if($finanzas['condicion']['id'] == 2){ //EN LETRAS


					$cont_indivisible=0;

					$resto_division=0;
					// CALCULANDO SI ES DIVISIBLE PARA EL NUMERO DE DIAS
					if($total_final % (count($finanzas['detalles_letra'])) != 0){
						$resto_division = round($total_final / (count($finanzas['detalles_letra'])),3);
						// dd($resto_division * (count($finanzas['detalles_letra']) ));
						$monto_sumar = round ( $total_final - ( $resto_division * (count($finanzas['detalles_letra']) )),3);
						$cont_indivisible=1;
						// dd(round($monto_sumar,3));
					}

					// INICIALIZANDO LA FECHA DE INICIO LA DEL COMPROBANTE
					$fecha = date($cabecera['fecha']);

					// CALCULANDO MONTO POR LETRA EN PARTES IGUALES
					$monto_por_letra = round($total_final / count($finanzas['detalles_letra']),3);

					foreach ($finanzas['detalles_letra'] as $key => $value) {

						// ADICIONANDO 1 DIA DEBIDO AL REDONDEO
						if($cont_indivisible == 1){
							$monto_por_letra = $monto_por_letra+$monto_sumar;
						}

						// CALCULANDO LA FECHA DE VENCIMIENTO PARA CADA LETRA
						$fecha = date($cabecera['fecha']);
						$fecha = strtotime ( '+'.round($value['numero_dias']).' day' , strtotime ( $fecha ) );
						$fecha = date ( 'Y-m-j' , $fecha ); 
						
						$detallePago = new DetallePago;
						// $detallePago->id_comprobanteVenta = $id_cabecera;
						$detallePago->id_condicion_pago = $finanzas['condicion']['id'];
						$detallePago->id_medio_pago = $finanzas['medio']['id'];
						$detallePago->id_estado_letra = 4;
						$detallePago->numero_dias = $value['numero_dias'];
						$detallePago->numero_letra = $value['numero_letra'];
						$detallePago->monto_letra = $value['monto_letra'];
						// $detallePago->monto_letra = $value['monto_letra'];
						$detallePago->fecha_vencimiento = $fecha;
						$detallePago->detalle_estado =  "";
						$detallePago->save();
						
						$RelacionLetras = new RelacionLetras;
						$RelacionLetras->id_comprobanteVenta = $id_cabecera;
						$RelacionLetras->id_detalle_pago = $detallePago->id;
						$RelacionLetras->total_facturas = $total_final;
						$RelacionLetras->save();


						// RESTANDO 1 PARA LOS SIGUIENTES REGISTROS
						if($cont_indivisible == 1){
							$monto_por_letra = $monto_por_letra-$monto_sumar;
							$cont_indivisible++;
						}
					}

				}
				// dd($finanzas);
				if($finanzas['condicion']['id'] == 1){ // AL CONTADO
					$detallePago = new DetallePago;
					$detallePago->id_comprobanteVenta = $id_cabecera;
					$detallePago->id_condicion_pago = $finanzas['condicion']['id'];
					$detallePago->id_medio_pago = $finanzas['medio']['id'];
					
					if($finanzas['medio']['id'] != 1){ // DIFERENTE DE PENDIENTE
						$detallePago->fecha_pago = $finanzas['medio']['fecha_pago'];
						$detallePago->detalle_medio_pago = $finanzas['medio']['detalle_medio_pago'];
					}
					$detallePago->id_estado_letra = 6;
					$detallePago->numero_dias = null;
					$detallePago->numero_letra = null;
					$detallePago->monto_letra = null;
					$detallePago->fecha_vencimiento = null;
					$detallePago->detalle_estado =  null;
					$detallePago->save();
				}

				if($finanzas['condicion']['id'] == 4){ // PENDIENTE
					$detallePago = new DetallePago;
					$detallePago->id_comprobanteVenta = $id_cabecera;
					$detallePago->id_condicion_pago = $finanzas['condicion']['id'];
					$detallePago->save();
				}



				// if($finanzas['condicion']['id'] == 3){
				// 	$detallePago = new DetallePago;
				// 	$detallePago->id_comprobanteVenta = $id_cabecera;
				// 	$detallePago->id_condicion_pago = $finanzas['condicion']['id'];
				// 	$detallePago->id_medio_pago = $finanzas['medio']['id'];
				// 	$detallePago->id_estado_letra = 6;
				// 	$detallePago->numero_dias = null;
				// 	$detallePago->numero_letra = null;
				// 	$detallePago->monto_letra = null;
				// 	$detallePago->fecha_vencimiento = null;
				// 	$detallePago->detalle_estado =  null;
				// 	$detallePago->save();
				// }


				// if($finanzas['condicion']['id'] != null){

				// 	// TRANSFORMANDO EN ARRAY EL FORMATO DE LETRA
				// 	$array_letra = explode("-",$finanzas['numero_letra']);

				// 	// EXTRAYENDO EL TOTAL DE DIAS PARA LAS LETRAS
				// 	$total_dias = $finanzas['numero_dias'];

				// 	// DIVIDIENDO EN PARTES IGUALES EL NUMERO DE DIAS
				// 	$dias_por_letra = floor($total_dias / (count($array_letra)-1) );
				// 	// DIVIDIENDO EN PARTES IGUALES EL MONTO
				// 	$monto_por_letra = $total_final / (count($array_letra)-1);

				// 	$cont_indivisible=0;

				// 	$resto_division=0;
				// 	// CALCULANDO SI ES DIVISIBLE PARA EL NUMERO DE DIAS
				// 	if($total_dias % (count($array_letra)-1) != 0){
				// 		$resto_division = $total_dias % (count($array_letra)-1);
				// 		$cont_indivisible=1;
				// 	}

				// 	for ($i=1; $i < count($array_letra); $i++) {

				// 		// ADICIONANDO 1 DIA DEBIDO AL REDONDEO
				// 		if($cont_indivisible == 1){
				// 			$dias_por_letra = $dias_por_letra+$resto_division;
				// 		}

				// 		$detallePago = new DetallePago;
				// 		$detallePago->id_comprobanteVenta = $id_cabecera;
				// 		$detallePago->id_condicion_pago = $finanzas['condicion']['id'];
				// 		$detallePago->id_medio_pago = $finanzas['medio']['id'];
				// 		$detallePago->id_estado_letra = $finanzas['estado']['id'];
				// 		$detallePago->numero_dias = round($dias_por_letra);
				// 		$detallePago->numero_letra = $array_letra[0].$array_letra[$i];
				// 		$detallePago->monto_letra = $monto_por_letra;
				// 		$detallePago->fecha_vencimiento = $fecha;
				// 		$detallePago->detalle_estado = $finanzas['detalle_estado'];
				// 		$detallePago->save();

				// 		// RESTANDO 1 PARA LOS SIGUIENTES REGISTROS
				// 		if($cont_indivisible == 1){
				// 			$dias_por_letra = $dias_por_letra-$resto_division;
				// 			$cont_indivisible++;
				// 		}
				// 	}					
				// }

				// $id_cabecera = $nuevaCabecera->id;

				DB::commit();

				return \Response::json(array(
						'datos' => 'correcto'
					));	
			}

		} catch (Exception $e) {
			DB::rollBack();
		}

		// });
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

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		try {
			DB::beginTransaction();

			// ELIMINAR GUIAS DE REMISION
			$a_data_pago = DB::select('SELECT  
									gr.id
								FROM ts_guiaremision gr
								WHERE gr.id_comprobanteVenta = '.$id);
			foreach ($a_data_pago as $key => $value) {
				$detalle_comprobante = GuiaRemision::find($value->id);
				$detalle_comprobante->forceDelete();
			}

			// ELIMINAR DETALLE PAGO
			$a_data_pago = DB::select('SELECT  
									dp.id
								FROM ts_detalle_pago dp
								WHERE dp.id_comprobanteVenta = '.$id);
			foreach ($a_data_pago as $key => $value) {
				$detalle_comprobante = DetallePago::find($value->id);
				$detalle_comprobante->forceDelete();
			}

			// ELIMINAR RELACION LETRAS
			$a_data_relacion_letras = DB::select('SELECT  
									rl.id
								FROM ts_relacion_letras rl
								WHERE rl.id_comprobanteVenta = '.$id);
			foreach ($a_data_relacion_letras as $key => $value) {
				$detalle_comprobante = RelacionLetras::find($value->id);
				$detalle_comprobante->forceDelete();
			}

			// ELIMINAR DETALLE NOTA
			$a_data_nota = DB::select('SELECT  
									dn.id
								FROM ts_detalle_nota dn
								WHERE dn.id_comprobanteVenta = '.$id);
			foreach ($a_data_nota as $key => $value) {
				$detalle_comprobante = DetalleNota::find($value->id);
				$detalle_comprobante->forceDelete();
			}
			
			$comprobante = ComprobanteVenta::find($id);
			$comprobante->forceDelete();

			// ELIMINAR DETALLE COMPROBANTE
			$a_data_detalle = DB::select('SELECT  
									dcv.id
								FROM ts_detallecomprobanteventa dcv
								WHERE dcv.id_comprobanteVenta = '.$id);
			foreach ($a_data_detalle as $key => $value) {
				$detalle_comprobante = ComprobanteDetalleVenta::find($value->id);
				$detalle_comprobante->forceDelete();
			}
			
			// ELIMINAR DETALLE KARDEX
			$a_data_kardex = DB::select('SELECT  
									k.id
								FROM ts_kardex k
								WHERE k.tipo_comprobante="FACTURA VENTA" AND k.id_comprobante = '.$id);
			foreach ($a_data_kardex as $key => $value) {
				$kardex = Kardex::find($value->id);
				$kardex->forceDelete();
			}

			DB::commit();

			return \Response::json(array(
		            'datos' => ComprobanteVenta::with(['ComprobanteDetalleVenta.Producto','Moneda','ClienteDetalle.Cliente','Igv','GuiaRemision.ClienteDetalle.Cliente','DetallePago','DetallePagoPendiente','DetalleNota.TipoNota'])->get()
				));	

		} catch (Exception $e) {
			DB::rollBack();
		}
	}

	/* Listar registros */
	public function getAll(){

        return \Response::json(array(
            'datos' => ComprobanteVenta::with(['ComprobanteDetalleVenta.Producto','Moneda','ClienteDetalle.Cliente','Igv','GuiaRemision.ClienteDetalle.Cliente','DetallePago','DetallePagoPendiente','DetalleNota.TipoNota'])->get()
        ));
	}

	public function imprimir(Request $request)
	{
		// $cabecera = $request->get('cabecera');
		// dd($request->get('detalle'));
		$a_datos = array(
							'cabecera' => $request->get('cabecera'),
							'detalle' => $request->get('detalle'),
							'totales' => $request->get('totales')
					);
        // return \Response::json(array(
        //     'datos' => view('administracion_sistema/comprobante/impresion')
        // ));
		return view('administracion_sistema/comprobante_venta/impresion', $a_datos);
	}



	public function validar_tipoCambio(Request $request)
	{
		// $cabecera = $request->get('cabecera');
		// dd($request->get('detalle'));
		$result = DB::table('ts_tipocambiomoneda')->where('fecha', $request->get('fecha'))->pluck('valor_venta');

		if($result != null){
			echo "EXISTE";
		}
		else{
			echo "NO EXISTE";
		}

	}

	public function getRowBySerieNumero(Request $request){
		// dd($request->get('guia')['serie']);

        return \Response::json(array(
            'datos' => ComprobanteVenta::with(['ComprobanteDetalleVenta.Producto.UnidadMedida','Moneda','ClienteDetalle.Cliente','Igv','GuiaRemision.ClienteDetalle.Cliente','DetallePago','DetalleNota.TipoNota'])->where('ts_comprobanteventa.serie_comprobante','=',$request->get('guia')['serie'])->where('ts_comprobanteventa.numero_comprobante','=',$request->get('guia')['numero'])->get()
        ));

	}

	public function create_reporte()
	{
		return view('administracion_sistema/comprobante_venta/reporte');
	}


	public function ventas_2013($scope){
		// dd($scope);
        Excel::create('Reporte Ventas', function($excel) use($scope) {


		    // Our first sheet
		    $excel->sheet('First sheet', function($sheet) use($scope) {
 			// Set with font color
			// $cells->setFontColor('#357954');
		    	$scope= json_decode($scope);
		    	// dd($scope->fecha_desde);
		    	$query = "";
		    	$query = "SELECT
							cv.id
							, cv.fecha
							, cv.serie_comprobante
							, cv.numero_comprobante
							, c.razon_social
							, p.nombre_producto
							, ROUND(dcv.unidades,3) AS cantidad
							, ROUND(dcv.precio_unitario / (i.valor_igv+1),3) AS precio_unitario_soles
							, ROUND((dcv.precio_unitario/tcm.valor_venta)/ (i.valor_igv+1),3) AS precio_unitario_dolares
							, tcm.valor_venta AS valor_tipo_cambio
							, ROUND((dcv.unidades * dcv.precio_unitario)/ (i.valor_igv+1) ,2) AS sub_total
							, ROUND((cv.total_comprobante / (i.valor_igv+1)),2) AS valor_venta
							, ROUND((cv.total_comprobante - ROUND((cv.total_comprobante / (i.valor_igv+1)),3) ),2) AS igv
							, cv.total_comprobante AS total
							, cv.orden_compra
							, cv.serie_retenedor
							, cv.numero_retenedor
							, cv.monto_retencion AS retencion
							, cv.id_moneda
							, (i.valor_igv+1) AS valor_igv
						FROM ts_comprobanteventa cv
						INNER JOIN ts_detallecomprobanteventa dcv ON dcv.id_comprobanteVenta = cv.id
						INNER JOIN ts_producto p ON p.id = dcv.id_producto
						INNER JOIN ts_detallecliente dc ON dc.id = cv.id_detalle_cliente
						INNER JOIN ts_cliente c ON c.id = dc.id_cliente
						INNER JOIN ts_igv i ON i.id = cv.id_igv
						INNER JOIN ts_tipocambiomoneda tcm ON tcm.id = cv.id_tipoCambio";
				if($scope->fecha_desde != null && $scope->fecha_hasta != null){
					$query .= " WHERE cv.fecha BETWEEN '".$scope->fecha_desde."' AND '".$scope->fecha_hasta."'";
				}

				$query .= " ORDER BY cv.fecha ASC,cv.numero_comprobante ASC";

	            $result = DB::select($query);
		
	            $array_general=[];

	            array_push($array_general,
	            				[
	            					'MES'
	            					, 'FECHA'
	            					, 'Nº FACTURA'
	            					, 'Nº GUIA'
	            					, 'CLIENTE'
	            					, 'DESCRIPCION'
	            					, 'CANTIDAD'
	            					, 'PRECIO S/. I/IGV'
	            					, 'PRECIO $/. I/IGV'
	            					, 'T/C'
	            					, 'SUB-TOTAL'
	            					, 'VALOR VENTA'
	            					, 'IGV'
	            					, 'TOTAL'
	            					, 'ORDEN COMPRA'
	            					, 'N/C'
	            					, 'N/D'
	            					, 'LETRA'
	            					, 'CHEQUE'
	            					, 'DEPOSITO'
	            					, 'OTROS'
	            					, 'DOCUMENTO RETENCION'
	            					, 'S/. MONTO RETENCION'
	            				]
	            				);

		            $doc_anterior=" ";
		            $doc_actual=" ";
	            foreach ($result as $key => $value) {
	            	
		            $letras = DB::select("SELECT
											dp.numero_letra
											, dp.fecha_vencimiento
										FROM ts_relacion_letras rl 
										INNER JOIN ts_detalle_pago dp ON dp.id = rl.id_detalle_pago
										INNER JOIN ts_comprobanteventa cv ON cv.id = rl.id_comprobanteventa
										WHERE dp.id_condicion_pago = 2 AND rl.id_comprobanteventa = ".$value->id);
		            
		            $notas_debito = DB::select("SELECT
											serie_nota
											, numero_nota
										FROM ts_detalle_nota
										WHERE id_comprobanteVenta = ".$value->id." AND id_tipoNota = 1
										ORDER BY serie_nota, numero_nota");

		            $notas_credito = DB::select("SELECT
											serie_nota
											, numero_nota
										FROM ts_detalle_nota
										WHERE id_comprobanteVenta = ".$value->id." AND id_tipoNota = 2
										ORDER BY serie_nota, numero_nota");
		            $guias = DB::select("SELECT
											serie_guiaRemision
											, numero_guiaRemision
										FROM ts_guiaremision
										WHERE id_comprobanteVenta = ".$value->id."
										ORDER BY numero_guiaRemision");

		            $detalle_venta = DB::select("SELECT
													p.nombre_producto
													, ROUND(dcv.unidades,3) AS cantidad
													, ROUND(dcv.precio_unitario,3) AS precio_unitario_soles
													, ROUND(dcv.precio_unitario/tcm.valor_venta,3) AS precio_unitario_dolares
												FROM ts_detallecomprobanteventa dcv
												INNER JOIN ts_comprobanteventa cv ON cv.id = dcv.id_comprobanteVenta
												INNER JOIN ts_producto p ON p.id = dcv.id_producto
												INNER JOIN ts_tipocambiomoneda tcm ON tcm.id = cv.id_tipoCambio
												WHERE dcv.id_comprobanteVenta = ".$value->id."
												ORDER BY p.nombre_producto");

		            $deposito = DB::select("SELECT 
												dp.id_comprobanteVenta
												, c.numero_cuenta
												, b.nombre_banco
											FROM ts_detalle_pago dp
											INNER JOIN ts_cuenta c ON c.id = dp.id_cuenta
											INNER JOIN ts_banco b ON b.id = c.id_banco
											WHERE dp.id_comprobanteVenta = ".$value->id);


		            $cadena_letras=" ";
		            $cadena_notas_debito=" ";
		            $cadena_notas_credito=" ";
		            $cadena_guias=" ";
		            $cadena_detalle_venta=" ";
		            $cadena_deposito=" ";
		            $cadena_otros=" ";
		            $cadena_doc_retenedor=" ";

		            if(count($letras)>0){
		            	foreach ($letras as $key2 => $value2) {
		            		$cadena_letras = $cadena_letras . $value2->numero_letra . "|";
		            		$cadena_otros = $cadena_otros . $value2->numero_letra . "->" . $value2->fecha_vencimiento . " | ";
		            	}
		            }
		            if(count($notas_debito)>0){
		            	foreach ($notas_debito as $key6 => $value6) {
		            		$cadena_notas_debito = $cadena_notas_debito . $value6->serie_nota . "-" . substr(($value6->numero_nota + 100000000), 1) . "|";
		            	}
		            }
		            if(count($notas_credito)>0){
		            	foreach ($notas_credito as $key7 => $value7) {
		            		$cadena_notas_credito = $cadena_notas_credito . $value7->serie_nota . "-" . substr(($value7->numero_nota + 100000000), 1) . "|";
		            	}
		            }
		            if(count($guias)>0){
		            	foreach ($guias as $key3 => $value3) {
		            		$cadena_guias = $cadena_guias . $value3->serie_guiaRemision . "-" . substr(($value3->numero_guiaRemision + 100000000), 1) . "|";
		            	}
		            }
		            if(count($detalle_venta)>0){
		            	foreach ($detalle_venta as $key4 => $value4) {
		            		$cadena_detalle_venta = $cadena_detalle_venta . $value4->nombre_producto . "|";
		            	}
		            }
		            if(count($deposito)>0){
		            	foreach ($deposito as $key5 => $value5) {
		            		$cadena_deposito = $cadena_deposito . $value5->nombre_banco . "|";
		            	}
		            }else{
	            		$cadena_deposito = "- ";

		            }


		            if($value->serie_retenedor!=null){
		            	$cadena_doc_retenedor = $value->serie_retenedor.'-'.substr(($value->numero_retenedor + 100000000), 1);
		            }
		            else{
		            	$cadena_doc_retenedor = '-';
		            }

		            $mes ="";
		            $array_mes = explode("-", $value->fecha);

		            if($array_mes[1] == 1){
		            	$mes ="Enero";
		            }
		            else if($array_mes[1] == 2){
	                    $mes ="Febrero";
		            }
		            else if($array_mes[1] == 3){
	                    $mes ="Marzo";
		            }
		            else if($array_mes[1] == 4){
	                    $mes ="Abril";
		            }
		            else if($array_mes[1] == 5){
	                    $mes ="Mayo";
		            }
		            else if($array_mes[1] == 6){
	                    $mes ="Junio";
		            }
		            else if($array_mes[1] == 7){
	                    $mes ="Julio";
		            }
		            else if($array_mes[1] == 8){
	                    $mes ="Agosto";
		            }
		            else if($array_mes[1] == 9){
	                    $mes ="Setiembre";
		            }
		            else if($array_mes[1] == 10){
	                    $mes ="Octubre";
		            }
		            else if($array_mes[1] == 11){
	                    $mes ="Noviembre";
		            }
		            else if($array_mes[1] == 12){
	                    $mes ="Diciembre";
		            }

		            $prec_unitario_soles = 0;
		            $prec_unitario_dolares = 0;

		            if($value->id_moneda == 1){
		            	$prec_unitario_soles = $value->precio_unitario_soles;
		            	$prec_unitario_dolares = $value->precio_unitario_dolares;
		            }
		            else if($value->id_moneda == 2){
		            	$prec_unitario_dolares = $value->precio_unitario_soles;
		            	$prec_unitario_soles = round((($prec_unitario_dolares * $value->valor_tipo_cambio)),3);
		            }

	            	array_push($array_general,
	            				[
	            					$mes
	            					, $value->fecha
	            					, $value->serie_comprobante.'-'.substr(($value->numero_comprobante + 100000000), 1)
	            					, substr($cadena_guias, 0, -1)
	            					, $value->razon_social
	            					, $value->nombre_producto
	            					, $value->cantidad
	            					, $prec_unitario_soles
	            					, $prec_unitario_dolares
	            					, $value->valor_tipo_cambio
	            					, $value->sub_total
	            					, $value->valor_venta//esto es el VALOR VENTA
	            					, $value->igv
	            					, $value->total
	            					, $value->orden_compra
	            					, substr($cadena_notas_credito, 0, -1)
	            					, substr($cadena_notas_debito, 0, -1)
	            					, substr($cadena_letras, 0, -1)
	            					, ''
	            					, substr($cadena_deposito, 0, -1)
	            					// , ''
	            					, substr($cadena_otros, 0, -1)
	            					, $cadena_doc_retenedor
	            					, $value->retencion
	            				]
	            				);
					// , 'S/. '.$value->igv
					if($doc_anterior == $value->serie_comprobante.'-'.substr(($value->numero_comprobante + 100000000), 1)){
						$sheet->mergeCells('A'.($key+1).':A'.($key+2));
						$sheet->mergeCells('B'.($key+1).':B'.($key+2));
						$sheet->mergeCells('D'.($key+1).':D'.($key+2));
						$sheet->mergeCells('E'.($key+1).':E'.($key+2));
						$sheet->mergeCells('C'.($key+1).':C'.($key+2));
						$sheet->mergeCells('Q'.($key+1).':Q'.($key+2));
						$sheet->mergeCells('S'.($key+1).':S'.($key+2));
						$sheet->mergeCells('T'.($key+1).':T'.($key+2));
						$sheet->mergeCells('L'.($key+1).':L'.($key+2));
						$sheet->mergeCells('M'.($key+1).':M'.($key+2));
						$sheet->mergeCells('N'.($key+1).':N'.($key+2));
						$sheet->mergeCells('O'.($key+1).':O'.($key+2));

						// $sheet->row($key+1, function($row) {
						    // $row->setAlignment('center');
						    // $row->setValignment('middle');
						// });
						// $sheet->row($key+2, function($row) {
						//     $row->setAlignment('center');
						//     $row->setValignment('middle');
						// });
					}

					$doc_anterior = $value->serie_comprobante.'-'.substr(($value->numero_comprobante + 100000000), 1);
	            }
                $sheet->fromArray($array_general, null, 'A1', false, false);

                $sheet->row(1, function($row) {

				    // call cell manipulation methods
				    $row->setFontColor('#FF0000');
				    $row->setFontWeight('bold');
				    $row->setAlignment('center');
				    $row->setValignment('middle');
				});

				$sheet->setBorder('A1:W'.(count($result)+1), 'thin');

				$sheet->cell('A1:W'.(count($result)+1), function($cell){
					$cell->setFontSize(8);
					$cell->setAlignment('center');
				    $cell->setValignment('middle');
				});

				$sheet->setHeight(1, 20);
				$sheet->setWidth('A', 12);
				$sheet->setWidth('B', 12);
				$sheet->setWidth('C', 18);
				$sheet->setWidth('D', 25);
				$sheet->setWidth('E', 38);
				$sheet->setWidth('F', 40);
				$sheet->setWidth('G', 10);
				$sheet->setWidth('H', 13);
				$sheet->setWidth('I', 13);

				$sheet->setWidth('K', 13);
				$sheet->setWidth('L', 13);
				$sheet->setWidth('M', 13);
				$sheet->setWidth('N', 13);

				$sheet->setWidth('O', 20);
				$sheet->setWidth('P', 25);
				$sheet->setWidth('Q', 25);
				$sheet->setWidth('R', 50);
				$sheet->setWidth('S', 10);
				$sheet->setWidth('T', 20);
				$sheet->setWidth('U', 25);
				$sheet->setWidth('V', 20);
				$sheet->setWidth('W', 18);
				/*
				$sheet->setColumnFormat(array(
				    'V' => '0.00',
				));
				*/
				$sheet->cell('N2:N'.(count($result)+1), function($cell) {
				    $cell->setFontColor('#0000FF');
				});
		    });
        })->export('xls');
	}




	public function getReporteVentaMensual2013(){
		$array_montos = [];
    	for ($i=1; $i <= 12; $i++) { 

	    	$result = DB::select("SELECT
									IFNULL(SUM(total_comprobante),0) AS monto
								FROM ts_comprobanteventa
								WHERE MONTH(fecha)=".$i." AND YEAR(fecha)=2013");

	    	array_push($array_montos, array_pop($result)->monto);

    	}
    	
		return \Response::json(array(
				'datos' => $array_montos
			));	
	}

	public function getReporteVentaMensual2014(){
		$array_montos = [];
    	for ($i=1; $i <= 12; $i++) { 

	    	$result = DB::select("SELECT
									IFNULL(SUM(total_comprobante),0) AS monto
								FROM ts_comprobanteventa
								WHERE MONTH(fecha)=".$i." AND YEAR(fecha)=2014");

	    	array_push($array_montos, array_pop($result)->monto);

    	}
    	
		return \Response::json(array(
				'datos' => $array_montos
			));	
	}



	public function getReporteVentaMensual2015(){
		$array_montos = [];
    	for ($i=1; $i <= 12; $i++) { 

	    	$result = DB::select("SELECT
									IFNULL(SUM(total_comprobante),0) AS monto
								FROM ts_comprobanteventa
								WHERE MONTH(fecha)=".$i." AND YEAR(fecha)=2015");

	    	array_push($array_montos, array_pop($result)->monto);

    	}
    	
		return \Response::json(array(
				'datos' => $array_montos
			));	
	}




}
