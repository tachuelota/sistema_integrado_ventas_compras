@extends('templates.layout')
@section('title')
Control  Tipo Cliente
@endsection

@section('head')
    <link href="{{ asset('plugins/morris/morris.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('breadcrumb')
    <!----><h1><small></small></h1>
    <ol class="breadcrumb">
        <li><a href="{{asset('/')}}"><i class="fa fa-home"></i> Principal</a></li>
        <li><a href="{{asset('/')}}"><i class="fa fa-fw fa-shopping-cart"></i> Módulo de Ventas</a></li>
        <li><a href="{{asset('/')}}"><i class="fa fa-fw fa-shopping-cart"></i> Transporte</a></li>
        <li class="active"><i class="fa fa-fw fa-building-o"></i> Unidad Transporte</li>
    </ol>
@endsection

@section('content')
<div ng-app="myApp" ng-controller="UnidadMedidaController as UnidadTransporteCtrl">

    <div class=" col-xs-12 col-md-12 col-lg-10">

        <div class="box box-solid">
            <div class="box-header " > 
                <i class="fa fa-list-ul"></i>
                <h3 class="box-title">Unidad de Transporte</h3>
            </div>
            <div class="box-body ">
                <div class="form-group row">
                    
                    <div  class="col-md-12"> 
                        <table class="table table-striped text-center"  datatable="ng" dt-instance="dtInstance">
                            <thead >
                                <tr>
                                    <th>ITEM</th>
                                    <th>MARCA</th>
                                    <th>PLACA</th>
                                    <th>CIMTC</th>
                                    <th>EMPRESA DE TRANSPORTE</th>
                                    <th>ACCION</th>
                                </tr>
                            </thead>
                            <tbody >
                                <tr ng-repeat="x in UnidadTransporteCtrl.unidad_transporte | filter: UnidadTransporteCtrl.buscar_unidadTransporte">
                                    <td>/% $index + 1 %/ </td>
                                    <td>/% x.marca %/ </td>
                                    <td>/% x.placa %/ </td>
                                    <td>/% x.ci_mtc %/ </td>
                                    <td>/% x.transporte.razon_social %/ </td>
                                    <td>
                                        <a ng-click="UnidadTransporteCtrl.edit(x)" class="btn btn-success">
                                            <i class="fa fa-edit" data-toggle="tooltip" title="Modificar"></i>
                                        </a>
                                        <a ng-click="UnidadTransporteCtrl.eliminar(x.id)" class="btn btn-danger">
                                            <i class="fa fa-times" data-toggle="tooltip" title="Eliminar Registro"></i>
                                        </a> 
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
              <li ng-click="UnidadTransporteCtrl.create()" class=" ">
                <div id="item-box-icon">
                    <i class="fa fa-plus"></i> 
                </div>
                <div id="item-box-text"> REGISTRAR UNIDAD</div>
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

    app.controller('UnidadMedidaController', function UnidadMedidaController(UnidadTransporteFactory){
        
        var vm = this;

        vm.unidad_transporte = UnidadTransporteFactory.UnidadTransporte;

        UnidadTransporteFactory.getUnidadTransporte();
        UnidadTransporteFactory.getTransportes(); /* Para llenar el comboBox */

        vm.eliminar = function(id_unidadTransporte){
            UnidadTransporteFactory.deleteAttempt(id_unidadTransporte);
        }
        
        vm.create = function(){

            UnidadTransporteFactory.create();
        }

        vm.edit = function(unidadTransporte){
            UnidadTransporteFactory.edit(unidadTransporte);
        }
    });


    app.factory('UnidadTransporteFactory', function UnidadTransporteFactory($http, $modal, $filter ) {
         
        UnidadTransporteFactory.unidadTransporte_edit = {};

        UnidadTransporteFactory.UnidadTransporte = [];
        UnidadTransporteFactory.EmpresasTransporte = []; /* Para llenar el comboBox */

        UnidadTransporteFactory.getUnidadTransporte = function() {
            return $http.get('AdsUnidadTransporte/getAllUnidadTransportes').success(function(data) {
                angular.copy(data.datos, UnidadTransporteFactory.UnidadTransporte);
            });
        }

        /* Para llenar el comboBox */
        UnidadTransporteFactory.getTransportes = function() {
            return $http.get('AdsTransporte/getAllTransportes').success(function(data) {
                console.log(data.datos);
                angular.copy(data.datos, UnidadTransporteFactory.EmpresasTransporte);
            });
        } 

        /* ------------------------------Estas dos funciones eliminan datos -----------------------*/
        UnidadTransporteFactory.deleteAttempt = function(id) {
            $modal.open( { 
                templateUrl:'templates_angular/deleteAttemp.html', 
                controller: function($scope, $modalInstance, UnidadTransporteFactory) {
                    $scope.yes = function() {
                        UnidadTransporteFactory.delete(id).then(function() { 
                            $modalInstance.close();
                        });                         
                    }
 
                }
 
            });
        }      
        // Delete Request
        UnidadTransporteFactory.delete = function(id) {
            return $http.delete('AdsUnidadTransporte/' + id).success(function(data) {
                angular.copy(data.datos,UnidadTransporteFactory.UnidadTransporte);
            });
        }
        /* ------------------------------FIN - Estas dos funciones eliminan datos -----------------------*/
        
        // Store Request
        UnidadTransporteFactory.create = function(){
            $modal.open({
                templateUrl: 'templates_angular/UnidadTransporteController/create.html',
                controller: function($scope, $modalInstance, $filter, EmpresasTransporte){
                    $scope.unidadTransporte = {};
                    $scope.empresasTransporte = EmpresasTransporte;
                    $scope.store = function(){
                        if ( $("#create_form").validationEngine('validate') ) {
                            UnidadTransporteFactory.store($scope.unidadTransporte);
                            $modalInstance.close();
                        };
                    }
                },
                resolve: {
                    EmpresasTransporte : function(){
                        return UnidadTransporteFactory.EmpresasTransporte;
                    }
                }
            });
        }
        
        UnidadTransporteFactory.store = function(unidadTransporte) {
            $http.post('AdsUnidadTransporte', unidadTransporte).success(function(data){
                angular.copy(data.datos,UnidadTransporteFactory.UnidadTransporte);
            });
        }

        UnidadTransporteFactory.edit = function(unidadTransporte){
            console.log(unidadTransporte);
            angular.copy(unidadTransporte, UnidadTransporteFactory.unidadTransporte_edit);
            $modal.open({
                templateUrl: 'templates_angular/unidadTransporteController/editar.html',
                controller: function($scope, $modalInstance, unidadTransporte_edit,EmpresasTransporte){
                    $scope.unidadTransporte = unidadTransporte_edit;
                    $scope.empresasTransporte = EmpresasTransporte; 
                    $scope.update = function(){
                        if( $("#edit_form").validationEngine('validate') ){
                            UnidadTransporteFactory.update($scope.unidadTransporte);
                            $modalInstance.close();
                        }
                    }
                },
                resolve: {
                    unidadTransporte_edit : function(){
                        return UnidadTransporteFactory.unidadTransporte_edit;
                    },
                    EmpresasTransporte : function(){
                        return UnidadTransporteFactory.EmpresasTransporte;
                    }
                }
            });
        }

        UnidadTransporteFactory.update = function(unidadTransporte){ 
            $http.put('AdsUnidadTransporte/'+unidadTransporte.id,unidadTransporte).success(function(data){
                angular.copy(data.datos, UnidadTransporteFactory.UnidadTransporte);
            });
        }
 
        return UnidadTransporteFactory;
 
    });
   
</script>

@endsection