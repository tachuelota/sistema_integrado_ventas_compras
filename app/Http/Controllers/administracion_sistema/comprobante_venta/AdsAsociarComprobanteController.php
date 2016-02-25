<?php namespace App\Http\Controllers\administracion_sistema\comprobante_venta;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\ComprobanteVenta;
use App\Models\ComprobanteCompra;
use App\Models\ComprobanteDetalleCompra;
use App\Models\ComprobanteServicio;
use App\Models\ComprobanteDetalleServicio;
use App\Models\AsociarComprobante;

use Illuminate\Support\Facades\DB;

class AdsAsociarComprobanteController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
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
		// DB::transaction(function(){
		try {
			DB::beginTransaction();


			$comprobante_compra = $request->get('comprobante_compra');
			$comprobante_servicio = $request->get('comprobante_servicio');
			// dd($comprobante_servicio);
			foreach ($comprobante_compra as $key1 => $value1) {

				$asociar = new AsociarComprobante;
				$asociar->id_comprobanteVenta = $value1['id_comprobanteVenta'];
				$asociar->id_comprobanteCompra = $value1['id_comprobanteCompra'];
				$asociar->id_producto = $value1['id_producto'];
				$asociar->precio_compra = $value1['precio_compra'];
				$asociar->cantidad_compra = $value1['cantidad_compra'];
				$asociar->precio_venta = $value1['precio_venta'];
				$asociar->cantidad_venta = $value1['cantidad_venta'];
				$asociar->save();
				$id_cabecera = $asociar->id;

				$compra = ComprobanteDetalleCompra::find($value1['id_comprobanteDetalleCompra']);
				$compra->indicador_asociado = 'false';
				$compra->save();
				
				foreach ($comprobante_servicio as $key2 => $value2) {
					if($value1['id_producto'] == $value2['id_producto']){
						$AsociarComprobante = AsociarComprobante::find($id_cabecera);
						$AsociarComprobante->id_comprobanteServicio =  $value2['id_comprobanteServicio'];
						$AsociarComprobante->precio_servicio =  $value2['precio_servicio'];
						$AsociarComprobante->cantidad_servicio =  $value2['cantidad_servicio'];
						$AsociarComprobante->save();

						$servicio = ComprobanteDetalleServicio::find($value2['id_comprobanteDetalleServicio']);
						$servicio->indicador_asociado = 'false';
						$servicio->save();
					}
				}
			}


			DB::commit();

			return \Response::json(array(
					'datos' => 'correcto'
				));	

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
	public function update($id, Request $request)
	{
		$nuevo = ComprobanteVenta::find($id);
		$nuevo->serie_retenedor = $request->get('serie');
		$nuevo->numero_retenedor = $request->get('numero');
		$nuevo->save();
		
        return \Response::json(array(
					'datos' => 'correcto'
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
	}

	public function AsociarRetenedor($id)
	{
		//
	}

}
