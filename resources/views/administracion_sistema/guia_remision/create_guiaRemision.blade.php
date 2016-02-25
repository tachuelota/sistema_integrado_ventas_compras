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
        <li class="active"><i class="fa fa-fw fa-building-o"></i> Guías de Remisión</li>
    </ol>
@endsection

@section('content')
<div ng-app="myApp" ng-controller="AdsGuiaRemision as ComprobanteCtrl" class="container-fluid">

    <div class="row">
        <div class="col-xs-12">
            <div id="box-comprobante" class="box box-solid box-primary">
                <div class="box-header"> 
                    <i class="fa fa-file-o"></i>
                    <h3 class="box-title">Guia de Remision</h3>

                    <div class="navbar-custom-menu pull-right">
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
                                                <a href="#" ng-click="ComprobanteCtrl.modal_asociar()">
                                                    <i class="fa fa-files-o text-aqua"></i> Asociar con Factura de Venta
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    
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
                                N° Serie:
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control validate[required,minSize[3]]" maxlength="3" ng-model="ComprobanteCtrl.cabecera.serie_comprobante">
                            </div>
                            <div class="col-md-2 text-right" style="padding-top: 4px;">
                                N° Comprobante: 
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control validate[required]" maxlength="20" ng-model="ComprobanteCtrl.cabecera.numero_comprobante">
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
                        <hr>
                        <div class="row form-group">
                            
                            <div class="col-md-2">
                                Fecha de inicio de traslado:
                            </div>
                            <div class="col-md-2">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <input type="text" id="fecha_comprobante" class="form-control validate[required]" datepicker-popup="/% format %/" ng-model="ComprobanteCtrl.fecha_comprobante" is-open="opened_fec_inicio" current-text="Hoy" weeks-text="Semanas" close-text="Cerrar" />
                                </div>
                            </div>
                            <!-- <div class="col-md-2 text-right" style="padding-top: 4px;">
                                <span>Empresa Transporte:</span>
                            </div> -->
                            
                        </div>
                        <div class="row form-group">
                            <div class="col-md-2">
                                Destinatario:
                            </div>
                            <div class="col-md-7">
                                <div class="input-group">
                                    <a href="" ng-click="ComprobanteCtrl.buscarCliente()" class="input-group-addon">
                                        <i class="fa fa-search"></i>
                                    </a>
                                    <angucomplete-alt id="cliente" placeholder="Cliente" maxlength="50" pause="100" selected-object="ComprobanteCtrl.seleccion_angucompletecliente" local-data="ComprobanteCtrl.angucomplete_clientes" search-fields="razon_social" title-field="razon_social" minlength="1" input-class="form-control form-control-small validate[required]" match-class="highlight" field-required="true">
                                    </angucomplete-alt>
                                    <a href="" ng-click="ComprobanteCtrl.nuevoCliente()" class="input-group-addon">
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <input type="text" id="ruc" class="form-control" placeholder="RUC" disabled>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-2">
                                Punto de Partida: 
                            </div>
                            <div class="col-md-10">
                                <angucomplete-alt placeholder="Punto de Partida" id="punto_partida" pause="100" selected-object="ComprobanteCtrl.seleccion_angucompletepartida_guia" local-data="ComprobanteCtrl.angucomplete_partida" search-fields="punto_partida" title-field="punto_partida" minlength="1" input-class="form-control form-control-small validate[required]" match-class="highlight" field-required="true">
                                </angucomplete-alt>
                                <!-- <input type="text"class="form-control" ng-model="ComprobanteCtrl.cabecera.punto_partida" ng-init="ComprobanteCtrl.cabecera.punto_partida = 'Jr. Mariano Melgar Nro 144 Dpto. 3 - Urb. Pampa de Cueva - Lima - Independencia'"> -->
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-2">
                                Punto de Llegada: 
                            </div>
                            <div class="col-md-10">
                                <angucomplete-alt placeholder="Punto de Llegada" id="punto_llegada" pause="100" selected-object="ComprobanteCtrl.seleccion_angucompletellegada_guia" local-data="ComprobanteCtrl.angucomplete_llegada" search-fields="punto_llegada" title-field="punto_llegada" minlength="1" input-class="form-control form-control-small validate[required]" match-class="highlight" field-required="true">
                                </angucomplete-alt>
                                <!-- <input type="text" id="direccion" class="form-control" placeholder="Direccion"> -->
                            </div>
                        </div>
                        <hr>
                        
                        
                    <!-- <hr> -->
                        <div class="row form-group" style="margin-bottom: 0px;">
                            <div class="col-md-2" style="padding-top: 4px;">
                                Motivo del Traslado
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <a href="" ng-click="ComprobanteCtrl.abrir_motivo()" class="input-group-addon">
                                        <i class="fa fa-search"></i>
                                    </a>
                                    <input type="text" id="motivo" ng-model="ComprobanteCtrl.cabecera.Motivo_seleccionado.nombre_motivoTraslado" class="form-control validate[required]">
                                    <!-- <angucomplete-alt id="cliente" placeholder="Cliente" maxlength="50" pause="100" selected-object="ComprobanteCtrl.seleccion_angucompletecliente" local-data="ComprobanteCtrl.angucomplete_clientes" search-fields="razon_social" title-field="razon_social" minlength="1" input-class="form-control form-control-small validate[required]" match-class="highlight" field-required="true"> -->
                                    <!-- </angucomplete-alt> -->
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            
                            <div id="div_motivos" class="col-md-12" style="margin-left:10px !important;margin-top: 25px;" ng-if="ComprobanteCtrl.cabecera.Motivo_seleccionado == null">
                                <div class="col-md-2" ng-repeat="item in ComprobanteCtrl.motivos">
                                    <label>
                                        <div class="radio">
                                            <input type="radio" ng-model="ComprobanteCtrl.cabecera.Motivo_seleccionado" ng-value="item">
                                            <h6>/% item.nombre_motivoTraslado %/</h6>
                                        </div>
                                    </label>
                                    <!-- <angucomplete-alt id="motivo" placeholder="Motivo Traslado" pause="100" selected-object="ComprobanteCtrl.seleccion_angucompletemotivo" local-data="ComprobanteCtrl.motivos" search-fields="nombre_motivoTraslado" title-field="nombre_motivoTraslado" minlength="1" input-class="form-control form-control-small validate[required]" match-class="highlight" field-required="true"> -->
                                    <!-- </angucomplete-alt> -->
                                </div>  
                            </div>
                                                      
                        </div>
                    </form>
                    <hr>
                    <div class="row" ng-hide="ComprobanteCtrl.cabecera.boolean_asociar">

                    <form id="form_detalle">
                        <div class="row form-group">
                            <div class="col-md-2 text-center" style="padding-top: 4px;">
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
                            <div class="col-md-1 hide">
                                <input type="text" id="stock" class="form-control" placeholder="Stock" disabled>
                            </div>
                            <div class="col-md-2 hide">
                                <input type="text" id="unidad_medida" class="form-control" placeholder="Unidad de Medida" disabled>
                            </div>
                        </div>
                        <div class="row form-group">        
                            <div class="col-md-2 text-center" style="padding-top: 4px;">
                                Cantidad
                            </div>
                            <div class="col-md-2">
                                <input type="text" id="cantidad_producto" ng-model="ComprobanteCtrl.detalle_comprobante.cantidad" class="form-control validate[required,custom[integer]]" placeholder="Cantidad">
                            </div>
                            <div class="col-md-2">
                                <a ng-click="ComprobanteCtrl.agregar_detalle()" class="btn btn-flat btn-success btn-block" ng-disabled="ComprobanteCtrl.detalles_comprobante.length == 16"><i class="fa fa-plus"></i><span style="padding-left: 8px;">Agregar Producto</span></a>
                            </div>
                        </div>
                    </div>
                    </form>
                    <hr style="margin-top: 0px;" ng-hide="ComprobanteCtrl.cabecera.boolean_asociar">
                    <div class="form-group row">
                        <div  class="col-md-12">       
                                <form id="form_detalle_table">

                        <!-- ESTA TABLA ES PARA EL FUNCIONAMIENTO NORMAL -->
                            <table class="table table-striped text-center"  ng-hide="ComprobanteCtrl.cabecera.boolean_asociar">
                                <thead >
                                    <tr>
                                        <th>ITEM</th>
                                        <th style="width : 10%">CANTIDAD</th>
                                        <th style="width : 40%">DESCRIPCION</th>
                                        <th style="width : 15%">UNIDAD MEDIDA</th>
                                        <th style="width : 10%">PESO</th>
                                        <th>...</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    <tr ng-repeat="x in ComprobanteCtrl.detalles_comprobante track by $index">
                                        <td>/% $index + 1 %/</td>
                                        <td><input type="text" ng-model="ComprobanteCtrl.detalles_comprobante[$index].cantidad" ng-init="ComprobanteCtrl.detalles_comprobante[$index].cantidad = x.cantidad" class="form-control text-center validate[required]"></td>
                                        <td>/% x.producto %/</td>
                                        <td>/% x.unidad_medida %/</td>
                                        <td><input type="text" ng-model="ComprobanteCtrl.detalles_comprobante[$index].peso" class="form-control text-center validate[required]" placeholder="Peso"></td>
                                        <td>
                                            <button ng-click="ComprobanteCtrl.eliminar($index)" class="btn btn-danger"> <i class="fa fa-trash" data-toggle="tooltip" title="Eliminar Registro"></i></button> 
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        
                        <!-- ESTA TABLA ES PARA LA ASOCIACION CON GUIA  -->
                            <table class="table table-striped text-center"  ng-show="ComprobanteCtrl.cabecera.boolean_asociar">
                                <thead >
                                    <tr>
                                        <th style="width : 10%">ITEM</th>
                                        <th style="width : 10%">CANTIDAD</th>
                                        <th style="width : 55%">DESCRIPCION</th>
                                        <th style="width : 15%">UNIDAD MEDIDA</th>
                                        <th style="width : 10%">PESO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="x in ComprobanteCtrl.detalles_comprobante track by $index">
                                        <td>/% $index + 1 %/</td>
                                        <td>/% x.unidades %/</td>
                                        <td>/% x.producto.nombre_producto %/</td>
                                        <td>/% x.producto.unidad_medida.nombre_unidad_medida %/</td>
                                        <!-- <td><input type="text" ng-model="ComprobanteCtrl.detalles_comprobante[$index].precio" ng-init="" class="form-control text-center" ng-change="ComprobanteCtrl.calcular_total()"></td> -->
                                        <!-- <td ng-if="ComprobanteCtrl.detalles_comprobante[$index].precio != null">/% x.unidades*ComprobanteCtrl.detalles_comprobante[$index].precio %/</td> -->
                                        <!-- <td ng-if="ComprobanteCtrl.detalles_comprobante[$index].precio == null"> 0</td> -->
                                        <td><input type="text" ng-model="ComprobanteCtrl.detalles_comprobante[$index].peso" class="form-control text-center validate[required]" placeholder="Peso"></td>
                                        <!-- <td> /% x.precio %/</td> -->
                                    </tr>
                                </tbody>
                            </table>
                                </form>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-1 text-right" style="padding-top: 4px;">
                            <span> Transporte:</span>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-truck"></i>
                                </span>
                                <select id="empresa" class="form-control validate[required]" ng-model="ComprobanteCtrl.cabecera.empresa" ng-change="ComprobanteCtrl.seleccion_empresa(ComprobanteCtrl.cabecera.empresa.id)"  ng-options="item as (item.razon_social) for item in ComprobanteCtrl.empresas track by item.id">
                                    <option value="">-- EMPRESA TRANSPORTE --</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <input type="text" ng-model="ComprobanteCtrl.cabecera.empresa.ruc" placeholder="RUC" class="form-control" disabled="disabled">
                        </div>
                        <div class="col-md-3">
                            <select id="unidad_transporte" class="form-control validate[required]" ng-model="ComprobanteCtrl.cabecera.unidad_transporte" ng-options="item as (item.marca+' : '+item.placa) for item in ComprobanteCtrl.unidades track by item.id">
                                <option value="">-- UNIDAD --</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select id="personal_transporte" class="form-control validate[required]" ng-model="ComprobanteCtrl.cabecera.personal_transporte" ng-options="item as (item.licencia_personal) for item in ComprobanteCtrl.personales track by item.id">
                                <option value="">-- LICENCIA --</option>
                            </select>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-3 col-md-offset-3">
                            <a ng-click="ComprobanteCtrl.imprimir()" target="_blank" class="btn btn-flat btn-primary btn-block"><i class="fa fa-print"></i> Imprimir</a>
                        </div>
                        <div class="col-md-3">
                            <a ng-click="ComprobanteCtrl.store(ComprobanteCtrl.detalles_venta,ComprobanteCtrl.cabecera_venta)" class="btn btn-flat btn-success btn-block"><i class="fa fa-dollar"></i> Procesar Guía</a>
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

    var app = angular.module('myApp',[ 'ui.bootstrap','ngRoute','angucomplete-alt']);

    app.config(function($interpolateProvider){
        $interpolateProvider.startSymbol('/%');
        $interpolateProvider.endSymbol('%/');
    });


    app.controller('AdsGuiaRemision', function AdsGuiaRemision(GuiaRemisionFactory){
  
        var vm = this;
        vm.motivo = {};
        vm.detalles_comprobante = GuiaRemisionFactory.Detalle_comprobante; 
        vm.cabecera = GuiaRemisionFactory.CabeceraComprobante_create; 

        vm.angucomplete_productos = GuiaRemisionFactory.Productos;
        vm.angucomplete_clientes = GuiaRemisionFactory.Clientes;
        vm.empresas = GuiaRemisionFactory.Empresas;
        vm.motivos = GuiaRemisionFactory.Motivos;
        vm.unidades = GuiaRemisionFactory.Unidades;
        vm.personales = GuiaRemisionFactory.Personales;
        vm.angucomplete_partida = GuiaRemisionFactory.Partida;
        vm.angucomplete_llegada = GuiaRemisionFactory.Llegada;


        vm.fecha_comprobante = GuiaRemisionFactory.FechaComprobante;
        
        vm.prueba = function(){
            // console.log(vm.cabecera);
            console.log(vm.motivo);
            // GuiaRemisionFactory.FechaComprobante = null;
        }

        // angular.element(div_motivos).hide();
        vm.cabecera.Motivo_seleccionado = GuiaRemisionFactory.CabeceraComprobante_create.Motivo_seleccionado;
        vm.abrir_motivo = function(){
            // angular.element(div_motivos).toggle();
            // angular.copy()
            vm.cabecera.Motivo_seleccionado = null;
        }

        vm.cancelar_comprobante = function(){

            GuiaRemisionFactory.cancelar_comprobante();

        }

        vm.imprimir = function(){

            if($("#form_cabecera").validationEngine('validate')){

                if(vm.detalles_comprobante[0]!=null){

                    var cabecera_create = {
                            serie : vm.cabecera.serie_comprobante
                            , numero : vm.cabecera.numero_comprobante
                            , fecha : new XDate(vm.fecha_comprobante).toString('yyyy-MM-dd')
                            , cliente : GuiaRemisionFactory.Cliente_seleccionado
                            , direccion : GuiaRemisionFactory.Cliente_seleccionado.direccion_seleccionada
                            , moneda : vm.cabecera.moneda
                            , hora : angular.element(Hora_Actual).text()
                        };

                    var detalle_create = vm.detalles_comprobante;

                    GuiaRemisionFactory.imprimir(cabecera_create,detalle_create,totales_create);
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

            
            angular.copy(object.description,GuiaRemisionFactory.Cliente_seleccionado)
            angular.element(cliente_value).val(GuiaRemisionFactory.Cliente_seleccionado.razon_social);
            angular.element(ruc).val(GuiaRemisionFactory.Cliente_seleccionado.ruc);
            // angular.element(direccion).val(GuiaRemisionFactory.Cliente_seleccionado.direccion_principal);

            GuiaRemisionFactory.Cliente_seleccionado.id_cliente_seleccionado = object.description.id_cliente;
            GuiaRemisionFactory.Cliente_seleccionado.id_direccion_seleccionada = object.description.id_direccion_principal;
            GuiaRemisionFactory.Cliente_seleccionado.direccion_seleccionada = object.description.direccion_principal;
        }

        GuiaRemisionFactory.getProductos();
        GuiaRemisionFactory.getClientes();
        GuiaRemisionFactory.getEmpresas();
        GuiaRemisionFactory.getMotivos();
        GuiaRemisionFactory.getRowTipoCambioToday();
        GuiaRemisionFactory.getPartidaGuia();
        GuiaRemisionFactory.getLlegadaGuia();

        vm.seleccion_empresa = function(id_empresa){
            GuiaRemisionFactory.getUnidades(id_empresa);
            GuiaRemisionFactory.getPersonales(id_empresa);
        }

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
            angular.element(stock).val(object.description.stock);
            angular.element(unidad_medida).val(object.description.unidad_medida.nombre_unidad_medida);

            

            angular.copy(object.description, GuiaRemisionFactory.Producto_seleccionado);
        }
        
        vm.seleccion_angucompletemotivo = function(object){            

            angular.copy(object.description, GuiaRemisionFactory.Motivo_seleccionado);
            console.log(GuiaRemisionFactory.Motivo_seleccionado);
        }
        
        vm.eliminar = function(index){
            GuiaRemisionFactory.deleteAttempt(index);
        }
        
        vm.create = function(){
            GuiaRemisionFactory.create();
        }

        vm.edit = function(row_detalle_venta, index){
            GuiaRemisionFactory.edit(row_detalle_venta, index);
        }

        vm.store = function(){
            if($("#form_cabecera").validationEngine('validate') && $("#form_detalle_table").validationEngine('validate')){
                if(vm.detalles_comprobante[0]!=null){
                    console.log(vm.cabecera.personal_transporte);
                    var person_transporte;
                    var unid_transporte;
                    if(vm.cabecera.personal_transporte == undefined){
                        person_transporte = {id:null};
                    }else{
                        person_transporte = vm.cabecera.personal_transporte;
                    }
                    if(vm.cabecera.unidad_transporte == undefined){
                        unid_transporte = {id:null};
                    }else{
                        unid_transporte = vm.cabecera.unidad_transporte;
                    }

                    var punto_partida;
                    var punto_llegada;

                    if(GuiaRemisionFactory.CabeceraComprobante_create.punto_partida == undefined){
                        punto_partida = document.getElementById('punto_partida_value').value;
                        
                    }
                    else{
                        punto_partida = GuiaRemisionFactory.CabeceraComprobante_create.punto_partida;
                    }
                    
                    if(GuiaRemisionFactory.CabeceraComprobante_create.punto_llegada == undefined){
                        punto_llegada = document.getElementById('punto_llegada_value').value;
                    }
                    else{
                        punto_llegada = GuiaRemisionFactory.CabeceraComprobante_create.punto_llegada;
                    }

                    var cabecera_create = {
                            serie : vm.cabecera.serie_comprobante
                            , numero : vm.cabecera.numero_comprobante
                            , fecha : new XDate(vm.fecha_comprobante).toString('yyyy-MM-dd')
                            , punto_partida : punto_partida
                            , punto_llegada : punto_llegada
                            , cliente : GuiaRemisionFactory.Cliente_seleccionado
                            , motivo : vm.cabecera.Motivo_seleccionado
                            , personal_transporte : person_transporte
                            , unidad_transporte : unid_transporte
                            , boolean_asociar : GuiaRemisionFactory.CabeceraComprobante_create.boolean_asociar
                            , id_comprobanteVenta : GuiaRemisionFactory.CabeceraComprobante_create.id_comprobanteVenta
                    };
                    var detalle_create = vm.detalles_comprobante;
                    // if(vm.cliente_angucomp_select)
                    // {
                    //     cabecera.id_cliente = vm.cliente_angucomp_select.description.id;
                    // }
                    GuiaRemisionFactory.store(cabecera_create,detalle_create);  
                }
                else{
                    alert('Debe agregar un detalle al comprobante.');
                }
            }
            // vm.tipo_local={};
        }

        vm.buscarProducto = function(){
            GuiaRemisionFactory.buscarProducto();
        }

        vm.buscarCliente = function(){
            GuiaRemisionFactory.buscarCliente();
        }

        vm.nuevoCliente = function(){
            GuiaRemisionFactory.nuevoCliente();
        }

        

        vm.set_codebar = function(){
            var posicion = vm.detalle_venta.codebar.indexOf('-');
            var id_producto = parseInt(vm.detalle_venta.codebar.substring(posicion+1));
            GuiaRemisionFactory.getProductoByIdFromInvetarioProd(id_producto);
        }

        vm.agregar_detalle = function(){
            if($("#form_detalle").validationEngine('validate')){      

                GuiaRemisionFactory.agregar_detalle(vm.detalle_comprobante);
                angular.element(nom_producto_value).val('');
                vm.detalle_comprobante.cantidad = '';
                vm.detalle_comprobante.unidadMedida = '';
                vm.detalle_comprobante.precio = '';

            }
        }

        vm.modal_asociar = function(){

            GuiaRemisionFactory.modal_asociar();

                // vm.boolean_asociar = true;
        }


        vm.seleccion_angucompletepartida_guia = function(object){
            
            // angular.copy(object.description.punto_partida, vm.cabecera_guia[index].punto_partida);
            vm.cabecera.punto_partida = object.description.punto_partida
        }

        vm.seleccion_angucompletellegada_guia = function(object){

            // angular.copy(object.description.punto_llegada, vm.cabecera_guia[$index].punto_llegada);
            vm.cabecera.punto_llegada = object.description.punto_llegada

        }

    });



 
    app.factory('GuiaRemisionFactory', function GuiaRemisionFactory($http, $modal ) {

        GuiaRemisionFactory.detalle_venta = {}; 
        GuiaRemisionFactory.cabecera_venta = {}; 
        GuiaRemisionFactory.detalle_venta.producto = {}; 
        GuiaRemisionFactory.seleccion_producto = {}; 
        GuiaRemisionFactory.Producto_create = {};
        GuiaRemisionFactory.Cliente_create = {};
        GuiaRemisionFactory.Detalle_venta_edit = {};

        GuiaRemisionFactory.Productos = [];
        GuiaRemisionFactory.Clientes = [];
        GuiaRemisionFactory.Empresas = [];
        GuiaRemisionFactory.Motivos = [];
        GuiaRemisionFactory.Unidades = [];
        GuiaRemisionFactory.Personales = [];
        GuiaRemisionFactory.Partida = [];
        GuiaRemisionFactory.Llegada = [];

        GuiaRemisionFactory.Detalle_comprobante = [];
        GuiaRemisionFactory.Cliente_seleccionado = {};
        GuiaRemisionFactory.Producto_seleccionado = {};
        GuiaRemisionFactory.Motivo_seleccionado = {};

        GuiaRemisionFactory.CabeceraComprobante_create = {};
        GuiaRemisionFactory.CabeceraComprobante_create.Motivo_seleccionado = {};
        GuiaRemisionFactory.DetalleComprobante_create = {};
        GuiaRemisionFactory.TipoCambio_create = {};
        GuiaRemisionFactory.TipoCambio_today = {};
        GuiaRemisionFactory.CabeceraComprobante_create.boolean_asociar = false;

        var fecha_actual = new XDate(new Date()).toString('yyyy-MM-dd');
        GuiaRemisionFactory.FechaComprobante = fecha_actual;

        GuiaRemisionFactory.modal_asociar = function(){
            $modal.open( { 
                templateUrl:'templates_angular/GuiaRemisionController/asociar_factura.html', 
                controller: function($scope, $modalInstance, GuiaRemisionFactory) {
                    $scope.factura = {};
                    $scope.asociar = function(){
                angular.element(div_loader).removeClass('hide');
                        
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
                                    
                                    GuiaRemisionFactory.CabeceraComprobante_create.boolean_asociar = true;
                                    // *************** SETEAR ID GUIA REMISION *******************
                                    GuiaRemisionFactory.CabeceraComprobante_create.id_comprobanteVenta = data.datos[0].id;
                                    // *************** FIIN SETEAR ID GUIA REMISION *******************

                                    // *************** SETEAR DATOS DEL CLIENTE *******************
                                    angular.element(cliente_value).val(data.datos[0].cliente_detalle.cliente.razon_social);
                                    angular.element(ruc).val(data.datos[0].cliente_detalle.cliente.ruc);
                                    // angular.element(direccion).val(data.datos[0].cliente_detalle.direccion_cliente);


                                    GuiaRemisionFactory.Cliente_seleccionado.id_cliente_seleccionado = data.datos[0].cliente_detalle.cliente.id;
                                    GuiaRemisionFactory.Cliente_seleccionado.id_direccion_seleccionada = data.datos[0].cliente_detalle.id;
                                    GuiaRemisionFactory.Cliente_seleccionado.direccion_seleccionada = data.datos[0].cliente_detalle.direccion_cliente;


                                    // ***************  FIIN SETEAR DATOS DEL CLIENTE *******************

                                    
                                    // ***************  SETEAR DATOS DEL DETALLE *******************
                                    angular.copy(data.datos[0].comprobante_detalle_venta,GuiaRemisionFactory.Detalle_comprobante);
                                    
                                    // ***************  FIIN SETEAR DATOS DEL DETALLE *******************
                                    
                                    $modalInstance.close();

                                }
                            angular.element(div_loader).addClass('hide');

                                
                            });

                    }

                }
            });
        }

        GuiaRemisionFactory.cancelar_comprobante = function(){
            $modal.open( { 
                templateUrl:'templates_angular/ComprobanteCompraController/cancelar_comprobante.html', 
                controller: function($scope, $modalInstance, GuiaRemisionFactory) {
                    $scope.yes = function() {

                        angular.copy({},GuiaRemisionFactory.Detalle_comprobante); 
                        angular.copy({},GuiaRemisionFactory.CabeceraComprobante_create); 

                        angular.element(cliente_value).val('');
                        angular.element(ruc).val('');
                        // angular.element(direccion).val('');

                        angular.element(stock).val('');
                        angular.element(unidad_medida).val('');

                        $modalInstance.close();
                    }
                }
            });
        }

        GuiaRemisionFactory.getPartidaGuia = function() {
        angular.element(div_loader).removeClass('hide');
            return $http.get('AdsGuiaRemision/getAllPartidaGuia').success(function(data) {
        angular.element(div_loader).addClass('hide');
                console.log('PARTIDA');
                console.log(data.datos);
                angular.copy(data.datos, GuiaRemisionFactory.Partida);
            });
        } 

        GuiaRemisionFactory.getLlegadaGuia = function() {
        angular.element(div_loader).removeClass('hide');
            return $http.get('AdsGuiaRemision/getAllLlegadaGuia').success(function(data) {
        angular.element(div_loader).addClass('hide');
                console.log('LLEGADA');
                console.log(data.datos);
                angular.copy(data.datos, GuiaRemisionFactory.Llegada);
            });
        } 
        
        GuiaRemisionFactory.getRowTipoCambioToday = function() {
                angular.element(div_loader).removeClass('hide');
            $http.get('AdsTipoCambioMoneda/getRowTipoCambioToday')
                .success(function(data){
                    console.log(data);
                    angular.copy({tipo_cambio:data.datos}, GuiaRemisionFactory.TipoCambio_today);
                            angular.element(div_loader).addClass('hide');
                });
        }

        GuiaRemisionFactory.validar_tipoCambio = function(fecha) {
                angular.element(div_loader).removeClass('hide');
            $http.post('AdsGuiaRemision/validar_tipoCambio', {fecha:fecha})
                .success(function(data){
                    if(data == 'EXISTE'){
                        console.log('existe');
                    }
                    else if(data == 'NO EXISTE'){
                        $modal.open( { 
                            templateUrl:'templates_angular/ComprobanteCompraController/confirmacion_tipoCambio.html', 
                            controller: function($scope, $modalInstance, GuiaRemisionFactory, TipoCambio_create) {
                                
                                $scope.tipoCambio = TipoCambio_create;

                                $scope.store = function() {
                                    $scope.tipoCambio.fecha = fecha;
                                    GuiaRemisionFactory.storeTipoCambio($scope.tipoCambio).then(function(){

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
                                    return GuiaRemisionFactory.TipoCambio_create;
                                }
                            }
                        });
                        console.log('no existe');
                    }
                            angular.element(div_loader).addClass('hide');
                });
        }


        GuiaRemisionFactory.storeTipoCambio = function(scope) {
            angular.element(div_loader).removeClass('hide');
            return $http.post('AdsTipoCambioMoneda', scope)
            .success(function(data){
                angular.element(div_loader).addClass('hide');
            });
        }
        


        GuiaRemisionFactory.imprimir = function(cabecera, detalle, totales) {
                angular.element(div_loader).removeClass('hide');
            $http.post('AdsGuiaRemision/imprimir', {cabecera:cabecera, detalle:detalle, totales:totales})
                .success(function(data){

                    var htmlObject = document.createElement('html');
                    htmlObject.innerHTML = data;

                    var ventimp=window.open(' ','popimpr');
                    ventimp.document.write(htmlObject.innerHTML);
                    ventimp.document.close();
                    ventimp.print();
                    ventimp.close();
                            angular.element(div_loader).addClass('hide');
                });
        }

        GuiaRemisionFactory.getProductos = function() {
                angular.element(div_loader).removeClass('hide');
            return $http.get('AdsProducto/getAllProductos').success(function(data) {
                console.log(data.datos);
                angular.copy(data.datos, GuiaRemisionFactory.Productos);

                            angular.element(div_loader).addClass('hide');
            });
        }

        GuiaRemisionFactory.getClientes = function() {
                angular.element(div_loader).removeClass('hide');
            return $http.get('PtvCliente/getAllClientes').success(function(data) {
                console.log(data.datos);
                angular.copy(data.datos, GuiaRemisionFactory.Clientes);
                            angular.element(div_loader).addClass('hide');
            });
        } 


        GuiaRemisionFactory.getEmpresas = function() {
                angular.element(div_loader).removeClass('hide');
            return $http.get('AdsTransporte/getAllTransportes').success(function(data) {
                angular.copy(data.datos, GuiaRemisionFactory.Empresas);
                            angular.element(div_loader).addClass('hide');
            });
        } 

        GuiaRemisionFactory.getMotivos = function() {
                angular.element(div_loader).removeClass('hide');
            return $http.get('AdsMotivoTraslado/getAllMotivoTraslado').success(function(data) {
                angular.copy(data.datos, GuiaRemisionFactory.Motivos);
                            angular.element(div_loader).addClass('hide');
            });
        } 

        GuiaRemisionFactory.getUnidades = function(id_empresa) {
                angular.element(div_loader).removeClass('hide');
            return $http.get('AdsUnidadTransporte/getAllUnidadTransportesByEmpresa/'+id_empresa).success(function(data) {
                console.log(data.datos);
                angular.copy(data.datos, GuiaRemisionFactory.Unidades);
                            angular.element(div_loader).addClass('hide');
            });
        } 

        GuiaRemisionFactory.getPersonales = function(id_empresa) {
                angular.element(div_loader).removeClass('hide');
            return $http.get('AdsPersonalTransporte/getAllPersonalTransportesByEmpresa/'+id_empresa).success(function(data) {
                angular.copy(data.datos, GuiaRemisionFactory.Personales);
                            angular.element(div_loader).addClass('hide');
            });
        } 


        GuiaRemisionFactory.deleteAttempt = function(index) {
            $modal.open( { 
                templateUrl:'templates_angular/deleteAttemp.html', 
                controller: function($scope, $modalInstance, GuiaRemisionFactory) {
                    $scope.yes = function() {
                        GuiaRemisionFactory.Detalle_comprobante.splice(index,1);
                        $modalInstance.close();
                    }
                }
            });
        }  

        GuiaRemisionFactory.edit = function(row_detalle_comprobante,index){
            angular.copy(row_detalle_comprobante, GuiaRemisionFactory.Detalle_venta_edit);
            $modal.open({
                templateUrl: 'templates_angular/ComprobanteCompraController/edit.html',
                controller: function($scope, $modalInstance, Detalle_venta_edit, UnidadesMedida){
                    $scope.Detalle = Detalle_venta_edit;
                    $scope.UnidadesMedida = UnidadesMedida;
                    $scope.update = function(){
                        GuiaRemisionFactory.update($scope.Detalle,index);
                        $modalInstance.close();
                    }
                },
                resolve: {
                    Detalle_venta_edit : function(){
                        return GuiaRemisionFactory.Detalle_venta_edit;
                    },
                    UnidadesMedida : function(){
                        return GuiaRemisionFactory.UnidadesMedida;
                    },
                    UnidadesMedida_seleccionado : function(){
                        return GuiaRemisionFactory.UnidadesMedida_seleccionado;
                    }
                }
            });
        }

        GuiaRemisionFactory.update = function(Detalle,index){ 
            GuiaRemisionFactory.detalles_venta[index].cantidad = Detalle.cantidad;
            GuiaRemisionFactory.detalles_venta[index].id_unidadMedida = Detalle.UnidadesMedida_seleccionado.id;
            GuiaRemisionFactory.detalles_venta[index].unidadMedida = Detalle.UnidadesMedida_seleccionado.n_EquivalenciaUnidad;
        }


        GuiaRemisionFactory.store = function(cabecera, detalle) {
                angular.element(div_loader).removeClass('hide');
                 $http.post('AdsGuiaRemision', {cabecera:cabecera, detalle:detalle, compra_venta:3})
                    .success(function(data){
                        if(data.datos=='correcto'){
                            // angular.copy({},GuiaRemisionFactory.detalles_venta);
                            // angular.copy({},GuiaRemisionFactory.detalle_venta);
                            // angular.copy({},GuiaRemisionFactory.cabecera_venta);      
                            angular.copy({},GuiaRemisionFactory.Detalle_comprobante); 
                            angular.copy({},GuiaRemisionFactory.CabeceraComprobante_create); 
                            // angular.copy({},GuiaRemisionFactory.CabeceraComprobante_create.Motivo_seleccionado); 
                            GuiaRemisionFactory.CabeceraComprobante_create.Motivo_seleccionado = {};
                            GuiaRemisionFactory.CabeceraComprobante_create.boolean_asociar = false;

                            angular.element(cliente_value).val('');
                            angular.element(ruc).val('');
                            // angular.element(direccion).val('');

                            angular.element(stock).val('');
                            angular.element(unidad_medida).val('');

                            $modal.open({
                                templateUrl: 'templates_angular/ComprobanteCompraController/msj_exito.html',
                                controller: function($scope, $modalInstance){
                                }
                            });

                        } 
                        else if(data.datos == 'duplicidad'){
                            alert('¡Existe otro comprobante de compra con estos datos!');
                        }
                            angular.element(div_loader).addClass('hide');
                    });
        }
        

        GuiaRemisionFactory.buscarProducto = function(){
            $modal.open({
                templateUrl: 'templates_angular/ProductoController/seleccion_producto.html',
                controller: function($scope, $modalInstance, Producto_create, Productos){
                    $scope.producto_create = Producto_create;
                    $scope.productos = Productos;

                    $scope.seleccionar = function(data){

                        if(data.precio_unitario == null) data.precio_unitario = 0;

                        angular.copy(data, GuiaRemisionFactory.Producto_seleccionado);
                        angular.element(nom_producto_value).val(GuiaRemisionFactory.Producto_seleccionado.nombre_producto);

                        angular.element(stock).val(GuiaRemisionFactory.Producto_seleccionado.stock);
                        angular.element(unidad_medida).val(GuiaRemisionFactory.Producto_seleccionado.unidad_medida.nombre_unidad_medida);

                        $modalInstance.close();
                    }
                },
                resolve: {
                    Producto_create : function(){
                        return GuiaRemisionFactory.Producto_create;
                    },
                    Productos : function(){
                        return GuiaRemisionFactory.Productos;
                    }
                }
            });
        }

        GuiaRemisionFactory.buscarCliente = function(){
            $modal.open({
                templateUrl: 'templates_angular/ClienteController/seleccion_cliente.html',
                controller: function($scope, $modalInstance, Cliente_create, Cliente){
                    $scope.cliente_create = Cliente_create;
                    $scope.cliente = Cliente;
                    console.log('entro');
                    $scope.seleccionar = function(data, id_cliente_seleccionado, id_direccion_seleccionada, direccion_seleccionada){
                        angular.element(cliente_value).val(data.razon_social);
                        angular.element(ruc).val(data.ruc);
                        // angular.element(direccion).val(direccion_seleccionada);

                        angular.copy(data, GuiaRemisionFactory.Cliente_seleccionado);

                        GuiaRemisionFactory.Cliente_seleccionado.id_cliente_seleccionado = id_cliente_seleccionado;
                        GuiaRemisionFactory.Cliente_seleccionado.id_direccion_seleccionada = id_direccion_seleccionada;
                        GuiaRemisionFactory.Cliente_seleccionado.direccion_seleccionada = direccion_seleccionada;

                        $modalInstance.close();
                    }
                },
                resolve: {
                    Cliente_create : function(){
                        return GuiaRemisionFactory.Cliente_create;
                    },
                    Cliente : function(){
                        return GuiaRemisionFactory.Clientes;
                    }
                }
            });
        }


        GuiaRemisionFactory.nuevoCliente = function(){
            $modal.open({
                templateUrl: 'templates_angular/ClienteController/create.html',
                controller: function($scope, $modalInstance, $filter){
                    /* El objeto creado del scope se utiliza en la vista */
                    $scope.cliente = {};
                    $scope.store = function(){
                        if ( $("#create_form").validationEngine('validate') ) {
                            GuiaRemisionFactory.storeCliente($scope.cliente); /* Objeto de la vista */
                            $modalInstance.close();
                        };
                    }
                },
                resolve: {
                    
                }
            });
        }

        GuiaRemisionFactory.storeCliente = function(Cliente) {
            $http.post('AdsCliente', Cliente).success(function(data){
                GuiaRemisionFactory.getClientes();
            });
        }


        GuiaRemisionFactory.agregar_detalle = function(detalle_comprobante){

            var entro = 0;
            var posicion_entro = 0;
            var cantidad_push = 0;
            for (var i = 0; i < GuiaRemisionFactory.Detalle_comprobante.length; i++) {
                if(GuiaRemisionFactory.Detalle_comprobante[i].id_producto == GuiaRemisionFactory.Producto_seleccionado.id){
                    cantidad_push = parseFloat(GuiaRemisionFactory.Detalle_comprobante[i].cantidad) + parseFloat(detalle_comprobante.cantidad);
                    entro = 1;
                    posicion_entro = i;
                }
                
            };

            if(entro == 1){
                GuiaRemisionFactory.Detalle_comprobante[posicion_entro].cantidad = cantidad_push;
            }
            else{

                GuiaRemisionFactory.Detalle_comprobante.push(
                                                                {
                                                                id_producto : GuiaRemisionFactory.Producto_seleccionado.id
                                                                , producto : GuiaRemisionFactory.Producto_seleccionado.nombre_producto
                                                                , cantidad : detalle_comprobante.cantidad
                                                                , unidad_medida : GuiaRemisionFactory.Producto_seleccionado.unidad_medida.nombre_unidad_medida
                                                                }
                                                                );
                console.log(GuiaRemisionFactory.Detalle_comprobante);
            }

            angular.element(stock).val('');
            angular.element(unidad_medida).val('');

        }

        return GuiaRemisionFactory;
 
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
