<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::get('/','MainController@index');
Route::get('home','MainController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);


//Pagina Principal
//Route::get('/', 'LoginController@index');
//Main Vista
Route::get('main', 'MainController@index');

Route::get('cargar_llave', function(){
	return view('reading');
});

Route::post('PtvCliente/getDirecFiscal','administracion_sistema\cliente\AdsClienteController@getDirecFiscal');
Route::get('PtvCliente/getAllClientes','administracion_sistema\cliente\AdsClienteController@getAll');
Route::resource('PtvCliente','administracion_sistema\cliente\AdsClienteController');


Route::get('AdsTransporte/getAllTransportes','administracion_sistema\transporte\AdsTransporteController@getAll');
Route::resource('AdsTransporte','administracion_sistema\transporte\AdsTransporteController');


Route::get('AdsUnidadTransporte/getAllUnidadTransportesByEmpresa/{id_empresa}','administracion_sistema\unidad_transporte\AdsUnidadTransporteController@getAllByEmpresa');
Route::get('AdsUnidadTransporte/getAllUnidadTransportes','administracion_sistema\unidad_transporte\AdsUnidadTransporteController@getAll');
Route::resource('AdsUnidadTransporte','administracion_sistema\unidad_transporte\AdsUnidadTransporteController');

Route::get('AdsPersonalTransporte/getAllPersonalTransportesByEmpresa/{id_empresa}','administracion_sistema\personal_transporte\AdsPersonalTransporteController@getAllByEmpresa');
Route::get('AdsPersonalTransporte/getAllPersonalTransportes','administracion_sistema\personal_transporte\AdsPersonalTransporteController@getAll');
Route::resource('AdsPersonalTransporte','administracion_sistema\personal_transporte\AdsPersonalTransporteController');


Route::get('AdsUnidadMedida/getAllUnidadMedida','administracion_sistema\unidad_medida\AdsUnidadMedidaController@getAll');
Route::resource('AdsUnidadMedida','administracion_sistema\unidad_medida\AdsUnidadMedidaController');

Route::get('excel', 'administracion_sistema\producto\AdsProductoController@exportExcel');
Route::post('AdsProducto/UploadImage', 'administracion_sistema\producto\AdsProductoController@uploadImage');
Route::get('AdsProducto/getAllProductos','administracion_sistema\producto\AdsProductoController@getAll');
Route::get('AdsProducto_Kardex_create','administracion_sistema\producto\AdsProductoController@create_kardex');
Route::get('AdsProducto_CierreMensual','administracion_sistema\producto\AdsProductoController@create_cierre_mensual');
Route::get('AdsProducto/getKardex/{q}','administracion_sistema\producto\AdsProductoController@getKardex');
Route::get('AdsProducto/getKardexNuevo/{q}','administracion_sistema\producto\AdsProductoController@getKardexNuevo');
Route::post('AdsProducto/cierre_mensual','administracion_sistema\producto\AdsProductoController@cierre_mensual');
Route::resource('AdsProducto','administracion_sistema\producto\AdsProductoController');

Route::get('AdsTipoComprobante/getAllTipoComprobantes','administracion_sistema\tipoComprobante\AdsTipoComprobanteController@getAll');
Route::resource('AdsTipoComprobante','administracion_sistema\tipoComprobante\AdsTipoComprobanteController');

Route::post('AdsComprobanteCompra/validar_tipoCambio','administracion_sistema\comprobante\AdsComprobanteCompraController@validar_tipoCambio');
Route::post('AdsComprobanteCompra/imprimir','administracion_sistema\comprobante\AdsComprobanteCompraController@imprimir');
Route::post('AdsComprobanteCompra/getGuiaBySerieNumero','administracion_sistema\comprobante\AdsComprobanteCompraController@getRowBySerieNumero');
Route::post('AdsComprobanteCompra/getFacturaBySerieNumero','administracion_sistema\comprobante\AdsComprobanteCompraController@getRowBySerieNumero');
Route::get('AdsComprobanteCompra/getAllComprobantes','administracion_sistema\comprobante\AdsComprobanteCompraController@getAll');
Route::get('AdsComprobanteCompra_create','administracion_sistema\comprobante\AdsComprobanteCompraController@create');
Route::resource('AdsComprobanteCompra','administracion_sistema\comprobante\AdsComprobanteCompraController');

Route::get('AdsComprobanteVenta/getReporteVentaMensual2013','administracion_sistema\comprobante_venta\AdsComprobanteVentaController@getReporteVentaMensual2013');
Route::get('AdsComprobanteVenta/getReporteVentaMensual2014','administracion_sistema\comprobante_venta\AdsComprobanteVentaController@getReporteVentaMensual2014');
Route::get('AdsComprobanteVenta/getReporteVentaMensual2015','administracion_sistema\comprobante_venta\AdsComprobanteVentaController@getReporteVentaMensual2015');
Route::get('AdsComprobanteVenta/ventas_2013/{q}','administracion_sistema\comprobante_venta\AdsComprobanteVentaController@ventas_2013');
Route::get('AdsComprobanteVenta/getAllEstadoLetra','administracion_sistema\comprobante_venta\AdsEstadoLetraController@getAll');
Route::get('AdsComprobanteVenta/getAllEstadoContado','administracion_sistema\comprobante_venta\AdsEstadoLetraController@getAllContado');
Route::get('AdsComprobanteVenta/getAllMedioPago','administracion_sistema\comprobante_venta\AdsMedioPagoController@getAll');
Route::get('AdsComprobanteVenta/getAllCondicionPago','administracion_sistema\comprobante_venta\AdsCondicionPagoController@getAll');
Route::post('AdsComprobanteVenta/validar_tipoCambio','administracion_sistema\comprobante_venta\AdsComprobanteVentaController@validar_tipoCambio');
Route::post('AdsComprobanteVenta/imprimir','administracion_sistema\comprobante_venta\AdsComprobanteVentaController@imprimir');
Route::post('AdsComprobanteVenta/getFacturaBySerieNumero','administracion_sistema\comprobante_venta\AdsComprobanteVentaController@getRowBySerieNumero');
Route::get('AdsComprobanteVenta/getAllComprobantes','administracion_sistema\comprobante_venta\AdsComprobanteVentaController@getAll');
Route::get('AdsComprobanteVenta_Reporte','administracion_sistema\comprobante_venta\AdsComprobanteVentaController@create_reporte');
Route::get('AdsComprobanteVenta_create','administracion_sistema\comprobante_venta\AdsComprobanteVentaController@create');
Route::resource('AdsComprobanteVenta','administracion_sistema\comprobante_venta\AdsComprobanteVentaController');

Route::post('AdsComprobanteServicio/validar_tipoCambio','administracion_sistema\comprobante_servicio\AdsComprobanteServicioController@validar_tipoCambio');
Route::post('AdsComprobanteServicio/getGuiaBySerieNumero','administracion_sistema\comprobante_servicio\AdsComprobanteServicioController@getRowBySerieNumero');
Route::post('AdsComprobanteServicio/imprimir','administracion_sistema\comprobante_servicio\AdsComprobanteServicioController@imprimir');
Route::get('AdsComprobanteServicio/getAllComprobantes','administracion_sistema\comprobante_servicio\AdsComprobanteServicioController@getAll');
Route::get('AdsComprobanteServicio_create','administracion_sistema\comprobante_servicio\AdsComprobanteServicioController@create');
Route::resource('AdsComprobanteServicio','administracion_sistema\comprobante_servicio\AdsComprobanteServicioController');

Route::get('AdsMoneda/getAllMonedas','administracion_sistema\moneda\AdsMonedaController@getAll');
Route::resource('AdsMoneda','administracion_sistema\moneda\AdsMonedaController');

Route::get('AdsIgv/getAllIgvs','administracion_sistema\igv\AdsIgvController@getAll');
Route::resource('AdsIgv','administracion_sistema\igv\AdsIgvController');

Route::get('AdsTipoCambioMoneda/getRowTipoCambioToday','administracion_sistema\tipo_cambio_moneda\AdsTipoCambioController@getRowTipoCambioToday');
Route::resource('AdsTipoCambioMoneda','administracion_sistema\tipo_cambio_moneda\AdsTipoCambioController');

Route::post('AdsProveedor/getDirecFiscal','administracion_sistema\proveedor\AdsProveedorController@getDirecFiscal');
Route::get('AdsProveedor/getAllProveedores','administracion_sistema\proveedor\AdsProveedorController@getAll');
Route::resource('AdsProveedor','administracion_sistema\proveedor\AdsProveedorController');

Route::post('AdsGuiaRemision/imprimir','administracion_sistema\guia_remision\AdsGuiaRemisionController@imprimir');
Route::post('AdsGuiaRemision/getGuiaBySerieNumero','administracion_sistema\guia_remision\AdsGuiaRemisionController@getRowBySerieNumero');
Route::get('AdsGuiaRemision/getAllPartidaGuia','administracion_sistema\guia_remision\AdsGuiaRemisionController@getAllPartida');
Route::get('AdsGuiaRemision/getAllLlegadaGuia','administracion_sistema\guia_remision\AdsGuiaRemisionController@getAllLlegada');
Route::get('AdsGuiaRemision/getAllGuiasVenta','administracion_sistema\guia_remision\AdsGuiaRemisionController@getAllVenta');
Route::get('AdsGuiaRemision/getAllGuiasCompra','administracion_sistema\guia_remision\AdsGuiaRemisionController@getAllCompra');
Route::get('AdsGuiaRemision_create_compra','administracion_sistema\guia_remision\AdsGuiaRemisionController@create_compra');
Route::get('AdsGuiaRemision_create','administracion_sistema\guia_remision\AdsGuiaRemisionController@create');
Route::get('AdsGuiaRemision_compra','administracion_sistema\guia_remision\AdsGuiaRemisionController@main_compra');
Route::resource('AdsGuiaRemision','administracion_sistema\guia_remision\AdsGuiaRemisionController');

Route::get('AdsMotivoTraslado/getAllMotivoTraslado','administracion_sistema\motivo_traslado\AdsMotivoTrasladoController@getAll');
Route::resource('AdsMotivoTraslado','administracion_sistema\motivo_traslado\AdsMotivoTrasladoController');

Route::get('AdsMotivoNota/getAllMotivoNota','administracion_sistema\motivo_nota\AdsMotivoNotaController@getAll');
Route::resource('AdsMotivoNota','administracion_sistema\motivo_nota\AdsMotivoNotaController');

Route::get('AdsColor/getAllColor','administracion_sistema\color\AdsColorController@getAll');
Route::resource('AdsColor','administracion_sistema\color\AdsColorController');

Route::post('AdsAsociarComprobante_AsociarRetenedor','administracion_sistema\comprobante_venta\AdsAsociarComprobanteController@AsociarRetenedor');
Route::resource('AdsAsociarComprobante','administracion_sistema\comprobante_venta\AdsAsociarComprobanteController');

Route::get('AdsDetalleNota/getAllEstadoLetra','administracion_sistema\nota_debito_credito\AdsEstadoLetraController@getAll');
Route::get('AdsDetalleNota/getAllMedioPago','administracion_sistema\nota_debito_credito\AdsMedioPagoController@getAll');
Route::get('AdsDetalleNota/getAllCondicionPago','administracion_sistema\nota_debito_credito\AdsCondicionPagoController@getAll');
Route::post('AdsDetalleNota/validar_tipoCambio','administracion_sistema\nota_debito_credito\AdsDetalleNotaController@validar_tipoCambio');
Route::post('AdsDetalleNota/imprimir','administracion_sistema\nota_debito_credito\AdsDetalleNotaController@imprimir');
Route::post('AdsDetalleNota/getFacturaBySerieNumero','administracion_sistema\nota_debito_credito\AdsDetalleNotaController@getRowBySerieNumero');
Route::get('AdsDetalleNota/getAllComprobantes','administracion_sistema\nota_debito_credito\AdsDetalleNotaController@getAll');
Route::get('AdsDetalleNota/getAllComprobantesCompra','administracion_sistema\nota_debito_credito\AdsDetalleNotaController@getAllCompra');
Route::get('AdsDetalleNota_createCompra','administracion_sistema\nota_debito_credito\AdsDetalleNotaController@createCompra');
Route::get('AdsDetalleNota_create','administracion_sistema\nota_debito_credito\AdsDetalleNotaController@create');
Route::post('AdsDetalleNota/asociar_factura','administracion_sistema\nota_debito_credito\AdsDetalleNotaController@asociar_factura');
Route::post('AdsDetalleNota/store_gestion_nota','administracion_sistema\nota_debito_credito\AdsDetalleNotaController@store_gestion_nota');
Route::post('AdsDetalleNota/store_gestion_nota_compra','administracion_sistema\nota_debito_credito\AdsDetalleNotaController@store_gestion_nota_compra');
Route::get('AdsDetalleNota_Compra','administracion_sistema\nota_debito_credito\AdsDetalleNotaController@main_compra');
Route::resource('AdsDetalleNota','administracion_sistema\nota_debito_credito\AdsDetalleNotaController');


Route::get('AdsTipoNota/getAllTipoNotas','administracion_sistema\tipo_nota\AdsTipoNotaController@getAll');
Route::resource('AdsTipoNota','administracion_sistema\tipo_nota\AdsTipoNotaController');

Route::get('AdsDetallePago/getLetrasWithFilter/{q}/{w}/{e}','administracion_sistema\seguimiento_letra\AdsDetallePagoController@getFilter');
// Route::post('AdsDetallePago/getLetrasWithFilter','administracion_sistema\seguimiento_letra\AdsDetallePagoController@getFilter');
Route::get('AdsDetallePago/getAllLetras','administracion_sistema\seguimiento_letra\AdsDetallePagoController@getAll');
Route::get('AdsDetallePago/getAllContado','administracion_sistema\seguimiento_letra\AdsDetallePagoController@getAllContado');
Route::get('AdsDetallePago_Reporte','administracion_sistema\seguimiento_letra\AdsDetallePagoController@create_reporte');
Route::get('AdsDetallePago_create','administracion_sistema\seguimiento_letra\AdsDetallePagoController@create');
Route::get('AdsDetallePago_Contado','administracion_sistema\seguimiento_letra\AdsDetallePagoController@create_contado');
Route::post('AdsDetallePago/set_detalle_pago','administracion_sistema\seguimiento_letra\AdsDetallePagoController@set_detalle_pago');
Route::post('AdsDetallePago/set_detalle_pago_compra','administracion_sistema\seguimiento_letra\AdsDetallePagoController@set_detalle_pago_compra');
Route::resource('AdsDetallePago','administracion_sistema\seguimiento_letra\AdsDetallePagoController');

Route::get('AdsCuenta/getAllCuentasByBanco/{id_banco}','administracion_sistema\cuenta\AdsCuentaController@getAllByBanco');
Route::get('AdsCuenta/getAllCuentas','administracion_sistema\cuenta\AdsCuentaController@getAll');
Route::resource('AdsCuenta','administracion_sistema\cuenta\AdsCuentaController');

Route::get('AdsBanco/getAllBancos','administracion_sistema\banco\AdsBancoController@getAll');
Route::resource('AdsBanco','administracion_sistema\banco\AdsBancoController');

Route::get('AdsComposicion/getAllComposicion','administracion_sistema\composicion\AdsComposicionController@getAll');
Route::resource('AdsComposicion','administracion_sistema\composicion\AdsComposicionController');

Route::get('AdsTitulo/getAllTitulo','administracion_sistema\titulo\AdsTituloController@getAll');
Route::resource('AdsTitulo','administracion_sistema\titulo\AdsTituloController');

Route::get('AdsHilatura/getAllHilatura','administracion_sistema\hilatura\AdsHilaturaController@getAll');
Route::resource('AdsHilatura','administracion_sistema\hilatura\AdsHilaturaController');

Route::get('AdsTipoProducto/getAllTipoProducto','administracion_sistema\tipo_producto\AdsTipoProductoController@getAll');
Route::resource('AdsTipoProducto','administracion_sistema\tipo_producto\AdsTipoProductoController');

Route::get('AdsTipoTela/getAllTipoTela','administracion_sistema\tipo_tela\AdsTipoTelaController@getAll');
Route::resource('AdsTipoTela','administracion_sistema\tipo_tela\AdsTipoTelaController');
