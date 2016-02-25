@extends('templates.layout')

@section('title')
Tipo Cliente
@endsection

@section('head')
    <link href="{{ asset('plugins/morris/morris.css') }}" rel="stylesheet" type="text/css" />
     <style>
      #selectable .ui-selecting {
        background: #ccc;
      }
      #selectable .ui-selected {
        background: #999;
      }
    </style>
@endsection

@section('breadcrumb')
    <h1>Tipo Cliente<small> / Configuracion</small></h1>
    <div class="pull-right">
        <label id="Fecha_Actual"></label>
        <br>
        <label name="Hora_Actual" id="Hora_Actual"></label>
        
    </div>
@endsection

@section('content')
<div ng-app="myApp" ng-controller="TipoClienteController">
    <form name="form" >  
        <div class="col-md-12 col-lg-10 ">
            <div class="box box-solid ">
                <div class="box-header"> 
                    <i class="fa fa-users"></i>
                    <h3 class="box-title">Tipos de Cliente</h3>
                </div>
                <form name="form" novalidate>
                <div class="box-body">  
                    
                    <div class="box-body table">
                        <div class="form-group-row">

                            <div class="col-xs-2 ">
                                <label>Buscar Tipo Cliente</label>
                            </div>
                            <div class="col-xs-6">
                                <input ng-model="search" type="number" validate-on-blur name="campo"  required class="form-control"/>
                                <span class="help-block" ng-show="!form.$pristine && form.campo.$invalid">El campo es requerido</span>
                            </div> 
                            <button class="btn btn-success" ng-disabled="form.$invalid">Buscar</button>
                            <div class="form-group row">
                                <div  class="col-md-12">       
                                <table class="table table-striped text-center" >
                                    <thead >
                                    <tr>
                                        <th>Descripcion</th>
                                        <th>Detalle</th>
                                        <th>Operaciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="x in tiposCliente">
                                            <td>/% x.s_DescripcionTipoCliente %/ </td>
                                            <td>/% x.s_DetalleTipoCliente %/ </td>
                                            <td>
                                                <button ng-click="edit(x)" style="background-color:#8c8988; border:1px; color:#fff; " class="btn"> <i class="fa fa-edit" data-toggle="tooltip" title="Modificar"></i> </button>
                                                <button ng-click="eliminar(x.id)" style="background-color:#222d32; color:#fff; " class="btn"> <i class="fa fa-times" data-toggle="tooltip" title="Eliminar Registro"></i></button> 
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
                </form>   
            </div>  
        </div>
    </form>
    





@endsection

@section('foot')

@endsection

@section('script')
<script type="text/javascript">
    $( "#selectable" ).selectable();

    var app = angular.module('myApp',[ 'ui.bootstrap','ngRoute','angucomplete-alt']);
 
    app.config(function($interpolateProvider){
        $interpolateProvider.startSymbol('/%');
        $interpolateProvider.endSymbol('%/');
    });
 
    app.factory('TipoClienteFactory', function TipoClienteFactory($http, $modal ) {
        
        // For When Dealing with a Single Object
        TipoClienteFactory.TipoCliente= {}; //
        TipoClienteFactory.TipoCliente_edit = {};
         TipoClienteFactory.TipoCliente_create = {};
 
        TipoClienteFactory.tiposCliente = [];
         // Retrieve Tipo Locals
        TipoClienteFactory.getTiposCliente = function() {
            return $http.get('AdsTipoCliente/Listar').success(function(data) {
                
                // Refresh Data
                TipoClienteFactory.refreshData(data.datos);
            });
        }      

        TipoClienteFactory.deleteAttempt = function(id) {
             $modal.open( { 
                template: '<div class="modal-header"><h3 class="modal-title">Confirmaci&oacute;n de eliminaci&oacute;n<small><i class="fa fa-close pull-right" style="cursor:pointer;" ng-click="$dismiss()"></i></small></h3></div><div class="modal-body"><p>¿Esta seguro de eliminar?</p></div><div class="modal-footer"><button class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Delete" ng-click="yes()">Yes</button><button class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Cancel" ng-click="$dismiss()">No</button></div>', 
                controller: function($scope, $modalInstance, TipoClienteFactory) {
                    $scope.yes = function() {
 
                        TipoClienteFactory.delete(id).then(function() { 
                            $modalInstance.close();
                        });                         
                   
                    }
 
                }
 
            } );
        }  
   
        // Delete Request
        TipoClienteFactory.delete = function(id) {
            return $http.delete('AdsTipoCliente/' + id).success(function(data) {
                // Refresh Data
                TipoClienteFactory.refreshData(data.datos);
            });
        }


        // Store Request
        TipoClienteFactory.store = function(data) {
             $http.post('AdsTipoCliente', data)
                .success(function(data){
                   TipoClienteFactory.refreshData(data.datos);
                });
        }

        TipoClienteFactory.storeAttemp = function(TipoCliente){
            angular.copy(TipoCliente, TipoClienteFactory.TipoCliente_create);

            $modal.open({
                templateUrl: 'templates_angular/TipoClienteController/create.html',
                controller: function($scope, $modalInstance, TipoCliente_create){
                    $scope.TipoCliente = TipoCliente_create;
                    
                    $scope.store = function(){
                        TipoClienteFactory.store($scope.TipoCliente);
                        $modalInstance.close();
                    }

                },
                resolve: {
                    TipoCliente_create : function(){
                        return TipoClienteFactory.TipoCliente_create;
                    }
                }

            });


        }

        TipoClienteFactory.edit = function(TipoCliente){
            angular.copy(TipoCliente, TipoClienteFactory.TipoCliente_edit);

            $modal.open({
                templateUrl: 'templates_angular/TipoClienteController/editar.html',
                controller: function($scope, $modalInstance, TipoCliente_edit){
                    $scope.TipoCliente = TipoCliente_edit;
                    
                    $scope.update = function(){
                        TipoClienteFactory.update($scope.TipoCliente);
                        $modalInstance.close();
                    }

                },
                resolve: {
                    TipoCliente_edit : function(){
                        return TipoClienteFactory.TipoCliente_edit;
                    }
                }
            });
        }

        TipoClienteFactory.update = function(TipoCliente){ 
            $http.put('AdsTipoCliente/'+TipoCliente.id,TipoCliente).success(function(data){
                TipoClienteFactory.refreshData(data.datos);
            });
        }
 
        TipoClienteFactory.refreshData = function(data)
        {
            angular.copy(data, TipoClienteFactory.tiposCliente);
        }

        return TipoClienteFactory;
 
    });

    app.controller('TipoClienteController', function TipoClienteController(TipoClienteFactory){
  
        var vm = this;

        vm.tiposCliente = TipoClienteFactory.tiposCliente;
 
        TipoClienteFactory.getTiposCliente();
 
        vm.eliminar = function(id_detalle){
            TipoClienteFactory.deleteAttempt(id_detalle);
        }
 
        vm.agregar = function(){
           TipoClienteFactory.store(vm.tipo_cliente);
           vm.tipo_cliente={};           
        }

        vm.edit = function(TipoCliente){
            TipoClienteFactory.edit(TipoCliente);
        } 

        vm.storeAttemp = function(){
            TipoClienteFactory.storeAttemp();
        }
 
    });





</script>

@endsection