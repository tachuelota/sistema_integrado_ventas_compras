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
        <li class="active"><i class="fa fa-fw fa-building-o"></i> Proveedor</li>
    </ol>
@endsection


@section('content')
<div ng-app="myApp" ng-controller="ProveedorController as ProveedorCtrl">

    <div class=" col-xs-12 col-md-12 col-lg-11">

        <div class="box box-solid">
            <div class="box-header " > 
                <i class="fa fa-list-ul"></i>
                <h3 class="box-title">Provedores</h3>
            </div>
            <div class="box-body ">
                <div class="form-group row">
                    
                    <div  class="col-md-12"> 
                        <table class="table table-striped text-center" datatable="ng" dt-instance="dtInstance">
                            <thead >
                                <tr>
                                    <th>ITEM</th>
                                    <th>RAZÓN SOCIAL</th>
                                    <th>RUC</th>
                                    <th>DIRECCIÓN</th>
                                    <th>TELÉFONO</th>
                                    <th>E-MAIL</th>
                                    <th style="width : 150px;">ACCION</th>
                                </tr>
                            </thead>
                            <tbody >
                                <tr ng-repeat="x in ProveedorCtrl.proveedor | filter: ProveedorCtrl.buscar_proveedor">
                                    <td>/% $index + 1 %/ </td>
                                    <td>/% x.razon_social %/ </td>
                                    <td>/% x.ruc %/ </td>
                                    <td>/% x.direccion %/ </td>
                                    <td>/% x.telefono %/ </td>
                                    <td>/% x.email %/ </td>
                                    <td>
                                        <a ng-click="ProveedorCtrl.edit(x)" class="btn btn-success">
                                            <i class="fa fa-edit" data-toggle="tooltip" title="Modificar"></i>
                                        </a>
                                        <a ng-click="ProveedorCtrl.eliminar(x.id)" class="btn btn-danger">
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
                margin-right: -210px !important;
            }

            #aside-right li:hover {
                margin-right: 0px !important;
                margin-left: -210px !important;
            }
        </style>

        <div id="content-aside-right">
            <ul id="aside-right" class="btn-group-vertical">
              <li ng-click="ProveedorCtrl.create()" class=" ">
                <div id="item-box-icon">
                    <i class="fa fa-plus"></i> 
                </div>
                <div id="item-box-text"> REGISTRAR PROVEEDOR</div>
              </li>
            </ul>
        </div>

</div>

 

        
@endsection

@section('foot')


@endsection

@section('script')
<script type="text/javascript">


    var app = angular.module('myApp',['ui.bootstrap','ngRoute','angucomplete-alt','datatables']);
 
    app.config(function($interpolateProvider){
        $interpolateProvider.startSymbol('/%');
        $interpolateProvider.endSymbol('%/');
    });

    app.controller('ProveedorController', function ProveedorController(ProveedorFactory){
        
        var vm = this;

        vm.proveedor = ProveedorFactory.Proveedor;

        ProveedorFactory.getProveedor();

        vm.eliminar = function(id_Proveedor){
            ProveedorFactory.deleteAttempt(id_Proveedor);
        }
        
        vm.create = function(){
            ProveedorFactory.create();
        }

        vm.edit = function(Proveedor){
            ProveedorFactory.edit(Proveedor);
        }

    });


    app.factory('ProveedorFactory', function ProveedorFactory($http, $modal, $filter ) {
         
        ProveedorFactory.Proveedor_edit = {};

        ProveedorFactory.Proveedor = [];

        ProveedorFactory.getProveedor = function() {
            return $http.get('AdsProveedor/getAllProveedores').success(function(data) {
                console.log(data.datos);
                angular.copy(data.datos, ProveedorFactory.Proveedor);
            });
        }

        /* ------------------------------Estas dos funciones eliminan datos -----------------------*/
        ProveedorFactory.deleteAttempt = function(id) {
            $modal.open( { 
                templateUrl:'templates_angular/deleteAttemp.html', 
                controller: function($scope, $modalInstance, ProveedorFactory) {
                    $scope.yes = function() {
                        ProveedorFactory.delete(id).then(function() { 
                            $modalInstance.close();
                        });                         
                    }
                }
            });
        }      
        // Delete Request
        ProveedorFactory.delete = function(id) {
            return $http.delete('AdsProveedor/' + id).success(function(data) {
                angular.copy(data.datos,ProveedorFactory.Proveedor);
            });
        }
        /* ------------------------------FIN - Estas dos funciones eliminan datos -----------------------*/
        
        /* Store Request */
        ProveedorFactory.create = function(){
            $modal.open({
                templateUrl: 'templates_angular/ProveedorController/create.html',
                controller: function($scope, $modalInstance, $filter){
                    /* El objeto creado del scope se utiliza en la vista */
                    $scope.proveedor = {};
                    $scope.store = function(){
                        if ( $("#create_form").validationEngine('validate') ) {
                            ProveedorFactory.store($scope.proveedor); /* Objeto de la vista */
                            $modalInstance.close();
                        };
                    }
                },
                resolve: {
                    
                }
            });
        }
        
        ProveedorFactory.store = function(Proveedor) {
            $http.post('AdsProveedor', Proveedor).success(function(data){
                angular.copy(data.datos,ProveedorFactory.Proveedor);
            });
        }

        ProveedorFactory.edit = function(proveedor){
            console.log(proveedor);
            angular.copy(proveedor, ProveedorFactory.Proveedor_edit);
            $modal.open({
                templateUrl: 'templates_angular/ProveedorController/editar.html',
                controller: function($scope, $modalInstance, Proveedor_edit){
                    $scope.proveedor = Proveedor_edit;
                    $scope.update = function(){
                        if( $("#edit_form").validationEngine('validate') ){
                            ProveedorFactory.update($scope.proveedor);
                            $modalInstance.close();
                        }
                    }
                },
                resolve: {
                    Proveedor_edit : function(){
                        return ProveedorFactory.Proveedor_edit;
                    }
                }
            });
        }

        ProveedorFactory.update = function(proveedor){ 
            $http.put('AdsProveedor/'+proveedor.id,proveedor).success(function(data){
                angular.copy(data.datos, ProveedorFactory.Proveedor);
            });
        }
 
        return ProveedorFactory;
 
    });
   
</script>

@endsection