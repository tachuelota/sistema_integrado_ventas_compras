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
        <li><a href="{{asset('/')}}"><i class="fa fa-fw fa-shopping-cart"></i> Módulo de Ventas</a></li>
        <li class="active"><i class="fa fa-fw fa-building-o"></i> Clientes</li>
    </ol>
@endsection

@section('content')
<div ng-app="myApp" ng-controller="ClientespvController as ClienteCtrl">

    <div class=" col-xs-12 col-md-12 col-lg-11">

        <div class="box box-solid">
            <div class="box-header " > 
                <i class="fa fa-list-ul"></i>
                <h3 class="box-title">Clientes</h3>
            </div>
            <div class="box-body ">
                <div class="form-group row">
                    
                    <div  class="col-md-12"> 
                        <table class="table table-striped text-center"  datatable="ng" dt-instance="dtInstance" style="font-size: 12px;">
                            <thead >
                                <tr>
                                    <th style="width: 80px;">ITEM</th>
                                    <th>RAZON SOCIAL</th>
                                    <th>RUC</th>
                                    <th>DIRECCION PRINCIPAL</th>
                                    <th>DIRECCION SECUNDARIA</th>
                                    <th>RETENEDOR</th>
                                    <th style="width: 120px;">OPCIONES</th>
                                </tr>
                            </thead>
                            <tbody >
                                <tr ng-repeat="x in ClienteCtrl.clientes | filter: ClienteCtrl.buscar_cliente">
                                    <td>/% $index + 1 %/ </td>
                                    <td>/% x.razon_social %/ </td>
                                    <td>/% x.ruc %/ </td>
                                    <td>/% x.direccion_principal %/ </td>
                                    <td>/% x.direccion_secundaria %/ </td>
                                    <td ng-if="x.agente_retenedor == 'true'"> <span class="label label-success"><i class="fa fa-check"></i> SI</span></td>
                                    <td ng-if="x.agente_retenedor == 'false'"> <span class="label label-danger"><i class="fa fa-times"></i> NO</span></td>
                                    <td>
                                        <a ng-click="ClienteCtrl.edit(x)" class="btn btn-success">
                                            <i class="fa fa-edit" data-toggle="tooltip" title="Modificar"></i>
                                        </a>
                                        <a ng-click="ClienteCtrl.eliminar(x.id)" class="btn btn-danger">
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
              <li ng-click="ClienteCtrl.create()" class=" ">
                <div id="item-box-icon">
                    <i class="fa fa-plus"></i> 
                </div>
                <div id="item-box-text"> REGISTRAR CLIENTE</div>
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

    app.controller('ClientespvController', function ClientespvController(ClienteFactory){
        var vm = this;

        vm.clientes = ClienteFactory.Clientes;
        ClienteFactory.getClientes();

        vm.eliminar = function(id_cliente){
            ClienteFactory.deleteAttempt(id_cliente);
        }
        
        vm.create = function(){

            ClienteFactory.create();
        }

        vm.edit = function(Cliente){
            ClienteFactory.edit(Cliente);
        }

          
 
    });


    app.factory('ClienteFactory', function ClienteFactory($http, $modal, $filter ) {
         
        ClienteFactory.Cliente_edit = {};

        ClienteFactory.Clientes = [];

        ClienteFactory.getClientes = function() {

        angular.element(div_loader).removeClass('hide');
            return $http.get('PtvCliente/getAllClientes').success(function(data) {
                angular.copy(data.datos, ClienteFactory.Clientes);
                console.log(ClienteFactory.Clientes);
        angular.element(div_loader).addClass('hide');
            });
        } 


        /* ------------------------------Estas dos funciones eliminan datos -----------------------*/
        ClienteFactory.deleteAttempt = function(id) {
            $modal.open( { 
                templateUrl:'templates_angular/deleteAttemp.html', 
                controller: function($scope, $modalInstance, ClienteFactory) {
                    
                    $scope.yes = function() {
                        ClienteFactory.delete(id).then(function() { 
                            $modalInstance.close();
                        });                         
                    }
 
                }
 
            });
        }      
        // Delete Request
        ClienteFactory.delete = function(id) {
        angular.element(div_loader).removeClass('hide');
            return $http.delete('PtvCliente/' + id).success(function(data) {
                angular.copy(data.datos,ClienteFactory.Clientes);
        angular.element(div_loader).addClass('hide');
            });
        }
        /* ------------------------------FIN - Estas dos funciones eliminan datos -----------------------*/
        // Store Request

        ClienteFactory.create = function(){

            $modal.open({
                templateUrl: 'templates_angular/ClienteController/create.html',
                controller: function($scope, $modalInstance, $filter){
                    $scope.cliente = {};

                    $scope.store = function(){
                        if ( $("#create_form").validationEngine('validate') ) {
                            // ClienteFactory.store($scope.cliente).then(function(){
                            //     $modalInstance.close();
                            // });
        angular.element(div_loader).removeClass('hide');
                            $http.post('PtvCliente', $scope.cliente).success(function(data){
                                if(data.datos == 'existe'){
                                    alert('Este cliente ya existe');
                                }
                                else{
                                    angular.copy(data.datos,ClienteFactory.Clientes);
                                    $modalInstance.close();
                                }
        angular.element(div_loader).addClass('hide');
                            });
                        };
                    }

              },
                resolve: {

                }

            });


        }
        
        ClienteFactory.store = function(Cliente) {

        }

        ClienteFactory.edit = function(Cliente){
            console.log(Cliente);
            angular.copy(Cliente, ClienteFactory.Cliente_edit);
            $modal.open({
                templateUrl: 'templates_angular/ClienteController/editar.html',
                controller: function($scope, $modalInstance, Cliente_edit){
                    $scope.cliente = Cliente_edit;

                    $scope.update = function(){
                        if( $("#edit_form").validationEngine('validate') ){
                            ClienteFactory.update($scope.cliente);
                            $modalInstance.close();
                        }
                    }

                },
                resolve: {
                    Cliente_edit : function(){
                        return ClienteFactory.Cliente_edit;
                    }
                }
            });
        }


        ClienteFactory.update = function(Cliente){ 
        angular.element(div_loader).removeClass('hide');
            $http.put('PtvCliente/'+Cliente.id,Cliente).success(function(data){
                angular.copy(data.datos, ClienteFactory.Clientes);
        angular.element(div_loader).addClass('hide');
            });
        }
 

        return ClienteFactory;
 
    });


        

    
</script>


@endsection