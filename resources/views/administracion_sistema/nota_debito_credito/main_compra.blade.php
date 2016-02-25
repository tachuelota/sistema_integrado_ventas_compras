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
        <li class="active"><i class="fa fa-fw fa-building-o"></i> Listado Notas</li>
    </ol>
@endsection

@section('content')
<div ng-app="myApp" ng-controller="AdsDetalleNotaController as NotaCtrl">

    <div class=" col-xs-12 col-md-12 col-lg-11">

        <div class="box box-solid">
            <div class="box-header " > 
                <i class="fa fa-list-ul"></i>
                <h3 class="box-title">Listado Notas</h3>
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
                                    <th>TIPO NOTA</th>
                                    <th>MONEDA</th>
                                    <th>FECHA</th>
                                    <th>MONTO NOTA</th>
                                    <th></th>

                                </tr>
                            </thead>
                            <tbody >
                                <tr ng-repeat="x in NotaCtrl.notas">
                                    <td>/% $index + 1 %/ </td>
                                    <td>/% "000".substring(0, 3 - x.serie_nota.length) + x.serie_nota %/</td>
                                    <td>/% "00000000".substring(0, 8 - x.numero_nota.length) + x.numero_nota %/ </td>
                                    <td>/% x.tipo_nota.nombre_tipo_nota %/ </td>
                                    <td>/% x.moneda.nombre_moneda %/ </td>
                                    <td>/% x.fecha %/ </td>
                                    <td ng-if="x.moneda.id == 1">/% NotaCtrl.formatNumber(x.precio, "S/. ") %/ </td>
                                    <td ng-if="x.moneda.id == 2">/% NotaCtrl.formatNumber(x.precio, "$ ") %/ </td>
                                    <td>
                                        <a href=""  data-toggle="tooltip" title="Asociar con Factura" ng-click="NotaCtrl.modal_asociar(x)"><i class="fa fa-cog fa-2x"></i></a>
                                    </td>
                                    <!-- <td> 
                                        <a href="" data-toggle="tooltip" title="Detalle de Factura" ng-click="NotaCtrl.edit(x)"><i class="fa fa-search fa-2x"></i></a> 
                                    </td>
                                    <td>
                                        <a href="" data-toggle="tooltip" title="Eliminar Factura" ng-click="NotaCtrl.deleteAttempt(x.id)"><i class="fa fa-trash fa-2x"></i></a> 
                                    </td> -->
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

    app.controller('AdsDetalleNotaController', function AdsDetalleNotaController(DetalleNotaFactory){
        
        var vm = this;

        vm.notas = DetalleNotaFactory.Nota;

        DetalleNotaFactory.getNotas();

        vm.create = function(){
            DetalleNotaFactory.create();
        }

        vm.edit = function(scope){
            DetalleNotaFactory.edit(scope);
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

            DetalleNotaFactory.modal_asociar(scope);
        }

        vm.deleteAttempt = function(id){

            DetalleNotaFactory.deleteAttempt(id);
        }

    });


    app.factory('DetalleNotaFactory', function DetalleNotaFactory($http, $modal, $filter ) {
         
        DetalleNotaFactory.Nota_edit = {};

        DetalleNotaFactory.Nota = [];

        DetalleNotaFactory.getNotas = function() {
        angular.element(div_loader).removeClass('hide');
            return $http.get('AdsDetalleNota/getAllComprobantesCompra').success(function(data) {
        angular.element(div_loader).addClass('hide');
                console.log(data.datos);
                angular.copy(data.datos, DetalleNotaFactory.Nota);
            });
        }

        /* ------------------------------Estas dos funciones eliminan datos -----------------------*/
        DetalleNotaFactory.deleteAttempt = function(id) {
            $modal.open( { 
                templateUrl:'templates_angular/deleteAttemp.html', 
                controller: function($scope, $modalInstance, DetalleNotaFactory) {
                    $scope.yes = function() {
                        DetalleNotaFactory.delete(id).then(function() { 
                            $modalInstance.close();
                        });                         
                    }
                }
            });
        }      
        // Delete Request
        DetalleNotaFactory.delete = function(id) {
        angular.element(div_loader).removeClass('hide');
            return $http.delete('AdsComprobanteVenta/' + id).success(function(data) {
        angular.element(div_loader).addClass('hide');
                angular.copy(data.datos, DetalleNotaFactory.Nota);
            });
        }
        /* ------------------------------FIN - Estas dos funciones eliminan datos -----------------------*/
        
        /* Store Request */
        DetalleNotaFactory.create = function(){
            $modal.open({
                templateUrl: 'templates_angular/AdsDetalleNotaController/create.html',
                controller: function($scope, $modalInstance, $filter){
                    $scope.moneda = {};
                    $scope.store = function(){
                        if ( $("#create_form").validationEngine('validate') ) {
                            DetalleNotaFactory.store($scope.moneda);
                            $modalInstance.close();
                        };
                    }
                },
                resolve: {
                    
                }
            });
        }

        DetalleNotaFactory.edit = function(scope){
            console.log(scope);
            angular.copy(scope, DetalleNotaFactory.Nota_edit);
            $modal.open({
                templateUrl: 'templates_angular/AdsDetalleNotaController/visualizar.html',
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
                        return DetalleNotaFactory.Nota_edit;
                    }
                }
            });
        }

        DetalleNotaFactory.update = function(moneda){ 
        angular.element(div_loader).removeClass('hide');
            $http.put('AdsMoneda/'+moneda.id,moneda).success(function(data){
        angular.element(div_loader).addClass('hide');
                angular.copy(data.datos, DetalleNotaFactory.Nota);
            });
        }

        DetalleNotaFactory.modal_asociar = function(scope){
            $modal.open( { 
                templateUrl:'templates_angular/DetalleNotaController/asociar_comprobante_compra.html', 
                controller: function($scope, $modalInstance) {
                    $scope.factura = {};
                    $scope.asociar = function(){

                        $http.post('AdsComprobanteCompra/getFacturaBySerieNumero', {comprobante_compra:$scope.factura})
                            .success(function(data){

                                if(data.datos == ''){
                                    sweetAlert("Error", "Esta Factura de Compra no existe", "error");
                                }
                                else{

                                    $http.post('AdsDetalleNota/asociar_factura', {nota:scope, comprobante:data.datos[0], tipo_comprobante: 'compra'})
                                        .success(function(response){

                                            DetalleNotaFactory.getNotas();

                                            swal({   
                                                    title: "Registro exitoso!"
                                                    ,   text: "El registro se realizó con éxito"
                                                    ,   type: "success"
                                                    ,   confirmButtonText: "OK" 
                                                    ,   timer: 2000
                                                });

                                            $modalInstance.close();
                                        });
                                    
                                    

                                }

                                
                            });

                    }
                }
            });
        }

        DetalleNotaFactory.modal_asociar_retenedor = function(scope){
            console.log('scope');
            console.log(scope);
            $modal.open( { 
                templateUrl:'templates_angular/AdsDetalleNotaController/asociar_retenedor.html', 
                controller: function($scope, $modalInstance, DetalleNotaFactory) {
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
                                
                                DetalleNotaFactory.getComprobanteVenta();
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

 
        return DetalleNotaFactory;
 
    });
   
</script>

@endsection