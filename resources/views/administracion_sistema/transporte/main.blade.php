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
        <li class="active"><i class="fa fa-fw fa-building-o"></i> Empresa</li>
    </ol>
@endsection

@section('content')
<div ng-app="myApp" ng-controller="TransporteController as TransporteCtrl">
    <!-- <div ng-app="myApp" ng-controller="TransporteController as TransporteCtrl"> -->

        <div class=" col-xs-12 col-md-12 col-lg-10">

            <div class="box box-solid collapsed-box">
                <div class="box-header" > 
                    <i class="fa fa-list-ul"></i>
                    <h3 class="box-title">Empresa de Transporte</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                    </div>
                </div>
                <div class="box-body ">
                    <div class="form-group row">
                        
                        <div  class="col-md-12"> 
                            <table class="table table-striped text-center"  datatable="ng" dt-instance="dtInstance">
                                <thead >
                                    <tr>
                                        <th>EMPRESA DE TRANSPORTE</th>
                                        <th>RUC</th>
                                        <th>ACCION</th>
                                    </tr>
                                </thead>
                                <tbody >
                                    <tr ng-repeat="x in TransporteCtrl.clientes | filter: TransporteCtrl.buscar_cliente">
                                        <td>/% x.razon_social %/ </td>
                                        <td>/% x.ruc %/ </td>
                                        <td>
                                            <a ng-click="TransporteCtrl.edit_empresa(x)" class="btn btn-success">
                                                <i class="fa fa-edit" data-toggle="tooltip" title="Modificar"></i>
                                            </a>
                                            <a ng-click="TransporteCtrl.eliminar_empresa(x.id)" class="btn btn-danger">
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

    <!-- </div> -->

     
    <!-- <div ng-app="myApp" ng-controller="UnidadMedidaController as UnidadTransporteCtrl"> -->

        <div class=" col-xs-12 col-md-12 col-lg-10">

            <div class="box box-solid collapsed-box">
                <div class="box-header" > 
                    <i class="fa fa-list-ul"></i>
                    <h3 class="box-title">Unidad de Transporte</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                    </div>
                </div>
                <div class="box-body ">
                    <div class="form-group row">
                        
                        <div  class="col-md-12"> 
                            <table class="table table-striped text-center"  datatable="ng" dt-instance="dtInstance">
                                <thead >
                                    <tr>
                                        <th>ITEM</th>
                                        <th>EMPRESA DE TRANSPORTE</th>
                                        <th>MARCA</th>
                                        <th>PLACA</th>
                                        <th>CIMTC</th>
                                        <th>ACCION</th>
                                    </tr>
                                </thead>
                                <tbody >
                                    <tr ng-repeat="x in TransporteCtrl.unidad_transporte | filter: TransporteCtrl.buscar_unidadTransporte">
                                        <td>/% $index + 1 %/ </td>
                                        <td>/% x.transporte.razon_social %/ </td>
                                        <td>/% x.marca %/ </td>
                                        <td>/% x.placa %/ </td>
                                        <td>/% x.ci_mtc %/ </td>
                                        <td>
                                            <a ng-click="TransporteCtrl.edit_unidad(x)" class="btn btn-success">
                                                <i class="fa fa-edit" data-toggle="tooltip" title="Modificar"></i>
                                            </a>
                                            <a ng-click="TransporteCtrl.eliminar_unidad(x.id)" class="btn btn-danger">
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


    <!-- </div> -->

     
    <!-- <div ng-app="myApp" ng-controller="PersonalTransporteController as PersonalTransporteCtrl"> -->
        <div class=" col-xs-12 col-md-12 col-lg-10">

            <div class="box box-solid collapsed-box">
                <div class="box-header" > 
                    <i class="fa fa-list-ul"></i>
                    <h3 class="box-title">Personal de Transporte</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                    </div>
                </div>
                <div class="box-body ">
                    <div class="form-group row">
                        
                        <div  class="col-md-12"> 
                            <table class="table table-striped text-center"  datatable="ng" dt-instance="dtInstance">
                                <thead >
                                    <tr>
                                        <th>ITEM</th>
                                        <th>EMPRESA TRANSPORTE</th>
                                        <th>NOMBRE PERSONAL</th>
                                        <th>LICENCIA CONDUCIR</th>
                                        <th>ACCION</th>
                                    </tr>
                                </thead>
                                <tbody >
                                    <tr ng-repeat="x in TransporteCtrl.personal_transporte | filter: TransporteCtrl.buscar_personalTransporte">
                                        <td>/% $index + 1 %/ </td>
                                        <td>/% x.transporte.razon_social %/ </td>
                                        <td>/% x.nombre_personal %/ </td>
                                        <td>/% x.licencia_personal %/ </td>
                                        <td>
                                            <a ng-click="TransporteCtrl.edit_personal(x)" class="btn btn-success">
                                                <i class="fa fa-edit" data-toggle="tooltip" title="Modificar"></i>
                                            </a>
                                            <a ng-click="TransporteCtrl.eliminar_personal(x.id)" class="btn btn-danger">
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
                    margin-right: -130px !important;
                }

                #aside-right li:hover {
                    margin-right: 0px !important;
                    margin-left: -130px !important;
                }
            </style>

            <div id="content-aside-right">
                <ul id="aside-right" class="btn-group-vertical">
                  <li ng-click="TransporteCtrl.create_empresa()">
                    <div id="item-box-icon">
                        <i class="fa fa-institution"></i> 
                    </div>
                    <div id="item-box-text"> EMPRESA   <i class="fa fa-plus" style="font-size : 1em !important;"></i> </div>
                  </li>
                  <li ng-click="TransporteCtrl.create_unidad()">
                    <div id="item-box-icon">
                        <i class="fa fa-bus" style="padding-left:4px;"></i> 
                    </div>
                    <div id="item-box-text"> UNIDAD   <i class="fa fa-plus" style="font-size : 1em !important;"></i> </div>
                  </li>
                  <li ng-click="TransporteCtrl.create_personal()">
                    <div id="item-box-icon">
                        <i class="fa fa-male" style="padding-left:8px;"></i> 
                    </div>
                    <div id="item-box-text"> PERSONAL   <i class="fa fa-plus" style="font-size : 1em !important;"></i> </div>
                  </li>
                </ul>
            </div>

    <!-- </div> -->
    
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

    app.controller('TransporteController', function TransporteController(TransporteFactory){
        var vm = this;

        vm.clientes = TransporteFactory.Transportes;
        TransporteFactory.getTransportes();

        vm.eliminar_empresa = function(id_transporte){
            TransporteFactory.deleteAttempt_empresa(id_transporte);
        }
        
        vm.create_empresa = function(){

            TransporteFactory.create_empresa();
        }


        vm.edit_empresa = function(Transporte){
            TransporteFactory.edit_empresa(Transporte);
        }

        vm.unidad_transporte = TransporteFactory.UnidadTransporte;

        TransporteFactory.getUnidadTransporte();

        vm.eliminar_unidad = function(id_unidadTransporte){
            TransporteFactory.deleteAttempt_unidad(id_unidadTransporte);
        }
        
        vm.create_unidad = function(){

            TransporteFactory.create_unidad();
        }

        vm.edit_unidad = function(unidadTransporte){
            TransporteFactory.edit_unidad(unidadTransporte);
        }


        vm.personal_transporte = TransporteFactory.PersonalTransporte;

        TransporteFactory.getPersonalTransporte();

        vm.eliminar_personal = function(id_personalTransporte){
            TransporteFactory.deleteAttempt_personal(id_personalTransporte);
        }
        
        vm.create_personal = function(){
            TransporteFactory.create_personal();
        }

        vm.edit_personal = function(peronsalTransporte){
            TransporteFactory.edit_personal(peronsalTransporte);
        }

          
 
    });


    app.factory('TransporteFactory', function TransporteFactory($http, $modal, $filter ) {
         
        TransporteFactory.Cliente_edit = {};

        TransporteFactory.Transportes = [];

        TransporteFactory.getTransportes = function() {

            return $http.get('AdsTransporte/getAllTransportes').success(function(data) {
                angular.copy(data.datos, TransporteFactory.Transportes);
                angular.copy(data.datos, TransporteFactory.EmpresasTransporte);
                // angular.copy(data.datos, TransporteFactory.EmpresasTransporte);
            });
        } 


        /* ------------------------------Estas dos funciones eliminan datos -----------------------*/
        TransporteFactory.deleteAttempt_empresa = function(id) {
            $modal.open( { 
                templateUrl:'templates_angular/deleteAttemp.html', 
                controller: function($scope, $modalInstance, TransporteFactory) {
                    
                    $scope.yes = function() {
                        TransporteFactory.delete_empresa(id).then(function() { 
                            $modalInstance.close();
                        });                         
                    }
 
                }
 
            });
        }      
        // Delete Request
        TransporteFactory.delete_empresa = function(id) {
            return $http.delete('AdsTransporte/' + id).success(function(data) {
                angular.copy(data.datos,TransporteFactory.Transportes);
            });
        }
        /* ------------------------------FIN - Estas dos funciones eliminan datos -----------------------*/
        // Store Request

        TransporteFactory.create_empresa = function(){

            $modal.open({
                templateUrl: 'templates_angular/TransporteController/create.html',
                controller: function($scope, $modalInstance, $filter){
                    $scope.cliente = {};

                    $scope.store = function(){
                        if ( $("#create_form").validationEngine('validate') ) {
                            TransporteFactory.store_empresa($scope.cliente);
                            $modalInstance.close();
                        };
                    }

              },
                resolve: {

                }

            });


        }
        
        TransporteFactory.store_empresa = function(Transporte) {
            $http.post('AdsTransporte', Transporte).success(function(data){
                angular.copy(data.datos, TransporteFactory.Transportes);
                angular.copy(data.datos, TransporteFactory.EmpresasTransporte);
            });
        }

        TransporteFactory.edit_empresa = function(Transporte){
            console.log(Transporte);
            angular.copy(Transporte, TransporteFactory.Cliente_edit);
            $modal.open({
                templateUrl: 'templates_angular/TransporteController/editar.html',
                controller: function($scope, $modalInstance, Cliente_edit){
                    $scope.cliente = Cliente_edit;

                    $scope.update = function(){
                        if( $("#edit_form").validationEngine('validate') ){
                            TransporteFactory.update_empresa($scope.cliente);
                            $modalInstance.close();
                        }
                    }

                },
                resolve: {
                    Cliente_edit : function(){
                        return TransporteFactory.Cliente_edit;
                    }
                }
            });
        }


        TransporteFactory.update_empresa = function(Transporte){ 
            $http.put('AdsTransporte/'+Transporte.id,Transporte).success(function(data){
                angular.copy(data.datos, TransporteFactory.Transportes);
            });
        }


        TransporteFactory.unidadTransporte_edit = {};

        TransporteFactory.UnidadTransporte = [];
        TransporteFactory.EmpresasTransporte = []; /* Para llenar el comboBox */

        TransporteFactory.getUnidadTransporte = function() {
            return $http.get('AdsUnidadTransporte/getAllUnidadTransportes').success(function(data) {
                angular.copy(data.datos, TransporteFactory.UnidadTransporte);
            });
        }


        /* ------------------------------Estas dos funciones eliminan datos -----------------------*/
        TransporteFactory.deleteAttempt_unidad = function(id) {
            $modal.open( { 
                templateUrl:'templates_angular/deleteAttemp.html', 
                controller: function($scope, $modalInstance, TransporteFactory) {
                    $scope.yes = function() {
                        TransporteFactory.delete_unidad(id).then(function() { 
                            $modalInstance.close();
                        });                         
                    }
 
                }
 
            });
        }      
        // Delete Request
        TransporteFactory.delete_unidad = function(id) {
            return $http.delete('AdsUnidadTransporte/' + id).success(function(data) {
                angular.copy(data.datos,TransporteFactory.UnidadTransporte);
            });
        }
        /* ------------------------------FIN - Estas dos funciones eliminan datos -----------------------*/
        
        // Store Request
        TransporteFactory.create_unidad = function(){
            $modal.open({
                templateUrl: 'templates_angular/UnidadTransporteController/create.html',
                controller: function($scope, $modalInstance, $filter, EmpresasTransporte){
                    $scope.unidadTransporte = {};
                    $scope.empresasTransporte = EmpresasTransporte;
                    $scope.store = function(){
                        if ( $("#create_form").validationEngine('validate') ) {
                            TransporteFactory.store_unidad($scope.unidadTransporte);
                            $modalInstance.close();
                        };
                    }
                },
                resolve: {
                    EmpresasTransporte : function(){
                        return TransporteFactory.EmpresasTransporte;
                    }
                }
            });
        }
        
        TransporteFactory.store_unidad = function(unidadTransporte) {
            $http.post('AdsUnidadTransporte', unidadTransporte).success(function(data){
                angular.copy(data.datos,TransporteFactory.UnidadTransporte);
            });
        }

        TransporteFactory.edit_unidad = function(unidadTransporte){
            console.log(unidadTransporte);
            angular.copy(unidadTransporte, TransporteFactory.unidadTransporte_edit);
            $modal.open({
                templateUrl: 'templates_angular/UnidadTransporteController/editar.html',
                controller: function($scope, $modalInstance, unidadTransporte_edit,EmpresasTransporte){
                    $scope.unidadTransporte = unidadTransporte_edit;
                    $scope.empresasTransporte = EmpresasTransporte; 
                    $scope.update = function(){
                        if( $("#edit_form").validationEngine('validate') ){
                            TransporteFactory.update_unidad($scope.unidadTransporte);
                            $modalInstance.close();
                        }
                    }
                },
                resolve: {
                    unidadTransporte_edit : function(){
                        return TransporteFactory.unidadTransporte_edit;
                    },
                    EmpresasTransporte : function(){
                        return TransporteFactory.EmpresasTransporte;
                    }
                }
            });
        }

        TransporteFactory.update_unidad = function(unidadTransporte){ 
            $http.put('AdsUnidadTransporte/'+unidadTransporte.id,unidadTransporte).success(function(data){
                angular.copy(data.datos, TransporteFactory.UnidadTransporte);
            });
        }
 
        TransporteFactory.personalTransporte_edit = {};

        TransporteFactory.PersonalTransporte = [];
        TransporteFactory.EmpresasTransporte = [];

        TransporteFactory.getPersonalTransporte = function() {

            return $http.get('AdsPersonalTransporte/getAllPersonalTransportes').success(function(data) {
                console.log(data.datos);
                angular.copy(data.datos, TransporteFactory.PersonalTransporte );
            });
        } 

        TransporteFactory.deleteAttempt_personal = function(id) {
            $modal.open( { 
                templateUrl:'templates_angular/deleteAttemp.html', 
                controller: function($scope, $modalInstance, TransporteFactory) {
                    $scope.yes = function() {
                        TransporteFactory.delete_personal(id).then(function() { 
                            $modalInstance.close();
                        });                         
                    }
 
                }
 
            });
        }      


        TransporteFactory.delete_personal = function(id) {
            return $http.delete('AdsPersonalTransporte/' + id).success(function(data) {
                angular.copy(data.datos,TransporteFactory.PersonalTransporte);
            });
        }


        TransporteFactory.create_personal = function(){
            $modal.open({
                templateUrl: 'templates_angular/PersonalTransporteController/create.html',
                controller: function($scope, $modalInstance, $filter, EmpresasTransporte){
                    $scope.personalTransporte = {};
                    $scope.empresasTransporte = EmpresasTransporte;

                    $scope.store = function(){
                        if( $("#create_form").validationEngine('validate') ) {
                            TransporteFactory.store_personal($scope.personalTransporte);
                            $modalInstance.close();
                        };
                    }
                },
                resolve: {
                    EmpresasTransporte : function(){
                        return TransporteFactory.EmpresasTransporte;
                    }
                }
            });
        }
        
        TransporteFactory.store_personal = function(personalTransporte) {
            $http.post('AdsPersonalTransporte', personalTransporte).success(function(data){
                angular.copy(data.datos,TransporteFactory.PersonalTransporte);
            });
        }

        TransporteFactory.edit_personal = function(peronsalTransporte){
            console.log(peronsalTransporte);
            angular.copy(peronsalTransporte, TransporteFactory.personalTransporte_edit);
            $modal.open({
                templateUrl: 'templates_angular/PersonalTransporteController/editar.html',
                controller: function($scope, $modalInstance, personalTransporte_edit, EmpresasTransporte){
                    $scope.personalTransporte = personalTransporte_edit;
                    $scope.empresasTransporte = EmpresasTransporte;

                    $scope.update = function(){
                        if( $("#edit_form").validationEngine('validate') ){
                            TransporteFactory.update_personal($scope.personalTransporte);
                            $modalInstance.close();
                        }
                    }
                },
                resolve: {
                    personalTransporte_edit : function(){
                        return TransporteFactory.personalTransporte_edit;
                    },
                    EmpresasTransporte : function(){
                        return TransporteFactory.EmpresasTransporte;
                    }
                }
            });
        }

        TransporteFactory.update_personal = function(personalTransporte){ 
            $http.put('AdsPersonalTransporte/'+personalTransporte.id,personalTransporte).success(function(data){
                angular.copy(data.datos, TransporteFactory.PersonalTransporte);
            });
        }
 
 

        return TransporteFactory;
 
    });


      
    // app.controller('UnidadMedidaController', function UnidadMedidaController(TransporteFactory){
        
    //     var vm = this;


    // });


    // app.factory('TransporteFactory', function TransporteFactory($http, $modal, $filter ) {
         
    //     return TransporteFactory;
 
    // });  

    
    // app.controller('PersonalTransporteController', function PersonalTransporteController(TransporteFactory){

    // });


    // app.factory('TransporteFactory', function TransporteFactory($http, $modal, $filter ) {
         
    //     return TransporteFactory;
 
    // });
    
</script>


@endsection