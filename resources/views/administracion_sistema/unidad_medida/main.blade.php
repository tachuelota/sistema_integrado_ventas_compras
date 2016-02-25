@extends('templates.layout')
@section('title')
Control  Tipo Cliente
@endsection

@section('head')
    <link href="{{ asset('plugins/morris/morris.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('breadcrumb')
    <h1 style="color:#222d32; font-family: arial;">Unidad de Medida<small style="color:#222d32; font-family: arial;"> / Transportistas</small></h1>
    <div class="pull-right">
        <label id="Fecha_Actual"></label>
        <br>
        <label name="Hora_Actual" id="Hora_Actual"></label>
    </div>
@endsection
@section('content')


<div ng-app="myApp" ng-controller="UnidadMedidaController as UnidadMedidaCtrl">
    <div class=" col-xs-12 col-md-12 col-lg-10">
        

        <div class="box box-solid">
            <div class="box-header " > 
                <i class="fa fa-list-ul"></i>
                <h3 class="box-title">Unidad de Medida</h3>
            </div>
            <div class="box-body ">
                <div class="form-group row">
                    
                    <div  class="col-md-12"> 
                        <table class="table table-striped text-center"  datatable="ng" dt-instance="dtInstance">
                            <thead >
                                <tr>
                                    <th>ITEM</th>
                                    <th>UNIDAD DE MEDIDA</th>
                                    <th>ACCION</th>
                                </tr>
                            </thead>
                            <tbody >
                                <tr ng-repeat="x in UnidadMedidaCtrl.unidad_medida">
                                    <td>/% $index + 1 %/ </td>
                                    <td>/% x.nombre_unidad_medida %/ </td>
                                    <td>
                                        <a ng-click="UnidadMedidaCtrl.edit(x)" class="btn btn-success">
                                            <i class="fa fa-edit" data-toggle="tooltip" title="Modificar"></i>
                                        </a>
                                        <a ng-click="UnidadMedidaCtrl.eliminar(x.id)" class="btn btn-danger">
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
                margin-right: -260px !important;
            }

            #aside-right li:hover {
                margin-right: 0px !important;
                margin-left: -260px !important;
            }
        </style>

        <div id="content-aside-right">
            <ul id="aside-right" class="btn-group-vertical">
              <li ng-click="UnidadMedidaCtrl.create()" class=" ">
                <div id="item-box-icon">
                    <i class="fa fa-plus"></i> 
                </div>
                <div id="item-box-text"> REGISTRAR UNIDAD DE MEDIDA</div>
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

    app.controller('UnidadMedidaController', function UnidadMedidaController(UnidadMedidaFactory){
        
        var vm = this; /* Hace referencia a todo el scope */

        vm.unidad_medida = UnidadMedidaFactory.UnidadMedida;

        UnidadMedidaFactory.getAllUnidadMedida();

        vm.eliminar = function(id_unidadMedida){
            UnidadMedidaFactory.deleteAttempt(id_unidadMedida);
        }
        
        vm.create = function(){
            UnidadMedidaFactory.create();
        }

        vm.edit = function(unidadMedida){
            UnidadMedidaFactory.edit(unidadMedida);
        }

    });


    app.factory('UnidadMedidaFactory', function UnidadMedidaFactory($http, $modal, $filter ) {
         
        UnidadMedidaFactory.unidadMedida_edit = {};

        UnidadMedidaFactory.UnidadMedida = [];

        UnidadMedidaFactory.getAllUnidadMedida = function() {

            return $http.get('AdsUnidadMedida/getAllUnidadMedida').success(function(data) {
                angular.copy(data.datos, UnidadMedidaFactory.UnidadMedida );
            });
        } 


        UnidadMedidaFactory.deleteAttempt = function(id) {
            $modal.open( { 
                templateUrl:'templates_angular/deleteAttemp.html', 
                controller: function($scope, $modalInstance, UnidadMedidaFactory) {
                    $scope.yes = function() {
                        UnidadMedidaFactory.delete(id).then(function() { 
                            $modalInstance.close();
                        });                         
                    }
 
                }
 
            });
        }      


        UnidadMedidaFactory.delete = function(id) {
            return $http.delete('AdsUnidadMedida/' + id).success(function(data) {
                angular.copy(data.datos,UnidadMedidaFactory.UnidadMedida);
            });
        }


        UnidadMedidaFactory.create = function(){
            $modal.open({
                templateUrl: 'templates_angular/UnidadMedidaController/create.html',
                controller: function($scope, $modalInstance, $filter){
                    $scope.unidadMedida = {};

                    $scope.store = function(){
                        if( $("#create_form").validationEngine('validate') ) {
                            UnidadMedidaFactory.store($scope.unidadMedida);
                            $modalInstance.close();
                        };
                    }
                },
                resolve: {
                }
            });
        }
        
        UnidadMedidaFactory.store = function(unidadMedida) {
            $http.post('AdsUnidadMedida', unidadMedida).success(function(data){
                angular.copy(data.datos,UnidadMedidaFactory.UnidadMedida);
            });
        }

        UnidadMedidaFactory.edit = function(peronsalTransporte){
            console.log(peronsalTransporte);
            angular.copy(peronsalTransporte, UnidadMedidaFactory.unidadMedida_edit);
            $modal.open({
                templateUrl: 'templates_angular/UnidadMedidaController/editar.html',
                controller: function($scope, $modalInstance, unidadMedida_edit){
                    $scope.unidadMedida = unidadMedida_edit;
                    
                    $scope.update = function(){
                        if( $("#edit_form").validationEngine('validate') ){
                            UnidadMedidaFactory.update($scope.unidadMedida);
                            $modalInstance.close();
                        }
                    }
                },
                resolve: {
                    unidadMedida_edit : function(){
                        return UnidadMedidaFactory.unidadMedida_edit;
                    }
                }
            });
        }

        UnidadMedidaFactory.update = function(personalTransporte){ 
            $http.put('AdsUnidadMedida/'+personalTransporte.id,personalTransporte).success(function(data){
                angular.copy(data.datos, UnidadMedidaFactory.UnidadMedida);
            });
        }
 
        return UnidadMedidaFactory;
 
    });
    
</script>

@endsection