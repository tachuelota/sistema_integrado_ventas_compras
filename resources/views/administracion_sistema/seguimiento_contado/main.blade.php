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
        <li><a href="{{asset('/')}}"><i class="fa fa-fw fa-shopping-cart"></i> Módulo de Cobranzas</a></li>
        <li class="active"><i class="fa fa-fw fa-building-o"></i> Listado al Contado</li>
    </ol>
@endsection

@section('content')
<div ng-app="myApp" ng-controller="DetallePagoController as LetraCtrl">

    <div class=" col-xs-12 col-md-12 col-lg-11">

        <div class="box box-solid">
            <div class="box-header " > 
                <i class="fa fa-list-ul"></i>
                <h3 class="box-title">Seguimiento al Contado</h3>
            </div>
            <div class="box-body ">
                <div class="form-group row">
                    <div  class="col-md-12"> 
                        <table class="table table-striped text-center"  datatable="ng" dt-instance="dtInstance" style="font-size: 12px;">
                            <thead >
                                <tr>
                                    <th>ITEM</th>
                                    <th>CLIENTE</th>
                                    <th># SERIE</th>
                                    <th># COMPROBANTE</th>
                                    <th>MONTO FACTURA</th>
                                    <th>FECHA EMISION</th>
                                    <th style="width:20%;">ESTADO</th>
                                    <th>PAGADO</th>
                                </tr>
                            </thead>
                            <tbody >
                                <tr ng-repeat="x in LetraCtrl.letras">
                                    <td>/% $index + 1 %/ </td>
                                    <td>/% x.comprobante_venta.cliente_detalle.cliente.razon_social %/</td>
                                    <td>/% "000".substring(0, 3 - x.comprobante_venta.serie_comprobante.length) + x.comprobante_venta.serie_comprobante %/</td>
                                    <td>/% "00000000".substring(0, 8 - x.comprobante_venta.numero_comprobante.length) + x.comprobante_venta.numero_comprobante %/ </td>
                                    <!-- <td>/% x.monto_letra %/ </td> -->
                                    <!-- <td ng-if="x.moneda.id == 1">/% LetraCtrl.formatNumber(x.total_comprobante, "S/. ") %/ </td> -->
                                    <!-- <td ng-if="x.moneda.id == 2">/% LetraCtrl.formatNumber(x.total_comprobante, "$ ") %/ </td> -->
<!-- 
                                    <td ng-if="x.comprobante_venta.detalle_nota.length == 0 && x.comprobante_venta.moneda.id == 1">/% LetraCtrl.formatNumber(x.comprobante_venta.total_comprobante, "S/. ") %/ </td>
                                    <td ng-if="x.comprobante_venta.detalle_nota.length == 0 && x.comprobante_venta.moneda.id == 2">/% LetraCtrl.formatNumber(x.comprobante_venta.total_comprobante, "$ ") %/ </td>
                                    <td ng-if="x.comprobante_venta.detalle_nota.length != 0 && x.comprobante_venta.moneda.id == 1">/% LetraCtrl.formatNumber(x.comprobante_venta.detalle_nota[0].total_nota, "S/. ") %/ </td>
                                    <td ng-if="x.comprobante_venta.detalle_nota.length != 0 && x.comprobante_venta.moneda.id == 2">/% LetraCtrl.formatNumber(x.comprobante_venta.detalle_nota[0].total_nota, "$ ") %/ </td>
                                     -->
                                    <td ng-if="x.comprobante_venta.detalle_nota.length == 0 && x.comprobante_venta.moneda.id == 1">/% LetraCtrl.formatNumber(x.comprobante_venta.total_comprobante - x.comprobante_venta.monto_retencion, "S/. ") %/ </td>
                                    <td ng-if="x.comprobante_venta.detalle_nota.length == 0 && x.comprobante_venta.moneda.id == 2">/% LetraCtrl.formatNumber(x.comprobante_venta.total_comprobante - x.comprobante_venta.monto_retencion, "$ ") %/ </td>
                                    <td ng-if="x.comprobante_venta.detalle_nota.length != 0 && x.comprobante_venta.moneda.id == 1">/% LetraCtrl.formatNumber(x.comprobante_venta.detalle_nota[(x.comprobante_venta.detalle_nota.length) - 1].total_nota - x.comprobante_venta.monto_retencion, "S/. ") %/ </td>
                                    <td ng-if="x.comprobante_venta.detalle_nota.length != 0 && x.comprobante_venta.moneda.id == 2">/% LetraCtrl.formatNumber(x.comprobante_venta.detalle_nota[(x.comprobante_venta.detalle_nota.length) - 1].total_nota - x.comprobante_venta.monto_retencion, "$ ") %/ </td>

                                    <td>/% x.comprobante_venta.fecha %/ </td>
                                    <td> 

                                        <div class="input-group">

                                            <select id="estado_letra" class="form-control validate[required]" ng-model="LetraCtrl.detalle_letra[$index].estado" ng-init="LetraCtrl.detalle_letra[$index].estado.id = x.id_medio_pago" ng-options="item as item.nombre_medio_pago for item in LetraCtrl.estados_letra track by item.id" style="font-size: 12px;height: 25px;">
                                                <option value="">-- Seleccione --</option>
                                            </select>
                                            <a href="" class="input-group-addon" ng-click="LetraCtrl.estado_change(x,LetraCtrl.detalle_letra[$index].estado.id)" style="font-size: 12px;">
                                                <i class="fa fa-edit fa-2x"></i></a> 
                                            </a>
                                        </div>
                                        
                                    </td>
                                    <td ng-if="x.id_medio_pago != 1">
                                        <a href="" class="fa fa-check fa-lg text-success"></a>
                                        <!-- <a href="" ng-click="LetraCtrl.edit(x)"><i class="fa fa-search fa-2x"></i></a>  -->
                                    </td>
                                    <td ng-if="x.id_medio_pago == 1">
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

        <!-- <div id="content-aside-right">
            <ul id="aside-right" class="btn-group-vertical">
              <li onclick="location.href='AdsComprobanteVenta_create'" class=" ">
                <div id="item-box-icon">
                    <i class="fa fa-plus"></i> 
                </div>
                <div id="item-box-text"> REGISTRAR FACTURA</div>
              </li>
            </ul>
        </div> -->

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

    app.controller('DetallePagoController', function DetallePagoController(SeguimientoLetraFactory){
        
        var vm = this;

        vm.letras = SeguimientoLetraFactory.SeguimientoLetra;
        vm.estados_letra = SeguimientoLetraFactory.EstadosLetra;

        SeguimientoLetraFactory.getContados();
        SeguimientoLetraFactory.getBancos();
        SeguimientoLetraFactory.getEstadoContado();

        vm.create = function(){
            SeguimientoLetraFactory.create();
        }

        vm.edit = function(scope){
            SeguimientoLetraFactory.edit(scope);
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

            SeguimientoLetraFactory.modal_asociar(scope);
        }

        vm.estado_change = function(scope,id_estado){
            SeguimientoLetraFactory.CambiarEstado(scope,id_estado);
        }


    });


    app.factory('SeguimientoLetraFactory', function SeguimientoLetraFactory($http, $modal, $filter ) {
         
        SeguimientoLetraFactory.SeguimientoLetra_edit = {};
        SeguimientoLetraFactory.Cuenta = [];
        SeguimientoLetraFactory.Banco = [];

        SeguimientoLetraFactory.SeguimientoLetra = [];
        SeguimientoLetraFactory.EstadosLetra = [];

        SeguimientoLetraFactory.getContados = function() {
            return $http.get('AdsDetallePago/getAllContado').success(function(data) {
                console.log('datos contado');
                console.log(data.datos);
                angular.copy(data.datos, SeguimientoLetraFactory.SeguimientoLetra);
            });
        }
        
        SeguimientoLetraFactory.getEstadoContado = function() {
            return $http.get('AdsComprobanteVenta/getAllEstadoContado').success(function(data) {
                angular.copy(data.datos, SeguimientoLetraFactory.EstadosLetra);
            });
        }
        SeguimientoLetraFactory.getCuentasByBanco = function(id_banco) {
            return $http.get('AdsCuenta/getAllCuentasByBanco/'+id_banco).success(function(data) {
                angular.copy(data.datos, SeguimientoLetraFactory.Cuenta);
            });
        }

        SeguimientoLetraFactory.getBancos = function() {
            return $http.get('AdsBanco/getAllBancos').success(function(data) {
                console.log(data.datos);
                angular.copy(data.datos, SeguimientoLetraFactory.Banco);
            });
        }


        SeguimientoLetraFactory.deleteAttempt = function(id) {
            $modal.open( { 
                templateUrl:'templates_angular/deleteAttemp.html', 
                controller: function($scope, $modalInstance, SeguimientoLetraFactory) {
                    $scope.yes = function() {
                        SeguimientoLetraFactory.delete(id).then(function() { 
                            $modalInstance.close();
                        });                         
                    }
                }
            });
        }      

        SeguimientoLetraFactory.delete = function(id) {
            return $http.delete('AdsMoneda/' + id).success(function(data) {
                angular.copy(data.datos,SeguimientoLetraFactory.SeguimientoLetra);
            });
        }

        SeguimientoLetraFactory.create = function(){
            $modal.open({
                templateUrl: 'templates_angular/DetallePagoController/create.html',
                controller: function($scope, $modalInstance, $filter){
                    $scope.moneda = {};
                    $scope.store = function(){
                        if ( $("#create_form").validationEngine('validate') ) {
                            SeguimientoLetraFactory.store($scope.moneda);
                            $modalInstance.close();
                        };
                    }
                },
                resolve: {
                    
                }
            });
        }

        SeguimientoLetraFactory.edit = function(scope){
            console.log(scope);
            angular.copy(scope, SeguimientoLetraFactory.SeguimientoLetra_edit);
            $modal.open({
                templateUrl: 'templates_angular/DetallePagoController/visualizar.html',
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
                        return SeguimientoLetraFactory.SeguimientoLetra_edit;
                    }
                }
            });
        }

        SeguimientoLetraFactory.update = function(scope,id_estado){ 
            return $http.put('AdsDetallePago/'+id_estado,scope).success(function(data){
                if(data.datos == 'correcto'){
                    SeguimientoLetraFactory.getContados();
                }
            });
        }


        SeguimientoLetraFactory.CambiarEstado = function(scope,id_estado) {
            SeguimientoLetraFactory.scope_modal = {};
            $modal.open( { 
                templateUrl:'templates_angular/DetallePagoController/cambiar_estado_contado.html', 
                controller: function($scope, $modalInstance, SeguimientoLetraFactory) {
                    $scope.datos = SeguimientoLetraFactory.scope_modal;
                    
                    $scope.bancos = SeguimientoLetraFactory.Banco;
                    $scope.cuentas = SeguimientoLetraFactory.Cuenta;

                    if(id_estado == 1){
                        $scope.boolean_estado = 'PENDIENTE';
                    }

                    $scope.mostrar_cuentas = function(id_banco){
                        SeguimientoLetraFactory.getCuentasByBanco(id_banco);
                    }

                    $scope.yes = function() {
                        if($('#form_modal').validationEngine('validate')){
                            
                            if(id_estado == 7){
                                scope.detalle_estado = $scope.datos.cuenta_seleccionado;
                            }
                            scope.tipo_pago="contado";
                            scope.datos = $scope.datos;
                            SeguimientoLetraFactory.update(scope,id_estado).then(function() { 
                                $modalInstance.close();
                            }); 
                        }                         
                    }
                }
            });
        }  

        return SeguimientoLetraFactory;
 
    });
   
</script>

@endsection