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
        <li><a href="{{asset('/')}}"><i class="fa fa-fw fa-shopping-cart"></i> Módulo de Venta</a></li>
        <li class="active"><i class="fa fa-fw fa-building-o"></i> Listado de Guias</li>
    </ol>
@endsection

@section('content')
<div ng-app="myApp" ng-controller="AdsGuiaRemisionController as GuiaCtrl">

    <div class=" col-xs-12 col-md-12 col-lg-11">

        <div class="box box-solid">
            <div class="box-header " > 
                <i class="fa fa-list-ul"></i>
                <h3 class="box-title">Listado de Guias</h3>
            </div>
            <div class="box-body ">
                <div class="form-group row">
                    <div  class="col-md-12"> 
                        <table class="table table-striped text-center"  datatable="ng" dt-instance="dtInstance" style="font-size: 12px;">
                            <thead >
                                <tr>
                                    <th>ITEM</th>
                                    <th>SERIE</th>
                                    <th>CORRELATIVO</th>
                                    <th>FECHA TRASLADO</th>
                                    <th></th>

                                </tr>
                            </thead>
                            <tbody >
                                <tr ng-repeat="x in GuiaCtrl.guias">
                                    <td>/% $index + 1 %/ </td>
                                    <td>/% "000".substring(0, 3 - x.serie_guiaRemision.length) + x.serie_guiaRemision %/</td>
                                    <td>/% "00000000".substring(0, 8 - x.numero_guiaRemision.length) + x.numero_guiaRemision %/ </td>
                                    <td>/% x.fecha_traslado %/ </td>
                                    <td> 
                                        <a href="" data-toggle="tooltip" title="Detalle de Guia" ng-click="GuiaCtrl.edit(x)"><i class="fa fa-search fa-2x"></i></a> 
                                        <!-- <a href="" data-toggle="tooltip" title="Eliminar Factura" ng-click="GuiaCtrl.deleteAttempt(x.id)"><i class="fa fa-trash fa-2x"></i></a>  -->
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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

    app.controller('AdsGuiaRemisionController', function AdsGuiaRemisionController(GuiaRemisionFactory){
        
        var vm = this;

        vm.guias = GuiaRemisionFactory.Guia;

        GuiaRemisionFactory.getGuias();

        vm.create = function(){
            GuiaRemisionFactory.create();
        }

        vm.edit = function(scope){
            GuiaRemisionFactory.edit(scope);
        }

        vm.formatNumber = function(num, simbol){
            
            var separador = ","; // separador para los miles
            var sepDecimal = '.'; // separador para los decimales

            num =  Math.round(num*100)/100; // permite redondear el valor a dos decimales
            num +='';
            var splitStr = num.split('.');
            var splitLeft = splitStr[0];
            var splitRight = splitStr.length > 1 ? sepDecimal + splitStr[1] : '';
            var regx = /(\d+)(\d{3})/;
            while (regx.test(splitLeft)) {
                splitLeft = splitLeft.replace(regx, '$1' + separador + '$2');
            }
            return simbol + splitLeft  +splitRight;
        }

        vm.modal_asociar = function(scope){

            GuiaRemisionFactory.modal_asociar(scope);
        }

        vm.deleteAttempt = function(id){

            GuiaRemisionFactory.deleteAttempt(id);
        }

    });


    app.factory('GuiaRemisionFactory', function GuiaRemisionFactory($http, $modal, $filter ) {
         
        GuiaRemisionFactory.Guia_edit = {};

        GuiaRemisionFactory.Guia = [];

        GuiaRemisionFactory.getGuias = function() {
        angular.element(div_loader).removeClass('hide');
            return $http.get('AdsGuiaRemision/getAllGuiasCompra').success(function(data) {
        angular.element(div_loader).addClass('hide');
                console.log(data.datos);
                angular.copy(data.datos, GuiaRemisionFactory.Guia);
            });
        }

        /* ------------------------------Estas dos funciones eliminan datos -----------------------*/
        GuiaRemisionFactory.deleteAttempt = function(id) {
            $modal.open( { 
                templateUrl:'templates_angular/deleteAttemp.html', 
                controller: function($scope, $modalInstance, GuiaRemisionFactory) {
                    $scope.yes = function() {
                        GuiaRemisionFactory.delete(id).then(function() { 
                            $modalInstance.close();
                        });                         
                    }
                }
            });
        }      
        // Delete Request
        GuiaRemisionFactory.delete = function(id) {
        angular.element(div_loader).removeClass('hide');
            return $http.delete('AdsComprobanteVenta/' + id).success(function(data) {
        angular.element(div_loader).addClass('hide');
                angular.copy(data.datos, GuiaRemisionFactory.Guia);
            });
        }
        /* ------------------------------FIN - Estas dos funciones eliminan datos -----------------------*/
        
        /* Store Request */
        GuiaRemisionFactory.create = function(){
            $modal.open({
                templateUrl: 'templates_angular/AdsGuiaRemisionController/create.html',
                controller: function($scope, $modalInstance, $filter){
                    $scope.moneda = {};
                    $scope.store = function(){
                        if ( $("#create_form").validationEngine('validate') ) {
                            GuiaRemisionFactory.store($scope.moneda);
                            $modalInstance.close();
                        };
                    }
                },
                resolve: {
                    
                }
            });
        }

        GuiaRemisionFactory.edit = function(scope){
            console.log(scope);
            angular.copy(scope, GuiaRemisionFactory.Guia_edit);
            $modal.open({
                templateUrl: 'templates_angular/GuiaRemisionController/visualizar.html',
                controller: function($scope, $modalInstance, Comprobante_edit){
                    $scope.comprobante = Comprobante_edit;
                    /* Crear funcion para la vista */
                    $scope.formatNumber = function(num, simbol){
                        var separador = ","; // separador para los miles
                        var sepDecimal = '.'; // separador para los decimales

                        num =  Math.round(num*100)/100; // permite redondear el valor a dos decimales
                        num +='';
                        var splitStr = num.split('.');
                        var splitLeft = splitStr[0];
                        var splitRight = splitStr.length > 1 ? sepDecimal + splitStr[1] : '';
                        var regx = /(\d+)(\d{3})/;
                        while (regx.test(splitLeft)) {
                            splitLeft = splitLeft.replace(regx, '$1' + separador + '$2');
                        }
                        return simbol + splitLeft  +splitRight;
                    }
                },
                resolve: {
                    Comprobante_edit : function(){
                        return GuiaRemisionFactory.Guia_edit;
                    }
                }
            });
        }

        GuiaRemisionFactory.update = function(moneda){ 
        angular.element(div_loader).removeClass('hide');
            $http.put('AdsMoneda/'+moneda.id,moneda).success(function(data){
        angular.element(div_loader).addClass('hide');
                angular.copy(data.datos, GuiaRemisionFactory.Guia);
            });
        }

        GuiaRemisionFactory.modal_asociar = function(scope){
            $modal.open( { 
                templateUrl:'templates_angular/DetalleNotaController/asociar_comprobante_compra.html', 
                controller: function($scope, $modalInstance) {
                    $scope.factura = {};
                    $scope.asociar = function(){

                        $http.post('AdsComprobanteCompra/getFacturaBySerieNumero', {comprobante_compra:$scope.factura})
                            .success(function(data){

                                if(data.datos == ''){
                                    sweetAlert("Error", "Esta Factura de Compra no existe", "error");
                                }
                                else{

                                    $http.post('AdsDetalleNota/asociar_factura', {nota:scope, comprobante:data.datos[0], tipo_comprobante: 'compra'})
                                        .success(function(response){

                                            GuiaRemisionFactory.getGuias();

                                            swal({   
                                                    title: "Registro exitoso!"
                                                    ,   text: "El registro se realizó con éxito"
                                                    ,   type: "success"
                                                    ,   confirmButtonText: "OK" 
                                                    ,   timer: 2000
                                                });

                                            $modalInstance.close();
                                        });
                                    
                                    

                                }

                                
                            });

                    }
                }
            });
        }

        GuiaRemisionFactory.modal_asociar_retenedor = function(scope){
            console.log('scope');
            console.log(scope);
            $modal.open( { 
                templateUrl:'templates_angular/AdsGuiaRemisionController/asociar_retenedor.html', 
                controller: function($scope, $modalInstance, GuiaRemisionFactory) {
                    $scope.comprobante_retenedor = {};

                    $scope.asociar = function(){
                        var serie = $scope.comprobante_retenedor.serie;
                        var numero = $scope.comprobante_retenedor.numero;
                        

        angular.element(div_loader).removeClass('hide');
                        $http.put('AdsAsociarComprobante/'+scope.id,$scope.comprobante_retenedor).success(function(data){
        angular.element(div_loader).addClass('hide');
                            // angular.copy(data.datos, ColorFactory.Color);
                            if(data.datos=='correcto'){
                                $modalInstance.close();
                                
                                GuiaRemisionFactory.getComprobanteVenta();
                                $modal.open({
                                    templateUrl: 'templates_angular/ComprobanteCompraController/msj_exito.html',
                                    controller: function($scope, $modalInstance){
                                    }
                                });

                            } 
                            else if(data.datos == 'duplicidad'){
                                alert('¡Existe otro comprobante de compra con estos datos!');
                            }
                        });

                    }

                }
            });
        }

 
        return GuiaRemisionFactory;
 
    });
   
</script>

@endsection