@extends('templates.layout')
@section('title')
Control  Tipo Cliente
@endsection

@section('head')
    <link href="{{ asset('plugins/morris/morris.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('breadcrumb')
    <h1 style="color:#222d32; font-family: arial;">Personal de Transporte<small style="color:#222d32; font-family: arial;"> / Transportistas</small></h1>
    <div class="pull-right">
        <label id="Fecha_Actual"></label>
        <br>
        <label name="Hora_Actual" id="Hora_Actual"></label>
    </div>
@endsection
@section('content')


<div ng-app="myApp" ng-controller="IgvController as IgvCtrl">
    <div class=" col-xs-12 col-md-12 col-lg-10">
        
       <!--  <div class="box box-solid">
            <div class="box-header" > 
                <i class="fa fa-list-ul"></i>
                <h3 class="box-title">Buscar Personal</h3>
            </div>
            <div class="box-body">
                <div class="form-group row">
                    <div class="col-md-2 text-right">
                        <label>Buscar Personal:</label> 
                    </div>
                    <div class="col-md-6 text-left pull left">
                        <input type="text" placeholder="Buscar Personal" ng-model="IgvCtrl.buscar_personalTransporte" class="form-control">
                    </div>
                </div>
            </div>
        </div> -->

        <div class="box box-solid">
            <div class="box-header " > 
                <i class="fa fa-list-ul"></i>
                <h3 class="box-title">Igv del Sistema</h3>
            </div>
            <div class="box-body ">
                <div class="form-group row">
                    
                    <div  class="col-md-12"> 
                        <table class="table table-striped text-center"  datatable="ng" dt-instance="dtInstance">
                            <thead >
                                <tr>
                                    <th>ITEM</th>
                                    <th>VALOR IGV</th>
                                    <th>ESTADO</th>
                                    <th>ACCION</th>
                                </tr>
                            </thead>
                            <tbody >
                                <tr ng-repeat="x in IgvCtrl.igv | filter: IgvCtrl.buscar_personalTransporte">
                                    <td>/% $index + 1 %/ </td>
                                    <td>/% x.valor_igv %/ </td>
                                    <td ng-if="x.estado == 'true'"> <span class="label label-success"><i class="fa fa-check"></i> ACTIVO </span> </td>
                                    <td ng-if="x.estado == 'true'"> </td>
                                    <td ng-if="x.estado == 'false'"> <span class="label label-danger"><i class="fa fa-times"></i> INACTIVO </span> </td>
                                    <td ng-if="x.estado == 'false'">
                                        <a ng-click="IgvCtrl.activar(x.id)" class="btn btn-success">
                                            <i class="fa fa-check-square-o" data-toggle="tooltip" data-title="Activar Igv"></i>
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
                margin-right: -140px !important;
            }

            #aside-right li:hover {
                margin-right: 0px !important;
                margin-left: -140px !important;
            }
        </style>

        <div id="content-aside-right">
            <ul id="aside-right" class="btn-group-vertical">
              <li ng-click="IgvCtrl.create()" class=" ">
                <div id="item-box-icon">
                    <i class="fa fa-plus"></i> 
                </div>
                <div id="item-box-text"> REGISTRAR IGV</div>
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

    app.controller('IgvController', function IgvController(IgvFactory){
        
        var vm = this; /* Hace referencia a todo el scope */

        vm.igv = IgvFactory.Igv;

        IgvFactory.getIgv();

        // vm.eliminar = function(id_personalTransporte){
        //     IgvFactory.deleteAttempt(id_personalTransporte);
        // }
        
        vm.create = function(){
            IgvFactory.create();
        }

        vm.activar = function(id){
            IgvFactory.activar(id);
        }

    });


    app.factory('IgvFactory', function IgvFactory($http, $modal, $filter ) {
         
        // IgvFactory.personalTransporte_edit = {};

        IgvFactory.Igv = [];
        // IgvFactory.EmpresasTransporte = [];

        IgvFactory.getIgv = function() {

            return $http.get('AdsIgv/getAllIgvs').success(function(data) {
                console.log(data.datos);
                angular.copy(data.datos, IgvFactory.Igv);
            });
        } 

        IgvFactory.create = function(){
            $modal.open({
                templateUrl: 'templates_angular/IgvController/create.html',
                controller: function($scope, $modalInstance, $filter){
                    $scope.igv = {};

                    $scope.store = function(){
                        if( $("#create_form").validationEngine('validate') ) {
                            IgvFactory.store($scope.igv);
                            $modalInstance.close();
                        };
                    }
                }
            });
        }
        
        IgvFactory.store = function(igv) {
            $http.post('AdsIgv', igv).success(function(data){
                angular.copy(data.datos,IgvFactory.Igv);
            });
        }

        IgvFactory.activar = function(id) {
            $modal.open( { 
                templateUrl:'templates_angular/IgvController/activar_igv.html', 
                controller: function($scope, $modalInstance, IgvFactory) {
                        console.log('entro'); 
                    $scope.yes = function() {

                        IgvFactory.update(id).then(function() {
                            $modalInstance.close();
                        console.log('2222'); 
                        });                         
                    }
 
                }
 
            });
        }  

        IgvFactory.update = function(id){ 
            return $http.put('AdsIgv/'+id).success(function(data){
                angular.copy(data.datos, IgvFactory.Igv);
            });
        }

        return IgvFactory;
 
    });
    
</script>

@endsection