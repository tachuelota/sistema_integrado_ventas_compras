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
        <li><a href="{{asset('/')}}"><i class="fa fa-fw fa-shopping-cart"></i> Módulo de Compras</a></li>
        <li class="active"><i class="fa fa-fw fa-building-o"></i> Consultar Facturas</li>
    </ol>
@endsection

@section('content')
<div ng-app="myApp" ng-controller="ComprobanteCompraController as CompraCtrl">

    <div class=" col-xs-12 col-md-12 col-lg-11">

        <div class="box box-solid">
            <div class="box-header " > 
                <i class="fa fa-list-ul"></i>
                <h3 class="box-title">Factura de Compra</h3>
            </div>
            <div class="box-body ">
                <div class="form-group row">
                    
                    <div  class="col-md-12"> 
                        <table class="table table-striped text-center"  datatable="ng" dt-instance="dtInstance" style="font-size: 12px;">
                            <thead >
                                <tr>
                                    <th>ITEM</th>
                                    <!-- <th>ID</th> -->
                                    <th>SERIE</th>
                                    <th>CORRELATIVO</th>
                                    <th>PROVEEDOR</th>
                                    <th>TOTAL</th>
                                    <th>MONEDA</th>
                                    <th>FECHA</th>
                                    <th>ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody >
                                <tr ng-repeat="x in CompraCtrl.comprobantes">
                                    <td>/% $index + 1 %/ </td>
                                    <!-- <td>/% x.id %/ </td> -->
                                    <td>/% "000".substring(0, 3 - x.serie_comprobante.length) + x.serie_comprobante %/</td>
                                    <td>/% "00000000".substring(0, 8 - x.numero_comprobante.length) + x.numero_comprobante %/ </td>
                                    <td>/% x.proveedor.razon_social %/ </td>
                                    <td ng-if="x.moneda.id == 1">/% CompraCtrl.formatNumber(x.total_comprobante, "S/. ") %/ </td>
                                    <td ng-if="x.moneda.id == 2">/% CompraCtrl.formatNumber(x.total_comprobante, "$ ") %/ </td>
                                    <td>/% x.moneda.nombre_moneda %/ </td>
                                    <td>/% x.fecha %/ </td>
                                    <td> 
                                        <a href="" ng-click="CompraCtrl.edit(x)" data-toggle="tooltip" title="Ver Detalle"><i class="fa fa-search fa-2x"></i></a> 
                                        <a href="" ng-if="x.detalle_pago_pendiente[0].id_condicion_pago == 4" data-toggle="tooltip" title="Asignar Pago" ng-click="CompraCtrl.asignar_pago(x)"><i class="fa fa-dollar fa-2x"></i></a> 
                                        <a href="" ng-click="CompraCtrl.delete(x.id)" data-toggle="tooltip" title="Eliminar" ><i class="fa fa-trash fa-2x"></i></a> 
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
              <li onclick="location.href='AdsComprobanteCompra_create'" class=" ">
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

    app.controller('ComprobanteCompraController', function ComprobanteCompraController(ComprobanteCompraFactory){
        
        var vm = this;

        vm.comprobantes = ComprobanteCompraFactory.ComprobanteCompra;

        ComprobanteCompraFactory.getComprobanteCompra();

        vm.create = function(){
            ComprobanteCompraFactory.create();
        }

        vm.edit = function(scope){
            ComprobanteCompraFactory.edit(scope);
        }

        vm.delete = function(id){

            swal({   
                    title:  "Eliminar Registro"
                    , text: "¿Desea continuar?"
                    , type: "warning",   showCancelButton: true
                    , confirmButtonColor: "#A5DC86"
                    , confirmButtonText: "Continuar"
                    , closeOnConfirm: true 
                }, 
                function(){
                    ComprobanteCompraFactory.delete(id).then(function(){
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

        vm.asignar_pago = function(scope){
            ComprobanteCompraFactory.asignar_pago(scope);
        }

        ComprobanteCompraFactory.getMedioPago();
        ComprobanteCompraFactory.getCondicionPago();
    });


    app.factory('ComprobanteCompraFactory', function ComprobanteCompraFactory($http, $modal, $filter ) {
         
        ComprobanteCompraFactory.ComprobanteCompra_edit = {};

        ComprobanteCompraFactory.ComprobanteCompra = [];

        ComprobanteCompraFactory.getComprobanteCompra = function() {
        angular.element(div_loader).removeClass('hide');
            return $http.get('AdsComprobanteCompra/getAllComprobantes').success(function(data) {
        angular.element(div_loader).addClass('hide');
                console.log(data.datos);
                angular.copy(data.datos, ComprobanteCompraFactory.ComprobanteCompra);
            });
        }

        /* ------------------------------Estas dos funciones eliminan datos -----------------------*/
        ComprobanteCompraFactory.deleteAttempt = function(id) {
            $modal.open( { 
                templateUrl:'templates_angular/deleteAttemp.html', 
                controller: function($scope, $modalInstance, ComprobanteCompraFactory) {
                    $scope.yes = function() {
                        ComprobanteCompraFactory.delete(id).then(function() { 
                            $modalInstance.close();
                        });                         
                    }
                }
            });
        }      
        // Delete Request
        ComprobanteCompraFactory.delete = function(id) {
        angular.element(div_loader).removeClass('hide');
            return $http.delete('AdsComprobanteCompra/' + id).success(function(data) {
        angular.element(div_loader).addClass('hide');
                angular.copy(data.datos, ComprobanteCompraFactory.ComprobanteCompra);
            });
        }
        /* ------------------------------FIN - Estas dos funciones eliminan datos -----------------------*/
        
        /* Store Request */
        ComprobanteCompraFactory.create = function(){
            $modal.open({
                templateUrl: 'templates_angular/ComprobanteCompraController/create.html',
                controller: function($scope, $modalInstance, $filter){
                    $scope.moneda = {};
                    $scope.store = function(){
                        if ( $("#create_form").validationEngine('validate') ) {
                            ComprobanteCompraFactory.store($scope.moneda);
                            $modalInstance.close();
                        };
                    }
                },
                resolve: {
                    
                }
            });
        }
        
        ComprobanteCompraFactory.edit = function(scope){
            console.log(scope);
            angular.copy(scope, ComprobanteCompraFactory.ComprobanteCompra_edit);
            $modal.open({
                templateUrl: 'templates_angular/ComprobanteCompraController/visualizar.html',
                controller: function($scope, $modalInstance, Comprobante_edit){
                    $scope.comprobante = Comprobante_edit;
                },
                resolve: {
                    Comprobante_edit : function(){
                        return ComprobanteCompraFactory.ComprobanteCompra_edit;
                    }
                }
            });
        }

        ComprobanteCompraFactory.update = function(moneda){ 
        angular.element(div_loader).removeClass('hide');
            $http.put('AdsMoneda/'+moneda.id,moneda).success(function(data){
        angular.element(div_loader).addClass('hide');
                angular.copy(data.datos, ComprobanteCompraFactory.ComprobanteCompra);
            });
        }
 
        ComprobanteCompraFactory.CondicionesPago = [];
        ComprobanteCompraFactory.MediosPago = [];
        ComprobanteCompraFactory.Detalle_letra = [];
        ComprobanteCompraFactory.Detalle_finanza = [];

        ComprobanteCompraFactory.asignar_pago = function(scope){
            console.log(scope);
            // angular.copy(scope, ComprobanteCompraFactory.ComprobanteVenta_edit);
            $modal.open({
                templateUrl: 'templates_angular/DetallePagoController/asignar_pago.html',
                controller: function($scope, $modalInstance, Comprobante_edit){
                    $scope.finanzas = {};
                    $scope.comprobante = Comprobante_edit;
                    $scope.condiciones_pago = ComprobanteCompraFactory.CondicionesPago;
                    $scope.medios_pago = ComprobanteCompraFactory.MediosPago;
                    $scope.detalles_letra = ComprobanteCompraFactory.Detalle_letra;
                    $scope.detalles_finanza = ComprobanteCompraFactory.Detalle_finanza;

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
                
                        ComprobanteCompraFactory.Detalle_letra.splice(index,1);

                        var cantidad_registros_detalle = ComprobanteCompraFactory.Detalle_letra.length;

                        var total_factura = scope.total_comprobante;

                        for (var i = 0; i < scope.detalle_nota.length; i++) {
                            if(scope.detalle_nota[i].tipo_nota == 1){ //DEBITO
                                total_factura = total_factura + scope.detalle_nota[i].precio;
                            }
                            else if(scope.detalle_nota[i].tipo_nota == 2){ //CREDITO
                                total_factura = total_factura - scope.detalle_nota[i].precio;
                            }
                        };

                        for (var i = 0; i < ComprobanteCompraFactory.Detalle_letra.length; i++) {
                            ComprobanteCompraFactory.Detalle_letra[i].monto_letra = Math.round((total_factura/cantidad_registros_detalle )* 1000) / 1000;
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
                                // ComprobanteCompraFactory.agregar_detalle_letra(vm.finanzas.letra, vm.fecha_comprobante);
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

                                var cantidad_registros_detalle = ComprobanteCompraFactory.Detalle_letra.length + 1;

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



                                ComprobanteCompraFactory.Detalle_letra.push({
                                                                                numero_letra : detalle_letra.numero_letra
                                                                                , numero_dias : dias_letra
                                                                                , monto_letra : monto_letra
                                                                                , fecha_vencimiento : new XDate(fecha_vencimiento_let).toString('yyyy-MM-dd')

                                                                            });

                                for (var i = 0; i < ComprobanteCompraFactory.Detalle_letra.length; i++) {
                                    ComprobanteCompraFactory.Detalle_letra[i].monto_letra = Math.round((total_factura/cantidad_registros_detalle )* 1000) / 1000;
                                };

                                console.log(ComprobanteCompraFactory.Detalle_letra);


                                // angular.element(numero_letra).val('');
                                // angular.element(fecha_vencimiento_letra).val('');
                                // angular.element(numero_dias).val('');
                                // ComprobanteCompraFactory.Finanzas_create.letra.fecha_vencimiento = null;
                                // ComprobanteCompraFactory.Finanzas_create.letra.numero_dias = null;

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
                        for (var i = 0; i < ComprobanteCompraFactory.Detalle_letra.length; i++) {
                            ComprobanteCompraFactory.Detalle_letra[i].numero_dias = ComprobanteCompraFactory.Detalle_finanza[i].numero_dias;
                        };

                        $scope.finanzas.detalles_letra = ComprobanteCompraFactory.Detalle_letra;

                        $scope.finanzas.total = $scope.total_monto_comprobante;
                        $scope.finanzas.id_comprobante = $scope.id_comprobante;
                        $scope.finanzas.id_detalle_pago_anterior = $scope.id_detalle_pago_anterior;

                        var finanzas_create = $scope.finanzas;
                        console.log(finanzas_create);
                        ComprobanteCompraFactory.set_detalle_pago(finanzas_create); 
                        $modalInstance.close();
                    }
                },
                resolve: {
                    Comprobante_edit : function(){
                        return ComprobanteCompraFactory.ComprobanteVenta_edit;
                    }
                }
            });
        }

        ComprobanteCompraFactory.set_detalle_pago = function(finanzas_create){
        angular.element(div_loader).removeClass('hide');
            return $http.post('AdsDetallePago/set_detalle_pago_compra',finanzas_create).success(function(data) {
        angular.element(div_loader).addClass('hide');
                if(data.datos == 'correcto'){
                    swal({   
                            title: "Registro Exitoso!"
                            ,   text: "El registro se realizó con éxito"
                            ,   type: "success"
                            ,   confirmButtonText: "OK" 
                            ,   timer: 2000
                        });
                    ComprobanteCompraFactory.getComprobanteCompra();
                }
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
                angular.copy(data.datos, ComprobanteCompraFactory.CondicionesPago);
            });
        }
        return ComprobanteCompraFactory;
 
    });
   
</script>

@endsection