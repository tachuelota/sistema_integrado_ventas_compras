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
        <li><a href="{{asset('/')}}"><i class="fa fa-fw fa-shopping-cart"></i> Transporte</a></li>
        <li class="active"><i class="fa fa-fw fa-building-o"></i> Personal</li>
    </ol>
@endsection

@section('content')
<div ng-app="myApp" ng-controller="PersonalTransporteController as PersonalTransporteCtrl">
    <div class=" col-xs-12 col-md-12 col-lg-10">

        <div class="box box-solid">
            <div class="box-header " > 
                <i class="fa fa-list-ul"></i>
                <h3 class="box-title">Personal de Transporte</h3>
            </div>
            <div class="box-body ">
                <div class="form-group row">
                    
                    <div  class="col-md-12"> 
                        <table class="table table-striped text-center"  datatable="ng" dt-instance="dtInstance">
                            <thead >
                                <tr>
                                    <th>ITEM</th>
                                    <th>NOMBRE PERSONAL</th>
                                    <th>LICENCIA CONDUCIR</th>
                                    <th>EMPRESA TRANSPORTE</th>
                                    <th>ACCION</th>
                                </tr>
                            </thead>
                            <tbody >
                                <tr ng-repeat="x in PersonalTransporteCtrl.personal_transporte | filter: PersonalTransporteCtrl.buscar_personalTransporte">
                                    <td>/% $index + 1 %/ </td>
                                    <td>/% x.nombre_personal %/ </td>
                                    <td>/% x.licencia_personal %/ </td>
                                    <td>/% x.transporte.razon_social %/ </td>
                                    <td>
                                        <a ng-click="PersonalTransporteCtrl.edit(x)" class="btn btn-success">
                                            <i class="fa fa-edit" data-toggle="tooltip" title="Modificar"></i>
                                        </a>
                                        <a ng-click="PersonalTransporteCtrl.eliminar(x.id)" class="btn btn-danger">
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
                margin-right: -200px !important;
            }

            #aside-right li:hover {
                margin-right: 0px !important;
                margin-left: -200px !important;
            }
        </style>

        <div id="content-aside-right">
            <ul id="aside-right" class="btn-group-vertical">
              <li ng-click="PersonalTransporteCtrl.create()" class=" ">
                <div id="item-box-icon">
                    <i class="fa fa-plus"></i> 
                </div>
                <div id="item-box-text"> REGISTRAR PERSONAL</div>
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

    app.controller('PersonalTransporteController', function PersonalTransporteController(PersonalTransporteFactory){
        
        var vm = this; /* Hace referencia a todo el scope */

        vm.personal_transporte = PersonalTransporteFactory.PersonalTransporte;

        PersonalTransporteFactory.getPersonalTransporte();
        PersonalTransporteFactory.getTransportes();

        vm.eliminar = function(id_personalTransporte){
            PersonalTransporteFactory.deleteAttempt(id_personalTransporte);
        }
        
        vm.create = function(){
            PersonalTransporteFactory.create();
        }

        vm.edit = function(peronsalTransporte){
            PersonalTransporteFactory.edit(peronsalTransporte);
        }

    });


    app.factory('PersonalTransporteFactory', function PersonalTransporteFactory($http, $modal, $filter ) {
         
        PersonalTransporteFactory.personalTransporte_edit = {};

        PersonalTransporteFactory.PersonalTransporte = [];
        PersonalTransporteFactory.EmpresasTransporte = [];

        PersonalTransporteFactory.getPersonalTransporte = function() {

            return $http.get('AdsPersonalTransporte/getAllPersonalTransportes').success(function(data) {
                console.log(data.datos);
                angular.copy(data.datos, PersonalTransporteFactory.PersonalTransporte );
            });
        } 

        PersonalTransporteFactory.getTransportes = function() {
            return $http.get('AdsTransporte/getAllTransportes').success(function(data) {
                angular.copy(data.datos, PersonalTransporteFactory.EmpresasTransporte);
            });
        } 

        PersonalTransporteFactory.deleteAttempt = function(id) {
            $modal.open( { 
                templateUrl:'templates_angular/deleteAttemp.html', 
                controller: function($scope, $modalInstance, PersonalTransporteFactory) {
                    $scope.yes = function() {
                        PersonalTransporteFactory.delete(id).then(function() { 
                            $modalInstance.close();
                        });                         
                    }
 
                }
 
            });
        }      


        PersonalTransporteFactory.delete = function(id) {
            return $http.delete('AdsPersonalTransporte/' + id).success(function(data) {
                angular.copy(data.datos,PersonalTransporteFactory.PersonalTransporte);
            });
        }


        PersonalTransporteFactory.create = function(){
            $modal.open({
                templateUrl: 'templates_angular/PersonalTransporteController/create.html',
                controller: function($scope, $modalInstance, $filter, EmpresasTransporte){
                    $scope.personalTransporte = {};
                    $scope.empresasTransporte = EmpresasTransporte;

                    $scope.store = function(){
                        if( $("#create_form").validationEngine('validate') ) {
                            PersonalTransporteFactory.store($scope.personalTransporte);
                            $modalInstance.close();
                        };
                    }
                },
                resolve: {
                    EmpresasTransporte : function(){
                        return PersonalTransporteFactory.EmpresasTransporte;
                    }
                }
            });
        }
        
        PersonalTransporteFactory.store = function(personalTransporte) {
            $http.post('AdsPersonalTransporte', personalTransporte).success(function(data){
                angular.copy(data.datos,PersonalTransporteFactory.PersonalTransporte);
            });
        }

        PersonalTransporteFactory.edit = function(peronsalTransporte){
            console.log(peronsalTransporte);
            angular.copy(peronsalTransporte, PersonalTransporteFactory.personalTransporte_edit);
            $modal.open({
                templateUrl: 'templates_angular/PersonalTransporteController/editar.html',
                controller: function($scope, $modalInstance, personalTransporte_edit, EmpresasTransporte){
                    $scope.personalTransporte = personalTransporte_edit;
                    $scope.empresasTransporte = EmpresasTransporte;

                    $scope.update = function(){
                        if( $("#edit_form").validationEngine('validate') ){
                            PersonalTransporteFactory.update($scope.personalTransporte);
                            $modalInstance.close();
                        }
                    }
                },
                resolve: {
                    personalTransporte_edit : function(){
                        return PersonalTransporteFactory.personalTransporte_edit;
                    },
                    EmpresasTransporte : function(){
                        return PersonalTransporteFactory.EmpresasTransporte;
                    }
                }
            });
        }

        PersonalTransporteFactory.update = function(personalTransporte){ 
            $http.put('AdsPersonalTransporte/'+personalTransporte.id,personalTransporte).success(function(data){
                angular.copy(data.datos, PersonalTransporteFactory.PersonalTransporte);
            });
        }
 
        return PersonalTransporteFactory;
 
    });
    
</script>

@endsection