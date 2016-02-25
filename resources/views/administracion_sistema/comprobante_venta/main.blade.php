@extends('templates.layout')
@section('title')
Control  Tipo Cliente
@endsection

@section('head')
    <link href="{{ asset('plugins/morris/morris.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('breadcrumb')
    <h1><small></small></h1>
    <ol class="breadcrumb">
        <li><a href="{{asset('/')}}"><i class="fa fa-home"></i> Principal</a></li>
        <li><a href="{{asset('/')}}"><i class="fa fa-fw fa-shopping-cart"></i> Módulo de Venta</a></li>
        <li class="active"><i class="fa fa-fw fa-building-o"></i> Consultar Facturas</li>
    </ol>
@endsection

@section('content')
<div ng-app="myApp" ng-controller="ComprobanteVentaController as VentaCtrl">

    <div class=" col-xs-12 col-md-12 col-lg-11">

        <div class="box box-solid">
            <div class="box-header " > 
                <i class="fa fa-list-ul"></i>
                <h3 class="box-title">Factura de Venta</h3>
            </div>
            <div class="box-body ">
                <div class="form-group row">
                    <div  class="col-md-12"> 
                        <table class="table table-striped text-center"  datatable="ng" dt-instance="dtInstance" style="font-size: 12px;">
                            <thead >
                                <tr>
                                    <th>ITEM</th>
                                    <th>SERIE</th>
                                    <th>CORRELATIVO</th>
                                    <th>CLIENTE</th>
                                    <th>TOTAL</th>
                                    <th>MONEDA</th>
                                    <th>FECHA</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody >
                                <tr ng-repeat="x in VentaCtrl.comprobantes">
                                    <td>/% $index + 1 %/ </td>
                                    <td>/% "000".substring(0, 3 - x.serie_comprobante.length) + x.serie_comprobante %/</td>
                                    <td>/% "00000000".substring(0, 8 - x.numero_comprobante.length) + x.numero_comprobante %/ </td>
                                    <td>/% x.cliente_detalle.cliente.razon_social %/ </td>
                                    <td ng-if="x.moneda.id == 1">/% VentaCtrl.formatNumber(x.total_comprobante, "S/. ") %/ </td>
                                    <td ng-if="x.moneda.id == 2">/% VentaCtrl.formatNumber(x.total_comprobante, "$ ") %/ </td>
                                    <td>/% x.moneda.nombre_moneda %/ </td>
                                    <td>/% x.fecha %/ </td>
                                    <td>
                                        <a href=""  data-toggle="tooltip" title="Asociar Facturas" ng-click="VentaCtrl.modal_asociar(x)"><i class="fa fa-cog fa-2x"></i></a>
                                        <a href="" ng-if="x.cliente_detalle.cliente.agente_retenedor == 'true' && x.serie_retenedor==null" ng-click="VentaCtrl.modal_asociar_retenedor(x)"><i class="fa fa-user-times fa-2x"></i></a>
                                    </td>
                                    <td> 
                                        <a href="" data-toggle="tooltip" title="Detalle de Factura" ng-click="VentaCtrl.edit(x)"><i class="fa fa-search fa-2x"></i></a> 
                                        <a href="" ng-if="x.detalle_pago_pendiente[0].id_condicion_pago == 4" data-toggle="tooltip" title="Asignar Pago" ng-click="VentaCtrl.asignar_pago(x)"><i class="fa fa-dollar fa-2x"></i></a> 
                                    </td>
                                    <td>
                                        <a href="" data-toggle="tooltip" title="Eliminar Factura" ng-click="VentaCtrl.deleteAttempt(x.id)"><i class="fa fa-trash fa-2x"></i></a> 
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>  
        <style>
            
            #aside-right li{
                margin-right: -180px !important;
            }

            #aside-right li:hover {
                margin-right: 0px !important;
                margin-left: -180px !important;
            }
        </style>

        <div id="content-aside-right">
            <ul id="aside-right" class="btn-group-vertical">
              <li onclick="location.href='AdsComprobanteVenta_create'" class=" ">
                <div id="item-box-icon">
                    <i class="fa fa-plus"></i> 
                </div>
                <div id="item-box-text"> REGISTRAR FACTURA</div>
              </li>
            </ul>
        </div>

</div>

 

        
@endsection

@section('foot')

@endsection

@section('script')
<script type="text/javascript">

    var app = angular.module('myApp',[ 'ui.bootstrap','ngRoute','angucomplete-alt','datatables']);
 
    app.config(function($interpolateProvider){
        $interpolateProvider.startSymbol('/%');
        $interpolateProvider.endSymbol('%/');
    });

    app.controller('ComprobanteVentaController', function ComprobanteVentaController(ComprobanteVentaFactory){
        
        var vm = this;

        vm.comprobantes = ComprobanteVentaFactory.ComprobanteVenta;

        ComprobanteVentaFactory.getComprobanteVenta();

        vm.create = function(){
            ComprobanteVentaFactory.create();
        }

        vm.edit = function(scope){
            ComprobanteVentaFactory.edit(scope);
        }

        vm.asignar_pago = function(scope){
            ComprobanteVentaFactory.asignar_pago(scope);
        }

        vm.formatNumber = function(num, simbol){
            
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

        vm.modal_asociar = function(scope){

            ComprobanteVentaFactory.modal_asociar(scope);
        }

        vm.modal_asociar_retenedor = function(scope){

            ComprobanteVentaFactory.modal_asociar_retenedor(scope);
        }

        vm.deleteAttempt = function(id){
            
            swal({   
                    title:  "Eliminar Registro"
                    , text: "¿Desea continuar?"
                    , type: "warning",   showCancelButton: true
                    , confirmButtonColor: "#A5DC86"
                    , confirmButtonText: "Continuar"
                    , closeOnConfirm: true 
                }, 
                function(){
                    ComprobanteVentaFactory.delete(id).then(function(){
                        swal({   
                            title: "Registro Eliminado!"
                            ,   text: "El registro se eliminó con éxito"
                            ,   type: "success"
                            ,   confirmButtonText: "OK" 
                            ,   timer: 2000
                        });
                        
                    });

                });

        }

        ComprobanteVentaFactory.getMedioPago();
        ComprobanteVentaFactory.getCondicionPago();
    });


    app.factory('ComprobanteVentaFactory', function ComprobanteVentaFactory($http, $modal, $filter ) {
         
        ComprobanteVentaFactory.ComprobanteVenta_edit = {};

        ComprobanteVentaFactory.ComprobanteVenta = [];

        ComprobanteVentaFactory.getComprobanteVenta = function() {
        angular.element(div_loader).removeClass('hide');
            return $http.get('AdsComprobanteVenta/getAllComprobantes').success(function(data) {
        angular.element(div_loader).addClass('hide');
                console.log(data.datos);
                angular.copy(data.datos, ComprobanteVentaFactory.ComprobanteVenta);
            });
        }

        /* ------------------------------Estas dos funciones eliminan datos -----------------------*/
        ComprobanteVentaFactory.deleteAttempt = function(id) {
            $modal.open( { 
                templateUrl:'templates_angular/deleteAttemp.html', 
                controller: function($scope, $modalInstance, ComprobanteVentaFactory) {
                    $scope.yes = function() {
                        ComprobanteVentaFactory.delete(id).then(function() { 
                            $modalInstance.close();
                        });                         
                    }
                }
            });
        }      
        // Delete Request
        ComprobanteVentaFactory.delete = function(id) {
        angular.element(div_loader).removeClass('hide');
            return $http.delete('AdsComprobanteVenta/' + id).success(function(data) {
        angular.element(div_loader).addClass('hide');
                swal({   
                        title: "Registro Eliminado!"
                        ,   text: "El registro se eliminó con éxito"
                        ,   type: "success"
                        ,   confirmButtonText: "OK" 
                        ,   timer: 2000
                    });
                angular.copy(data.datos, ComprobanteVentaFactory.ComprobanteVenta);
            });
        }
        /* ------------------------------FIN - Estas dos funciones eliminan datos -----------------------*/
        
        /* Store Request */
        ComprobanteVentaFactory.create = function(){
            $modal.open({
                templateUrl: 'templates_angular/ComprobanteVentaController/create.html',
                controller: function($scope, $modalInstance, $filter){
                    $scope.moneda = {};
                    $scope.store = function(){
                        if ( $("#create_form").validationEngine('validate') ) {
                            ComprobanteVentaFactory.store($scope.moneda);
                            $modalInstance.close();
                        };
                    }
                },
                resolve: {
                    
                }
            });
        }

        ComprobanteVentaFactory.edit = function(scope){
            console.log(scope);
            angular.copy(scope, ComprobanteVentaFactory.ComprobanteVenta_edit);
            $modal.open({
                templateUrl: 'templates_angular/ComprobanteVentaController/visualizar.html',
                controller: function($scope, $modalInstance, Comprobante_edit){
                    $scope.comprobante = Comprobante_edit;
                    /* Crear funcion para la vista */
                    $scope.formatNumber = function(num, simbol){
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
                },
                resolve: {
                    Comprobante_edit : function(){
                        return ComprobanteVentaFactory.ComprobanteVenta_edit;
                    }
                }
            });
        }

        ComprobanteVentaFactory.CondicionesPago = [];
        ComprobanteVentaFactory.MediosPago = [];
        ComprobanteVentaFactory.Detalle_letra = [];
        ComprobanteVentaFactory.Detalle_finanza = [];

        ComprobanteVentaFactory.asignar_pago = function(scope){
            console.log(scope);
            // angular.copy(scope, ComprobanteVentaFactory.ComprobanteVenta_edit);
            $modal.open({
                templateUrl: 'templates_angular/DetallePagoController/asignar_pago.html',
                controller: function($scope, $modalInstance, Comprobante_edit){
                    $scope.finanzas = {};
                    $scope.comprobante = Comprobante_edit;
                    $scope.condiciones_pago = ComprobanteVentaFactory.CondicionesPago;
                    $scope.medios_pago = ComprobanteVentaFactory.MediosPago;
                    $scope.detalles_letra = ComprobanteVentaFactory.Detalle_letra;
                    $scope.detalles_finanza = ComprobanteVentaFactory.Detalle_finanza;

                    $scope.id_comprobante = null;
                    $scope.total_monto_comprobante = 0;
                    $scope.id_detalle_pago_anterior = scope.detalle_pago_pendiente[0].id;
                    $scope.id_comprobante = scope.id;

                    $scope.formatNumber = function(num, simbol){
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

                    $scope.calcular_vencimiento_letra = function(numero_dias, index){
                        var vencimiento = new Date(new Date(scope.fecha + " 00:00:00").getTime() + (numero_dias * 24 * 3600 * 1000));
                        var fec_vencimiento = new XDate(vencimiento).toString('yyyy-MM-dd');
                        $scope.detalles_finanza[index].fecha_vencimiento = fec_vencimiento;
                    }


                    $scope.eliminar_letra = function(index){
                
                        ComprobanteVentaFactory.Detalle_letra.splice(index,1);

                        var cantidad_registros_detalle = ComprobanteVentaFactory.Detalle_letra.length;

                        var total_factura = scope.total_comprobante;

                        for (var i = 0; i < scope.detalle_nota.length; i++) {
                            if(scope.detalle_nota[i].tipo_nota == 1){ //DEBITO
                                total_factura = total_factura + scope.detalle_nota[i].precio;
                            }
                            else if(scope.detalle_nota[i].tipo_nota == 2){ //CREDITO
                                total_factura = total_factura - scope.detalle_nota[i].precio;
                            }
                        };

                        for (var i = 0; i < ComprobanteVentaFactory.Detalle_letra.length; i++) {
                            ComprobanteVentaFactory.Detalle_letra[i].monto_letra = Math.round((total_factura/cantidad_registros_detalle )* 1000) / 1000;
                        };

                        swal({   
                            title: "¡Eliminado!"
                            ,   text: "Se elimino correctamente."
                            ,   type: "success"
                            ,   confirmButtonText: "OK" 
                            ,   timer: 1500
                        });

                    }

                    $scope.agregar_detalle_letra = function(){
                        if($("#form_detalle_letra").validationEngine('validate')){

                            // if(vm.fecha_comprobante != undefined){
                                // ComprobanteVentaFactory.agregar_detalle_letra(vm.finanzas.letra, vm.fecha_comprobante);
                                var detalle_letra = $scope.finanzas.letra;
                                var fecha_comprobante = scope.fecha;
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
                                    fecha_vencimiento_let = new Date(new Date(fecha_comprobante + " 00:00:00").getTime() + (detalle_letra.numero_dias * 24 * 3600 * 1000));

                                }
                                console.log('dias_letra');
                                console.log(dias_letra);
                                // console.log("Fecha final: " + fecha_vencimiento.getDate() + "/" + (fecha_vencimiento.getMonth() + 1) + "/" + fecha_vencimiento.getFullYear());

                                var cantidad_registros_detalle = ComprobanteVentaFactory.Detalle_letra.length + 1;

                                var total_factura = scope.total_comprobante;
                                var aux = 0;

                                for (var i = 0; i < scope.detalle_nota.length; i++) {
                                    if(scope.detalle_nota[i].tipo_nota == 1){ //DEBITO
                                        total_factura = total_factura + scope.detalle_nota[i].precio;
                                    }
                                    else if(scope.detalle_nota[i].tipo_nota == 2){ //CREDITO
                                        total_factura = total_factura - scope.detalle_nota[i].precio;
                                    }
                                };

                                $scope.total_monto_comprobante = total_factura

                                var monto_letra = Math.round((total_factura/cantidad_registros_detalle )* 1000) / 1000;



                                ComprobanteVentaFactory.Detalle_letra.push({
                                                                                numero_letra : detalle_letra.numero_letra
                                                                                , numero_dias : dias_letra
                                                                                , monto_letra : monto_letra
                                                                                , fecha_vencimiento : new XDate(fecha_vencimiento_let).toString('yyyy-MM-dd')

                                                                            });

                                for (var i = 0; i < ComprobanteVentaFactory.Detalle_letra.length; i++) {
                                    ComprobanteVentaFactory.Detalle_letra[i].monto_letra = Math.round((total_factura/cantidad_registros_detalle )* 1000) / 1000;
                                };

                                console.log(ComprobanteVentaFactory.Detalle_letra);


                                // angular.element(numero_letra).val('');
                                // angular.element(fecha_vencimiento_letra).val('');
                                // angular.element(numero_dias).val('');
                                // ComprobanteVentaFactory.Finanzas_create.letra.fecha_vencimiento = null;
                                // ComprobanteVentaFactory.Finanzas_create.letra.numero_dias = null;

                                angular.copy({},$scope.finanzas.letra);

                            // }
                            // else{
                                // alert('Debe seleccionar la Fecha de Emision del Comprobante');
                                // sweetAlert("Error...", "Debe seleccionar la Fecha de Emision del Comprobante", "error");
                            // }
                            
                        }
                    }

                    $scope.store = function(){
                        if(Object.keys($scope.finanzas).length == 0){
                            $scope.finanzas.condicion = {id:null};
                        }

                        if($scope.finanzas.medio == undefined){
                            $scope.finanzas.medio = {id:null};
                        }
                        else {
                            
                            if(!$scope.finanzas.medio.detalle_medio_pago){
                                $scope.finanzas.medio.detalle_medio_pago = null;
                            }
                            if(!$scope.finanzas.medio.fecha_pago){
                                $scope.finanzas.medio.fecha_pago = null;
                            }
                        }
                        for (var i = 0; i < ComprobanteVentaFactory.Detalle_letra.length; i++) {
                            ComprobanteVentaFactory.Detalle_letra[i].numero_dias = ComprobanteVentaFactory.Detalle_finanza[i].numero_dias;
                        };

                        $scope.finanzas.detalles_letra = ComprobanteVentaFactory.Detalle_letra;

                        $scope.finanzas.total = $scope.total_monto_comprobante;
                        $scope.finanzas.id_comprobante = $scope.id_comprobante;
                        $scope.finanzas.id_detalle_pago_anterior = $scope.id_detalle_pago_anterior;

                        var finanzas_create = $scope.finanzas;
                        console.log(finanzas_create);
                        ComprobanteVentaFactory.set_detalle_pago(finanzas_create); 
                        $modalInstance.close();
                    }
                },
                resolve: {
                    Comprobante_edit : function(){
                        return ComprobanteVentaFactory.ComprobanteVenta_edit;
                    }
                }
            });
        }

        ComprobanteVentaFactory.set_detalle_pago = function(finanzas_create){
        angular.element(div_loader).removeClass('hide');
            return $http.post('AdsDetallePago/set_detalle_pago',finanzas_create).success(function(data) {
        angular.element(div_loader).addClass('hide');
                if(data.datos == 'correcto'){
                    swal({   
                            title: "Registro Exitoso!"
                            ,   text: "El registro se realizó con éxito"
                            ,   type: "success"
                            ,   confirmButtonText: "OK" 
                            ,   timer: 2000
                        });
                    ComprobanteVentaFactory.getComprobanteVenta();
                }
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

        ComprobanteVentaFactory.update = function(moneda){ 
        angular.element(div_loader).removeClass('hide');
            $http.put('AdsMoneda/'+moneda.id,moneda).success(function(data){
        angular.element(div_loader).addClass('hide');
                angular.copy(data.datos, ComprobanteVentaFactory.ComprobanteVenta);
            });
        }

        ComprobanteVentaFactory.modal_asociar = function(scope){
            console.log('scope');
            console.log(scope);
            $modal.open( { 
                templateUrl:'templates_angular/ComprobanteVentaController/asociar_compra_servicio.html', 
                controller: function($scope, $modalInstance, ComprobanteVentaFactory) {
                    $scope.comprobante_compra = {};
                    $scope.comprobante_servicio = {};
                    $scope.comprobante_compra.detalles_asociar_compra = [];
                    $scope.comprobante_servicio.detalles_asociar_servicio = [];

                    var cabecera = {};
                    var detalle = [];
                    var cliente = {};
                    var Object_datos_compra = {};
                    var Object_datos_servicio = {};
                    var Array_detalle_compra = [];
                    var Array_detalle_servicio = [];
                    var Array_detalle_final = [];
                    var Array_id_guias = [];
                    var acum_unidades = 0;
                    var acum_peso = 0;

                    $scope.agregar_compra = function(){
        angular.element(div_loader).removeClass('hide');

                        $http.post('AdsComprobanteCompra/getGuiaBySerieNumero', {comprobante_compra:$scope.comprobante_compra})
                            .success(function(data){
        angular.element(div_loader).addClass('hide');
                                console.log('DATOS');
                                console.log(data.datos);

                                if(data.datos == ''){
                                    alert('Esta Factura de Compra no existe.');
                                }
                                else{
                                    console.log($scope.comprobante_compra);
                                    angular.copy(data.datos[0],Object_datos_compra);

                                    var existe_data = 0;
                                    for (i in scope.comprobante_detalle_venta) {
                                        for (j in Object_datos_compra.comprobante_detalle_compra) {
                                            if(scope.comprobante_detalle_venta[i].producto.id == Object_datos_compra.comprobante_detalle_compra[j].producto.id)
                                            {
                                                existe_data = 1;
                                                Array_detalle_compra.push({
                                                                            id_comprobanteVenta : scope.id
                                                                            , id_comprobanteCompra : Object_datos_compra.id
                                                                            , id_comprobanteDetalleCompra : Object_datos_compra.comprobante_detalle_compra[j].id
                                                                            , id_producto : Object_datos_compra.comprobante_detalle_compra[j].producto.id
                                                                            , precio_compra : Object_datos_compra.comprobante_detalle_compra[j].precio_unitario
                                                                            , cantidad_compra : Object_datos_compra.comprobante_detalle_compra[j].unidades
                                                                            , precio_venta : scope.comprobante_detalle_venta[i].precio_unitario
                                                                            , cantidad_venta : scope.comprobante_detalle_venta[i].unidades
                                                                        });
                                            }
                                            
                                        };
                                    };

                                    if (existe_data == 1) {
                                        $scope.comprobante_compra.detalles_asociar_compra.push({serie:$scope.comprobante_compra.serie, numero:$scope.comprobante_compra.numero});
                                    }
                                    else{
                                        $modal.open({
                                            templateUrl: 'templates_angular/ComprobanteVentaController/msj_inexistencia_asociar_compra_servicio.html',
                                            size: 'lg',
                                            windowClass: 'modal-error',
                                            controller: function($scope, $modalInstance){
                                            }
                                        });
                                    }
                                    console.log('Array_detalle_compra');
                                    console.log(Array_detalle_compra);

                                    // id
                                    // id_comprobanteVenta
                                    // id_comprobanteCompra
                                    // id_comprobanteServicio
                                    // id_producto
                                    // precio_compra
                                    // cantidad_compra
                                    // precio_venta
                                    // cantidad_venta
                                    // precio_servicio
                                    // cantidad_servicio


                                    // detalle.push(data.datos[0].guia_remision_detalle);
                                    // Array_id_guias.push(data.datos[0].id);
                                    // angular.copy(data.datos[0].guia_remision_detalle,Array_detalle_final);
                                    // $scope.comprobante_compra.serie_compra = '';
                                    // $scope.comprobante_compra.numero_compra = '';

                                }

                                
                            });

                    }

                    $scope.agregar_servicio = function(){
        angular.element(div_loader).removeClass('hide');

                        $http.post('AdsComprobanteServicio/getGuiaBySerieNumero', {comprobante_servicio:$scope.comprobante_servicio})
                            .success(function(data){
        angular.element(div_loader).addClass('hide');
                                console.log('DATOS');
                                console.log(data.datos);

                                if(data.datos == ''){
                                    alert('Esta Factura de Servicio no existe.');
                                }
                                else{
                                    angular.copy(data.datos[0],Object_datos_servicio);
                                    console.log(Object_datos_servicio);
                                    console.log('RECORRIENDO DETALLES');
                                    var existe_data = 0;

                                    for (i in scope.comprobante_detalle_venta) {
                                        for (j in Object_datos_servicio.comprobante_detalle_servicio) {
                                            if(scope.comprobante_detalle_venta[i].producto.id == Object_datos_servicio.comprobante_detalle_servicio[j].producto.id)
                                            {
                                                existe_data = 1;
                                                Array_detalle_servicio.push({
                                                                            id_comprobanteServicio : Object_datos_servicio.id
                                                                            , id_comprobanteDetalleServicio : Object_datos_servicio.comprobante_detalle_servicio[j].id
                                                                            , id_producto : Object_datos_servicio.comprobante_detalle_servicio[j].producto.id
                                                                            , precio_servicio : Object_datos_servicio.id
                                                                            , cantidad_servicio : Object_datos_servicio.comprobante_detalle_servicio[j].producto.id
                                                                        });
                                            }
                                            
                                        };
                                    };

                                    if (existe_data == 1) {
                                        $scope.comprobante_servicio.detalles_asociar_servicio.push({serie:$scope.comprobante_servicio.serie, numero:$scope.comprobante_servicio.numero});
                                    }
                                    else{
                                        $modal.open({
                                            templateUrl: 'templates_angular/ComprobanteVentaController/msj_inexistencia_asociar_compra_servicio.html',
                                            size: 'lg',
                                            windowClass: 'modal-error',
                                            controller: function($scope, $modalInstance){
                                            }
                                        });
                                    }

                                    console.log('Array_detalle_servicio');
                                    console.log(Array_detalle_servicio);

                                }

                                
                            });

                    }

                    $scope.asociar = function(){
        angular.element(div_loader).removeClass('hide');
                        $http.post('AdsAsociarComprobante', {comprobante_compra:Array_detalle_compra, comprobante_servicio:Array_detalle_servicio})
                            .success(function(data){
        angular.element(div_loader).addClass('hide');
                                if(data.datos=='correcto'){
                                    $modalInstance.close();
                                    
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

                }
            });
        }

        ComprobanteVentaFactory.modal_asociar_retenedor = function(scope){
            console.log('scope');
            console.log(scope);
            $modal.open( { 
                templateUrl:'templates_angular/ComprobanteVentaController/asociar_retenedor.html', 
                controller: function($scope, $modalInstance, ComprobanteVentaFactory) {
                    $scope.comprobante_retenedor = {};

                    $scope.asociar = function(){
                        var serie = $scope.comprobante_retenedor.serie;
                        var numero = $scope.comprobante_retenedor.numero;
                        

        angular.element(div_loader).removeClass('hide');
                        $http.put('AdsAsociarComprobante/'+scope.id,$scope.comprobante_retenedor).success(function(data){
        angular.element(div_loader).addClass('hide');
                            // angular.copy(data.datos, ColorFactory.Color);
                            if(data.datos=='correcto'){
                                $modalInstance.close();
                                
                                ComprobanteVentaFactory.getComprobanteVenta();
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

                }
            });
        }

 
        return ComprobanteVentaFactory;
 
    });
   
</script>

@endsection