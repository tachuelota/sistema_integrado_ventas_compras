<?php namespace App\Http\Controllers\administracion_sistema\nota_debito_credito;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Nota;
use App\Models\DetalleNota;
use App\Models\DetallePago;
use App\Models\Kardex;
use App\Models\RelacionNotas;
use App\Models\ComprobanteVenta;

use Illuminate\Support\Facades\DB;

class AdsDetalleNotaController extends Controller {

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
		return view('administracion_sistema/nota_debito_credito/main');
	}


	public function main_compra()
	{
		return view('administracion_sistema/nota_debito_credito/main_compra');
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
		return view('administracion_sistema/nota_debito_credito/create_notaDebitoCredito');
	}

	public function createCompra()
	{
		$tipo_cambio = DB::table('ts_tipocambiomoneda')->where('fecha', date("Y-m-d"))->pluck('valor_venta');
		if($tipo_cambio == null){
			return redirect('AdsTipoCambioMoneda');	
		}
		return view('administracion_sistema/nota_debito_credito/create_notaDebitoCredito_compra');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		$cabecera = $request->get('cabecera');
		$tipo_cambio_venta = DB::table('ts_tipocambiomoneda')->where('fecha', $cabecera['fecha'])->pluck('valor_venta');
		$id_igv = DB::table('ts_igv')->where('estado', 'true')->pluck('id');
		$incluido_igv_activo = DB::table('ts_igv')->where('estado', 'true')->pluck('valor_igv');

		// DB::transaction(function(){
		try {
			DB::beginTransaction();

			$filtro_existencia = '';
			// FILTRO --- EXISTE OTRO COMPROBANTE CON LA MISMA SERIE, NUMERO, CLIENTE Y FECHA
			// if(DB::table('ts_detalle_nota')
			// 		->where('serie_nota', $cabecera['serie'])
			// 		->where('numero_nota', $cabecera['numero'])
					// ->where('id_cliente', $cabecera['cliente']['id_cliente_seleccionado'])
		            // ->join('ts_detallecliente', 'ts_detallecliente.id', '=', 'ts_detalle_nota.id_detalle_cliente')
			// 		->pluck('ts_detalle_nota.id') != null)
			// {
			// 	$filtro_existencia = 'EXISTE';
			// }
			// FIN FILTRO --- EXISTE OTRO COMPROBANTE CON LA MISMA SERIE, NUMERO, CLIENTE Y FECHA

			if($filtro_existencia=='EXISTE')
			{ // EXISTE COMPROBANTE DE VENTA, NO GUARDAMOS NADA

				return \Response::json(array(
						'datos' => 'duplicidad'
					));	
			}
			else
			{ //SE EJECUTA NORMALMENTE PORQUE NO EXISTE COMPROBANTE DE VENTA

					$nuevaCabecera = new DetalleNota;
					$nuevaCabecera->id_tipoNota = $cabecera['tipo_nota']['id'];
					$nuevaCabecera->id_moneda = $cabecera['moneda']['id'];
					$nuevaCabecera->serie_nota = $cabecera['serie'];
					$nuevaCabecera->numero_nota = $cabecera['numero'];
					$nuevaCabecera->fecha = $cabecera['fecha'];
					$nuevaCabecera->descripcion = $cabecera['descripcion'];
					if(count($cabecera['producto']) > 0){ // NOTA CON PRODUCTO
						$nuevaCabecera->id_producto = $cabecera['producto']['id'];
						$nuevaCabecera->cantidad = $cabecera['cantidad'];
						$nuevaCabecera->merma = $cabecera['merma'];
					}
					$nuevaCabecera->precio = $cabecera['precio'];
					// $nuevaCabecera->total_nota = $cabecera['total_nota'];
					$nuevaCabecera->afecta = $cabecera['compra_venta'];
					$nuevaCabecera->save();
					// $id_cabecera = $nuevaCabecera->id;

					if(count($cabecera['producto']) > 0){ // AFECTA A KARDEX PORQE ES UNA NOTA CON PRODUCTO
						$kardex_nota = new Kardex;
						$kardex_nota->id_comprobante = $nuevaCabecera->id;
						$kardex_nota->serie_comprobante = $cabecera['serie'];
						$kardex_nota->numero_comprobante = $cabecera['numero'];
						$kardex_nota->id_producto = $cabecera['producto']['id'];
						$kardex_nota->cantidad_movimiento = $cabecera['cantidad'] + $cabecera['merma'];
						$kardex_nota->precio_unitario_movimiento = $cabecera['precio'] / ($cabecera['cantidad'] + $cabecera['merma']);
						$kardex_nota->fecha_registro = $cabecera['fecha'];
						if($cabecera['tipo_nota']['id'] == 1){
							$kardex_nota->tipo_comprobante = 'NOTA DEBITO VENTA';
							$kardex_nota->abreviatura_tipo_documento = 'ND';
							$kardex_nota->tipo_movimiento = 'ENTRADA';
						} else if($cabecera['tipo_nota']['id'] == 2){
							$kardex_nota->tipo_comprobante = 'NOTA CREDITO VENTA';
							$kardex_nota->abreviatura_tipo_documento = 'NC';
							$kardex_nota->tipo_movimiento = 'SALIDA';
						}
						$kardex_nota->save();
					}

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

	}

	/* Listar registros */
	public function getAll(){
        // $array_datos = RelacionNotas::with(['Nota'])->get();
        // dd($array_datos);
        return \Response::json(array(
            'datos' => RelacionNotas::with(['Nota.TipoNota','Nota.Moneda'])->get()
            // 'datos' => Nota::with(['TipoNota','Moneda'])->where('ts_nota.id_comprobanteVenta', null)->where('ts_nota.afecta', 'VENTA')->get()
        ));
	}

	public function getAllCompra(){

        return \Response::json(array(
            'datos' => DetalleNota::with(['TipoNota','Moneda'])->where('ts_detalle_nota.id_comprobanteCompra', null)->where('ts_detalle_nota.afecta', 'COMPRA')->get()
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
		// dd($request->get('guia'));

        return \Response::json(array(
            'datos' => ComprobanteVenta::with(['ComprobanteDetalleVenta.Producto.UnidadMedida','Moneda','ClienteDetalle.Cliente','Igv'])->where('ts_comprobanteventa.serie_comprobante','=',$request->get('guia')['serie'])->where('ts_comprobanteventa.numero_comprobante','=',$request->get('guia')['numero'])->get()
        ));

	}

	public function store_gestion_nota(Request $request)
	{
		$facturas = $request->get('facturas');
		$notas = $request->get('notas');
		$nota_detalles = $request->get('nota_detalles');
		// PARA EL TOTAL FINAL FALTA CONSIDERAR SI LA FACTURA TIENE NOTAS 
		try {
			DB::beginTransaction();
			foreach ($facturas as $key => $value) {

				$condicion_pago = DB::table('ts_detalle_pago')->where('id_comprobanteVenta', $value['id'])->pluck('id_condicion_pago');
				// dd($value);
				$cantidad_letras = count($value['detalle_pago']);
				$total_final;
				$total_final = $value['total_comprobante'] - $value['monto_retencion'];
				// dd($value['detalle_nota']);
				foreach ($value['detalle_nota'] as $key4 => $value4) {
					if($value4['tipo_nota']['id'] == 1){
						$total_final = $total_final + $value4['monto_total'];
					}
					else if($value4['tipo_nota']['id'] == 2){
						$total_final = $total_final - $value4['monto_total'];
					}

				}
				foreach ($notas as $key_nota => $nota) {

					// dd($nota['tipo_nota']['id']);
					if($nota['tipo_nota']['id'] == 1){
						$total_final = $total_final + $nota['monto_total'];
					}
					else if($nota['tipo_nota']['id'] == 2){
						$total_final = $total_final - $nota['monto_total'];
					}

		// dd($condicion_pago);
					if($condicion_pago == null || $condicion_pago == 2){ // EN LETRAS

						if($cantidad_letras > 0){ // EN LETRAS

							$monto_letra = $total_final / $cantidad_letras;
							$cont_indivisible=0;
							foreach ($value['detalle_pago'] as $key3 => $value3) {
								if($nota['anular_factura'] == true){
									$updateLetra = DetallePago::find($value3['id']);
									$updateLetra->id_estado_letra = 8;
									$updateLetra->save();
								}
								else{
									$updateLetra = DetallePago::find($value3['id']);
									$updateLetra->monto_letra = $monto_letra;
									$updateLetra->save();
								}
							}
						}
					}

					$nuevaNota = new Nota;
					$nuevaNota->id_detalle_cliente = $value['id_detalle_cliente'];
					$nuevaNota->id_motivo_nota = $nota['motivo_nota']['id'];
					$nuevaNota->id_tipo_nota = $nota['tipo_nota']['id'];
					$nuevaNota->id_moneda = $value['id_moneda'];
					$nuevaNota->serie_nota = $nota['serie_nota'];
					$nuevaNota->numero_nota = $nota['numero_nota'];
					$nuevaNota->fecha = $nota['fecha_emision'];
					$nuevaNota->monto_subtotal = $nota['monto_subtotal'];
					$nuevaNota->monto_igv = $nota['monto_igv'];
					$nuevaNota->monto_total = $nota['monto_total'];
					$nuevaNota->afecta = 'VENTA';
					$nuevaNota->save();

					foreach ($nota_detalles[$key_nota] as $key => $value_nota_detalle) {
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
						$relacion_nota->id_comprobanteVenta = $value['id'];
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
							$kardex_nota->fecha_registro = $nota['fecha_emision'];
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

					if($nota['anular_factura'] == true){
						$anular_factura = ComprobanteVenta::find($value['id']);
						$anular_factura->anulado = $nuevaNota->id;
						// $anular_factura->anulado = date('Y-m-d');
						$anular_factura->save();
					}

				}
			}
					// dd($condicion_pago);

			
			// $id_cabecera = $nuevaCabecera->id;

			DB::commit();

			return \Response::json(array(
					'datos' => 'correcto'
				));	

		} catch (Exception $e) {
			DB::rollBack();
		}

		// });
	}

	public function asociar_factura(Request $request)
	{
		$nota = $request->get('nota');
		$comprobante = $request->get('comprobante');

		// TOTAL COMPROVANTE VENTA
		$total_final;
		
		// CREANDO UPDATE A LA NOTA
		$nota_update = DetalleNota::find( $nota['id'] );
		
		// AFECTARA A COMPRA O VENTA
		if($request->get('tipo_comprobante') == 'venta'){
			$nota_update->id_comprobanteVenta = $comprobante['id'];
			$total_final = $comprobante['total_comprobante'] - $comprobante['monto_retencion'];
		}
		else if($request->get('tipo_comprobante') == 'compra'){
			$nota_update->id_comprobanteCompra = $comprobante['id'];
			$total_final = $comprobante['total_comprobante'];
		}

		// SUMANDO O RESTANDO SEGUN NOTA A ASOCIAR
		if($nota['tipo_nota']['id'] == 1){
			$total_final = $total_final + $nota['precio'];
		}
		else if($nota['tipo_nota']['id'] == 2){
			$total_final = $total_final - $nota['precio'];
		}



		// RECORRIENDO LAS NOTAS EXISTENTES DEL COMPROBANTE PARA CALCULAR EL MONTO FINAL
		foreach ($comprobante['detalle_nota'] as $key2 => $value2) {
			if($value2['tipo_nota']['id'] == 1){
				$total_final = $total_final + $value2['precio'];
			}
			else if($value2['tipo_nota']['id'] == 2){
				$total_final = $total_final - $value2['precio'];
			}
		}

		$nota_update->total_nota = $total_final;
		$nota_update->save();
	}


	public function store_gestion_nota_compra(Request $request)
	{
		$facturas = $request->get('facturas');
		$notas = $request->get('notas');
		// PARA EL TOTAL FINAL FALTA CONSIDERAR SI LA FACTURA TIENE NOTAS 
		try {
			DB::beginTransaction();
			foreach ($facturas as $key => $value) {
				// dd($value);
				$cantidad_letras = count($value['detalle_pago']);
				$total_final;
				$total_final = $value['total_comprobante'];
				// dd($value['detalle_nota']);
				foreach ($value['detalle_nota'] as $key4 => $value4) {
					if($value4['tipo_nota']['id'] == 1){
						$total_final = $total_final + $value4['precio'];
					}
					else if($value4['tipo_nota']['id'] == 2){
						$total_final = $total_final - $value4['precio'];
					}

				}
				foreach ($notas as $key2 => $value2) {
					$condicion_pago = DB::table('ts_detalle_pago')->where('id_comprobanteCompra', $value['id'])->pluck('id_condicion_pago');
					
					if($value2['tipo_nota']['id'] == 1){
						$total_final = $total_final + $value2['precio_nota'];
					}
					else if($value2['tipo_nota']['id'] == 2){
						$total_final = $total_final - $value2['precio_nota'];
					}
					if($condicion_pago == null){ // EN LETRAS o PENDIENTE

						if($cantidad_letras > 0){ // EN LETRAS

							$monto_letra = $total_final / $cantidad_letras;
							$cont_indivisible=0;

							foreach ($value['detalle_pago'] as $key3 => $value3) {
								$updateLetra = DetallePago::find($value3['id']);
								$updateLetra->monto_letra = $monto_letra;
								$updateLetra->save();							
							}
						}

						$nuevaNota = new DetalleNota;
						$nuevaNota->id_tipoNota = $value2['tipo_nota']['id'];
						$nuevaNota->id_comprobanteCompra = $value['id'];
						$nuevaNota->id_moneda = $value['id_moneda'];
						$nuevaNota->serie_nota = $value2['serie_nota'];
						$nuevaNota->numero_nota = $value2['numero_nota'];
						$nuevaNota->fecha = $value2['fecha_emision_nota'];
						$nuevaNota->descripcion = $value2['descripcion_nota'];
						$nuevaNota->precio = $value2['precio_nota'];
						// dd($total_final);
						$nuevaNota->total_nota = $total_final;
						// if($value2['tipo_nota']['id'] == 1){
						// 	$nuevaNota->total_nota = $value['total_comprobante'] - $value['monto_retencion'] + $value2['precio_nota'];
						// }
						// else if($value2['tipo_nota']['id'] == 2){
						// 	$nuevaNota->total_nota = $value['total_comprobante'] - $value['monto_retencion'] - $value2['precio_nota'];
						// }
						$nuevaNota->save();

					}
					else{ // AL CONTADO
						$nuevaNota = new DetalleNota;
						$nuevaNota->id_tipoNota = $value2['tipo_nota']['id'];
						$nuevaNota->id_comprobanteCompra = $value['id'];
						$nuevaNota->id_moneda = $value['id_moneda'];
						$nuevaNota->serie_nota = $value2['serie_nota'];
						$nuevaNota->numero_nota = $value2['numero_nota'];
						$nuevaNota->fecha = $value2['fecha_emision_nota'];
						$nuevaNota->descripcion = $value2['descripcion_nota'];
						$nuevaNota->precio = $value2['precio_nota'];
						if(count($value2['producto'])>0){
							$nuevaNota->id_producto = $value2['producto']['id'];
							$nuevaNota->cantidad = $value2['cantidad'];
							$nuevaNota->merma = $value2['merma'];
						}
						$nuevaNota->total_nota = $total_final;
						// if($value2['tipo_nota']['id'] == 1){
						// 	$nuevaNota->total_nota = $value['total_comprobante'] - $value['monto_retencion'] + $value2['precio_nota'];
						// }
						// else if($value2['tipo_nota']['id'] == 2){
						// 	$nuevaNota->total_nota = $value['total_comprobante'] - $value['monto_retencion'] - $value2['precio_nota'];
						// }
						$nuevaNota->save();
					}

					if(count($value2['producto'])>0){
						$precio_movimiento = null;
						// CONOCER CUAL ES EL PRODUCTO DEL DETALLE DE VENTA PARA EXTRAER SU PRECIO UNITARIO Y SETEARLO AL KARDEX
						foreach ($value['comprobante_detalle_compra'] as $key => $value_detalle_factura) {
							if($value_detalle_factura['id_producto'] == $value2['producto']['id']){
								$precio_movimiento = $value_detalle_factura['precio_unitario'];
							}
						}
						$kardex_nota = new Kardex;
						$kardex_nota->id_comprobante = $nuevaNota->id;
						$kardex_nota->serie_comprobante = $value2['serie_nota'];
						$kardex_nota->numero_comprobante = $value2['numero_nota'];
						$kardex_nota->id_producto = $value2['producto']['id'];
						$kardex_nota->cantidad_movimiento = $value2['cantidad'] + $value2['merma'];
						$kardex_nota->precio_unitario_movimiento = $precio_movimiento;
						$kardex_nota->fecha_registro = $value2['fecha_emision_nota'];
						if($value2['tipo_nota']['id'] == 1){
							$kardex_nota->tipo_comprobante = 'NOTA DEBITO VENTA';
							$kardex_nota->abreviatura_tipo_documento = 'ND';
							$kardex_nota->tipo_movimiento = 'SALIDA'; // PARA COMPRA LA ND ES UNA SALIDA
						} else if($value2['tipo_nota']['id'] == 2){
							$kardex_nota->tipo_comprobante = 'NOTA CREDITO VENTA';
							$kardex_nota->abreviatura_tipo_documento = 'NC';
							$kardex_nota->tipo_movimiento = 'ENTRADA'; // PARA OMPRA LA NC ES ENTRADA
						}
						$kardex_nota->save();
					}
				}
			}
					// dd($condicion_pago);

			
			// $id_cabecera = $nuevaCabecera->id;

			DB::commit();

			return \Response::json(array(
					'datos' => 'correcto'
				));	

		} catch (Exception $e) {
			DB::rollBack();
		}

		// });
	}

}
