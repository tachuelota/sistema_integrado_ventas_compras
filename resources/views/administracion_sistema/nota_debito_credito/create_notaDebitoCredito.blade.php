@extends('templates.layout')

@section('title')
Registro de Ventas
@endsection

@section('head')
    <style>
        #box-options, #box-options:focus, #box-options:hover {
             background-color: transparent !important; 
        }

        #box-options {
            padding: 5px 10px !important;
        }
    </style>
@endsection

@section('breadcrumb')
    <!----><h1><small></small></h1>
    <ol class="breadcrumb">
        <li><a href="{{asset('/')}}"><i class="fa fa-home"></i> Principal</a></li>
        <li><a href="{{asset('/')}}"><i class="fa fa-fw fa-shopping-cart"></i> Módulo de Ventas</a></li>
        <li class="active"><i class="fa fa-fw fa-building-o"></i> Nota Débito/Crédito</li>
    </ol>
@endsection

@section('content')
<div ng-app="myApp" ng-controller="AdsDetalleNotaController as NotaCtrl" class="container-fluid">

    <div class="row">
        <div class="col-xs-12">
            <div id="box-comprobante" class="box box-solid box-primary">
                <div class="box-header"> 
                    <i class="fa fa-file-o"></i>
                    <h3 class="box-title">Nota Débito/Crédito</h3>

                    <!-- <div class="navbar-custom-menu pull-right">
                        <ul class="nav navbar-nav">
                            <li class="dropdown notifications-menu">
                                <a id="box-options" href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-cog"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header">Opciones</li>
                                    <li>
                                        <ul class="menu">
                                            <li>
                                                <a href="#" ng-click="NotaCtrl.modal_asociar()">
                                                    <i class="fa fa-files-o text-aqua"></i> Asociar con Factura de Venta
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div> -->

                </div>
                <div class="box-body"> 
                    <!--
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h2>Factura de Venta</h2>
                        </div>
                    </div>
                    --> 
                    <form id="form_cabecera" style="margin-top: 15px;">
                        <div class="row form-group">
                            <div class="col-md-2 text-right" style="padding-top: 4px;">
                                <span>N° Serie:</span>
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control validate[required,minSize[3]]" maxlength="3" ng-model="NotaCtrl.cabecera.serie_comprobante">
                            </div>
                            <div class="col-md-1 text-right" style="padding-top: 4px;">
                                Moneda:
                            </div>
                            <div class="col-md-2">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-dollar"></i>
                                    </span>
                                    <select id="moneda" class="form-control validate[required]" ng-model="NotaCtrl.cabecera.moneda" ng-options="item as item.nombre_moneda for item in NotaCtrl.monedas track by item.id" ng-change="NotaCtrl.moneda_change()">
                                        <option value="">-- Seleccione --</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1 text-right" style="padding-top: 4px;">
                                Hora:
                            </div>
                            <div class="col-md-2">
                                <div class="input-group">
                                    <div href="" class="input-group-addon">
                                        <i class="fa fa-clock-o"></i>
                                    </div>
                                    <label name="Hora_Actual" id="Hora_Actual" class="form-control"></label>

                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-2 text-right" style="padding-top: 4px;">
                                N° Comprobante: 
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control validate[required]" maxlength="20" ng-model="NotaCtrl.cabecera.numero_comprobante">
                            </div>
                            <div class="col-md-1 text-right" style="padding-top: 4px;">
                                Fecha:
                            </div>
                            <div class="col-md-2">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <input type="text" id="fecha_comprobante" class="form-control validate[required]" datepicker-popup="/% format %/" ng-model="NotaCtrl.fecha_comprobante" ng-change="NotaCtrl.validar_tipoCambio()" is-open="opened_fec_inicio" current-text="Hoy" weeks-text="Semanas" close-text="Cerrar" />
                                </div>
                            </div>
                            <div class="col-md-1 text-right" style="padding-top: 4px;">
                                Tipo Nota:
                            </div>
                            <div class="col-md-2">
                                <select id="moneda" class="form-control validate[required]" ng-model="NotaCtrl.cabecera.tipo_nota" ng-options="item as item.nombre_tipo_nota for item in NotaCtrl.tipos_nota track by item.id">
                                    <option value="">-- Seleccione --</option>
                                </select>
                            </div>
                        </div>
                        <!-- <hr>
                        <div class="row form-group">
                            <div class="col-md-2 text-right" style="padding-top: 4px;">
                                Cliente:
                            </div>
                            <div class="col-md-5">
                                    <input id="cliente" placeholder="Cliente" class="form-control validate[required]" disabled>
                            </div>
                            <div class="col-md-3">
                                <input type="text" id="ruc" class="form-control" placeholder="RUC" disabled>
                            </div>
                            <div class="col-md-2">
                                <p id="label_agente_retenedor" style="color:red;"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 text-right" style="padding-top: 4px;">
                                Direccion: 
                            </div>
                            <div class="col-md-8">
                                <input type="text" id="direccion" class="form-control" placeholder="Direccion" disabled>
                            </div>
                        </div> -->
                    </form>
                    <!-- <hr> -->


                                    <form id="form_detalle">
                                        <div class="row form-group">        
                                            <div class="col-md-2 text-right" style="padding-top: 4px;">
                                                Descripcion
                                            </div>
                                            <div class="col-md-5">
                                                <input type="text" id="descripcion_nota" ng-model="NotaCtrl.cabecera.descripcion_nota" class="form-control validate[required]" placeholder="Descripcion">
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2 text-right" style="padding-top: 4px;">
                                                Producto
                                            </div>
                                            <div class="col-md-5">
                                                <div class="input-group">

                                                    <a href="" ng-click="NotaCtrl.buscarProducto()" class="input-group-addon">
                                                        <i class="fa fa-search"></i>
                                                    </a>
                                                    <angucomplete-alt id="nom_producto" placeholder="Nombre Producto" pause="100" selected-object="NotaCtrl.seleccion_angucompleteproducto_nota" local-data="NotaCtrl.angucomplete_productos" search-fields="nombre_producto" title-field="nombre_producto" minlength="1" input-class="form-control form-control-small validate[required]" match-class="highlight" field-required="true">
                                                    </angucomplete-alt>
                                                    <a href="" ng-click="NotaCtrl.nuevoProducto()" class="input-group-addon">
                                                        <i class="fa fa-plus"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row form-group">        
                                            <div class="col-md-2 text-right" style="padding-top: 4px;">
                                                Cantidad
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" id="cantidad_producto" ng-model="NotaCtrl.cabecera.cantidad" class="form-control validate[required,custom[number]]" placeholder="Cantidad">
                                            </div>
                                        </div>
                                        <div class="row form-group">        
                                            <div class="col-md-2 text-right" style="padding-top: 4px;">
                                                Merma
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" id="merma" ng-model="NotaCtrl.cabecera.merma" class="form-control validate[required,custom[number]]" placeholder="Cantidad">
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2 text-right" style="padding-top: 4px;">
                                                Monto 
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" id="precio_nota" ng-model="NotaCtrl.cabecera.precio_nota" ng-change="NotaCtrl.calcular_importe_aplicado()" class="form-control validate[required]" placeholder="Precio">
                                            </div>
                                        </div>
                                    </form>
                    <!-- <hr>
                    <div class="row form-group">
                        <div class="col-md-2 col-md-offset-8 text-right">
                            <label>SubTotal : </label>
                        </div>
                        <div class="col-md-2">
                            <input type="hidden" id="subtotal" ng-model="NotaCtrl.totales.subtotal" class="form-control" placeholder="SubTotal" disabled>
                            <input type="number" id="subtotal_nota" ng-model="NotaCtrl.totales.subtotal_nota" class="form-control" placeholder="SubTotal" disabled>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-2 col-md-offset-8 text-right">
                            <label>IGV (/% NotaCtrl.totales.porcentaje_igv %/%) : </label>
                        </div>
                        <div class="col-md-2">
                            <input type="number" id="igv" ng-model="NotaCtrl.totales.igv" class="form-control" placeholder="IGV" disabled>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-2 col-md-offset-8 text-right">
                            <label>Total : </label>
                        </div>
                        <div class="col-md-2">
                            <input type="number" id="total" ng-model="NotaCtrl.totales.total_comprobante" class="form-control" placeholder="Total" disabled>
                        </div>
                    </div> -->

                    <!-- <div class="row form-group" style="margin-bottom: 25px;">
                        <div class="col-md-2 col-md-offset-8 text-right">
                            <label>Importe Aplicado : </label>
                        </div>
                        <div class="col-md-2">
                            <input type="number" id="importe_aplicado" ng-model="NotaCtrl.totales.importe_aplicado" class="form-control" placeholder="Importe Aplicado" disabled>
                        </div>
                    </div> -->

                    <div class="row form-group">
                        <div class="col-md-3 col-md-offset-3">
                            <a ng-click="NotaCtrl.imprimir()" target="_blank" class="btn btn-flat btn-primary btn-block"><i class="fa fa-print"></i> Imprimir</a>
                        </div>
                        <div class="col-md-3">
                            <a ng-click="NotaCtrl.store(NotaCtrl.detalles_venta,NotaCtrl.cabecera_venta)" class="btn btn-flat btn-success btn-block"><i class="fa fa-dollar"></i> Registrar Nota</a>
                        </div>
                        <div class="col-md-3">
                            <!-- <a href="main" class="btn btn-flat btn-danger btn-block"><i class="fa fa-minus"></i> Cancelar</a> -->
                            <a ng-click="NotaCtrl.cancelar_comprobante()" class="btn btn-flat btn-danger btn-block"><i class="fa fa-minus"></i> Cancelar</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>



@endsection

@section('foot')

@endsection

@section('script')


<script type="text/javascript">

    var app = angular.module('myApp',[ 'ui.bootstrap','ngRoute','angucomplete-alt']);

    app.config(function($interpolateProvider){
        $interpolateProvider.startSymbol('/%');
        $interpolateProvider.endSymbol('%/');
    });


    app.controller('AdsDetalleNotaController', function AdsDetalleNotaController(AdsDetalleNotaFactory){
  
        var vm = this;
        vm.detalles_comprobante = AdsDetalleNotaFactory.Detalle_comprobante; 
        vm.cabecera = AdsDetalleNotaFactory.CabeceraComprobante_create; 
        vm.finanzas = AdsDetalleNotaFactory.Finanzas_create; 
        vm.totales = AdsDetalleNotaFactory.Totales_create; 
        vm.boolean_cliente_seleccionado = AdsDetalleNotaFactory.Cliente_seleccionado;
        vm.angucomplete_productos = AdsDetalleNotaFactory.Productos;
        vm.angucomplete_clientes = AdsDetalleNotaFactory.Clientes;
        vm.monedas = AdsDetalleNotaFactory.Monedas;
        vm.condiciones_pago = AdsDetalleNotaFactory.CondicionesPago;
        vm.medios_pago = AdsDetalleNotaFactory.MediosPago;
        vm.estados_letra = AdsDetalleNotaFactory.EstadosLetra;
        vm.tipos_nota = AdsDetalleNotaFactory.TipoNotas;

        // vm.boolean_asociar = AdsDetalleNotaFactory.boolean_asociar;

        vm.fecha_comprobante = AdsDetalleNotaFactory.FechaComprobante;

        vm.calcular_importe_aplicado = function(){
            var precio_nota = vm.cabecera.precio_nota;
            var igv = vm.cabecera.igv;
            if(precio_nota == '') precio_nota = 0;
            vm.totales.subtotal_nota = parseFloat(precio_nota) + parseFloat(vm.totales.subtotal);
            vm.totales.igv = vm.totales.subtotal_nota * (vm.totales.porcentaje_igv/100);
            vm.totales.total_comprobante = vm.totales.subtotal_nota + vm.totales.igv;

            // REDONDEANDO A 2 DECIMAS
            vm.totales.total_comprobante = Math.round(vm.totales.total_comprobante * 100) / 100;
        }
        
        vm.prueba = function(){
            // var fecha = new XDate(vm.fecha_comprobante+ vm.finanzas.numero_dias).toString('yyyy-MM-dd')
            // fecha = fecha + vm.finanzas.numero_dias;
             var fecha= new Date(vm.fecha_comprobante);
             fecha.setDate(fecha.getDate()+parseInt(vm.finanzas.numero_dias));
            console.log(new XDate(fecha).toString('yyyy-MM-dd'));

            // AdsDetalleNotaFactory.FechaComprobante = null;
        }
        vm.cancelar_comprobante = function(){

            AdsDetalleNotaFactory.cancelar_comprobante();

        }

        vm.validar_tipoCambio = function(){

            var fecha = new XDate(vm.fecha_comprobante).toString('yyyy-MM-dd');
            
        }
        vm.imprimir = function(){

            if($("#form_cabecera").validationEngine('validate')){

                if(vm.detalles_comprobante[0]!=null){

                    var cabecera_create = {
                            serie : vm.cabecera.serie_comprobante
                            , numero : vm.cabecera.numero_comprobante
                            , fecha : new XDate(vm.fecha_comprobante).toString('yyyy-MM-dd')
                            , cliente : AdsDetalleNotaFactory.Cliente_seleccionado
                            , direccion : AdsDetalleNotaFactory.Cliente_seleccionado.direccion_seleccionada
                            , moneda : vm.cabecera.moneda
                            , hora : angular.element(Hora_Actual).text()
                        };

                    var detalle_create = vm.detalles_comprobante;

                    var totales_create = {
                            subtotal : angular.element(subtotal).val()
                            , igv : angular.element(igv).val()
                            , total : angular.element(total).val()
                            , retencion : angular.element(retencion).val()
                            , importe_aplicado : angular.element(importe_aplicado).val()
                        };
                    // if(vm.cliente_angucomp_select)
                    // {
                    //     cabecera.id_cliente = vm.cliente_angucomp_select.description.id;
                    // }
                    
                    AdsDetalleNotaFactory.imprimir(cabecera_create,detalle_create,totales_create);
                }
                else{
                    alert('Debe agregar un detalle al comprobante.');
                }
            }
            
            // var ficha=document.getElementById("box-comprobante");
            // var ventimp=window.open(' ','popimpr');
            // ventimp.document.write(ficha.innerHTML);
            // ventimp.document.close();
            // ventimp.print();
            // ventimp.close();
        }

        vm.seleccion_angucompletecliente = function(object){

            
            angular.copy(object.description,AdsDetalleNotaFactory.Cliente_seleccionado)
            angular.element(cliente_value).val(AdsDetalleNotaFactory.Cliente_seleccionado.razon_social);
            angular.element(ruc).val(AdsDetalleNotaFactory.Cliente_seleccionado.ruc);
            angular.element(direccion).val(AdsDetalleNotaFactory.Cliente_seleccionado.direccion_principal);

            AdsDetalleNotaFactory.Cliente_seleccionado.id_cliente_seleccionado = object.description.id_cliente;
            AdsDetalleNotaFactory.Cliente_seleccionado.id_direccion_seleccionada = object.description.id_direccion_principal;
            AdsDetalleNotaFactory.Cliente_seleccionado.direccion_seleccionada = object.description.direccion_principal;
            
            if(AdsDetalleNotaFactory.Cliente_seleccionado.agente_retenedor == 'true')
            {
                angular.element(label_agente_retenedor).text('AGENTE RETENEDOR');
            }
            else
            {
                angular.element(label_agente_retenedor).text('');
            }
        }

        AdsDetalleNotaFactory.getProductos();
        AdsDetalleNotaFactory.getClientes();
        AdsDetalleNotaFactory.getMonedas();
        AdsDetalleNotaFactory.getRowTipoCambioToday();
        AdsDetalleNotaFactory.getTipoNota();

        var acum_total=0;

        //Configuracion para FECHA

        vm.today = function() {
            vm.fecha_comprobante = new Date();
        }
        vm.clear = function () {
            vm.fecha_comprobante = null;
        }
        vm.open = function($event) {
            // $event.preventDefault();
            // $event.stopPropagation();
            // vm.opened_fec_inicio = true;
        }


        vm.formats = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
        vm.format = 'yyyy/MM/dd';
        
        /* Carga de productos para la Funcion autocompletar */
        vm.seleccion_angucompleteproducto = function(object){
            if($('#moneda').validationEngine('validate')){
                if(AdsDetalleNotaFactory.CabeceraComprobante_create.moneda.id == 1){

                    angular.element(precio_producto).removeClass('validate[required,min['+AdsDetalleNotaFactory.Producto_seleccionado.precio_unitario+']]');
                    angular.element(precio_producto).addClass('validate[required]');

                }
                else if(AdsDetalleNotaFactory.CabeceraComprobante_create.moneda.id == 2){

                    angular.element(precio_producto).removeClass('validate[required,min['+AdsDetalleNotaFactory.Producto_seleccionado.precio_unitario/AdsDetalleNotaFactory.TipoCambio_today.tipo_cambio+']]');
                    angular.element(precio_producto).addClass('validate[required]');

                }

                if(object.description.precio_unitario == null) object.description.precio_unitario=0;

                if(AdsDetalleNotaFactory.CabeceraComprobante_create.moneda.id == 1){
                    angular.element(label_precio).text('Precio Mínimo: S/.'+ formatNumber(object.description.precio_unitario, ''));
                
                    angular.element(precio_producto).removeClass('validate[required]');
                    angular.element(precio_producto).addClass('validate[required,min['+formatNumber(object.description.precio_unitario, '')+']]');

                }
                else if(AdsDetalleNotaFactory.CabeceraComprobante_create.moneda.id == 2){

                    angular.element(label_precio).text('Precio Mínimo: $.'+formatNumber(object.description.precio_unitario/AdsDetalleNotaFactory.TipoCambio_today.tipo_cambio, ''));
                    
                    angular.element(precio_producto).removeClass('validate[required]');
                    angular.element(precio_producto).addClass('validate[required,min['+formatNumber(object.description.precio_unitario/AdsDetalleNotaFactory.TipoCambio_today.tipo_cambio, '')+']]');
                    
                }
                angular.element(stock).val(object.description.stock);
                angular.element(unidad_medida).val(object.description.unidad_medida.nombre_unidad_medida);
                

                angular.copy(object.description, AdsDetalleNotaFactory.Producto_seleccionado);
            }

        }
        
        vm.eliminar = function(index){
            AdsDetalleNotaFactory.deleteAttempt(index);
        }
        
        vm.create = function(){
            AdsDetalleNotaFactory.create();
        }

        vm.edit = function(row_detalle_venta, index){
            AdsDetalleNotaFactory.edit(row_detalle_venta, index);
        }

        vm.store = function(){
            if($("#form_cabecera").validationEngine('validate')){

                var cabecera_create = {
                        serie : vm.cabecera.serie_comprobante
                        , numero : vm.cabecera.numero_comprobante
                        , fecha : new XDate(vm.fecha_comprobante).toString('yyyy-MM-dd')
                        , tipo_nota : vm.cabecera.tipo_nota
                        , descripcion : vm.cabecera.descripcion_nota
                        , precio : vm.cabecera.precio_nota
                        , cliente : AdsDetalleNotaFactory.Cliente_seleccionado
                        , total_nota : vm.totales.total_comprobante
                        , moneda : vm.cabecera.moneda
                        , producto : AdsDetalleNotaFactory.Producto_seleccionado
                        , cantidad : vm.cabecera.cantidad
                        , merma : vm.cabecera.merma
                        , compra_venta : 'VENTA'
                };

                AdsDetalleNotaFactory.store(cabecera_create);  

            }
        }

        // vm.store_ANTIGUO = function(){
        //     if($("#form_cabecera").validationEngine('validate')){
        //         if(vm.detalles_comprobante[0]!=null){
        //             var cabecera_create = {
        //                     serie : vm.cabecera.serie_comprobante
        //                     , numero : vm.cabecera.numero_comprobante
        //                     , fecha : new XDate(vm.fecha_comprobante).toString('yyyy-MM-dd')
        //                     , descripcion : vm.cabecera.descripcion_nota
        //                     , precio : vm.cabecera.precio_nota
        //                     , cliente : AdsDetalleNotaFactory.Cliente_seleccionado
        //                     , total_nota : vm.totales.total_comprobante
        //                     , moneda : vm.cabecera.moneda
        //                     // , importe_aplicado : angular.element(importe_aplicado).val()
        //                     , id_comprobanteVenta : AdsDetalleNotaFactory.CabeceraComprobante_create.id_comprobanteVenta
        //             };

        //             AdsDetalleNotaFactory.store(cabecera_create);  
        //         }
        //         else{
        //             alert('Debe agregar un detalle al comprobante.');
        //         }
        //     }
        // }

        vm.buscarCliente = function(){
            AdsDetalleNotaFactory.buscarCliente();
        }

        vm.nuevoCliente = function(){
            AdsDetalleNotaFactory.nuevoCliente();
        }

        

        vm.set_codebar = function(){
            var posicion = vm.detalle_venta.codebar.indexOf('-');
            var id_producto = parseInt(vm.detalle_venta.codebar.substring(posicion+1));
            AdsDetalleNotaFactory.getProductoByIdFromInvetarioProd(id_producto);
        }

        vm.agregar_detalle = function(){
            if($("#form_detalle").validationEngine('validate')){      

                AdsDetalleNotaFactory.agregar_detalle(vm.detalle_comprobante);
                angular.element(nom_producto_value).val('');
                vm.detalle_comprobante.cantidad = '';
                vm.detalle_comprobante.unidadMedida = '';
                vm.detalle_comprobante.precio = '';

            }
        }

        vm.calcular_total = function(){
            AdsDetalleNotaFactory.calcular_total();
        }

        vm.moneda_change = function(){
            // AdsDetalleNotaFactory.calcular_total();
            if(vm.cabecera.moneda==null){
                vm.deshabilitar_agregar = true;
            }
            else{
                vm.deshabilitar_agregar = false;
            }

        }        
        vm.deshabilitar_agregar = true;


        vm.modal_asociar = function(){

            AdsDetalleNotaFactory.modal_asociar();
        }
        
 

        vm.seleccion_angucompleteproducto_nota = function(object){

            if(object.description.precio_unitario == null) object.description.precio_unitario=0;
            angular.copy(object.description, AdsDetalleNotaFactory.Producto_seleccionado);

        }

        vm.buscarProducto = function(){
            AdsDetalleNotaFactory.buscarProducto();
        }

        vm.nuevoProducto = function(){
            AdsDetalleNotaFactory.nuevoProducto();
        }

        AdsDetalleNotaFactory.getAllComposicion();
        AdsDetalleNotaFactory.getAllTitulo();
        AdsDetalleNotaFactory.getAllHilatura();
        AdsDetalleNotaFactory.getAllTipoProducto();
        AdsDetalleNotaFactory.getAllTipoTela();
        AdsDetalleNotaFactory.getAllColor();

    });

 
    app.factory('AdsDetalleNotaFactory', function AdsDetalleNotaFactory($http, $modal ) {

        AdsDetalleNotaFactory.detalle_venta = {}; 
        AdsDetalleNotaFactory.cabecera_venta = {}; 
        AdsDetalleNotaFactory.detalle_venta.producto = {}; 
        AdsDetalleNotaFactory.seleccion_producto = {}; 
        AdsDetalleNotaFactory.Producto_create = {};
        AdsDetalleNotaFactory.Cliente_create = {};
        AdsDetalleNotaFactory.Detalle_venta_edit = {};

        AdsDetalleNotaFactory.Productos = [];
        AdsDetalleNotaFactory.Clientes = [];
        AdsDetalleNotaFactory.Monedas = [];
        AdsDetalleNotaFactory.CondicionesPago = [];
        AdsDetalleNotaFactory.MediosPago = [];
        AdsDetalleNotaFactory.EstadosLetra = [];
        AdsDetalleNotaFactory.TipoNotas = [];

        AdsDetalleNotaFactory.Array_id_guias = [];
        AdsDetalleNotaFactory.Detalle_comprobante = [];
        AdsDetalleNotaFactory.Cliente_seleccionado = {};
        AdsDetalleNotaFactory.Producto_seleccionado = {};


        AdsDetalleNotaFactory.CabeceraComprobante_create = {};
        AdsDetalleNotaFactory.Finanzas_create = {};
        AdsDetalleNotaFactory.Totales_create = {};
        AdsDetalleNotaFactory.DetalleComprobante_create = {};
        AdsDetalleNotaFactory.TipoCambio_create = {};
        AdsDetalleNotaFactory.TipoCambio_today = {};
        AdsDetalleNotaFactory.CabeceraComprobante_create.boolean_asociar = false;


        AdsDetalleNotaFactory.Composicion = [];
        AdsDetalleNotaFactory.Titulo = [];
        AdsDetalleNotaFactory.Hilatura = [];
        AdsDetalleNotaFactory.TipoProducto = [];
        AdsDetalleNotaFactory.TipoTela = [];
        AdsDetalleNotaFactory.Color = [];
        // var fecha_actual = new XDate(new Date()+1).toString('yyyy-MM-dd');

             // var fecha_actual= new Date();
            // fecha_actual.setDate(fecha_actual.getDate());
            // fecha_actual = new XDate(fecha_actual).toString('yyyy-MM-dd');
        // AdsDetalleNotaFactory.FechaComprobante = fecha_actual;


        AdsDetalleNotaFactory.getAllComposicion = function() {
            return $http.get('AdsComposicion/getAllComposicion').success(function(data) {
                angular.copy(data.datos, AdsDetalleNotaFactory.Composicion );
            });
        } 
        AdsDetalleNotaFactory.getAllTitulo = function() {
            return $http.get('AdsTitulo/getAllTitulo').success(function(data) {
                angular.copy(data.datos, AdsDetalleNotaFactory.Titulo );
            });
        } 
        AdsDetalleNotaFactory.getAllHilatura = function() {
            return $http.get('AdsHilatura/getAllHilatura').success(function(data) {
                angular.copy(data.datos, AdsDetalleNotaFactory.Hilatura );
            });
        } 
        AdsDetalleNotaFactory.getAllTipoProducto = function() {
            return $http.get('AdsTipoProducto/getAllTipoProducto').success(function(data) {
                angular.copy(data.datos, AdsDetalleNotaFactory.TipoProducto );
            });
        } 

        AdsDetalleNotaFactory.getAllTipoTela = function() {
            return $http.get('AdsTipoTela/getAllTipoTela').success(function(data) {
                angular.copy(data.datos, AdsDetalleNotaFactory.TipoTela );
            });
        } 
        AdsDetalleNotaFactory.getAllColor = function() {
            return $http.get('AdsColor/getAllColor').success(function(data) {
                angular.copy(data.datos, AdsDetalleNotaFactory.Color );
                console.log('AdsDetalleNotaFactory.Color');
                console.log(AdsDetalleNotaFactory.Color);
            });
        } 

        AdsDetalleNotaFactory.nuevoProducto = function(){
            $modal.open({
                templateUrl: 'templates_angular/ProductoController/create.html',
                controller: function($scope, $modalInstance, $filter, UnidadMedida, Composicion, Titulo, Hilatura, TipoProducto, TipoTela, Color){
                    /* El objeto creado del scope se utiliza en la vista */
                    $scope.producto = {};
                    $scope.unidadmedida = UnidadMedida;
                    $scope.composicion = Composicion;
                    $scope.titulo = Titulo;
                    $scope.hilatura = Hilatura;
                    $scope.tipoproducto = TipoProducto;
                    $scope.tipotela = TipoTela;
                    $scope.color = Color;
                    console.log(Color);
                    $scope.store = function(){
                        if ( $("#create_form").validationEngine('validate') ) {
                            AdsDetalleNotaFactory.storeProducto($scope.producto); /* Objeto de la vista */
                            $modalInstance.close();
                        };
                    }
                },
                resolve: {
                    UnidadMedida : function(){
                        return AdsDetalleNotaFactory.UnidadMedida;
                    },
                    Composicion : function(){
                        return AdsDetalleNotaFactory.Composicion;
                    },
                    Titulo : function(){
                        return AdsDetalleNotaFactory.Titulo;
                    },
                    Hilatura : function(){
                        return AdsDetalleNotaFactory.Hilatura;
                    },
                    TipoProducto : function(){
                        return AdsDetalleNotaFactory.TipoProducto;
                    },
                    TipoTela : function(){
                        return AdsDetalleNotaFactory.TipoTela;
                    },
                    Color : function(){
                        return AdsDetalleNotaFactory.Color;
                    }
                }
            });
        }

        AdsDetalleNotaFactory.storeProducto = function(Producto) {
 
        angular.element(div_loader).removeClass('hide');

            if(Producto.file!=null){
                upload.uploadFile(Producto.file);
                Producto.file_nombre = Producto.file.name;
            }
            $http.post('AdsProducto', Producto).success(function(data){
                if(data.datos == 'duplicidad'){
                    sweetAlert("Duplicidad", "Este producto ya existe!", "error");
        angular.element(div_loader).addClass('hide');
                }else{
        angular.element(div_loader).addClass('hide');
                    angular.copy(data.datos,AdsDetalleNotaFactory.Productos);
                    swal({   
                            title: "Producto registrado!"
                            ,   text: "El registro se realizó con éxito"
                            ,   type: "success"
                            ,   confirmButtonText: "OK" 
                            ,   timer: 2000
                        });
                }

            });
        }

        AdsDetalleNotaFactory.buscarProducto = function(){
            $modal.open({
                templateUrl: 'templates_angular/ProductoController/seleccion_producto.html',
                controller: function($scope, $modalInstance, Producto_create, Productos){
                    $scope.producto_create = Producto_create;
                    $scope.productos = Productos;

                    $scope.seleccionar = function(data){


                        if(data.precio_unitario == null) data.precio_unitario = 0;

                        angular.copy(data, AdsDetalleNotaFactory.Producto_seleccionado);
                        angular.element(nom_producto_value).val(AdsDetalleNotaFactory.Producto_seleccionado.nombre_producto);

                        $modalInstance.close();
                    }
                },
                resolve: {
                    Producto_create : function(){
                        return AdsDetalleNotaFactory.Producto_create;
                    },
                    Productos : function(){
                        return AdsDetalleNotaFactory.Productos;
                    }
                }
            });
        }

        AdsDetalleNotaFactory.modal_asociar = function(){
            $modal.open( { 
                templateUrl:'templates_angular/DetalleNotaController/asociar_comprobante.html', 
                controller: function($scope, $modalInstance, AdsDetalleNotaFactory) {
                    $scope.factura = {};
                    $scope.asociar = function(){

                        $http.post('AdsComprobanteVenta/getFacturaBySerieNumero', {guia:$scope.factura})
                            .success(function(data){
                                console.log('DATOS');
                                console.log(data.datos);

                                if(data.datos == ''){
                                    alert('Esta Factura de Venta no existe.');
                                }
                                else if(data.datos[0].id_comprobanteVenta != null){
                                    alert('Esta Factura de Venta ya esta asociada a otra Guia de Remision.');
                                }
                                else{
                                    
                                    AdsDetalleNotaFactory.CabeceraComprobante_create.boolean_asociar = true;
                                    // *************** SETEAR ID GUIA REMISION *******************
                                    AdsDetalleNotaFactory.CabeceraComprobante_create.id_comprobanteVenta = data.datos[0].id;
                                    // *************** FIIN SETEAR ID GUIA REMISION *******************

                                    // *************** SETEAR DATOS DEL CLIENTE *******************
                                    angular.element(cliente).val(data.datos[0].cliente_detalle.cliente.razon_social);
                                    angular.element(ruc).val(data.datos[0].cliente_detalle.cliente.ruc);
                                    angular.element(direccion).val(data.datos[0].cliente_detalle.direccion_cliente);


                                    AdsDetalleNotaFactory.Cliente_seleccionado.id_cliente_seleccionado = data.datos[0].cliente_detalle.cliente.id;
                                    AdsDetalleNotaFactory.Cliente_seleccionado.id_direccion_seleccionada = data.datos[0].cliente_detalle.id;
                                    AdsDetalleNotaFactory.Cliente_seleccionado.direccion_seleccionada = data.datos[0].cliente_detalle.direccion_cliente;


                                    // ***************  FIIN SETEAR DATOS DEL CLIENTE *******************

                                    
                                    // ***************  SETEAR DATOS DEL DETALLE *******************
                                    angular.copy(data.datos[0].comprobante_detalle_venta,AdsDetalleNotaFactory.Detalle_comprobante);
                                    
                                    // ***************  SETEAR DATOS DE TOTALES *******************
                                    angular.copy(data.datos[0],AdsDetalleNotaFactory.Totales_create);
                                    AdsDetalleNotaFactory.Totales_create.igv = ( data.datos[0].total_comprobante / (data.datos[0].igv.valor_igv + 1) * data.datos[0].igv.valor_igv );
                                    AdsDetalleNotaFactory.Totales_create.subtotal = (data.datos[0].total_comprobante / (data.datos[0].igv.valor_igv + 1));
                                    AdsDetalleNotaFactory.Totales_create.subtotal_nota = (data.datos[0].total_comprobante / (data.datos[0].igv.valor_igv + 1));
                                    AdsDetalleNotaFactory.Totales_create.porcentaje_igv = data.datos[0].igv.valor_igv * 100;
                                    
                                    // ***************  FIIN SETEAR DATOS DEL DETALLE *******************

                                    $modalInstance.close();

                                }

                                
                            });

                    }
                }
            });
        }

        AdsDetalleNotaFactory.cancelar_comprobante = function(){
            $modal.open( { 
                templateUrl:'templates_angular/ComprobanteCompraController/cancelar_comprobante.html', 
                controller: function($scope, $modalInstance, AdsDetalleNotaFactory) {
                    $scope.yes = function() {

                        angular.copy({},AdsDetalleNotaFactory.Detalle_comprobante); 
                        angular.copy({},AdsDetalleNotaFactory.CabeceraComprobante_create); 

                        angular.element(cliente_value).val('');
                        angular.element(ruc).val('');
                        angular.element(direccion).val('');

                        angular.element(subtotal).val('');
                        angular.element(igv).val('');
                        angular.element(total).val('');
                        angular.element(retencion).val('');
                        angular.element(importe_aplicado).val('');
                        angular.element(stock).val('');
                        angular.element(unidad_medida).val('');

                        angular.element(label_agente_retenedor).text('');

                        $modalInstance.close();
                    }
                }
            });
        }

        AdsDetalleNotaFactory.getRowTipoCambioToday = function() {
            $http.get('AdsTipoCambioMoneda/getRowTipoCambioToday')
                .success(function(data){
                    console.log(data);
                    angular.copy({tipo_cambio:data.datos}, AdsDetalleNotaFactory.TipoCambio_today);
                });
        }

        AdsDetalleNotaFactory.validar_tipoCambio = function(fecha) {
            $http.post('AdsDetalleNotaController/validar_tipoCambio', {fecha:fecha})
                .success(function(data){
                    if(data == 'EXISTE'){
                        console.log('existe');
                    }
                    else if(data == 'NO EXISTE'){
                        $modal.open( { 
                            templateUrl:'templates_angular/ComprobanteCompraController/confirmacion_tipoCambio.html', 
                            controller: function($scope, $modalInstance, AdsDetalleNotaFactory, TipoCambio_create) {
                                
                                $scope.tipoCambio = TipoCambio_create;

                                $scope.store = function() {
                                    $scope.tipoCambio.fecha = fecha;
                                    AdsDetalleNotaFactory.storeTipoCambio($scope.tipoCambio).then(function(){

                                        $modalInstance.close();
                                    });
                                }
                                $scope.cancelar = function() {
                                    angular.element(fecha_comprobante).val('');
                                    $modalInstance.close();
                                }
                            },
                            resolve: {
                                TipoCambio_create : function(){
                                    return AdsDetalleNotaFactory.TipoCambio_create;
                                }
                            }
                        });
                        console.log('no existe');
                    }
                });
        }


        AdsDetalleNotaFactory.storeTipoCambio = function(scope) {
                 return $http.post('AdsTipoCambioMoneda', scope)
                    .success(function(data){

                    });
        }
        


        AdsDetalleNotaFactory.imprimir = function(cabecera, detalle, totales) {
            $http.post('AdsDetalleNotaController/imprimir', {cabecera:cabecera, detalle:detalle, totales:totales})
                .success(function(data){

                    var htmlObject = document.createElement('html');
                    htmlObject.innerHTML = data;

                    var ventimp=window.open(' ','popimpr');
                    ventimp.document.write(htmlObject.innerHTML);
                    ventimp.document.close();
                    ventimp.print();
                    ventimp.close();
                });
        }

        AdsDetalleNotaFactory.getProductos = function() {
            return $http.get('AdsProducto/getAllProductos').success(function(data) {
                console.log(data.datos);
                angular.copy(data.datos, AdsDetalleNotaFactory.Productos);

            });
        }

        AdsDetalleNotaFactory.getClientes = function() {
            return $http.get('PtvCliente/getAllClientes').success(function(data) {
                console.log(data.datos);
                angular.copy(data.datos, AdsDetalleNotaFactory.Clientes);
            });
        } 


        AdsDetalleNotaFactory.getMonedas = function() {
            return $http.get('AdsMoneda/getAllMonedas').success(function(data) {
                angular.copy(data.datos, AdsDetalleNotaFactory.Monedas);
            });
        }

        AdsDetalleNotaFactory.getTipoNota = function() {
            return $http.get('AdsTipoNota/getAllTipoNotas').success(function(data) {
                angular.copy(data.datos, AdsDetalleNotaFactory.TipoNotas);
            });
        }


        AdsDetalleNotaFactory.deleteAttempt = function(index) {
            $modal.open( { 
                templateUrl:'templates_angular/deleteAttemp.html', 
                controller: function($scope, $modalInstance, AdsDetalleNotaFactory) {
                    $scope.yes = function() {
                        AdsDetalleNotaFactory.Detalle_comprobante.splice(index,1);
                        AdsDetalleNotaFactory.calcular_total();
                        $modalInstance.close();
                    }
                }
            });
        }  

        AdsDetalleNotaFactory.edit = function(row_detalle_comprobante,index){
            angular.copy(row_detalle_comprobante, AdsDetalleNotaFactory.Detalle_venta_edit);
            $modal.open({
                templateUrl: 'templates_angular/ComprobanteCompraController/edit.html',
                controller: function($scope, $modalInstance, Detalle_venta_edit, UnidadesMedida){
                    $scope.Detalle = Detalle_venta_edit;
                    $scope.UnidadesMedida = UnidadesMedida;
                    $scope.update = function(){
                        AdsDetalleNotaFactory.update($scope.Detalle,index);
                        $modalInstance.close();
                    }
                },
                resolve: {
                    Detalle_venta_edit : function(){
                        return AdsDetalleNotaFactory.Detalle_venta_edit;
                    },
                    UnidadesMedida : function(){
                        return AdsDetalleNotaFactory.UnidadesMedida;
                    },
                    UnidadesMedida_seleccionado : function(){
                        return AdsDetalleNotaFactory.UnidadesMedida_seleccionado;
                    }
                }
            });
        }

        AdsDetalleNotaFactory.update = function(Detalle,index){ 
            AdsDetalleNotaFactory.detalles_venta[index].cantidad = Detalle.cantidad;
            AdsDetalleNotaFactory.detalles_venta[index].id_unidadMedida = Detalle.UnidadesMedida_seleccionado.id;
            AdsDetalleNotaFactory.detalles_venta[index].unidadMedida = Detalle.UnidadesMedida_seleccionado.n_EquivalenciaUnidad;
            AdsDetalleNotaFactory.calcular_total();
        }


        AdsDetalleNotaFactory.store = function(cabecera, detalle, finanzas) {
                 $http.post('AdsDetalleNota', {cabecera:cabecera, detalle:detalle, finanzas:finanzas})
                    .success(function(data){
                        if(data.datos=='correcto'){
                            angular.copy({},AdsDetalleNotaFactory.Detalle_comprobante); 
                            angular.copy({},AdsDetalleNotaFactory.CabeceraComprobante_create); 
                            angular.copy({},AdsDetalleNotaFactory.Totales_create); 
                            angular.copy({},AdsDetalleNotaFactory.CabeceraComprobante_create.moneda); 
                            angular.copy({},AdsDetalleNotaFactory.Cliente_seleccionado); 
                            angular.copy({},AdsDetalleNotaFactory.Producto_seleccionado); 

                            // angular.element(cliente).val('');
                            // angular.element(ruc).val('');
                            // angular.element(direccion).val('');


                            angular.element(descripcion_nota).val('');
                            angular.element(precio_nota).val('');

                            // angular.element(subtotal).val('');
                            // angular.element(igv).val('');
                            // angular.element(total).val('');
                            // angular.element(importe_aplicado).val('');


                            swal({   
                                    title: "Registro exitoso!"
                                    ,   text: "El registro se realizó con éxito"
                                    ,   type: "success"
                                    ,   confirmButtonText: "OK" 
                                    ,   timer: 2000
                                });

                        } 
                        else if(data.datos == 'duplicidad'){
                            sweetAlert("Error...", "¡Existe otro comprobante con estos datos!", "error");
                        }
                    });
        }


        AdsDetalleNotaFactory.buscarCliente = function(){
            $modal.open({
                templateUrl: 'templates_angular/ClienteController/seleccion_cliente.html',
                controller: function($scope, $modalInstance, Cliente_create, Cliente){
                    $scope.cliente_create = Cliente_create;
                    $scope.cliente = Cliente;
                    console.log('entro');
                    $scope.seleccionar = function(data, id_cliente_seleccionado, id_direccion_seleccionada, direccion_seleccionada){
                        angular.element(cliente_value).val(data.razon_social);
                        angular.element(ruc).val(data.ruc);
                        angular.element(direccion).val(direccion_seleccionada);

                        if(data.agente_retenedor == 'true')
                        {
                            angular.element(label_agente_retenedor).text('AGENTE RETENEDOR');
                        }
                        else
                        {
                            angular.element(label_agente_retenedor).text('');
                        }

                        angular.copy(data, AdsDetalleNotaFactory.Cliente_seleccionado);

                        AdsDetalleNotaFactory.Cliente_seleccionado.id_cliente_seleccionado = id_cliente_seleccionado;
                        AdsDetalleNotaFactory.Cliente_seleccionado.id_direccion_seleccionada = id_direccion_seleccionada;
                        AdsDetalleNotaFactory.Cliente_seleccionado.direccion_seleccionada = direccion_seleccionada;

                        $modalInstance.close();
                    }
                },
                resolve: {
                    Cliente_create : function(){
                        return AdsDetalleNotaFactory.Cliente_create;
                    },
                    Cliente : function(){
                        return AdsDetalleNotaFactory.Clientes;
                    }
                }
            });
        }


        AdsDetalleNotaFactory.nuevoCliente = function(){
            $modal.open({
                templateUrl: 'templates_angular/ClienteController/create.html',
                controller: function($scope, $modalInstance, $filter){
                    /* El objeto creado del scope se utiliza en la vista */
                    $scope.cliente = {};
                    $scope.store = function(){
                        if ( $("#create_form").validationEngine('validate') ) {
                            AdsDetalleNotaFactory.storeCliente($scope.cliente); /* Objeto de la vista */
                            $modalInstance.close();
                        };
                    }
                },
                resolve: {
                    
                }
            });
        }

        AdsDetalleNotaFactory.storeCliente = function(Cliente) {
            $http.post('AdsCliente', Cliente).success(function(data){
                AdsDetalleNotaFactory.getClientes();
            });
        }


        AdsDetalleNotaFactory.agregar_detalle = function(detalle_comprobante){

            console.log('detalle_comprobante');
            console.log(detalle_comprobante);
            var entro = 0;
            var posicion_entro = 0;
            var cantidad_push = 0;
            for (var i = 0; i < AdsDetalleNotaFactory.Detalle_comprobante.length; i++) {
                if(AdsDetalleNotaFactory.Detalle_comprobante[i].id_producto == AdsDetalleNotaFactory.Producto_seleccionado.id){
                    cantidad_push = parseFloat(AdsDetalleNotaFactory.Detalle_comprobante[i].cantidad) + parseFloat(detalle_comprobante.cantidad);
                    entro = 1;
                    posicion_entro = i;
                }
                
            };

            if(entro == 1){
                AdsDetalleNotaFactory.Detalle_comprobante[posicion_entro].cantidad = cantidad_push;
                AdsDetalleNotaFactory.Detalle_comprobante[posicion_entro].precio = detalle_comprobante.precio;
            }
            else{
                    console.log('ENTROOOO');
                    console.log(detalle_comprobante.precio);

                AdsDetalleNotaFactory.Detalle_comprobante.push({
                                                                id_producto : AdsDetalleNotaFactory.Producto_seleccionado.id
                                                                , producto : AdsDetalleNotaFactory.Producto_seleccionado.nombre_producto
                                                                , cantidad : detalle_comprobante.cantidad
                                                                , precio : detalle_comprobante.precio
                                                            });
            console.log(AdsDetalleNotaFactory.Detalle_comprobante);
            }


            AdsDetalleNotaFactory.calcular_total();



            if(AdsDetalleNotaFactory.CabeceraComprobante_create.moneda.id == 1){

                angular.element(precio_producto).removeClass('validate[required,min['+formatNumber(AdsDetalleNotaFactory.Producto_seleccionado.precio_unitario,'')+']]');
                angular.element(precio_producto).addClass('validate[required]');

            }
            else if(AdsDetalleNotaFactory.CabeceraComprobante_create.moneda.id == 2){

                angular.element(precio_producto).removeClass('validate[required,min['+formatNumber(AdsDetalleNotaFactory.Producto_seleccionado.precio_unitario/AdsDetalleNotaFactory.TipoCambio_today.tipo_cambio,'')+']]');
                angular.element(precio_producto).addClass('validate[required]');
                
            }
            // AdsDetalleNotaFactory.Detalle_comprobante.push({id_producto : AdsDetalleNotaFactory.Producto_seleccionado.id, producto : AdsDetalleNotaFactory.Producto_seleccionado.nombre_producto, cantidad : detalle_comprobante.cantidad, precio : detalle_comprobante.precio});
            
            angular.element(label_precio).text('');
            angular.element(stock).val('');
            angular.element(unidad_medida).val('');

            AdsDetalleNotaFactory.calcular_total();

        }

        AdsDetalleNotaFactory.calcular_total = function(){

            var valor_igv = <?php echo DB::table('ts_igv')->where('estado', 'true')->pluck('valor_igv'); ?>;
            var valor_dividir = valor_igv+1;

            var acum_subtotal=0;
            var var_total=0;

            if(AdsDetalleNotaFactory.CabeceraComprobante_create.boolean_asociar == true){ //CUANDO SE ASOCIA CON UNA GUIA

                for (x=0;x<AdsDetalleNotaFactory.Detalle_comprobante.length;x++){
                    

                    var cantidad = AdsDetalleNotaFactory.Detalle_comprobante[x].unidades;
                    var precio = AdsDetalleNotaFactory.Detalle_comprobante[x].precio;

                    acum_subtotal = acum_subtotal + (cantidad*precio);
                    
                    // REDONDEANDO A 2 DECIMAS
                    acum_subtotal = Math.round(acum_subtotal * 100) / 100;
                }
            }
            else{ // CUANDO ES EL FUNCIONAMIENTO NORMAL

                for (x=0;x<AdsDetalleNotaFactory.Detalle_comprobante.length;x++){

                    var cantidad = AdsDetalleNotaFactory.Detalle_comprobante[x].cantidad;
                    var precio = AdsDetalleNotaFactory.Detalle_comprobante[x].precio;

                    acum_subtotal = acum_subtotal + (cantidad*precio);
                    
                    // REDONDEANDO A 2 DECIMAS
                    acum_subtotal = Math.round(acum_subtotal * 100) / 100;
                }
            }

                var var_igv = acum_subtotal * valor_igv;
                // REDONDEANDO A 2 DECIMAS
                var_igv = Math.round(var_igv * 100) / 100;
                var var_total = acum_subtotal + var_igv;
                // REDONDEANDO A 2 DECIMAS
                var_total = Math.round(var_total * 100) / 100;



            // var sub_total = acum_total /valor_dividir;
            // // REDONDEANDO A 2 DECIMAS
            // sub_total = Math.round(sub_total * 100) / 100;

            // var var_igv = sub_total * valor_igv;
            // // REDONDEANDO A 2 DECIMAS
            // var_igv = Math.round(var_igv * 100) / 100;

            // CALCULO PARA AGENTE RETENEDOR
            var valor_retencion = 0;
            var valor_importe_aplicado = 0;
            if(AdsDetalleNotaFactory.Cliente_seleccionado.agente_retenedor == 'true')
            {
                valor_retencion = var_total*0.03;
                // REDONDEANDO A 2 DECIMAS
                valor_retencion = Math.round(valor_retencion * 100) / 100;

                valor_importe_aplicado = var_total - valor_retencion;
            }

                angular.element(subtotal).val(acum_subtotal);
                angular.element(igv).val(var_igv);
                angular.element(total).val(var_total);


            // angular.element(subtotal).val(sub_total);
            // angular.element(igv).val(var_igv);
            // angular.element(total).val(acum_total);
            if(var_total >= 700){
                angular.element(retencion).val(valor_retencion);
                angular.element(importe_aplicado).val(valor_importe_aplicado);
            }
            else {
                angular.element(retencion).val(0);
                angular.element(importe_aplicado).val(0);
            }
        }


        return AdsDetalleNotaFactory;
 
    });


    function mueveReloj(){ 
        var momentoActual = new Date();
        var hora = momentoActual.getHours();
        var minuto = momentoActual.getMinutes();
        var segundo = momentoActual.getSeconds();
        var horaImprimible = hora + " : " + minuto + " : " + segundo;
        document.getElementById("Hora_Actual").innerHTML = horaImprimible;
        setTimeout("mueveReloj()",1000);
    }
    window.onload=function(){
        mueveReloj();
    }

    function formatNumber(num, simbol){
            
        var separador = ","; // separador para los miles
        var sepDecimal = '.'; // separador para los decimales

        num =  Math.round(num*100)/100; // permite redondear el valor a dos decimales
        num +='';
        var splitStr = num.split('.');
        var splitLeft = splitStr[0];
        var splitRight = splitStr.length > 1 ? sepDecimal + splitStr[1] : '';
        var regx = /(\d+)(\d{3})/;
        while (regx.test(splitLeft)) {
            splitLeft = splitLeft.replace(regx, '$1' + separador + '$2');
        }
        return simbol + splitLeft  +splitRight;
    }

</script>

@endsection
