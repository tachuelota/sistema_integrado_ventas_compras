<?php namespace App\Http\Controllers\administracion_sistema\producto;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\Producto;
use App\Models\DetallePago;
use App\Models\SaldoInicial;
use Maatwebsite\Excel\Facades\Excel;

class AdsProductoController extends Controller {

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
		return view('administracion_sistema/producto/main');
	}


	public function create_cierre_mensual()
	{
		return view('administracion_sistema/producto/cierre_mensual');
	}

	public function create_kardex()
	{
		return view('administracion_sistema/producto/create_kardexProducto');
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
		$existe = "";
		if(DB::table('ts_producto')
				->where('id_titulo', $request->get('titulo')['id'])
				->where('id_composicion', $request->get('composicion')['id'])
				->where('id_hilatura', $request->get('hilatura')['id'])
				->where('id_tipoproducto', $request->get('tipo_producto')['id'])
				->where('id_tipotela', $request->get('tipo_tela')['id'])
				->where('id_color', $request->get('color')['id'])
				->pluck('id') != null)
		{
			$existe = 'EXISTE';
		}

		if($existe=='EXISTE')
		{ // EXISTE COMPROBANTE DE VENTA, NO GUARDAMOS NADA
			return \Response::json(array(
					'datos' => 'duplicidad'
				));	
		}
		else
		{

			$nuevo = new Producto; // Preparamos un registro vacio para la tabla Local
			$nuevo->imagen_producto = $request->get('file_nombre');
			$nombre_producto_anidado = "";
			$nombre_producto_anidado .= $request->get('tipo_producto')['nombre_tipo_producto']." ";
			if($request->get('tipo_producto')['id'] == 2){
				$nombre_producto_anidado .= $request->get('tipo_tela')['nombre_tipo_tela']." ";
				$nuevo->id_tipotela = $request->get('tipo_tela')['id'];
			}
			if($request->get('composicion')!=null){
				$nombre_producto_anidado .= $request->get('composicion')['nombre_composicion']." ";
				$nuevo->id_composicion = $request->get('composicion')['id'];
			}

			if($request->get('hilatura')!=null){
				$nombre_producto_anidado .= $request->get('hilatura')['nombre_hilatura']." ";
				$nuevo->id_hilatura = $request->get('hilatura')['id'];
			}

			if($request->get('tipo_producto')['id'] == 2){
				$nombre_producto_anidado .= $request->get('color')['nombre_color']." ";
				$nuevo->id_color = $request->get('color')['id'];
			}

			if($request->get('titulo')!=null){
				$nombre_producto_anidado .= "TIT ".$request->get('titulo')['nombre_titulo'];
				$nuevo->id_titulo = $request->get('titulo')['id'];
			}

			$nuevo->id_tipoproducto = $request->get('tipo_producto')['id'];
			$nuevo->nombre_producto = trim($nombre_producto_anidado);
			// $nuevo->id_unidad_medida = $request->get('unidad_medida')['id'];
			$nuevo->id_unidad_medida = 1;
			$nuevo->stock = 0;
			$nuevo->save();

			$update = Producto::find($nuevo->id);
			$update->codigo_producto = $nuevo->id;
			$update->save();

	        return \Response::json(array(
	            'datos' => Producto::with(['UnidadMedida'])->get()
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
		$nuevo = Producto::find($id);
		$nuevo->imagen_producto = $request->get('file_nombre');
		$nombre_producto_anidado = "";
		$nombre_producto_anidado .= $request->get('tipo_producto')['nombre_tipo_producto']." ";
		if($request->get('tipo_producto')['id'] == 2){
			$nombre_producto_anidado .= $request->get('tipo_tela')['nombre_tipo_tela']." ";
			$nuevo->id_tipotela = $request->get('tipo_tela')['id'];
		}
		if($request->get('composicion')!=null){
			$nombre_producto_anidado .= $request->get('composicion')['nombre_composicion']." ";
			$nuevo->id_composicion = $request->get('composicion')['id'];
		}

		if($request->get('tipo_producto')['id'] == 1 && $request->get('hilatura')!=null){
			$nombre_producto_anidado .= $request->get('hilatura')['nombre_hilatura']." ";
			$nuevo->id_hilatura = $request->get('hilatura')['id'];
		}

		if($request->get('tipo_producto')['id'] == 2){
			$nombre_producto_anidado .= $request->get('color')['nombre_color']." ";
			$nuevo->id_color = $request->get('color')['id'];
		}

		if($request->get('tipo_producto')['id'] == 1){
			$nombre_producto_anidado .= "TIT ".$request->get('titulo')['nombre_titulo'];
			$nuevo->id_titulo = $request->get('titulo')['id'];
		}

		$nuevo->id_tipoproducto = $request->get('tipo_producto')['id'];
		$nuevo->nombre_producto = trim($nombre_producto_anidado);
		// $nuevo->id_unidad_medida = $request->get('unidad_medida')['id'];
		$nuevo->id_unidad_medida = 1;
		$nuevo->save();
		
        return \Response::json(array(
            'datos' => Producto::with(['UnidadMedida'])->get()
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
		$guiasalida = Producto::find($id);
		$guiasalida -> delete();

        return \Response::json(array(
            'datos' => Producto::with(['UnidadMedida'])->get()
        ));
	}

	/* Listar registros */
	public function getAll(){
        return \Response::json(array(
            'datos' => Producto::with(['UnidadMedida','Composicion','Hilatura','Color','Titulo','TipoProducto','TipoTela'])->orderBy('ts_producto.nombre_producto')->get()
        ));
	}

	public function uploadImage(){
		$file = $_FILES['file']['name'];

		if(!is_dir('img_productos/')) mkdir('img_productos/',0777);

		if($file && move_uploaded_file($_FILES['file']['tmp_name'], 'img_productos/'.$file))
		{
			Session::put('nombre_imagen',$file);
			// dd($file);
			echo $file;
		}
	}

	public function exportExcel(){
		Excel::create('Laravel Excel', function($excel) {

		    // Our first sheet
		    $excel->sheet('First sheet', function($sheet) {
 
                $products = DetallePago::with(['ComprobanteVenta','ComprobanteVenta.DetalleNota','ComprobanteVenta.Moneda','ComprobanteVenta.ClienteDetalle.Cliente'])->orderBy('ts_detalle_pago.id_comprobanteVenta','desc')->orderBy('ts_detalle_pago.fecha_vencimiento','asc')->get();
 
                $sheet->fromArray($products);

		    });

		    // Our second sheet
		    // $excel->sheet('Second sheet', function($sheet) {
 
      //           $products = Producto::all();
 
      //           $sheet->fromArray($products);

		    // });
        })->export('xls');
	}

	public function cierre_mensual(Request $request){

		try {
			DB::beginTransaction();

			$mes = $request->get('mes');
			$nuevo_mes = strtotime ( '+1 month' , strtotime ( $mes ) ) ;
			$fecha_saldo = date ( 'Y-m-d' , $nuevo_mes );

	        $array_productos = Producto::all();

	        foreach ($array_productos as $key => $value) {
	        	$nuevo_saldo = new SaldoInicial;
	        	$nuevo_saldo->id_producto = $value['id'];
	        	$nuevo_saldo->stock_inicial = $value['stock'];
	        	if($value['precio_unitario'] != null){
		        	$nuevo_saldo->precio_unitario_inicial = $value['precio_unitario'];
	        	}
	        	else{
		        	$nuevo_saldo->precio_unitario_inicial = 0;
	        	}
	        	$nuevo_saldo->fecha_saldo = $fecha_saldo;
	        	$nuevo_saldo->save();
	        }

			DB::commit();

			return \Response::json(array(
					'datos' => 'correcto'
				));	

		} catch (Exception $e) {
			DB::rollBack();
		}

	}


	public function getKardex($scope){
		try {
			$scope = json_decode($scope);

			$anio=date("Y",strtotime($scope->fecha)); 
			$mes=date("m",strtotime($scope->fecha)); 
			$parte_fecha=date("Y-m-",strtotime($scope->fecha)); 
			$ultimo_dia_mes = $parte_fecha.date("d",(mktime(0,0,0,$mes+1,1,$anio)-1));

			$nombre_archivo;
			if($scope->id_producto == null){
				$nombre_archivo = 'KARDEX GENERAL';
			}
			else if($scope->id_producto != null){
				$nombre_archivo = $scope->nombre_producto;
			}
	        Excel::create($nombre_archivo, function($excel) use($ultimo_dia_mes, $scope) {
				if($scope->id_producto == null){
            		$array_productos = Producto::orderBy('ts_producto.nombre_producto')->get();

            		foreach ($array_productos as $key => $value) {
            			$value['nombre_producto'] = str_replace("[áàâãª]","a",$value['nombre_producto']);
						$value['nombre_producto'] = str_replace("[ÁÀÂÃ]","A",$value['nombre_producto']);
						$value['nombre_producto'] = str_replace("[éèê]","e",$value['nombre_producto']);
						$value['nombre_producto'] = str_replace("[ÉÈÊ]","E",$value['nombre_producto']);
						$value['nombre_producto'] = str_replace("[íìî]","i",$value['nombre_producto']);
						$value['nombre_producto'] = str_replace("[ÍÌÎ]","I",$value['nombre_producto']);
						$value['nombre_producto'] = str_replace("[óòôõº]","o",$value['nombre_producto']);
						$value['nombre_producto'] = str_replace("[ÓÒÔÕ]","O",$value['nombre_producto']);
						$value['nombre_producto'] = str_replace("[úùû]","u",$value['nombre_producto']);
						$value['nombre_producto'] = str_replace("[ÚÙÛ]","U",$value['nombre_producto']);
						$value['nombre_producto'] = str_replace(" ","-",$value['nombre_producto']);
						$value['nombre_producto'] = str_replace("ñ","n",$value['nombre_producto']);
						$value['nombre_producto'] = str_replace("Ñ","N",$value['nombre_producto']);
						$value['nombre_producto'] = str_replace("/","_",$value['nombre_producto']);
						$titulo = substr($value['nombre_producto'], 0, 30);

					    $excel->sheet($titulo, function($sheet) use($ultimo_dia_mes, $scope, $value) {
					    	$query = "";
					    	$query = "SELECT
										kp.nombre_tipo_documento
										, p.nombre_producto
										, kp.stock_anterior
										, ROUND(kp.precio_unitario_anterior,2) AS precio_unitario_anterior
										, kp.stock_actualizado
										, ROUND(kp.precio_unitario_actualizado,2) AS precio_unitario_actualizado
										, kp.cantidad_salida
										, kp.cantidad_entrada
										, kp.fecha_registro
										, kp.serie_comprobante
										, kp.numero_comprobante
									FROM ts_kardex_producto kp
									INNER JOIN ts_producto p ON p.id = kp.id_producto";
						// dd(date("Y-m-d",strtotime($scope->fecha)));
								$query .= " WHERE kp.fecha_registro BETWEEN '".date("Y-m-d",strtotime($scope->fecha))."' AND '".$ultimo_dia_mes."'";
								$query .= " AND kp.id_producto=".$value['id'];
								$query .= " ORDER BY kp.fecha_registro ASC,kp.id ASC";

				            $result = DB::select($query);
				            $array_general=[];

				            $descripcion = str_replace("-"," ",$value['nombre_producto']);
				            $descripcion = str_replace("_","/",$descripcion);
				            array_push($array_general,
				            				[
				            					'INVENTARIO PERMANENTE VALORIZADO', '', '', '', '', 'FT: FACTURA'
				            				],
				            				[
				            					'PERIODO: '.date("Y",strtotime($scope->fecha)), '', '', '', '', 'GR: GUÍA DE REMISIÓN'
				            				],
				            				[
				            					'RUC: 20101717098', '', '', '', '', 'BV: BOLETA DE VENTA'
				            				],
				            				[
				            					'TEJIDOS JORGITO SRL', '', '', '', '', 'NC: NOTA DE CRÉDITO'
				            				],
				            				[
				            					'CALLE LOS TELARES No 185 URB. VULCANO-ATE', '', '', '', '', 'ND: NOTA DE DÉBITO'
				            				],
				            				[
				            					'CÓDIGO', '', '', '', '', 'OS: ORDEN DE SALIDA'
				            				],
				            				[
				            					'TIPO: 03', '', '', '', '', 'OI: ORDEN DE INGRESO'
				            				],
				            				[
				            					$descripcion, '', '', '', '', 'CU: COSTO UNITARIO (NUEVOS SOLES)'
				            				],
				            				[
				            					'UNIDAD DE MEDIDA: 01', '', '', '', '', 'CT: COSTO TOTAL (NUEVOS SOLES)'
				            				],
				            				[
				            					'MÉTODO DE EVALUACIÓN: COSTO PROMEDIO', '', '', '', '', 'SI: SALDO INICIAL'
				            				],
				            				[
				            					'', '', '', '', '', ''
				            				],
				            				[
				            					'DOCUMENTO DE MOVIMIENTO', '', '', '', 'ENTRADAS', '', '', 'SALIDAS', '', '', 'SALDO FINAL'
				            				],
				            				[
				            					'FECHA', 'TIPO', 'SERIE', 'NÚMERO', 'CANTIDAD', 'CU', 'CT', 'CANTIDAD', 'CU', 'CT', 'CANTIDAD', 'CU', 'CT'
				            				]
				            			);


				             //EXTRAYENDO EL SALDO INICIAL
					        $saldo_inicial = SaldoInicial::where('id_producto',$value['id'])->where('fecha_saldo', date("Y-m-d",strtotime($scope->fecha)) )->get();
							$no_saldo_inicial = 0;

					        // INICIALISANDO MONTOS TOTALES
					        $total_entrada_cantidad = 0;
					        $total_entrada_cu = 0;
					        $total_entrada_ct = 0;
					        $total_salida_cantidad = 0;
					        $total_salida_cu = 0;
					        $total_salida_ct = 0;
					        $total_final_cantidad = 0;
					        $total_final_cu = 0;
					        $total_final_ct = 0;
					        if(count($saldo_inicial)>0){
						        foreach ($saldo_inicial as $key => $value_saldo_inicial) {
						        	array_push($array_general,
						            				[
						            					date("d-m-Y",strtotime($value_saldo_inicial->fecha_saldo))
						            					, ''
						            					, 'SI'
						            					, ''
							            				, $english_format_number = number_format(''.$value_saldo_inicial->stock_inicial, 2, '.', '')
							            				, $english_format_number = number_format(''.round($value_saldo_inicial->precio_unitario_inicial,2), 2, '.', '')
							            				, $english_format_number = number_format(''.$value_saldo_inicial->stock_inicial*round($value_saldo_inicial->precio_unitario_inicial,2), 2, '.', '')
							            				, $english_format_number = number_format(0, 2, '.', '')
							            				, $english_format_number = number_format(0, 2, '.', '')
							            				, $english_format_number = number_format(0, 2, '.', '')
							            				, $english_format_number = number_format(''.$value_saldo_inicial->stock_inicial, 2, '.', '')
							            				, $english_format_number = number_format(''.round($value_saldo_inicial->precio_unitario_inicial,2), 2, '.', '')
							            				, $english_format_number = number_format(''.$value_saldo_inicial->stock_inicial*round($value_saldo_inicial->precio_unitario_inicial,2), 2, '.', '')
						            				]
				        				);


							        $total_entrada_cantidad = $total_entrada_cantidad + $value_saldo_inicial->stock_inicial;
							        $total_entrada_cu = $total_entrada_cu + round($value_saldo_inicial->precio_unitario_inicial,2);
							        $total_entrada_ct = $total_entrada_ct + $value_saldo_inicial->stock_inicial*round($value_saldo_inicial->precio_unitario_inicial,2);
							        $total_salida_cantidad = $total_salida_cantidad + 0;
							        $total_salida_cu = $total_salida_cu + 0;
							        $total_salida_ct = $total_salida_ct + 0;
							        $total_final_cantidad = $total_final_cantidad + $value_saldo_inicial->stock_inicial;
							        $total_final_cu = $total_final_cu + round($value_saldo_inicial->precio_unitario_inicial,2);
							        $total_final_ct = $total_final_ct + $value_saldo_inicial->stock_inicial*round($value_saldo_inicial->precio_unitario_inicial,2);
						        }
					        }else{  //NO EXISTE SALDO INICIAL PARA EL PRODUCTO EN EL MES
					        	$no_saldo_inicial = 1;
					        	array_push($array_general,
						            				[
						            					date("d-m-Y",strtotime($scope->fecha))
						            					, ''
						            					, 'SI'
						            					, ''
							            				, $english_format_number = number_format(0, 2, '.', '')
							            				, $english_format_number = number_format(0, 2, '.', '')
							            				, $english_format_number = number_format(0, 2, '.', '')
							            				, $english_format_number = number_format(0, 2, '.', '')
							            				, $english_format_number = number_format(0, 2, '.', '')
							            				, $english_format_number = number_format(0, 2, '.', '')
							            				, $english_format_number = number_format(0, 2, '.', '')
							            				, $english_format_number = number_format(0, 2, '.', '')
							            				, $english_format_number = number_format(0, 2, '.', '')
						            				]
				        				);
					        }

				            foreach ($result as $key => $value_result) {

				            	if($value_result->nombre_tipo_documento === 'FT'){ //SALIDA
					            	array_push($array_general,
					            				[
					            					date("d-m-Y",strtotime($value_result->fecha_registro))
					            					, $value_result->nombre_tipo_documento
					            					, $value_result->serie_comprobante
					            					, substr(($value_result->numero_comprobante + 100000000), 1)
						            				, $english_format_number = number_format(0, 2, '.', '')
						            				, $english_format_number = number_format(0, 2, '.', '')
						            				, $english_format_number = number_format(0, 2, '.', '')
						            				, $english_format_number = number_format(''.$value_result->cantidad_salida, 2, '.', '')
						            				, $english_format_number = number_format(''.$value_result->precio_unitario_actualizado, 2, '.', '')
						            				, $english_format_number = number_format(''.$value_result->cantidad_salida*$value_result->precio_unitario_actualizado, 2, '.', '')
						            				, $english_format_number = number_format(''.$value_result->stock_actualizado, 2, '.', '')
						            				, $english_format_number = number_format(''.$value_result->precio_unitario_actualizado, 2, '.', '')
						            				, $english_format_number = number_format(''.$value_result->stock_actualizado*$value_result->precio_unitario_actualizado, 2, '.', '')
					            				]
			        				);
			        				
							        $total_entrada_cantidad = $total_entrada_cantidad + 0;
							        $total_entrada_cu = $total_entrada_cu + 0;
							        $total_entrada_ct = $total_entrada_ct + 0;
							        $total_salida_cantidad = $total_salida_cantidad + $value_result->cantidad_salida;
							        $total_salida_cu = $total_salida_cu + $value_result->precio_unitario_actualizado;
							        $total_salida_ct = $total_salida_ct + $value_result->cantidad_salida*$value_result->precio_unitario_actualizado;
							        $total_final_cantidad = $total_final_cantidad + $value_result->stock_actualizado;
							        $total_final_cu = $total_final_cu + $value_result->precio_unitario_actualizado;
							        $total_final_ct = $total_final_ct + $value_result->stock_actualizado*$value_result->precio_unitario_actualizado;

				            	}
				            	else if($value_result->nombre_tipo_documento === 'GR'){ //ENTRADA
				            		array_push($array_general,
					            				[
					            					date("d-m-Y",strtotime($value_result->fecha_registro))
					            					, ''.$value_result->nombre_tipo_documento
					            					, ''.$value_result->serie_comprobante
					            					, ''.substr(($value_result->numero_comprobante + 100000000), 1)
						            				, $english_format_number = number_format(''.$value_result->cantidad_entrada, 2, '.', '')
						            				, $english_format_number = number_format(''.$value_result->precio_unitario_anterior, 2, '.', '')
						            				, $english_format_number = number_format(''.($value_result->cantidad_entrada*$value_result->precio_unitario_anterior), 2, '.', '')
						            				, $english_format_number = number_format(0, 2, '.', '')
						            				, $english_format_number = number_format(0, 2, '.', '')
						            				, $english_format_number = number_format(0, 2, '.', '')
						            				, $english_format_number = number_format(''.$value_result->stock_actualizado, 2, '.', '')
						            				, $english_format_number = number_format(''.$value_result->precio_unitario_actualizado, 2, '.', '')
						            				, $english_format_number = number_format(''.$value_result->stock_actualizado*$value_result->precio_unitario_actualizado, 2, '.', '')
					            				]
			        				);

							        $total_entrada_cantidad = $total_entrada_cantidad + $value_result->cantidad_entrada;
							        $total_entrada_cu = $total_entrada_cu + $value_result->precio_unitario_anterior;
							        $total_entrada_ct = $total_entrada_ct + ($value_result->cantidad_entrada*$value_result->precio_unitario_anterior);
							        $total_salida_cantidad = $total_salida_cantidad + 0;
							        $total_salida_cu = $total_salida_cu + 0;
							        $total_salida_ct = $total_salida_ct + 0;
							        $total_final_cantidad = $total_final_cantidad + $value_result->stock_actualizado;
							        $total_final_cu = $total_final_cu + $value_result->precio_unitario_actualizado;
							        $total_final_ct = $total_final_ct + $value_result->stock_actualizado*$value_result->precio_unitario_actualizado;
				            	}

				            }
				            
				            array_push($array_general,
				            				[
				            					''
				            					, ''
				            					, ''
				            					, 'TOTALES'
					            				, $english_format_number = number_format(''.$total_entrada_cantidad, 2, '.', '')
					            				, $english_format_number = number_format(''.$total_entrada_cu, 2, '.', '')
					            				, $english_format_number = number_format(''.$total_entrada_ct, 2, '.', '')
					            				, $english_format_number = number_format(''.$total_salida_cantidad, 2, '.', '')
					            				, $english_format_number = number_format(''.$total_salida_cu, 2, '.', '')
					            				, $english_format_number = number_format(''.$total_salida_ct, 2, '.', '')
					            				, $english_format_number = number_format(''.$total_final_cantidad, 2, '.', '')
					            				, $english_format_number = number_format(''.$total_final_cu, 2, '.', '')
					            				, $english_format_number = number_format(''.$total_final_ct, 2, '.', '')
				            				]);

				            // dd($array_general);
			                $sheet->fromArray($array_general, null, 'A1', false, false);
			                $sheet->mergeCells('A1:E1');
			                $sheet->mergeCells('A2:E2');
			                $sheet->mergeCells('A3:E3');
			                $sheet->mergeCells('A4:E4');
			                $sheet->mergeCells('A5:E5');
			                $sheet->mergeCells('A6:E6');
			                $sheet->mergeCells('A7:E7');
			                $sheet->mergeCells('A8:E8');
			                $sheet->mergeCells('A9:E9');
			                $sheet->mergeCells('A10:E10');

			                $sheet->mergeCells('F1:I1');
			                $sheet->mergeCells('F2:I2');
			                $sheet->mergeCells('F3:I3');
			                $sheet->mergeCells('F4:I4');
			                $sheet->mergeCells('F5:I5');
			                $sheet->mergeCells('F6:I6');
			                $sheet->mergeCells('F7:I7');
			                $sheet->mergeCells('F8:I8');
			                $sheet->mergeCells('F9:I9');
			                $sheet->mergeCells('F10:I10');

			                $sheet->mergeCells('A12:D12');
			                $sheet->mergeCells('E12:G12');
			                $sheet->mergeCells('H12:J12');
			                $sheet->mergeCells('K12:M12');

							$sheet->setBorder('A12:M'.(count($result)+count($saldo_inicial)+$no_saldo_inicial+13), 'thin');
							$sheet->setBorder('D'.(count($result)+count($saldo_inicial)+$no_saldo_inicial+14).':M'.(count($result)+count($saldo_inicial)+$no_saldo_inicial+14), 'thin');
							$sheet->setColumnFormat(array(
							    'E14:'.'M'.(count($result)+count($saldo_inicial)+$no_saldo_inicial+14) => '0.00',
							));

							$sheet->cell(('A1:M13'), function($cell){
								$cell->setFontSize(10);
								$cell->setFontFamily('Arial Narrow');
							    $cell->setFontWeight('bold');
							    $cell->setValignment('middle');
							});

							$sheet->cell('A12:M'.(count($result)+count($saldo_inicial)+$no_saldo_inicial+14), function($cell){
								$cell->setFontSize(10);
								$cell->setFontFamily('Arial Narrow');
								$cell->setAlignment('center');
							    $cell->setValignment('middle');
							});

							$sheet->setWidth('A', 10);
							$sheet->setWidth('B', 10);
							$sheet->setWidth('C', 10);
							$sheet->setWidth('D', 10);
							$sheet->setWidth('E', 10);
							$sheet->setWidth('F', 10);
							$sheet->setWidth('G', 10);
							$sheet->setWidth('H', 10);
							$sheet->setWidth('I', 10);
							$sheet->setWidth('K', 10);
							$sheet->setWidth('L', 10);
							$sheet->setWidth('M', 10);
					    });
            		}
				}
				else{
					// Our first sheet
				    $excel->sheet(substr($scope->nombre_producto, 0, 30), function($sheet) use($ultimo_dia_mes, $scope) {
		 			// Set with font color
				    	$query = "";
				    	$query = "SELECT
									kp.nombre_tipo_documento
									, p.nombre_producto
									, kp.stock_anterior
									, ROUND(kp.precio_unitario_anterior,2) AS precio_unitario_anterior
									, kp.stock_actualizado
									, ROUND(kp.precio_unitario_actualizado,2) AS precio_unitario_actualizado
									, kp.cantidad_salida
									, kp.cantidad_entrada
									, kp.fecha_registro
									, kp.serie_comprobante
									, kp.numero_comprobante
								FROM ts_kardex_producto kp
								INNER JOIN ts_producto p ON p.id = kp.id_producto";
					// dd(date("Y-m-d",strtotime($scope->fecha)));
							$query .= " WHERE kp.fecha_registro BETWEEN '".date("Y-m-d",strtotime($scope->fecha))."' AND '".$ultimo_dia_mes."'";
								$query .= " AND kp.id_producto=".$scope->id_producto;

						$query .= " ORDER BY kp.fecha_registro ASC,kp.id ASC";

			            $result = DB::select($query);
			            $array_general=[];

			            array_push($array_general,
			            				[
			            					'INVENTARIO PERMANENTE VALORIZADO', '', '', '', '', 'FT: FACTURA'
			            				],
			            				[
			            					'PERIODO: '.date("Y",strtotime($scope->fecha)), '', '', '', '', 'GR: GUÍA DE REMISIÓN'
			            				],
			            				[
			            					'RUC: 20101717098', '', '', '', '', 'BV: BOLETA DE VENTA'
			            				],
			            				[
			            					'TEJIDOS JORGITO SRL', '', '', '', '', 'NC: NOTA DE CRÉDITO'
			            				],
			            				[
			            					'CALLE LOS TELARES No 185 URB. VULCANO-ATE', '', '', '', '', 'ND: NOTA DE DÉBITO'
			            				],
			            				[
			            					'CÓDIGO', '', '', '', '', 'OS: ORDEN DE SALIDA'
			            				],
			            				[
			            					'TIPO: 03', '', '', '', '', 'OI: ORDEN DE INGRESO'
			            				],
			            				[
			            					$scope->nombre_producto, '', '', '', '', 'CU: COSTO UNITARIO (NUEVOS SOLES)'
			            				],
			            				[
			            					'UNIDAD DE MEDIDA: 01', '', '', '', '', 'CT: COSTO TOTAL (NUEVOS SOLES)'
			            				],
			            				[
			            					'MÉTODO DE EVALUACIÓN: COSTO PROMEDIO', '', '', '', '', 'SI: SALDO INICIAL'
			            				],
			            				[
			            					'', '', '', '', '', ''
			            				],
			            				[
			            					'DOCUMENTO DE MOVIMIENTO', '', '', '', 'ENTRADAS', '', '', 'SALIDAS', '', '', 'SALDO FINAL'
			            				],
			            				[
			            					'FECHA', 'TIPO', 'SERIE', 'NÚMERO', 'CANTIDAD', 'CU', 'CT', 'CANTIDAD', 'CU', 'CT', 'CANTIDAD', 'CU', 'CT'
			            				]
			            			);


				        // INICIALISANDO MONTOS TOTALES
				        $total_entrada_cantidad = 0;
				        $total_entrada_cu = 0;
				        $total_entrada_ct = 0;
				        $total_salida_cantidad = 0;
				        $total_salida_cu = 0;
				        $total_salida_ct = 0;
				        $total_final_cantidad = 0;
				        $total_final_cu = 0;
				        $total_final_ct = 0;

			             //EXTRAYENDO EL SALDO INICIAL
				        $saldo_inicial = SaldoInicial::where('id_producto',$scope->id_producto)->where('fecha_saldo', date("Y-m-d",strtotime($scope->fecha)) )->get();
						$no_saldo_inicial = 0;

				        if(count($saldo_inicial)>0){
					        foreach ($saldo_inicial as $key => $value) {
					        	array_push($array_general,
					            				[
					            					date("d-m-Y",strtotime($value->fecha_saldo))
					            					, ''
					            					, 'SI'
					            					, ''
						            				, $english_format_number = number_format(''.$value->stock_inicial, 2, '.', '')
						            				, $english_format_number = number_format(''.round($value->precio_unitario_inicial,2), 2, '.', '')
						            				, $english_format_number = number_format(''.$value->stock_inicial*round($value->precio_unitario_inicial,2), 2, '.', '')
						            				, $english_format_number = number_format(0, 2, '.', '')
						            				, $english_format_number = number_format(0, 2, '.', '')
						            				, $english_format_number = number_format(0, 2, '.', '')
						            				, $english_format_number = number_format(''.$value->stock_inicial, 2, '.', '')
						            				, $english_format_number = number_format(''.round($value->precio_unitario_inicial,2), 2, '.', '')
						            				, $english_format_number = number_format(''.$value->stock_inicial*round($value->precio_unitario_inicial,2), 2, '.', '')
					            				]
			        				);

							        $total_entrada_cantidad = $total_entrada_cantidad + $value->stock_inicial;
							        $total_entrada_cu = $total_entrada_cu + round($value->precio_unitario_inicial,2);
							        $total_entrada_ct = $total_entrada_ct + $value->stock_inicial*round($value->precio_unitario_inicial,2);
							        $total_salida_cantidad = $total_salida_cantidad + 0;
							        $total_salida_cu = $total_salida_cu + 0;
							        $total_salida_ct = $total_salida_ct + 0;
							        $total_final_cantidad = $total_final_cantidad + $value->stock_inicial;
							        $total_final_cu = $total_final_cu + round($value->precio_unitario_inicial,2);
							        $total_final_ct = $total_final_ct + $value->stock_inicial*round($value->precio_unitario_inicial,2);
					        }
				        }else{  //NO EXISTE SALDO INICIAL PARA EL PRODUCTO EN EL MES
				        	$no_saldo_inicial = 1;
				        	array_push($array_general,
					            				[
					            					date("d-m-Y",strtotime($scope->fecha))
					            					, ''
					            					, 'SI'
					            					, ''
					            					, $english_format_number = number_format(0, 2, '.', '')
					            					, $english_format_number = number_format(0, 2, '.', '')
					            					, $english_format_number = number_format(0, 2, '.', '')
					            					, $english_format_number = number_format(0, 2, '.', '')
					            					, $english_format_number = number_format(0, 2, '.', '')
					            					, $english_format_number = number_format(0, 2, '.', '')
					            					, $english_format_number = number_format(0, 2, '.', '')
					            					, $english_format_number = number_format(0, 2, '.', '')
					            					, $english_format_number = number_format(0, 2, '.', '')
					            				]
			        				);
				        }

			            foreach ($result as $key => $value) {

			            	if($value->nombre_tipo_documento === 'FT'){ //SALIDA
				            	array_push($array_general,
				            				[
				            					date("d-m-Y",strtotime($value->fecha_registro))
				            					, $value->nombre_tipo_documento
				            					, $value->serie_comprobante
				            					, substr(($value->numero_comprobante + 100000000), 1)
					            				, $english_format_number = number_format(0, 2, '.', '')
					            				, $english_format_number = number_format(0, 2, '.', '')
					            				, $english_format_number = number_format(0, 2, '.', '')
					            				, $english_format_number = number_format(''.$value->cantidad_salida, 2, '.', '')
					            				, $english_format_number = number_format(''.$value->precio_unitario_actualizado, 2, '.', '')
					            				, $english_format_number = number_format(''.($value->cantidad_salida*$value->precio_unitario_actualizado), 2, '.', '')
					            				, $english_format_number = number_format(''.$value->stock_actualizado, 2, '.', '')
					            				, $english_format_number = number_format(''.$value->precio_unitario_actualizado, 2, '.', '')
					            				, $english_format_number = number_format(''.$value->stock_actualizado*$value->precio_unitario_actualizado, 2, '.', '')
				            				]);

			        				
							        $total_entrada_cantidad = $total_entrada_cantidad + 0;
							        $total_entrada_cu = $total_entrada_cu + 0;
							        $total_entrada_ct = $total_entrada_ct + 0;
							        $total_salida_cantidad = $total_salida_cantidad + $value->cantidad_salida;
							        $total_salida_cu = $total_salida_cu + $value->precio_unitario_actualizado;
							        $total_salida_ct = $total_salida_ct + $value->cantidad_salida*$value->precio_unitario_actualizado;
							        $total_final_cantidad = $total_final_cantidad + $value->stock_actualizado;
							        $total_final_cu = $total_final_cu + $value->precio_unitario_actualizado;
							        $total_final_ct = $total_final_ct + $value->stock_actualizado*$value->precio_unitario_actualizado;
			            	}
			            	else if($value->nombre_tipo_documento === 'GR'){ //ENTRADA
			            		array_push($array_general,
				            				[
				            					date("d-m-Y",strtotime($value->fecha_registro))
				            					, $value->nombre_tipo_documento
				            					, $value->serie_comprobante
				            					, substr(($value->numero_comprobante + 100000000), 1)
					            				, $english_format_number = number_format(''.$value->cantidad_entrada, 2, '.', '')
					            				, $english_format_number = number_format(''.$value->precio_unitario_anterior, 2, '.', '')
					            				, $english_format_number = number_format(''.($value->cantidad_entrada*$value->precio_unitario_anterior), 2, '.', '')
					            				, $english_format_number = number_format(0, 2, '.', '')
					            				, $english_format_number = number_format(0, 2, '.', '')
					            				, $english_format_number = number_format(0, 2, '.', '')
					            				, $english_format_number = number_format(''.$value->stock_actualizado, 2, '.', '')
					            				, $english_format_number = number_format(''.$value->precio_unitario_actualizado, 2, '.', '')
					            				, $english_format_number = number_format(''.$value->stock_actualizado*$value->precio_unitario_actualizado, 2, '.', '')
				            				]);
			        				
							        $total_entrada_cantidad = $total_entrada_cantidad + $value->cantidad_entrada;
							        $total_entrada_cu = $total_entrada_cu + $value->precio_unitario_anterior;
							        $total_entrada_ct = $total_entrada_ct + ($value->cantidad_entrada*$value->precio_unitario_anterior);
							        $total_salida_cantidad = $total_salida_cantidad + 0;
							        $total_salida_cu = $total_salida_cu + 0;
							        $total_salida_ct = $total_salida_ct + 0;
							        $total_final_cantidad = $total_final_cantidad + $value->stock_actualizado;
							        $total_final_cu = $total_final_cu + $value->precio_unitario_actualizado;
							        $total_final_ct = $total_final_ct + $value->stock_actualizado*$value->precio_unitario_actualizado;
			            	}

			            }
			            
			            array_push($array_general,
				            				[
				            					''
				            					, ''
				            					, ''
				            					, 'TOTALES'
					            				, $english_format_number = number_format(''.$total_entrada_cantidad, 2, '.', '')
					            				, $english_format_number = number_format(''.$total_entrada_cu, 2, '.', '')
					            				, $english_format_number = number_format(''.$total_entrada_ct, 2, '.', '')
					            				, $english_format_number = number_format(''.$total_salida_cantidad, 2, '.', '')
					            				, $english_format_number = number_format(''.$total_salida_cu, 2, '.', '')
					            				, $english_format_number = number_format(''.$total_salida_ct, 2, '.', '')
					            				, $english_format_number = number_format(''.$total_final_cantidad, 2, '.', '')
					            				, $english_format_number = number_format(''.$total_final_cu, 2, '.', '')
					            				, $english_format_number = number_format(''.$total_final_ct, 2, '.', '')
				            				]);

			            // dd($array_general);
		                $sheet->fromArray($array_general, null, 'A1', false, false);

		                $sheet->mergeCells('A1:E1');
		                $sheet->mergeCells('A2:E2');
		                $sheet->mergeCells('A3:E3');
		                $sheet->mergeCells('A4:E4');
		                $sheet->mergeCells('A5:E5');
		                $sheet->mergeCells('A6:E6');
		                $sheet->mergeCells('A7:E7');
		                $sheet->mergeCells('A8:E8');
		                $sheet->mergeCells('A9:E9');
		                $sheet->mergeCells('A10:E10');

		                $sheet->mergeCells('F1:I1');
		                $sheet->mergeCells('F2:I2');
		                $sheet->mergeCells('F3:I3');
		                $sheet->mergeCells('F4:I4');
		                $sheet->mergeCells('F5:I5');
		                $sheet->mergeCells('F6:I6');
		                $sheet->mergeCells('F7:I7');
		                $sheet->mergeCells('F8:I8');
		                $sheet->mergeCells('F9:I9');
		                $sheet->mergeCells('F10:I10');

		                $sheet->mergeCells('A12:D12');
		                $sheet->mergeCells('E12:G12');
		                $sheet->mergeCells('H12:J12');
		                $sheet->mergeCells('K12:M12');

						$sheet->setBorder('A12:M'.(count($result)+count($saldo_inicial)+$no_saldo_inicial+13), 'thin');
						$sheet->setBorder('D'.(count($result)+count($saldo_inicial)+$no_saldo_inicial+14).':M'.(count($result)+count($saldo_inicial)+$no_saldo_inicial+14), 'thin');
						$sheet->setColumnFormat(array(
						    'E14:'.'M'.(count($result)+count($saldo_inicial)+$no_saldo_inicial+14) => '0.00',
						));

						$sheet->cell(('A1:M13'), function($cell){
							$cell->setFontSize(10);
							$cell->setFontFamily('Arial Narrow');
						    $cell->setFontWeight('bold');
						    $cell->setValignment('middle');
						});

						$sheet->cell('A12:M'.(count($result)+count($saldo_inicial)+$no_saldo_inicial+14), function($cell){
							$cell->setFontSize(10);
							$cell->setFontFamily('Arial Narrow');
							$cell->setAlignment('center');
						    $cell->setValignment('middle');
						});

						$sheet->setWidth('A', 10);
						$sheet->setWidth('B', 10);
						$sheet->setWidth('C', 10);
						$sheet->setWidth('D', 10);
						$sheet->setWidth('E', 10);
						$sheet->setWidth('F', 10);
						$sheet->setWidth('G', 10);
						$sheet->setWidth('H', 10);
						$sheet->setWidth('I', 10);
						$sheet->setWidth('K', 10);
						$sheet->setWidth('L', 10);
						$sheet->setWidth('M', 10);
				    });
				}


			    
	        })->export('xls');

			return \Response::json(array(
					'datos' => 'correcto'
				));	

		} catch (Exception $e) {

		}
	}



	public function getKardexNuevo($scope){
		try {

			$scope = json_decode($scope);

			$anio=date("Y",strtotime($scope->fecha)); 
			$mes=date("m",strtotime($scope->fecha)); 
			$parte_fecha=date("Y-m-",strtotime($scope->fecha)); 
			$ultimo_dia_mes = $parte_fecha.date("d",(mktime(0,0,0,$mes+1,1,$anio)-1));


			$nombre_archivo;
			if($scope->id_producto == null){
				$nombre_archivo = 'KARDEX GENERAL';
			}
			else if($scope->id_producto != null){
				$nombre_archivo = $scope->nombre_producto;
				$scope->nombre_producto = str_replace("_","/",$scope->nombre_producto);
			}
	        Excel::create($nombre_archivo, function($excel) use($ultimo_dia_mes, $scope) {
				if($scope->id_producto == null){
            		$array_productos = Producto::orderBy('ts_producto.nombre_producto')->get();

            		foreach ($array_productos as $key => $value) {
            			$value['nombre_producto'] = str_replace("[áàâãª]","a",$value['nombre_producto']);
						$value['nombre_producto'] = str_replace("[ÁÀÂÃ]","A",$value['nombre_producto']);
						$value['nombre_producto'] = str_replace("[éèê]","e",$value['nombre_producto']);
						$value['nombre_producto'] = str_replace("[ÉÈÊ]","E",$value['nombre_producto']);
						$value['nombre_producto'] = str_replace("[íìî]","i",$value['nombre_producto']);
						$value['nombre_producto'] = str_replace("[ÍÌÎ]","I",$value['nombre_producto']);
						$value['nombre_producto'] = str_replace("[óòôõº]","o",$value['nombre_producto']);
						$value['nombre_producto'] = str_replace("[ÓÒÔÕ]","O",$value['nombre_producto']);
						$value['nombre_producto'] = str_replace("[úùû]","u",$value['nombre_producto']);
						$value['nombre_producto'] = str_replace("[ÚÙÛ]","U",$value['nombre_producto']);
						$value['nombre_producto'] = str_replace(" ","-",$value['nombre_producto']);
						$value['nombre_producto'] = str_replace("ñ","n",$value['nombre_producto']);
						$value['nombre_producto'] = str_replace("Ñ","N",$value['nombre_producto']);
						$value['nombre_producto'] = str_replace("/","_",$value['nombre_producto']);
						$titulo = substr($value['nombre_producto'], 0, 30);

					    $excel->sheet($titulo, function($sheet) use($ultimo_dia_mes, $scope, $value) {

					    	$query = "";
					    	$query = "SELECT
										k.abreviatura_tipo_documento
										, k.serie_comprobante
										, k.numero_comprobante
										, p.nombre_producto
										, k.cantidad_movimiento
										, k.precio_unitario_movimiento
										, k.fecha_registro
										, k.tipo_movimiento
									FROM ts_kardex k
									INNER JOIN ts_producto p ON p.id = k.id_producto";
							$query .= " WHERE k.fecha_registro BETWEEN '".date("Y-m-d",strtotime($scope->fecha))."' AND '".$ultimo_dia_mes."'";
							$query .= " AND k.id_producto=".$value['id'];
							$query .= " ORDER BY k.fecha_registro ASC,k.abreviatura_tipo_documento DESC";

				            $result = DB::select($query);
				            $array_general=[];

				            $descripcion = str_replace("-"," ",$value['nombre_producto']);
				            $descripcion = str_replace("_","/",$descripcion);
				            array_push($array_general,
				            				[
				            					'INVENTARIO PERMANENTE VALORIZADO', '', '', '', '', 'FT: FACTURA'
				            				],
				            				[
				            					'PERIODO: '.date("Y",strtotime($scope->fecha)), '', '', '', '', 'GR: GUÍA DE REMISIÓN'
				            				],
				            				[
				            					'RUC: 20101717098', '', '', '', '', 'BV: BOLETA DE VENTA'
				            				],
				            				[
				            					'TEJIDOS JORGITO SRL', '', '', '', '', 'NC: NOTA DE CRÉDITO'
				            				],
				            				[
				            					'CALLE LOS TELARES No 185 URB. VULCANO-ATE', '', '', '', '', 'ND: NOTA DE DÉBITO'
				            				],
				            				[
				            					'CÓDIGO', '', '', '', '', 'OS: ORDEN DE SALIDA'
				            				],
				            				[
				            					'TIPO: 03', '', '', '', '', 'OI: ORDEN DE INGRESO'
				            				],
				            				[
				            					$descripcion, '', '', '', '', 'CU: COSTO UNITARIO (NUEVOS SOLES)'
				            				],
				            				[
				            					'UNIDAD DE MEDIDA: 01', '', '', '', '', 'CT: COSTO TOTAL (NUEVOS SOLES)'
				            				],
				            				[
				            					'MÉTODO DE EVALUACIÓN: COSTO PROMEDIO', '', '', '', '', 'SI: SALDO INICIAL'
				            				],
				            				[
				            					'', '', '', '', '', ''
				            				],
				            				[
				            					'DOCUMENTO DE MOVIMIENTO', '', '', '', 'ENTRADAS', '', '', 'SALIDAS', '', '', 'SALDO FINAL'
				            				],
				            				[
				            					'FECHA', 'TIPO', 'SERIE', 'NÚMERO', 'CANTIDAD', 'CU', 'CT', 'CANTIDAD', 'CU', 'CT', 'CANTIDAD', 'CU', 'CT'
				            				]
				            			);


				             //EXTRAYENDO EL SALDO INICIAL
					        $saldo_inicial = SaldoInicial::where('id_producto',$value['id'])->where('fecha_saldo', date("Y-m-d",strtotime($scope->fecha)) )->get();
							$no_saldo_inicial = 0;


							$producto_stock = 0;
							$producto_precio = 0;
					        // INICIALISANDO MONTOS TOTALES
					        $total_entrada_cantidad = 0;
					        $total_entrada_cu = 0;
					        $total_entrada_ct = 0;
					        $total_salida_cantidad = 0;
					        $total_salida_cu = 0;
					        $total_salida_ct = 0;
					        $total_final_cantidad = 0;
					        $total_final_cu = 0;
					        $total_final_ct = 0;
					        if(count($saldo_inicial)>0){
						        foreach ($saldo_inicial as $key => $value_saldo_inicial) {
						        	array_push($array_general,
					            				[
					            					date("d-m-Y",strtotime($value->fecha_saldo))
					            					, ''
					            					, 'SI'
					            					, ''
						            				, $english_format_number = number_format(''.$value_saldo_inicial->stock_inicial, 2, '.', '')
						            				, $english_format_number = number_format(''.round($value_saldo_inicial->precio_unitario_inicial,2), 2, '.', '')
						            				, $english_format_number = number_format(''.$value_saldo_inicial->stock_inicial*round($value_saldo_inicial->precio_unitario_inicial,2), 2, '.', '')
						            				, $english_format_number = number_format(0, 2, '.', '')
						            				, $english_format_number = number_format(0, 2, '.', '')
						            				, $english_format_number = number_format(0, 2, '.', '')
						            				, $english_format_number = number_format(''.$value_saldo_inicial->stock_inicial, 2, '.', '')
						            				, $english_format_number = number_format(''.round($value_saldo_inicial->precio_unitario_inicial,2), 2, '.', '')
						            				, $english_format_number = number_format(''.$value_saldo_inicial->stock_inicial*round($value_saldo_inicial->precio_unitario_inicial,2), 2, '.', '')
					            				]
			        				);


							        $total_entrada_cantidad = $total_entrada_cantidad + $value_saldo_inicial->stock_inicial;
							        $total_entrada_cu = $total_entrada_cu + round($value_saldo_inicial->precio_unitario_inicial,2);
							        $total_entrada_ct = $total_entrada_ct + $value_saldo_inicial->stock_inicial*round($value_saldo_inicial->precio_unitario_inicial,2);
							        $total_salida_cantidad = $total_salida_cantidad + 0;
							        $total_salida_cu = $total_salida_cu + 0;
							        $total_salida_ct = $total_salida_ct + 0;
							        $total_final_cantidad = $total_final_cantidad + $value_saldo_inicial->stock_inicial;
							        $total_final_cu = $total_final_cu + round($value_saldo_inicial->precio_unitario_inicial,2);
							        $total_final_ct = $total_final_ct + $value_saldo_inicial->stock_inicial*round($value_saldo_inicial->precio_unitario_inicial,2);

									$producto_stock = $value_saldo_inicial->stock_inicial;
									$producto_precio = round($value_saldo_inicial->precio_unitario_inicial,2);
						        }
					        }else{  //NO EXISTE SALDO INICIAL PARA EL PRODUCTO EN EL MES
					        	$no_saldo_inicial = 1;
					        	$producto_precio = null;
					        	array_push($array_general,
						            				[
						            					date("d-m-Y",strtotime($scope->fecha))
						            					, ''
						            					, 'SI'
						            					, ''
							            				, $english_format_number = number_format(0, 2, '.', '')
							            				, $english_format_number = number_format(0, 2, '.', '')
							            				, $english_format_number = number_format(0, 2, '.', '')
							            				, $english_format_number = number_format(0, 2, '.', '')
							            				, $english_format_number = number_format(0, 2, '.', '')
							            				, $english_format_number = number_format(0, 2, '.', '')
							            				, $english_format_number = number_format(0, 2, '.', '')
							            				, $english_format_number = number_format(0, 2, '.', '')
							            				, $english_format_number = number_format(0, 2, '.', '')
						            				]
				        				);
					        }

				            foreach ($result as $key => $value_result) {

				            	$producto_stock_anterior = $producto_stock;
				            	if($value_result->tipo_movimiento === 'SALIDA'){ //SALIDA

				            		// CALCULANDO STOCK Y PRECIO DEL PRODUCTO PARA LA SALIDA, ACA EL PRECIO NO SE MODIFICA
				            		if($producto_precio == null){
										$producto_precio = 0;
									}
				            		$producto_stock = $producto_stock - $value_result->cantidad_movimiento;

					            	array_push($array_general,
					            				[
					            					date("d-m-Y",strtotime($value_result->fecha_registro))
					            					, $value_result->abreviatura_tipo_documento
					            					, $value_result->serie_comprobante
					            					, substr(($value_result->numero_comprobante + 100000000), 1)
						            				, $english_format_number = number_format(0, 2, '.', '')
						            				, $english_format_number = number_format(0, 2, '.', '')
						            				, $english_format_number = number_format(0, 2, '.', '')
						            				, $english_format_number = number_format(''.$value_result->cantidad_movimiento, 2, '.', '')
						            				, $english_format_number = number_format(''.$value_result->precio_unitario_movimiento, 2, '.', '')
						            				, $english_format_number = number_format(''.($value_result->cantidad_movimiento*$value_result->precio_unitario_movimiento), 2, '.', '')
						            				, $english_format_number = number_format(''.$producto_stock, 2, '.', '')
						            				, $english_format_number = number_format(''.$producto_precio, 2, '.', '')
						            				, $english_format_number = number_format(''.$producto_stock*$producto_precio, 2, '.', '')
					            				]);

				        				
								        $total_entrada_cantidad = $total_entrada_cantidad + 0;
								        $total_entrada_cu = $total_entrada_cu + 0;
								        $total_entrada_ct = $total_entrada_ct + 0;
								        $total_salida_cantidad = $total_salida_cantidad + $value_result->cantidad_movimiento;
								        $total_salida_cu = $total_salida_cu + $value_result->precio_unitario_movimiento;
								        $total_salida_ct = $total_salida_ct + $value_result->cantidad_movimiento*$value_result->precio_unitario_movimiento;
								        $total_final_cantidad = $total_final_cantidad + $producto_stock;
								        $total_final_cu = $total_final_cu + $producto_precio;
								        $total_final_ct = $total_final_ct + $producto_stock*$producto_precio;
				            	}
				            	else if($value_result->tipo_movimiento === 'ENTRADA'){ //ENTRADA

				            		// SETEAR EN 0 EL PRECIO DE MOVIMIENTO NULL PORQE SE REGISTRO LA GUIA SIN PRECIO
				            		if($value_result->precio_unitario_movimiento == null){
				            			$value_result->precio_unitario_movimiento = 0;
				            		}

				            		// CALCULANDO STOCK Y PRECIO DEL PRODUCTO PARA LA ENTRADA
				            		if($producto_precio == null){
										$producto_precio = $value_result->precio_unitario_movimiento;
									}
									else{
										$producto_precio = ( ($producto_precio)*($producto_stock) + ($value_result->precio_unitario_movimiento*$value_result->cantidad_movimiento) )/( ($producto_stock)+($value_result->cantidad_movimiento));
									}
				            		$producto_stock = $producto_stock + $value_result->cantidad_movimiento;
				            		
				            		array_push($array_general,
					            				[
					            					date("d-m-Y",strtotime($value_result->fecha_registro))
					            					, $value_result->abreviatura_tipo_documento
					            					, $value_result->serie_comprobante
					            					, substr(($value_result->numero_comprobante + 100000000), 1)
						            				, $english_format_number = number_format(''.$value_result->cantidad_movimiento, 2, '.', '')
						            				, $english_format_number = number_format(''.$value_result->precio_unitario_movimiento, 2, '.', '')
						            				, $english_format_number = number_format(''.($value_result->cantidad_movimiento*$value_result->precio_unitario_movimiento), 2, '.', '')
						            				, $english_format_number = number_format(0, 2, '.', '')
						            				, $english_format_number = number_format(0, 2, '.', '')
						            				, $english_format_number = number_format(0, 2, '.', '')
						            				, $english_format_number = number_format(''.$producto_stock, 2, '.', '')
						            				, $english_format_number = number_format(''.$producto_precio, 2, '.', '')
						            				, $english_format_number = number_format(''.$producto_stock*$producto_precio, 2, '.', '')
					            				]);
				        				
								        $total_entrada_cantidad = $total_entrada_cantidad + $value_result->cantidad_movimiento;
								        $total_entrada_cu = $total_entrada_cu + $value_result->precio_unitario_movimiento;
								        $total_entrada_ct = $total_entrada_ct + ($value_result->cantidad_movimiento*$value_result->precio_unitario_movimiento);
								        $total_salida_cantidad = $total_salida_cantidad + 0;
								        $total_salida_cu = $total_salida_cu + 0;
								        $total_salida_ct = $total_salida_ct + 0;
								        $total_final_cantidad = $total_final_cantidad + $producto_stock;
								        $total_final_cu = $total_final_cu + $producto_precio;
								        $total_final_ct = $total_final_ct + $producto_stock*$producto_precio;
				            	}

				            }
				            
				            array_push($array_general,
				            				[
				            					''
				            					, ''
				            					, ''
				            					, 'TOTALES'
					            				, $english_format_number = number_format(''.$total_entrada_cantidad, 2, '.', '')
					            				, $english_format_number = number_format(''.$total_entrada_cu, 2, '.', '')
					            				, $english_format_number = number_format(''.$total_entrada_ct, 2, '.', '')
					            				, $english_format_number = number_format(''.$total_salida_cantidad, 2, '.', '')
					            				, $english_format_number = number_format(''.$total_salida_cu, 2, '.', '')
					            				, $english_format_number = number_format(''.$total_salida_ct, 2, '.', '')
					            				, $english_format_number = number_format(''.$total_final_cantidad, 2, '.', '')
					            				, $english_format_number = number_format(''.$total_final_cu, 2, '.', '')
					            				, $english_format_number = number_format(''.$total_final_ct, 2, '.', '')
				            				]);

				            // dd($array_general);
			                $sheet->fromArray($array_general, null, 'A1', false, false);
			                $sheet->mergeCells('A1:E1');
			                $sheet->mergeCells('A2:E2');
			                $sheet->mergeCells('A3:E3');
			                $sheet->mergeCells('A4:E4');
			                $sheet->mergeCells('A5:E5');
			                $sheet->mergeCells('A6:E6');
			                $sheet->mergeCells('A7:E7');
			                $sheet->mergeCells('A8:E8');
			                $sheet->mergeCells('A9:E9');
			                $sheet->mergeCells('A10:E10');

			                $sheet->mergeCells('F1:I1');
			                $sheet->mergeCells('F2:I2');
			                $sheet->mergeCells('F3:I3');
			                $sheet->mergeCells('F4:I4');
			                $sheet->mergeCells('F5:I5');
			                $sheet->mergeCells('F6:I6');
			                $sheet->mergeCells('F7:I7');
			                $sheet->mergeCells('F8:I8');
			                $sheet->mergeCells('F9:I9');
			                $sheet->mergeCells('F10:I10');

			                $sheet->mergeCells('A12:D12');
			                $sheet->mergeCells('E12:G12');
			                $sheet->mergeCells('H12:J12');
			                $sheet->mergeCells('K12:M12');

							$sheet->setBorder('A12:M'.(count($result)+count($saldo_inicial)+$no_saldo_inicial+13), 'thin');
							$sheet->setBorder('D'.(count($result)+count($saldo_inicial)+$no_saldo_inicial+14).':M'.(count($result)+count($saldo_inicial)+$no_saldo_inicial+14), 'thin');
							$sheet->setColumnFormat(array(
							    'E14:'.'M'.(count($result)+count($saldo_inicial)+$no_saldo_inicial+14) => '0.00',
							));

							$sheet->cell(('A1:M13'), function($cell){
								$cell->setFontSize(10);
								$cell->setFontFamily('Arial Narrow');
							    $cell->setFontWeight('bold');
							    $cell->setValignment('middle');
							});

							$sheet->cell('A12:M'.(count($result)+count($saldo_inicial)+$no_saldo_inicial+14), function($cell){
								$cell->setFontSize(10);
								$cell->setFontFamily('Arial Narrow');
								$cell->setAlignment('center');
							    $cell->setValignment('middle');
							});

							$sheet->setWidth('A', 10);
							$sheet->setWidth('B', 10);
							$sheet->setWidth('C', 10);
							$sheet->setWidth('D', 10);
							$sheet->setWidth('E', 10);
							$sheet->setWidth('F', 10);
							$sheet->setWidth('G', 10);
							$sheet->setWidth('H', 10);
							$sheet->setWidth('I', 10);
							$sheet->setWidth('K', 10);
							$sheet->setWidth('L', 10);
							$sheet->setWidth('M', 10);
					    });
            		}
				}
				else{
					$titulo = $scope->nombre_producto;
	    			$titulo = str_replace("[áàâãª]","a",$titulo);
					$titulo = str_replace("[ÁÀÂÃ]","A",$titulo);
					$titulo = str_replace("[éèê]","e",$titulo);
					$titulo = str_replace("[ÉÈÊ]","E",$titulo);
					$titulo = str_replace("[íìî]","i",$titulo);
					$titulo = str_replace("[ÍÌÎ]","I",$titulo);
					$titulo = str_replace("[óòôõº]","o",$titulo);
					$titulo = str_replace("[ÓÒÔÕ]","O",$titulo);
					$titulo = str_replace("[úùû]","u",$titulo);
					$titulo = str_replace("[ÚÙÛ]","U",$titulo);
					$titulo = str_replace(" ","-",$titulo);
					$titulo = str_replace("ñ","n",$titulo);
					$titulo = str_replace("Ñ","N",$titulo);
					$titulo = str_replace("/","_",$titulo);
					$titulo = substr($titulo, 0, 30);
					// Our first sheet
				    $excel->sheet(substr($titulo, 0, 30), function($sheet) use($ultimo_dia_mes, $scope) {
		 			// Set with font color
				    	$query = "";
				    	$query = "SELECT
									k.abreviatura_tipo_documento
									, k.serie_comprobante
									, k.numero_comprobante
									, p.nombre_producto
									, k.cantidad_movimiento
									, k.precio_unitario_movimiento
									, k.fecha_registro
									, k.tipo_movimiento
								FROM ts_kardex k
								INNER JOIN ts_producto p ON p.id = k.id_producto";
						$query .= " WHERE k.fecha_registro BETWEEN '".date("Y-m-d",strtotime($scope->fecha))."' AND '".$ultimo_dia_mes."'";
						$query .= " AND k.id_producto=".$scope->id_producto;
						$query .= " ORDER BY k.fecha_registro ASC,k.abreviatura_tipo_documento DESC";

			            $result = DB::select($query);
			            $array_general=[];

			            array_push($array_general,
			            				[
			            					'INVENTARIO PERMANENTE VALORIZADO', '', '', '', '', 'FT: FACTURA'
			            				],
			            				[
			            					'PERIODO: '.date("Y",strtotime($scope->fecha)), '', '', '', '', 'GR: GUÍA DE REMISIÓN'
			            				],
			            				[
			            					'RUC: 20101717098', '', '', '', '', 'BV: BOLETA DE VENTA'
			            				],
			            				[
			            					'TEJIDOS JORGITO SRL', '', '', '', '', 'NC: NOTA DE CRÉDITO'
			            				],
			            				[
			            					'CALLE LOS TELARES No 185 URB. VULCANO-ATE', '', '', '', '', 'ND: NOTA DE DÉBITO'
			            				],
			            				[
			            					'CÓDIGO', '', '', '', '', 'OS: ORDEN DE SALIDA'
			            				],
			            				[
			            					'TIPO: 03', '', '', '', '', 'OI: ORDEN DE INGRESO'
			            				],
			            				[
			            					$scope->nombre_producto, '', '', '', '', 'CU: COSTO UNITARIO (NUEVOS SOLES)'
			            				],
			            				[
			            					'UNIDAD DE MEDIDA: 01', '', '', '', '', 'CT: COSTO TOTAL (NUEVOS SOLES)'
			            				],
			            				[
			            					'MÉTODO DE EVALUACIÓN: COSTO PROMEDIO', '', '', '', '', 'SI: SALDO INICIAL'
			            				],
			            				[
			            					'', '', '', '', '', ''
			            				],
			            				[
			            					'DOCUMENTO DE MOVIMIENTO', '', '', '', 'ENTRADAS', '', '', 'SALIDAS', '', '', 'SALDO FINAL'
			            				],
			            				[
			            					'FECHA', 'TIPO', 'SERIE', 'NÚMERO', 'CANTIDAD', 'CU', 'CT', 'CANTIDAD', 'CU', 'CT', 'CANTIDAD', 'CU', 'CT'
			            				]
			            			);


				        // INICIALISANDO MONTOS TOTALES
				        $total_entrada_cantidad = 0;
				        $total_entrada_cu = 0;
				        $total_entrada_ct = 0;
				        $total_salida_cantidad = 0;
				        $total_salida_cu = 0;
				        $total_salida_ct = 0;
				        $total_final_cantidad = 0;
				        $total_final_cu = 0;
				        $total_final_ct = 0;

			             //EXTRAYENDO EL SALDO INICIAL
				        $saldo_inicial = SaldoInicial::where('id_producto',$scope->id_producto)->where('fecha_saldo', date("Y-m-d",strtotime($scope->fecha)) )->get();
						$no_saldo_inicial = 0;

						$producto_stock = 0;
						$producto_precio = 0;
				        if(count($saldo_inicial)>0){
					        foreach ($saldo_inicial as $key => $value_saldo_inicial) {
					        	array_push($array_general,
					            				[
					            					date("d-m-Y",strtotime($value_saldo_inicial->fecha_saldo))
					            					, ''
					            					, 'SI'
					            					, ''
						            				, $english_format_number = number_format(''.$value_saldo_inicial->stock_inicial, 2, '.', '')
						            				, $english_format_number = number_format(''.round($value_saldo_inicial->precio_unitario_inicial,2), 2, '.', '')
						            				, $english_format_number = number_format(''.$value_saldo_inicial->stock_inicial*round($value_saldo_inicial->precio_unitario_inicial,2), 2, '.', '')
						            				, $english_format_number = number_format(0, 2, '.', '')
						            				, $english_format_number = number_format(0, 2, '.', '')
						            				, $english_format_number = number_format(0, 2, '.', '')
						            				, $english_format_number = number_format(''.$value_saldo_inicial->stock_inicial, 2, '.', '')
						            				, $english_format_number = number_format(''.round($value_saldo_inicial->precio_unitario_inicial,2), 2, '.', '')
						            				, $english_format_number = number_format(''.$value_saldo_inicial->stock_inicial*round($value_saldo_inicial->precio_unitario_inicial,2), 2, '.', '')
					            				]
			        				);

							        $total_entrada_cantidad = $total_entrada_cantidad + $value_saldo_inicial->stock_inicial;
							        $total_entrada_cu = $total_entrada_cu + round($value_saldo_inicial->precio_unitario_inicial,2);
							        $total_entrada_ct = $total_entrada_ct + $value_saldo_inicial->stock_inicial*round($value_saldo_inicial->precio_unitario_inicial,2);
							        $total_salida_cantidad = $total_salida_cantidad + 0;
							        $total_salida_cu = $total_salida_cu + 0;
							        $total_salida_ct = $total_salida_ct + 0;
							        $total_final_cantidad = $total_final_cantidad + $value_saldo_inicial->stock_inicial;
							        $total_final_cu = $total_final_cu + round($value_saldo_inicial->precio_unitario_inicial,2);
							        $total_final_ct = $total_final_ct + $value_saldo_inicial->stock_inicial*round($value_saldo_inicial->precio_unitario_inicial,2);

									$producto_stock = $value_saldo_inicial->stock_inicial;
									$producto_precio = round($value_saldo_inicial->precio_unitario_inicial,2);
					        }
				        }else{  //NO EXISTE SALDO INICIAL PARA EL PRODUCTO EN EL MES
				        	$no_saldo_inicial = 1;
				        	$producto_precio = null;
				        	array_push($array_general,
					            				[
					            					date("d-m-Y",strtotime($scope->fecha))
					            					, ''
					            					, 'SI'
					            					, ''
					            					, $english_format_number = number_format(0, 2, '.', '')
					            					, $english_format_number = number_format(0, 2, '.', '')
					            					, $english_format_number = number_format(0, 2, '.', '')
					            					, $english_format_number = number_format(0, 2, '.', '')
					            					, $english_format_number = number_format(0, 2, '.', '')
					            					, $english_format_number = number_format(0, 2, '.', '')
					            					, $english_format_number = number_format(0, 2, '.', '')
					            					, $english_format_number = number_format(0, 2, '.', '')
					            					, $english_format_number = number_format(0, 2, '.', '')
					            				]
			        				);
				        }

			            foreach ($result as $key => $value_result) {

			            	$producto_stock_anterior = $producto_stock;
			            	if($value_result->tipo_movimiento === 'SALIDA'){ //SALIDA

			            		// CALCULANDO STOCK Y PRECIO DEL PRODUCTO PARA LA SALIDA, ACA EL PRECIO NO SE MODIFICA
			            		if($producto_precio == null){
									$producto_precio = 0;
								}
			            		$producto_stock = $producto_stock - $value_result->cantidad_movimiento;

				            	array_push($array_general,
				            				[
				            					date("d-m-Y",strtotime($value_result->fecha_registro))
				            					, $value_result->abreviatura_tipo_documento
				            					, $value_result->serie_comprobante
				            					, substr(($value_result->numero_comprobante + 100000000), 1)
					            				, $english_format_number = number_format(0, 2, '.', '')
					            				, $english_format_number = number_format(0, 2, '.', '')
					            				, $english_format_number = number_format(0, 2, '.', '')
					            				, $english_format_number = number_format(''.$value_result->cantidad_movimiento, 2, '.', '')
					            				, $english_format_number = number_format(''.$value_result->precio_unitario_movimiento, 2, '.', '')
					            				, $english_format_number = number_format(''.($value_result->cantidad_movimiento*$value_result->precio_unitario_movimiento), 2, '.', '')
					            				, $english_format_number = number_format(''.$producto_stock, 2, '.', '')
					            				, $english_format_number = number_format(''.$producto_precio, 2, '.', '')
					            				, $english_format_number = number_format(''.$producto_stock*$producto_precio, 2, '.', '')
				            				]);

			        				
							        $total_entrada_cantidad = $total_entrada_cantidad + 0;
							        $total_entrada_cu = $total_entrada_cu + 0;
							        $total_entrada_ct = $total_entrada_ct + 0;
							        $total_salida_cantidad = $total_salida_cantidad + $value_result->cantidad_movimiento;
							        $total_salida_cu = $total_salida_cu + $value_result->precio_unitario_movimiento;
							        $total_salida_ct = $total_salida_ct + $value_result->cantidad_movimiento*$value_result->precio_unitario_movimiento;
							        $total_final_cantidad = $total_final_cantidad + $producto_stock;
							        $total_final_cu = $total_final_cu + $producto_precio;
							        $total_final_ct = $total_final_ct + $producto_stock*$producto_precio;
			            	}
			            	else if($value_result->tipo_movimiento === 'ENTRADA'){ //ENTRADA

			            		// SETEAR EN 0 EL PRECIO DE MOVIMIENTO NULL PORQE SE REGISTRO LA GUIA SIN PRECIO
			            		if($value_result->precio_unitario_movimiento == null){
			            			$value_result->precio_unitario_movimiento = 0;
			            		}
			            		
			            		// CALCULANDO STOCK Y PRECIO DEL PRODUCTO PARA LA ENTRADA
			            		if($producto_precio == null){
									$producto_precio = $value_result->precio_unitario_movimiento;
								}
								else{
									$producto_precio = ( ($producto_precio)*($producto_stock) + ($value_result->precio_unitario_movimiento*$value_result->cantidad_movimiento) )/( ($producto_stock)+($value_result->cantidad_movimiento));
								}
			            		$producto_stock = $producto_stock + $value_result->cantidad_movimiento;


			            		array_push($array_general,
				            				[
				            					date("d-m-Y",strtotime($value_result->fecha_registro))
				            					, $value_result->abreviatura_tipo_documento
				            					, $value_result->serie_comprobante
				            					, substr(($value_result->numero_comprobante + 100000000), 1)
					            				, $english_format_number = number_format(''.$value_result->cantidad_movimiento, 2, '.', '')
					            				, $english_format_number = number_format(''.$value_result->precio_unitario_movimiento, 2, '.', '')
					            				, $english_format_number = number_format(''.($value_result->cantidad_movimiento*$value_result->precio_unitario_movimiento), 2, '.', '')
					            				, $english_format_number = number_format(0, 2, '.', '')
					            				, $english_format_number = number_format(0, 2, '.', '')
					            				, $english_format_number = number_format(0, 2, '.', '')
					            				, $english_format_number = number_format(''.$producto_stock, 2, '.', '')
					            				, $english_format_number = number_format(''.$producto_precio, 2, '.', '')
					            				, $english_format_number = number_format(''.$producto_stock*$producto_precio, 2, '.', '')
				            				]);
			        				
							        $total_entrada_cantidad = $total_entrada_cantidad + $value_result->cantidad_movimiento;
							        $total_entrada_cu = $total_entrada_cu + $value_result->precio_unitario_movimiento;
							        $total_entrada_ct = $total_entrada_ct + ($value_result->cantidad_movimiento*$value_result->precio_unitario_movimiento);
							        $total_salida_cantidad = $total_salida_cantidad + 0;
							        $total_salida_cu = $total_salida_cu + 0;
							        $total_salida_ct = $total_salida_ct + 0;
							        $total_final_cantidad = $total_final_cantidad + $producto_stock;
							        $total_final_cu = $total_final_cu + $producto_precio;
							        $total_final_ct = $total_final_ct + $producto_stock*$producto_precio;
			            	}

			            }
			            
			            array_push($array_general,
				            				[
				            					''
				            					, ''
				            					, ''
				            					, 'TOTALES'
					            				, $english_format_number = number_format(''.$total_entrada_cantidad, 2, '.', '')
					            				, $english_format_number = number_format(''.$total_entrada_cu, 2, '.', '')
					            				, $english_format_number = number_format(''.$total_entrada_ct, 2, '.', '')
					            				, $english_format_number = number_format(''.$total_salida_cantidad, 2, '.', '')
					            				, $english_format_number = number_format(''.$total_salida_cu, 2, '.', '')
					            				, $english_format_number = number_format(''.$total_salida_ct, 2, '.', '')
					            				, $english_format_number = number_format(''.$total_final_cantidad, 2, '.', '')
					            				, $english_format_number = number_format(''.$total_final_cu, 2, '.', '')
					            				, $english_format_number = number_format(''.$total_final_ct, 2, '.', '')
				            				]);

			            // dd($array_general);
		                $sheet->fromArray($array_general, null, 'A1', false, false);

		                $sheet->mergeCells('A1:E1');
		                $sheet->mergeCells('A2:E2');
		                $sheet->mergeCells('A3:E3');
		                $sheet->mergeCells('A4:E4');
		                $sheet->mergeCells('A5:E5');
		                $sheet->mergeCells('A6:E6');
		                $sheet->mergeCells('A7:E7');
		                $sheet->mergeCells('A8:E8');
		                $sheet->mergeCells('A9:E9');
		                $sheet->mergeCells('A10:E10');

		                $sheet->mergeCells('F1:I1');
		                $sheet->mergeCells('F2:I2');
		                $sheet->mergeCells('F3:I3');
		                $sheet->mergeCells('F4:I4');
		                $sheet->mergeCells('F5:I5');
		                $sheet->mergeCells('F6:I6');
		                $sheet->mergeCells('F7:I7');
		                $sheet->mergeCells('F8:I8');
		                $sheet->mergeCells('F9:I9');
		                $sheet->mergeCells('F10:I10');

		                $sheet->mergeCells('A12:D12');
		                $sheet->mergeCells('E12:G12');
		                $sheet->mergeCells('H12:J12');
		                $sheet->mergeCells('K12:M12');

						$sheet->setBorder('A12:M'.(count($result)+count($saldo_inicial)+$no_saldo_inicial+13), 'thin');
						$sheet->setBorder('D'.(count($result)+count($saldo_inicial)+$no_saldo_inicial+14).':M'.(count($result)+count($saldo_inicial)+$no_saldo_inicial+14), 'thin');
						$sheet->setColumnFormat(array(
						    'E14:'.'M'.(count($result)+count($saldo_inicial)+$no_saldo_inicial+14) => '0.00',
						));

						$sheet->cell(('A1:M13'), function($cell){
							$cell->setFontSize(10);
							$cell->setFontFamily('Arial Narrow');
						    $cell->setFontWeight('bold');
						    $cell->setValignment('middle');
						});

						$sheet->cell('A12:M'.(count($result)+count($saldo_inicial)+$no_saldo_inicial+14), function($cell){
							$cell->setFontSize(10);
							$cell->setFontFamily('Arial Narrow');
							$cell->setAlignment('center');
						    $cell->setValignment('middle');
						});

						$sheet->setWidth('A', 10);
						$sheet->setWidth('B', 10);
						$sheet->setWidth('C', 10);
						$sheet->setWidth('D', 10);
						$sheet->setWidth('E', 10);
						$sheet->setWidth('F', 10);
						$sheet->setWidth('G', 10);
						$sheet->setWidth('H', 10);
						$sheet->setWidth('I', 10);
						$sheet->setWidth('K', 10);
						$sheet->setWidth('L', 10);
						$sheet->setWidth('M', 10);
				    });
				}


			    
	        })->export('xls');

			return \Response::json(array(
					'datos' => 'correcto'
				));	

		} catch (Exception $e) {

		}
	}

}
