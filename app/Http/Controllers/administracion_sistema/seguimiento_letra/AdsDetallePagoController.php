<?php namespace App\Http\Controllers\administracion_sistema\seguimiento_letra;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\DetallePago;
use App\Models\RelacionLetras;
use Maatwebsite\Excel\Facades\Excel;
    use Illuminate\Support\Facades\DB;

class AdsDetallePagoController extends Controller {

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
		return view('administracion_sistema/seguimiento_letra/main');
	}
	public function create_contado()
	{
		return view('administracion_sistema/seguimiento_contado/main');
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
	public function store(request $request)
	{
		$facturas = $request->get('facturas');
		$letras = $request->get('letras');
		// dd($letras);



		$acum_total_facturas = 0;
		foreach ($facturas as $key => $value) {
			$acum_total_facturas = $acum_total_facturas + $value['total_comprobante'] - $value['monto_retencion'];
		}


		$total_final = $acum_total_facturas;



		$cont_indivisible=0;

		$resto_division=0;
		// CALCULANDO SI ES DIVISIBLE PARA EL NUMERO DE DIAS
		if($total_final % (count($letras)) != 0){
			$resto_division = round($total_final / (count($letras)),3);
			$monto_sumar = round ( $total_final - ( $resto_division * (count($letras) )),3);
			$cont_indivisible=1;
		}





		// CALCULANDO MONTO POR LETRA EN PARTES IGUALES
		$monto_por_letra = round($total_final / count($letras),3);

		foreach ($letras as $key => $value) {

			// ADICIONANDO 1 DIA DEBIDO AL REDONDEO
			if($cont_indivisible == 1){
				$monto_por_letra = $monto_por_letra+$monto_sumar;
			}

			$detallePago = new DetallePago;
			$detallePago->id_condicion_pago = 2;
			$detallePago->id_estado_letra = 4;
			$detallePago->numero_dias = $value['numero_dias'];
			$detallePago->numero_letra = $value['numero_letra'];
			$detallePago->monto_letra = $value['monto_letra'];
			$detallePago->fecha_vencimiento = $value['fecha_vencimiento'];
			$detallePago->save();
			
			// RESTANDO 1 PARA LOS SIGUIENTES REGISTROS
			if($cont_indivisible == 1){
				$monto_por_letra = $monto_por_letra-$monto_sumar;
				$cont_indivisible++;
			}

			foreach ($facturas as $key2 => $value2) {
				$RelacionLetras = new RelacionLetras;
				$RelacionLetras->id_comprobanteVenta = $value2['id'];
				$RelacionLetras->id_detalle_pago = $detallePago->id;
				$RelacionLetras->total_facturas = $total_final;
				$RelacionLetras->save();
			}

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
	public function update($id_estado_nuevo, Request $request)
	{
		// dd($request);
		if($request->get('tipo_pago')=="contado"){
			$nuevo = DetallePago::find($request->get('id'));
			$nuevo->id_medio_pago = $id_estado_nuevo;
			$nuevo->fecha_pago = $request->get('datos')['fecha_pago'];
			$nuevo->detalle_medio_pago = $request->get('datos')['detalle_medio_pago'];
			$nuevo->save();
			
	        return \Response::json(array(
	            'datos' => 'correcto'
	        ));	
		}
		else if($request->get('tipo_pago')=="letras"){
			$nuevo = DetallePago::find($request->get('id'));
			$nuevo->id_estado_letra = $id_estado_nuevo;
			if($id_estado_nuevo == 2 || $id_estado_nuevo == 5 || $id_estado_nuevo == 7){
				$nuevo->id_cuenta = $request->get('detalle_estado')['id'];
			}
			if($id_estado_nuevo == 3){
				$nuevo->detalle_estado = $request->get('detalle_estado');
			}
			$nuevo->save();
			
	        return \Response::json(array(
	            'datos' => 'correcto'
	        ));	
		}
		

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

	public function getAll(){

        return \Response::json(array(
            'datos' => DetallePago::with(['RelacionLetras.ComprobanteVenta','RelacionLetras.ComprobanteVenta.DetalleNota','RelacionLetras.ComprobanteVenta.Moneda','RelacionLetras.ComprobanteVenta.ClienteDetalle.Cliente'])->orderBy('ts_detalle_pago.id_comprobanteVenta','desc')->orderBy('ts_detalle_pago.fecha_vencimiento','asc')->where('ts_detalle_pago.id_condicion_pago',2)->get()
        ));
	}
	
	public function getAllContado(){

        return \Response::json(array(
            'datos' => DetallePago::with(['ComprobanteVenta','ComprobanteVenta.DetalleNota','ComprobanteVenta.Moneda','ComprobanteVenta.ClienteDetalle.Cliente'])->orderBy('ts_detalle_pago.id_comprobanteVenta','desc')->where('ts_detalle_pago.id_condicion_pago',1)->whereNull('ts_detalle_pago.id_comprobanteCompra')->get()
        ));
	}

	public function getFilter($fecha_desde,$fecha_hasta,$razon_social){
		// dd($fecha_hasta);
		// $fecha_desde = $request->get('fecha_desde');
		// $fecha_hasta = $request->get('fecha_hasta');
		if($razon_social == 'null') $razon_social="";
        Excel::create('ReporteLetras', function($excel) use($fecha_desde,$fecha_hasta,$razon_social) {

		    // Our first sheet
		    $excel->sheet('First sheet', function($sheet) use($fecha_desde,$fecha_hasta,$razon_social) {
 				// dd($fecha_desde);
 				
                // $products = DetallePago::with(['ComprobanteVenta','ComprobanteVenta.DetalleNota','ComprobanteVenta.Moneda','ComprobanteVenta.ClienteDetalle.Cliente'])->orderBy('ts_detalle_pago.id_comprobanteVenta','desc')->orderBy('ts_detalle_pago.fecha_vencimiento','asc')->get();
	            $result = DB::select("SELECT
										c.razon_social
										, dp.numero_letra
										, CAST(dp.monto_letra as CHAR(50)) as monto_letra
										, cv.serie_comprobante
										, cv.numero_comprobante
										, dp.fecha_vencimiento
										, el.nombre_estado_letra
									FROM ts_detalle_pago dp
									INNER JOIN ts_comprobanteventa cv ON cv.id = dp.id_comprobanteVenta
									INNER JOIN ts_detallecliente dc ON dc.id = cv.id_detalle_cliente
									INNER JOIN ts_cliente c ON c.id = dc.id_cliente
									INNER JOIN ts_estado_letra el ON el.id = dp.id_estado_letra
									WHERE dp.fecha_vencimiento BETWEEN '".$fecha_desde."' AND '".$fecha_hasta."' AND c.razon_social LIKE '".$razon_social."%' AND dp.id_condicion_pago = 2
									ORDER BY c.razon_social DESC, dp.fecha_vencimiento ASC");
		// dd($result);
            	// $result = DetallePago::with(['ComprobanteVenta','ComprobanteVenta.DetalleNota','ComprobanteVenta.Moneda','ComprobanteVenta.ClienteDetalle.Cliente'])->orderBy('ts_detalle_pago.id_comprobanteVenta','desc')->orderBy('ts_detalle_pago.fecha_vencimiento','asc')->get();
	            $array_general=[];
	            $cont = 0;
	            foreach ($result as $key => $value) {

	            	if($cont == 0){//SETEANDO CABECERA DE CONSULTA
	            		array_push($array_general,
	            				[
	            					'RAZON SOCIAL'
	            					, 'NUMERO LETRA'
	            					, 'MONTO LETRA'
	            					, 'SERIE FACTURA'
	            					, 'CORELATIVO FACTURA'
	            					, 'FECHA VENCIMIENTO'
	            					, 'ESTADO LETRA'
	            				]
	            				);
	            		$cont++;
	            	}
	            	array_push($array_general,
	            				[
	            					$value->razon_social
	            					, $value->numero_letra
	            					, $value->monto_letra
	            					, $value->serie_comprobante
	            					, $value->numero_comprobante
	            					, $value->fecha_vencimiento
	            					, $value->nombre_estado_letra
	            				]
	            				);
	            }
                $sheet->fromArray($array_general, null, 'A1', false, false);

		    });
        })->export('xls');
	}
	

	public function ventas_2013(){

        Excel::create('Reporte Ventas', function($excel){


		    // Our first sheet
		    $excel->sheet('First sheet', function($sheet){
 			// Set with font color
			// $cells->setFontColor('#357954');
	            $result = DB::select("SELECT
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
										,	ROUND((dcv.unidades * dcv.precio_unitario)/ (i.valor_igv+1) ,2) AS sub_total
										,	ROUND((cv.total_comprobante / (i.valor_igv+1)),2) AS valor_venta
										,	ROUND((cv.total_comprobante - ROUND((cv.total_comprobante / (i.valor_igv+1)),3) ),2) AS igv
										,	cv.total_comprobante AS total
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
									INNER JOIN ts_tipocambiomoneda tcm ON tcm.id = cv.id_tipoCambio
									ORDER BY cv.fecha ASC,cv.numero_comprobante ASC");
		
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
		            
		            $guias = DB::select("SELECT
											serie_guiaRemision
											, numero_guiaRemision
										FROM ts_guiaremision
										WHERE id_comprobanteVenta = ".$value->id."
										ORDER BY numero_guiaRemision");

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
		            		$cadena_otros = $cadena_otros . "LETRA " . $value2->numero_letra . " VCTO " . $value2->fecha_vencimiento . "|";
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
		            }


		            if($value->serie_retenedor!=null){
		            	$cadena_doc_retenedor = $value->serie_retenedor.'-'.substr(($value->numero_retenedor + 100000000), 1);
		            }
		            else{
		            	$cadena_doc_retenedor = '';
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
	            					, substr($cadena_notas_debito, 0, -1)
	            					, substr($cadena_notas_credito, 0, -1)
	            					, substr($cadena_letras, 0, -1)
	            					, ''
	            					, substr($cadena_deposito, 0, -1)
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

				$sheet->setBorder('A1:V'.(count($result)+1), 'thin');

				$sheet->cell('A1:V'.(count($result)+1), function($cell){
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

				$sheet->setWidth('O', 10);
				$sheet->setWidth('P', 10);
				$sheet->setWidth('Q', 10);
				$sheet->setWidth('R', 10);
				$sheet->setWidth('S', 20);
				$sheet->setWidth('T', 25);
				$sheet->setWidth('U', 20);
				$sheet->setWidth('V', 18);
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



// $sheet->row(1, function($row) {

//     // call cell manipulation methods
//     $row->setBackground('#000000');

// });
	public function create_reporte()
	{
		return view('administracion_sistema/seguimiento_letra/reporte');
	}

	public function set_detalle_pago(Request $request)
	{
		// dd($request);

		// DB::transaction(function(){
		try {
			DB::beginTransaction();

			// dd($request->get('id_detalle_pago_anterior'));

			$eliminar_detallePago = DetallePago::find($request->get('id_detalle_pago_anterior'));
			$eliminar_detallePago->forceDelete();

			if($request->get('condicion')['id'] == 2){ //EN LETRAS
			foreach ($request->get('detalles_letra') as $key => $value) {
					
					$detallePago = new DetallePago;
					$detallePago->id_condicion_pago = $request->get('condicion')['id'];
					$detallePago->id_medio_pago = $request->get('medio')['id'];
					$detallePago->id_estado_letra = 4;
					$detallePago->numero_dias = $value['numero_dias'];
					$detallePago->numero_letra = $value['numero_letra'];
					$detallePago->monto_letra = $value['monto_letra'];
					// $detallePago->monto_letra = $value['monto_letra'];
					$detallePago->id_comprobanteVenta = $request->get('id_comprobante');
					$detallePago->fecha_vencimiento = $value['fecha_vencimiento'];
					$detallePago->save();
					
					$RelacionLetras = new RelacionLetras;
					$RelacionLetras->id_comprobanteVenta = $request->get('id_comprobante');
					$RelacionLetras->id_detalle_pago = $detallePago->id;
					$RelacionLetras->total_facturas = $request->get('total');
					$RelacionLetras->save();
				}

			}
				// dd($finanzas);
			if($request->get('condicion')['id'] == 1){ // AL CONTADO
				$detallePago = new DetallePago;
				$detallePago->id_comprobanteVenta = $request->get('id_comprobante');
				$detallePago->id_condicion_pago = $request->get('condicion')['id'];
				$detallePago->id_medio_pago = $request->get('medio')['id'];
				
				if($request->get('medio')['id'] != 1){ // DIFERENTE DE PENDIENTE
					$detallePago->fecha_pago = $request->get('medio')['fecha_pago'];
					$detallePago->detalle_medio_pago = $request->get('medio')['detalle_medio_pago'];
				}
				$detallePago->id_estado_letra = 6;
				$detallePago->save();
			}

			if($request->get('condicion')['id'] == 4){ // PENDIENTE
				$detallePago = new DetallePago;
				$detallePago->id_comprobanteVenta = $request->get('id_comprobante');
				$detallePago->id_condicion_pago = $request->get('condicion')['id'];
				$detallePago->save();
			}


			DB::commit();

			return \Response::json(array(
					'datos' => 'correcto'
				));	

		} catch (Exception $e) {
			DB::rollBack();
		}

		// });
	}

	public function set_detalle_pago_compra(Request $request)
	{
		// dd($request);

		// DB::transaction(function(){
		try {
			DB::beginTransaction();

			// dd($request->get('id_detalle_pago_anterior'));

			$eliminar_detallePago = DetallePago::find($request->get('id_detalle_pago_anterior'));
			$eliminar_detallePago->forceDelete();

			if($request->get('condicion')['id'] == 2){ //EN LETRAS
			foreach ($request->get('detalles_letra') as $key => $value) {
					
					$detallePago = new DetallePago;
					$detallePago->id_condicion_pago = $request->get('condicion')['id'];
					$detallePago->id_medio_pago = $request->get('medio')['id'];
					$detallePago->id_estado_letra = 4;
					$detallePago->numero_dias = $value['numero_dias'];
					$detallePago->numero_letra = $value['numero_letra'];
					$detallePago->monto_letra = $value['monto_letra'];
					// $detallePago->monto_letra = $value['monto_letra'];
					$detallePago->id_comprobanteCompra = $request->get('id_comprobante');
					$detallePago->fecha_vencimiento = $value['fecha_vencimiento'];
					$detallePago->save();
					
					$RelacionLetras = new RelacionLetras;
					$RelacionLetras->id_comprobanteCompra = $request->get('id_comprobante');
					$RelacionLetras->id_detalle_pago = $detallePago->id;
					$RelacionLetras->total_facturas = $request->get('total');
					$RelacionLetras->save();
				}

			}
				// dd($finanzas);
			if($request->get('condicion')['id'] == 1){ // AL CONTADO
				$detallePago = new DetallePago;
				$detallePago->id_comprobanteCompra = $request->get('id_comprobante');
				$detallePago->id_condicion_pago = $request->get('condicion')['id'];
				$detallePago->id_medio_pago = $request->get('medio')['id'];
				
				if($request->get('medio')['id'] != 1){ // DIFERENTE DE PENDIENTE
					$detallePago->fecha_pago = $request->get('medio')['fecha_pago'];
					$detallePago->detalle_medio_pago = $request->get('medio')['detalle_medio_pago'];
				}
				$detallePago->id_estado_letra = 6;
				$detallePago->save();
			}

			if($request->get('condicion')['id'] == 4){ // PENDIENTE
				$detallePago = new DetallePago;
				$detallePago->id_comprobanteCompra = $request->get('id_comprobante');
				$detallePago->id_condicion_pago = $request->get('condicion')['id'];
				$detallePago->save();
			}


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
