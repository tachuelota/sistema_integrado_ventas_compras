@extends('templates.layout')
@section('title')
Control  Tipo Cliente
@endsection

@section('head')
    <link href="{{ asset('plugins/morris/morris.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('breadcrumb')
    <h1 style="color:#222d32; font-family: arial;">Moneda<small style="color:#222d32; font-family: arial;"> / Factura</small></h1>
    <div class="pull-right">
        <label id="Fecha_Actual"></label>
        <br>
        <label name="Hora_Actual" id="Hora_Actual"></label>
    </div>
@endsection
@section('content')


<div ng-app="myApp" ng-controller="MonedaController as MonedaCtrl">

    <div class=" col-xs-12 col-md-12 col-lg-10">

        <div class="box box-solid">
            <div class="box-header " > 
                <i class="fa fa-list-ul"></i>
                <h3 class="box-title">Moneda</h3>
            </div>
            <div class="box-body ">
                <div class="form-group row">
                    
                    <div  class="col-md-12"> 
                        <table class="table table-striped text-center"  datatable="ng" dt-instance="dtInstance">
                            <thead >
                                <tr>
                                    <th>ITEM</th>
                                    <th>MONEDA</th>
                                    <th>ACCION</th>
                                </tr>
                            </thead>
                            <tbody >
                                <tr ng-repeat="x in MonedaCtrl.moneda | filter: MonedaCtrl.buscar_moneda">
                                    <td>/% $index + 1 %/ </td>
                                    <td>/% x.nombre_moneda %/ </td>
                                    <td>
                                        <a ng-click="MonedaCtrl.edit(x)" class="btn btn-success">
                                            <i class="fa fa-edit" data-toggle="tooltip" title="Modificar"></i>
                                        </a>
                                        <a ng-click="MonedaCtrl.eliminar(x.id)" class="btn btn-danger">
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
              <li ng-click="MonedaCtrl.create()" class=" ">
                <div id="item-box-icon">
                    <i class="fa fa-plus"></i> 
                </div>
                <div id="item-box-text"> REGISTRAR MONEDA</div>
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

    app.controller('MonedaController', function MonedaController(MonedaFactory){
        
        var vm = this;

        vm.moneda = MonedaFactory.Moneda;

        MonedaFactory.getMoneda();

        vm.eliminar = function(id_Moneda){
            MonedaFactory.deleteAttempt(id_Moneda);
        }
        
        vm.create = function(){
            MonedaFactory.create();
        }

        vm.edit = function(Moneda){
            MonedaFactory.edit(Moneda);
        }

    });


    app.factory('MonedaFactory', function MonedaFactory($http, $modal, $filter ) {
         
        MonedaFactory.Moneda_edit = {};

        MonedaFactory.Moneda = [];

        MonedaFactory.getMoneda = function() {
            return $http.get('AdsMoneda/getAllMonedas').success(function(data) {
                console.log(data.datos);
                angular.copy(data.datos, MonedaFactory.Moneda);
            });
        }

        /* ------------------------------Estas dos funciones eliminan datos -----------------------*/
        MonedaFactory.deleteAttempt = function(id) {
            $modal.open( { 
                templateUrl:'templates_angular/deleteAttemp.html', 
                controller: function($scope, $modalInstance, MonedaFactory) {
                    $scope.yes = function() {
                        MonedaFactory.delete(id).then(function() { 
                            $modalInstance.close();
                        });                         
                    }
                }
            });
        }      
        // Delete Request
        MonedaFactory.delete = function(id) {
            return $http.delete('AdsMoneda/' + id).success(function(data) {
                angular.copy(data.datos,MonedaFactory.Moneda);
            });
        }
        /* ------------------------------FIN - Estas dos funciones eliminan datos -----------------------*/
        
        /* Store Request */
        MonedaFactory.create = function(){
            $modal.open({
                templateUrl: 'templates_angular/MonedaController/create.html',
                controller: function($scope, $modalInstance, $filter){
                    $scope.moneda = {};
                    $scope.store = function(){
                        if ( $("#create_form").validationEngine('validate') ) {
                            MonedaFactory.store($scope.moneda);
                            $modalInstance.close();
                        };
                    }
                },
                resolve: {
                    
                }
            });
        }
        
        MonedaFactory.store = function(Moneda) {
            $http.post('AdsMoneda', Moneda).success(function(data){
                angular.copy(data.datos,MonedaFactory.Moneda);
            });
        }

        MonedaFactory.edit = function(moneda){
            console.log(moneda);
            angular.copy(moneda, MonedaFactory.Moneda_edit);
            $modal.open({
                templateUrl: 'templates_angular/MonedaController/editar.html',
                controller: function($scope, $modalInstance, Moneda_edit){
                    $scope.moneda = Moneda_edit;
                    $scope.update = function(){
                        if( $("#edit_form").validationEngine('validate') ){
                            MonedaFactory.update($scope.moneda);
                            $modalInstance.close();
                        }
                    }
                },
                resolve: {
                    Moneda_edit : function(){
                        return MonedaFactory.Moneda_edit;
                    }
                }
            });
        }

        MonedaFactory.update = function(moneda){ 
            $http.put('AdsMoneda/'+moneda.id,moneda).success(function(data){
                angular.copy(data.datos, MonedaFactory.Moneda);
            });
        }
 
        return MonedaFactory;
 
    });
   
</script>

@endsection