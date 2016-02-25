<?php namespace App\Http\Controllers\administracion_sistema\comprobante_servicio;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\ComprobanteServicio;
use App\Models\ComprobanteDetalleServicio;
use App\Models\Producto;

use Illuminate\Support\Facades\DB;

class AdsComprobanteServicioController extends Controller {

	public function __construct()
	{
		$this->middleware('auth');  
	}

	public function index()
	{
		return view('administracion_sistema/comprobante_servicio/main');
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
		return view('administracion_sistema/comprobante_servicio/create_comprobanteServicio');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{

		$tipo_cambio_compra_hoy = DB::table('ts_tipocambiomoneda')->where('fecha', date("Y-m-d"))->pluck('valor_venta');
		$id_igv = DB::table('ts_igv')->where('estado', 'true')->pluck('id');
		$incluido_igv_activo = DB::table('ts_igv')->where('estado', 'true')->pluck('valor_igv');

		// DB::transaction(function(){
		try {
			DB::beginTransaction();


			$cabecera = $request->get('cabecera');

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
				$boolean_incluido_igv;
				if($cabecera['incluido_igv'] === 'undefined' || $cabecera['incluido_igv'] === null)
				{
					$boolean_incluido_igv = false;
				} 
				else{
					$boolean_incluido_igv = $cabecera['incluido_igv'];
				}
				// dd($cabecera);
				$nuevaCabecera = new ComprobanteServicio;
				$nuevaCabecera->id_tipoComprobante = 3;
				$nuevaCabecera->serie_comprobante = $cabecera['serie'];
				$nuevaCabecera->numero_comprobante = $cabecera['numero'];
				$nuevaCabecera->fecha = $cabecera['fecha'];
				$nuevaCabecera->id_moneda = $cabecera['moneda']['id'];
				$nuevaCabecera->id_proveedor = $cabecera['cliente']['id'];
				$nuevaCabecera->id_igv = $id_igv;
				$nuevaCabecera->indicador_asociado = 'true';
				// $nuevaCabecera->estado_igv = json_encode($boolean_incluido_igv);
				$nuevaCabecera->total_comprobante = $cabecera['total'];
				$nuevaCabecera->id_tipoServicio = $cabecera['tipo_servicio']['id'];
				$nuevaCabecera->monto_detraccion = $cabecera['detraccion'];
				$nuevaCabecera->save();
				$id_cabecera = $nuevaCabecera->id;

				$detalle = $request->get('detalle');

				foreach ($detalle as $key => $value) {
					
					$nuevaDetalle = new ComprobanteDetalleServicio;
					$nuevaDetalle->id_comprobanteServicio = $id_cabecera;
					$nuevaDetalle->id_producto = $value['id_producto'];
					$nuevaDetalle->unidad_medida = 1; //ID UNIDAD MEDIDA ES 1 PARA KLOGRAMO
					$nuevaDetalle->unidades = $value['cantidad'];
					$nuevaDetalle->precio = $value['precio'];
					$nuevaDetalle->id_detalleTipoServicio = $value['id_detalle_tipo_servicio'];
					$nuevaDetalle->id_color = $value['id_color'];
					$nuevaDetalle->save();

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
        return \Response::json(array(
            'datos' => ComprobanteCompra::with(['ComprobanteDetalleCompra.Producto','Moneda','Proveedor','Igv'])->get()
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
		// dd($request->get('comprobante_servicio')['serie']);
        return \Response::json(array(
            'datos' => ComprobanteServicio::with(['ComprobanteDetalleServicio.Producto','Moneda','Proveedor','Igv'])->where('ts_comprobanteservicio.serie_comprobante','=',$request->get('comprobante_servicio')['serie'])->where('ts_comprobanteservicio.numero_comprobante','=',$request->get('comprobante_servicio')['numero'])->get()
        ));
	}

}
