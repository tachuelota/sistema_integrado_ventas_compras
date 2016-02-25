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
        <li><a href="{{asset('/')}}"><i class="fa fa-fw fa-shopping-cart"></i> Administración Sistema</a></li>
        <li class="active"><i class="fa fa-fw fa-building-o"></i> Productos</li>
    </ol>
@endsection

@section('content')
<div ng-app="myApp" ng-controller="ProductoController as ProductoCtrl">

    <div class=" col-xs-12 col-md-12 col-lg-11">

        <div class="box box-solid">
            <div class="box-header " > 
                <i class="fa fa-list-ul"></i>
                <h3 class="box-title">Productos</h3>
            </div>
            <div class="box-body ">
                <div class="form-group row">
                    <div class="col-md-2 text-center" style="padding-top: 5px;">
                        <span> Mes de Cierre</span>
                    </div>
                    <div class="col-md-3">
                        <input ng-model="ProductoCtrl.mes" type="month" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <div class="btn btn-success" ng-click="ProductoCtrl.store()">Consolidar</div>
                    </div>
                </div>
                

            </div>
        </div>   
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

    app.controller('ProductoController', function ProductoController(ProductoFactory){
        var vm = this;

        vm.store = function(){
            console.log(vm.mes);
            ProductoFactory.store(vm.mes).then(function(){
                vm.mes = null;
            });
        }

    });


    app.factory('ProductoFactory', function ProductoFactory($http, $modal, $filter ) {
         
        ProductoFactory.Productos = [];

        ProductoFactory.store = function(mes) {
        angular.element(div_loader).removeClass('hide');
            return $http.post('AdsProducto/cierre_mensual', {mes: mes}).success(function(data){
                if(data.datos == 'correcto'){
                    
        angular.element(div_loader).addClass('hide');
                    swal({   
                            title: "Cierre exitoso!"
                            ,   text: "El cierre del mes se realizó con éxito"
                            ,   type: "success"
                            ,   confirmButtonText: "OK" 
                            ,   timer: 2000
                        });
                }
            });
        }

        return ProductoFactory;
 
    });


    
</script>


@endsection