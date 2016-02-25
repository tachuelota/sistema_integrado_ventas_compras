@extends('templates.layout')
@section('title')
Color
@endsection

@section('head')
    <link href="{{ asset('plugins/morris/morris.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('breadcrumb')
    <h1 style="color:#222d32; font-family: arial;">Color</h1>
    <div class="pull-right">
        <label id="Fecha_Actual"></label>
        <br>
        <label name="Hora_Actual" id="Hora_Actual"></label>
    </div>
@endsection
@section('content')


<div ng-app="myApp" ng-controller="ColorController as ColorCtrl">
    <div class=" col-xs-12 col-md-12 col-lg-10">
        

        <div class="box box-solid">
            <div class="box-header " > 
                <i class="fa fa-list-ul"></i>
                <h3 class="box-title">Color</h3>
            </div>
            <div class="box-body ">
                <div class="form-group row">
                    
                    <div  class="col-md-12"> 
                        <table class="table table-striped text-center"  datatable="ng" dt-instance="dtInstance">
                            <thead >
                                <tr>
                                    <th>ITEM</th>
                                    <th>COLOR</th>
                                    <th>ACCION</th>
                                </tr>
                            </thead>
                            <tbody >
                                <tr ng-repeat="x in ColorCtrl.color">
                                    <td>/% $index + 1 %/ </td>
                                    <td>/% x.nombre_color %/ </td>
                                    <td>
                                        <a ng-click="ColorCtrl.edit(x)" class="btn btn-success">
                                            <i class="fa fa-edit" data-toggle="tooltip" title="Modificar"></i>
                                        </a>
                                        <a ng-click="ColorCtrl.eliminar(x.id)" class="btn btn-danger">
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
                margin-right: -170px !important;
            }

            #aside-right li:hover {
                margin-right: 0px !important;
                margin-left: -170px !important;
            }
        </style>

        <div id="content-aside-right">
            <ul id="aside-right" class="btn-group-vertical">
              <li ng-click="ColorCtrl.create()" class=" ">
                <div id="item-box-icon">
                    <i class="fa fa-plus"></i> 
                </div>
                <div id="item-box-text"> REGISTRAR COLOR</div>
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

    app.controller('ColorController', function ColorController(ColorFactory){
        
        var vm = this; /* Hace referencia a todo el scope */

        vm.color = ColorFactory.Color;

        ColorFactory.getAllColor();

        vm.eliminar = function(id_color){
            ColorFactory.deleteAttempt(id_color);
        }
        
        vm.create = function(){
            ColorFactory.create();
        }

        vm.edit = function(color){
            ColorFactory.edit(color);
        }

    });


    app.factory('ColorFactory', function ColorFactory($http, $modal, $filter ) {
         
        ColorFactory.color_edit = {};

        ColorFactory.Color = [];

        ColorFactory.getAllColor = function() {
        angular.element(div_loader).removeClass('hide');
            return $http.get('AdsColor/getAllColor').success(function(data) {
                angular.copy(data.datos, ColorFactory.Color );
        angular.element(div_loader).addClass('hide');
            });
        } 


        ColorFactory.deleteAttempt = function(id) {
            $modal.open( { 
                templateUrl:'templates_angular/deleteAttemp.html', 
                controller: function($scope, $modalInstance, ColorFactory) {
                    $scope.yes = function() {
                        ColorFactory.delete(id).then(function() { 
                            $modalInstance.close();
                        });                         
                    }
                }
            });
        }    


        ColorFactory.delete = function(id) {
        angular.element(div_loader).removeClass('hide');
            return $http.delete('AdsColor/' + id).success(function(data) {
                angular.copy(data.datos,ColorFactory.Color);
        angular.element(div_loader).addClass('hide');
            });
        }


        ColorFactory.create = function(){
            $modal.open({
                templateUrl: 'templates_angular/ColorController/create.html',
                controller: function($scope, $modalInstance, $filter){
                    $scope.color = {};
                    $scope.store = function(){
                        if( $("#create_form").validationEngine('validate') ) {
                            ColorFactory.store($scope.color);
                            $modalInstance.close();
                        };
                    }
                },
                resolve: {
                }
            });
        }
        
        ColorFactory.store = function(color) {
        angular.element(div_loader).removeClass('hide');
            $http.post('AdsColor', color).success(function(data){
                angular.copy(data.datos,ColorFactory.Color);
        angular.element(div_loader).addClass('hide');
            });
        }

        ColorFactory.edit = function(color){
            console.log(color);
            angular.copy(color, ColorFactory.color_edit);
            $modal.open({
                templateUrl: 'templates_angular/ColorController/editar.html',
                controller: function($scope, $modalInstance, color_edit){
                    $scope.color = color_edit;
                    
                    $scope.update = function(){
                        if( $("#edit_form").validationEngine('validate') ){
                            ColorFactory.update($scope.color);
                            $modalInstance.close();
                        }
                    }
                },
                resolve: {
                    color_edit : function(){
                        return ColorFactory.color_edit;
                    }
                }
            });
        }

        ColorFactory.update = function(color){ 
        angular.element(div_loader).removeClass('hide');
            $http.put('AdsColor/'+color.id,color).success(function(data){
                angular.copy(data.datos, ColorFactory.Color);
        angular.element(div_loader).addClass('hide');
            });
        }
 
        return ColorFactory;
 
    });
    
</script>

@endsection