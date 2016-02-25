@extends('templates.layout')

@section('title')
Registro de Compras
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
    <h1><small></small></h1>
    <ol class="breadcrumb">
        <li><a href="{{asset('/')}}"><i class="fa fa-home"></i> Principal</a></li>
        <li><a href="{{asset('/')}}"><i class="fa fa-fw fa-shopping-cart"></i> Módulo de Compras</a></li>
        <li class="active"><i class="fa fa-fw fa-building-o"></i> Facturas de Compra</li>
    </ol>
@endsection

@section('content')
<div ng-app="myApp" ng-controller="AdsComprobanteCompra as ComprobanteCtrl" class="container-fluid">

    <div class="row">
        <div class="col-xs-12">
            <div id="box-comprobante" class="box box-solid box-primary">
                <div class="box-header"> 
                    <i class="fa fa-file-o"></i>
                    <h3 class="box-title">Factura de Compra</h3>

                    <div id="opciones-box" class="navbar-custom-menu pull-right">
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
                    <!--
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h2>Factura de Compra</h2>
                        </div>
                    </div>
                    -->
<div class="row">
    <div class="col-md-12">
        <!-- Custom Tabs -->
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li id="li_box_tab_1" class="active"><a href="#box_tab_1" data-toggle="tab">FACTURA DE COMPRA</a></li>
              <li id="li_box_tab_2"><a href="#box_tab_2" data-toggle="tab">GUIA DE REMISION</a></li>
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
                                <input type="checkbox" id="incluido_igv" ng-model="ComprobanteCtrl.cabecera.incluido_igv" ng-change="ComprobanteCtrl.moneda_or_incluido_igv_change()">
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
                                                <input type="hidden" id="id_producto" ng-model="ComprobanteCtrl.detalle_comprobante.id_producto" class="form-control validate[required,custom[integer]]" placeholder="Cantidad">
                                                <input type="text" id="cantidad_producto" ng-model="ComprobanteCtrl.detalle_comprobante.cantidad" class="form-control validate[required,custom[number]]" placeholder="Cantidad">
                                            </div>
                                        </div>
                                        <div class="row form-group">
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
                                    
                                    <hr ng-hide="ComprobanteCtrl.cabecera.boolean_asociar">
                                    <div class="form-group row">
                                        <div  class="col-md-12">       
                                                        <!-- ESTA TABLA ES PARA EL FUNCIONAMIENTO NORMAL -->
                                            <table class="table table-striped text-center" style="background-color: #E0E4EB;" ng-hide="ComprobanteCtrl.cabecera.boolean_asociar">
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
                                                    <tr ng-repeat="x in ComprobanteCtrl.detalles_comprobante track by $index">
                                                        <td>/% $index + 1 %/</td>
                                                        <td><input type="text" ng-model="ComprobanteCtrl.detalles_comprobante[$index].cantidad" ng-init="ComprobanteCtrl.detalles_comprobante[$index].cantidad = x.cantidad" class="form-control text-center" ng-change="ComprobanteCtrl.moneda_or_incluido_igv_change()"></td>
                                                        <td><input type="text" ng-model="ComprobanteCtrl.detalles_comprobante[$index].nombre_producto" ng-init="ComprobanteCtrl.detalles_comprobante[$index].nombre_producto = x.producto" class="form-control text-center"></td>
                                                        <td><input type="text" ng-model="ComprobanteCtrl.detalles_comprobante[$index].precio" ng-init="ComprobanteCtrl.detalles_comprobante[$index].precio = x.precio" class="form-control text-center" ng-change="ComprobanteCtrl.moneda_or_incluido_igv_change()"></td>
                                                        <td>/% x.cantidad*x.precio %/</td>
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
                                                            <td>/% x.nombre_producto %/</td>
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
                                  <div class="tab-pane" id="tab_2">
                                    <form id="form_nota">
                                        <div class="row form-group">
                                            <div class="col-md-2 text-right" style="padding-top: 4px;">
                                                Tipo Nota:
                                            </div>
                                            <div class="col-md-2">
                                                <select id="moneda" class="form-control validate[required]" ng-model="ComprobanteCtrl.nota.tipo_nota" ng-options="item as item.nombre_tipo_nota for item in ComprobanteCtrl.tipos_nota track by item.id" ng-change="ComprobanteCtrl.calcular_importe_nota()">
                                                    <option value="">-- Seleccione --</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2 text-right" style="padding-top: 4px;">
                                                N° Serie:
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" class="form-control validate[required,minSize[3]]" maxlength="3" ng-model="ComprobanteCtrl.nota.serie_comprobante">
                                            </div>
                                            <div class="col-md-2 text-right" style="padding-top: 4px;">
                                                N° Comprobante: 
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" class="form-control validate[required]" maxlength="20" ng-model="ComprobanteCtrl.nota.numero_comprobante">
                                            </div>
                                        </div>
                                        <div class="row form-group">        
                                            <div class="col-md-2 text-right" style="padding-top: 4px;">
                                                Descripcion
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" id="descripcion_nota" ng-model="ComprobanteCtrl.nota.descripcion_nota" class="form-control validate[required]" placeholder="Descripcion">
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2 text-right" style="padding-top: 4px;">
                                                Producto
                                            </div>
                                            <div class="col-md-5">
                                                <div class="input-group">

                                                    <a href="" ng-click="ComprobanteCtrl.buscarProducto()" class="input-group-addon">
                                                        <i class="fa fa-search"></i>
                                                    </a>
                                                    <angucomplete-alt id="nom_producto" placeholder="Nombre Producto" pause="100" selected-object="ComprobanteCtrl.seleccion_angucompleteproducto_nota" local-data="ComprobanteCtrl.angucomplete_productos" search-fields="nombre_producto" title-field="nombre_producto" minlength="1" input-class="form-control form-control-small validate[required]" match-class="highlight" field-required="true">
                                                    </angucomplete-alt>
                                                    <a href="" ng-click="ComprobanteCtrl.nuevoProducto()" class="input-group-addon">
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
                                                <input type="text" id="cantidad_producto" ng-model="ComprobanteCtrl.nota.cantidad" class="form-control validate[required,custom[number]]" placeholder="Cantidad">
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2 text-right" style="padding-top: 4px;">
                                                Monto 
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" id="precio_nota" ng-model="ComprobanteCtrl.nota.precio_nota" ng-change="ComprobanteCtrl.calcular_importe_nota()" class="form-control validate[required]" placeholder="Precio">
                                            </div>
                                        </div>
                                    </form>
                                  </div><!-- /.tab-pane -->
                                  <div class="tab-pane" id="tab_3">
                                    <form id="form_finanza">
                                        <div class="row form-group">
                                            <div class="col-md-1 text-right" style="padding-top: 4px;">
                                                Condicion Pago
                                            </div>
                                            <div class="col-md-3">
                                                <select id="condicion_pago" class="form-control validate[required]" ng-model="ComprobanteCtrl.finanzas.condicion" ng-options="item as item.nombre_condicion for item in ComprobanteCtrl.condiciones_pago track by item.id">
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
                                                    <select id="medio_pago" class="form-control validate[required]" ng-model="ComprobanteCtrl.finanzas.medio" ng-options="item as item.nombre_medio_pago for item in ComprobanteCtrl.medios_pago track by item.id">
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
                                                        <div class="col-md-1 text-right" style="padding-top: 4px;">
                                                            Dias
                                                        </div>
                                                        <div class="col-md-1">
                                                            <input type="text" id="numero_dias" ng-model="ComprobanteCtrl.finanzas.letra.numero_dias" class="form-control validate[required,custom[integer]]" placeholder="Días" ng-disabled="ComprobanteCtrl.finanzas.letra.fecha_vencimiento" >
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
                                                    <select id="estado_letra" class="form-control validate[required]" ng-model="ComprobanteCtrl.finanzas.estado" ng-init="ComprobanteCtrl.finanzas.estado.id = 4" ng-options="item as item.nombre_estado_letra for item in ComprobanteCtrl.estados_letra track by item.id">
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

                    <div class="row form-group" ng-show="ComprobanteCtrl.nota.precio_nota">
                        <div class="col-md-2 col-md-offset-8 text-right">
                            <label>Total con Nota : </label>
                        </div>
                        <div class="col-md-2">
                            <input type="number" id="total_nota" class="form-control" placeholder="Total Nota" disabled>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-3 col-md-offset-3">
                            <a ng-click="ComprobanteCtrl.imprimir()" target="_blank" class="btn btn-flat btn-primary btn-block"><i class="fa fa-print"></i> Imprimir</a>
                        </div>
                        <div class="col-md-3">
                            <a ng-click="ComprobanteCtrl.store(ComprobanteCtrl.detalles_venta,ComprobanteCtrl.cabecera_venta)" class="btn btn-flat btn-success btn-block"><i class="fa fa-dollar"></i> Procesar Compra</a>
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
                          <li id="li_box_tab_create_guia_/% x.n_guia %/" ng-class="{active: $last}" ng-repeat="x in ComprobanteCtrl.numero_guias track by $index"><a href="#box_tab_create_guia_/% x.n_guia %/" data-toggle="tab">Guia Remision Nº/% x.n_guia %/ <i class="fa fa-times" style="padding: 5px; cursor:pointer;" ng-click="ComprobanteCtrl.numero_guias.splice($index,1); ComprobanteCtrl.tab_hover[$index] = false;" ng-class="{'text-danger':ComprobanteCtrl.tab_hover[$index]}" ng-mouseover="ComprobanteCtrl.tab_hover[$index] = true" ng-mouseleave="ComprobanteCtrl.tab_hover[$index] = false"></i></a></li>
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
                                                <input type="text" id="fecha_comprobante_guia_/% x.n_guia %/" class="form-control validate[required]" datepicker-popup="/% format %/" ng-model="ComprobanteCtrl.cabecera_guia[$index].fecha_comprobante_guia" is-open="opened_fec_inicio_guia_[$index]" current-text="Hoy" weeks-text="Semanas" close-text="Cerrar" />
                                            </div>
                                        </div>
                                        
                                        
                                    </div>

                                    <hr>
                                    
                                    
                                <!-- <hr> -->

                                    <!-- <div class="row form-group">
                                        <div class="col-md-2 text-right">
                                            Punto de Partida: 
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" id="fecha_comprobante_guia_/% x.n_guia %/" class="form-control" ng-model="ComprobanteCtrl.cabecera_guia[$index].punto_partida" ng-init="ComprobanteCtrl.cabecera_guia[$index].punto_partida = 'Jr. Mariano Melgar Nro 144 Dpto. 3 - Urb. Pampa de Cueva - Lima - Independencia'">
                                        </div>
                                    </div>
                                     -->
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
                                        
                                        <div id="div_motivos" class="col-md-12" style="margin-left:10px !important;margin-top: 25px;" ng-if="ComprobanteCtrl.cabecera_guia[$index].Motivo_seleccionado.id == null">
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
                                <div class="row form-group hide" >
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
                <div class="tab-pane" id="box_tab_4">

                                    <form id="form_gestion_nota_factura" style="margin-top: 15px;">


                                        <div class="row form-group">
                                            <div class="col-md-2 text-right" style="padding-top: 4px;">
                                                N° Serie:
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" class="form-control validate[required,minSize[3]]" maxlength="3" ng-model="ComprobanteCtrl.gestion_nota.serie">
                                            </div>
                                            <div class="col-md-2 text-right" style="padding-top: 4px;">
                                                N° Comprobante: 
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" class="form-control validate[required]" maxlength="20" ng-model="ComprobanteCtrl.gestion_nota.numero">
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

                                    <form id="form_gestion_nota_detalle_nota">
                                        
                                        <div class="row form-group">
                                            <div class="col-md-2 text-right" style="padding-top: 4px;">
                                                Tipo Nota:
                                            </div>
                                            <div class="col-md-2">
                                                <select id="moneda" class="form-control validate[required]" ng-model="ComprobanteCtrl.gestion_nota.tipo_nota" ng-options="item as item.nombre_tipo_nota for item in ComprobanteCtrl.tipos_nota track by item.id">
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
                                                    <input type="text" id="fecha_emision_nota" class="form-control validate[required]" datepicker-popup="/% format %/" ng-model="ComprobanteCtrl.gestion_nota.fecha_emision" is-open="opened_fec_emision_nota_gestion_nota" current-text="Hoy" weeks-text="Semanas" close-text="Cerrar" clear-text="Limpiar" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2 text-right" style="padding-top: 4px;">
                                                N° Serie:
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" class="form-control validate[required,minSize[3]]" maxlength="3" ng-model="ComprobanteCtrl.gestion_nota.serie_nota">
                                            </div>
                                            <div class="col-md-2 text-right" style="padding-top: 4px;">
                                                N° Comprobante: 
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" class="form-control validate[required]" maxlength="20" ng-model="ComprobanteCtrl.gestion_nota.numero_nota">
                                            </div>
                                        </div>
                                        <div class="row form-group">        
                                            <div class="col-md-2 text-right" style="padding-top: 4px;">
                                                Descripcion
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" id="descripcion_nota" ng-model="ComprobanteCtrl.gestion_nota.descripcion_nota" class="form-control validate[required]" placeholder="Descripcion">
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2 text-right" style="padding-top: 4px;">
                                                Producto
                                            </div>
                                            <div class="col-md-5">
                                                <div class="input-group">

                                                    <a href="" ng-click="ComprobanteCtrl.buscarProducto_gestion_nota()" class="input-group-addon">
                                                        <i class="fa fa-search"></i>
                                                    </a>
                                                    <angucomplete-alt id="nom_producto_gestion_nota" placeholder="Nombre Producto" pause="100" selected-object="ComprobanteCtrl.seleccion_angucompleteproducto_gestion_nota" local-data="ComprobanteCtrl.angucomplete_productos" search-fields="nombre_producto" title-field="nombre_producto" minlength="1" input-class="form-control form-control-small" match-class="highlight" field-required="true">
                                                    </angucomplete-alt>
                                                    <a href="" ng-click="ComprobanteCtrl.nuevoProducto()" class="input-group-addon">
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
                                                <input type="text" id="cantidad_producto" ng-model="ComprobanteCtrl.gestion_nota.cantidad" class="form-control validate[custom[number]]" placeholder="Cantidad">
                                            </div>
                                        </div>
                                        <div class="row form-group">        
                                            <div class="col-md-2 text-right" style="padding-top: 4px;">
                                                Merma
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" id="merma" ng-model="ComprobanteCtrl.gestion_nota.merma" class="form-control validate[custom[number]]" placeholder="Cantidad">
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2 text-right" style="padding-top: 4px;">
                                                Monto 
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" id="precio_nota" ng-model="ComprobanteCtrl.gestion_nota.precio_nota" class="form-control validate[required]" placeholder="Precio">
                                            </div>
                                            <div class="col-md-2">
                                                <a ng-click="ComprobanteCtrl.agregar_detalle_nota_gestion_nota()" class="btn btn-flat btn-success btn-block" ><i class="fa fa-plus"></i><span style="padding-left: 8px;">Agregar Nota</span></a>
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
                                                        <th style="width : 20%">TIPO NOTA</th>
                                                        <th style="width : 20%">SERIE</th>
                                                        <th style="width : 20%">NUMERO</th>
                                                        <th style="width : 20%">DESCRIPCION</th>
                                                        <th style="width : 20%">PRECIO</th>
                                                        <th style="width : 10%">...</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr ng-repeat="x in ComprobanteCtrl.detalles_nota_gestion_nota track by $index">
                                                        <td>/% $index + 1 %/</td>
                                                        <td>/% x.tipo_nota.nombre_tipo_nota %/</td>
                                                        <td>/% x.serie_nota %/</td>
                                                        <td>/% x.numero_nota %/</td>
                                                        <td>/% x.descripcion_nota %/</td>
                                                        <td>/% x.precio_nota %/</td>
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
                                            <a ng-click="ComprobanteCtrl.store_gestion_nota(ComprobanteCtrl.detalles_nota_gestion_nota,ComprobanteCtrl.detalles_factura_nota)" class="btn btn-flat btn-success btn-block"><i class="fa fa-dollar"></i> Asociar</a>
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


    app.controller('AdsComprobanteCompra', function AdsComprobanteCompra(ComprobanteCompraFactory, $scope){
  
        var vm = this;
        vm.detalles_comprobante = ComprobanteCompraFactory.Detalle_comprobante; 
        vm.detalles_letra = ComprobanteCompraFactory.Detalle_letra; 
        vm.detalles_finanza = ComprobanteCompraFactory.Detalle_finanza; 
        vm.cabecera = ComprobanteCompraFactory.CabeceraComprobante_create; 
        vm.cabecera.incluido_igv = false;

        vm.finanzas = ComprobanteCompraFactory.Finanzas_create; 
        vm.nota = ComprobanteCompraFactory.Nota_create; 

        vm.angucomplete_productos = ComprobanteCompraFactory.Productos;
        vm.angucomplete_proveedores = ComprobanteCompraFactory.Proveedores;
        vm.angucomplete_partida = ComprobanteCompraFactory.Partida;
        vm.angucomplete_llegada = ComprobanteCompraFactory.Llegada;
        vm.monedas = ComprobanteCompraFactory.Monedas;
        vm.condiciones_pago = ComprobanteCompraFactory.CondicionesPago;
        vm.medios_pago = ComprobanteCompraFactory.MediosPago;
        vm.estados_letra = ComprobanteCompraFactory.EstadosLetra;
        vm.tipos_nota = ComprobanteCompraFactory.TipoNotas;

        vm.fecha_comprobante = ComprobanteCompraFactory.FechaComprobante;
        
        vm.prueba = function(){
            // console.log(vm.cabecera);
            console.log(vm.fecha_comprobante);
            // ComprobanteCompraFactory.FechaComprobante = null;
        }

        vm.cancelar_comprobante = function(){

            ComprobanteCompraFactory.cancelar_comprobante();

        }

        vm.nuevoProducto = function(){
            ComprobanteCompraFactory.nuevoProducto();
        }

        vm.validar_tipoCambio = function(){

            var fecha = new XDate(vm.fecha_comprobante).toString('yyyy-MM-dd');

            console.log(ComprobanteCompraFactory.validar_tipoCambio(fecha));
            
        }
        vm.imprimir = function(){

            if($("#form_cabecera").validationEngine('validate')){

                if(vm.detalles_comprobante[0]!=null){

                    var cabecera_create = {
                            serie : vm.cabecera.serie_comprobante
                            , numero : vm.cabecera.numero_comprobante
                            , fecha : new XDate(vm.fecha_comprobante).toString('yyyy-MM-dd')
                            , cliente : ComprobanteCompraFactory.Proveedor_seleccionado
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
                    
                    ComprobanteCompraFactory.imprimir(cabecera_create,detalle_create,totales_create);
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


        vm.modal_asociar = function(){

            ComprobanteCompraFactory.modal_asociar();
        }

        vm.seleccion_angucompleteproveedor = function(object){

            angular.copy(object.description,ComprobanteCompraFactory.Proveedor_seleccionado)
            angular.element(proveedor_value).val(ComprobanteCompraFactory.Proveedor_seleccionado.razon_social);
            angular.element(ruc).val(ComprobanteCompraFactory.Proveedor_seleccionado.ruc);
            angular.element(direccion).val(ComprobanteCompraFactory.Proveedor_seleccionado.direccion);
        }

        ComprobanteCompraFactory.getProductos();
        // ComprobanteCompraFactory.getClientes();
        ComprobanteCompraFactory.getProveedores();
        ComprobanteCompraFactory.getMonedas();
        ComprobanteCompraFactory.getEstadoLetra();
        ComprobanteCompraFactory.getMedioPago();
        ComprobanteCompraFactory.getCondicionPago();
        ComprobanteCompraFactory.getTipoNota();


        ComprobanteCompraFactory.getAllUnidadMedida();
        ComprobanteCompraFactory.getAllComposicion();
        ComprobanteCompraFactory.getAllTitulo();
        ComprobanteCompraFactory.getAllHilatura();
        ComprobanteCompraFactory.getAllTipoProducto();
        ComprobanteCompraFactory.getAllTipoTela();
        ComprobanteCompraFactory.getAllColor();


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
            angular.element(stock).val(object.description.stock);
            angular.element(unidad_medida).val(object.description.unidad_medida.nombre_unidad_medida);
            // angular.element(label_precio).text('Mínimo.: '+object.description.precio_unitario);
            // angular.element(precio_producto).removeClass('validate[required]');
            // angular.element(precio_producto).addClass('validate[required,min['+object.description.precio_unitario+']]');
            

            angular.copy(object.description, ComprobanteCompraFactory.Producto_seleccionado);
        }
        
        vm.seleccion_angucompleteproducto_nota = function(object){
            if($('#moneda').validationEngine('validate')){


                if(object.description.precio_unitario == null) object.description.precio_unitario=0;

                angular.copy(object.description, ComprobanteCompraFactory.Producto_seleccionado_nota);
            }

        }

        vm.eliminar = function(index){
            ComprobanteCompraFactory.deleteAttempt(index);
        }
        
        vm.create = function(){
            ComprobanteCompraFactory.create();
        }

        vm.edit = function(row_detalle_venta, index){
            ComprobanteCompraFactory.edit(row_detalle_venta, index);
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

            if($("#form_cabecera").validationEngine('validate')){
                if(Object.keys(vm.finanzas).length != 0){
                    if(vm.detalles_comprobante[0]!=null){
                        if(gen_guia==true){//CUANDO SE VA A GENERAR GUIASSS JUNTO CON LA FACTURA DE VENTA

                            console.log('GENERAR GUIAS');
                            console.log(ComprobanteCompraFactory.CabeceraComprobante_create.boolean_asociar);

                            if(vm.cabecera_guia[0].serie_comprobante_guia==undefined || vm.cabecera_guia[0].numero_comprobante_guia==undefined || vm.cabecera_guia[0].fecha_comprobante_guia==undefined || vm.cabecera_guia[0].Motivo_seleccionado==undefined){
                                alert('Debe completar los campos requeridos');

                                $("#box_tab_1").removeClass('active');
                                $("#li_box_tab_1").removeClass('active');
                                $("#box_tab_2").addClass('active');
                                $("#li_box_tab_2").addClass('active');

                                $("#form_cabecera_guia_0").validationEngine("validate");
                            }
                            else{
                                var cabecera_create = {
                                        serie : vm.cabecera.serie_comprobante
                                        , numero : vm.cabecera.numero_comprobante
                                        , fecha : new XDate(vm.fecha_comprobante).toString('yyyy-MM-dd')
                                        , cliente : ComprobanteCompraFactory.Proveedor_seleccionado
                                        , moneda : vm.cabecera.moneda
                                        , incluido_igv : vm.cabecera.incluido_igv
                                        , total : angular.element(total).val()
                                        , boolean_asociar : ComprobanteCompraFactory.CabeceraComprobante_create.boolean_asociar
                                        , id_guiasRemision : ComprobanteCompraFactory.Array_id_guias
                                };

                                var cabecera_guia_create = [];
                                var cant_guias = ComprobanteCompraFactory.numero_guias.length;
                                for (var i = 0; i < ComprobanteCompraFactory.numero_guias.length; i++) {
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
                                                                , detalle_guia : ComprobanteCompraFactory.Detalle_comprobante_guia[i]
                                                        });

                                };

                                var detalle_create = vm.detalles_comprobante;
                                // if(vm.cliente_angucomp_select)
                                // {
                                //     cabecera.id_cliente = vm.cliente_angucomp_select.description.id;
                                // }
                                // CREANDO DETALLE DE FINANZA

                                    if(Object.keys(vm.finanzas).length == 0){
                                        vm.finanzas.condicion = {id:null};
                                    }
                                    
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

                                    vm.finanzas.detalles_letra = ComprobanteCompraFactory.Detalle_letra;
                                    var finanzas_create = vm.finanzas;

                                    if(Object.keys(vm.nota).length == 0){
                                        vm.nota.tipo_nota = {id:null};
                                    }

                                    vm.nota.total_nota = angular.element(total_nota).val();
                                    vm.nota.producto = ComprobanteCompraFactory.Producto_seleccionado_nota;

                                    var nota_create = vm.nota;
                                ComprobanteCompraFactory.store(cabecera_create,cabecera_guia_create,detalle_create,finanzas_create,nota_create);
                            }
                        }
                        else{//CUANDO SE VA A GENERAR SOLO LA FACTURA DE VENTA
                            console.log('BOOOLEAN ASOCIAR');
                            console.log(ComprobanteCompraFactory.CabeceraComprobante_create.boolean_asociar);
                            var cabecera_create = {
                                    serie : vm.cabecera.serie_comprobante
                                    , numero : vm.cabecera.numero_comprobante
                                    , fecha : new XDate(vm.fecha_comprobante).toString('yyyy-MM-dd')
                                    , cliente : ComprobanteCompraFactory.Proveedor_seleccionado
                                    , moneda : vm.cabecera.moneda
                                    , incluido_igv : vm.cabecera.incluido_igv
                                    , total : angular.element(total).val()
                                    , boolean_asociar : ComprobanteCompraFactory.CabeceraComprobante_create.boolean_asociar
                                    , id_guiasRemision : ComprobanteCompraFactory.Array_id_guias
                            };

                            var cabecera_guia_create = [];

                            var detalle_create = vm.detalles_comprobante;
                                console.log('detalle_create');
                                console.log(detalle_create);
                            // if(vm.cliente_angucomp_select)
                            // {
                            //     cabecera.id_cliente = vm.cliente_angucomp_select.description.id;
                            // }
                            // CREANDO DETALLE DE FINANZA

                                if(Object.keys(vm.finanzas).length == 0){
                                    vm.finanzas.condicion = {id:null};
                                }

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

                                vm.finanzas.detalles_letra = ComprobanteCompraFactory.Detalle_letra;
                                var finanzas_create = vm.finanzas;

                                if(Object.keys(vm.nota).length == 0){
                                    vm.nota.tipo_nota = {id:null};
                                }

                                vm.nota.total_nota = angular.element(total_nota).val();
                                vm.nota.producto = ComprobanteCompraFactory.Producto_seleccionado_nota;

                                var nota_create = vm.nota;
                            ComprobanteCompraFactory.store(cabecera_create,cabecera_guia_create,detalle_create,finanzas_create,nota_create);
                        }
                    }
                    else{
                        alert('Debe agregar un detalle al comprobante.');
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

        vm.buscarProducto = function(){
            ComprobanteCompraFactory.buscarProducto();
        }

        vm.buscarProducto_guia = function(index){
            ComprobanteCompraFactory.buscarProducto_guia(index);
        }

        vm.buscarProveedor = function(){
            ComprobanteCompraFactory.buscarProveedor();
        }

        vm.nuevoProveedor = function(){
            ComprobanteCompraFactory.nuevoProveedor();
        }

        // vm.buscarCliente = function(){
        //     ComprobanteCompraFactory.buscarCliente();
        // }

        vm.set_codebar = function(){
            var posicion = vm.detalle_venta.codebar.indexOf('-');
            var id_producto = parseInt(vm.detalle_venta.codebar.substring(posicion+1));
            ComprobanteCompraFactory.getProductoByIdFromInvetarioProd(id_producto);
        }

        vm.agregar_detalle = function(){
            if($("#form_detalle").validationEngine('validate')){      

                ComprobanteCompraFactory.agregar_detalle(vm.detalle_comprobante);
                angular.element(nom_producto_value).val('');
                vm.detalle_comprobante.cantidad = '';
                vm.detalle_comprobante.unidadMedida = '';
                vm.detalle_comprobante.precio = '';

            }
        }        

        vm.agregar_detalle_letra = function(){
            if($("#form_detalle_letra").validationEngine('validate')){

                if(vm.fecha_comprobante != undefined){
                    // ComprobanteCompraFactory.agregar_detalle_letra(vm.finanzas.letra, vm.fecha_comprobante);

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
                    var cantidad_registros_detalle = ComprobanteCompraFactory.Detalle_letra.length + 1;

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

                    ComprobanteCompraFactory.Detalle_letra.push({
                                                                    numero_letra : detalle_letra.numero_letra
                                                                    , numero_dias : dias_letra
                                                                    , monto_letra : monto_letra
                                                                    , fecha_vencimiento : new XDate(fecha_vencimiento_let).toString('yyyy-MM-dd')

                                                                });

                    for (var i = 0; i < ComprobanteCompraFactory.Detalle_letra.length; i++) {
                        console.log('ENTRO ACTUALIZAR');
                        ComprobanteCompraFactory.Detalle_letra[i].monto_letra = Math.round((total_factura/cantidad_registros_detalle )* 1000) / 1000;
                        // vm.detalles_finanza[i].monto_letra = Math.round((total_factura/cantidad_registros_detalle )* 1000) / 1000;
                    };

                    console.log(ComprobanteCompraFactory.Detalle_letra);


                    angular.element(numero_letra).val('');
                    angular.element(fecha_vencimiento_letra).val('');
                    angular.element(numero_dias).val('');
                    ComprobanteCompraFactory.Finanzas_create.letra.fecha_vencimiento = null;
                    ComprobanteCompraFactory.Finanzas_create.letra.numero_dias = null;


                }
                else{
                    sweetAlert("Error...", "Debe seleccionar la Fecha de Emision del Comprobante", "error");
                }
            }
        }

        vm.moneda_or_incluido_igv_change = function(){
            ComprobanteCompraFactory.calcular_total();

        }


        vm.calcular_total = function(){
            ComprobanteCompraFactory.calcular_total();
        }

        vm.calcular_importe_nota = function(){
            ComprobanteCompraFactory.calcular_total();
            var total_comprobante = angular.element(total).val();
            var total_importe_aplicado = 0;
            var igv = <?php echo (DB::table('ts_igv')->where('estado', 'true')->pluck('valor_igv')); ?>;
            var var_total_nota = 0;
            if(vm.nota.tipo_nota.id == 1){
                var_total_nota = parseFloat(total_comprobante) + parseFloat(vm.nota.precio_nota);
            }
            else if(vm.nota.tipo_nota.id == 2){
                var_total_nota = parseFloat(total_comprobante) - parseFloat(vm.nota.precio_nota);
            }

            angular.element(total_nota).val(var_total_nota);
        }




        ComprobanteCompraFactory.getPartidaGuia();
        ComprobanteCompraFactory.getLlegadaGuia();


        vm.cabecera_guia = ComprobanteCompraFactory.CabeceraComprobanteGuia_create; 
        vm.detalles_comprobante_guia = ComprobanteCompraFactory.Detalle_comprobante_guia; 


        vm.numero_guias = ComprobanteCompraFactory.numero_guias;
        vm.cabecera_guia[0] = {Motivo_seleccionado:{}};
        vm.cabecera_guia[0].Motivo_seleccionado.id = 5;
        vm.cabecera_guia[0].Motivo_seleccionado.nombre_motivoTraslado = 'COMPRA';

        ComprobanteCompraFactory.Detalle_comprobante_guia[0] = [];
        ComprobanteCompraFactory.Producto_seleccionado_guia[0] = [];
        vm.nueva_guia = function(){
            vm.numero_guias.push({n_guia:(ComprobanteCompraFactory.numero_guias.length+1)});
            vm.cabecera_guia[ComprobanteCompraFactory.numero_guias.length-1] = {Motivo_seleccionado:{}};
            vm.cabecera_guia[ComprobanteCompraFactory.numero_guias.length-1].Motivo_seleccionado.id = 5;
            vm.cabecera_guia[ComprobanteCompraFactory.numero_guias.length-1].Motivo_seleccionado.nombre_motivoTraslado = 'COMPRA';
            ComprobanteCompraFactory.Detalle_comprobante_guia[ComprobanteCompraFactory.numero_guias.length-1] = [];
            ComprobanteCompraFactory.Producto_seleccionado_guia[ComprobanteCompraFactory.numero_guias.length-1] = [];
        }

        vm.pasar_factura = function(){

            // var contador_empresa = 0;
            // for (var i = 0; i < vm.cabecera_guia.length; i++) {
            //     if(vm.cabecera_guia[i].empresa == undefined){
            //         contador_empresa++;
            //     }
            // };
            // if(contador_empresa > 0){

            //     swal({   
            //             title: contador_empresa+" Guía(s) de remisión sin Transporte"
            //             , text: "¿Desea continuar?"
            //             , type: "warning",   showCancelButton: true
            //             , confirmButtonColor: "#A5DC86"
            //             , confirmButtonText: "Continuar"
            //             , closeOnConfirm: true 
            //         }, 
            //         function(){
            //             console.log('11');
            //             var aux_cabecera = 0;
            //             var aux_detalle = 0;
            //             var aux_general = 0;
            //             console.log('22');
            //             for (var i = 0; i < ComprobanteCompraFactory.numero_guias.length; i++) {
            //                 console.log('33');
            //                 if($("#form_cabecera_guia_"+i).validationEngine('validate')){
            //                     aux_cabecera = 0;
            //                 }
            //                 else{
            //                     aux_cabecera++;
            //                 }
                            
            //                 if(ComprobanteCompraFactory.Detalle_comprobante_guia[i].length != 0){
            //                     if($("#form_detalle_table_"+i).validationEngine('validate')){
            //                         aux_detalle = 0;
            //                     }
            //                     else{
            //                         aux_detalle++;
            //                     }
            //                 }
            //                 if(aux_cabecera != 0 || aux_detalle != 0){
            //                     console.log('44');
            //                     aux_general++;
            //                 }
            //             };
            //             if(aux_general == 0){
            //                 console.log('55');

            //                 ComprobanteCompraFactory.pasar_factura();
            //             }
            //         });
            // }
            // else{
                var aux_cabecera = 0;
                var aux_detalle = 0;
                var aux_general = 0;
                for (var i = 0; i < ComprobanteCompraFactory.numero_guias.length; i++) {
                    if($("#form_cabecera_guia_"+i).validationEngine('validate')){
                        aux_cabecera = 0;
                    }
                    else{
                        aux_cabecera++;
                    }
                    
                    if(ComprobanteCompraFactory.Detalle_comprobante_guia[i].length != 0){
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
                    ComprobanteCompraFactory.pasar_factura();
                }
            // }
        }


        ComprobanteCompraFactory.getEmpresas();
        ComprobanteCompraFactory.getMotivos();

        vm.empresas = ComprobanteCompraFactory.Empresas;
        vm.motivos = ComprobanteCompraFactory.Motivos;
        vm.unidades = ComprobanteCompraFactory.Unidades;
        vm.personales = ComprobanteCompraFactory.Personales;

        vm.abrir_motivo = function(index){
            // vm.cabecera_guia[index].Motivo_seleccionado = null;
            angular.copy(null,vm.cabecera_guia[index].Motivo_seleccionado);
        }

        vm.seleccion_empresa = function(id_empresa){
            ComprobanteCompraFactory.getUnidades(id_empresa);
            ComprobanteCompraFactory.getPersonales(id_empresa);
        }


        vm.agregar_detalle_guia = function(index){
            if($("#form_detalle_guia_"+index).validationEngine('validate')){      

                ComprobanteCompraFactory.agregar_detalle_guia(vm.detalle_comprobante_guia[index], index);
                // angular.element(nom_producto_guia_value).val('');
                $scope.$broadcast('angucomplete-alt:clearInput', 'nom_producto_'+index);
                vm.detalle_comprobante_guia[index].cantidad = '';
                // vm.detalle_comprobante.unidadMedida = '';
                // vm.detalle_comprobante.precio = '';

            }
        }

        vm.eliminar_detalle_guia = function(parent, index){
            ComprobanteCompraFactory.deleteAttempt_detalle_guia(parent, index);
        }

        vm.seleccion_angucompleteproducto_guia = function(object){

            var index = this.$parent.$index;  

            angular.copy(object.description, ComprobanteCompraFactory.Producto_seleccionado_guia[index]);
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


        vm.detalles_nota_gestion_nota = ComprobanteCompraFactory.Detalle_nota_gestion_nota; 
        vm.detalles_factura_nota = ComprobanteCompraFactory.Detalle_factura_nota; 
        vm.agregar_detalle_factura_nota = function(){
            if($("#form_gestion_nota_factura").validationEngine('validate')){

                ComprobanteCompraFactory.agregar_detalle_factura_nota(vm.gestion_nota);

            }
        }

        vm.buscarProducto_gestion_nota = function(index){
            ComprobanteCompraFactory.buscarProducto_gestion_nota(index);
        }
 
        vm.seleccion_angucompleteproducto_gestion_nota = function(object){

            if(object.description.precio_unitario == null) object.description.precio_unitario=0;
            angular.copy(object.description, ComprobanteCompraFactory.Producto_seleccionado_gestion_nota);

        }
        vm.agregar_detalle_nota_gestion_nota = function(){
            if($("#form_gestion_nota_detalle_nota").validationEngine('validate')){
                if(ComprobanteCompraFactory.agregar_detalle_nota_gestion_nota(vm.gestion_nota,vm.detalles_factura_nota, ComprobanteCompraFactory.Producto_seleccionado_gestion_nota)){
                    
                }
                
            }
        }
        vm.store_gestion_nota = function(detalle_notas, detalle_facturas_nota){

            ComprobanteCompraFactory.store_gestion_nota(detalle_notas,detalle_facturas_nota); 

        }
    });



 
    app.factory('ComprobanteCompraFactory', function ComprobanteCompraFactory($http, $modal ) {

        ComprobanteCompraFactory.numero_guias = [{n_guia:1}];
        ComprobanteCompraFactory.Detalle_comprobante_guia = [];
        ComprobanteCompraFactory.Producto_seleccionado_guia = [];
        ComprobanteCompraFactory.CabeceraComprobanteGuia_create = [];

        ComprobanteCompraFactory.detalle_venta = {}; 
        ComprobanteCompraFactory.cabecera_venta = {}; 
        ComprobanteCompraFactory.detalle_venta.producto = {}; 
        ComprobanteCompraFactory.seleccion_producto = {}; 
        ComprobanteCompraFactory.Producto_create = {};
        ComprobanteCompraFactory.Proveedor_create = {};
        ComprobanteCompraFactory.Detalle_venta_edit = {};

        ComprobanteCompraFactory.Productos = [];
        ComprobanteCompraFactory.UnidadMedida = [];
        ComprobanteCompraFactory.Composicion = [];
        ComprobanteCompraFactory.Titulo = [];
        ComprobanteCompraFactory.Hilatura = [];
        ComprobanteCompraFactory.TipoProducto = [];
        ComprobanteCompraFactory.TipoTela = [];
        ComprobanteCompraFactory.Color = [];

        ComprobanteCompraFactory.Proveedores = [];
        ComprobanteCompraFactory.Partida = [];
        ComprobanteCompraFactory.Llegada = [];
        ComprobanteCompraFactory.Monedas = [];
        ComprobanteCompraFactory.CondicionesPago = [];
        ComprobanteCompraFactory.MediosPago = [];
        ComprobanteCompraFactory.EstadosLetra = [];
        ComprobanteCompraFactory.TipoNotas = [];

        ComprobanteCompraFactory.Array_id_guias = [];

        ComprobanteCompraFactory.Detalle_comprobante = [];
        ComprobanteCompraFactory.Detalle_letra = [];
        ComprobanteCompraFactory.Detalle_finanza = [];
        ComprobanteCompraFactory.Proveedor_seleccionado = {};
        ComprobanteCompraFactory.Producto_seleccionado = {};
        ComprobanteCompraFactory.Producto_seleccionado_nota = {};

        ComprobanteCompraFactory.CabeceraComprobante_create = {};
        ComprobanteCompraFactory.Finanzas_create = {};
        ComprobanteCompraFactory.Nota_create = {};
        ComprobanteCompraFactory.DetalleComprobante_create = {};
        ComprobanteCompraFactory.TipoCambio_create = {};

        ComprobanteCompraFactory.CabeceraComprobante_create.boolean_asociar = false;
        ComprobanteCompraFactory.CabeceraComprobante_create.incluido_igv = false;

        var fecha_actual = new XDate(new Date()).toString('yyyy-MM-dd');
        // ComprobanteCompraFactory.FechaComprobante = fecha_actual;


        ComprobanteCompraFactory.cancelar_comprobante = function(){
            $modal.open( { 
                templateUrl:'templates_angular/ComprobanteCompraController/cancelar_comprobante.html', 
                controller: function($scope, $modalInstance, ComprobanteCompraFactory) {
                    $scope.yes = function() {
                        angular.copy({},ComprobanteCompraFactory.Detalle_comprobante); 
                        angular.copy({},ComprobanteCompraFactory.CabeceraComprobante_create); 

                        ComprobanteCompraFactory.CabeceraComprobante_create.incluido_igv = false;

                        angular.element(proveedor_value).val('');
                        angular.element(ruc).val('');
                        angular.element(direccion).val('');

                        angular.element(subtotal).val('');
                        angular.element(igv).val('');
                        angular.element(total).val('');

                        angular.element(id_producto).val('');
                        angular.element(stock).val('');
                        angular.element(unidad_medida).val('');

                        $modalInstance.close();
                    }
                }
            });
        }

        ComprobanteCompraFactory.validar_tipoCambio = function(fecha) {
        angular.element(div_loader).removeClass('hide');
            $http.post('AdsComprobanteCompra/validar_tipoCambio', {fecha:fecha})
                .success(function(data){
        angular.element(div_loader).addClass('hide');
                    if(data == 'EXISTE'){
                        console.log('existe');
                    }
                    else if(data == 'NO EXISTE'){
                        $modal.open( { 
                            templateUrl:'templates_angular/ComprobanteCompraController/confirmacion_tipoCambio.html', 
                            controller: function($scope, $modalInstance, ComprobanteCompraFactory, TipoCambio_create) {
                                
                                $scope.tipoCambio = TipoCambio_create;

                                $scope.store = function() {
                                    $scope.tipoCambio.fecha = fecha;
                                    ComprobanteCompraFactory.storeTipoCambio($scope.tipoCambio).then(function(){

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
                                    return ComprobanteCompraFactory.TipoCambio_create;
                                }
                            }
                        });
                        console.log('no existe');
                    }
                });
        }


        ComprobanteCompraFactory.storeTipoCambio = function(scope) {
        angular.element(div_loader).removeClass('hide');
                 return $http.post('AdsTipoCambioMoneda', scope)
                    .success(function(data){
        angular.element(div_loader).addClass('hide');

                    });
        }
        
        ComprobanteCompraFactory.nuevoProducto = function(){
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
                            ComprobanteCompraFactory.storeProducto($scope.producto); /* Objeto de la vista */
                            $modalInstance.close();
                        };
                    }
                },
                resolve: {
                    UnidadMedida : function(){
                        return ComprobanteCompraFactory.UnidadMedida;
                    },
                    Composicion : function(){
                        return ComprobanteCompraFactory.Composicion;
                    },
                    Titulo : function(){
                        return ComprobanteCompraFactory.Titulo;
                    },
                    Hilatura : function(){
                        return ComprobanteCompraFactory.Hilatura;
                    },
                    TipoProducto : function(){
                        return ComprobanteCompraFactory.TipoProducto;
                    },
                    TipoTela : function(){
                        return ComprobanteCompraFactory.TipoTela;
                    },
                    Color : function(){
                        return ComprobanteCompraFactory.Color;
                    }
                }
            });
        }

        ComprobanteCompraFactory.storeProducto = function(Producto) {
 
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
                    angular.copy(data.datos,ComprobanteCompraFactory.Productos);
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

        ComprobanteCompraFactory.getAllComposicion = function() {
            return $http.get('AdsComposicion/getAllComposicion').success(function(data) {
                angular.copy(data.datos, ComprobanteCompraFactory.Composicion );
            });
        } 
        ComprobanteCompraFactory.getAllTitulo = function() {
            return $http.get('AdsTitulo/getAllTitulo').success(function(data) {
                angular.copy(data.datos, ComprobanteCompraFactory.Titulo );
            });
        } 
        ComprobanteCompraFactory.getAllHilatura = function() {
            return $http.get('AdsHilatura/getAllHilatura').success(function(data) {
                angular.copy(data.datos, ComprobanteCompraFactory.Hilatura );
            });
        } 
        ComprobanteCompraFactory.getAllTipoProducto = function() {
            return $http.get('AdsTipoProducto/getAllTipoProducto').success(function(data) {
                angular.copy(data.datos, ComprobanteCompraFactory.TipoProducto );
            });
        } 

        ComprobanteCompraFactory.getAllTipoTela = function() {
            return $http.get('AdsTipoTela/getAllTipoTela').success(function(data) {
                angular.copy(data.datos, ComprobanteCompraFactory.TipoTela );
            });
        } 
        ComprobanteCompraFactory.getAllColor = function() {
            return $http.get('AdsColor/getAllColor').success(function(data) {
                angular.copy(data.datos, ComprobanteCompraFactory.Color );
            });
        } 

        ComprobanteCompraFactory.getAllUnidadMedida = function() {

            return $http.get('AdsUnidadMedida/getAllUnidadMedida').success(function(data) {
                angular.copy(data.datos, ComprobanteCompraFactory.UnidadMedida );
            });
        } 


        ComprobanteCompraFactory.modal_asociar = function(){
            $modal.open( { 
                templateUrl:'templates_angular/ComprobanteVentaController/asociar_guia.html', 
                controller: function($scope, $modalInstance, ComprobanteCompraFactory) {
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
                        $scope.guia.compra_venta = 'COMPRA';
                        $http.post('AdsGuiaRemision/getGuiaBySerieNumero', {guia:$scope.guia})
                            .success(function(data){
        angular.element(div_loader).addClass('hide');
                                console.log(data.datos);
                                if(data.datos == ''){
                                    // alert('Esta Guia de Remision no existe.');
                                    sweetAlert("Error...", "Esta Guia de Remision no existe.", "error");
                                }
                                else if(data.datos[0].id_comprobanteCompra != null){
                                    // alert('Esta Guia ya esta asociada a otra Factura de Venta.');
                                    sweetAlert("Error...", "Esta Guia ya esta asociada a otra Factura de Compra.", "error");
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
                        angular.copy(Array_id_guias,ComprobanteCompraFactory.Array_id_guias);
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

                                    // Array_detalle_final[0].nombre_producto = null;
                                    // angular.copy(Array_detalle_final[0].nombre_producto,ComprobanteCompraFactory.Detalle_comprobante[0].nombre_producto);

                                    // angular.copy([],ComprobanteCompraFactory.Detalle_comprobante);
                                    // ComprobanteCompraFactory.Detalle_comprobante = [];


                                    // ComprobanteCompraFactory.Detalle_comprobante.push({
                                    //     'id_producto': Array_detalle_final[0].id_producto
                                    //     , 'nombre_producto': Array_detalle_final[0].nombre_producto
                                    //     , 'producto': Array_detalle_final[0].producto
                                    //     , 'unidades': Array_detalle_final[0].unidades
                                    //     , 'peso': Array_detalle_final[0].peso
                                    //     , 'precio_unitario': 0
                                    // });

                                    ComprobanteCompraFactory.Detalle_comprobante.push({
                                        'id_producto': Array_detalle_final[0].id_producto
                                        , 'nombre_producto': Array_detalle_final[0].nombre_producto
                                        , 'producto': Array_detalle_final[0].producto.nombre_producto
                                        , 'unidades': Array_detalle_final[0].unidades
                                        , 'peso': Array_detalle_final[0].peso
                                        , 'precio_unitario': 0
                                    });

                                    // angular.copy

                                    // angular.copy(Array_detalle_final,ComprobanteCompraFactory.Detalle_comprobante);

                                    // ComprobanteCompraFactory.Detalle_comprobante = Array_detalle_final;

                                    // angular.copy(null, ComprobanteCompraFactory.Detalle_comprobante[0].nombre_producto);
                                    // ComprobanteCompraFactory.Detalle_comprobante[0].nombre_producto = null;
                                    console.log('MODAL ASOCIAR');
                                    console.log(ComprobanteCompraFactory.Detalle_comprobante);
                                    console.log(ComprobanteCompraFactory.Detalle_comprobante[0].nombre_producto);
                        // *************    FIIN ACUMULANDO UNIUDADES Y PESO DE LOS DETALLES DE GUIAS     **************

                        
                                    ComprobanteCompraFactory.CabeceraComprobante_create.boolean_asociar = true;
                                    // *************** SETEAR ID GUIA REMISION *******************
                                    ComprobanteCompraFactory.CabeceraComprobante_create.id_guiaRemision = Object_datos.id;
                                    // *************** FIIN SETEAR ID GUIA REMISION *******************

                                    var data_datos_fiscal = {};


                                    // MEOTOD POST PARA OBTENER LA DIRECCION FISCAL DEL PROVEEDOR Y SETEARLO EN LA FACTURA
                                angular.element(div_loader).removeClass('hide');
                                ///////////////////////////////////////////////////////// FALTA AQUI EL ID DEL PROVEEEDOR METER CONSOLE LOG PARA SABER COMO LLEGA EL RESPONSE
                                    $http.post('AdsProveedor/getDirecFiscal',{id_proveedor : Object_datos.proveedor.id})
                                        .success(function(data){
                                angular.element(div_loader).addClass('hide');
                                            angular.copy(data.datos, data_datos_fiscal);

                                            // ComprobanteCompraFactory.Proveedor_seleccionado = data_datos_fiscal.direccion_cliente;.
                                            angular.copy(data_datos_fiscal, ComprobanteCompraFactory.Proveedor_seleccionado);


                                            // *************** SETEAR DATOS DEL CLIENTE *******************
                                            angular.element(proveedor_value).val(Object_datos.proveedor.razon_social);
                                            angular.element(ruc).val(Object_datos.proveedor.ruc);
                                            angular.element(direccion).val(data_datos_fiscal.direccion);


                                            // ***************  FIIN SETEAR DATOS DEL CLIENTE *******************

                                            
                                            // ***************  SETEAR DATOS DEL DETALLE *******************
                                            // angular.copy(Object_datos.guia_remision_detalle,ComprobanteCompraFactory.Detalle_comprobante);
                                            
                                            // ***************  FIIN SETEAR DATOS DEL DETALLE *******************

                                            $modalInstance.close();
                                        });
                                    


                    }

                }
            });
        }

        ComprobanteCompraFactory.imprimir = function(cabecera, detalle, totales) {
        angular.element(div_loader).removeClass('hide');
            $http.post('AdsComprobanteCompra/imprimir', {cabecera:cabecera, detalle:detalle, totales:totales})
                .success(function(data){
        angular.element(div_loader).addClass('hide');
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

        ComprobanteCompraFactory.getProductos = function() {
        angular.element(div_loader).removeClass('hide');
            return $http.get('AdsProducto/getAllProductos').success(function(data) {
        angular.element(div_loader).addClass('hide');
                console.log(data.datos);
                angular.copy(data.datos, ComprobanteCompraFactory.Productos);

            });
        }

        // ComprobanteCompraFactory.getClientes = function() {
        //     return $http.get('PtvCliente/getAllClientes').success(function(data) {
        //         angular.copy(data.datos, ComprobanteCompraFactory.Proveedores);
        //     });
        // } 

        ComprobanteCompraFactory.getProveedores = function() {
        angular.element(div_loader).removeClass('hide');
            return $http.get('AdsProveedor/getAllProveedores').success(function(data) {
        angular.element(div_loader).addClass('hide');
                console.log(data.datos);
                angular.copy(data.datos, ComprobanteCompraFactory.Proveedores);
            });
        } 

        ComprobanteCompraFactory.getPartidaGuia = function() {
        angular.element(div_loader).removeClass('hide');
            return $http.get('AdsGuiaRemision/getAllPartidaGuia').success(function(data) {
        angular.element(div_loader).addClass('hide');
                console.log('PARTIDA');
                console.log(data.datos);
                angular.copy(data.datos, ComprobanteCompraFactory.Partida);
            });
        } 

        ComprobanteCompraFactory.getLlegadaGuia = function() {
        angular.element(div_loader).removeClass('hide');
            return $http.get('AdsGuiaRemision/getAllLlegadaGuia').success(function(data) {
        angular.element(div_loader).addClass('hide');
                console.log('LLEGADA');
                console.log(data.datos);
                angular.copy(data.datos, ComprobanteCompraFactory.Llegada);
            });
        } 

        ComprobanteCompraFactory.getMonedas = function() {
        angular.element(div_loader).removeClass('hide');
            return $http.get('AdsMoneda/getAllMonedas').success(function(data) {
        angular.element(div_loader).addClass('hide');
                angular.copy(data.datos, ComprobanteCompraFactory.Monedas);
            });
        } 

        ComprobanteCompraFactory.getEstadoLetra = function() {
        angular.element(div_loader).removeClass('hide');
            return $http.get('AdsComprobanteVenta/getAllEstadoLetra').success(function(data) {
        angular.element(div_loader).addClass('hide');
                angular.copy(data.datos, ComprobanteCompraFactory.EstadosLetra);
            });
        }

        ComprobanteCompraFactory.getMedioPago = function() {
        angular.element(div_loader).removeClass('hide');
            return $http.get('AdsComprobanteVenta/getAllMedioPago').success(function(data) {
        angular.element(div_loader).addClass('hide');
                angular.copy(data.datos, ComprobanteCompraFactory.MediosPago);
            });
        }

        ComprobanteCompraFactory.getCondicionPago = function() {
        angular.element(div_loader).removeClass('hide');
            return $http.get('AdsComprobanteVenta/getAllCondicionPago').success(function(data) {
        angular.element(div_loader).addClass('hide');
        console.log(data.datos);
                angular.copy(data.datos, ComprobanteCompraFactory.CondicionesPago);
            });
        }

        ComprobanteCompraFactory.getTipoNota = function() {
        angular.element(div_loader).removeClass('hide');
            return $http.get('AdsTipoNota/getAllTipoNotas').success(function(data) {
        angular.element(div_loader).addClass('hide');
                angular.copy(data.datos, ComprobanteCompraFactory.TipoNotas);
            });
        }


        ComprobanteCompraFactory.deleteAttempt = function(index) {
            $modal.open( { 
                templateUrl:'templates_angular/deleteAttemp.html', 
                controller: function($scope, $modalInstance, ComprobanteCompraFactory) {
                    $scope.yes = function() {
                        ComprobanteCompraFactory.Detalle_comprobante.splice(index,1);
                        ComprobanteCompraFactory.calcular_total();
                        $modalInstance.close();
                    }
                }
            });
        }  

        ComprobanteCompraFactory.edit = function(row_detalle_comprobante,index){
            angular.copy(row_detalle_comprobante, ComprobanteCompraFactory.Detalle_venta_edit);
            $modal.open({
                templateUrl: 'templates_angular/ComprobanteCompraController/edit.html',
                controller: function($scope, $modalInstance, Detalle_venta_edit, UnidadesMedida){
                    $scope.Detalle = Detalle_venta_edit;
                    $scope.UnidadesMedida = UnidadesMedida;
                    $scope.update = function(){
                        ComprobanteCompraFactory.update($scope.Detalle,index);
                        $modalInstance.close();
                    }
                },
                resolve: {
                    Detalle_venta_edit : function(){
                        return ComprobanteCompraFactory.Detalle_venta_edit;
                    },
                    UnidadesMedida : function(){
                        return ComprobanteCompraFactory.UnidadesMedida;
                    },
                    UnidadesMedida_seleccionado : function(){
                        return ComprobanteCompraFactory.UnidadesMedida_seleccionado;
                    }
                }
            });
        }

        ComprobanteCompraFactory.update = function(Detalle,index){ 
            ComprobanteCompraFactory.detalles_venta[index].cantidad = Detalle.cantidad;
            ComprobanteCompraFactory.detalles_venta[index].id_unidadMedida = Detalle.UnidadesMedida_seleccionado.id;
            ComprobanteCompraFactory.detalles_venta[index].unidadMedida = Detalle.UnidadesMedida_seleccionado.n_EquivalenciaUnidad;
            ComprobanteCompraFactory.calcular_total();
        }


        ComprobanteCompraFactory.store = function(cabecera, cabecera_guia, detalle, finanzas, nota) {
        angular.element(div_loader).removeClass('hide');
                 $http.post('AdsComprobanteCompra', {cabecera:cabecera, cabecera_guia:cabecera_guia, detalle:detalle, finanzas:finanzas, nota:nota})
                    .success(function(data){
        angular.element(div_loader).addClass('hide');
                        if(data.datos=='correcto'){
                            // angular.copy({},ComprobanteCompraFactory.detalles_venta);
                            // angular.copy({},ComprobanteCompraFactory.detalle_venta);
                            // angular.copy({},ComprobanteCompraFactory.cabecera_venta);      
                            angular.copy([],ComprobanteCompraFactory.Detalle_comprobante); 
                            angular.copy({},ComprobanteCompraFactory.Detalle_letra);
                            angular.copy({},ComprobanteCompraFactory.CabeceraComprobante_create); 
                            angular.copy({},ComprobanteCompraFactory.Finanzas_create);
                            angular.copy({},ComprobanteCompraFactory.Nota_create);
                            ComprobanteCompraFactory.CabeceraComprobante_create.incluido_igv = false;

                            angular.copy([{n_guia:1}],ComprobanteCompraFactory.numero_guias); 
                            angular.copy([{Motivo_seleccionado:{}}],ComprobanteCompraFactory.CabeceraComprobanteGuia_create); 
                            ComprobanteCompraFactory.CabeceraComprobanteGuia_create[0].Motivo_seleccionado.id = 5;
                            ComprobanteCompraFactory.CabeceraComprobanteGuia_create[0].Motivo_seleccionado.nombre_motivoTraslado = 'COMPRA';

                            angular.copy([],ComprobanteCompraFactory.Detalle_comprobante_guia[0]);
                            
                            angular.element(proveedor_value).val('');
                            angular.element(ruc).val('');
                            angular.element(direccion).val('');

                            angular.element(subtotal).val('');
                            angular.element(igv).val('');
                            angular.element(total).val('');

                            angular.element(id_producto).val('');
                            angular.element(stock).val('');
                            angular.element(unidad_medida).val('');

                            ComprobanteCompraFactory.getProductos();

                            swal({   
                                title: "Registro exitoso!",
                                text: "El registro se realizó con éxito",
                                type: "success",
                                confirmButtonText: "OK" ,
                                timer: 2000
                            });
                        }else if(data.datos == 'duplicidad'){
                            sweetAlert("Error...", "¡Existe otro Comprobante de Compra con estos datos!", "error");
                        }
                    });
        }
        

        ComprobanteCompraFactory.buscarProducto = function(){
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
                    
                        angular.copy(data, ComprobanteCompraFactory.Producto_seleccionado);
                        angular.element(nom_producto_value).val(ComprobanteCompraFactory.Producto_seleccionado.nombre_producto);

                        angular.element(id_producto).val(ComprobanteCompraFactory.Producto_seleccionado.id);
                        angular.element(stock).val(ComprobanteCompraFactory.Producto_seleccionado.stock);
                        angular.element(unidad_medida).val(ComprobanteCompraFactory.Producto_seleccionado.unidad_medida.nombre_unidad_medida);
                        $modalInstance.close();
                    }
                },
                resolve: {
                    Producto_create : function(){
                        return ComprobanteCompraFactory.Producto_create;
                    },
                    Productos : function(){
                        return ComprobanteCompraFactory.Productos;
                    }
                }
            });
        }


        ComprobanteCompraFactory.buscarProducto_guia = function(index){
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
                        console.log('data PRODUCTO');
                        console.log(data);
                        angular.copy(data, ComprobanteCompraFactory.Producto_seleccionado_guia[index]);
                        $("#nom_producto_"+index+"_value").val(ComprobanteCompraFactory.Producto_seleccionado_guia[index].nombre_producto);
                        $("#unidad_medida_"+index+"_value").val(ComprobanteCompraFactory.Producto_seleccionado_guia[index].unidad_medida.nombre_unidad_medida);
                        $modalInstance.close();
                    }
                },
                resolve: {
                    Producto_create : function(){
                        return ComprobanteCompraFactory.Producto_create;
                    },
                    Productos : function(){
                        return ComprobanteCompraFactory.Productos;
                    }
                }
            });
        }

        // ComprobanteCompraFactory.buscarCliente = function(){
        //     $modal.open({
        //         templateUrl: 'templates_angular/ClienteController/seleccion_cliente.html',
        //         controller: function($scope, $modalInstance, Cliente_create, Cliente){
        //             $scope.cliente_create = Cliente_create;
        //             $scope.cliente = Cliente;
        //             $scope.seleccionar = function(data){
        //                 angular.element(proveedor_value).val(data.razon_social);
        //                 angular.element(ruc).val(data.ruc);
        //                 angular.element(direccion).val(data.direccion);

        //                 angular.copy(data, ComprobanteCompraFactory.Proveedor_seleccionado);

        //                 $modalInstance.close();
        //             }
        //         },
        //         resolve: {
        //             Cliente_create : function(){
        //                 return ComprobanteCompraFactory.Proveedor_create;
        //             },
        //             Cliente : function(){
        //                 return ComprobanteCompraFactory.Proveedores;
        //             }
        //         }
        //     });
        // }


        ComprobanteCompraFactory.buscarProveedor = function(){
            $modal.open({
                templateUrl: 'templates_angular/ProveedorController/seleccion_proveedor.html',
                controller: function($scope, $modalInstance, Proveedor_create, Proveedor){
                    $scope.proveedor_create = Proveedor_create;
                    $scope.proveedor = Proveedor;
                    $scope.seleccionar = function(data){
                        angular.element(proveedor_value).val(data.razon_social);
                        angular.element(ruc).val(data.ruc);
                        angular.element(direccion).val(data.direccion);

                        angular.copy(data, ComprobanteCompraFactory.Proveedor_seleccionado);

                        $modalInstance.close();
                    }
                },
                resolve: {
                    Proveedor_create : function(){
                        return ComprobanteCompraFactory.Proveedor_create;
                    },
                    Proveedor : function(){
                        return ComprobanteCompraFactory.Proveedores;
                    }
                }
            });
        }


        ComprobanteCompraFactory.nuevoProveedor = function(){
            $modal.open({
                templateUrl: 'templates_angular/ProveedorController/create.html',
                controller: function($scope, $modalInstance, $filter){
                    /* El objeto creado del scope se utiliza en la vista */
                    $scope.proveedor = {};
                    $scope.store = function(){
                        if ( $("#create_form").validationEngine('validate') ) {
                            ComprobanteCompraFactory.storeProveedor($scope.proveedor); /* Objeto de la vista */
                            $modalInstance.close();
                        };
                    }
                },
                resolve: {
                    
                }
            });
        }

        ComprobanteCompraFactory.storeProveedor = function(Proveedor) {
        angular.element(div_loader).removeClass('hide');
            $http.post('AdsProveedor', Proveedor).success(function(data){
        angular.element(div_loader).addClass('hide');
                ComprobanteCompraFactory.getProveedores();
            });
        }


        ComprobanteCompraFactory.agregar_detalle = function(detalle_comprobante){
            var entro = 0;
            var posicion_entro = 0;
            var cantidad_push = 0;
            for (var i = 0; i < ComprobanteCompraFactory.Detalle_comprobante.length; i++) {
                if(ComprobanteCompraFactory.Detalle_comprobante[i].id_producto == ComprobanteCompraFactory.Producto_seleccionado.id){
                    cantidad_push = parseFloat(ComprobanteCompraFactory.Detalle_comprobante[i].cantidad) + parseFloat(detalle_comprobante.cantidad);
                    entro = 1;
                    posicion_entro = i;
                }
                
            };

            if(entro == 1){
                ComprobanteCompraFactory.Detalle_comprobante[posicion_entro].cantidad = cantidad_push;
                ComprobanteCompraFactory.Detalle_comprobante[posicion_entro].precio = detalle_comprobante.precio;
            }
            else{

                ComprobanteCompraFactory.Detalle_comprobante.push({id_producto : ComprobanteCompraFactory.Producto_seleccionado.id, producto : ComprobanteCompraFactory.Producto_seleccionado.nombre_producto, cantidad : detalle_comprobante.cantidad, precio : detalle_comprobante.precio});
            }

            ComprobanteCompraFactory.calcular_total();

        }


        ComprobanteCompraFactory.agregar_detalle_letra = function(detalle_letra,fecha_comprobante){

            console.log('detalle_letra');

            // var fecha_vencimiento = fecha_comprobante.setSeconds((detalle_letra.numero_dias) * 86400);
            // var fecha_vencimiento = fecha_comprobante.setSeconds((detalle_letra.numero_dias) * 86400);
            console.log(fecha_comprobante);
            console.log(detalle_letra.numero_dias);
            console.log(fecha_vencimiento);
            var fecha_vencimiento = new Date(new Date(fecha_comprobante).getTime() + (detalle_letra.numero_dias * 24 * 3600 * 1000));
            // console.log("Fecha final: " + fecha_vencimiento.getDate() + "/" + (fecha_vencimiento.getMonth() + 1) + "/" + fecha_vencimiento.getFullYear());

            ComprobanteCompraFactory.Detalle_letra.push({
                                                            numero_letra : detalle_letra.numero_letra
                                                            , numero_dias : detalle_letra.numero_dias
                                                            , monto_letra : detalle_letra.monto_letra
                                                            , fecha_vencimiento : new XDate(fecha_vencimiento).toString('yyyy-MM-dd')

                                                        });
            console.log(ComprobanteCompraFactory.Detalle_letra);


            angular.element(numero_letra).val('');
            angular.element(numero_dias).val('');
            angular.element(monto_letra).val('');

        }
        ComprobanteCompraFactory.calcular_total = function(){

            // var tipo_cambio_dolar = <?php echo DB::table('ts_tipocambiomoneda')->where('fecha', date("Y-m-d"))->pluck('valor_venta'); ?>;
            var valor_igv = <?php echo DB::table('ts_igv')->where('estado', 'true')->pluck('valor_igv'); ?>;
            var valor_dividir = valor_igv+1;

            console.log(valor_igv);
            console.log(valor_dividir);

            if(ComprobanteCompraFactory.CabeceraComprobante_create.incluido_igv == false)
            {
                console.log(ComprobanteCompraFactory.Detalle_comprobante);
                var acum_subtotal=0;

                if(ComprobanteCompraFactory.CabeceraComprobante_create.boolean_asociar == true){ //CUANDO SE ASOCIA CON UNA GUIA

                    for (x=0;x<ComprobanteCompraFactory.Detalle_comprobante.length;x++){

                        var cantidad = ComprobanteCompraFactory.Detalle_comprobante[x].unidades;
                        var precio = ComprobanteCompraFactory.Detalle_comprobante[x].precio;
                        // if(ComprobanteCompraFactory.CabeceraComprobante_create.moneda.id == 2)
                        // {
                        //     precio = precio * tipo_cambio_dolar;
                        // }

                        acum_subtotal = acum_subtotal + (cantidad*precio);

                        // REDONDEANDO A 2 DECIMAS
                        acum_subtotal = Math.round(acum_subtotal * 100) / 100;
                    }
                }
                else{ // CUANDO ES EL FUNCIONAMIENTO NORMAL
                    for (x=0;x<ComprobanteCompraFactory.Detalle_comprobante.length;x++){

                        var cantidad = ComprobanteCompraFactory.Detalle_comprobante[x].cantidad;
                        var precio = ComprobanteCompraFactory.Detalle_comprobante[x].precio;
                        // if(ComprobanteCompraFactory.CabeceraComprobante_create.moneda.id == 2)
                        // {
                        //     precio = precio * tipo_cambio_dolar;
                        // }

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
                angular.element(subtotal).val(acum_subtotal);
                angular.element(igv).val(var_igv);
                angular.element(total).val(var_total);
                
            }
            else
            {
                var acum_total=0;

                if(ComprobanteCompraFactory.CabeceraComprobante_create.boolean_asociar == true){ //CUANDO SE ASOCIA CON UNA GUIA

                    for (x=0;x<ComprobanteCompraFactory.Detalle_comprobante.length;x++){

                        var cantidad = ComprobanteCompraFactory.Detalle_comprobante[x].unidades;
                        var precio = ComprobanteCompraFactory.Detalle_comprobante[x].precio;
                        // if(ComprobanteCompraFactory.CabeceraComprobante_create.moneda.id == 2)
                        // {
                        //     precio = precio * tipo_cambio_dolar;
                        // }

                        acum_total = acum_total + (cantidad*precio);
                        
                        // REDONDEANDO A 2 DECIMAS
                        acum_total = Math.round(acum_total * 100) / 100;
                    }
                }
                else{ // CUANDO ES EL FUNCIONAMIENTO NORMAL

                    for (x=0;x<ComprobanteCompraFactory.Detalle_comprobante.length;x++){

                        var cantidad = ComprobanteCompraFactory.Detalle_comprobante[x].cantidad;
                        var precio = ComprobanteCompraFactory.Detalle_comprobante[x].precio;
                        // if(ComprobanteCompraFactory.CabeceraComprobante_create.moneda.id == 2)
                        // {
                        //     precio = precio * tipo_cambio_dolar;
                        // }

                        acum_total = acum_total + (cantidad*precio);
                        
                        // REDONDEANDO A 2 DECIMAS
                        acum_total = Math.round(acum_total * 100) / 100;
                    }
                }
                
                var sub_total = acum_total /valor_dividir;
                // REDONDEANDO A 2 DECIMAS
                sub_total = Math.round(sub_total * 100) / 100;

                var var_igv = sub_total * valor_igv;
                // REDONDEANDO A 2 DECIMAS
                var_igv = Math.round(var_igv * 100) / 100;

                angular.element(subtotal).val(sub_total);
                angular.element(igv).val(var_igv);
                angular.element(total).val(acum_total);
            }
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


        ComprobanteCompraFactory.Empresas = [];
        ComprobanteCompraFactory.Motivos = []; 
        ComprobanteCompraFactory.Unidades = [];
        ComprobanteCompraFactory.Personales = []; 
        // ComprobanteCompraFactory.CabeceraComprobante_create.Motivo_seleccionado = {};



        ComprobanteCompraFactory.getEmpresas = function() {
                angular.element(div_loader).removeClass('hide');
            return $http.get('AdsTransporte/getAllTransportes').success(function(data) {
                angular.copy(data.datos, ComprobanteCompraFactory.Empresas);
                            angular.element(div_loader).addClass('hide');
            });
        } 


        ComprobanteCompraFactory.getUnidades = function(id_empresa) {
                angular.element(div_loader).removeClass('hide');
            return $http.get('AdsUnidadTransporte/getAllUnidadTransportesByEmpresa/'+id_empresa).success(function(data) {
                console.log(data.datos);
                angular.copy(data.datos, ComprobanteCompraFactory.Unidades);
                            angular.element(div_loader).addClass('hide');
            });
        } 

        ComprobanteCompraFactory.getPersonales = function(id_empresa) {
                angular.element(div_loader).removeClass('hide');
            return $http.get('AdsPersonalTransporte/getAllPersonalTransportesByEmpresa/'+id_empresa).success(function(data) {
                angular.copy(data.datos, ComprobanteCompraFactory.Personales);
                            angular.element(div_loader).addClass('hide');
            });
        } 


        ComprobanteCompraFactory.getMotivos = function() {
                angular.element(div_loader).removeClass('hide');
            return $http.get('AdsMotivoTraslado/getAllMotivoTraslado').success(function(data) {
                angular.copy(data.datos, ComprobanteCompraFactory.Motivos);
                            angular.element(div_loader).addClass('hide');
            });
        } 

        ComprobanteCompraFactory.pasar_factura = function(){
        angular.element(div_loader).removeClass('hide');
            console.log('ComprobanteCompraFactory.Detalle_comprobante_guia');
            console.log(ComprobanteCompraFactory.Detalle_comprobante_guia);
            var entro = 0;
            var posicion_entro = 0;
            var posicion_index = 0;
            var cantidad_push = 0;
            for (var index = 0; index < ComprobanteCompraFactory.Detalle_comprobante_guia.length; index++) { // RECORRO LAS GUIAS CREADAS

                for (var j = 0; j < ComprobanteCompraFactory.Detalle_comprobante_guia[index].length; j++) { // RECORRO EL DETALLE DE LA GUIA

                    for (var i = 0; i < ComprobanteCompraFactory.Detalle_comprobante.length; i++) { // RECORRO EL DETALLE DE LA FACTURA
                        if(ComprobanteCompraFactory.Detalle_comprobante_guia[index][j].id_producto == ComprobanteCompraFactory.Detalle_comprobante[i].id_producto){
                            cantidad_push = parseFloat(ComprobanteCompraFactory.Detalle_comprobante_guia[index][j].peso) + parseFloat(ComprobanteCompraFactory.Detalle_comprobante[i].cantidad);
                            entro = 1;
                            posicion_entro = i;
                            posicion_index = index;

                        }
                    };

                    if(entro == 1){

                        // ComprobanteCompraFactory.Detalle_comprobante_guia[posicion_index][posicion_entro].cantidad = cantidad_push;
                        ComprobanteCompraFactory.Detalle_comprobante[posicion_entro].cantidad = cantidad_push;
                        entro = 0;
                        // ComprobanteCompraFactory.Detalle_comprobante_guia[index][posicion_entro].precio = detalle_comprobante_guia.precio;
                    }
                    else{

                        ComprobanteCompraFactory.Detalle_comprobante.push({
                                                                        id_producto : ComprobanteCompraFactory.Detalle_comprobante_guia[index][j].id_producto
                                                                        , producto : ComprobanteCompraFactory.Detalle_comprobante_guia[index][j].producto
                                                                        , cantidad : ComprobanteCompraFactory.Detalle_comprobante_guia[index][j].peso
                                                                        , unidad_medida : ComprobanteCompraFactory.Detalle_comprobante_guia[index][j].unidad_medida
                                                                        , precio : 0
                                                                    });
                    }

                        
                    
                };

                



            };

            $("#box_tab_1").addClass('active');
            $("#li_box_tab_1").addClass('active');
            $("#box_tab_2").removeClass('active');
            $("#li_box_tab_2").removeClass('active');

            $("#tab_1").focus();
            $("#nom_producto_value").focus();
        angular.element(div_loader).addClass('hide');

        }

        ComprobanteCompraFactory.agregar_detalle_guia = function(detalle_comprobante_guia, index){

            console.log('detalle_comprobante_guia');
            console.log(detalle_comprobante_guia);
            var entro = 0;
            var posicion_entro = 0;
            var cantidad_push = 0;
            for (var i = 0; i < ComprobanteCompraFactory.Detalle_comprobante_guia[index].length; i++) {
                if(ComprobanteCompraFactory.Detalle_comprobante_guia[index][i].id_producto == ComprobanteCompraFactory.Producto_seleccionado_guia[index].id){
                    cantidad_push = parseFloat(ComprobanteCompraFactory.Detalle_comprobante_guia[index][i].cantidad) + parseFloat(detalle_comprobante_guia.cantidad);
                    entro = 1;
                    posicion_entro = i;
                }
                
            };

            if(entro == 1){
                ComprobanteCompraFactory.Detalle_comprobante_guia[index][posicion_entro].cantidad = cantidad_push;
                // ComprobanteCompraFactory.Detalle_comprobante_guia[index][posicion_entro].precio = detalle_comprobante_guia.precio;
            }
            else{
                    console.log('ENTROOOO 2');
                    console.log(ComprobanteCompraFactory.Producto_seleccionado_guia[index]);

                ComprobanteCompraFactory.Detalle_comprobante_guia[index].push({
                                                                id_producto : ComprobanteCompraFactory.Producto_seleccionado_guia[index].id
                                                                , producto : ComprobanteCompraFactory.Producto_seleccionado_guia[index].nombre_producto
                                                                , cantidad : detalle_comprobante_guia.cantidad
                                                                , unidad_medida : ComprobanteCompraFactory.Producto_seleccionado_guia[index].unidad_medida.nombre_unidad_medida
                                                                // , precio : detalle_comprobante_guia.precio
                                                            });
            console.log(ComprobanteCompraFactory.Detalle_comprobante_guia[index]);
            }


            // ComprobanteCompraFactory.calcular_total();


            // ComprobanteCompraFactory.Detalle_comprobante_guia[index].push({id_producto : ComprobanteCompraFactory.Producto_seleccionado.id, producto : ComprobanteCompraFactory.Producto_seleccionado.nombre_producto, cantidad : detalle_comprobante.cantidad, precio : detalle_comprobante.precio});
            
            // angular.element(label_precio).text('');
            // angular.element(stock).val('');
            // angular.element(unidad_medida).val('');

            // ComprobanteCompraFactory.calcular_total();

        }


        ComprobanteCompraFactory.deleteAttempt_detalle_guia= function(parent, index) {
            $modal.open( { 
                templateUrl:'templates_angular/deleteAttemp.html', 
                controller: function($scope, $modalInstance, ComprobanteCompraFactory) {
                    $scope.yes = function() {
                        ComprobanteCompraFactory.Detalle_comprobante_guia[parent].splice(index,1);
                        $modalInstance.close();
                    }
                }
            });
        }  


        ComprobanteCompraFactory.Detalle_factura_nota = [];
        ComprobanteCompraFactory.Detalle_nota_gestion_nota = [];
        ComprobanteCompraFactory.Producto_seleccionado_gestion_nota = {};

        ComprobanteCompraFactory.agregar_detalle_factura_nota = function(factura){

        angular.element(div_loader).removeClass('hide');

            $http.post('AdsComprobanteCompra/getFacturaBySerieNumero', {comprobante_compra:factura}).success(function(data){
        angular.element(div_loader).addClass('hide');
                // console.log('data.datos');
                // console.log(data.datos);
                if(data.datos == ''){
                    // alert('Esta Factura no existe.');
                    sweetAlert("Error...", "Esta Factura no existe.", "error");
                }
                else{
                    
                    ComprobanteCompraFactory.Detalle_factura_nota.push(data.datos[0]);
                    console.log('entro');
                    console.log(data.datos[0]);
                    angular.copy({},ComprobanteCompraFactory.Gestion_letra);

                }

                
            });

        }

        ComprobanteCompraFactory.store_gestion_nota = function(detalle_notas, detalle_facturas) {
        angular.element(div_loader).removeClass('hide');
                $http.post('AdsDetalleNota/store_gestion_nota_compra', {notas: detalle_notas, facturas: detalle_facturas})
                    .success(function(data){
        angular.element(div_loader).addClass('hide');
                        if(data.datos == 'correcto'){
                            angular.copy([],ComprobanteCompraFactory.Detalle_nota_gestion_nota);
                            angular.copy([],ComprobanteCompraFactory.Detalle_factura_nota);

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

        ComprobanteCompraFactory.buscarProducto_gestion_nota = function(){
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
                        angular.copy(data, ComprobanteCompraFactory.Producto_seleccionado_gestion_nota);
                        $("#nom_producto_gestion_nota_value").val(ComprobanteCompraFactory.Producto_seleccionado_gestion_nota.nombre_producto);
                        $modalInstance.close();
                    }
                },
                resolve: {
                    Producto_create : function(){
                        return ComprobanteCompraFactory.Producto_create;
                    },
                    Productos : function(){
                        return ComprobanteCompraFactory.Productos;
                    }
                }
            });
        }
        ComprobanteCompraFactory.agregar_detalle_nota_gestion_nota = function(detalle_nota,array_facturas, producto){

            // var index_array_facturas = array_facturas.length - 1;

            // var dias_letra = Math.round((  (new Date(new XDate(detalle_nota.fecha_vencimiento).toString('yyyy-MM-dd') + " 00:00:00")).getTime() - (new Date(new XDate(array_facturas[index_array_facturas].fecha).toString('yyyy-MM-dd') + " 00:00:00")).getTime())/(1000 * 60 * 60 * 24));

            // var cantidad_registros_detalle = ComprobanteCompraFactory.Detalle_nota_gestion_nota.length + 1;

            var acum_total = 0;

            // for (var i = 0; i < array_facturas.length; i++) {
            //     acum_total = acum_total + array_facturas[i].total_comprobante - array_facturas[i].monto_retencion;
            //     if(array_facturas[i].detalle_nota != null){
            //         if(array_facturas[i].detalle_nota.tipo_nota.id==1){
            //             acum_total = acum_total + array_facturas[i].detalle_nota.precio;
            //         }
            //         else if(array_facturas[i].detalle_nota.tipo_nota.id==2){
            //             acum_total = acum_total - array_facturas[i].detalle_nota.precio;
            //         }
            //     }
                
            // };
            var producto_gesiton_nota = {};
            angular.copy(producto, producto_gesiton_nota);
            ComprobanteCompraFactory.Detalle_nota_gestion_nota.push({
                                                            tipo_nota : detalle_nota.tipo_nota
                                                            , fecha_emision_nota : new XDate(detalle_nota.fecha_emision).toString('yyyy-MM-dd')
                                                            , serie_nota : detalle_nota.serie_nota
                                                            , numero_nota : detalle_nota.numero_nota
                                                            , descripcion_nota : detalle_nota.descripcion_nota
                                                            , precio_nota : detalle_nota.precio_nota
                                                            , producto : producto_gesiton_nota
                                                            , cantidad : detalle_nota.cantidad
                                                            , merma : detalle_nota.merma
                                                        });

            console.log('detalle_nota');
            console.log(ComprobanteCompraFactory.Detalle_nota_gestion_nota);
            
            angular.copy({},ComprobanteCompraFactory.Gestion_nota);
                    angular.copy({},ComprobanteCompraFactory.Producto_seleccionado_gestion_nota);
                    angular.element(nom_producto_gestion_nota_value).val(' ');
            // for (var i = 0; i < ComprobanteCompraFactory.Detalle_nota_gestion_nota.length; i++) {
            //     ComprobanteCompraFactory.Detalle_nota_gestion_nota[i].monto_nota = Math.round((acum_total/cantidad_registros_detalle )* 1000) / 1000;
            // };


            // angular.element(numero_nota).val('');
            // angular.element(fecha_vencimiento_nota).val('');
            return true;
        }



        return ComprobanteCompraFactory;
 
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
