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
        <li class="active"><i class="fa fa-fw fa-building-o"></i> Kardex</li>
    </ol>
@endsection

@section('content')
<div ng-app="myApp" ng-controller="ProductoController as ProductoCtrl">

    <div class=" col-xs-12 col-md-12 col-lg-11">

        <div class="box box-solid">
            <div class="box-header " > 
                <i class="fa fa-list-ul"></i>
                <h3 class="box-title">Kardex</h3>
            </div>
            <div class="box-body ">
                <div class="form-group row">
                    <form id="form_create">
                        <div class="col-md-1 text-center" style="padding-top: 5px;">
                            <span> Mes</span>
                        </div>
                        <div class="col-md-3">
                            <input ng-model="ProductoCtrl.mes" type="month" class="form-control validate[required]">
                        </div>
                        <div class="col-md-1 text-right" style="padding-top: 4px;">
                            Producto
                        </div>
                        <div class="col-md-5">
                            <div class="input-group">

                                <a href="" ng-click="ProductoCtrl.buscarProducto()" class="input-group-addon">
                                    <i class="fa fa-search"></i>
                                </a>
                                <angucomplete-alt id="nom_producto" placeholder="Nombre Producto" pause="100" selected-object="ProductoCtrl.seleccion_angucompleteproducto" local-data="ProductoCtrl.angucomplete_productos" search-fields="nombre_producto" title-field="nombre_producto" minlength="1" input-class="form-control form-control-small" match-class="highlight" field-required="true">
                                </angucomplete-alt>
                                <a href="" ng-click="ProductoCtrl.limpiar_producto();" class="input-group-addon">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </div>
                        <!-- <div class="col-md-3">
                            <div class="btn btn-success" ng-click="ProductoCtrl.get_kardex()">Exportar Excel</div>
                        </div> -->
                        <div class="col-md-2">
                            <div class="btn btn-success" ng-click="ProductoCtrl.get_kardex_nuevo()">Exportar Excel</div>
                        </div>
                    </form>
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

    app.controller('ProductoController', function ProductoController(ProductoFactory, $scope){
        var vm = this;

        ProductoFactory.getProductos();
        vm.angucomplete_productos = ProductoFactory.Productos;
        vm.producto_seleccion = ProductoFactory.Producto_seleccionado;

        vm.get_kardex = function(){
            if($('#form_create').validationEngine('validate')){
                ProductoFactory.get_kardex(vm.mes);
            }
            
        }
        vm.get_kardex_nuevo = function(){
            if($('#form_create').validationEngine('validate')){
                ProductoFactory.get_kardex_nuevo(vm.mes);
            }
            
        }

        vm.buscarProducto = function(){
            ProductoFactory.buscarProducto();
            
        }

        vm.seleccion_angucompleteproducto = function(object){
            angular.copy(object.description, ProductoFactory.Producto_seleccionado);
        }

        vm.limpiar_producto = function(){
            $scope.$broadcast('angucomplete-alt:clearInput');
            angular.copy({},ProductoFactory.Producto_seleccionado);
        }
    });


    app.factory('ProductoFactory', function ProductoFactory($http, $modal, $filter ) {
         
        ProductoFactory.Productos = [];
        ProductoFactory.Producto_seleccionado = {}; 

        ProductoFactory.get_kardex = function(mes) {
            if(ProductoFactory.Producto_seleccionado.id == undefined) ProductoFactory.Producto_seleccionado.id = null;
            location.href='AdsProducto/getKardex/'+ JSON.stringify({fecha: mes, id_producto: ProductoFactory.Producto_seleccionado.id, nombre_producto: ProductoFactory.Producto_seleccionado.nombre_producto});
        }

        ProductoFactory.get_kardex_nuevo = function(mes) {
            if(ProductoFactory.Producto_seleccionado.id == undefined){
                ProductoFactory.Producto_seleccionado.id = null;
            } else{
                ProductoFactory.Producto_seleccionado.nombre_producto = ProductoFactory.Producto_seleccionado.nombre_producto.replace("/", "_");
            }
            location.href='AdsProducto/getKardexNuevo/'+ JSON.stringify({fecha: mes, id_producto: ProductoFactory.Producto_seleccionado.id, nombre_producto: ProductoFactory.Producto_seleccionado.nombre_producto});
        }


        ProductoFactory.buscarProducto = function(){
            $modal.open({
                templateUrl: 'templates_angular/ProductoController/seleccion_producto.html',
                controller: function($scope, $modalInstance, Productos){
                    $scope.productos = Productos;

                    $scope.seleccionar = function(data){

                        angular.copy(data, ProductoFactory.Producto_seleccionado);

                        $modalInstance.close();
                    }
                },
                resolve: {
                    Productos : function(){
                        return ProductoFactory.Productos;
                    }
                }
            });
        }

        ProductoFactory.getProductos = function() {
        angular.element(div_loader).removeClass('hide');
            return $http.get('AdsProducto/getAllProductos').success(function(data) {
        angular.element(div_loader).addClass('hide');
                angular.copy(data.datos, ProductoFactory.Productos);

            });
        }

        

        return ProductoFactory;
 
    });


    
</script>


@endsection