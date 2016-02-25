@extends('templates.layout')

@section('title')
Registro de Servicios
@endsection

@section('head')

@endsection

@section('breadcrumb')
    <!----><h1><small></small></h1>
    <ol class="breadcrumb">
        <li><a href="{{asset('/')}}"><i class="fa fa-home"></i> Principal</a></li>
        <li><a href="{{asset('/')}}"><i class="fa fa-fw fa-shopping-cart"></i> Módulo de Compras</a></li>
        <li class="active"><i class="fa fa-fw fa-building-o"></i> Facturas de Servicios</li>
    </ol>
@endsection

@section('content')
<div ng-app="myApp" ng-controller="AdsComprobanteServicio as ComprobanteCtrl" class="container-fluid">

    <div class="row">
        <div class="col-xs-12">
            <div id="box-comprobante" class="box box-solid box-primary">
                <div class="box-header"> 
                    <i class="fa fa-file-o"></i>
                    <h3 class="box-title">Factura de Servicios</h3>
                </div>
                <div class="box-body">
                    <!--
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h2>Factura de Compra</h2>
                        </div>
                    </div>
                    --> 
                    <form id="form_cabecera" style="margin-top: 15px;">                    
                        <div class="row form-group">
                            <div class="col-md-2 text-right" style="padding-top: 4px;">
                                <span>N° Serie:</span>
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control validate[required,minSize[3]]" maxlength="3" ng-model="ComprobanteCtrl.cabecera.serie_comprobante">
                                <!--<input type="text" class="form-control validate[required,minSize[3]]" maxlength="3" ng-model="ComprobanteCtrl.cabecera.serie_comprobante"  data-inputmask='"mask": "999"' data-mask>-->
                            </div>
                            <div class="col-md-1 text-right" style="padding-top: 4px;">
                                Moneda:
                            </div>
                            <div class="col-md-2">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-dollar"></i>
                                    </span>
                                    <select id="moneda" class="form-control validate[required]" ng-model="ComprobanteCtrl.cabecera.moneda" ng-options="item as item.nombre_moneda for item in ComprobanteCtrl.monedas track by item.id">
                                        <option value="">-- Seleccione --</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1 text-right" style="padding-top: 4px;">
                                Hora:
                            </div>
                            <div class="col-md-2">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-clock-o"></i>
                                    </span>
                                    <label name="Hora_Actual" id="Hora_Actual" class="form-control"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 text-right" style="padding-top: 4px;">
                                N° Comprobante: 
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control validate[required]" maxlength="20" ng-model="ComprobanteCtrl.cabecera.numero_comprobante">
                            </div>
                            <div class="col-md-1 text-right" style="padding-top: 4px;">
                                Fecha:
                            </div>
                            <div class="col-md-2">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <input type="text" id="fecha_comprobante" class="form-control validate[required]" datepicker-popup="/% format %/" ng-model="ComprobanteCtrl.fecha_comprobante" ng-change="ComprobanteCtrl.validar_tipoCambio()" is-open="opened_fec_inicio" current-text="Hoy" weeks-text="Semanas" close-text="Cerrar" />
                                </div>
                            </div>
                            <div class="col-md-1 text-right">
                                ¿Incluye IGV?
                            </div>
                            <div class="col-md-2">
                                <input type="checkbox" id="incluido_igv" ng-model="ComprobanteCtrl.cabecera.incluido_igv" ng-change="ComprobanteCtrl.calcular_total()">
                            </div>
                        </div>
                        <hr>
                        <div class="row form-group">
                            <div class="col-md-2 text-right" style="padding-top: 4px;">
                                Proveedor: 
                            </div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <a href="" ng-click="ComprobanteCtrl.buscarProveedor()" class="input-group-addon">
                                        <i class="fa fa-search"></i>
                                    </a>
                                    <angucomplete-alt id="proveedor" placeholder="Proveedor" maxlength="50" pause="100" selected-object="ComprobanteCtrl.seleccion_angucompleteproveedor" local-data="ComprobanteCtrl.angucomplete_proveedores" search-fields="razon_social" title-field="razon_social" minlength="1" input-class="form-control form-control-small validate[required]" match-class="highlight" field-required="true">
                                    </angucomplete-alt>
                                    <a href="" ng-click="ComprobanteCtrl.nuevoProveedor()" class="input-group-addon">
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <input type="text" id="ruc" class="form-control" placeholder="RUC" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 text-right" style="padding-top: 4px;">
                                Direccion: 
                            </div>
                            <div class="col-md-8">
                                <input type="text" id="direccion" class="form-control" placeholder="Direccion" disabled>
                            </div>
                        </div>
                    </form>
                    <hr>
                    <form id="form_detalle">
                        <div class="row form-group">
                            <div class="col-md-2 text-right" style="padding-top: 4px;">
                                Servicio
                            </div>

                            <div class="col-md-2" style="padding-top: 4px;">
                                <div class="radio" style="margin-top:0;">
                                    <label>
                                        <input type="radio" ng-model="ComprobanteCtrl.detalle_comprobante.tipo_servicio_seleccionado" ng-value="{id:1,nombre_tipoServicio:'Producción'}">
                                        Producción
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-2" style="padding-top: 4px;">
                                <div class="radio" style="margin-top:0;">
                                    <label>
                                        <input type="radio" ng-model="ComprobanteCtrl.detalle_comprobante.tipo_servicio_seleccionado" ng-value="{id:2,nombre_tipoServicio:'Transporte'}">
                                        Transporte
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-2 text-right" ng-if="ComprobanteCtrl.detalle_comprobante.tipo_servicio_seleccionado.id == 1" style="padding-top: 4px;">
                                Detalle Servicio
                            </div>
                            <div id="div_detalle_tipo_servicio" class="col-md-2" ng-if="ComprobanteCtrl.detalle_comprobante.tipo_servicio_seleccionado.id == 1">
                                <select class="form-control validate[required]" ng-model="ComprobanteCtrl.detalle_comprobante.detalle_tipo_servicio_seleccionado" ng-options="item as item.nombre_detalleTipoServicio for item in ComprobanteCtrl.detalleTipoServicios track by item.id">
                                    <option value="">-- Seleccione --</option>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group" ng-if="ComprobanteCtrl.detalle_comprobante.tipo_servicio_seleccionado.id != 2">
                            <div class="col-md-2 text-right" style="padding-top: 4px;">
                                Producto
                            </div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <angucomplete-alt id="nom_producto" placeholder="Nombre Producto" pause="100" selected-object="ComprobanteCtrl.seleccion_angucompleteproducto" local-data="ComprobanteCtrl.angucomplete_productos" search-fields="nombre_producto" title-field="nombre_producto" minlength="1" input-class="form-control form-control-small validate[required]" match-class="highlight" field-required="true">
                                    </angucomplete-alt>
                                    <a href="" ng-click="ComprobanteCtrl.buscarProducto()" class="input-group-addon">
                                        <i class="fa fa-search"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-1 text-right" ng-if="ComprobanteCtrl.detalle_comprobante.detalle_tipo_servicio_seleccionado.id == 2" style="padding-top: 4px;">
                                Color
                            </div>
                            <div id="div_detalle_tipo_servicio" class="col-md-2" ng-if="ComprobanteCtrl.detalle_comprobante.detalle_tipo_servicio_seleccionado.id == 2">
                                <select class="form-control validate[required]" ng-model="ComprobanteCtrl.detalle_comprobante.color_seleccionado" ng-options="item as item.nombre_color for item in ComprobanteCtrl.colores track by item.id">
                                    <option value="">-- Seleccione --</option>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group" ng-if="ComprobanteCtrl.detalle_comprobante.tipo_servicio_seleccionado.id != 2">
                            <div class="col-md-2 text-right" style="padding-top: 4px;">
                                Cantidad
                            </div>
                            <div class="col-md-2">
                                <input type="hidden" id="id_producto" ng-model="ComprobanteCtrl.detalle_comprobante.id_producto" class="form-control validate[required,custom[integer]]" placeholder="Cantidad">
                                <input type="number" id="cantidad_producto" ng-model="ComprobanteCtrl.detalle_comprobante.cantidad" class="form-control validate[required,custom[number]]" placeholder="Cantidad">
                            </div>
                        </div>
                        <div class="row form-group" ng-if="ComprobanteCtrl.detalle_comprobante.tipo_servicio_seleccionado.id != 2">
                            <div class="col-md-2 text-right" style="padding-top: 4px;">
                                Precio 
                                <p id="label_precio" style="color:red;"></p>
                            </div>
                            <div class="col-md-2">
                                <input type="text" id="precio_producto" ng-model="ComprobanteCtrl.detalle_comprobante.precio" class="form-control validate[required]" placeholder="Precio">
                            </div>
                            <div class="col-md-2">
                                <a ng-click="ComprobanteCtrl.agregar_detalle()" class="btn btn-flat btn-success btn-block"><i class="fa fa-plus" style="vertical-align: middle;"></i><span style="padding-left: 8px;">Agregar Producto</span></a>
                            </div>
                        </div>
                    </form>
                    <hr>
                    <div class="form-group row">
                        <div  class="col-md-12">       
                            <table class="table table-striped text-center" style="background-color: #E0E4EB;">
                                <thead >
                                    <tr>
                                        <th>ITEM</th>
                                        <th style="width : 10%">CANTIDAD</th>
                                        <th>DESCRIPCION</th>
                                        <th style="width : 10%">PRECIO</th>
                                        <th>IMPORTE</th>
                                        <th ng-if="ComprobanteCtrl.detalle_comprobante.tipo_servicio_seleccionado.id != 2">...</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="x in ComprobanteCtrl.detalles_comprobante track by $index" ng-if="ComprobanteCtrl.detalle_comprobante.tipo_servicio_seleccionado.id != 2">
                                        <td>/% $index + 1 %/</td>
                                        <td><input type="text" ng-model="ComprobanteCtrl.detalles_comprobante[$index].cantidad" ng-init="ComprobanteCtrl.detalles_comprobante[$index].cantidad = x.cantidad" class="form-control text-center" ng-change="ComprobanteCtrl.calcular_total()"></td>
                                        <td ng-if="x.color != ''">/% "SERVICIO DE " + x.detalle_tipo_servicio+" A TELA "+x.producto+" COLOR "+x.color %/</td>
                                        <td ng-if="x.color == ''">/% "SERVICIO DE " + x.detalle_tipo_servicio+" A TELA "+x.producto %/</td>
                                        <td><input type="text" ng-model="ComprobanteCtrl.detalles_comprobante[$index].precio" ng-init="ComprobanteCtrl.detalles_comprobante[$index].precio = x.precio" class="form-control text-center" ng-change="ComprobanteCtrl.calcular_total()"></td>
                                        <td>/% x.cantidad*x.precio %/</td>
                                        <td>
                                            <button ng-click="ComprobanteCtrl.eliminar($index)" class="btn btn-danger"> <i class="fa fa-trash" data-toggle="tooltip" title="Eliminar Registro"></i></button> 
                                        </td>
                                    </tr>
                                    <tr ng-repeat="y in ComprobanteCtrl.detalles_comprobante_servicio track by $index" ng-if="ComprobanteCtrl.detalle_comprobante.tipo_servicio_seleccionado.id == 2">
                                        <td>/% $index + 1 %/</td>
                                        <td>/% y.cantidad %/</td>
                                        <td>/% y.descripcion %/</td>
                                        <td><input type="text" ng-model="ComprobanteCtrl.detalles_comprobante_servicio[$index].precio" ng-init="ComprobanteCtrl.detalles_comprobante_servicio[$index].precio = y.precio" class="form-control text-center" ng-change="ComprobanteCtrl.calcular_total()"></td>
                                        <td>/% y.cantidad*y.precio %/</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-2 col-md-offset-8 text-right">
                            <label>SubTotal : </label>
                        </div>
                        <div class="col-md-2">
                            <input type="number" id="subtotal" class="form-control" placeholder="SubTotal" disabled>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-2 col-md-offset-8 text-right">
                            <label>IGV (<?php echo (DB::table('ts_igv')->where('estado', 'true')->pluck('valor_igv'))*100; ?>%) : </label>
                        </div>
                        <div class="col-md-2">
                            <input type="number" id="igv" class="form-control" placeholder="IGV" disabled>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-2 col-md-offset-8 text-right">
                            <label>Total : </label>
                        </div>
                        <div class="col-md-2">
                            <input type="number" id="total" class="form-control" placeholder="Total" disabled>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-2 col-md-offset-8 text-right">
                            <label>Detracción : </label>
                        </div>
                        <div class="col-md-2">
                            <input type="number" id="detraccion" class="form-control" placeholder="Detraccion" disabled>
                        </div>
                    </div>

                    <div class="row form-group" style="margin-bottom: 25px;">
                        <div class="col-md-2 col-md-offset-8 text-right">
                            <label>Importe Aplicado : </label>
                        </div>
                        <div class="col-md-2">
                            <input type="number" id="importe_aplicado" class="form-control" placeholder="Importe Aplicado" disabled>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-3 col-md-offset-3">
                            <a ng-click="ComprobanteCtrl.imprimir()" target="_blank" class="btn btn-flat btn-primary btn-block"><i class="fa fa-print"></i> Imprimir</a>
                        </div>
                        <div class="col-md-3">
                            <a ng-click="ComprobanteCtrl.store(ComprobanteCtrl.detalles_venta,ComprobanteCtrl.cabecera_venta)" class="btn btn-flat btn-success btn-block"><i class="fa fa-dollar"></i> Procesar Venta</a>
                        </div>
                        <div class="col-md-3">
                            <!-- <a href="main" class="btn btn-flat btn-danger btn-block"><i class="fa fa-minus"></i> Cancelar</a> -->
                            <a ng-click="ComprobanteCtrl.cancelar_comprobante()" class="btn btn-flat btn-danger btn-block"><i class="fa fa-minus"></i> Cancelar</a>
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
    // angular.element(incluido_igv).bootstrapSwitch();
    // angular.element(document).ready(function(){
    //     $("#incluido_igv").bootstrapSwitch();
    // });

    /* Permite ejecutar la mascara del input */
    $("[data-mask]").inputmask();

    //$("#date").inputmask("d/m/y",{ "onincomplete": function(){ alert('inputmask incomplete'); } });

    var app = angular.module('myApp',[ 'ui.bootstrap','ngRoute','angucomplete-alt']);

    app.config(function($interpolateProvider){
        $interpolateProvider.startSymbol('/%');
        $interpolateProvider.endSymbol('%/');
    });


    app.controller('AdsComprobanteServicio', function AdsComprobanteServicio(ComprobanteServicioFactory){
  
        var vm = this;
        vm.detalles_comprobante = ComprobanteServicioFactory.Detalle_comprobante; 
        vm.detalles_comprobante_servicio= ComprobanteServicioFactory.Detalle_comprobante_servicio; 
        vm.cabecera = ComprobanteServicioFactory.CabeceraComprobante_create; 
        vm.cabecera.incluido_igv = false;

        vm.angucomplete_productos = ComprobanteServicioFactory.Productos;
        vm.angucomplete_proveedores = ComprobanteServicioFactory.Proveedores;
        vm.monedas = ComprobanteServicioFactory.Monedas;
        vm.colores = ComprobanteServicioFactory.Colores;
        vm.detalleTipoServicios=[
                                    {'id' : 1 , 'nombre_detalleTipoServicio' : 'TEJIDO'}
                                    ,{'id' : 2 ,'nombre_detalleTipoServicio' : 'TEÑIDO'}
                                ];


        vm.fecha_comprobante = ComprobanteServicioFactory.FechaComprobante;


        
        vm.prueba = function(){
            // console.log(vm.cabecera);
            console.log(vm.detalle_comprobante.tipo_servicio_seleccionado);
            // ComprobanteServicioFactory.FechaComprobante = null;
        }

        vm.cancelar_comprobante = function(){

            ComprobanteServicioFactory.cancelar_comprobante();

        }

        vm.validar_tipoCambio = function(){

            var fecha = new XDate(vm.fecha_comprobante).toString('yyyy-MM-dd');

            console.log(ComprobanteServicioFactory.validar_tipoCambio(fecha));
            
        }
        vm.imprimir = function(){

            if($("#form_cabecera").validationEngine('validate')){

                if(vm.detalles_comprobante[0]!=null){

                    var cabecera_create = {
                            serie : vm.cabecera.serie_comprobante
                            , numero : vm.cabecera.numero_comprobante
                            , fecha : new XDate(vm.fecha_comprobante).toString('yyyy-MM-dd')
                            , cliente : ComprobanteServicioFactory.Proveedor_seleccionado
                            , moneda : vm.cabecera.moneda
                            , incluido_igv : vm.cabecera.incluido_igv
                            , hora : angular.element(Hora_Actual).text()
                        };

                    var detalle_create = vm.detalles_comprobante;

                    var totales_create = {
                            subtotal : angular.element(subtotal).val()
                            , igv : angular.element(igv).val()
                            , total : angular.element(total).val()
                        };
                    // if(vm.cliente_angucomp_select)
                    // {
                    //     cabecera.id_cliente = vm.cliente_angucomp_select.description.id;
                    // }
                    
                    ComprobanteServicioFactory.imprimir(cabecera_create,detalle_create,totales_create);
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

        vm.seleccion_angucompleteproveedor = function(object){

            angular.copy(object.description,ComprobanteServicioFactory.Proveedor_seleccionado)
            angular.element(proveedor_value).val(ComprobanteServicioFactory.Proveedor_seleccionado.razon_social);
            angular.element(ruc).val(ComprobanteServicioFactory.Proveedor_seleccionado.ruc);
            angular.element(direccion).val(ComprobanteServicioFactory.Proveedor_seleccionado.direccion);
        }

        ComprobanteServicioFactory.getProductos();
        // ComprobanteServicioFactory.getClientes();
        ComprobanteServicioFactory.getProveedores();
        ComprobanteServicioFactory.getMonedas();
        ComprobanteServicioFactory.getColores();

        var acum_total=0;

        //Configuracion para FECHA

        vm.today = function() {
            vm.fecha_comprobante = new Date();
        }
        vm.clear = function () {
            vm.fecha_comprobante = null;
        }
        vm.open = function($event) {
            $event.preventDefault();
            $event.stopPropagation();
            vm.opened_fec_inicio = true;
        }

        vm.dateOptions = {
            formatYear: 'yy',
            startingDay: 1,
        }

        vm.formats = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
        vm.format = vm.formats[1];
        

        vm.seleccion_angucompleteproducto = function(object){
            if(object.description.precio_unitario == null) object.description.precio_unitario=0;
            angular.element(id_producto).val(object.description.id);
            // angular.element(label_precio).text('Mínimo.: '+object.description.precio_unitario);
            // angular.element(precio_producto).removeClass('validate[required]');
            // angular.element(precio_producto).addClass('validate[required,min['+object.description.precio_unitario+']]');
            

            angular.copy(object.description, ComprobanteServicioFactory.Producto_seleccionado);
        }
        
        vm.eliminar = function(index){
            ComprobanteServicioFactory.deleteAttempt(index);
        }
        
        vm.create = function(){
            ComprobanteServicioFactory.create();
        }

        vm.store = function(){
            if($("#form_cabecera").validationEngine('validate')){
                if(vm.detalle_comprobante.tipo_servicio_seleccionado.id == 1)
                {
                    if(vm.detalles_comprobante[0]!=null){
                        var cabecera_create = {
                                serie : vm.cabecera.serie_comprobante
                                , numero : vm.cabecera.numero_comprobante
                                , fecha : new XDate(vm.fecha_comprobante).toString('yyyy-MM-dd')
                                , cliente : ComprobanteServicioFactory.Proveedor_seleccionado
                                , moneda : vm.cabecera.moneda
                                , incluido_igv : vm.cabecera.incluido_igv
                                , total : angular.element(total).val()
                                , tipo_servicio : vm.detalle_comprobante.tipo_servicio_seleccionado
                                , detraccion : angular.element(detraccion).val()
                        };
                        var detalle_create = vm.detalles_comprobante;
                        // if(vm.cliente_angucomp_select)
                        // {
                        //     cabecera.id_cliente = vm.cliente_angucomp_select.description.id;
                        // }
                        ComprobanteServicioFactory.store(cabecera_create,detalle_create);  
                    }
                    else{
                        alert('Debe agregar un detalle al comprobante.');
                    }
                }
                else if(vm.detalle_comprobante.tipo_servicio_seleccionado.id == 2)
                {
                    var cabecera_create = {
                            serie : vm.cabecera.serie_comprobante
                            , numero : vm.cabecera.numero_comprobante
                            , fecha : new XDate(vm.fecha_comprobante).toString('yyyy-MM-dd')
                            , cliente : ComprobanteServicioFactory.Proveedor_seleccionado
                            , moneda : vm.cabecera.moneda
                            , incluido_igv : vm.cabecera.incluido_igv
                            , total : angular.element(total).val()
                            , tipo_servicio : vm.detalle_comprobante.tipo_servicio_seleccionado
                            , detraccion : angular.element(detraccion).val()
                    };
                    var detalle_create = vm.detalles_comprobante_servicio;
                    // if(vm.cliente_angucomp_select)
                    // {
                    //     cabecera.id_cliente = vm.cliente_angucomp_select.description.id;
                    // }
                    ComprobanteServicioFactory.store(cabecera_create,detalle_create); 
                }
                
            }
            // vm.tipo_local={};
        }

        vm.buscarProducto = function(){
            ComprobanteServicioFactory.buscarProducto();
        }

        vm.buscarProveedor = function(){
            ComprobanteServicioFactory.buscarProveedor();
        }

        vm.nuevoProveedor = function(){
            ComprobanteServicioFactory.nuevoProveedor();
        }

        // vm.buscarCliente = function(){
        //     ComprobanteServicioFactory.buscarCliente();
        // }

        vm.set_codebar = function(){
            var posicion = vm.detalle_venta.codebar.indexOf('-');
            var id_producto = parseInt(vm.detalle_venta.codebar.substring(posicion+1));
            ComprobanteServicioFactory.getProductoByIdFromInvetarioProd(id_producto);
        }

        vm.agregar_detalle = function(){
            console.log(vm.detalle_comprobante);
            if($("#form_detalle").validationEngine('validate')){      

                ComprobanteServicioFactory.agregar_detalle(vm.detalle_comprobante);
                angular.element(nom_producto_value).val('');
                vm.detalle_comprobante.cantidad = '';
                vm.detalle_comprobante.unidadMedida = '';
                vm.detalle_comprobante.precio = '';

            }
        }

        vm.calcular_total = function(){
            ComprobanteServicioFactory.calcular_total(vm.detalle_comprobante.tipo_servicio_seleccionado.id);
        }
 
    });



 
    app.factory('ComprobanteServicioFactory', function ComprobanteServicioFactory($http, $modal ) {

        ComprobanteServicioFactory.detalle_venta = {}; 
        ComprobanteServicioFactory.cabecera_venta = {}; 
        ComprobanteServicioFactory.detalle_venta.producto = {}; 
        ComprobanteServicioFactory.seleccion_producto = {}; 
        ComprobanteServicioFactory.Producto_create = {};
        ComprobanteServicioFactory.Proveedor_create = {};
        ComprobanteServicioFactory.Detalle_venta_edit = {};

        ComprobanteServicioFactory.Productos = [];
        ComprobanteServicioFactory.Proveedores = [];
        ComprobanteServicioFactory.Monedas = [];
        ComprobanteServicioFactory.Colores = [];

        ComprobanteServicioFactory.Detalle_comprobante = [];
        ComprobanteServicioFactory.Detalle_comprobante_servicio = [{id_producto:null,id_color:null,id_detalle_tipo_servicio:null,descripcion:'SERVICIO DE TRANSPORTE',cantidad:1,precio:0}];
        ComprobanteServicioFactory.Proveedor_seleccionado = {};
        ComprobanteServicioFactory.Producto_seleccionado = {};

        ComprobanteServicioFactory.CabeceraComprobante_create = {};
        ComprobanteServicioFactory.DetalleComprobante_create = {};
        ComprobanteServicioFactory.TipoCambio_create = {};

        ComprobanteServicioFactory.CabeceraComprobante_create.incluido_igv = false;

        var fecha_actual = new XDate(new Date()).toString('yyyy-MM-dd');
        ComprobanteServicioFactory.FechaComprobante = fecha_actual;


        ComprobanteServicioFactory.cancelar_comprobante = function(){
            $modal.open( { 
                templateUrl:'templates_angular/ComprobanteServicioController/cancelar_comprobante.html', 
                controller: function($scope, $modalInstance, ComprobanteServicioFactory) {
                    $scope.yes = function() {
                        angular.copy({},ComprobanteServicioFactory.Detalle_comprobante); 
                        angular.copy({},ComprobanteServicioFactory.CabeceraComprobante_create); 

                        ComprobanteServicioFactory.CabeceraComprobante_create.incluido_igv = false;

                        angular.element(proveedor_value).val('');
                        angular.element(ruc).val('');
                        angular.element(direccion).val('');

                        angular.element(subtotal).val('');
                        angular.element(igv).val('');
                        angular.element(total).val('');

                        angular.element(id_producto).val('');

                        $modalInstance.close();
                    }
                }
            });
        }

        ComprobanteServicioFactory.validar_tipoCambio = function(fecha) {
            $http.post('AdsComprobanteServicio/validar_tipoCambio', {fecha:fecha})
                .success(function(data){
                    if(data == 'EXISTE'){
                        console.log('existe');
                    }
                    else if(data == 'NO EXISTE'){
                        $modal.open( { 
                            templateUrl:'templates_angular/ComprobanteServicioController/confirmacion_tipoCambio.html', 
                            controller: function($scope, $modalInstance, ComprobanteServicioFactory, TipoCambio_create) {
                                
                                $scope.tipoCambio = TipoCambio_create;

                                $scope.store = function() {
                                    $scope.tipoCambio.fecha = fecha;
                                    ComprobanteServicioFactory.storeTipoCambio($scope.tipoCambio).then(function(){

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
                                    return ComprobanteServicioFactory.TipoCambio_create;
                                }
                            }
                        });
                        console.log('no existe');
                    }
                });
        }


        ComprobanteServicioFactory.storeTipoCambio = function(scope) {
                 return $http.post('AdsTipoCambioMoneda', scope)
                    .success(function(data){

                    });
        }
        


        ComprobanteServicioFactory.imprimir = function(cabecera, detalle, totales) {
            $http.post('AdsComprobanteServicio/imprimir', {cabecera:cabecera, detalle:detalle, totales:totales})
                .success(function(data){
                    // var ficha=document.getElementById("box-comprobante");
                    // console.log(data.toHtmlObject);
                    var htmlObject = document.createElement('html');
                    htmlObject.innerHTML = data;
                    console.log(htmlObject);
                    // htmlObject.getElementById("myDiv").style.marginTop = something;
                    var ventimp=window.open(' ','popimpr');
                    ventimp.document.write(htmlObject.innerHTML);
                    ventimp.document.close();
                    ventimp.print();
                    ventimp.close();
                });
        }

        ComprobanteServicioFactory.getProductos = function() {
            return $http.get('AdsProducto/getAllProductos').success(function(data) {
                console.log(data.datos);
                angular.copy(data.datos, ComprobanteServicioFactory.Productos);

            });
        }

        // ComprobanteServicioFactory.getClientes = function() {
        //     return $http.get('PtvCliente/getAllClientes').success(function(data) {
        //         angular.copy(data.datos, ComprobanteServicioFactory.Proveedores);
        //     });
        // } 

        ComprobanteServicioFactory.getProveedores = function() {
            return $http.get('AdsProveedor/getAllProveedores').success(function(data) {
                console.log(data.datos);
                angular.copy(data.datos, ComprobanteServicioFactory.Proveedores);
            });
        } 

        ComprobanteServicioFactory.getMonedas = function() {
            return $http.get('AdsMoneda/getAllMonedas').success(function(data) {
                angular.copy(data.datos, ComprobanteServicioFactory.Monedas);
            });
        } 

        ComprobanteServicioFactory.getColores = function() {
            return $http.get('AdsColor/getAllColor').success(function(data) {
                angular.copy(data.datos, ComprobanteServicioFactory.Colores);
                console.log('COLORES');
                console.log(ComprobanteServicioFactory.Colores);
            });
        } 


        ComprobanteServicioFactory.deleteAttempt = function(index) {
            $modal.open( { 
                templateUrl:'templates_angular/deleteAttemp.html', 
                controller: function($scope, $modalInstance, ComprobanteServicioFactory) {
                    $scope.yes = function() {
                        ComprobanteServicioFactory.Detalle_comprobante.splice(index,1);
                        ComprobanteServicioFactory.calcular_total(1);
                        $modalInstance.close();
                    }
                }
            });
        }  


        ComprobanteServicioFactory.store = function(cabecera, detalle) {
                 $http.post('AdsComprobanteServicio', {cabecera:cabecera, detalle:detalle})
                    .success(function(data){
                        if(data.datos=='correcto'){
                            // angular.copy({},ComprobanteServicioFactory.detalles_venta);
                            // angular.copy({},ComprobanteServicioFactory.detalle_venta);
                            // angular.copy({},ComprobanteServicioFactory.cabecera_venta);      

                            angular.element(proveedor_value).val('');
                            angular.element(ruc).val('');
                            angular.element(direccion).val('');

                            angular.element(subtotal).val('');
                            angular.element(igv).val('');
                            angular.element(total).val('');

                            if(cabecera.tipo_servicio.id == 2){
                                console.log('ENTRO A BORRAR');
                                angular.copy({},ComprobanteServicioFactory.Detalle_comprobante_servicio); 
                            }
                            else{
                                angular.element(id_producto).val('');
                                console.log('NOOOOOOOOO ENTRO A BORRAR');
                                angular.copy({},ComprobanteServicioFactory.Detalle_comprobante); 
                            }

                            angular.element(detraccion).val('');
                            angular.element(importe_aplicado).val('');

                            angular.copy({},ComprobanteServicioFactory.CabeceraComprobante_create); 

                            ComprobanteServicioFactory.CabeceraComprobante_create.incluido_igv = false;
                            ComprobanteServicioFactory.getProductos();

                            $modal.open({
                                templateUrl: 'templates_angular/ComprobanteCompraController/msj_exito.html',
                                controller: function($scope, $modalInstance){
                                }
                            });

                        } 
                        else if(data.datos == 'duplicidad'){
                            alert('¡Existe otro comprobante de compra con estos datos!');
                        }
                    });
        }
        

        ComprobanteServicioFactory.buscarProducto = function(){
            $modal.open({
                templateUrl: 'templates_angular/ProductoController/seleccion_producto.html',
                controller: function($scope, $modalInstance, Producto_create, Productos){
                    $scope.producto_create = Producto_create;
                    $scope.productos = Productos;

                    $scope.seleccionar = function(data){

                        // if(data.precio_unitario == null) data.precio_unitario = 0;
                        // angular.element(label_precio).text('Mínimo: '+data.precio_unitario);
                        
                        // angular.element(precio_producto).removeClass('validate[required]');
                        // angular.element(precio_producto).addClass('validate[required,min['+data.precio_unitario+']]');
                    
                        angular.copy(data, ComprobanteServicioFactory.Producto_seleccionado);
                        angular.element(nom_producto_value).val(ComprobanteServicioFactory.Producto_seleccionado.nombre_producto);

                        angular.element(id_producto).val(ComprobanteServicioFactory.Producto_seleccionado.id);
                        $modalInstance.close();
                    }
                },
                resolve: {
                    Producto_create : function(){
                        return ComprobanteServicioFactory.Producto_create;
                    },
                    Productos : function(){
                        return ComprobanteServicioFactory.Productos;
                    }
                }
            });
        }

        // ComprobanteServicioFactory.buscarCliente = function(){
        //     $modal.open({
        //         templateUrl: 'templates_angular/ClienteController/seleccion_cliente.html',
        //         controller: function($scope, $modalInstance, Cliente_create, Cliente){
        //             $scope.cliente_create = Cliente_create;
        //             $scope.cliente = Cliente;
        //             $scope.seleccionar = function(data){
        //                 angular.element(proveedor_value).val(data.razon_social);
        //                 angular.element(ruc).val(data.ruc);
        //                 angular.element(direccion).val(data.direccion);

        //                 angular.copy(data, ComprobanteServicioFactory.Proveedor_seleccionado);

        //                 $modalInstance.close();
        //             }
        //         },
        //         resolve: {
        //             Cliente_create : function(){
        //                 return ComprobanteServicioFactory.Proveedor_create;
        //             },
        //             Cliente : function(){
        //                 return ComprobanteServicioFactory.Proveedores;
        //             }
        //         }
        //     });
        // }


        ComprobanteServicioFactory.buscarProveedor = function(){
            $modal.open({
                templateUrl: 'templates_angular/ProveedorController/seleccion_proveedor.html',
                controller: function($scope, $modalInstance, Proveedor_create, Proveedor){
                    $scope.proveedor_create = Proveedor_create;
                    $scope.proveedor = Proveedor;
                    $scope.seleccionar = function(data){
                        angular.element(proveedor_value).val(data.razon_social);
                        angular.element(ruc).val(data.ruc);
                        angular.element(direccion).val(data.direccion);

                        angular.copy(data, ComprobanteServicioFactory.Proveedor_seleccionado);

                        $modalInstance.close();
                    }
                },
                resolve: {
                    Proveedor_create : function(){
                        return ComprobanteServicioFactory.Proveedor_create;
                    },
                    Proveedor : function(){
                        return ComprobanteServicioFactory.Proveedores;
                    }
                }
            });
        }


        ComprobanteServicioFactory.nuevoProveedor = function(){
            $modal.open({
                templateUrl: 'templates_angular/ProveedorController/create.html',
                controller: function($scope, $modalInstance, $filter){
                    /* El objeto creado del scope se utiliza en la vista */
                    $scope.proveedor = {};
                    $scope.store = function(){
                        if ( $("#create_form").validationEngine('validate') ) {
                            ComprobanteServicioFactory.storeProveedor($scope.proveedor); /* Objeto de la vista */
                            $modalInstance.close();
                        };
                    }
                },
                resolve: {
                    
                }
            });
        }

        ComprobanteServicioFactory.storeProveedor = function(Proveedor) {
            $http.post('AdsProveedor', Proveedor).success(function(data){
                ComprobanteServicioFactory.getProveedores();
            });
        }


        ComprobanteServicioFactory.agregar_detalle = function(detalle_comprobante){
            var entro = 0;
            var posicion_entro = 0;
            var cantidad_push = 0;
            for (var i = 0; i < ComprobanteServicioFactory.Detalle_comprobante.length; i++) {
                if(ComprobanteServicioFactory.Detalle_comprobante[i].id_producto == ComprobanteServicioFactory.Producto_seleccionado.id && ComprobanteServicioFactory.Detalle_comprobante[i].id_detalle_tipo_servicio == detalle_comprobante.detalle_tipo_servicio_seleccionado.id && ComprobanteServicioFactory.Detalle_comprobante[i].id_tipo_servicio == detalle_comprobante.tipo_servicio_seleccionado.id && ComprobanteServicioFactory.Detalle_comprobante[i].id_color == detalle_comprobante.color_seleccionado.id){
                    cantidad_push = parseFloat(ComprobanteServicioFactory.Detalle_comprobante[i].cantidad) + parseFloat(detalle_comprobante.cantidad);
                    entro = 1;
                    posicion_entro = i;
                }
                
            };

            if(entro == 1){
                ComprobanteServicioFactory.Detalle_comprobante[posicion_entro].cantidad = cantidad_push;
                ComprobanteServicioFactory.Detalle_comprobante[posicion_entro].precio = detalle_comprobante.precio;
            }
            else{

                // if(detalle_comprobante.tipo_servicio_seleccionado.id == 2){

                //     detalle_comprobante.detalle_tipo_servicio_seleccionado = {id:null, nombre_detalleTipoServicio:null};
                //     detalle_comprobante.color_seleccionado = {id : null,nombre_color : null};
                // }

                if(detalle_comprobante.detalle_tipo_servicio_seleccionado.id == 1){
                    detalle_comprobante.color_seleccionado = {id:null, nombre_color:''};
                    // detalle_comprobante.color_seleccionado.id = '';
                    // detalle_comprobante.color_seleccionado.nombre_color = '';
                }
                ComprobanteServicioFactory.Detalle_comprobante.push({
                                                                        id_producto : ComprobanteServicioFactory.Producto_seleccionado.id
                                                                        , producto : ComprobanteServicioFactory.Producto_seleccionado.nombre_producto
                                                                        , id_tipo_servicio : detalle_comprobante.tipo_servicio_seleccionado.id
                                                                        , tipo_servicio : detalle_comprobante.tipo_servicio_seleccionado.nombre_tipoServicio
                                                                        , id_detalle_tipo_servicio : detalle_comprobante.detalle_tipo_servicio_seleccionado.id
                                                                        , detalle_tipo_servicio : detalle_comprobante.detalle_tipo_servicio_seleccionado.nombre_detalleTipoServicio
                                                                        , id_color : detalle_comprobante.color_seleccionado.id
                                                                        , color : detalle_comprobante.color_seleccionado.nombre_color
                                                                        , cantidad : detalle_comprobante.cantidad
                                                                        , precio : detalle_comprobante.precio
                                                                    });
            }

            ComprobanteServicioFactory.calcular_total(detalle_comprobante.tipo_servicio_seleccionado.id);

        }

        ComprobanteServicioFactory.calcular_total = function(id_tipo_servicio){

            // var tipo_cambio_dolar = <?php echo DB::table('ts_tipocambiomoneda')->where('fecha', date("Y-m-d"))->pluck('valor_venta'); ?>;
            var valor_igv = <?php echo DB::table('ts_igv')->where('estado', 'true')->pluck('valor_igv'); ?>;
            var valor_dividir = valor_igv+1;
            var Array_detalle = [];
            if(id_tipo_servicio == 1)
            {
                angular.copy(ComprobanteServicioFactory.Detalle_comprobante,Array_detalle);
            }
            else if(id_tipo_servicio == 2)
            {
                angular.copy(ComprobanteServicioFactory.Detalle_comprobante_servicio,Array_detalle);
                valor_detraccion = var_total * 0.04;
            }

            if(ComprobanteServicioFactory.CabeceraComprobante_create.incluido_igv == false)
            {
                var acum_subtotal=0;
                for (x=0;x<Array_detalle.length;x++){

                    var cantidad = Array_detalle[x].cantidad;
                    var precio = Array_detalle[x].precio;
                    // if(ComprobanteServicioFactory.CabeceraComprobante_create.moneda.id == 2)
                    // {
                    //     precio = precio * tipo_cambio_dolar;
                    // }

                    acum_subtotal = acum_subtotal + (cantidad*precio);

                    // REDONDEANDO A 2 DECIMAS
                    acum_subtotal = Math.round(acum_subtotal * 100) / 100;
                }
                var var_igv = acum_subtotal * valor_igv;
                // REDONDEANDO A 2 DECIMAS
                var_igv = Math.round(var_igv * 100) / 100;
                var var_total = acum_subtotal + var_igv;
                // REDONDEANDO A 2 DECIMAS
                var_total = Math.round(var_total * 100) / 100;


                var valor_detraccion = 0;
                var valor_importe_aplicado = 0;

                if(id_tipo_servicio == 1)
                {
                    valor_detraccion = var_total * 0.1;
                }
                else if(id_tipo_servicio == 2)
                {
                    valor_detraccion = 0;
                }

                valor_importe_aplicado = var_total - valor_detraccion;


                angular.element(subtotal).val(acum_subtotal);
                angular.element(igv).val(var_igv);
                angular.element(total).val(var_total);
                
                if(id_tipo_servicio == 1)
                {
                    if(var_total >= 700){
                    angular.element(detraccion).val(valor_detraccion);
                    angular.element(importe_aplicado).val(valor_importe_aplicado);
                    }
                    else {
                        angular.element(detraccion).val(0);
                        angular.element(importe_aplicado).val(0);
                    }
                }
                else {
                    angular.element(detraccion).val(0);
                    angular.element(importe_aplicado).val(0);
                }
                
                
            }
            else
            {
                var acum_total=0;
                for (x=0;x<Array_detalle.length;x++){

                    var cantidad = Array_detalle[x].cantidad;
                    var precio = Array_detalle[x].precio;
                    // if(ComprobanteServicioFactory.CabeceraComprobante_create.moneda.id == 2)
                    // {
                    //     precio = precio * tipo_cambio_dolar;
                    // }

                    acum_total = acum_total + (cantidad*precio);
                    
                    // REDONDEANDO A 2 DECIMAS
                    acum_total = Math.round(acum_total * 100) / 100;
                }
                var sub_total = acum_total /valor_dividir;
                // REDONDEANDO A 2 DECIMAS
                sub_total = Math.round(sub_total * 100) / 100;

                var var_igv = sub_total * valor_igv;
                // REDONDEANDO A 2 DECIMAS
                var_igv = Math.round(var_igv * 100) / 100;

                var valor_detraccion = 0;
                var valor_importe_aplicado = 0;

                if(id_tipo_servicio == 1)
                {
                    valor_detraccion = acum_total * 0.1;
                }
                else if(id_tipo_servicio == 2)
                {
                    valor_detraccion = 0;
                }

                valor_importe_aplicado = acum_total - valor_detraccion;

                angular.element(subtotal).val(sub_total);
                angular.element(igv).val(var_igv);
                angular.element(total).val(acum_total);

                if(id_tipo_servicio == 1)
                {
                    if(acum_total >= 700){
                        angular.element(detraccion).val(valor_detraccion);
                        angular.element(importe_aplicado).val(valor_importe_aplicado);
                    }
                    else {
                        angular.element(detraccion).val(0);
                        angular.element(importe_aplicado).val(0);
                    }
                }
                else{
                    angular.element(detraccion).val(0);
                    angular.element(importe_aplicado).val(0);
                }
                
                
            }
        }


        return ComprobanteServicioFactory;
 
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

</script>

@endsection
