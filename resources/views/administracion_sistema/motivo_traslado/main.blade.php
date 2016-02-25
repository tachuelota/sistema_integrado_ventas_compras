@extends('templates.layout')
@section('title')
Motivo de Traslado
@endsection

@section('head')
    <link href="{{ asset('plugins/morris/morris.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('breadcrumb')
    <h1 style="color:#222d32; font-family: arial;">Motivo de Traslado</h1>
    <div class="pull-right">
        <label id="Fecha_Actual"></label>
        <br>
        <label name="Hora_Actual" id="Hora_Actual"></label>
    </div>
@endsection
@section('content')


<div ng-app="myApp" ng-controller="MotivoTrasladoController as MotivoTrasladoCtrl">
    
    <div class=" col-xs-12 col-md-12 col-lg-10">
        <div class="box box-solid">
            <div class="box-header " > 
                <i class="fa fa-list-ul"></i>
                <h3 class="box-title">Motivo de Traslado</h3>
            </div>
            <div class="box-body ">
                <div class="form-group row">
                    <div  class="col-md-12"> 
                        <table class="table table-striped text-center"  datatable="ng" dt-instance="dtInstance">
                            <thead >
                                <tr>
                                    <th>ITEM</th>
                                    <th>MOTIVO DE TRASLADO</th>
                                    <th>ACCION</th>
                                </tr>
                            </thead>
                            <tbody >
                                <tr ng-repeat="x in MotivoTrasladoCtrl.motivo_traslado">
                                    <td>/% $index + 1 %/ </td>
                                    <td>/% x.nombre_motivoTraslado %/ </td>
                                    <td>
                                        <a ng-click="MotivoTrasladoCtrl.edit(x)" class="btn btn-success">
                                            <i class="fa fa-edit" data-toggle="tooltip" title="Modificar"></i>
                                        </a>
                                        <a ng-click="MotivoTrasladoCtrl.eliminar(x.id)" class="btn btn-danger">
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
            <li ng-click="MotivoTrasladoCtrl.create()" class=" ">
                <div id="item-box-icon">
                    <i class="fa fa-plus"></i> 
                </div>
                <div id="item-box-text"> REGISTRAR MOTIVO DE TRASLADO</div>
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

    app.controller('MotivoTrasladoController', function MotivoTrasladoController(MotivoTrasladoFactory){
        
        var vm = this; /* Hace referencia a todo el scope */

        vm.motivo_traslado = MotivoTrasladoFactory.MotivoTraslado;

        MotivoTrasladoFactory.getAllMotivoTraslado();

        vm.eliminar = function(id_motivoTraslado){
            MotivoTrasladoFactory.deleteAttempt(id_motivoTraslado);
        }
        
        vm.create = function(){
            MotivoTrasladoFactory.create();
        }

        vm.edit = function(unidadMedida){
            MotivoTrasladoFactory.edit(unidadMedida);
        }

    });


    app.factory('MotivoTrasladoFactory', function MotivoTrasladoFactory($http, $modal, $filter ) {
         
        MotivoTrasladoFactory.motivoTraslado_edit = {};

        MotivoTrasladoFactory.MotivoTraslado = [];

        MotivoTrasladoFactory.getAllMotivoTraslado = function() {
            return $http.get('AdsMotivoTraslado/getAllMotivoTraslado').success(function(data) {
                angular.copy(data.datos, MotivoTrasladoFactory.MotivoTraslado );
            });
        }


        MotivoTrasladoFactory.deleteAttempt = function(id) {
            $modal.open( { 
                templateUrl:'templates_angular/deleteAttemp.html', 
                controller: function($scope, $modalInstance, MotivoTrasladoFactory) {
                    $scope.yes = function() {
                        MotivoTrasladoFactory.delete(id).then(function() { 
                            $modalInstance.close();
                        });                         
                    }
 
                }
 
            });
        }      


        MotivoTrasladoFactory.delete = function(id) {
            return $http.delete('AdsMotivoTraslado/' + id).success(function(data) {
                angular.copy(data.datos,MotivoTrasladoFactory.MotivoTraslado);
            });
        }


        MotivoTrasladoFactory.create = function(){
            $modal.open({
                templateUrl: 'templates_angular/MotivoTrasladoController/create.html',
                controller: function($scope, $modalInstance, $filter){
                    $scope.motivoTraslado = {};
                    $scope.store = function(){
                        if( $("#create_form").validationEngine('validate') ) {
                            MotivoTrasladoFactory.store($scope.motivoTraslado);
                            $modalInstance.close();
                        };
                    }
                },
                resolve: {
                }
            });
        }
        
        MotivoTrasladoFactory.store = function(motivoTraslado) {
            $http.post('AdsMotivoTraslado', motivoTraslado).success(function(data){
                angular.copy(data.datos,MotivoTrasladoFactory.MotivoTraslado);
            });
        }

        MotivoTrasladoFactory.edit = function(motivoTraslado){
            console.log(motivoTraslado);
            angular.copy(motivoTraslado, MotivoTrasladoFactory.motivoTraslado_edit);
            $modal.open({
                templateUrl: 'templates_angular/MotivoTrasladoController/editar.html',
                controller: function($scope, $modalInstance, motivoTraslado_edit){
                    $scope.motivoTraslado = motivoTraslado_edit;
                    $scope.update = function(){
                        if( $("#edit_form").validationEngine('validate') ){
                            MotivoTrasladoFactory.update($scope.motivoTraslado);
                            $modalInstance.close();
                        }
                    }
                },
                resolve: {
                    motivoTraslado_edit : function(){
                        return MotivoTrasladoFactory.motivoTraslado_edit;
                    }
                }
            });
        }

        MotivoTrasladoFactory.update = function(personalTransporte){ 
            $http.put('AdsMotivoTraslado/'+personalTransporte.id,personalTransporte).success(function(data){
                angular.copy(data.datos, MotivoTrasladoFactory.MotivoTraslado);
            });
        }

        return MotivoTrasladoFactory;
 
    });
    
</script>

@endsection