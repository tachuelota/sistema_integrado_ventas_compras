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
        #opciones-box .tooltip{
            /*position: relative !important;*/
            /*float: right !important;*/
            /*left: 0px !important;*/
            /*right: 100px !important;*/
        }
    </style>
@endsection

@section('breadcrumb')
    <!----><h1><small></small></h1>
    <ol class="breadcrumb">
        <li><a href="{{asset('/')}}"><i class="fa fa-home"></i> Principal</a></li>
        <li><a href="{{asset('/')}}"><i class="fa fa-fw fa-shopping-cart"></i> Módulo de Ventas</a></li>
        <li class="active"><i class="fa fa-fw fa-building-o"></i> Facturas de Venta</li>
    </ol>
@endsection

@section('content')

<div ng-app="myApp" ng-controller="AdsComprobanteVenta as ComprobanteCtrl" class="container-fluid">
                                    
                    <div class="row">
                        <div class="col-xs-12">
                            <div id="box-comprobante" class="box box-solid box-primary">
                                <div class="box-header"> 
                                    <i class="fa fa-file-o"></i>
                                    <h3 class="box-title">Factura de Venta</h3>

                                    <div id="opciones-box" class="navbar-custom-menu pull-right">
                                        <ul class="nav navbar-nav">
                                             <!-- data-toggle="tooltip" data-placement="top" title="Actualizar Clientes" -->
                                            <li class="dropdown notifications-menu">
                                                <div class="box-tools pull-right">
                                                    <button class="btn btn-default btn-sm" ng-click="ComprobanteCtrl.actualizarCliente()" style="border: 0 !important;" ><i class="fa fa-users"></i></button>
                                                </div>
                                            </li>
                                             <!-- data-toggle="tooltip" data-placement="top" title="Actualizar Productos" -->
                                            <li class="dropdown notifications-menu">
                                                <div class="box-tools pull-right">
                                                    <button class="btn btn-default btn-sm" ng-click="ComprobanteCtrl.actualizarProducto()" style="border: 0 !important;" ><i class="fa fa-cubes"></i></button>
                                                </div>
                                            </li>
                                             <!-- data-toggle="tooltip" data-placement="top" title="Actualizar Transporte" -->
                                            <li class="dropdown notifications-menu">
                                                <div class="box-tools pull-right">
                                                    <button class="btn btn-default btn-sm" ng-click="ComprobanteCtrl.actualizarTransporte()" style="border: 0 !important;" ><i class="fa fa-bus"></i></button>
                                                </div>
                                            </li>
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
                                                                    <i class="fa fa-files-o text-aqua"></i> Asociar con Guia de Remision
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



<div class="row">
    <div class="col-md-12">
        <!-- Custom Tabs -->
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li id="li_box_tab_1" class="active"><a href="#box_tab_1" data-toggle="tab">FACTURA DE VENTA</a></li>
              <li id="li_box_tab_2"><a href="#box_tab_2" data-toggle="tab">GUIA DE REMISION</a></li>
              <li id="li_box_tab_3"><a href="#box_tab_3" data-toggle="tab">GESTION DE LETRAS</a></li>
              <li id="li_box_tab_4"><a href="#box_tab_4" data-toggle="tab">GESTION DE NOTAS</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="box_tab_1">

                                

                                    <form id="form_cabecera" style="margin-top: 15px;">
                                        <div class="row form-group">
                                            <div class="col-md-2 text-right" style="padding-top: 4px;">
                                                <span>N° Serie:</span>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" class="form-control validate[required,minSize[3]]" maxlength="3" ng-model="ComprobanteCtrl.cabecera.serie_comprobante">
                                            </div>
                                            <div class="col-md-1 text-right" style="padding-top: 4px;">
                                                Moneda:
                                            </div>
                                            <div class="col-md-2">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-dollar"></i>
                                                    </span>
                                                    <select id="moneda" class="form-control validate[required]" ng-model="ComprobanteCtrl.cabecera.moneda" ng-init="ComprobanteCtrl.cabecera.moneda.id = 2" ng-options="item as item.nombre_moneda for item in ComprobanteCtrl.monedas track by item.id" ng-change="ComprobanteCtrl.moneda_change()">
                                                        <option value="">-- Seleccione --</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-1 text-right" style="padding-top: 4px;">
                                                Nº Orden de Compra
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" class="form-control" ng-model="ComprobanteCtrl.cabecera.orden_compra">
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
                                                    <input type="text" id="fecha_comprobante" class="form-control validate[required]" datepicker-popup="/% format %/" ng-model="ComprobanteCtrl.fecha_comprobante" ng-change="ComprobanteCtrl.validar_tipoCambio()" is-open="opened_fec_inicio" current-text="Hoy" weeks-text="Semanas" close-text="Cerrar" clear-text="Limpiar" />
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row form-group">
                                            <div class="col-md-2 text-right" style="padding-top: 4px;">
                                                Cliente:
                                            </div>
                                            <div class="col-md-5">
                                                <div class="input-group">
                                                    <a href="" ng-click="ComprobanteCtrl.buscarCliente()" class="input-group-addon">
                                                        <i class="fa fa-search"></i>
                                                    </a>
                                                    <angucomplete-alt id="cliente" placeholder="Cliente" maxlength="50" pause="100" selected-object="ComprobanteCtrl.seleccion_angucompletecliente" local-data="ComprobanteCtrl.angucomplete_clientes" search-fields="razon_social" title-field="razon_social" minlength="1" input-class="form-control form-control-small validate[required]" match-class="highlight" field-required="true">
                                                    </angucomplete-alt>
                                                    <!-- <a href="" ng-click="ComprobanteCtrl.actualizarCliente()" class="input-group-addon">
                                                        <i class="fa fa-refresh"></i>
                                                    </a> -->
                                                    <a href="" ng-click="ComprobanteCtrl.nuevoCliente()" class="input-group-addon">
                                                        <i class="fa fa-plus"></i>
                                                    </a>
                                                </div>
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
                                        </div>
                                    </form>
                                    <hr>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <!-- Custom Tabs -->
                                            <div class="nav-tabs-custom">
                                                <ul class="nav nav-tabs">
                                                  <li id="li_tab_1" class="active"><a href="#tab_1" data-toggle="tab">Detalle Venta</a></li>
                                                  <li id="li_tab_2"><a href="#tab_2" data-toggle="tab">Nota Débito/Crédito</a></li>
                                                  <li id="li_tab_3"><a href="#tab_3" data-toggle="tab">Finanza</a></li>
                                                </ul>
                                                <div class="tab-content">
                                                  <div class="tab-pane active" id="tab_1">
                                                    <form id="form_detalle" ng-hide="ComprobanteCtrl.cabecera.boolean_asociar">
                                                        <div class="row form-group">
                                                            <div class="col-md-2 text-right" style="padding-top: 4px;">
                                                                Producto
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="input-group">

                                                                    <a href="" ng-click="ComprobanteCtrl.buscarProducto()" class="input-group-addon">
                                                                        <i class="fa fa-search"></i>
                                                                    </a>
                                                                    <angucomplete-alt id="nom_producto" placeholder="Nombre Producto" pause="100" selected-object="ComprobanteCtrl.seleccion_angucompleteproducto" local-data="ComprobanteCtrl.angucomplete_productos" search-fields="nombre_producto" title-field="nombre_producto" minlength="1" input-class="form-control form-control-small validate[required]" match-class="highlight" field-required="true">
                                                                    </angucomplete-alt>
                                                                    <a href="" ng-click="ComprobanteCtrl.nuevoProducto()" class="input-group-addon">
                                                                        <i class="fa fa-plus"></i>
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
                                                            <div class="col-md-2 text-right" style="padding-top: 4px;">
                                                                Cantidad
                                                            </div>
                                                            <div class="col-md-2">
                                                                <input type="text" id="cantidad_producto" ng-model="ComprobanteCtrl.detalle_comprobante.cantidad" class="form-control validate[required,custom[number]]" placeholder="Cantidad">
                                                            </div>
                                                        </div>
                                                        <div class="row form-group">
                                                            <div class="col-md-2 text-right" style="padding-top: 4px;">
                                                                Precio 
                                                            </div>
                                                            <div class="col-md-2">
                                                                <input type="text" id="precio_producto" ng-model="ComprobanteCtrl.detalle_comprobante.precio" class="form-control validate[required]" placeholder="Precio">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <a ng-if="ComprobanteCtrl.cabecera.moneda != null && ComprobanteCtrl.boolean_cliente_seleccionado.id != null" ng-click="ComprobanteCtrl.agregar_detalle()" class="btn btn-flat btn-success btn-block"  ng-disabled="ComprobanteCtrl.detalles_comprobante.length == 9"><i class="fa fa-plus"></i><span style="padding-left: 8px;">Agregar Producto</span></a>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <p id="label_precio" style="color:red;"></p>
                                                            </div>
                                                        </div>
                                                    </form>
                                                    <hr style="margin-top: 0px;" ng-hide="ComprobanteCtrl.cabecera.boolean_asociar">
                                                    <div class="form-group row">
                                                        <div class="col-md-12">  

                                                        <!-- ESTA TABLA ES PARA EL FUNCIONAMIENTO NORMAL -->
                                                            <form id="form_detalle_table">
                                                            <table class="table table-striped text-center"  ng-hide="ComprobanteCtrl.cabecera.boolean_asociar">
                                                                <thead >
                                                                    <tr>
                                                                        <th>ITEM</th>
                                                                        <th style="width : 10%">CANTIDAD</th>
                                                                        <th>DESCRIPCION</th>
                                                                        <th style="width : 10%">PRECIO</th>
                                                                        <th>IMPORTE</th>
                                                                        <!-- <th style="width : 10%" ng-if="ComprobanteCtrl.cabecera.generar_guia">PESO</th> -->
                                                                        <th>...</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr ng-repeat="x in ComprobanteCtrl.detalles_comprobante track by $index">
                                                                        <td>/% $index + 1 %/</td>
                                                                        <td><input type="text" ng-model="ComprobanteCtrl.detalles_comprobante[$index].cantidad" ng-init="ComprobanteCtrl.detalles_comprobante[$index].cantidad = x.cantidad" class="form-control text-center" ng-change="ComprobanteCtrl.calcular_total()"></td>
                                                                        <td><input type="text" ng-model="ComprobanteCtrl.detalles_comprobante[$index].nombre_producto" ng-init="ComprobanteCtrl.detalles_comprobante[$index].nombre_producto = x.producto" class="form-control text-center"></td>
                                                                        <td><input type="text" ng-model="ComprobanteCtrl.detalles_comprobante[$index].precio" ng-init="ComprobanteCtrl.detalles_comprobante[$index].precio = x.precio" class="form-control text-center" ng-change="ComprobanteCtrl.calcular_total()"></td>
                                                                        <td>/% x.cantidad*x.precio %/</td>
                                                                        <!-- <td ng-if="ComprobanteCtrl.cabecera.generar_guia"><input type="text" ng-model="ComprobanteCtrl.detalles_comprobante[$index].peso" class="form-control text-center validate[required]" placeholder="Peso"></td> -->
                                                                        <td>
                                                                            <button ng-click="ComprobanteCtrl.eliminar($index)" class="btn btn-danger"> <i class="fa fa-trash" data-toggle="tooltip" title="Eliminar Registro"></i></button> 
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            </form>
                                                        
                                                        <!-- ESTA TABLA ES PARA LA ASOCIACION CON GUIA  -->
                                                            <table class="table table-striped text-center"  ng-show="ComprobanteCtrl.cabecera.boolean_asociar">
                                                                <thead >
                                                                    <tr>
                                                                        <th>ITEM</th>
                                                                        <th style="width : 10%">CANTIDAD</th>
                                                                        <th>DESCRIPCION</th>
                                                                        <th style="width : 10%">PRECIO</th>
                                                                        <th>IMPORTE</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr ng-repeat="x in ComprobanteCtrl.detalles_comprobante track by $index">
                                                                        <td>/% $index + 1 %/</td>
                                                                        <td>/% x.unidades %/</td>
                                                                        <td>/% x.producto %/</td>
                                                                        <td><input type="text" ng-model="ComprobanteCtrl.detalles_comprobante[$index].precio" ng-init="" class="form-control text-center" ng-change="ComprobanteCtrl.calcular_total()"></td>
                                                                        <td ng-if="ComprobanteCtrl.detalles_comprobante[$index].precio != null">/% x.unidades*ComprobanteCtrl.detalles_comprobante[$index].precio %/</td>
                                                                        <td ng-if="ComprobanteCtrl.detalles_comprobante[$index].precio == null"> 0</td>
                                                                        <!-- <td> /% x.precio %/</td> -->
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>

                                                  </div><!-- /.tab-pane -->
                                                  <div class="tab-pane" id="tab_3">
                                                    <form id="form_finanza">
                                                        <div class="row form-group">
                                                            <div class="col-md-1 text-right" style="padding-top: 4px;">
                                                                Condicion Pago
                                                            </div>
                                                            <div class="col-md-2">
                                                                <select id="condicion_pago" class="form-control validate[required]" ng-model="ComprobanteCtrl.finanzas.condicion" ng-options="item as item.nombre_condicion for item in ComprobanteCtrl.condiciones_pago track by item.id" ng-change="ComprobanteCtrl.moneda_change()">
                                                                    <option value="">-- Seleccione --</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div ng-if="ComprobanteCtrl.finanzas.condicion.id == 1">
                                                            <div class="row form-group">
                                                                <div class="col-md-2 text-right" style="padding-top: 4px;">
                                                                    Medio Pago
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <select id="medio_pago" class="form-control validate[required]" ng-model="ComprobanteCtrl.finanzas.medio" ng-options="item as item.nombre_medio_pago for item in ComprobanteCtrl.medios_pago track by item.id" ng-change="ComprobanteCtrl.moneda_change()">
                                                                        <option value="">-- Seleccione --</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-1 text-right" style="padding-top: 4px;" ng-show="ComprobanteCtrl.finanzas.medio.id != 1 && ComprobanteCtrl.finanzas.medio">
                                                                    Fecha:
                                                                </div>
                                                                <div class="col-md-2" ng-show="ComprobanteCtrl.finanzas.medio.id != 1 && ComprobanteCtrl.finanzas.medio">
                                                                    <div class="input-group">
                                                                        <span class="input-group-addon">
                                                                            <i class="fa fa-calendar"></i>
                                                                        </span>
                                                                        <input type="text" id="fecha_pago" class="form-control validate[required]" datepicker-popup="/% format %/" ng-model="ComprobanteCtrl.finanzas.medio.fecha_pago" is-open="opened_fec_pago" current-text="Hoy" weeks-text="Semanas" close-text="Cerrar" clear-text="Limpiar" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-1 text-right" style="padding-top: 4px;" ng-show="ComprobanteCtrl.finanzas.medio.id != 1 && ComprobanteCtrl.finanzas.medio">
                                                                    Detalle:
                                                                </div>
                                                                <div class="col-md-3" ng-show="ComprobanteCtrl.finanzas.medio.id != 1 && ComprobanteCtrl.finanzas.medio">
                                                                    <input type="text" class="form-control validate[required]" ng-model="ComprobanteCtrl.finanzas.medio.detalle_medio_pago"/>
                                                                </div>
                                                            </div>                                            
                                                        </div>
                                                        <div ng-if="ComprobanteCtrl.finanzas.condicion.id == 2">
                                                            
                                                            <!-- <div class="row form-group"> -->
                                                                <!-- -- -->
                                                                <form id="form_detalle_letra" ng-hide="ComprobanteCtrl.cabecera.boolean_asociar">
                                                                    <div class="row form-group">
                                                                        <div class="col-md-1 text-right" style="padding-top: 4px;">
                                                                            # Letra
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <input type="text" id="numero_letra" ng-model="ComprobanteCtrl.finanzas.letra.numero_letra" class="form-control validate[required]" placeholder="A##">
                                                                        </div>
                                                                    <!-- </div> -->
                                                                    <!-- <div class="row form-group"> -->
                                                                        <div class="col-md-2 text-right" style="padding-top: 4px;">
                                                                            Fecha Vencimiento
                                                                        </div>
                                                                        <div class="col-md-2">

                                                                            <div class="input-group">
                                                                                <span class="input-group-addon">
                                                                                    <i class="fa fa-calendar"></i>
                                                                                </span>
                                                                                <input type="text" id="fecha_vencimiento_letra" class="form-control validate[required]" datepicker-popup="/% format %/" ng-model="ComprobanteCtrl.finanzas.letra.fecha_vencimiento" ng-disabled="ComprobanteCtrl.finanzas.letra.numero_dias" is-open="opened_fec_venc_letra" current-text="Hoy" weeks-text="Semanas" close-text="Cerrar" clear-text="Limpiar" />
                                                                            </div>
                                                                        </div>
                                                                    <!-- </div> -->
                                                                    <!-- <div class="row form-group"> -->

                                                                        <div class="col-md-1 text-right" style="padding-top: 4px;">
                                                                            Dias 
                                                                        </div>
                                                                        <div class="col-md-1">
                                                                            <input type="text" id="numero_dias" ng-model="ComprobanteCtrl.finanzas.letra.numero_dias" class="form-control validate[required,custom[integer]]" placeholder="Días" ng-disabled="ComprobanteCtrl.finanzas.letra.fecha_vencimiento">
                                                                            <!-- <input type="text" id="monto_letra" ng-model="ComprobanteCtrl.finanzas.letra.monto_letra" class="form-control validate[required,custom[number]]" placeholder="Monto"> -->
                                                                        </div>

                                                                        <div class="col-md-2">
                                                                            <a ng-click="ComprobanteCtrl.agregar_detalle_letra()" class="btn btn-flat btn-success btn-block" ><i class="fa fa-plus"></i><span style="padding-left: 8px;">Agregar Letra</span></a>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            <!-- </div> -->
                                                            <!-- <div class="row form-group">
                                                                <div class="col-md-2 text-right" style="padding-top: 4px;">
                                                                    Estado
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <select id="estado_letra" class="form-control validate[required]" ng-model="ComprobanteCtrl.finanzas.estado" ng-init="ComprobanteCtrl.finanzas.estado.id = 4" ng-options="item as item.nombre_estado_letra for item in ComprobanteCtrl.estados_letra track by item.id" ng-change="ComprobanteCtrl.moneda_change()">
                                                                        <option value="">-- Seleccione --</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-2" ng-if="ComprobanteCtrl.finanzas.estado.id == 2">
                                                                    <input type="text" id="nombre_banco" ng-model="ComprobanteCtrl.finanzas.detalle_estado" class="form-control validate[required,custom[integer]]" placeholder="¿En cuál?">
                                                                </div>
                                                                <div class="col-md-2" ng-if="ComprobanteCtrl.finanzas.estado.id == 3">
                                                                    <input type="text" id="nombre_banco" ng-model="ComprobanteCtrl.finanzas.detalle_estado" class="form-control validate[required,custom[integer]]" placeholder="¿A quién?">
                                                                </div>
                                                            </div> -->
                                                            <div class="form-group row">
                                                                <div class="col-md-12">  

                                                                <!-- ESTA TABLA ES PARA EL FUNCIONAMIENTO NORMAL -->
                                                                    <table class="table table-striped text-center" >
                                                                        <thead >
                                                                            <tr>
                                                                                <th style="width : 10%">ITEM</th>
                                                                                <th style="width : 20%"># LETRA</th>
                                                                                <th style="width : 20%">DIAS</th>
                                                                                <th style="width : 20%">MONTO</th>
                                                                                <th style="width : 20%">FECHA VCTO</th>
                                                                                <th style="width : 10%">...</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr ng-repeat="x in ComprobanteCtrl.detalles_letra track by $index">
                                                                                <td>/% $index + 1 %/</td>
                                                                                <td><input type="text" ng-model="ComprobanteCtrl.detalles_finanza[$index].numero_letra" ng-init="ComprobanteCtrl.detalles_finanza[$index].numero_letra = x.numero_letra" class="form-control text-center"></td>
                                                                                <td><input type="text" ng-model="ComprobanteCtrl.detalles_finanza[$index].numero_dias" ng-init="ComprobanteCtrl.detalles_finanza[$index].numero_dias = x.numero_dias" ng-change="ComprobanteCtrl.calcular_vencimiento_letra(ComprobanteCtrl.detalles_finanza[$index].numero_dias, $index)" class="form-control text-center"></td>
                                                                                <!-- <td>/% x.numero_dias %/</td> -->
                                                                                <!-- <td><input type="text" ng-model="x.monto_letra" ng-init="ComprobanteCtrl.detalles_finanza[$index].monto_letra = x.monto_letra" class="form-control text-center"></td> -->
                                                                                <td><input type="text" ng-model="x.monto_letra" ng-init="ComprobanteCtrl.detalles_finanza[$index].monto_letra = x.monto_letra" class="form-control text-center"></td>
                                                                                <td><input type="text" ng-model="ComprobanteCtrl.detalles_finanza[$index].fecha_vencimiento" ng-init="ComprobanteCtrl.detalles_finanza[$index].fecha_vencimiento = x.fecha_vencimiento" class="form-control text-center"></td>
                                                                                <td>
                                                                                    <button ng-click="ComprobanteCtrl.eliminar_letra($index)" class="btn btn-danger"> <i class="fa fa-trash" data-toggle="tooltip" title="Eliminar Registro"></i></button> 
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </form>
                                                  </div><!-- /.tab-pane -->
                                                  <div class="tab-pane" id="tab_2">
                                                    <form id="form_nota">
                                                        <div class="row form-group">
                                                            <div class="col-md-2 text-right" style="padding-top: 4px;">
                                                                Tipo Nota:
                                                            </div>
                                                            <div class="col-md-2">
                                                                <select id="tipo_nota" class="form-control validate[required]" ng-model="ComprobanteCtrl.nota.tipo_nota" ng-options="item as item.nombre_tipo_nota for item in ComprobanteCtrl.tipos_nota track by item.id" ng-change="ComprobanteCtrl.calcular_importe_nota()">
                                                                    <option value="">-- Seleccione --</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-2 text-right" style="padding-top: 4px;">
                                                                Fecha emision: 
                                                            </div>
                                                            <div class="col-md-2">

                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <i class="fa fa-calendar"></i>
                                                                    </span>
                                                                    <input type="text" id="fecha_emision_nota" class="form-control validate[required]" datepicker-popup="/% format %/" ng-model="ComprobanteCtrl.nota.fecha_emision" is-open="opened_fec_emision_nota" current-text="Hoy" weeks-text="Semanas" close-text="Cerrar" clear-text="Limpiar" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row form-group">
                                                            <div class="col-md-2 text-right" style="padding-top: 4px;">
                                                                N° Serie:
                                                            </div>
                                                            <div class="col-md-2">
                                                                <input type="text" class="form-control validate[required,minSize[3]]" maxlength="3" ng-model="ComprobanteCtrl.nota.serie_nota">
                                                            </div>
                                                            <div class="col-md-2 text-right" style="padding-top: 4px;">
                                                                N° Comprobante: 
                                                            </div>
                                                            <div class="col-md-2">
                                                                <input type="text" class="form-control validate[required]" maxlength="20" ng-model="ComprobanteCtrl.nota.numero_nota">
                                                            </div>
                                                            <div class="col-md-1 text-right" style="padding-top: 4px;" ng-if="ComprobanteCtrl.nota.tipo_nota.id == 2">
                                                                Motivo: 
                                                            </div>
                                                            <div class="col-md-2" ng-if="ComprobanteCtrl.nota.tipo_nota.id == 2">
                                                                <select id="motivo_nota" class="form-control validate[required]" ng-model="ComprobanteCtrl.nota.motivo_nota" ng-options="item as item.nombre_motivo_nota for item in ComprobanteCtrl.motivos_nota track by item.id">
                                                                    <option value="">-- Seleccione --</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row form-group" ng-if="ComprobanteCtrl.nota.tipo_nota.id == 1">        
                                                            <div class="col-md-2 text-right" style="padding-top: 4px;">
                                                                Descripcion
                                                            </div>
                                                            <div class="col-md-6">
                                                                <input type="text" id="descripcion_nota" ng-model="ComprobanteCtrl.nota.descripcion_nota" class="form-control validate[required]" placeholder="Descripcion">
                                                            </div>
                                                        </div>
                                                        <div class="row form-group" ng-if="ComprobanteCtrl.nota.tipo_nota.id == 2">
                                                            <div class="col-md-2 text-right" style="padding-top: 4px;">
                                                                Producto
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="input-group">

                                                                    <a href="" ng-click="ComprobanteCtrl.buscarProducto_nota()" class="input-group-addon">
                                                                        <i class="fa fa-search"></i>
                                                                    </a>
                                                                    <angucomplete-alt id="nom_producto_nota" placeholder="Nombre Producto" pause="100" selected-object="ComprobanteCtrl.seleccion_angucompleteproducto_nota" local-data="ComprobanteCtrl.angucomplete_productos" search-fields="nombre_producto" title-field="nombre_producto" minlength="1" input-class="form-control form-control-small validate[required]" match-class="highlight" field-required="true">
                                                                    </angucomplete-alt>
                                                                    <a href="" ng-click="ComprobanteCtrl.nuevoProducto()" class="input-group-addon">
                                                                        <i class="fa fa-plus"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row form-group" ng-if="ComprobanteCtrl.nota.tipo_nota.id == 2">        
                                                            <div class="col-md-2 text-right" style="padding-top: 4px;">
                                                                Cantidad
                                                            </div>
                                                            <div class="col-md-2">
                                                                <input type="text" id="cantidad_producto" ng-model="ComprobanteCtrl.nota.cantidad" class="form-control validate[required,custom[number]]">
                                                            </div>
                                                            <div class="col-md-2 text-right" style="padding-top: 4px;">
                                                                Merma
                                                            </div>
                                                            <div class="col-md-2">
                                                                <input type="text" id="merma" ng-model="ComprobanteCtrl.nota.merma" class="form-control validate[required,custom[number]]">
                                                            </div>
                                                        </div>

                                                        <div class="row form-group" ng-if="ComprobanteCtrl.nota.tipo_nota">
                                                            <div class="col-md-2 text-right" style="padding-top: 4px;">
                                                                <span ng-if="ComprobanteCtrl.nota.tipo_nota.id == 1">Monto</span>
                                                                <span ng-if="ComprobanteCtrl.nota.tipo_nota.id == 2">Precio Unitario </span>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <input type="text" id="precio_nota" ng-model="ComprobanteCtrl.nota.precio_nota" class="form-control validate[required]">
                                                            </div>
                                                            <div class="col-md-3 col-md-offset-1">
                                                                <a ng-if="ComprobanteCtrl.cabecera.moneda != null && ComprobanteCtrl.boolean_cliente_seleccionado.id != null" ng-click="ComprobanteCtrl.agregar_detalle_nota()" class="btn btn-flat btn-success btn-block"><i class="fa fa-plus"></i><span style="padding-left: 8px;">Agregar</span></a>
                                                            </div>
                                                        </div>
                                                    </form>
                                                    <div class="row form-group" ng-if="ComprobanteCtrl.nota.tipo_nota">
                                                        <div class="col-md-12">
                                                            <table class="table table-striped text-center"  ng-hide="ComprobanteCtrl.cabecera.boolean_asociar">
                                                                <thead >
                                                                    <tr>
                                                                        <th>ITEM</th>
                                                                        <th style="width : 10%">CANTIDAD</th>
                                                                        <th>DESCRIPCION</th>
                                                                        <th style="width : 10%">PRECIO</th>
                                                                        <th>IMPORTE</th>
                                                                        <th>...</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr ng-repeat="x in ComprobanteCtrl.detalles_nota track by $index">
                                                                        <td>/% $index + 1 %/</td>
                                                                        <td><input type="text" ng-model="ComprobanteCtrl.detalles_nota[$index].cantidad" ng-init="ComprobanteCtrl.detalles_nota[$index].cantidad = x.cantidad" class="form-control text-center" ng-change="ComprobanteCtrl.calcular_total_nota()"></td>
                                                                        <!-- <td ng-if="ComprobanteCtrl.nota.tipo_nota.id == 1"><input type="text" ng-model="ComprobanteCtrl.detalles_nota[$index].descripcion" ng-init="ComprobanteCtrl.detalles_nota[$index].descripcion = x.descripcion" class="form-control text-center"></td> -->
                                                                        <!-- <td ng-if="ComprobanteCtrl.nota.tipo_nota.id == 2"><input type="text" ng-model="ComprobanteCtrl.detalles_nota[$index].nombre_producto" ng-init="ComprobanteCtrl.detalles_nota[$index].nombre_producto = x.producto" class="form-control text-center"></td> -->
                                                                        <td><input type="text" ng-model="ComprobanteCtrl.detalles_nota[$index].nombre_producto" ng-init="ComprobanteCtrl.detalles_nota[$index].nombre_producto = x.producto" class="form-control text-center"></td>
                                                                        <td><input type="text" ng-model="ComprobanteCtrl.detalles_nota[$index].precio_nota" ng-init="ComprobanteCtrl.detalles_nota[$index].precio_nota = x.precio_nota" class="form-control text-center" ng-change="ComprobanteCtrl.calcular_total_nota()"></td>
                                                                        <td>/% x.cantidad*x.precio_nota %/</td>
                                                                        <td>
                                                                            <button ng-click="ComprobanteCtrl.eliminar_detalle_nota($index)" class="btn btn-danger"> <i class="fa fa-trash" data-toggle="tooltip" title="Eliminar Registro"></i></button> 
                                                                        </td>
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
                                                            <input type="number" id="nota_subtotal" class="form-control" placeholder="SubTotal" disabled>
                                                        </div>
                                                    </div>

                                                    <div class="row form-group">
                                                        <div class="col-md-2 col-md-offset-8 text-right">
                                                            <label>IGV (<?php echo (DB::table('ts_igv')->where('estado', 'true')->pluck('valor_igv'))*100; ?>%) : </label>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <input type="number" id="nota_igv" class="form-control" placeholder="IGV" disabled>
                                                        </div>
                                                    </div>

                                                    <div class="row form-group">
                                                        <div class="col-md-2 col-md-offset-8 text-right">
                                                            <label>Total : </label>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <input type="number" id="nota_total" class="form-control" placeholder="Total" disabled>
                                                        </div>
                                                    </div>
                                                  </div><!-- /.tab-pane -->
                                                </div><!-- /.tab-content -->
                                            </div><!-- nav-tabs-custom -->

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

                                    <div class="row form-group" ng-if="ComprobanteCtrl.boolean_cliente_seleccionado.agente_retenedor == 'true'" ng-hide="ComprobanteCtrl.nota.tipo_nota.id">
                                        <div class="col-md-2 col-md-offset-8 text-right">
                                            <label>Retencion : </label>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="number" id="retencion" class="form-control" placeholder="Retencion" disabled>
                                        </div>
                                    </div>

                                    <div class="row form-group" style="margin-bottom: 25px;" ng-if="ComprobanteCtrl.boolean_cliente_seleccionado.agente_retenedor == 'true'" ng-hide="ComprobanteCtrl.nota.tipo_nota.id">
                                        <div class="col-md-2 col-md-offset-8 text-right">
                                            <label>Importe Aplicado : </label>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="number" id="importe_aplicado" class="form-control" placeholder="Importe Aplicado" disabled>
                                        </div>
                                    </div>

                                    <div class="row form-group" ng-show="ComprobanteCtrl.nota.tipo_nota.id">
                                        <div class="col-md-2 col-md-offset-8 text-right">
                                            <label>Total con Nota : </label>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="number" id="total_nota" class="form-control" placeholder="Total Nota" disabled>
                                        </div>
                                    </div>
                                    
                                    <div class="row form-group" ng-show="ComprobanteCtrl.nota.tipo_nota.id && ComprobanteCtrl.boolean_cliente_seleccionado.agente_retenedor == 'true'">
                                        <div class="col-md-2 col-md-offset-8 text-right">
                                            <label>Retencion con Nota : </label>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="number" id="retencion_nota" class="form-control" placeholder="Total Nota" disabled>
                                        </div>
                                    </div>

                                    <div class="row form-group" style="margin-bottom: 25px;" ng-show="ComprobanteCtrl.nota.tipo_nota.id && ComprobanteCtrl.boolean_cliente_seleccionado.agente_retenedor == 'true'">
                                        <div class="col-md-2 col-md-offset-8 text-right">
                                            <label>Importe Aplicado  con Nota: </label>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="number" id="importe_aplicado_nota" class="form-control" placeholder="Importe Aplicado con Nota" disabled>
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

                </div><!-- /.tab-pane -->
                <div class="tab-pane" id="box_tab_2">
                    <div class="row form-group">
                        <div class="col-md-12 text-center">
                            <h4>¿Generar Guía?</h4>
                            <input type="checkbox" id="bolean_guia" ng-model="ComprobanteCtrl.cabecera.generar_guia">
                        </div>
                    </div>
                    <div class="nav-tabs-custom" ng-if="ComprobanteCtrl.cabecera.generar_guia">
                        <ul class="nav nav-tabs">
                          <li id="li_box_tab_create_guia_/% x.n_guia %/" ng-class="{active: $last}" ng-repeat="x in ComprobanteCtrl.numero_guias track by $index"><a href="#box_tab_create_guia_/% x.n_guia %/" data-toggle="tab">Guia Remision Nº/% x.n_guia %/  <i class="fa fa-times" style="padding: 5px; cursor:pointer;" ng-click="ComprobanteCtrl.numero_guias.splice($index,1); ComprobanteCtrl.tab_hover[$index] = false;" ng-class="{'text-danger':ComprobanteCtrl.tab_hover[$index]}" ng-mouseover="ComprobanteCtrl.tab_hover[$index] = true" ng-mouseleave="ComprobanteCtrl.tab_hover[$index] = false"></i></a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane" ng-class="{active: $last}" id="box_tab_create_guia_/% x.n_guia %/" ng-repeat="x in ComprobanteCtrl.numero_guias track by $index">

                                <form id="form_cabecera_guia_/% $index %/" style="margin-top: 15px;">
                                    <div class="row form-group">
                                        <div class="col-md-1 text-right" style="padding-top: 4px;">
                                            N° Serie:
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" id="serie_comprobante_guia_/% x.n_guia %/" ng-model="ComprobanteCtrl.cabecera_guia[$index].serie_comprobante_guia" class="form-control validate[required,minSize[3]]" maxlength="3">
                                        </div>
                                        <div class="col-md-2 text-right" style="padding-top: 4px;">
                                            N° Comprobante: 
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" id="numero_comprobante_guia/% x.n_guia %/" ng-model="ComprobanteCtrl.cabecera_guia[$index].numero_comprobante_guia" class="form-control validate[required]" maxlength="20">
                                        </div>
                                        <div class="col-md-2 text-right">
                                            Fecha de traslado:
                                        </div>
                                        <div class="col-md-2">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </span>
                                                <input type="text" id="fecha_comprobante_guia_/% x.n_guia %/" class="form-control validate[required]" datepicker-popup="/% format %/" ng-model="ComprobanteCtrl.cabecera_guia[$index].fecha_comprobante_guia" is-open="opened_fec_inicio_guia_[$index]" current-text="Hoy" weeks-text="Semanas" close-text="Cerrar" clear-text="Limpiar" />
                                            </div>
                                        </div>
                                        
                                        
                                    </div>

                                    <hr>
                                    
                                    
                                <!-- <hr> -->

                                    <div class="row form-group">
                                        <div class="col-md-2 text-right">
                                            Punto de Partida: 
                                        </div>
                                        <div class="col-md-10">
                                            <div class="input-group col-md-10">
                                                <angucomplete-alt id="punto_partida_guia/% $index %/" placeholder="Punto de Partida" pause="100" selected-object="ComprobanteCtrl.seleccion_angucompletepartida_guia" local-data="ComprobanteCtrl.angucomplete_partida" search-fields="punto_partida" title-field="punto_partida" minlength="1" input-class="form-control form-control-large" match-class="highlight" field-required="true">
                                                </angucomplete-alt>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-2 text-right">
                                            Punto de Llegada: 
                                        </div>
                                        <div class="col-md-10">
                                            <div class="input-group col-md-10">
                                                <angucomplete-alt id="punto_llegada_guia/% $index %/" placeholder="Punto de Llegada" pause="100" selected-object="ComprobanteCtrl.seleccion_angucompletellegada_guia" local-data="ComprobanteCtrl.angucomplete_llegada" search-fields="punto_llegada" title-field="punto_llegada" minlength="1" input-class="form-control form-control-small" match-class="highlight" field-required="true">
                                                </angucomplete-alt>
                                
                                            </div>
                                            <!-- <input type="text" class="form-control validate[required]" ng-model="ComprobanteCtrl.cabecera_guia[$index].punto_llegada" placeholder="Direccion"> -->
                                        </div>
                                    </div>
                                    <div class="row form-group" style="margin-bottom: 0px;">
                                        <div class="col-md-2 text-right" style="padding-top: 4px;">
                                            Motivo del Traslado
                                        </div>
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <a href="" ng-click="ComprobanteCtrl.abrir_motivo($index)" class="input-group-addon">
                                                    <i class="fa fa-search"></i>
                                                </a>
                                                <input type="text" id="motivo" ng-model="ComprobanteCtrl.cabecera_guia[$index].Motivo_seleccionado.nombre_motivoTraslado" class="form-control validate[required]">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        
                                        <div id="div_motivos" class="col-md-12" style="margin-left:10px !important;margin-top: 25px;" ng-if="ComprobanteCtrl.cabecera_guia[$index].Motivo_seleccionado == null">
                                            <div class="col-md-2" ng-repeat="item in ComprobanteCtrl.motivos">
                                                <label>
                                                    <div class="radio">
                                                        <input type="radio" ng-model="ComprobanteCtrl.cabecera_guia[$parent.$index].Motivo_seleccionado" ng-value="item">
                                                        <h6>/% item.nombre_motivoTraslado %/</h6>
                                                    </div>
                                                </label>
                                            </div>  
                                        </div>
                                                                  
                                    </div>
                                </form>
                                <hr>
                                <form id="form_detalle_guia_/% $index %/">
                                    <div class="row" >

                                        <div class="row form-group">
                                            <div class="col-md-2 text-center" style="padding-top: 4px;">
                                                Producto
                                            </div>
                                            <div class="col-md-5">
                                                <div class="input-group">
                                                    <a href="" ng-click="ComprobanteCtrl.buscarProducto_guia($index)" class="input-group-addon">
                                                        <i class="fa fa-search"></i>
                                                    </a>
                                                    <angucomplete-alt id="nom_producto_/% $index %/" placeholder="Nombre Producto" pause="100" selected-object="ComprobanteCtrl.seleccion_angucompleteproducto_guia" local-data="ComprobanteCtrl.angucomplete_productos" search-fields="nombre_producto" title-field="nombre_producto" minlength="1" input-class="form-control form-control-small validate[required]" match-class="highlight" field-required="true">
                                                    </angucomplete-alt>
                                                    <a href="" ng-click="ComprobanteCtrl.nuevoProducto()" class="input-group-addon">
                                                        <i class="fa fa-plus"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-md-1 hide">
                                                <input type="text" id="stock" class="form-control" placeholder="Stock" disabled>
                                            </div>
                                            <div class="col-md-2 hide">
                                                <input type="text" id="unidad_medida_/% $index %/" class="form-control" placeholder="Unidad de Medida" disabled>
                                            </div>
                                        </div>
                                        <div class="row form-group">        
                                            <div class="col-md-2 text-center" style="padding-top: 4px;">
                                                Cantidad
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" id="cantidad_producto" ng-model="ComprobanteCtrl.detalle_comprobante_guia[$index].cantidad" class="form-control validate[required,custom[number]]" placeholder="Cantidad">
                                            </div>
                                            <div class="col-md-2">
                                                <a ng-click="ComprobanteCtrl.agregar_detalle_guia($index)" class="btn btn-flat btn-success btn-block" ng-disabled="ComprobanteCtrl.detalles_comprobante.length == 16"><i class="fa fa-plus"></i><span style="padding-left: 8px;">Agregar Producto</span></a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <hr style="margin-top: 0px;" >
                                <div class="form-group row">
                                    <div  class="col-md-12">       
                                        <form id="form_detalle_table_/% $index %/">

                                        <!-- ESTA TABLA ES PARA EL FUNCIONAMIENTO NORMAL -->
                                            <table class="table table-striped text-center">
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
                                                    
                                                    <tr ng-repeat="x in ComprobanteCtrl.detalles_comprobante_guia[$index] track by $index">
                                                        <td>/% $index + 1 %/</td>
                                                        <td><input type="text" ng-model="ComprobanteCtrl.detalles_comprobante_guia[$parent.$index][$index].cantidad" ng-init="ComprobanteCtrl.detalles_comprobante_guia[$parent.$index][$index].cantidad = x.cantidad" class="form-control text-center validate[required]"></td>
                                                        <td><input type="text" ng-model="ComprobanteCtrl.detalles_comprobante_guia[$parent.$index][$index].nombre_producto" ng-init="ComprobanteCtrl.detalles_comprobante_guia[$parent.$index][$index].nombre_producto = x.producto" class="form-control text-center"></td>
                                                        <td>/% x.unidad_medida %/</td>
                                                        <td><input type="text" ng-model="ComprobanteCtrl.detalles_comprobante_guia[$parent.$index][$index].peso" class="form-control text-center validate[required]" placeholder="Peso"></td>
                                                        <td>
                                                            <button ng-click="ComprobanteCtrl.eliminar_detalle_guia($parent.$index,$index)" class="btn btn-danger"> <i class="fa fa-trash" data-toggle="tooltip" title="Eliminar Registro"></i></button> 
                                                        </td>
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
                                            <select id="empresa_guia_/% x.n_guia %/" class="form-control validate[required]" ng-model="ComprobanteCtrl.cabecera_guia[$index].empresa" ng-change="ComprobanteCtrl.seleccion_empresa(ComprobanteCtrl.cabecera_guia[$index].empresa.id)"  ng-options="item as (item.razon_social) for item in ComprobanteCtrl.empresas track by item.id">
                                                <option value="">-- EMPRESA TRANSPORTE --</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" ng-model="ComprobanteCtrl.cabecera_guia[$index].empresa.ruc" placeholder="RUC" class="form-control" disabled="disabled">
                                    </div>
                                    <div class="col-md-3">
                                        <select id="id_unidad_transporte_guia_/% x.n_guia %/" class="form-control validate[required]" ng-model="ComprobanteCtrl.cabecera_guia[$index].unidad_transporte" ng-options="item as (item.marca+' : '+item.placa) for item in ComprobanteCtrl.unidades track by item.id">
                                            <option value="">-- UNIDAD --</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select id="id_personal_transporte_guia_/% x.n_guia %/" class="form-control validate[required]" ng-model="ComprobanteCtrl.cabecera_guia[$index].personal_transporte" ng-options="item as (item.licencia_personal) for item in ComprobanteCtrl.personales track by item.id">
                                            <option value="">-- LICENCIA --</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-md-3 col-md-offset-9">
                                        <a ng-click="ComprobanteCtrl.imprimir()" target="_blank" class="btn btn-flat btn-primary btn-block"><i class="fa fa-print"></i> Imprimir</a>
                                    </div>
                                    <!-- <div class="col-md-3">
                                        <a ng-click="ComprobanteCtrl.store(ComprobanteCtrl.detalles_venta,ComprobanteCtrl.cabecera_venta)" class="btn btn-flat btn-success btn-block"><i class="fa fa-dollar"></i> Procesar Guía</a>
                                    </div>
                                    <div class="col-md-3">
                                        <a ng-click="ComprobanteCtrl.cancelar_comprobante()" class="btn btn-flat btn-danger btn-block"><i class="fa fa-minus"></i> Cancelar</a>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row form-group" ng-if="ComprobanteCtrl.cabecera.generar_guia">
                        <div class="col-md-12 text-center">
                            <a class="btn btn-app" ng-click="ComprobanteCtrl.nueva_guia()"><i class="fa fa-plus"></i> GUIA</a>
                            <a class="btn btn-app " ng-click="ComprobanteCtrl.pasar_factura()"><i class="fa fa-angle-double-left" style="margin-bottom : 5px;margin-top : -5px;"></i> PASAR A FACTURA</a>
                        </div>
                    </div>           
                </div><!-- /.tab-pane -->
                
                <div class="tab-pane" id="box_tab_3">

                                    <form id="form_gestion_letra_factura" style="margin-top: 15px;">
                                        <div class="row form-group">
                                            <div class="col-md-2 text-right" style="padding-top: 4px;">
                                                N° Serie:
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" class="form-control validate[required,minSize[3]]" maxlength="3" ng-model="ComprobanteCtrl.gestion_letra.serie">
                                            </div>
                                            <div class="col-md-2 text-right" style="padding-top: 4px;">
                                                N° Comprobante: 
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" class="form-control validate[required]" maxlength="20" ng-model="ComprobanteCtrl.gestion_letra.numero">
                                            </div>
                                            <div class="col-md-2">
                                                <a ng-click="ComprobanteCtrl.agregar_detalle_factura()" class="btn btn-flat btn-success btn-block" ><i class="fa fa-plus"></i><span style="padding-left: 8px;">Agregar Factura</span></a>
                                            </div>
                                            
                                        </div>

                                    </form>

                                    <div class="form-group row">
                                        <div class="col-md-12">  

                                        <!-- ESTA TABLA ES PARA EL FUNCIONAMIENTO NORMAL -->
                                            <table class="table table-striped text-center" >
                                                <thead >
                                                    <tr>
                                                        <th style="width : 10%">ITEM</th>
                                                        <th style="width : 20%"># FACTURA</th>
                                                        <th style="width : 20%">MONTO</th>
                                                        <th style="width : 10%">...</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr ng-repeat="x in ComprobanteCtrl.detalles_factura track by $index">
                                                        <td>/% $index + 1 %/</td>
                                                        <td>/% "000".substring(0, 3 - x.serie_comprobante.length) + x.serie_comprobante %/-/% "00000000".substring(0, 8 - x.numero_comprobante.length) + x.numero_comprobante %/</td>
                                                        <td ng-if="x.detalle_nota.length == 0">/% x.total_comprobante - x.monto_retencion%/</td>
                                                        <td ng-if="x.detalle_nota.length != 0 && x.detalle_nota[(x.detalle_nota.length-1)].tipo_nota.id == 1">/% x.detalle_nota[(x.detalle_nota.length-1)].total_nota + x.monto_retencion %/</td>
                                                        <td ng-if="x.detalle_nota.length != 0 && x.detalle_nota[(x.detalle_nota.length-1)].tipo_nota.id == 2">/% x.detalle_nota[(x.detalle_nota.length-1)].total_nota - x.monto_retencion %/</td>
                                                       <!--  <td ng-if="!x.detalle_nota">/% x.total_comprobante - x.monto_retencion - x.detalle_nota.precio %/</td>
x.detalle_nota[(x.detalle_nota.length-1)].total_nota
                                                        <td ng-if="x.comprobante_venta.detalle_nota.length == 0 && x.comprobante_venta.moneda.id == 1">/% LetraCtrl.formatNumber(x.comprobante_venta.total_comprobante - x.comprobante_venta.monto_retencion, "S/. ") %/ </td>
                                                        <td ng-if="x.comprobante_venta.detalle_nota.length == 0 && x.comprobante_venta.moneda.id == 2">/% LetraCtrl.formatNumber(x.comprobante_venta.total_comprobante - x.comprobante_venta.monto_retencion, "$ ") %/ </td>
                                                        <td ng-if="x.comprobante_venta.detalle_nota.length != 0 && x.comprobante_venta.moneda.id == 1">/% LetraCtrl.formatNumber(x.comprobante_venta.detalle_nota[0].total_nota - x.comprobante_venta.monto_retencion, "S/. ") %/ </td>
                                                        <td ng-if="x.comprobante_venta.detalle_nota.length != 0 && x.comprobante_venta.moneda.id == 2">/% LetraCtrl.formatNumber(x.comprobante_venta.detalle_nota[0].total_nota - x.comprobante_venta.monto_retencion, "$ ") %/ </td>
 -->
                                                        <td>
                                                            <button ng-click="ComprobanteCtrl.eliminar_detalle_factura($index)" class="btn btn-danger"> <i class="fa fa-trash" data-toggle="tooltip" title="Eliminar Registro"></i></button> 
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <hr>

                                    <form id="form_gestion_letra_detalle_letra">
                                        <div class="row form-group">
                                            <div class="col-md-2 text-right" style="padding-top: 4px;">
                                                # Letra
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" id="numero_letra" ng-model="ComprobanteCtrl.gestion_letra.numero_letra" class="form-control validate[required]" placeholder="A##">
                                            </div>
                                            <div class="col-md-2 text-right" style="padding-top: 4px;">
                                                Fecha Vencimiento
                                            </div>
                                            <div class="col-md-2">

                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </span>
                                                    <input type="text" id="fecha_vencimiento_letra" class="form-control validate[required]" datepicker-popup="/% format %/" ng-model="ComprobanteCtrl.gestion_letra.fecha_vencimiento" ng-disabled="ComprobanteCtrl.gestion_letra.numero_dias" is-open="opened_fec_venc_letra_gestion_letra" current-text="Hoy" weeks-text="Semanas" close-text="Cerrar" clear-text="Limpiar" />
                                                </div>
                                            </div>
                                            <div class="col-md-1 text-right" style="padding-top: 4px;">
                                                Dias 
                                            </div>
                                            <div class="col-md-1">
                                                <input type="text" id="numero_dias_gestion_letra" ng-model="ComprobanteCtrl.gestion_letra.numero_dias" class="form-control validate[required,custom[integer]]" placeholder="Días" ng-disabled="ComprobanteCtrl.gestion_letra.fecha_vencimiento">
                                                <!-- <input type="text" id="monto_letra" ng-model="ComprobanteCtrl.finanzas.letra.monto_letra" class="form-control validate[required,custom[number]]" placeholder="Monto"> -->
                                            </div>

                                            <div class="col-md-2">
                                                <a ng-click="ComprobanteCtrl.agregar_detalle_letra_gestion_letra()" class="btn btn-flat btn-success btn-block" ><i class="fa fa-plus"></i><span style="padding-left: 8px;">Agregar Letra</span></a>
                                            </div>
                                        </div>
                                    </form>

                                    <div class="form-group row">
                                        <div class="col-md-12">  

                                        <!-- ESTA TABLA ES PARA EL FUNCIONAMIENTO NORMAL -->
                                            <table class="table table-striped text-center" >
                                                <thead >
                                                    <tr>
                                                        <th style="width : 10%">ITEM</th>
                                                        <th style="width : 20%"># LETRA</th>
                                                        <th style="width : 20%">DIAS</th>
                                                        <th style="width : 20%">MONTO</th>
                                                        <th style="width : 20%">FECHA VCTO</th>
                                                        <th style="width : 10%">...</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr ng-repeat="x in ComprobanteCtrl.detalles_letra_gestion_letra track by $index">
                                                        <td>/% $index + 1 %/</td>
                                                        <td>/% x.numero_letra %/</td>
                                                        <td><input type="text" ng-model="ComprobanteCtrl.detalles_finanza_gestion_letra[$index].numero_dias" ng-init="ComprobanteCtrl.detalles_finanza_gestion_letra[$index].numero_dias = x.numero_dias" ng-change="ComprobanteCtrl.calcular_vencimiento_letra_gestion_letra(ComprobanteCtrl.detalles_finanza_gestion_letra[$index].numero_dias, $index)" class="form-control text-center"></td>
                                                        <!-- <td>/% x.numero_dias %/</td> -->
                                                        <!-- <td>/% x.monto_letra %/</td> -->
                                                        <td><input type="text" ng-model="x.monto_letra" ng-init="ComprobanteCtrl.detalles_finanza_gestion_letra[$index].monto_letra = x.monto_letra" class="form-control text-center"></td>
                                                        <td>/% x.fecha_vencimiento %/</td>
                                                        <td>
                                                            <button ng-click="ComprobanteCtrl.eliminar_letra_gestion_letra($index)" class="btn btn-danger"> <i class="fa fa-trash" data-toggle="tooltip" title="Eliminar Registro"></i></button> 
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    
                                    <div class="row form-group">
                                        <div class="col-md-4 col-md-offset-4">
                                            <a ng-click="ComprobanteCtrl.store_gestion_letra(ComprobanteCtrl.detalles_letra_gestion_letra,ComprobanteCtrl.detalles_factura)" class="btn btn-flat btn-success btn-block"><i class="fa fa-dollar"></i> Asociar</a>
                                        </div>
                                    </div>
                </div><!-- /.tab-pane -->
                
                <div class="tab-pane" id="box_tab_4">

                                    <form id="form_gestion_nota_factura" style="margin-top: 15px;">


                                        <div class="row form-group">
                                            <div class="col-md-2 text-right" style="padding-top: 4px;">
                                                N° Serie:
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" class="form-control validate[required,minSize[3]]" maxlength="3" ng-model="ComprobanteCtrl.gestion_nota_factura.serie">
                                            </div>
                                            <div class="col-md-2 text-right" style="padding-top: 4px;">
                                                N° Comprobante: 
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" class="form-control validate[required]" maxlength="20" ng-model="ComprobanteCtrl.gestion_nota_factura.numero">
                                            </div>
                                            <div class="col-md-2">
                                                <a ng-click="ComprobanteCtrl.agregar_detalle_factura_nota()" class="btn btn-flat btn-success btn-block" ><i class="fa fa-plus"></i><span style="padding-left: 8px;">Agregar Factura</span></a>
                                            </div>
                                            
                                        </div>

                                    </form>

                                    <div class="form-group row">
                                        <div class="col-md-12">  

                                        <!-- ESTA TABLA ES PARA EL FUNCIONAMIENTO NORMAL -->
                                            <table class="table table-striped text-center" >
                                                <thead >
                                                    <tr>
                                                        <th style="width : 10%">ITEM</th>
                                                        <th style="width : 20%"># FACTURA</th>
                                                        <th style="width : 20%">MONTO</th>
                                                        <th style="width : 10%">...</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr ng-repeat="x in ComprobanteCtrl.detalles_factura_nota track by $index">
                                                        <td>/% $index + 1 %/</td>
                                                        <td>/% "000".substring(0, 3 - x.serie_comprobante.length) + x.serie_comprobante %/-/% "00000000".substring(0, 8 - x.numero_comprobante.length) + x.numero_comprobante %/</td>
                                                        <td ng-if="x.detalle_nota.length > 0 && x.detalle_nota[0].tipo_nota.id == 1">/% x.total_comprobante - x.monto_retencion + x.detalle_nota.precio %/</td>
                                                        <td ng-if="x.detalle_nota.length > 0 && x.detalle_nota[0].tipo_nota.id == 2">/% x.total_comprobante - x.monto_retencion - x.detalle_nota.precio %/</td>
                                                        <td ng-if="x.detalle_nota.length == 0">/% x.total_comprobante - x.monto_retencion %/</td>
                                                        <td>
                                                            <button ng-click="ComprobanteCtrl.eliminar_detalle_factura_nota($index)" class="btn btn-danger"> <i class="fa fa-trash" data-toggle="tooltip" title="Eliminar Registro"></i></button> 
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <hr>
                                    <div class="nav-tabs-custom">
                                        <ul class="nav nav-tabs">
                                            <li id="li_box_tab_create_nota_/% x.n_nota %/" ng-class="{active: $last}" ng-repeat="x in ComprobanteCtrl.numero_notas track by $index"><a href="#box_tab_create_nota_/% x.n_nota %/" data-toggle="tab">Nota Nº/% x.n_nota %/  <i class="fa fa-times" style="padding: 5px; cursor:pointer;" ng-click="ComprobanteCtrl.numero_notas.splice($index,1); ComprobanteCtrl.tab_hover_nota[$index] = false;" ng-class="{'text-danger':ComprobanteCtrl.tab_hover_nota[$index]}" ng-mouseover="ComprobanteCtrl.tab_hover_nota[$index] = true" ng-mouseleave="ComprobanteCtrl.tab_hover_nota[$index] = false"></i></a></li>
                                            <li><a href="" ng-click="ComprobanteCtrl.nueva_nota()"><i class="fa fa-plus"></i></a></li>
                                            <!-- <a class="btn btn-app" ng-click="ComprobanteCtrl.nueva_nota()"> NOTA</a> -->
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane" ng-class="{active: $last}" id="box_tab_create_nota_/% x.n_nota %/" ng-repeat="x in ComprobanteCtrl.numero_notas track by $index">

                                                <form id="form_gestion_nota_cabecera_nota_/% $index %/">
                                                    <div class="row form-group">
                                                        <div class="col-md-2 text-right" style="padding-top: 4px;">
                                                            Tipo Nota:
                                                        </div>
                                                        <div class="col-md-2">
                                                            <select id="tipo_nota" class="form-control validate[required]" ng-model="ComprobanteCtrl.gestion_nota[$index].tipo_nota" ng-options="item as item.nombre_tipo_nota for item in ComprobanteCtrl.tipos_nota track by item.id" ng-change="ComprobanteCtrl.calcular_total_nota_gestion_nota()">
                                                                <option value="">-- Seleccione --</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2 text-right" style="padding-top: 4px;">
                                                            Fecha emision: 
                                                        </div>
                                                        <div class="col-md-2">

                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-calendar"></i>
                                                                </span>
                                                                <input type="text" id="fecha_emision_nota" class="form-control validate[required]" datepicker-popup="/% format %/" ng-model="ComprobanteCtrl.gestion_nota[$index].fecha_emision" is-open="opened_fec_emision_nota_gestion_nota" current-text="Hoy" weeks-text="Semanas" close-text="Cerrar" clear-text="Limpiar" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1 text-right" ng-if="ComprobanteCtrl.gestion_nota[$index].tipo_nota.id == 2">
                                                            ¿Anula Factura?
                                                        </div>
                                                        <div class="col-md-3" ng-if="ComprobanteCtrl.gestion_nota[$index].tipo_nota.id == 2">
                                                            <input type="checkbox" id="bolean_guia" ng-model="ComprobanteCtrl.gestion_nota[$index].anular_factura">
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-md-2 text-right" style="padding-top: 4px;">
                                                            N° Serie:
                                                        </div>
                                                        <div class="col-md-2">
                                                            <input type="text" class="form-control validate[required,minSize[3]]" maxlength="3" ng-model="ComprobanteCtrl.gestion_nota[$index].serie_nota">
                                                        </div>
                                                        <div class="col-md-2 text-right" style="padding-top: 4px;">
                                                            N° Comprobante: 
                                                        </div>
                                                        <div class="col-md-2">
                                                            <input type="text" class="form-control validate[required]" maxlength="20" ng-model="ComprobanteCtrl.gestion_nota[$index].numero_nota">
                                                        </div>
                                                        <div class="col-md-1 text-right" style="padding-top: 4px;" ng-if="ComprobanteCtrl.gestion_nota[$index].tipo_nota.id == 2">
                                                            Motivo: 
                                                        </div>
                                                        <div class="col-md-2" ng-if="ComprobanteCtrl.gestion_nota[$index].tipo_nota.id == 2">
                                                            <select id="motivo_nota" class="form-control validate[required]" ng-model="ComprobanteCtrl.gestion_nota[$index].motivo_nota" ng-options="item as item.nombre_motivo_nota for item in ComprobanteCtrl.motivos_nota track by item.id">
                                                                <option value="">-- Seleccione --</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </form>
                                                <form id="form_gestion_nota_detalle_nota_/% $index %/">
                                                    <div class="row form-group" ng-if="ComprobanteCtrl.gestion_nota[$index].tipo_nota.id == 1">        
                                                        <div class="col-md-2 text-right" style="padding-top: 4px;">
                                                            Descripcion
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="text" id="descripcion_nota" ng-model="ComprobanteCtrl.gestion_nota[$index].descripcion_nota" class="form-control validate[required]" placeholder="Descripcion">
                                                        </div>
                                                    </div>
                                                    <div class="row form-group" ng-if="ComprobanteCtrl.gestion_nota[$index].tipo_nota.id == 2">
                                                        <div class="col-md-2 text-right" style="padding-top: 4px;">
                                                            Producto
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="input-group">

                                                                <a href="" ng-click="ComprobanteCtrl.buscarProducto_gestion_nota($index)" class="input-group-addon">
                                                                    <i class="fa fa-search"></i>
                                                                </a>
                                                                <angucomplete-alt id="nom_producto_gestion_nota_/% $index %/" placeholder="Nombre Producto" pause="100" selected-object="ComprobanteCtrl.seleccion_angucompleteproducto_gestion_nota" local-data="ComprobanteCtrl.angucomplete_productos" search-fields="nombre_producto" title-field="nombre_producto" minlength="1" input-class="form-control form-control-small validate[required]" match-class="highlight" field-required="true">
                                                                </angucomplete-alt>
                                                                <a href="" ng-click="ComprobanteCtrl.nuevoProducto()" class="input-group-addon">
                                                                    <i class="fa fa-plus"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group" ng-if="ComprobanteCtrl.gestion_nota[$index].tipo_nota.id == 2">        
                                                        <div class="col-md-2 text-right" style="padding-top: 4px;">
                                                            Cantidad
                                                        </div>
                                                        <div class="col-md-2">
                                                            <input type="text" id="cantidad_producto" ng-model="ComprobanteCtrl.gestion_nota[$index].cantidad" class="form-control validate[required,custom[number]]">
                                                        </div>
                                                        <div class="col-md-2 text-right" style="padding-top: 4px;">
                                                            Merma
                                                        </div>
                                                        <div class="col-md-2">
                                                            <input type="text" id="merma" ng-model="ComprobanteCtrl.gestion_nota[$index].merma" class="form-control validate[custom[number]]">
                                                        </div>
                                                    </div>

                                                    <div class="row form-group" ng-if="ComprobanteCtrl.gestion_nota[$index].tipo_nota">
                                                        <div class="col-md-2 text-right" style="padding-top: 4px;">
                                                            <span ng-if="ComprobanteCtrl.gestion_nota[$index].tipo_nota.id == 1">Monto</span>
                                                            <span ng-if="ComprobanteCtrl.gestion_nota[$index].tipo_nota.id == 2">Precio Unitario </span>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <input type="text" id="precio_nota" ng-model="ComprobanteCtrl.gestion_nota[$index].precio_nota" class="form-control validate[required]">
                                                        </div>
                                                        <div class="col-md-3 col-md-offset-1">
                                                            <a ng-click="ComprobanteCtrl.agregar_detalle_nota_gestion_nota($index)" class="btn btn-flat btn-success btn-block"><i class="fa fa-plus"></i><span style="padding-left: 8px;">Agregar</span></a>
                                                        </div>
                                                    </div>
                                                </form>
                                                <div class="row form-group" ng-if="ComprobanteCtrl.gestion_nota[$index].tipo_nota">
                                                    <div class="col-md-12">
                                                        <table class="table table-striped text-center"  ng-hide="ComprobanteCtrl.cabecera.boolean_asociar">
                                                            <thead >
                                                                <tr>
                                                                    <th>ITEM</th>
                                                                    <th style="width : 10%">CANTIDAD</th>
                                                                    <th>DESCRIPCION</th>
                                                                    <th style="width : 10%">PRECIO</th>
                                                                    <th>IMPORTE</th>
                                                                    <th>...</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr ng-repeat="x in ComprobanteCtrl.detalles_nota_gestion_nota[$index] track by $index">
                                                                    <td>/% $index + 1 %/</td>
                                                                    <td><input type="text" ng-model="ComprobanteCtrl.detalles_nota_gestion_nota[$parent.$index][$index].cantidad" ng-init="ComprobanteCtrl.detalles_nota_gestion_nota[$parent.$index][$index].cantidad = x.cantidad" class="form-control text-center" ng-change="ComprobanteCtrl.calcular_total_nota_gestion_nota()"></td>
                                                                    <td><input type="text" ng-model="ComprobanteCtrl.detalles_nota_gestion_nota[$parent.$index][$index].nombre_producto" ng-init="ComprobanteCtrl.detalles_nota_gestion_nota[$parent.$index][$index].nombre_producto = x.producto" class="form-control text-center"></td>
                                                                    <td><input type="text" ng-model="ComprobanteCtrl.detalles_nota_gestion_nota[$parent.$index][$index].precio_nota" ng-init="ComprobanteCtrl.detalles_nota_gestion_nota[$parent.$index][$index].precio_nota = x.precio_nota" class="form-control text-center" ng-change="ComprobanteCtrl.calcular_total_nota_gestion_nota()"></td>
                                                                    <td>/% x.cantidad*x.precio_nota %/</td>
                                                                    <td>
                                                                        <button ng-click="ComprobanteCtrl.eliminar_detalle_nota($index)" class="btn btn-danger"> <i class="fa fa-trash" data-toggle="tooltip" title="Eliminar Registro"></i></button> 
                                                                    </td>
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
                                                        <input type="number" id="gestion_nota_/% $index %/_subtotal" class="form-control" placeholder="SubTotal" disabled>
                                                    </div>
                                                </div>

                                                <div class="row form-group">
                                                    <div class="col-md-2 col-md-offset-8 text-right">
                                                        <label>IGV (<?php echo (DB::table('ts_igv')->where('estado', 'true')->pluck('valor_igv'))*100; ?>%) : </label>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input type="number" id="gestion_nota_/% $index %/_igv" class="form-control" placeholder="IGV" disabled>
                                                    </div>
                                                </div>

                                                <div class="row form-group">
                                                    <div class="col-md-2 col-md-offset-8 text-right">
                                                        <label>Total : </label>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input type="number" id="gestion_nota_/% $index %/_total" class="form-control" placeholder="Total" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- <div class="row form-group">
                                            <div class="col-md-12 text-center">
                                                <a class="btn btn-app" ng-click="ComprobanteCtrl.nueva_nota()"><i class="fa fa-plus"></i> NOTA</a>
                                            </div>
                                        </div>    -->        
                                    </div><!-- /.tab-pane -->

                                    <div class="row form-group">
                                        <div class="col-md-4 col-md-offset-4">
                                            <a ng-click="ComprobanteCtrl.store_gestion_nota(ComprobanteCtrl.gestion_nota,ComprobanteCtrl.detalles_nota_gestion_nota,ComprobanteCtrl.detalles_factura_nota)" class="btn btn-flat btn-success btn-block"><i class="fa fa-dollar"></i> Asociar</a>
                                        </div>
                                    </div>
                </div><!-- /.tab-pane -->


            </div><!-- /.tab-content -->
        </div><!-- nav-tabs-custom -->

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

    // console.log('REDONDEANDO');
    // console.log(Math[round](1.4));

    var app = angular.module('myApp',[ 'ui.bootstrap','ngRoute','angucomplete-alt']);

    app.config(function($interpolateProvider){
        $interpolateProvider.startSymbol('/%');
        $interpolateProvider.endSymbol('%/');
    });


    app.controller('AdsComprobanteVenta', function AdsComprobanteVenta(ComprobanteVentaFactory, $scope){
  
        var vm = this;
        vm.detalles_comprobante = ComprobanteVentaFactory.Detalle_comprobante; 
        vm.detalles_nota = ComprobanteVentaFactory.Detalle_nota; 
        vm.detalles_letra = ComprobanteVentaFactory.Detalle_letra; 
        vm.detalles_finanza = ComprobanteVentaFactory.Detalle_finanza; 
        vm.detalles_finanza_gestion_letra = ComprobanteVentaFactory.Detalle_finanza_gestion_letra; 
        vm.detalles_letra_gestion_letra = ComprobanteVentaFactory.Detalle_letra_gestion_letra; 
        vm.detalles_nota_gestion_nota = ComprobanteVentaFactory.Detalle_nota_gestion_nota; 
        vm.detalles_factura = ComprobanteVentaFactory.Detalle_factura; 
        vm.detalles_factura_nota = ComprobanteVentaFactory.Detalle_factura_nota; 
        vm.cabecera = ComprobanteVentaFactory.CabeceraComprobante_create; 
        vm.cabecera_guia = ComprobanteVentaFactory.CabeceraComprobanteGuia_create; 
        vm.gestion_letra = ComprobanteVentaFactory.Gestion_letra; 
        vm.gestion_nota = ComprobanteVentaFactory.Gestion_nota; 
        vm.finanzas = ComprobanteVentaFactory.Finanzas_create; 
        vm.nota = ComprobanteVentaFactory.Nota_create; 
        vm.boolean_cliente_seleccionado = ComprobanteVentaFactory.Cliente_seleccionado;
        vm.angucomplete_productos = ComprobanteVentaFactory.Productos;
        vm.angucomplete_clientes = ComprobanteVentaFactory.Clientes;
        vm.angucomplete_partida = ComprobanteVentaFactory.Partida;
        vm.angucomplete_llegada = ComprobanteVentaFactory.Llegada;
        vm.monedas = ComprobanteVentaFactory.Monedas;
        vm.condiciones_pago = ComprobanteVentaFactory.CondicionesPago;
        vm.medios_pago = ComprobanteVentaFactory.MediosPago;
        vm.estados_letra = ComprobanteVentaFactory.EstadosLetra;
        vm.tipos_nota = ComprobanteVentaFactory.TipoNotas;

        vm.detalles_comprobante_guia = ComprobanteVentaFactory.Detalle_comprobante_guia; 

        // vm.boolean_asociar = ComprobanteVentaFactory.boolean_asociar;

        vm.fecha_comprobante = ComprobanteVentaFactory.FechaComprobante;
        


        vm.prueba = function(){

            console.log(vm.cabecera.moneda);

        }
        vm.cancelar_comprobante = function(){

            ComprobanteVentaFactory.cancelar_comprobante();

        }

        vm.validar_tipoCambio = function(){

            var fecha = new XDate(vm.fecha_comprobante).toString('yyyy-MM-dd');
            ComprobanteVentaFactory.validar_tipoCambio(fecha);
        }
        vm.imprimir = function(){

            if($("#form_cabecera").validationEngine('validate')){

                if(vm.detalles_comprobante[0]!=null){

                    var cabecera_create = {
                            serie : vm.cabecera.serie_comprobante
                            , numero : vm.cabecera.numero_comprobante
                            , fecha : new XDate(vm.fecha_comprobante).toString('yyyy-MM-dd')
                            , cliente : ComprobanteVentaFactory.Cliente_seleccionado
                            , direccion : ComprobanteVentaFactory.Cliente_seleccionado.direccion_seleccionada
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
                    
                    ComprobanteVentaFactory.imprimir(cabecera_create,detalle_create,totales_create);
                }
                else{
                    // alert('Debe agregar un detalle al comprobante.');
                    sweetAlert("Error...", "Debe agregar un detalle al comprobante.", "error");
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

            
            angular.copy(object.description,ComprobanteVentaFactory.Cliente_seleccionado)
            angular.element(cliente_value).val(ComprobanteVentaFactory.Cliente_seleccionado.razon_social);
            angular.element(ruc).val(ComprobanteVentaFactory.Cliente_seleccionado.ruc);
            angular.element(direccion).val(ComprobanteVentaFactory.Cliente_seleccionado.direccion_principal);

            ComprobanteVentaFactory.Cliente_seleccionado.id_cliente_seleccionado = object.description.id_cliente;
            ComprobanteVentaFactory.Cliente_seleccionado.id_direccion_seleccionada = object.description.id_direccion_principal;
            ComprobanteVentaFactory.Cliente_seleccionado.direccion_seleccionada = object.description.direccion_principal;
            
            if(ComprobanteVentaFactory.Cliente_seleccionado.agente_retenedor == 'true')
            {
                angular.element(label_agente_retenedor).text('AGENTE RETENEDOR');
            }
            else
            {
                angular.element(label_agente_retenedor).text('');
            }
        }

        ComprobanteVentaFactory.getProductos();
        ComprobanteVentaFactory.getClientes();
        ComprobanteVentaFactory.getMonedas();
        ComprobanteVentaFactory.getRowTipoCambioToday();
        ComprobanteVentaFactory.getEstadoLetra();
        ComprobanteVentaFactory.getMedioPago();
        ComprobanteVentaFactory.getCondicionPago();
        ComprobanteVentaFactory.getTipoNota();


        ComprobanteVentaFactory.getAllUnidadMedida();
        ComprobanteVentaFactory.getAllComposicion();
        ComprobanteVentaFactory.getAllTitulo();
        ComprobanteVentaFactory.getAllHilatura();
        ComprobanteVentaFactory.getAllTipoProducto();
        ComprobanteVentaFactory.getAllTipoTela();
        ComprobanteVentaFactory.getAllColor();



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

                if(ComprobanteVentaFactory.CabeceraComprobante_create.moneda.id == 1){

                    angular.element(precio_producto).removeClass('validate[required,min['+formatNumber(ComprobanteVentaFactory.Producto_seleccionado.precio_unitario,'')+']]');
                    angular.element(precio_producto).addClass('validate[required]');

                }
                else if(ComprobanteVentaFactory.CabeceraComprobante_create.moneda.id == 2){

                    angular.element(precio_producto).removeClass('validate[required,min['+formatNumber(ComprobanteVentaFactory.Producto_seleccionado.precio_unitario/ComprobanteVentaFactory.TipoCambio_today.tipo_cambio,'')+']]');
                    angular.element(precio_producto).addClass('validate[required]');
                    
                }
                
                // if(ComprobanteVentaFactory.CabeceraComprobante_create.moneda.id == 1){

                //     angular.element(precio_producto).removeClass('validate[required,min['+ComprobanteVentaFactory.Producto_seleccionado.precio_unitario+']]');
                //     angular.element(precio_producto).addClass('validate[required]');

                // }
                // else if(ComprobanteVentaFactory.CabeceraComprobante_create.moneda.id == 2){

                //     angular.element(precio_producto).removeClass('validate[required,min['+ComprobanteVentaFactory.Producto_seleccionado.precio_unitario/ComprobanteVentaFactory.TipoCambio_today.tipo_cambio+']]');
                //     angular.element(precio_producto).addClass('validate[required]');

                // }

                if(object.description.precio_unitario == null) object.description.precio_unitario=0;

                if(ComprobanteVentaFactory.CabeceraComprobante_create.moneda.id == 1){
                    angular.element(label_precio).text('Precio Mínimo: S/.'+ formatNumber(object.description.precio_unitario, ''));
                
                    angular.element(precio_producto).removeClass('validate[required]');
                    angular.element(precio_producto).addClass('validate[required,min['+formatNumber(object.description.precio_unitario, '')+']]');

                }
                else if(ComprobanteVentaFactory.CabeceraComprobante_create.moneda.id == 2){

                    angular.element(label_precio).text('Precio Mínimo: $.'+formatNumber(object.description.precio_unitario/ComprobanteVentaFactory.TipoCambio_today.tipo_cambio, ''));
                    
                    angular.element(precio_producto).removeClass('validate[required]');
                    angular.element(precio_producto).addClass('validate[required,min['+formatNumber(object.description.precio_unitario/ComprobanteVentaFactory.TipoCambio_today.tipo_cambio, '')+']]');
                    
                }
                angular.element(stock).val(object.description.stock);
                angular.element(unidad_medida).val(object.description.unidad_medida.nombre_unidad_medida);
                

                angular.copy(object.description, ComprobanteVentaFactory.Producto_seleccionado);
            }

        }

        vm.seleccion_angucompleteproducto_nota = function(object){
            if($('#moneda').validationEngine('validate')){


                if(object.description.precio_unitario == null) object.description.precio_unitario=0;

                angular.copy(object.description, ComprobanteVentaFactory.Producto_seleccionado_nota);
            }

        }

        vm.seleccion_angucompleteproducto_gestion_nota = function(object){
            var index = this.$parent.$index;    

            if(object.description.precio_unitario == null) object.description.precio_unitario=0;
            angular.copy(object.description, ComprobanteVentaFactory.Producto_seleccionado_gestion_nota[index]);

        }

        vm.seleccion_angucompleteproducto_guia = function(object){

            var index = this.$parent.$index;    
                // if(object.description.precio_unitario == null) object.description.precio_unitario=0;
                // angular.element(stock).val(object.description.stock);
                // angular.element(unidad_medida).val(object.description.unidad_medida.nombre_unidad_medida);


            angular.copy(object.description, ComprobanteVentaFactory.Producto_seleccionado_guia[index]);
        }
        
        vm.seleccion_angucompletepartida_guia = function(object){
            
            var index = this.$parent.$index;    

            // angular.copy(object.description.punto_partida, vm.cabecera_guia[index].punto_partida);
            vm.cabecera_guia[index].punto_partida = object.description.punto_partida
        }
        vm.seleccion_angucompletellegada_guia = function(object){

            var index = this.$parent.$index;    

            // angular.copy(object.description.punto_llegada, vm.cabecera_guia[$index].punto_llegada);
            vm.cabecera_guia[index].punto_llegada = object.description.punto_llegada

        }
        
        vm.eliminar = function(index){
            ComprobanteVentaFactory.deleteAttempt(index);
        }

        vm.eliminar_detalle_nota = function(index){
            ComprobanteVentaFactory.deleteAttempt_detalle_nota(index);
        }

        vm.eliminar_letra = function(index){
            console.log(index);
            ComprobanteVentaFactory.deleteAttempt_letra(index);
        }

        vm.eliminar_letra_gestion_letra = function(index){
            ComprobanteVentaFactory.deleteAttempt_letra_gestion_letra(index);
        }

        vm.eliminar_detalle_factura = function(index){
            ComprobanteVentaFactory.deleteAttempt_detalle_factura(index);
        }
        
        vm.eliminar_detalle_guia = function(parent, index){
            ComprobanteVentaFactory.deleteAttempt_detalle_guia(parent, index);
        }
        
        vm.create = function(){
            ComprobanteVentaFactory.create();
        }

        vm.edit = function(row_detalle_venta, index){
            ComprobanteVentaFactory.edit(row_detalle_venta, index);
        }

        vm.store = function(){

            $("#tab_1").addClass('active');
            $("#li_tab_1").addClass('active');
            $("#tab_2").removeClass('active');
            $("#li_tab_2").removeClass('active');
            $("#tab_3").removeClass('active');
            $("#li_tab_3").removeClass('active');



            var gen_guia;
            console.log(vm.cabecera.generar_guia);

            if(vm.cabecera.generar_guia == undefined){
                gen_guia = false;
            }else{
                gen_guia = vm.cabecera.generar_guia;
            }

            console.log(vm.cabecera.generar_guia);

            if($("#form_cabecera").validationEngine('validate') && $("#form_detalle_table").validationEngine('validate')){
                if(Object.keys(vm.finanzas).length != 0){
                    if(vm.detalles_comprobante[0]!=null){
                        if(gen_guia==true){//CUANDO SE VA A GENERAR GUIASSSS JUNTO CON LA FACTURA DE VENTA

                            if(vm.cabecera_guia[0].serie_comprobante_guia==undefined || vm.cabecera_guia[0].numero_comprobante_guia==undefined || vm.cabecera_guia[0].fecha_comprobante_guia==undefined || vm.cabecera_guia[0].Motivo_seleccionado==undefined){
                                // alert('Debe completar los campos requeridos');
                                sweetAlert("Error...", "Debe completar los campos requeridos", "error");

                                $("#box_tab_1").removeClass('active');
                                $("#li_box_tab_1").removeClass('active');
                                $("#box_tab_2").addClass('active');
                                $("#li_box_tab_2").addClass('active');

                                $("#form_cabecera_guia_0").validationEngine("validate");
                            }
                            else{

                                var var_retencion = '';
                                var var_importe_aplicado = '';

                                if(ComprobanteVentaFactory.Cliente_seleccionado.agente_retenedor == 'true')
                                {
                                    var_retencion = angular.element(retencion).val();
                                    var_importe_aplicado = angular.element(importe_aplicado).val();
                                    if(ComprobanteVentaFactory.Nota_create.precio_nota)
                                    {
                                        var_retencion = angular.element(retencion_nota).val();
                                        var_importe_aplicado = angular.element(importe_aplicado_nota).val();
                                    }
                                }


                                // var total_factura = 0;
                                // var aux = 0;
                                // if($("#importe_aplicado_nota").length){ //TOTAL + AGENTE RETENEDOR + NOTA
                                //     if($("#importe_aplicado_nota").val()!=""){
                                //         total_factura = angular.element(importe_aplicado_nota).val();
                                //         aux=1;
                                //     }
                                // }
                                // if($("#importe_aplicado").length){//TOTAL + AGENTE RETENEDOR
                                //     if($("#importe_aplicado").val()!=""){
                                //         if(aux==0){
                                //             total_factura = angular.element(importe_aplicado).val();
                                //             aux=1;                        
                                //         }
                                //     }
                                // }
                                // if($("#total_nota").length){
                                //     if($("#total_nota").val()!=""){ //TOTAL + NOTA
                                //         if(aux==0){
                                //             total_factura = angular.element(total_nota).val();
                                //             aux=1;                        
                                //         }
                                //     }
                                // }
                                // if($("#total").length){//TOTAL SOLO
                                //     if($("#total").val()!=""){
                                //         if(aux==0){
                                //             total_factura = angular.element(total).val();
                                //             aux=1;                        
                                //         }
                                //     }
                                // }

                                var orden_compra="";
                                if(vm.cabecera.orden_compra){
                                    orden_compra = vm.cabecera.orden_compra;
                                }

                                var cabecera_create = {
                                        serie : vm.cabecera.serie_comprobante
                                        , numero : vm.cabecera.numero_comprobante
                                        , orden_compra : orden_compra
                                        , fecha : new XDate(vm.fecha_comprobante).toString('yyyy-MM-dd')
                                        , cliente : ComprobanteVentaFactory.Cliente_seleccionado
                                        , moneda : vm.cabecera.moneda
                                        , total : angular.element(total).val()
                                        , retencion : var_retencion
                                        , importe_aplicado : var_importe_aplicado
                                        , boolean_asociar : ComprobanteVentaFactory.CabeceraComprobante_create.boolean_asociar
                                        , id_guiasRemision : ComprobanteVentaFactory.Array_id_guias
                                };


                                var cabecera_guia_create = [];
                                var cant_guias = ComprobanteVentaFactory.numero_guias.length;
                                for (var i = 0; i < ComprobanteVentaFactory.numero_guias.length; i++) {
                                    var person_transporte;
                                    var unid_transporte;
                                    if(vm.cabecera_guia[i].personal_transporte == undefined){
                                        person_transporte = {id:null};
                                    }else{
                                        person_transporte = vm.cabecera_guia[i].personal_transporte;
                                    }
                                    if(vm.cabecera_guia[i].unidad_transporte == undefined){
                                        unid_transporte = {id:null};
                                    }else{
                                        unid_transporte = vm.cabecera_guia[i].unidad_transporte;
                                    }

                                    var punto_partida;
                                    var punto_llegada;

                                    if(vm.cabecera_guia[i].punto_partida == undefined){
                                        punto_partida = document.getElementById('punto_partida_guia'+i+'_value').value;
                                        
                                    }
                                    else{
                                        punto_partida = vm.cabecera_guia[i].punto_partida;
                                    }
                                    
                                    if(vm.cabecera_guia[i].punto_llegada == undefined){
                                        punto_llegada = document.getElementById('punto_llegada_guia'+i+'_value').value;
                                    }
                                    else{
                                        punto_llegada = vm.cabecera_guia[i].punto_llegada;
                                    }

                                    cabecera_guia_create.push({
                                                                serie : vm.cabecera_guia[i].serie_comprobante_guia
                                                                , numero : vm.cabecera_guia[i].numero_comprobante_guia
                                                                , fecha : new XDate(vm.cabecera_guia[i].fecha_comprobante_guia).toString('yyyy-MM-dd')
                                                                , punto_partida : punto_partida
                                                                , punto_llegada : punto_llegada
                                                                , motivo : vm.cabecera_guia[i].Motivo_seleccionado
                                                                , personal_transporte : person_transporte
                                                                , unidad_transporte : unid_transporte
                                                                , generar_guia : gen_guia
                                                                , detalle_guia : ComprobanteVentaFactory.Detalle_comprobante_guia[i]
                                                        });

                                };

                                var detalle_create = vm.detalles_comprobante;

                                // CREANDO DETALLE DE FINANZA

                                if(Object.keys(vm.finanzas).length == 0){
                                    vm.finanzas.condicion = {id:null};
                                }

                                // if(vm.finanzas.numero_dias == undefined){
                                //     vm.finanzas.numero_dias = null;
                                //     vm.finanzas.fecha_vencimiento = new XDate(vm.fecha_comprobante).toString('yyyy-MM-dd');
                                // }
                                // else{
                                //     // SI SE HA SELECCIONADO NUMERO DE DIAS AQUI SE CALCULA LA FECHA DE VENCIMIENTO
                                //     var fecha= new Date(vm.fecha_comprobante);
                                //     fecha.setDate(fecha.getDate()+parseInt(vm.finanzas.numero_dias));
                                //     vm.finanzas.fecha_vencimiento = new XDate(fecha).toString('yyyy-MM-dd');
                                // }
                                // if(vm.finanzas.numero_letra == undefined){
                                //     vm.finanzas.numero_letra = null;
                                // }
                                // if(vm.finanzas.estado == undefined){
                                //     vm.finanzas.estado = {id:null};
                                // }
                                // if(vm.finanzas.detalle_estado == undefined){
                                //     vm.finanzas.detalle_estado = null;
                                // }
                                if(vm.finanzas.medio == undefined){
                                    vm.finanzas.medio = {id:null};
                                }
                                else {
                                    
                                    if(!vm.finanzas.medio.detalle_medio_pago){
                                        vm.finanzas.medio.detalle_medio_pago = null;
                                    }
                                    if(!vm.finanzas.medio.fecha_pago){
                                        vm.finanzas.medio.fecha_pago = null;
                                    }
                                }
                                for (var i = 0; i < ComprobanteVentaFactory.Detalle_letra.length; i++) {
                                    ComprobanteVentaFactory.Detalle_letra[i].numero_dias = ComprobanteVentaFactory.Detalle_finanza[i].numero_dias;
                                };

                                vm.finanzas.detalles_letra = ComprobanteVentaFactory.Detalle_letra;

                                var finanzas_create = vm.finanzas;

                                if(Object.keys(vm.nota).length == 0){
                                    vm.nota.tipo_nota = {id:null};
                                }

                                vm.nota.monto_subtotal = angular.element(nota_subtotal).val();
                                vm.nota.monto_igv = angular.element(nota_igv).val();
                                vm.nota.monto_total = angular.element(nota_total).val();

                                if(vm.nota.motivo_nota == undefined){
                                    vm.nota.motivo_nota = {id:null};
                                }

                                for (var i = 0; i < ComprobanteVentaFactory.Detalle_nota.length; i++) {
                                    if(ComprobanteVentaFactory.Detalle_nota[i].id_producto == undefined){
                                        ComprobanteVentaFactory.Detalle_nota[i].id_producto = null;
                                        ComprobanteVentaFactory.Detalle_nota[i].merma = null;
                                    }
                                };

                                var nota_create = vm.nota;
                                var nota_detalle_create = ComprobanteVentaFactory.Detalle_nota;

                                ComprobanteVentaFactory.store(cabecera_create,cabecera_guia_create,detalle_create,finanzas_create,nota_create,nota_detalle_create); 
                            }

                        }
                        else{//CUANDO SE VA A GENERAR SOLO LA FACTURA DE VENTA

                            var var_retencion = '';
                            var var_importe_aplicado = '';

                            if(ComprobanteVentaFactory.Cliente_seleccionado.agente_retenedor == 'true')
                            {
                                var_retencion = angular.element(retencion).val();
                                var_importe_aplicado = angular.element(importe_aplicado).val();
                                if(ComprobanteVentaFactory.Nota_create.precio_nota)
                                {
                                    var_retencion = angular.element(retencion_nota).val();
                                    var_importe_aplicado = angular.element(importe_aplicado_nota).val();
                                }
                            }

                            var orden_compra="";
                            if(vm.cabecera.orden_compra){
                                orden_compra = vm.cabecera.orden_compra;
                            }

                            var cabecera_create = {
                                    serie : vm.cabecera.serie_comprobante
                                    , numero : vm.cabecera.numero_comprobante
                                    , orden_compra : orden_compra
                                    , fecha : new XDate(vm.fecha_comprobante).toString('yyyy-MM-dd')
                                    , cliente : ComprobanteVentaFactory.Cliente_seleccionado
                                    , moneda : vm.cabecera.moneda
                                    , total : angular.element(total).val()
                                    , retencion : var_retencion
                                    , importe_aplicado : var_importe_aplicado
                                    , boolean_asociar : ComprobanteVentaFactory.CabeceraComprobante_create.boolean_asociar
                                    , id_guiasRemision : ComprobanteVentaFactory.Array_id_guias
                            };


                            var cabecera_guia_create = [];

                            var detalle_create = vm.detalles_comprobante;

                            // CREANDO DETALLE DE FINANZA

                            if(Object.keys(vm.finanzas).length == 0){
                                vm.finanzas.condicion = {id:null};
                            }

                            // if(vm.finanzas.numero_dias == undefined){
                            //     vm.finanzas.numero_dias = null;
                            //     vm.finanzas.fecha_vencimiento = new XDate(vm.fecha_comprobante).toString('yyyy-MM-dd');
                            // }
                            // else{
                            //     // SI SE HA SELECCIONADO NUMERO DE DIAS AQUI SE CALCULA LA FECHA DE VENCIMIENTO
                            //     var fecha= new Date(vm.fecha_comprobante);
                            //     fecha.setDate(fecha.getDate()+parseInt(vm.finanzas.numero_dias));
                            //     vm.finanzas.fecha_vencimiento = new XDate(fecha).toString('yyyy-MM-dd');
                            // }
                            // if(vm.finanzas.numero_letra == undefined){
                            //     vm.finanzas.numero_letra = null;
                            // }
                            // if(vm.finanzas.estado == undefined){
                            //     vm.finanzas.estado = {id:null};
                            // }
                            // if(vm.finanzas.detalle_estado == undefined){
                            //     vm.finanzas.detalle_estado = null;
                            // }
                            if(vm.finanzas.medio == undefined){
                                vm.finanzas.medio = {id:null};
                            } else {
                                    console.log('QQQQQQQQQQQQQQQQQ');
                                    console.log(vm.finanzas.medio.detalle_medio_pago);
                                    console.log(vm.finanzas.medio.fecha_pago);
                                    if(!vm.finanzas.medio.detalle_medio_pago){
                                        vm.finanzas.medio.detalle_medio_pago = null;
                                    }
                                    if(!vm.finanzas.medio.fecha_pago){
                                        vm.finanzas.medio.fecha_pago = null;
                                    }
                            }

                            for (var i = 0; i < ComprobanteVentaFactory.Detalle_letra.length; i++) {
                                ComprobanteVentaFactory.Detalle_letra[i].numero_dias = ComprobanteVentaFactory.Detalle_finanza[i].numero_dias;
                            };
                            console.log('STORE');
                            console.log(ComprobanteVentaFactory.Detalle_letra);
                            vm.finanzas.detalles_letra = ComprobanteVentaFactory.Detalle_letra;
                            var finanzas_create = vm.finanzas;

                            if(Object.keys(vm.nota).length == 0){
                                vm.nota.tipo_nota = {id:null};
                            }

                            // vm.nota.total_nota = angular.element(total_nota).val();
                            // vm.nota.producto = ComprobanteVentaFactory.Producto_seleccionado_nota;

                            vm.nota.monto_subtotal = angular.element(nota_subtotal).val();
                            vm.nota.monto_igv = angular.element(nota_igv).val();
                            vm.nota.monto_total = angular.element(nota_total).val();

                            if(vm.nota.motivo_nota == undefined){
                                vm.nota.motivo_nota = {id:null};
                            }

                            for (var i = 0; i < ComprobanteVentaFactory.Detalle_nota.length; i++) {
                                if(ComprobanteVentaFactory.Detalle_nota[i].id_producto == undefined){
                                    ComprobanteVentaFactory.Detalle_nota[i].id_producto = null;
                                    ComprobanteVentaFactory.Detalle_nota[i].merma = null;
                                }
                            };

                            var nota_create = vm.nota;
                            var nota_detalle_create = ComprobanteVentaFactory.Detalle_nota;
                            console.log('nota_detalle_create');
                            console.log(nota_detalle_create);
                            ComprobanteVentaFactory.store(cabecera_create,cabecera_guia_create,detalle_create,finanzas_create,nota_create,nota_detalle_create); 
                        }

                    }
                    else{
                        // alert('Debe agregar un detalle al comprobante.');
                        sweetAlert("Error...", "Debe agregar un detalle al comprobante.", "error");
                    }
                }
                else{
                    // alert("Debe de elegir la Condicion de Pago");
                    sweetAlert("Error...", "Debe de elegir la Condicion de Pago", "error");
                    // location.href="#tab_2";
                    $("#tab_1").removeClass('active');
                    $("#li_tab_1").removeClass('active');
                    $("#tab_2").removeClass('active');
                    $("#li_tab_2").removeClass('active');
                    $("#tab_3").addClass('active');
                    $("#li_tab_3").addClass('active');
                }
                
            }
            // vm.tipo_local={};
        }
        

        vm.store_gestion_letra = function(detalle_letras, detalle_facturas){
            console.log('detalle_letras');
            console.log(detalle_letras);
            for (var i = 0; i < detalle_letras.length; i++) {
                detalle_letras[i].numero_dias = ComprobanteVentaFactory.Detalle_finanza_gestion_letra[i].numero_dias;
            };
            ComprobanteVentaFactory.store_gestion_letra(detalle_letras,detalle_facturas); 

        }

        vm.store_gestion_nota = function(nota, nota_detalle, detalle_facturas_nota){

            for (var i = 0; i < nota.length; i++) {
                nota[i].monto_subtotal = $("#gestion_nota_"+i+"_subtotal").val();
                nota[i].monto_igv = $("#gestion_nota_"+i+"_igv").val();
                nota[i].monto_total = $("#gestion_nota_"+i+"_total").val();

                if(nota[i].motivo_nota == undefined){
                    nota[i].motivo_nota = {id:null};
                }

                for (var j = 0; j < nota_detalle[i].length; j++) {
                    if(nota_detalle[i][j].id_producto == undefined){
                        nota_detalle[i][j].id_producto = null;
                        nota_detalle[i][j].merma = null;
                    }
                };
            };


            ComprobanteVentaFactory.store_gestion_nota(nota, nota_detalle,detalle_facturas_nota); 

        }


        vm.buscarProducto = function(){
            if($('#moneda').validationEngine('validate')){
                ComprobanteVentaFactory.buscarProducto();
            }
            
        }

        vm.buscarProducto_guia = function(index){
            ComprobanteVentaFactory.buscarProducto_guia(index);
        }

        vm.buscarProducto_gestion_nota = function(index){
            ComprobanteVentaFactory.buscarProducto_gestion_nota(index);
        }


        vm.buscarCliente = function(){
            ComprobanteVentaFactory.buscarCliente();
        }

        vm.nuevoCliente = function(){
            ComprobanteVentaFactory.nuevoCliente();
        }

        vm.nuevoProducto = function(){
            ComprobanteVentaFactory.nuevoProducto();
        }

        vm.actualizarCliente = function(){
            ComprobanteVentaFactory.getClientes();
        }

        vm.actualizarProducto = function(){
            ComprobanteVentaFactory.getProductos();
        }

        vm.actualizarTransporte = function(){
            ComprobanteVentaFactory.getEmpresas();
            ComprobanteVentaFactory.getUnidades();
            ComprobanteVentaFactory.getPersonales();
        }


        vm.set_codebar = function(){
            var posicion = vm.detalle_venta.codebar.indexOf('-');
            var id_producto = parseInt(vm.detalle_venta.codebar.substring(posicion+1));
            ComprobanteVentaFactory.getProductoByIdFromInvetarioProd(id_producto);
        }

        vm.agregar_detalle = function(){
            if($("#form_detalle").validationEngine('validate')){      

                ComprobanteVentaFactory.agregar_detalle(vm.detalle_comprobante);
                angular.element(nom_producto_value).val('');
                vm.detalle_comprobante.cantidad = '';
                vm.detalle_comprobante.unidadMedida = '';
                vm.detalle_comprobante.precio = '';

            }
        }

        vm.agregar_detalle_guia = function(index){
            if($("#form_detalle_guia_"+index).validationEngine('validate')){      

                ComprobanteVentaFactory.agregar_detalle_guia(vm.detalle_comprobante_guia[index], index);
                // angular.element(nom_producto_guia_value).val('');
                $scope.$broadcast('angucomplete-alt:clearInput', 'nom_producto_'+index);
                vm.detalle_comprobante_guia[index].cantidad = '';
                // vm.detalle_comprobante.unidadMedida = '';
                // vm.detalle_comprobante.precio = '';

            }
        }

        vm.agregar_detalle_nota = function(){
            if($("#form_detalle").validationEngine('validate')){      

                ComprobanteVentaFactory.agregar_detalle_nota(vm.nota);

            }
        }

        vm.agregar_detalle_nota_gestion_nota = function(index){
            if($("#form_gestion_nota_detalle_nota_"+index).validationEngine('validate')){      

                ComprobanteVentaFactory.agregar_detalle_nota_gestion_nota(vm.gestion_nota[index], index);

            }
        }

        vm.agregar_detalle_letra = function(){
            if($("#form_detalle_letra").validationEngine('validate')){

                if(vm.fecha_comprobante != undefined){
                    // ComprobanteVentaFactory.agregar_detalle_letra(vm.finanzas.letra, vm.fecha_comprobante);
                    var detalle_letra = vm.finanzas.letra;
                    var fecha_comprobante = vm.fecha_comprobante;
                    var dias_letra;
                    var fecha_vencimiento_let;
                    if(detalle_letra.fecha_vencimiento){
                        dias_letra = Math.round((  (new Date(new XDate(detalle_letra.fecha_vencimiento).toString('yyyy-MM-dd') + " 00:00:00")).getTime() - (new Date(new XDate(fecha_comprobante).toString('yyyy-MM-dd') + " 00:00:00")).getTime())/(1000 * 60 * 60 * 24));
                        fecha_vencimiento_let = detalle_letra.fecha_vencimiento;
                    }
                    else if(detalle_letra.numero_dias){
                        // var fecha_vencimiento = fecha_comprobante.setSeconds((detalle_letra.numero_dias) * 86400);
                        // var fecha_vencimiento = fecha_comprobante.setSeconds((detalle_letra.numero_dias) * 86400);
                        dias_letra = detalle_letra.numero_dias;
                        fecha_vencimiento_let = new Date(fecha_comprobante.getTime() + (detalle_letra.numero_dias * 24 * 3600 * 1000));

                    }
                    console.log('dias_letra');
                    console.log(dias_letra);
                    // console.log("Fecha final: " + fecha_vencimiento.getDate() + "/" + (fecha_vencimiento.getMonth() + 1) + "/" + fecha_vencimiento.getFullYear());

                    // ME QUEDE AQUI ********************************************************************************************************************************************************************************************************************************************************
                    var cantidad_registros_detalle = ComprobanteVentaFactory.Detalle_letra.length + 1;

                    var total_factura = 0;
                    var aux = 0;
                    if($("#importe_aplicado_nota").length){ //TOTAL + AGENTE RETENEDOR + NOTA
                        if($("#importe_aplicado_nota").val()!=""){
                            total_factura = angular.element(importe_aplicado_nota).val();
                            aux=1;
                        }
                    }
                    if($("#importe_aplicado").length){//TOTAL + AGENTE RETENEDOR
                        if($("#importe_aplicado").val()!=""){
                            if(aux==0){
                                total_factura = angular.element(importe_aplicado).val();
                                aux=1;                        
                            }
                        }
                    }
                    if($("#total_nota").length){
                        if($("#total_nota").val()!=""){ //TOTAL + NOTA
                            if(aux==0){
                                total_factura = angular.element(total_nota).val();
                                aux=1;                        
                            }
                        }
                    }
                    if($("#total").length){//TOTAL SOLO
                        if($("#total").val()!=""){
                            if(aux==0){
                                total_factura = angular.element(total).val();
                                aux=1;                        
                            }
                        }
                    }

                        console.log(total_factura);

                    var monto_letra = Math.round((total_factura/cantidad_registros_detalle )* 1000) / 1000;
                    // console.log('########################################################');
                    // console.log(total);
                    // console.log(total_retencion);
                    // console.log(total_nota);
                    // console.log(total_retencion_nota);
                    // console.log('########################################################');

                    // var acum_total = 0;
                    // falta calcular el total de lafactura para dividirlas a las letras ********************************************************************************************************************************************************************************************************************************************************


                    // ComprobanteVentaFactory.Detalle_letra.push({
                    //                                                 numero_letra : detalle_letra.numero_letra
                    //                                                 , numero_dias : dias_letra
                    //                                                 , fecha_vencimiento : new XDate(detalle_letra.fecha_vencimiento).toString('yyyy-MM-dd')
                    //                                                 , monto_letra : Math.round((acum_total/cantidad_registros_detalle )* 1000) / 1000
                    //                                             });



                    ComprobanteVentaFactory.Detalle_letra.push({
                                                                    numero_letra : detalle_letra.numero_letra
                                                                    , numero_dias : dias_letra
                                                                    , monto_letra : monto_letra
                                                                    , fecha_vencimiento : new XDate(fecha_vencimiento_let).toString('yyyy-MM-dd')

                                                                });

                    for (var i = 0; i < ComprobanteVentaFactory.Detalle_letra.length; i++) {
                        console.log('ENTRO ACTUALIZAR');
                        ComprobanteVentaFactory.Detalle_letra[i].monto_letra = Math.round((total_factura/cantidad_registros_detalle )* 1000) / 1000;
                        // vm.detalles_finanza[i].monto_letra = Math.round((total_factura/cantidad_registros_detalle )* 1000) / 1000;
                    };

                    console.log(ComprobanteVentaFactory.Detalle_letra);


                    angular.element(numero_letra).val('');
                    angular.element(fecha_vencimiento_letra).val('');
                    angular.element(numero_dias).val('');
                    ComprobanteVentaFactory.Finanzas_create.letra.fecha_vencimiento = null;
                    ComprobanteVentaFactory.Finanzas_create.letra.numero_dias = null;
                }
                else{
                    // alert('Debe seleccionar la Fecha de Emision del Comprobante');
                    sweetAlert("Error...", "Debe seleccionar la Fecha de Emision del Comprobante", "error");
                }
                
            }
        }

        vm.agregar_detalle_letra_gestion_letra = function(){
            if($("#form_gestion_letra_detalle_letra").validationEngine('validate')){

                // ComprobanteVentaFactory.agregar_detalle_letra_gestion_letra(vm.gestion_letra,vm.detalles_factura);

                var detalle_letra = vm.gestion_letra;
                var array_facturas = vm.detalles_factura;
                var dias_letra;
                var fecha_vencimiento_let;
                
                var index_array_facturas = array_facturas.length - 1;

                if(detalle_letra.fecha_vencimiento){
                    dias_letra = Math.round((  (new Date(new XDate(detalle_letra.fecha_vencimiento).toString('yyyy-MM-dd') + " 00:00:00")).getTime() - (new Date(new XDate(array_facturas[index_array_facturas].fecha).toString('yyyy-MM-dd') + " 00:00:00")).getTime())/(1000 * 60 * 60 * 24));
                    fecha_vencimiento_let = detalle_letra.fecha_vencimiento;
                }
                else if(detalle_letra.numero_dias){
                    dias_letra = detalle_letra.numero_dias;
                    fecha_vencimiento_let = new Date(new Date( (array_facturas[index_array_facturas].fecha).toString('yyyy-MM-dd') + " 00:00:00").getTime() + (detalle_letra.numero_dias * 24 * 3600 * 1000));
                }

                var cantidad_registros_detalle = ComprobanteVentaFactory.Detalle_letra_gestion_letra.length + 1;

                var acum_total = 0;

                console.log('array_facturas');
                console.log(array_facturas);
                for (var i = 0; i < array_facturas.length; i++) {
                    acum_total = acum_total + array_facturas[i].total_comprobante - array_facturas[i].monto_retencion;
                console.log('array_facturas[i].detalle_nota');
                console.log(array_facturas[i].detalle_nota);
                    if(array_facturas[i].detalle_nota.length > 0){
                        for (var ind = 0; ind < array_facturas[i].detalle_nota.length; ind++) {
                            if(array_facturas[i].detalle_nota[ind].tipo_nota.id==1){
                                console.log('ENTRO DEBITO');
                                acum_total = acum_total + array_facturas[i].detalle_nota[ind].precio;
                            }
                            else if(array_facturas[i].detalle_nota[ind].tipo_nota.id==2){
                                console.log('ENTRO CREDITO');
                                acum_total = acum_total - array_facturas[i].detalle_nota[ind].precio;
                            }
                        };
                    }
                    
                };

                ComprobanteVentaFactory.Detalle_letra_gestion_letra.push({
                                                                numero_letra : detalle_letra.numero_letra
                                                                , numero_dias : dias_letra
                                                                , fecha_vencimiento : new XDate(fecha_vencimiento_let).toString('yyyy-MM-dd')
                                                                , monto_letra : Math.round((acum_total/cantidad_registros_detalle )* 1000) / 1000
                                                            });


                for (var i = 0; i < ComprobanteVentaFactory.Detalle_letra_gestion_letra.length; i++) {
                    ComprobanteVentaFactory.Detalle_letra_gestion_letra[i].monto_letra = Math.round((acum_total/cantidad_registros_detalle )* 1000) / 1000;
                    vm.detalles_letra_gestion_letra[i].monto_letra = Math.round((acum_total/cantidad_registros_detalle )* 1000) / 1000;
                };


                angular.element(numero_letra).val('');
                angular.element(fecha_vencimiento_letra).val('');
                angular.element(numero_dias_gestion_letra).val('');
                angular.copy({}, vm.gestion_letra);
            }
        }


        vm.agregar_detalle_factura = function(){
            if($("#form_gestion_letra_factura").validationEngine('validate')){

                ComprobanteVentaFactory.agregar_detalle_factura(vm.gestion_letra);

            }
        }

        vm.agregar_detalle_factura_nota = function(){
            if($("#form_gestion_nota_factura").validationEngine('validate')){

                ComprobanteVentaFactory.agregar_detalle_factura_nota(vm.gestion_nota_factura);

            }
        }

        vm.calcular_vencimiento_letra = function(numero_dias, index){
            var vencimiento = new Date(vm.fecha_comprobante.getTime() + (numero_dias * 24 * 3600 * 1000));
            var fec_vencimiento = new XDate(vencimiento).toString('yyyy-MM-dd');
            vm.detalles_finanza[index].fecha_vencimiento = fec_vencimiento;
            // vm.detalles_letra[index].fecha_vencimiento = fec_vencimiento;
            // ComprobanteVentaFactory.Detalle_letra[index].fecha_vencimiento = fec_vencimiento;
        }


        vm.calcular_vencimiento_letra_gestion_letra = function(numero_dias, index){
            console.log('ENTRO VENCIMIMENTO GESITON LETRA');
            var fec_vencimiento;

            var index_array_facturas = vm.detalles_factura.length - 1;

            fec_vencimiento = new XDate( new Date(new Date( (vm.detalles_factura[index_array_facturas].fecha).toString('yyyy-MM-dd') + " 00:00:00").getTime() + (numero_dias * 24 * 3600 * 1000)) ).toString('yyyy-MM-dd');
            
            ComprobanteVentaFactory.Detalle_letra_gestion_letra[index].fecha_vencimiento = fec_vencimiento;
            // console.log(vm.detalles_finanza_gestion_letra);
            // vm.detalles_letra[index].fecha_vencimiento = fec_vencimiento;
            // ComprobanteVentaFactory.Detalle_letra[index].fecha_vencimiento = fec_vencimiento;
        }

        vm.calcular_total = function(){
            ComprobanteVentaFactory.calcular_total();
        }

        vm.calcular_total_nota = function(){
            ComprobanteVentaFactory.calcular_total_nota();
        }

        vm.calcular_importe_nota = function(){
            if(vm.nota.tipo_nota){
                ComprobanteVentaFactory.calcular_importe_nota();
            }
        }

        vm.moneda_change = function(){
            // ComprobanteVentaFactory.calcular_total();
            if(vm.cabecera.moneda==null){
                vm.deshabilitar_agregar = true;
            }
            else{
                vm.deshabilitar_agregar = false;
            }

        }        
        vm.deshabilitar_agregar = true;


        vm.modal_asociar = function(){

            ComprobanteVentaFactory.modal_asociar();
        }
        


        // ***************  GUIA DE REMISION **************
        // ***************  GUIA DE REMISION **************
        // ***************  GUIA DE REMISION **************
        // ***************  GUIA DE REMISION **************
        // ***************  GUIA DE REMISION **************
        // ***************  GUIA DE REMISION **************
        // ***************  GUIA DE REMISION **************
        // ***************  GUIA DE REMISION **************
        // ***************  GUIA DE REMISION **************
        // ***************  GUIA DE REMISION **************
        // ***************  GUIA DE REMISION **************

        ComprobanteVentaFactory.getEmpresas();
        ComprobanteVentaFactory.getMotivos();
        ComprobanteVentaFactory.getPartidaGuia();
        ComprobanteVentaFactory.getLlegadaGuia();

        vm.empresas = ComprobanteVentaFactory.Empresas;
        vm.motivos = ComprobanteVentaFactory.Motivos;
        vm.motivos_nota = ComprobanteVentaFactory.MotivosNota;
        vm.unidades = ComprobanteVentaFactory.Unidades;
        vm.personales = ComprobanteVentaFactory.Personales;

        vm.cabecera_guia[0] = {Motivo_seleccionado:{}};
        vm.abrir_motivo = function(index){
            vm.cabecera_guia[index].Motivo_seleccionado = null;
        }

        vm.seleccion_empresa = function(id_empresa){
            ComprobanteVentaFactory.getUnidades(id_empresa);
            ComprobanteVentaFactory.getPersonales(id_empresa);
        }

        // vm.generar_guia = false;
        vm.numero_guias = ComprobanteVentaFactory.numero_guias;
        ComprobanteVentaFactory.Detalle_comprobante_guia[0] = [];
        ComprobanteVentaFactory.Producto_seleccionado_guia[0] = {};
        vm.nueva_guia = function(){
            vm.numero_guias.push({n_guia:(ComprobanteVentaFactory.numero_guias.length+1)});
            vm.cabecera_guia[ComprobanteVentaFactory.numero_guias.length-1] = {Motivo_seleccionado:{}};
            ComprobanteVentaFactory.Detalle_comprobante_guia[ComprobanteVentaFactory.numero_guias.length-1] = [];
            ComprobanteVentaFactory.Producto_seleccionado_guia[ComprobanteVentaFactory.numero_guias.length-1] = [];
        }

        vm.pasar_factura = function(){
            var contador_empresa = 0;
            for (var i = 0; i < vm.cabecera_guia.length; i++) {
                if(vm.cabecera_guia[i].empresa == undefined){
                    contador_empresa++;
                }
            };
            if(contador_empresa > 0){

                swal({   
                        title: contador_empresa+" Guía(s) de remisión sin Transporte"
                        , text: "¿Desea continuar?"
                        , type: "warning",   showCancelButton: true
                        , confirmButtonColor: "#A5DC86"
                        , confirmButtonText: "Continuar"
                        , closeOnConfirm: true 
                    }, 
                    function(){
                        console.log('11');
                        var aux_cabecera = 0;
                        var aux_detalle = 0;
                        var aux_general = 0;
                        console.log('22');
                        for (var i = 0; i < ComprobanteVentaFactory.numero_guias.length; i++) {
                            console.log('33');
                            if($("#form_cabecera_guia_"+i).validationEngine('validate')){
                                aux_cabecera = 0;
                            }
                            else{
                                aux_cabecera++;
                            }
                            
                            if(ComprobanteVentaFactory.Detalle_comprobante_guia[i].length != 0){
                                if($("#form_detalle_table_"+i).validationEngine('validate')){
                                    aux_detalle = 0;
                                }
                                else{
                                    aux_detalle++;
                                }
                            }
                            if(aux_cabecera != 0 || aux_detalle != 0){
                                console.log('44');
                                aux_general++;
                            }
                        };
                        if(aux_general == 0){
                            console.log('55');

                            ComprobanteVentaFactory.pasar_factura();
                            // $("#tab_1").removeClass('active');
                            // $("#li_tab_1").removeClass('active');
                            // $("#tab_1").addClass('active');
                            // $("#li_tab_1").addClass('active');
                            // $("#tab_1").hide();
                            // $("#li_tab_1").hide();
                            // $("#tab_1").addClass('hide');
                            // $("#li_tab_1").addClass('hide');
                            // $("#tab_1").removeClass('hide');
                            // $("#li_tab_1").removeClass('hide');
                        }
                    });
            }
            else{
                var aux_cabecera = 0;
                var aux_detalle = 0;
                var aux_general = 0;
                for (var i = 0; i < ComprobanteVentaFactory.numero_guias.length; i++) {
                    if($("#form_cabecera_guia_"+i).validationEngine('validate')){
                        aux_cabecera = 0;
                    }
                    else{
                        aux_cabecera++;
                    }
                    
                    if(ComprobanteVentaFactory.Detalle_comprobante_guia[i].length != 0){
                        if($("#form_detalle_table_"+i).validationEngine('validate')){
                            aux_detalle = 0;
                        }
                        else{
                            aux_detalle++;
                        }
                    }
                    if(aux_cabecera != 0 || aux_detalle != 0){
                        aux_general++;
                    }
                };
                if(aux_general == 0){
                    ComprobanteVentaFactory.pasar_factura();
                }
            }
        }

        // ************** GESTION NOTA - TABS NOTAS ****************
        
        ComprobanteVentaFactory.getAllMotivoNota();

        vm.numero_notas = ComprobanteVentaFactory.numero_notas;
        ComprobanteVentaFactory.Detalle_nota_gestion_nota[0] = [];
        ComprobanteVentaFactory.Producto_seleccionado_gestion_nota[0] = {};

        vm.nueva_nota = function(){
            vm.numero_notas.push({n_nota:(ComprobanteVentaFactory.numero_notas.length+1)});
            vm.gestion_nota[ComprobanteVentaFactory.numero_notas.length-1] = {};
            ComprobanteVentaFactory.Detalle_nota_gestion_nota[ComprobanteVentaFactory.numero_notas.length-1] = [];
            ComprobanteVentaFactory.Producto_seleccionado_gestion_nota[ComprobanteVentaFactory.numero_notas.length-1] = [];
        }

    });

 
    app.factory('ComprobanteVentaFactory', function ComprobanteVentaFactory($http, $modal ) {

        ComprobanteVentaFactory.detalle_venta = {}; 
        ComprobanteVentaFactory.cabecera_venta = {}; 
        ComprobanteVentaFactory.detalle_venta.producto = {}; 
        ComprobanteVentaFactory.seleccion_producto = {}; 
        ComprobanteVentaFactory.Producto_create = {};
        ComprobanteVentaFactory.Cliente_create = {};
        ComprobanteVentaFactory.Detalle_venta_edit = {};

        ComprobanteVentaFactory.Productos = [];
        ComprobanteVentaFactory.UnidadMedida = [];
        ComprobanteVentaFactory.Composicion = [];
        ComprobanteVentaFactory.Titulo = [];
        ComprobanteVentaFactory.Hilatura = [];
        ComprobanteVentaFactory.TipoProducto = [];
        ComprobanteVentaFactory.TipoTela = [];
        ComprobanteVentaFactory.Color = [];

        ComprobanteVentaFactory.Clientes = [];
        ComprobanteVentaFactory.Partida = [];
        ComprobanteVentaFactory.Llegada = [];
        ComprobanteVentaFactory.Monedas = [];
        ComprobanteVentaFactory.CondicionesPago = [];
        ComprobanteVentaFactory.MediosPago = [];
        ComprobanteVentaFactory.EstadosLetra = [];
        ComprobanteVentaFactory.TipoNotas = [];

        ComprobanteVentaFactory.Array_id_guias = [];
        ComprobanteVentaFactory.Detalle_comprobante = [];
        ComprobanteVentaFactory.Detalle_nota = [];
        ComprobanteVentaFactory.Detalle_comprobante_guia = [];
        ComprobanteVentaFactory.Detalle_letra = [];
        ComprobanteVentaFactory.Detalle_finanza = [];
        ComprobanteVentaFactory.Detalle_finanza_gestion_letra = [];
        ComprobanteVentaFactory.Detalle_letra_gestion_letra = [];
        ComprobanteVentaFactory.Detalle_nota_gestion_nota = [];
        ComprobanteVentaFactory.Detalle_factura = [];
        ComprobanteVentaFactory.Detalle_factura_nota = [];
        ComprobanteVentaFactory.Cliente_seleccionado = {};
        ComprobanteVentaFactory.Producto_seleccionado = {};
        ComprobanteVentaFactory.Producto_seleccionado_gestion_nota = {};
        ComprobanteVentaFactory.Producto_seleccionado_nota = {};
        ComprobanteVentaFactory.Producto_seleccionado_guia = [];

        ComprobanteVentaFactory.CabeceraComprobante_create = {};
        ComprobanteVentaFactory.CabeceraComprobanteGuia_create = [];
        ComprobanteVentaFactory.Gestion_letra = {};
        ComprobanteVentaFactory.Gestion_nota = [];
        ComprobanteVentaFactory.Finanzas_create = {};
        ComprobanteVentaFactory.Nota_create = {};
        ComprobanteVentaFactory.DetalleComprobante_create = {};
        ComprobanteVentaFactory.TipoCambio_create = {};
        ComprobanteVentaFactory.TipoCambio_today = {};
        ComprobanteVentaFactory.CabeceraComprobante_create.boolean_asociar = false;

        ComprobanteVentaFactory.numero_guias = [{n_guia:1}];
        ComprobanteVentaFactory.numero_notas = [{n_nota:1}];
        // var fecha_actual = new XDate(new Date()+1).toString('yyyy-MM-dd');

             // var fecha_actual= new Date();
            // fecha_actual.setDate(fecha_actual.getDate());
            // fecha_actual = new XDate(fecha_actual).toString('yyyy-MM-dd');
        // ComprobanteVentaFactory.FechaComprobante = fecha_actual;



        ComprobanteVentaFactory.getAllComposicion = function() {
            return $http.get('AdsComposicion/getAllComposicion').success(function(data) {
                angular.copy(data.datos, ComprobanteVentaFactory.Composicion );
            });
        } 
        ComprobanteVentaFactory.getAllTitulo = function() {
            return $http.get('AdsTitulo/getAllTitulo').success(function(data) {
                angular.copy(data.datos, ComprobanteVentaFactory.Titulo );
            });
        } 
        ComprobanteVentaFactory.getAllHilatura = function() {
            return $http.get('AdsHilatura/getAllHilatura').success(function(data) {
                angular.copy(data.datos, ComprobanteVentaFactory.Hilatura );
            });
        } 
        ComprobanteVentaFactory.getAllTipoProducto = function() {
            return $http.get('AdsTipoProducto/getAllTipoProducto').success(function(data) {
                angular.copy(data.datos, ComprobanteVentaFactory.TipoProducto );
            });
        } 

        ComprobanteVentaFactory.getAllTipoTela = function() {
            return $http.get('AdsTipoTela/getAllTipoTela').success(function(data) {
                angular.copy(data.datos, ComprobanteVentaFactory.TipoTela );
            });
        } 
        ComprobanteVentaFactory.getAllColor = function() {
            return $http.get('AdsColor/getAllColor').success(function(data) {
                angular.copy(data.datos, ComprobanteVentaFactory.Color );
            });
        } 

        ComprobanteVentaFactory.getAllUnidadMedida = function() {

            return $http.get('AdsUnidadMedida/getAllUnidadMedida').success(function(data) {
                angular.copy(data.datos, ComprobanteVentaFactory.UnidadMedida );
            });
        } 


        ComprobanteVentaFactory.modal_asociar = function(){
            $modal.open( { 
                templateUrl:'templates_angular/ComprobanteVentaController/asociar_guia.html', 
                controller: function($scope, $modalInstance, ComprobanteVentaFactory) {
                    $scope.guia = {};
                    $scope.guia.detalles_asociar = [];
                    var cabecera = {};
                    var detalle = [];
                    var cliente = {};
                    var Object_datos = {};
                    var Array_detalle_final = [];
                    var Array_id_guias = [];
                    var acum_unidades = 0;
                    var acum_peso = 0;

                    $scope.agregar_guia = function(){
        angular.element(div_loader).removeClass('hide');
                        $scope.guia.compra_venta = 'VENTA';
                        $http.post('AdsGuiaRemision/getGuiaBySerieNumero', {guia:$scope.guia})
                            .success(function(data){
        angular.element(div_loader).addClass('hide');

                                if(data.datos == ''){
                                    // alert('Esta Guia de Remision no existe.');
                                    sweetAlert("Error...", "Esta Guia de Remision no existe.", "error");
                                }
                                else if(data.datos[0].id_comprobanteVenta != null){
                                    // alert('Esta Guia ya esta asociada a otra Factura de Venta.');
                                    sweetAlert("Error...", "Esta Guia ya esta asociada a otra Factura de Venta.", "error");
                                }
                                else{
                                    
                                    $scope.guia.detalles_asociar.push({serie:$scope.guia.serie, numero:$scope.guia.numero});
                                    angular.copy(data.datos[0],Object_datos);
                                    detalle.push(data.datos[0].guia_remision_detalle);
                                    Array_id_guias.push(data.datos[0].id);
                                    angular.copy(data.datos[0].guia_remision_detalle,Array_detalle_final);


                                }

                                
                            });

                    }

                    $scope.asociar = function(){

                        // ***** COPIANDO ID'S DE GUIAS ASOCIADAS A SCOPE FACTORY *****
                        angular.copy(Array_id_guias,ComprobanteVentaFactory.Array_id_guias);
                        // ***** FIIIN COPIANDO ID'S DE GUIAS ASOCIADAS A SCOPE FACTORY *****

                        // *************    ACUMULANDO UNIUDADES Y PESO DE LOS DETALLES DE GUIAS     **************
                        for (var i = 0; i < detalle.length; i++) {
                            // data.datos[0].guia_remision_detalle[i].unidades;
                            for (var j = 0; j < detalle[i].length; j++) {
                                acum_unidades = acum_unidades + detalle[i][j].unidades;
                                acum_peso = acum_peso + detalle[i][j].peso;
                            }
                        }
                        
                        Array_detalle_final[0].peso = acum_peso;
                        Array_detalle_final[0].unidades = acum_peso;

                                    // angular.copy(Array_detalle_final,ComprobanteVentaFactory.Detalle_comprobante);
                                    // console.log('ComprobanteVentaFactory.Detalle_comprobante');
                                    // console.log(ComprobanteVentaFactory.Detalle_comprobante);

                                    ComprobanteVentaFactory.Detalle_comprobante.push({
                                        'id_producto': Array_detalle_final[0].id_producto
                                        , 'nombre_producto': Array_detalle_final[0].nombre_producto
                                        , 'producto': Array_detalle_final[0].producto.nombre_producto
                                        , 'unidades': Array_detalle_final[0].unidades
                                        , 'peso': Array_detalle_final[0].peso
                                        , 'precio_unitario': 0
                                    });
                        // *************    FIIN ACUMULANDO UNIUDADES Y PESO DE LOS DETALLES DE GUIAS     **************

                        
                                    ComprobanteVentaFactory.CabeceraComprobante_create.boolean_asociar = true;
                                    // *************** SETEAR ID GUIA REMISION *******************
                                    ComprobanteVentaFactory.CabeceraComprobante_create.id_guiaRemision = Object_datos.id;
                                    // *************** FIIN SETEAR ID GUIA REMISION *******************

                                    var data_datos_fiscal = {};


                                    // MEOTOD POST PARA OBTENER LA DIRECCION FISCAL DEL CLIENTE Y SETEARLO EN LA FACTURA
                                angular.element(div_loader).removeClass('hide');
                                    $http.post('PtvCliente/getDirecFiscal',{id_cliente : Object_datos.cliente_detalle.cliente.id})
                                        .success(function(data){
                                angular.element(div_loader).addClass('hide');

                                            angular.copy(data.datos[0], data_datos_fiscal);

                                            ComprobanteVentaFactory.Cliente_seleccionado.id_cliente_seleccionado = Object_datos.cliente_detalle.cliente.id;
                                            ComprobanteVentaFactory.Cliente_seleccionado.id_direccion_seleccionada = data_datos_fiscal.id;
                                            ComprobanteVentaFactory.Cliente_seleccionado.direccion_seleccionada = data_datos_fiscal.direccion_cliente;


                                            // *************** SETEAR DATOS DEL CLIENTE *******************
                                            angular.element(cliente_value).val(Object_datos.cliente_detalle.cliente.razon_social);
                                            angular.element(ruc).val(Object_datos.cliente_detalle.cliente.ruc);
                                            angular.element(direccion).val(data_datos_fiscal.direccion_cliente);


                                            if(Object_datos.cliente_detalle.cliente.agente_retenedor == 'true')
                                            {
                                                angular.element(label_agente_retenedor).text('AGENTE RETENEDOR');
                                                ComprobanteVentaFactory.Cliente_seleccionado.agente_retenedor = 'true';

                                            }
                                            else
                                            {
                                                angular.element(label_agente_retenedor).text('');
                                            }

                                            // ***************  FIIN SETEAR DATOS DEL CLIENTE *******************

                                            
                                            // ***************  SETEAR DATOS DEL DETALLE *******************
                                            // angular.copy(Object_datos.guia_remision_detalle,ComprobanteVentaFactory.Detalle_comprobante);
                                            
                                            // ***************  FIIN SETEAR DATOS DEL DETALLE *******************

                                            $modalInstance.close();
                                        });
                                    


                    }

                }
            });
        }

        ComprobanteVentaFactory.cancelar_comprobante = function(){
            $modal.open( { 
                templateUrl:'templates_angular/ComprobanteCompraController/cancelar_comprobante.html', 
                controller: function($scope, $modalInstance, ComprobanteVentaFactory) {
                    $scope.yes = function() {

                        angular.copy({},ComprobanteVentaFactory.Detalle_comprobante); 
                        angular.copy({},ComprobanteVentaFactory.CabeceraComprobante_create); 

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

        ComprobanteVentaFactory.getRowTipoCambioToday = function() {
        angular.element(div_loader).removeClass('hide');
            $http.get('AdsTipoCambioMoneda/getRowTipoCambioToday')
                .success(function(data){
        angular.element(div_loader).addClass('hide');
                    console.log(data);
                    angular.copy({tipo_cambio:data.datos}, ComprobanteVentaFactory.TipoCambio_today);
                });
        }


        ComprobanteVentaFactory.getDireccionFiscal = function(id_cliente) {

            angular.element(div_loader).removeClass('hide');
                $http.post('PtvCliente/getDirecFiscal',{id_cliente : id_cliente})
                    .success(function(data){
            angular.element(div_loader).addClass('hide');
                        console.log(data);
                        return data.datos;
                    });
        }

        ComprobanteVentaFactory.validar_tipoCambio = function(fecha) {
        angular.element(div_loader).removeClass('hide');
            $http.post('AdsComprobanteVenta/validar_tipoCambio', {fecha:fecha})
                .success(function(data){
        angular.element(div_loader).addClass('hide');
                    if(data == 'EXISTE'){
                        console.log('existe');
                    }
                    else if(data == 'NO EXISTE'){
                        $modal.open( { 
                            templateUrl:'templates_angular/ComprobanteCompraController/confirmacion_tipoCambio.html', 
                            controller: function($scope, $modalInstance, ComprobanteVentaFactory, TipoCambio_create) {
                                
                                $scope.tipoCambio = TipoCambio_create;

                                $scope.store = function() {
                                    $scope.tipoCambio.fecha = fecha;
                                    ComprobanteVentaFactory.storeTipoCambio($scope.tipoCambio).then(function(){

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
                                    return ComprobanteVentaFactory.TipoCambio_create;
                                }
                            }
                        });
                        console.log('no existe');
                    }
                });
        }


        ComprobanteVentaFactory.storeTipoCambio = function(scope) {
        angular.element(div_loader).removeClass('hide');
                 return $http.post('AdsTipoCambioMoneda', scope)
                    .success(function(data){
        angular.element(div_loader).addClass('hide');

                    });
        }
        


        ComprobanteVentaFactory.imprimir = function(cabecera, detalle, totales) {
        angular.element(div_loader).removeClass('hide');
            $http.post('AdsComprobanteVenta/imprimir', {cabecera:cabecera, detalle:detalle, totales:totales})
                .success(function(data){
        angular.element(div_loader).addClass('hide');

                    var htmlObject = document.createElement('html');
                    htmlObject.innerHTML = data;

                    var ventimp=window.open(' ','popimpr');
                    ventimp.document.write(htmlObject.innerHTML);
                    ventimp.document.close();
                    ventimp.print();
                    ventimp.close();
                });
        }

        ComprobanteVentaFactory.getProductos = function() {
        angular.element(div_loader).removeClass('hide');
            return $http.get('AdsProducto/getAllProductos').success(function(data) {
        angular.element(div_loader).addClass('hide');
                angular.copy(data.datos, ComprobanteVentaFactory.Productos);

            });
        }

        ComprobanteVentaFactory.getClientes = function() {
        angular.element(div_loader).removeClass('hide');
            return $http.get('PtvCliente/getAllClientes').success(function(data) {
        angular.element(div_loader).addClass('hide');
                angular.copy(data.datos, ComprobanteVentaFactory.Clientes);
            });
        } 

        ComprobanteVentaFactory.getPartidaGuia = function() {
        angular.element(div_loader).removeClass('hide');
            return $http.get('AdsGuiaRemision/getAllPartidaGuia').success(function(data) {
        angular.element(div_loader).addClass('hide');
                console.log('PARTIDA');
                console.log(data.datos);
                angular.copy(data.datos, ComprobanteVentaFactory.Partida);
            });
        } 

        ComprobanteVentaFactory.getLlegadaGuia = function() {
        angular.element(div_loader).removeClass('hide');
            return $http.get('AdsGuiaRemision/getAllLlegadaGuia').success(function(data) {
        angular.element(div_loader).addClass('hide');
                console.log('LLEGADA');
                console.log(data.datos);
                angular.copy(data.datos, ComprobanteVentaFactory.Llegada);
            });
        } 


        ComprobanteVentaFactory.getMonedas = function() {
        angular.element(div_loader).removeClass('hide');
            return $http.get('AdsMoneda/getAllMonedas').success(function(data) {
        angular.element(div_loader).addClass('hide');
                angular.copy(data.datos, ComprobanteVentaFactory.Monedas);
            });
        }

        ComprobanteVentaFactory.getEstadoLetra = function() {
        angular.element(div_loader).removeClass('hide');
            return $http.get('AdsComprobanteVenta/getAllEstadoLetra').success(function(data) {
        angular.element(div_loader).addClass('hide');
                angular.copy(data.datos, ComprobanteVentaFactory.EstadosLetra);
            });
        }

        ComprobanteVentaFactory.getMedioPago = function() {
        angular.element(div_loader).removeClass('hide');
            return $http.get('AdsComprobanteVenta/getAllMedioPago').success(function(data) {
        angular.element(div_loader).addClass('hide');
                angular.copy(data.datos, ComprobanteVentaFactory.MediosPago);
            });
        }

        ComprobanteVentaFactory.getCondicionPago = function() {
        angular.element(div_loader).removeClass('hide');
            return $http.get('AdsComprobanteVenta/getAllCondicionPago').success(function(data) {
        angular.element(div_loader).addClass('hide');
                angular.copy(data.datos, ComprobanteVentaFactory.CondicionesPago);
            });
        }

        ComprobanteVentaFactory.getTipoNota = function() {
        angular.element(div_loader).removeClass('hide');
            return $http.get('AdsTipoNota/getAllTipoNotas').success(function(data) {
        angular.element(div_loader).addClass('hide');
                angular.copy(data.datos, ComprobanteVentaFactory.TipoNotas);
            });
        }


        ComprobanteVentaFactory.deleteAttempt = function(index) {
            $modal.open( { 
                templateUrl:'templates_angular/deleteAttemp.html', 
                controller: function($scope, $modalInstance, ComprobanteVentaFactory) {
                    $scope.yes = function() {
                        ComprobanteVentaFactory.Detalle_comprobante.splice(index,1);
                        ComprobanteVentaFactory.calcular_total();
                        $modalInstance.close();
                    }
                }
            });
        }  

        ComprobanteVentaFactory.deleteAttempt_detalle_nota = function(index) {
            ComprobanteVentaFactory.Detalle_nota.splice(index,1);
            swal({   
                title: "Eliminado!"
                ,   text: "Se elimino con éxito"
                ,   type: "success"
                ,   confirmButtonText: "OK" 
                ,   timer: 2000
            });
            ComprobanteVentaFactory.calcular_total_nota();
        }  

        ComprobanteVentaFactory.deleteAttempt_letra = function(index) {
            $modal.open( { 
                templateUrl:'templates_angular/deleteAttemp.html', 
                controller: function($scope, $modalInstance, ComprobanteVentaFactory) {
                    $scope.yes = function() {
                        ComprobanteVentaFactory.Detalle_letra.splice(index,1);

                        var cantidad_registros_detalle = ComprobanteVentaFactory.Detalle_letra.length;

                        var total_factura = 0;
                        var aux = 0;
                        if($("#importe_aplicado_nota").length){ //TOTAL + AGENTE RETENEDOR + NOTA
                            if($("#importe_aplicado_nota").val()!=""){
                                total_factura = angular.element(importe_aplicado_nota).val();
                                aux=1;
                            }
                        }
                        if($("#importe_aplicado").length){//TOTAL + AGENTE RETENEDOR
                            if($("#importe_aplicado").val()!=""){
                                if(aux==0){
                                    total_factura = angular.element(importe_aplicado).val();
                                    aux=1;                        
                                }
                            }
                        }
                        if($("#total_nota").length){
                            if($("#total_nota").val()!=""){ //TOTAL + NOTA
                                if(aux==0){
                                    total_factura = angular.element(total_nota).val();
                                    aux=1;                        
                                }
                            }
                        }
                        if($("#total").length){//TOTAL SOLO
                            if($("#total").val()!=""){
                                if(aux==0){
                                    total_factura = angular.element(total).val();
                                    aux=1;                        
                                }
                            }
                        }


                        for (var i = 0; i < ComprobanteVentaFactory.Detalle_letra.length; i++) {
                            ComprobanteVentaFactory.Detalle_letra[i].monto_letra = Math.round((total_factura/cantidad_registros_detalle )* 1000) / 1000;
                        };

                        $modalInstance.close();
                    }
                }
            });
        }  

        ComprobanteVentaFactory.deleteAttempt_letra_gestion_letra = function(index) {
            $modal.open( { 
                templateUrl:'templates_angular/deleteAttemp.html', 
                controller: function($scope, $modalInstance, ComprobanteVentaFactory) {
                    $scope.yes = function() {
                        ComprobanteVentaFactory.Detalle_letra_gestion_letra.splice(index,1);

                        var cantidad_registros_detalle = ComprobanteVentaFactory.Detalle_letra_gestion_letra.length;

                        var acum_total = 0;
                        for (var i = 0; i < ComprobanteVentaFactory.Detalle_factura.length; i++) {
                            acum_total = acum_total + ComprobanteVentaFactory.Detalle_factura[i].total_comprobante - ComprobanteVentaFactory.Detalle_factura[i].monto_retencion;

                            if(ComprobanteVentaFactory.Detalle_factura[i].detalle_nota != null){
                                if(ComprobanteVentaFactory.Detalle_factura[i].detalle_nota.tipo_nota.id==1){
                                    console.log('ENTRO DEBITO');
                                    acum_total = acum_total + ComprobanteVentaFactory.Detalle_factura[i].detalle_nota.precio;
                                }
                                else if(ComprobanteVentaFactory.Detalle_factura[i].detalle_nota.tipo_nota.id==2){
                                    console.log('ENTRO CREDITO');
                                    acum_total = acum_total - ComprobanteVentaFactory.Detalle_factura[i].detalle_nota.precio;
                                }
                            }
                        };


                        for (var i = 0; i < ComprobanteVentaFactory.Detalle_letra_gestion_letra.length; i++) {
                            ComprobanteVentaFactory.Detalle_letra_gestion_letra[i].monto_letra = Math.round((acum_total/cantidad_registros_detalle )* 1000) / 1000;
                        };

                        $modalInstance.close();
                    }
                }
            });
        }  

        ComprobanteVentaFactory.deleteAttempt_detalle_factura = function(index) {
            $modal.open( { 
                templateUrl:'templates_angular/deleteAttemp.html', 
                controller: function($scope, $modalInstance, ComprobanteVentaFactory) {
                    $scope.yes = function() {
                        ComprobanteVentaFactory.Detalle_factura.splice(index,1);
                        $modalInstance.close();
                    }
                }
            });
        }  

        ComprobanteVentaFactory.deleteAttempt_detalle_guia= function(parent, index) {
            $modal.open( { 
                templateUrl:'templates_angular/deleteAttemp.html', 
                controller: function($scope, $modalInstance, ComprobanteVentaFactory) {
                    $scope.yes = function() {
                        ComprobanteVentaFactory.Detalle_comprobante_guia[parent].splice(index,1);
                        $modalInstance.close();
                    }
                }
            });
        }  

        ComprobanteVentaFactory.edit = function(row_detalle_comprobante,index){
            angular.copy(row_detalle_comprobante, ComprobanteVentaFactory.Detalle_venta_edit);
            $modal.open({
                templateUrl: 'templates_angular/ComprobanteCompraController/edit.html',
                controller: function($scope, $modalInstance, Detalle_venta_edit, UnidadesMedida){
                    $scope.Detalle = Detalle_venta_edit;
                    $scope.UnidadesMedida = UnidadesMedida;
                    $scope.update = function(){
                        ComprobanteVentaFactory.update($scope.Detalle,index);
                        $modalInstance.close();
                    }
                },
                resolve: {
                    Detalle_venta_edit : function(){
                        return ComprobanteVentaFactory.Detalle_venta_edit;
                    },
                    UnidadesMedida : function(){
                        return ComprobanteVentaFactory.UnidadesMedida;
                    },
                    UnidadesMedida_seleccionado : function(){
                        return ComprobanteVentaFactory.UnidadesMedida_seleccionado;
                    }
                }
            });
        }

        ComprobanteVentaFactory.update = function(Detalle,index){ 
            ComprobanteVentaFactory.detalles_venta[index].cantidad = Detalle.cantidad;
            ComprobanteVentaFactory.detalles_venta[index].id_unidadMedida = Detalle.UnidadesMedida_seleccionado.id;
            ComprobanteVentaFactory.detalles_venta[index].unidadMedida = Detalle.UnidadesMedida_seleccionado.n_EquivalenciaUnidad;
            ComprobanteVentaFactory.calcular_total();
        }


        ComprobanteVentaFactory.store = function(cabecera, cabecera_guia, detalle, finanzas, nota, nota_detalle) {
        angular.element(div_loader).removeClass('hide');
                 $http.post('AdsComprobanteVenta', {cabecera:cabecera, cabecera_guia:cabecera_guia, detalle:detalle, finanzas:finanzas, nota:nota, nota_detalle:nota_detalle})
                    .success(function(data){
        angular.element(div_loader).addClass('hide');
                        if(data.datos=='correcto'){
                            if(ComprobanteVentaFactory.Cliente_seleccionado.agente_retenedor == 'true')
                            {
                                angular.element(retencion).val('');
                                angular.element(importe_aplicado).val('');                                
                            }

                            // angular.copy({},ComprobanteVentaFactory.detalles_venta);
                            // angular.copy({},ComprobanteVentaFactory.detalle_venta);
                            // angular.copy({},ComprobanteVentaFactory.cabecera_venta);      
                            angular.copy({},ComprobanteVentaFactory.Detalle_comprobante); 
                            angular.copy({},ComprobanteVentaFactory.Detalle_letra);
                            angular.copy({},ComprobanteVentaFactory.CabeceraComprobante_create); 
                            angular.copy({},ComprobanteVentaFactory.CabeceraComprobante_create.moneda); 
                            angular.copy({},ComprobanteVentaFactory.Cliente_seleccionado); 
                            angular.copy({},ComprobanteVentaFactory.Producto_seleccionado_nota); 
                            // angular.copy({},ComprobanteVentaFactory.CabeceraComprobante_create.boolean_cliente_seleccionado);
                            angular.copy({},ComprobanteVentaFactory.Finanzas_create);
                            angular.copy({},ComprobanteVentaFactory.Nota_create);
                            ComprobanteVentaFactory.CabeceraComprobante_create.boolean_asociar = false;
                            // ComprobanteVentaFactory.CabeceraComprobante_create.generar_guia = false;
                            ComprobanteVentaFactory.CabeceraComprobante_create.moneda = {id:2};

                            angular.copy([{n_guia:1}],ComprobanteVentaFactory.numero_guias); 
                            angular.copy([{Motivo_seleccionado:{}}],ComprobanteVentaFactory.CabeceraComprobanteGuia_create); 
                            angular.copy([],ComprobanteVentaFactory.Detalle_comprobante_guia[0]);


                            angular.element(cliente_value).val('');
                            angular.element(ruc).val('');
                            angular.element(direccion).val('');

                            angular.element(subtotal).val('');
                            angular.element(igv).val('');
                            angular.element(total).val('');
                            angular.element(stock).val('');
                            angular.element(unidad_medida).val('');

                            angular.element(label_agente_retenedor).text('');

                            ComprobanteVentaFactory.getProductos();
                            ComprobanteVentaFactory.getPartidaGuia();
                            ComprobanteVentaFactory.getLlegadaGuia();
                            // angular.element(div_loader).addClass('hide');
// asdasdasdasdasdas
                            // $modal.open({
                            //     templateUrl: 'templates_angular/ComprobanteCompraController/msj_exito.html',
                            //     controller: function($scope, $modalInstance){
                            //     }
                            // });
                            swal({   
                                    title: "Registro exitoso!"
                                    ,   text: "El registro se realizó con éxito"
                                    ,   type: "success"
                                    ,   confirmButtonText: "OK" 
                                    ,   timer: 2000
                                });
                            // swal({   title: "Auto close alert!",   text: "I will close in 2 seconds.",   timer: 2000,   showConfirmButton: false });
                            
                        } 
                        else if(data.datos == 'duplicidad'){
                            // alert('¡Existe otra Factura de Venta con estos datos!');
                            sweetAlert("Error...", "¡Existe otra Factura de Venta con estos datos!", "error");
                        }
                        else if(data.datos == 'duplicidad_nota'){
                            // alert('¡Existe otra Nota con estos datos!');
                            sweetAlert("Error...", "¡Existe otra Nota con estos datos!", "error");
                        }
                            angular.element(div_loader).addClass('hide');
                        
                    });
        }
        

        ComprobanteVentaFactory.store_gestion_letra = function(detalle_letras, detalle_facturas) {
        angular.element(div_loader).removeClass('hide');
                 $http.post('AdsDetallePago', {letras:detalle_letras, facturas:detalle_facturas})
                    .success(function(data){
        angular.element(div_loader).addClass('hide');

                            angular.copy({},ComprobanteVentaFactory.Detalle_factura); 
                            angular.copy({},ComprobanteVentaFactory.Detalle_letra_gestion_letra);
                            
                            // angular.element(div_loader).addClass('hide');
// asdasdasdasdasdas
                            // $modal.open({
                            //     templateUrl: 'templates_angular/ComprobanteCompraController/msj_exito.html',
                            //     controller: function($scope, $modalInstance){
                            //     }
                            // });
                    swal({   
                                    title: "Registro exitoso!"
                                    ,   text: "El registro se realizó con éxito"
                                    ,   type: "success"
                                    ,   confirmButtonText: "OK" 
                                    ,   timer: 2000
                                });

                        
                    });
        }
        

        ComprobanteVentaFactory.store_gestion_nota = function(nota,nota_detalle, detalle_facturas) {
        angular.element(div_loader).removeClass('hide');
                $http.post('AdsDetalleNota/store_gestion_nota', {notas: nota,nota_detalles: nota_detalle, facturas: detalle_facturas})
                    .success(function(data){
        angular.element(div_loader).addClass('hide');
                        if(data.datos == 'correcto'){
                            
                            angular.copy([],ComprobanteVentaFactory.Detalle_factura_nota);
                            angular.copy([{n_nota:1}],ComprobanteVentaFactory.numero_notas); 
                            angular.copy([],ComprobanteVentaFactory.Detalle_nota_gestion_nota[0]);
                            angular.copy([{}],ComprobanteVentaFactory.Gestion_nota);
                            angular.copy([],ComprobanteVentaFactory.Producto_seleccionado_gestion_nota);

                            // $modal.open({
                            //     templateUrl: 'templates_angular/ComprobanteCompraController/msj_exito.html',
                            //     controller: function($scope, $modalInstance){
                            //     }
                            // });
                    swal({   
                                    title: "Registro exitoso!"
                                    ,   text: "El registro se realizó con éxito"
                                    ,   type: "success"
                                    ,   confirmButtonText: "OK" 
                                    ,   timer: 2000
                                });
                            
                        }

                    });

        }
        

        ComprobanteVentaFactory.buscarProducto = function(){
            $modal.open({
                templateUrl: 'templates_angular/ProductoController/seleccion_producto.html',
                controller: function($scope, $modalInstance, Producto_create, Productos){
                    $scope.producto_create = Producto_create;
                    $scope.productos = Productos;

                    $scope.seleccionar = function(data){

                        // if(ComprobanteVentaFactory.CabeceraComprobante_create.moneda.id == 1){

                        //     angular.element(precio_producto).removeClass('validate[required,min['+ComprobanteVentaFactory.Producto_seleccionado.precio_unitario+']]');
                        //     angular.element(precio_producto).addClass('validate[required]');

                        // }
                        // else if(ComprobanteVentaFactory.CabeceraComprobante_create.moneda.id == 2){

                        //     angular.element(precio_producto).removeClass('validate[required,min['+ComprobanteVentaFactory.Producto_seleccionado.precio_unitario/ComprobanteVentaFactory.TipoCambio_today.tipo_cambio+']]');
                        //     angular.element(precio_producto).addClass('validate[required]');
                            
                        // }


                        if(data.precio_unitario == null) data.precio_unitario = 0;

                        if(ComprobanteVentaFactory.CabeceraComprobante_create.moneda.id == 1){
                            angular.element(label_precio).text('Precio Mínimo: S/.'+formatNumber(data.precio_unitario, ''));
                        
                            angular.element(precio_producto).removeClass('validate[required]');
                            angular.element(precio_producto).addClass('validate[required,min['+formatNumber(data.precio_unitario, '')+']]');
                            
                        }
                        else if(ComprobanteVentaFactory.CabeceraComprobante_create.moneda.id == 2){

                            angular.element(label_precio).text('Precio Mínimo: $.'+formatNumber(data.precio_unitario/ComprobanteVentaFactory.TipoCambio_today.tipo_cambio, ''));
                            
                            angular.element(precio_producto).removeClass('validate[required]');
                            angular.element(precio_producto).addClass('validate[required,min['+formatNumber(data.precio_unitario/ComprobanteVentaFactory.TipoCambio_today.tipo_cambio, '')+']]');
                            

                        }

                        angular.copy(data, ComprobanteVentaFactory.Producto_seleccionado);
                        angular.element(nom_producto_value).val(ComprobanteVentaFactory.Producto_seleccionado.nombre_producto);

                        angular.element(stock).val(ComprobanteVentaFactory.Producto_seleccionado.stock);
                        angular.element(unidad_medida).val(ComprobanteVentaFactory.Producto_seleccionado.unidad_medida.nombre_unidad_medida);

                        $modalInstance.close();
                    }
                },
                resolve: {
                    Producto_create : function(){
                        return ComprobanteVentaFactory.Producto_create;
                    },
                    Productos : function(){
                        return ComprobanteVentaFactory.Productos;
                    }
                }
            });
        }

        
        ComprobanteVentaFactory.buscarProducto_guia = function(index){
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
                        angular.copy(data, ComprobanteVentaFactory.Producto_seleccionado_guia[index]);
                        $("#nom_producto_"+index+"_value").val(ComprobanteVentaFactory.Producto_seleccionado_guia[index].nombre_producto);
                        $("#unidad_medida_"+index+"_value").val(ComprobanteVentaFactory.Producto_seleccionado_guia[index].unidad_medida.nombre_unidad_medida);
                        $modalInstance.close();
                    }
                },
                resolve: {
                    Producto_create : function(){
                        return ComprobanteVentaFactory.Producto_create;
                    },
                    Productos : function(){
                        return ComprobanteVentaFactory.Productos;
                    }
                }
            });
        }

        
        ComprobanteVentaFactory.buscarProducto_gestion_nota = function(index){
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
                        angular.copy(data, ComprobanteVentaFactory.Producto_seleccionado_gestion_nota[index]);
                        $("#nom_producto_gestion_nota_"+index+"_value").val(ComprobanteVentaFactory.Producto_seleccionado_gestion_nota[index].nombre_producto);
                        $modalInstance.close();
                    }
                },
                resolve: {
                    Producto_create : function(){
                        return ComprobanteVentaFactory.Producto_create;
                    },
                    Productos : function(){
                        return ComprobanteVentaFactory.Productos;
                    }
                }
            });
        }


        ComprobanteVentaFactory.buscarCliente = function(){
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

                        angular.copy(data, ComprobanteVentaFactory.Cliente_seleccionado);

                        ComprobanteVentaFactory.Cliente_seleccionado.id_cliente_seleccionado = id_cliente_seleccionado;
                        ComprobanteVentaFactory.Cliente_seleccionado.id_direccion_seleccionada = id_direccion_seleccionada;
                        ComprobanteVentaFactory.Cliente_seleccionado.direccion_seleccionada = direccion_seleccionada;

                        $modalInstance.close();
                    }
                },
                resolve: {
                    Cliente_create : function(){
                        return ComprobanteVentaFactory.Cliente_create;
                    },
                    Cliente : function(){
                        return ComprobanteVentaFactory.Clientes;
                    }
                }
            });
        }


        ComprobanteVentaFactory.nuevoCliente = function(){
            $modal.open({
                templateUrl: 'templates_angular/ClienteController/create.html',
                controller: function($scope, $modalInstance, $filter){
                    /* El objeto creado del scope se utiliza en la vista */
                    $scope.cliente = {};
                    $scope.store = function(){
                        if ( $("#create_form").validationEngine('validate') ) {
                            ComprobanteVentaFactory.storeCliente($scope.cliente); /* Objeto de la vista */
                            $modalInstance.close();
                        };
                    }
                },
                resolve: {
                    
                }
            });
        }


        ComprobanteVentaFactory.nuevoProducto = function(){
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

                    $scope.store = function(){
                        if ( $("#create_form").validationEngine('validate') ) {
                            ComprobanteVentaFactory.storeProducto($scope.producto); /* Objeto de la vista */
                            $modalInstance.close();
                        };
                    }
                },
                resolve: {
                    UnidadMedida : function(){
                        return ComprobanteVentaFactory.UnidadMedida;
                    },
                    Composicion : function(){
                        return ComprobanteVentaFactory.Composicion;
                    },
                    Titulo : function(){
                        return ComprobanteVentaFactory.Titulo;
                    },
                    Hilatura : function(){
                        return ComprobanteVentaFactory.Hilatura;
                    },
                    TipoProducto : function(){
                        return ComprobanteVentaFactory.TipoProducto;
                    },
                    TipoTela : function(){
                        return ComprobanteVentaFactory.TipoTela;
                    },
                    Color : function(){
                        return ComprobanteVentaFactory.Color;
                    }
                }
            });
        }

        ComprobanteVentaFactory.storeCliente = function(Cliente) {
        angular.element(div_loader).removeClass('hide');
            $http.post('PtvCliente', Cliente).success(function(data){
        angular.element(div_loader).addClass('hide');
                ComprobanteVentaFactory.getClientes();
            });
        }

        ComprobanteVentaFactory.storeProducto = function(Producto) {
 
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
                    angular.copy(data.datos,ComprobanteVentaFactory.Productos);
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


        ComprobanteVentaFactory.agregar_detalle = function(detalle_comprobante){

            console.log('detalle_comprobante');
            console.log(detalle_comprobante);
            var entro = 0;
            var posicion_entro = 0;
            var cantidad_push = 0;
            for (var i = 0; i < ComprobanteVentaFactory.Detalle_comprobante.length; i++) {
                if(ComprobanteVentaFactory.Detalle_comprobante[i].id_producto == ComprobanteVentaFactory.Producto_seleccionado.id){
                    cantidad_push = parseFloat(ComprobanteVentaFactory.Detalle_comprobante[i].cantidad) + parseFloat(detalle_comprobante.cantidad);
                    entro = 1;
                    posicion_entro = i;
                }
                
            };

            if(entro == 1){
                ComprobanteVentaFactory.Detalle_comprobante[posicion_entro].cantidad = cantidad_push;
                ComprobanteVentaFactory.Detalle_comprobante[posicion_entro].precio = detalle_comprobante.precio;
            }
            else{
                    console.log('ENTROOOO');
                    console.log(detalle_comprobante.precio);

                ComprobanteVentaFactory.Detalle_comprobante.push({
                                                                id_producto : ComprobanteVentaFactory.Producto_seleccionado.id
                                                                , producto : ComprobanteVentaFactory.Producto_seleccionado.nombre_producto
                                                                , cantidad : detalle_comprobante.cantidad
                                                                , precio : detalle_comprobante.precio
                                                            });
            console.log(ComprobanteVentaFactory.Detalle_comprobante);
            }


            // ComprobanteVentaFactory.calcular_total();



            if(ComprobanteVentaFactory.CabeceraComprobante_create.moneda.id == 1){

                angular.element(precio_producto).removeClass('validate[required,min['+formatNumber(ComprobanteVentaFactory.Producto_seleccionado.precio_unitario,'')+']]');
                angular.element(precio_producto).addClass('validate[required]');

            }
            else if(ComprobanteVentaFactory.CabeceraComprobante_create.moneda.id == 2){

                angular.element(precio_producto).removeClass('validate[required,min['+formatNumber(ComprobanteVentaFactory.Producto_seleccionado.precio_unitario/ComprobanteVentaFactory.TipoCambio_today.tipo_cambio,'')+']]');
                angular.element(precio_producto).addClass('validate[required]');
                
            }
            // ComprobanteVentaFactory.Detalle_comprobante.push({id_producto : ComprobanteVentaFactory.Producto_seleccionado.id, producto : ComprobanteVentaFactory.Producto_seleccionado.nombre_producto, cantidad : detalle_comprobante.cantidad, precio : detalle_comprobante.precio});
            
            angular.element(label_precio).text('');
            angular.element(stock).val('');
            angular.element(unidad_medida).val('');

            ComprobanteVentaFactory.calcular_total();

        }

        ComprobanteVentaFactory.agregar_detalle_nota = function(detalle_comprobante){

            console.log('detalle_comprobante');
            console.log(detalle_comprobante);
            if(detalle_comprobante.tipo_nota.id == 1){ //DEBITO
                ComprobanteVentaFactory.Detalle_nota.push({
                    producto : detalle_comprobante.descripcion_nota
                    , cantidad : 1
                    , precio_nota : detalle_comprobante.precio_nota
                });
                ComprobanteVentaFactory.Nota_create.descripcion_nota = '';

            } 
            else if(detalle_comprobante.tipo_nota.id == 2){ //CREDITO
                var entro = 0;
                var posicion_entro = 0;
                var cantidad_push = 0;
                for (var i = 0; i < ComprobanteVentaFactory.Detalle_nota.length; i++) {
                    if(ComprobanteVentaFactory.Detalle_nota[i].id_producto == ComprobanteVentaFactory.Producto_seleccionado_nota.id){
                        cantidad_push = parseFloat(ComprobanteVentaFactory.Detalle_nota[i].cantidad) + parseFloat(detalle_comprobante.cantidad);
                        entro = 1;
                        posicion_entro = i;
                    }
                    
                };

                if(entro == 1){
                    ComprobanteVentaFactory.Detalle_nota[posicion_entro].cantidad = cantidad_push;
                    ComprobanteVentaFactory.Detalle_nota[posicion_entro].precio_nota = detalle_comprobante.precio_nota;
                }
                else{
                    ComprobanteVentaFactory.Detalle_nota.push({
                                                                    id_producto : ComprobanteVentaFactory.Producto_seleccionado_nota.id
                                                                    , producto : ComprobanteVentaFactory.Producto_seleccionado_nota.nombre_producto
                                                                    , cantidad : detalle_comprobante.cantidad
                                                                    , precio_nota : detalle_comprobante.precio_nota
                                                                    , merma : detalle_comprobante.merma
                                                                });
                }
                angular.element(nom_producto_nota_value).val('');
                ComprobanteVentaFactory.Nota_create.cantidad = '';
                ComprobanteVentaFactory.Nota_create.merma = '';
            }

            
            ComprobanteVentaFactory.Nota_create.precio_nota = '';

            ComprobanteVentaFactory.calcular_total_nota();
        }


        ComprobanteVentaFactory.agregar_detalle_nota_gestion_nota = function(detalle_comprobante, index){

            console.log('detalle_comprobante');
            console.log(detalle_comprobante);
            if(detalle_comprobante.tipo_nota.id == 1){ //DEBITO
                ComprobanteVentaFactory.Detalle_nota_gestion_nota[index].push({
                    producto : detalle_comprobante.descripcion_nota
                    , cantidad : 1
                    , precio_nota : detalle_comprobante.precio_nota
                });
                ComprobanteVentaFactory.Gestion_nota[index].descripcion_nota = '';

            } 
            else if(detalle_comprobante.tipo_nota.id == 2){ //CREDITO
                var entro = 0;
                var posicion_entro = 0;
                var cantidad_push = 0;
                for (var i = 0; i < ComprobanteVentaFactory.Detalle_nota_gestion_nota[index].length; i++) {
                    if(ComprobanteVentaFactory.Detalle_nota_gestion_nota[index][i].id_producto == ComprobanteVentaFactory.Producto_seleccionado_gestion_nota[index].id){
                        cantidad_push = parseFloat(ComprobanteVentaFactory.Detalle_nota_gestion_nota[index][i].cantidad) + parseFloat(detalle_comprobante.cantidad);
                        entro = 1;
                        posicion_entro = i;
                    }
                    
                };

                if(entro == 1){
                    ComprobanteVentaFactory.Detalle_nota_gestion_nota[index][posicion_entro].cantidad = cantidad_push;
                    ComprobanteVentaFactory.Detalle_nota_gestion_nota[index][posicion_entro].precio_nota = detalle_comprobante.precio_nota;
                }
                else{
                    ComprobanteVentaFactory.Detalle_nota_gestion_nota[index].push({
                                                                    id_producto : ComprobanteVentaFactory.Producto_seleccionado_gestion_nota[index].id
                                                                    , producto : ComprobanteVentaFactory.Producto_seleccionado_gestion_nota[index].nombre_producto
                                                                    , cantidad : detalle_comprobante.cantidad
                                                                    , precio_nota : detalle_comprobante.precio_nota
                                                                    , merma : detalle_comprobante.merma
                                                                });
                }
                $('#nom_producto_gestion_nota_'+index+'_value').val('');
                ComprobanteVentaFactory.Gestion_nota[index].cantidad = '';
                ComprobanteVentaFactory.Gestion_nota[index].merma = '';
            }

            
            ComprobanteVentaFactory.Gestion_nota[index].precio_nota = '';

            ComprobanteVentaFactory.calcular_total_nota_gestion_nota(index);
        }


        ComprobanteVentaFactory.agregar_detalle_guia = function(detalle_comprobante_guia, index){

            console.log('detalle_comprobante_guia');
            console.log(detalle_comprobante_guia);
            var entro = 0;
            var posicion_entro = 0;
            var cantidad_push = 0;
            for (var i = 0; i < ComprobanteVentaFactory.Detalle_comprobante_guia[index].length; i++) {
                if(ComprobanteVentaFactory.Detalle_comprobante_guia[index][i].id_producto == ComprobanteVentaFactory.Producto_seleccionado_guia[index].id){
                    cantidad_push = parseFloat(ComprobanteVentaFactory.Detalle_comprobante_guia[index][i].cantidad) + parseFloat(detalle_comprobante_guia.cantidad);
                    entro = 1;
                    posicion_entro = i;
                }
                
            };

            if(entro == 1){
                ComprobanteVentaFactory.Detalle_comprobante_guia[index][posicion_entro].cantidad = cantidad_push;
                // ComprobanteVentaFactory.Detalle_comprobante_guia[index][posicion_entro].precio = detalle_comprobante_guia.precio;
            }
            else{
                    console.log('ENTROOOO 2');
                    // console.log(detalle_comprobante_guia.precio);

                ComprobanteVentaFactory.Detalle_comprobante_guia[index].push({
                                                                id_producto : ComprobanteVentaFactory.Producto_seleccionado_guia[index].id
                                                                , producto : ComprobanteVentaFactory.Producto_seleccionado_guia[index].nombre_producto
                                                                , cantidad : detalle_comprobante_guia.cantidad
                                                                , unidad_medida : ComprobanteVentaFactory.Producto_seleccionado_guia[index].unidad_medida.nombre_unidad_medida
                                                                // , precio : detalle_comprobante_guia.precio
                                                            });
            console.log(ComprobanteVentaFactory.Detalle_comprobante_guia[index]);
            }


            // ComprobanteVentaFactory.calcular_total();


            // ComprobanteVentaFactory.Detalle_comprobante_guia[index].push({id_producto : ComprobanteVentaFactory.Producto_seleccionado.id, producto : ComprobanteVentaFactory.Producto_seleccionado.nombre_producto, cantidad : detalle_comprobante.cantidad, precio : detalle_comprobante.precio});
            
            // angular.element(label_precio).text('');
            // angular.element(stock).val('');
            // angular.element(unidad_medida).val('');

            // ComprobanteVentaFactory.calcular_total();

        }

        ComprobanteVentaFactory.pasar_factura = function(){
                            console.log('PASAR_FACTURA');

        angular.element(div_loader).removeClass('hide');
            console.log('ComprobanteVentaFactory.Detalle_comprobante_guia');
            console.log(ComprobanteVentaFactory.Detalle_comprobante_guia);
            var entro = 0;
            var posicion_entro = 0;
            var posicion_index = 0;
            var cantidad_push = 0;
            for (var index = 0; index < ComprobanteVentaFactory.Detalle_comprobante_guia.length; index++) { // RECORRO LAS GUIAS CREADAS

                for (var j = 0; j < ComprobanteVentaFactory.Detalle_comprobante_guia[index].length; j++) { // RECORRO EL DETALLE DE LA GUIA

                    for (var i = 0; i < ComprobanteVentaFactory.Detalle_comprobante.length; i++) { // RECORRO EL DETALLE DE LA FACTURA
                        if(ComprobanteVentaFactory.Detalle_comprobante_guia[index][j].id_producto == ComprobanteVentaFactory.Detalle_comprobante[i].id_producto){
                            cantidad_push = parseFloat(ComprobanteVentaFactory.Detalle_comprobante_guia[index][j].peso) + parseFloat(ComprobanteVentaFactory.Detalle_comprobante[i].cantidad);
                            entro = 1;
                            posicion_entro = i;
                            posicion_index = index;

                        }
                    };

                    if(entro == 1){

                        // ComprobanteVentaFactory.Detalle_comprobante_guia[posicion_index][posicion_entro].cantidad = cantidad_push;
                        ComprobanteVentaFactory.Detalle_comprobante[posicion_entro].cantidad = cantidad_push;
                        entro = 0;
                        // ComprobanteVentaFactory.Detalle_comprobante_guia[index][posicion_entro].precio = detalle_comprobante_guia.precio;
                    }
                    else{

                        ComprobanteVentaFactory.Detalle_comprobante.push({
                                                                        id_producto : ComprobanteVentaFactory.Detalle_comprobante_guia[index][j].id_producto
                                                                        , producto : ComprobanteVentaFactory.Detalle_comprobante_guia[index][j].producto
                                                                        , cantidad : ComprobanteVentaFactory.Detalle_comprobante_guia[index][j].peso
                                                                        , unidad_medida : ComprobanteVentaFactory.Detalle_comprobante_guia[index][j].unidad_medida
                                                                        , precio : 0
                                                                    });
                    }

                        
                    
                };

                



            };

            $("#box_tab_1").addClass('active');
            $("#li_box_tab_1").addClass('active');
            $("#box_tab_2").removeClass('active');
            $("#li_box_tab_2").removeClass('active');
            $("#box_tab_3").removeClass('active');
            $("#li_box_tab_3").removeClass('active');
            $("#box_tab_4").removeClass('active');
            $("#li_box_tab_4").removeClass('active');


            // $("#tab_1").addClass('hide');
            // $("#li_tab_1").addClass('hide');
            // $("#tab_1").removeClass('hide');
            // $("#li_tab_1").removeClass('hide');
            $("#tab_1").focus();
            $("#nom_producto_value").focus();
        angular.element(div_loader).addClass('hide');

        }

        ComprobanteVentaFactory.agregar_detalle_letra = function(detalle_letra,fecha_comprobante){

        }


        ComprobanteVentaFactory.agregar_detalle_factura = function(factura){

        angular.element(div_loader).removeClass('hide');

            $http.post('AdsComprobanteVenta/getFacturaBySerieNumero', {guia:factura}).success(function(data){
        angular.element(div_loader).addClass('hide');
                console.log('data.datos');
                console.log(data.datos);
                if(data.datos == ''){
                    // alert('Esta Factura no existe.');
                    sweetAlert("Error...", "Esta Factura no existe.", "error");
                }
                else{

                    if(data.datos[0].detalle_pago.length > 0){ // ESTA FACTURA YA TIENE LETRAS DE CAMBIO
                        sweetAlert("Error...", "Esta Factura ya tiene letra(s) de cambio.", "error");
                    }
                    else{
                        ComprobanteVentaFactory.Detalle_factura.push(data.datos[0]);
                        angular.copy({},ComprobanteVentaFactory.Gestion_letra);
                    }
                    
                    

                }

                
            });

        }


        ComprobanteVentaFactory.agregar_detalle_factura_nota = function(factura){

        angular.element(div_loader).removeClass('hide');

            $http.post('AdsComprobanteVenta/getFacturaBySerieNumero', {guia:factura}).success(function(data){
        angular.element(div_loader).addClass('hide');
                // console.log('data.datos');
                // console.log(data.datos);
                if(data.datos == ''){
                    // alert('Esta Factura no existe.');
                    sweetAlert("Error...", "Esta Factura no existe.", "error");
                }
                else{
                    
                    ComprobanteVentaFactory.Detalle_factura_nota.push(data.datos[0]);
                    console.log('entro');
                    console.log(data.datos[0]);
                    angular.copy({},ComprobanteVentaFactory.Gestion_letra);

                }

                
            });

        }

        // ComprobanteVentaFactory.agregar_detalle_letra_gestion_letra = function

        // }

        ComprobanteVentaFactory.calcular_importe_nota = function(){

            if(ComprobanteVentaFactory.calcular_total()){
                var total_comprobante = angular.element(total).val();
                var total_importe_aplicado = 0;
                var igv = <?php echo (DB::table('ts_igv')->where('estado', 'true')->pluck('valor_igv')); ?>;
                var var_total_nota = 0;
                var var_importe_aplicado = 0;
                var var_retencion_nota = 0;
                if(ComprobanteVentaFactory.Nota_create.tipo_nota.id == 1){
                    var_total_nota = parseFloat(total_comprobante) + parseFloat(angular.element(nota_total).val());
                }
                else if(ComprobanteVentaFactory.Nota_create.tipo_nota.id == 2){
                    var_total_nota = parseFloat(total_comprobante) - parseFloat(angular.element(nota_total).val());
                }
                // if(ComprobanteVentaFactory.Nota_create.tipo_nota.id == 1){
                //     var_total_nota = parseFloat(total_comprobante) + parseFloat(ComprobanteVentaFactory.Nota_create.precio_nota);
                // }
                // else if(ComprobanteVentaFactory.Nota_create.tipo_nota.id == 2){
                //     var_total_nota = parseFloat(total_comprobante) - parseFloat(ComprobanteVentaFactory.Nota_create.precio_nota);
                // }
                if(var_total_nota>=700 && ComprobanteVentaFactory.Cliente_seleccionado.agente_retenedor == 'true'){
                    var_retencion_nota = parseFloat(var_total_nota)*0.03;
                }
                var_importe_aplicado = parseFloat(var_total_nota) - parseFloat(var_retencion_nota);
                angular.element(total_nota).val(var_total_nota);
                angular.element(retencion_nota).val(var_retencion_nota);
                angular.element(importe_aplicado_nota).val(var_importe_aplicado);
            }
        }
        
        ComprobanteVentaFactory.calcular_total = function(){

            var valor_igv = <?php echo DB::table('ts_igv')->where('estado', 'true')->pluck('valor_igv'); ?>;
            var valor_dividir = valor_igv+1;

            var acum_subtotal=0;
            var var_total=0;

            var acum_total=0;

            if(ComprobanteVentaFactory.CabeceraComprobante_create.boolean_asociar == true){ //CUANDO SE ASOCIA CON UNA GUIA

                for (x=0;x<ComprobanteVentaFactory.Detalle_comprobante.length;x++){
                    

                    var cantidad = ComprobanteVentaFactory.Detalle_comprobante[x].unidades;
                    var precio = ComprobanteVentaFactory.Detalle_comprobante[x].precio;

                    // acum_subtotal = acum_subtotal + (cantidad*precio);
                    acum_total = acum_total + (cantidad*precio);
                    
                    // REDONDEANDO A 2 DECIMAS
                    // acum_subtotal = Math.round(acum_subtotal * 100) / 100;
                    acum_total = Math.round(acum_total * 100) / 100;
                }
            }
            else{ // CUANDO ES EL FUNCIONAMIENTO NORMAL

                for (x=0;x<ComprobanteVentaFactory.Detalle_comprobante.length;x++){

                    var cantidad = ComprobanteVentaFactory.Detalle_comprobante[x].cantidad;
                    var precio = ComprobanteVentaFactory.Detalle_comprobante[x].precio;

                    // acum_subtotal = acum_subtotal + (cantidad*precio);
                    acum_total = acum_total + (cantidad*precio);
                    
                    // REDONDEANDO A 2 DECIMAS
                    // acum_subtotal = Math.round(acum_subtotal * 100) / 100;
                    acum_total = Math.round(acum_total * 100) / 100;
                }
            }

                var var_igv = acum_subtotal * valor_igv;
                // REDONDEANDO A 2 DECIMAS
                var_igv = Math.round(var_igv * 100) / 100;
                var var_total = acum_subtotal + var_igv;
                // REDONDEANDO A 2 DECIMAS
                var_total = Math.round(var_total * 100) / 100;


                var_total = acum_total;
                var_total = Math.round(var_total * 100) / 100;
                acum_subtotal = var_total/valor_dividir;
                acum_subtotal = Math.round(acum_subtotal * 100) / 100;
                var_igv = var_total - acum_subtotal;
                var_igv = Math.round(var_igv * 100) / 100;


            // var sub_total = acum_total /valor_dividir;
            // // REDONDEANDO A 2 DECIMAS
            // sub_total = Math.round(sub_total * 100) / 100;

            // var var_igv = sub_total * valor_igv;
            // // REDONDEANDO A 2 DECIMAS
            // var_igv = Math.round(var_igv * 100) / 100;

            // CALCULO PARA AGENTE RETENEDOR
            var valor_retencion = 0;
            var valor_importe_aplicado = 0;
            if(ComprobanteVentaFactory.Cliente_seleccionado.agente_retenedor == 'true')
            {
                valor_retencion = var_total*0.03;
                // REDONDEANDO A 2 DECIMAS
                valor_retencion = Math.round(valor_retencion * 100) / 100;

                valor_importe_aplicado = var_total - valor_retencion;

                if(var_total >= 700){
                    angular.element(retencion).val(valor_retencion);
                    angular.element(importe_aplicado).val(valor_importe_aplicado);
                }
                else {
                    angular.element(retencion).val(0);
                    angular.element(importe_aplicado).val(0);
                }
            }

                angular.element(subtotal).val(acum_subtotal);
                angular.element(igv).val(var_igv);
                angular.element(total).val(var_total);

            return true;
            // angular.element(subtotal).val(sub_total);
            // angular.element(igv).val(var_igv);
            // angular.element(total).val(acum_total);
        }

        ComprobanteVentaFactory.calcular_total_nota = function(){

            var valor_igv = <?php echo DB::table('ts_igv')->where('estado', 'true')->pluck('valor_igv'); ?>;
            var valor_dividir = valor_igv+1;

            var acum_subtotal=0;
            var var_total=0;

            var acum_total=0;

            for (x=0;x<ComprobanteVentaFactory.Detalle_nota.length;x++){

                var cantidad = ComprobanteVentaFactory.Detalle_nota[x].cantidad;
                var precio_nota = ComprobanteVentaFactory.Detalle_nota[x].precio_nota;

                acum_total = acum_total + (cantidad*precio_nota);
                
                // REDONDEANDO A 2 DECIMAS
                acum_total = Math.round(acum_total * 100) / 100;
            }

            var var_igv = acum_subtotal * valor_igv;
            // REDONDEANDO A 2 DECIMAS
            var_igv = Math.round(var_igv * 100) / 100;
            var var_total = acum_subtotal + var_igv;
            // REDONDEANDO A 2 DECIMAS
            var_total = Math.round(var_total * 100) / 100;


            var_total = acum_total;
            var_total = Math.round(var_total * 100) / 100;
            acum_subtotal = var_total/valor_dividir;
            acum_subtotal = Math.round(acum_subtotal * 100) / 100;
            var_igv = var_total - acum_subtotal;
            var_igv = Math.round(var_igv * 100) / 100;

            // CALCULO PARA AGENTE RETENEDOR
            var valor_retencion = 0;
            var valor_importe_aplicado = 0;

            angular.element(nota_subtotal).val(acum_subtotal);
            angular.element(nota_igv).val(var_igv);
            angular.element(nota_total).val(var_total);

            ComprobanteVentaFactory.calcular_importe_nota();
        }

        ComprobanteVentaFactory.calcular_total_nota_gestion_nota = function(index){

            var valor_igv = <?php echo DB::table('ts_igv')->where('estado', 'true')->pluck('valor_igv'); ?>;
            var valor_dividir = valor_igv+1;

            var acum_subtotal=0;
            var var_total=0;

            var acum_total=0;

            for (x=0;x<ComprobanteVentaFactory.Detalle_nota_gestion_nota[index].length;x++){

                var cantidad = ComprobanteVentaFactory.Detalle_nota_gestion_nota[index][x].cantidad;
                var precio_nota = ComprobanteVentaFactory.Detalle_nota_gestion_nota[index][x].precio_nota;

                acum_total = acum_total + (cantidad*precio_nota);
                
                // REDONDEANDO A 2 DECIMAS
                acum_total = Math.round(acum_total * 100) / 100;
            }

            var var_igv = acum_subtotal * valor_igv;
            // REDONDEANDO A 2 DECIMAS
            var_igv = Math.round(var_igv * 100) / 100;
            var var_total = acum_subtotal + var_igv;
            // REDONDEANDO A 2 DECIMAS
            var_total = Math.round(var_total * 100) / 100;


            var_total = acum_total;
            var_total = Math.round(var_total * 100) / 100;
            acum_subtotal = var_total/valor_dividir;
            acum_subtotal = Math.round(acum_subtotal * 100) / 100;
            var_igv = var_total - acum_subtotal;
            var_igv = Math.round(var_igv * 100) / 100;

            // CALCULO PARA AGENTE RETENEDOR
            var valor_retencion = 0;
            var valor_importe_aplicado = 0;

            $('#gestion_nota_'+index+'_subtotal').val(acum_subtotal);
            $('#gestion_nota_'+index+'_igv').val(var_igv);
            $('#gestion_nota_'+index+'_total').val(var_total);

            // ComprobanteVentaFactory.calcular_importe_nota();
        }








        // ***************  GUIA DE REMISION **************
        // ***************  GUIA DE REMISION **************
        // ***************  GUIA DE REMISION **************
        // ***************  GUIA DE REMISION **************
        // ***************  GUIA DE REMISION **************
        // ***************  GUIA DE REMISION **************
        // ***************  GUIA DE REMISION **************
        // ***************  GUIA DE REMISION **************
        // ***************  GUIA DE REMISION **************
        // ***************  GUIA DE REMISION **************
        // ***************  GUIA DE REMISION **************


        ComprobanteVentaFactory.Empresas = [];
        ComprobanteVentaFactory.Motivos = []; 
        ComprobanteVentaFactory.MotivosNota = []; 
        ComprobanteVentaFactory.Unidades = [];
        ComprobanteVentaFactory.Personales = []; 
        // ComprobanteVentaFactory.CabeceraComprobante_create.Motivo_seleccionado = {};



        ComprobanteVentaFactory.getEmpresas = function() {
                angular.element(div_loader).removeClass('hide');
            return $http.get('AdsTransporte/getAllTransportes').success(function(data) {
                angular.copy(data.datos, ComprobanteVentaFactory.Empresas);
                angular.element(div_loader).addClass('hide');
            });
        } 


        ComprobanteVentaFactory.getUnidades = function(id_empresa) {
                angular.element(div_loader).removeClass('hide');
            return $http.get('AdsUnidadTransporte/getAllUnidadTransportesByEmpresa/'+id_empresa).success(function(data) {
                console.log(data.datos);
                angular.copy(data.datos, ComprobanteVentaFactory.Unidades);
                angular.element(div_loader).addClass('hide');
            });
        } 

        ComprobanteVentaFactory.getPersonales = function(id_empresa) {
                angular.element(div_loader).removeClass('hide');
            return $http.get('AdsPersonalTransporte/getAllPersonalTransportesByEmpresa/'+id_empresa).success(function(data) {
                angular.copy(data.datos, ComprobanteVentaFactory.Personales);
                angular.element(div_loader).addClass('hide');
            });
        } 


        ComprobanteVentaFactory.getMotivos = function() {
                angular.element(div_loader).removeClass('hide');
            return $http.get('AdsMotivoTraslado/getAllMotivoTraslado').success(function(data) {
                angular.copy(data.datos, ComprobanteVentaFactory.Motivos);
                angular.element(div_loader).addClass('hide');
            });
        } 

        ComprobanteVentaFactory.getAllMotivoNota = function() {
                angular.element(div_loader).removeClass('hide');
            return $http.get('AdsMotivoNota/getAllMotivoNota').success(function(data) {
                angular.copy(data.datos, ComprobanteVentaFactory.MotivosNota);
                angular.element(div_loader).addClass('hide');
            });
        } 

        return ComprobanteVentaFactory;
 
    });

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
