@extends('templates.layout')
@section('title')
Control  Tipo Cliente
@endsection

@section('head')
    <link href="{{ asset('plugins/morris/morris.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('breadcrumb')
    <h1 style="color:#222d32; font-family: arial;">Factura de Compra<small style="color:#222d32; font-family: arial;"> / Factura</small></h1>
    <div class="pull-right">
        <label id="Fecha_Actual"></label>
        <br>
        <label name="Hora_Actual" id="Hora_Actual"></label>
    </div>
@endsection
@section('content')


<div ng-app="myApp" ng-controller="ComprobanteCompraController as CompraCtrl">

    <div class=" col-xs-12 col-md-12 col-lg-10">

        <div class="box box-solid">
            <div class="box-header " > 
                <i class="fa fa-list-ul"></i>
                <h3 class="box-title">Factura de Compra</h3>
            </div>
            <div class="box-body ">
                <div class="form-group row">
                    
                    <div  class="col-md-12"> 
                        <table class="table table-striped text-center"  datatable="ng" dt-instance="dtInstance">
                            <thead >
                                <tr>
                                    <th>ITEM</th>
                                    <th>SERIE</th>
                                    <th>NUMERO</th>
                                    <th>TOTAL</th>
                                    <th>FECHA</th>
                                    <th>VER DETALLE</th>
                                </tr>
                            </thead>
                            <tbody >
                                <tr ng-repeat="x in CompraCtrl.comprobantes">
                                    <td>/% $index + 1 %/ </td>
                                    <td>/% x.serie_comprobante %/ </td>
                                    <td>/% x.numero_comprobante %/ </td>
                                    <td>/% x.total_comprobante %/ </td>
                                    <td>/% x.fecha %/ </td>
                                    <td> 
                                        <a href="" ng-click="CompraCtrl.edit(x)"><i class="fa fa-search fa-2x"></i></a> 
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

    });


    app.factory('ComprobanteCompraFactory', function ComprobanteCompraFactory($http, $modal, $filter ) {
         
        ComprobanteCompraFactory.ComprobanteCompra_edit = {};

        ComprobanteCompraFactory.ComprobanteCompra = [];

        ComprobanteCompraFactory.getComprobanteCompra = function() {
            return $http.get('AdsComprobanteCompra/getAllComprobantes').success(function(data) {
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
            return $http.delete('AdsMoneda/' + id).success(function(data) {
                angular.copy(data.datos,ComprobanteCompraFactory.ComprobanteCompra);
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
            $http.put('AdsMoneda/'+moneda.id,moneda).success(function(data){
                angular.copy(data.datos, ComprobanteCompraFactory.ComprobanteCompra);
            });
        }
 
        return ComprobanteCompraFactory;
 
    });
   
</script>

@endsection