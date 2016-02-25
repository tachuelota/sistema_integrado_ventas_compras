<?php namespace App\Http\Controllers\administracion_sistema\comprobante;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\ComprobanteCompra;
use App\Models\ComprobanteDetalleCompra;
use App\Models\Producto;
use App\Models\DetallePago;
use App\Models\DetalleNota;
use App\Models\GuiaRemision;
use App\Models\GuiaRemisionDetalle;
use App\Models\RelacionLetras;
use App\Models\KardexProducto;
use App\Models\Kardex;

use Illuminate\Support\Facades\DB;

class AdsComprobanteCompraController extends Controller {

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
		return view('administracion_sistema/comprobante/main');
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
		return view('administracion_sistema/comprobante/create_comprobanteCompra');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		$cabecera = $request->get('cabecera');

		$tipo_cambio_compra_fecha_seleccionada = DB::table('ts_tipocambiomoneda')->where('fecha', date("Y-m-d",strtotime($cabecera['fecha'])))->pluck('valor_venta');
		$id_igv = DB::table('ts_igv')->where('estado', 'true')->pluck('id');
		$incluido_igv_activo = DB::table('ts_igv')->where('estado', 'true')->pluck('valor_igv');

		// DB::transaction(function(){
		try {
			DB::beginTransaction();


			$cabecera_guia = $request->get('cabecera_guia');

			$filtro_existencia = '';
			// FILTRO --- EXISTE OTRO COMPROBANTE CON LA MISMA SERIE, NUMERO, PROVEEDOR Y FECHA
			if(DB::table('ts_comprobantecompra')
					->where('serie_comprobante', $cabecera['serie'])
					->where('numero_comprobante', $cabecera['numero'])
					->where('id_proveedor', $cabecera['cliente']['id'])
					->where('fecha', $cabecera['fecha'])
					->pluck('id') != null)
			{
				$filtro_existencia = 'EXISTE';
			}
			// FIN FILTRO --- EXISTE OTRO COMPROBANTE CON LA MISMA SERIE, NUMERO, PROVEEDOR Y FECHA

			if($filtro_existencia=='EXISTE')
			{ // EXISTE COMPROBANTE DE COMPRA, NO GUARDAMOS NADA

				return \Response::json(array(
						'datos' => 'duplicidad'
					));	
			}
			else
			{ //SE EJECUTA NORMALMENTE PORQUE NO EXISTE COMPROBANTE DE COMPRA
				// dd($cabecera);
				if($cabecera['boolean_asociar'] == true){ // CUANDO SE ASOCIA CON UNA GUIA cogs


					$boolean_incluido_igv;
					if($cabecera['incluido_igv'] === 'undefined' || $cabecera['incluido_igv'] === null)
					{
						$boolean_incluido_igv = false;
					} 
					else{
						$boolean_incluido_igv = $cabecera['incluido_igv'];
					}
					$nuevaCabecera = new ComprobanteCompra;
					$nuevaCabecera->id_tipoComprobante = 1;
					$nuevaCabecera->serie_comprobante = $cabecera['serie'];
					$nuevaCabecera->numero_comprobante = $cabecera['numero'];
					$nuevaCabecera->fecha = $cabecera['fecha'];
					$nuevaCabecera->id_moneda = $cabecera['moneda']['id'];
					$nuevaCabecera->id_proveedor = $cabecera['cliente']['id'];
					$nuevaCabecera->id_igv = $id_igv;
					// $nuevaCabecera->indicador_asociado = 'true';
					$nuevaCabecera->estado_igv = json_encode($boolean_incluido_igv);
					$nuevaCabecera->total_comprobante = $cabecera['total'];
					$nuevaCabecera->save();
					$id_cabecera = $nuevaCabecera->id;
					
					$id_cabecera_guia_remision = null;
					foreach ($cabecera['id_guiasRemision'] as $key => $value) {
						$guiaRemision = GuiaRemision::find($value);
						$guiaRemision->id_comprobanteCompra = $id_cabecera;
						$id_cabecera_guia_remision = $value;
						$guiaRemision->save();
					};


					foreach ($cabecera_guia as $key => $value) {
						if($cabecera_guia[$key]['generar_guia'] == true){
							// REGISTRAR CABECERA GUIAREMISION
							$nuevaCabecera_guia = new GuiaRemision;
							$nuevaCabecera_guia->id_tipoComprobante = 4;
							$nuevaCabecera_guia->serie_guiaRemision = $cabecera_guia[$key]['serie'];
							$nuevaCabecera_guia->numero_guiaRemision = $cabecera_guia[$key]['numero'];
							$nuevaCabecera_guia->fecha_traslado = $cabecera_guia[$key]['fecha'];
							$nuevaCabecera_guia->punto_partida = strtoupper($cabecera_guia[$key]['punto_partida']);
							$nuevaCabecera_guia->punto_llegada = strtoupper($cabecera_guia[$key]['punto_llegada']);
							$nuevaCabecera_guia->id_proveedor = $cabecera['cliente']['id'];
							$nuevaCabecera_guia->id_motivoTraslado = $cabecera_guia[$key]['motivo']['id'];

							$nuevaCabecera_guia->id_personalTransporte = $cabecera_guia[$key]['personal_transporte']['id'];
							$nuevaCabecera_guia->id_unidad_Transporte = $cabecera_guia[$key]['unidad_transporte']['id'];
							$nuevaCabecera_guia->id_comprobanteCompra = $id_cabecera;
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

						$nuevaDetalle = new ComprobanteDetalleCompra;
						$nuevaDetalle->id_comprobante = $id_cabecera;
						$nuevaDetalle->id_producto = $value['id_producto'];
						if(DB::table('ts_producto')->where('id', $value['id_producto'])->pluck('nombre_producto') != $value['nombre_producto']){
							$nuevaDetalle->nombre_producto = $value['nombre_producto'];
						}
						$nuevaDetalle->unidades = $value['unidades'];
						$nuevaDetalle->precio_unitario = $value['precio'];
						$nuevaDetalle->save();


						$producto = Producto::find($value['id_producto']);

						// APLICANDO IGV INCLUIDO A PRECIO UNITARIO DE PRODUCTO
						if($cabecera['incluido_igv'] == true)
						{
							$valor_dividir = $incluido_igv_activo+1;
							$value['precio'] = $value['precio']/$valor_dividir;
						}
						
						// TRANSFORMANDO PRECIO UNITARIO - DE DOLARES A SOLES
						if($cabecera['moneda']['id'] == 2){
							$value['precio'] = $value['precio']*$tipo_cambio_compra_fecha_seleccionada;
						}

						if($producto->precio_unitario == null){
							// $producto->stock = $value['cantidad'];
							$producto->stock = $producto->stock + $value['unidades'];
							$producto->precio_unitario = $value['precio'];
						}
						else{
							// dd($value);
							$producto->precio_unitario = ( ($producto->precio_unitario)*($producto->stock) + ($value['precio']*$value['unidades']) )/( ($producto->stock)+($value['unidades']));
							$producto->stock = $producto->stock + $value['unidades'];
						}

						$producto->save();

						$response = DB::table('ts_kardex')->where('id_comprobante',$id_cabecera_guia_remision)->where('id_producto',$value['id_producto'])->where('tipo_comprobante','GUIA REMISION COMPRA')->get();
						$kardex = Kardex::find($response[0]->id);
						$kardex->precio_unitario_movimiento = $value['precio'];
						$kardex->save();
					}

				}
				else{ // STORE NORMAL
					
					$boolean_incluido_igv;
					if($cabecera['incluido_igv'] === 'undefined' || $cabecera['incluido_igv'] === null)
					{
						$boolean_incluido_igv = false;
					} 
					else{
						$boolean_incluido_igv = $cabecera['incluido_igv'];
					}
					$nuevaCabecera = new ComprobanteCompra;
					$nuevaCabecera->id_tipoComprobante = 1;
					$nuevaCabecera->serie_comprobante = $cabecera['serie'];
					$nuevaCabecera->numero_comprobante = $cabecera['numero'];
					$nuevaCabecera->fecha = $cabecera['fecha'];
					$nuevaCabecera->id_moneda = $cabecera['moneda']['id'];
					$nuevaCabecera->id_proveedor = $cabecera['cliente']['id'];
					$nuevaCabecera->id_igv = $id_igv;
					// $nuevaCabecera->indicador_asociado = 'true';
					$nuevaCabecera->estado_igv = json_encode($boolean_incluido_igv);
					$nuevaCabecera->total_comprobante = $cabecera['total'];
					$nuevaCabecera->save();
					$id_cabecera = $nuevaCabecera->id;


					// dd($cabecera_guia);
					$array_id_guias_generadas = [];
					foreach ($cabecera_guia as $key => $value) {
						if($cabecera_guia[$key]['generar_guia'] == true){
							// REGISTRAR CABECERA GUIAREMISION
							$nuevaCabecera_guia = new GuiaRemision;
							$nuevaCabecera_guia->id_tipoComprobante = 4;
							$nuevaCabecera_guia->serie_guiaRemision = $cabecera_guia[$key]['serie'];
							$nuevaCabecera_guia->numero_guiaRemision = $cabecera_guia[$key]['numero'];
							$nuevaCabecera_guia->fecha_traslado = $cabecera_guia[$key]['fecha'];
							$nuevaCabecera_guia->punto_partida = strtoupper($cabecera_guia[$key]['punto_partida']);
							$nuevaCabecera_guia->punto_llegada = strtoupper($cabecera_guia[$key]['punto_llegada']);
							$nuevaCabecera_guia->id_proveedor = $cabecera['cliente']['id'];
							$nuevaCabecera_guia->id_motivoTraslado = $cabecera_guia[$key]['motivo']['id'];

							$nuevaCabecera_guia->id_personalTransporte = $cabecera_guia[$key]['personal_transporte']['id'];
							$nuevaCabecera_guia->id_unidad_Transporte = $cabecera_guia[$key]['unidad_transporte']['id'];
							$nuevaCabecera_guia->id_comprobanteCompra = $id_cabecera;
							$nuevaCabecera_guia->save();
							$id_cabecera_guia = $nuevaCabecera_guia->id; //PARA DETERMINAR LAS GUIAS QUE SE MODIFICARAN EN EL KARDEX Y SETEAR EL PRECIO DE MOVIMIENTO

							array_push($array_id_guias_generadas, ['id'=>$id_cabecera_guia]);
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

								$kardex = new Kardex;
								$kardex->id_comprobante = $id_cabecera_guia;
								$kardex->tipo_comprobante = 'GUIA REMISION COMPRA';
								$kardex->abreviatura_tipo_documento = 'GR';
								$kardex->serie_comprobante = $cabecera_guia[$key]['serie'];
								$kardex->numero_comprobante = $cabecera_guia[$key]['numero'];
								$kardex->id_producto = $value_guia['id_producto'];
								$kardex->cantidad_movimiento = $value_guia['peso'];
								$kardex->precio_unitario_movimiento = null;
								$kardex->fecha_registro = $cabecera_guia[$key]['fecha'];
								$kardex->tipo_movimiento = 'ENTRADA';
								$kardex->save();
							}
						}
					}


					$detalle = $request->get('detalle');

					foreach ($detalle as $key => $value) {

						$nuevaDetalle = new ComprobanteDetalleCompra;
						$nuevaDetalle->id_comprobante = $id_cabecera;
						$nuevaDetalle->id_producto = $value['id_producto'];
						if(DB::table('ts_producto')->where('id', $value['id_producto'])->pluck('nombre_producto') != $value['nombre_producto']){
							$nuevaDetalle->nombre_producto = $value['nombre_producto'];
						}
						$nuevaDetalle->unidades = $value['cantidad'];
						$nuevaDetalle->precio_unitario = $value['precio'];
						$nuevaDetalle->save();


						$producto = Producto::find($value['id_producto']);

						// APLICANDO IGV INCLUIDO A PRECIO UNITARIO DE PRODUCTO
						if($cabecera['incluido_igv'] == true)
						{
							$valor_dividir = $incluido_igv_activo+1;
							$value['precio'] = $value['precio']/$valor_dividir;
						}
						
						// TRANSFORMANDO PRECIO UNITARIO - DE DOLARES A SOLES
						if($cabecera['moneda']['id'] == 2){
							$value['precio'] = $value['precio']*$tipo_cambio_compra_fecha_seleccionada;
						}

						if($producto->precio_unitario == null){
							// $producto->stock = $value['cantidad'];
							$producto->stock = $producto->stock + $value['cantidad'];
							$producto->precio_unitario = $value['precio'];
						}
						else{
							// dd($value);
							$producto->precio_unitario = ( ($producto->precio_unitario)*($producto->stock) + ($value['precio']*$value['cantidad']) )/( ($producto->stock)+($value['cantidad']));
							$producto->stock = $producto->stock + $value['cantidad'];
						}

						foreach ($array_id_guias_generadas as $key_id_guias => $value_id_guias) {
							$response = DB::table('ts_kardex')->where('id_comprobante',$value_id_guias['id'])->where('id_producto',$value['id_producto'])->where('tipo_comprobante','GUIA REMISION COMPRA')->get();
							$kardex = Kardex::find($response[0]->id);
							$kardex->precio_unitario_movimiento = $value['precio'];
							$kardex->save();
						}


						$producto->save();
					}


				}	


				// total de comprobante, metiendo a una variable
				$total_final = $cabecera['total'];
				
				// GUARDANDO DETALLE DE NOTA
				$nota = $request->get('nota');
				if($nota['tipo_nota']['id'] != null){

					$total_final = $nota['total_nota'];

					$nuevaNota = new DetalleNota;
					$nuevaNota->id_tipoNota = $nota['tipo_nota']['id'];
					$nuevaNota->id_comprobanteCompra = $id_cabecera;
					$nuevaNota->id_moneda = $cabecera['moneda']['id'];
					$nuevaNota->serie_nota = $nota['serie_comprobante'];
					$nuevaNota->numero_nota = $nota['numero_comprobante'];
					$nuevaNota->fecha = $cabecera['fecha'];
					$nuevaNota->descripcion = $nota['descripcion_nota'];
					$nuevaNota->precio = $nota['precio_nota'];
					$nuevaNota->total_nota = $nota['total_nota'];
					$nuevaNota->save();

					$kardex_nota = new Kardex;
					$kardex_nota->id_comprobante = $nuevaNota->id;
					$kardex_nota->serie_comprobante = $nota['serie_comprobante'];
					$kardex_nota->numero_comprobante = $nota['numero_comprobante'];
					$kardex_nota->id_producto = $nota['producto']['id'];
					$kardex_nota->cantidad_movimiento = $nota['cantidad'];
					$kardex_nota->precio_unitario_movimiento = $nota['precio_nota'];
					$kardex_nota->fecha_registro = $cabecera['fecha'];
					if($nota['tipo_nota']['id'] == 1){
						$kardex_nota->tipo_comprobante = 'NOTA DEBITO COMPRA';
						$kardex_nota->abreviatura_tipo_documento = 'ND';
						$kardex_nota->tipo_movimiento = 'ENTRADA';
					} else if($nota['tipo_nota']['id'] == 2){
						$kardex_nota->tipo_comprobante = 'NOTA CREDITO COMPRA';
						$kardex_nota->abreviatura_tipo_documento = 'NC';
						$kardex_nota->tipo_movimiento = 'SALIDA';
					}
					$kardex_nota->save();
				}
				
				//dd($request->get('finanzas'));
				
				// GUARDANDO DETALLE DE FINANZAS
				$finanzas = $request->get('finanzas');
				if($finanzas['condicion']['id'] == 2){ //EN LETRAS
				// dd($finanzas);

					// INICIALIZANDO LA FECHA DE INICIO LA DEL COMPROBANTE
					$fecha = date($cabecera['fecha']);


					foreach ($finanzas['detalles_letra'] as $key => $value) {
						// CALCULANDO LA FECHA DE VENCIMIENTO PARA CADA LETRA
						$fecha = date($cabecera['fecha']);
						$fecha = strtotime ( '+'.round($value['numero_dias']).' day' , strtotime ( $fecha ) );
						$fecha = date ( 'Y-m-j' , $fecha ); 
						
						$detallePago = new DetallePago;
						// $detallePago->id_comprobanteCompra = $id_cabecera;
						$detallePago->id_condicion_pago = $finanzas['condicion']['id'];
						$detallePago->id_medio_pago = $finanzas['medio']['id'];
						$detallePago->id_estado_letra = 4;
						$detallePago->numero_dias = $value['numero_dias'];
						$detallePago->numero_letra = $value['numero_letra'];
						$detallePago->monto_letra = $value['monto_letra'];
						$detallePago->fecha_vencimiento = $fecha;
						$detallePago->detalle_estado =  "";
						$detallePago->save();

						$RelacionLetras = new RelacionLetras;
						$RelacionLetras->id_comprobanteCompra = $id_cabecera;
						$RelacionLetras->id_detalle_pago = $detallePago->id;
						$RelacionLetras->total_facturas = $total_final;
						$RelacionLetras->save();
					}

				}

				if($finanzas['condicion']['id'] == 1){ // AL CONTADO
					$detallePago = new DetallePago;
					$detallePago->id_comprobanteCompra = $id_cabecera;
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
								WHERE gr.id_comprobanteCompra = '.$id);
			foreach ($a_data_pago as $key => $value) {
				$guia_remision = GuiaRemision::find($value->id);
				$guia_remision->forceDelete();
			}

			// ELIMINAR DETALLE PAGO
			$a_data_pago = DB::select('SELECT  
									dp.id
								FROM ts_detalle_pago dp
								WHERE dp.id_comprobanteCompra = '.$id);
			foreach ($a_data_pago as $key => $value) {
				$detalle_pago = DetallePago::find($value->id);
				$detalle_pago->forceDelete();
			}

			// ELIMINAR RELACION LETRAS
			$a_data_relacion_letras = DB::select('SELECT  
									rl.id
								FROM ts_relacion_letras rl
								WHERE rl.id_comprobanteCompra = '.$id);
			foreach ($a_data_relacion_letras as $key => $value) {
				$relacion_letras = RelacionLetras::find($value->id);
				$relacion_letras->forceDelete();
			}

			// ELIMINAR DETALLE NOTA
			$a_data_nota = DB::select('SELECT  
									dn.id
								FROM ts_detalle_nota dn
								WHERE dn.id_comprobanteCompra = '.$id);
			foreach ($a_data_nota as $key => $value) {
				$detalle_nota = DetalleNota::find($value->id);
				$detalle_nota->forceDelete();
			}

			// ELIMINAR DETALLE KARDEX
			$a_data_kardex = DB::select('SELECT  
									k.id
								FROM ts_kardex k
								WHERE k.tipo_comprobante="FACTURA COMPRA" AND k.id_comprobante = '.$id);
			foreach ($a_data_kardex as $key => $value) {
				$kardex = Kardex::find($value->id);
				$kardex->forceDelete();
			}

			
			$comprobante = ComprobanteCompra::find($id);
			$comprobante->forceDelete();

			// ELIMINAR DETALLE COMPROBANTE
			$a_data_detalle = DB::select('SELECT  
									dcc.id
								FROM ts_detallecomprobantecompra dcc
								WHERE dcc.id_comprobante = '.$id);
			foreach ($a_data_detalle as $key => $value) {
				$detalle_comprobante = ComprobanteDetalleCompra::find($value->id);
				$detalle_comprobante->forceDelete();
			}

			DB::commit();

			return \Response::json(array(
		            'datos' => ComprobanteCompra::with(['ComprobanteDetalleCompra.Producto.UnidadMedida','Moneda','Proveedor','Igv','GuiaRemision.Proveedor','DetallePago','DetalleNota.TipoNota','DetallePagoPendiente'])->get()
				));	

		} catch (Exception $e) {
			DB::rollBack();
		}
	}

	/* Listar registros */
	public function getAll(){
        return \Response::json(array(
            'datos' => ComprobanteCompra::with(['ComprobanteDetalleCompra.Producto.UnidadMedida','Moneda','Proveedor','Igv','GuiaRemision.Proveedor','DetallePago','DetalleNota.TipoNota','DetallePagoPendiente'])->get()
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
		return view('administracion_sistema/comprobante/impresion', $a_datos);
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
		// dd(ComprobanteCompra::with(['ComprobanteDetalleCompra.Producto','Moneda','Proveedor','Igv'])->where('ts_comprobantecompra.serie_comprobante','=',$request->get('comprobante_compra')['serie'])->where('ts_comprobantecompra.numero_comprobante','=',$request->get('comprobante_compra')['numero'])->get());
		// dd($request);
        return \Response::json(array(
            'datos' => ComprobanteCompra::with(['ComprobanteDetalleCompra.Producto.UnidadMedida','Moneda','Proveedor','Igv','GuiaRemision.Proveedor','DetallePago','DetalleNota.TipoNota','DetallePagoPendiente'])->where('ts_comprobantecompra.serie_comprobante','=',$request->get('comprobante_compra')['serie'])->where('ts_comprobantecompra.numero_comprobante','=',$request->get('comprobante_compra')['numero'])->get()
        ));
	}


}
