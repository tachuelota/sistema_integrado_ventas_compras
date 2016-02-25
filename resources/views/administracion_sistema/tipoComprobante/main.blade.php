@extends('templates.layout')
@section('title')
Control  Tipo Cliente
@endsection

@section('head')
    <link href="{{ asset('plugins/morris/morris.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('breadcrumb')
    <h1 style="color:#222d32; font-family: arial;">Tipo de Comprobante<small style="color:#222d32; font-family: arial;"> / Factura</small></h1>
    <div class="pull-right">
        <label id="Fecha_Actual"></label>
        <br>
        <label name="Hora_Actual" id="Hora_Actual"></label>
    </div>
@endsection
@section('content')


<div ng-app="myApp" ng-controller="TipoComprobanteController as TipoComprobanteCtrl">

    <div class=" col-xs-12 col-md-12 col-lg-10">

        <div class="box box-solid">
            <div class="box-header " > 
                <i class="fa fa-list-ul"></i>
                <h3 class="box-title">Tipo de Comprobante</h3>
            </div>
            <div class="box-body ">
                <div class="form-group row">
                    
                    <div  class="col-md-12"> 
                        <table class="table table-striped text-center"  datatable="ng" dt-instance="dtInstance">
                            <thead >
                                <tr>
                                    <th>ITEM</th>
                                    <th>TIPO DE COMPROBANTE</th>
                                    <th>ACCION</th>
                                </tr>
                            </thead>
                            <tbody >
                                <tr ng-repeat="x in TipoComprobanteCtrl.tipoComprobante | filter: TipoComprobanteCtrl.buscar_tipoComprobante">
                                    <td>/% $index + 1 %/ </td>
                                    <td>/% x.nombre_tipoComprobante %/ </td>
                                    <td>
                                        <a ng-click="TipoComprobanteCtrl.edit(x)" class="btn btn-success">
                                            <i class="fa fa-edit" data-toggle="tooltip" title="Modificar"></i>
                                        </a>
                                        <a ng-click="TipoComprobanteCtrl.eliminar(x.id)" class="btn btn-danger">
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
              <li ng-click="TipoComprobanteCtrl.create()" class=" ">
                <div id="item-box-icon">
                    <i class="fa fa-plus"></i> 
                </div>
                <div id="item-box-text"> REGISTRAR TIPO COMPROBANTE</div>
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

    app.controller('TipoComprobanteController', function TipoComprobanteController(TipoComprobanteFactory){
        
        var vm = this;

        vm.tipoComprobante = TipoComprobanteFactory.TipoComprobante;

        TipoComprobanteFactory.getTipoComprobante();

        vm.eliminar = function(id_TipoComprobante){
            TipoComprobanteFactory.deleteAttempt(id_TipoComprobante);
        }
        
        vm.create = function(){
            TipoComprobanteFactory.create();
        }

        vm.edit = function(TipoComprobante){
            TipoComprobanteFactory.edit(TipoComprobante);
        }

    });


    app.factory('TipoComprobanteFactory', function TipoComprobanteFactory($http, $modal, $filter ) {
         
        TipoComprobanteFactory.TipoComprobante_edit = {};

        TipoComprobanteFactory.TipoComprobante = [];

        TipoComprobanteFactory.getTipoComprobante = function() {
            return $http.get('AdsTipoComprobante/getAllTipoComprobantes').success(function(data) {
                console.log(data.datos);
                angular.copy(data.datos, TipoComprobanteFactory.TipoComprobante);
            });
        }

        /* ------------------------------Estas dos funciones eliminan datos -----------------------*/
        TipoComprobanteFactory.deleteAttempt = function(id) {
            $modal.open( { 
                templateUrl:'templates_angular/deleteAttemp.html', 
                controller: function($scope, $modalInstance, TipoComprobanteFactory) {
                    $scope.yes = function() {
                        TipoComprobanteFactory.delete(id).then(function() { 
                            $modalInstance.close();
                        });                         
                    }
                }
            });
        }      
        // Delete Request
        TipoComprobanteFactory.delete = function(id) {
            return $http.delete('AdsTipoComprobante/' + id).success(function(data) {
                angular.copy(data.datos,TipoComprobanteFactory.TipoComprobante);
            });
        }
        /* ------------------------------FIN - Estas dos funciones eliminan datos -----------------------*/
        
        /* Store Request */
        TipoComprobanteFactory.create = function(){
            $modal.open({
                templateUrl: 'templates_angular/TipoComprobanteController/create.html',
                controller: function($scope, $modalInstance, $filter){
                    $scope.TipoComprobante = {};
                    $scope.store = function(){
                        if ( $("#create_form").validationEngine('validate') ) {
                            TipoComprobanteFactory.store($scope.TipoComprobante);
                            $modalInstance.close();
                        };
                    }
                },
                resolve: {
                    
                }
            });
        }
        
        TipoComprobanteFactory.store = function(TipoComprobante) {
            $http.post('AdsTipoComprobante', TipoComprobante).success(function(data){
                angular.copy(data.datos,TipoComprobanteFactory.TipoComprobante);
            });
        }

        TipoComprobanteFactory.edit = function(tipoComprobante){
            console.log(tipoComprobante);
            angular.copy(tipoComprobante, TipoComprobanteFactory.TipoComprobante_edit);
            $modal.open({
                templateUrl: 'templates_angular/TipoComprobanteController/editar.html',
                controller: function($scope, $modalInstance, TipoComprobante_edit){
                    $scope.tipoComprobante = TipoComprobante_edit;
                    $scope.update = function(){
                        if( $("#edit_form").validationEngine('validate') ){
                            TipoComprobanteFactory.update($scope.tipoComprobante);
                            $modalInstance.close();
                        }
                    }
                },
                resolve: {
                    TipoComprobante_edit : function(){
                        return TipoComprobanteFactory.TipoComprobante_edit;
                    }
                }
            });
        }

        TipoComprobanteFactory.update = function(tipoComprobante){ 
            $http.put('AdsTipoComprobante/'+tipoComprobante.id,tipoComprobante).success(function(data){
                angular.copy(data.datos, TipoComprobanteFactory.TipoComprobante);
            });
        }
 
        return TipoComprobanteFactory;
 
    });
   
</script>

@endsection