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
        <li><a href="{{asset('/')}}"><i class="fa fa-fw fa-shopping-cart"></i> Módulo de Cobranzas</a></li>
        <li class="active"><i class="fa fa-fw fa-building-o"></i> Reporte de Letras</li>
    </ol>
@endsection

@section('content')
<div ng-app="myApp" ng-controller="DetallePagoController as LetraCtrl">

    <div class=" col-xs-12 col-md-12 col-lg-11">

        <div class="box box-solid">
            <div class="box-header " > 
                <i class="fa fa-list-ul"></i>
                <h3 class="box-title">Reporte de Letras</h3>
            </div>
            <div class="box-body ">
                <div class="form-group row">
                    <div class="col-md-1 text-right" style="padding-top: 4px;">
                        Fecha:
                    </div>
                    <div class="col-md-2">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </span>
                            <input type="text" id="fecha_desde" class="form-control validate[required]" datepicker-popup="/% format %/" ng-model="LetraCtrl.filtro.fecha_desde" is-open="opened_fec_inicio" current-text="Hoy" weeks-text="Semanas" close-text="Cerrar" placeholder="Desde"/>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </span>
                            <input type="text" id="fecha_hasta" class="form-control validate[required]" datepicker-popup="/% format %/" ng-model="LetraCtrl.filtro.fecha_hasta" is-open="opened_fec_inicio2" current-text="Hoy" weeks-text="Semanas" close-text="Cerrar" placeholder="Hasta"/>
                        </div>
                    </div>
                    <div class="col-md-2 text-right" style="padding-top: 4px;">
                        Razon Social: 
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control validate[required]" maxlength="20" ng-model="LetraCtrl.filtro.razon_social">
                    </div>
                    <div class="col-md-3">
                        <a href="" class="btn btn-block btn-success" ng-click="LetraCtrl.filtrar_letras()"> Filtrar <i class="fa fa-search"></i></a>
                    </div>
                </div>
                <!-- <hr> -->

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

        <!-- <div id="content-aside-right">
            <ul id="aside-right" class="btn-group-vertical">
              <li onclick="location.href='AdsComprobanteVenta_create'" class=" ">
                <div id="item-box-icon">
                    <i class="fa fa-plus"></i> 
                </div>
                <div id="item-box-text"> REGISTRAR FACTURA</div>
              </li>
            </ul>
        </div> -->

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

    app.controller('DetallePagoController', function DetallePagoController(SeguimientoLetraFactory){
        
        var vm = this;

        vm.letras = SeguimientoLetraFactory.SeguimientoLetra;
        vm.estados_letra = SeguimientoLetraFactory.EstadosLetra;

        vm.create = function(){
            SeguimientoLetraFactory.create();
        }

        vm.edit = function(scope){
            SeguimientoLetraFactory.edit(scope);
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

            SeguimientoLetraFactory.modal_asociar(scope);
        }

        vm.estado_change = function(scope,id_estado){
            SeguimientoLetraFactory.CambiarEstado(scope,id_estado);
        }

        //Configuracion para FECHA

        vm.today = function() {
            vm.fecha_comprobante = new Date();
        }
        vm.clear = function () {
            vm.fecha_comprobante = null;
        }
        vm.open = function($event) {
            $event.preventDefault();
            $event.stopPropagation();
            vm.opened_fec_inicio = true;
        }


        vm.formats = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
        vm.format = 'yyyy/MM/dd';


        vm.filtrar_letras = function(){
            vm.filtro.fecha_desde = new XDate(vm.filtro.fecha_desde).toString('yyyy-MM-dd');
            vm.filtro.fecha_hasta = new XDate(vm.filtro.fecha_hasta).toString('yyyy-MM-dd');
            if(vm.filtro.razon_social = 'undefined'){
                vm.filtro.razon_social = "null";
                console.log('sdASDAsdadasdas');
            } 
            console.log(vm.filtro.razon_social);
            SeguimientoLetraFactory.getLetrasWithFilter(vm.filtro);
        }
    });


    app.factory('SeguimientoLetraFactory', function SeguimientoLetraFactory($http, $modal, $filter ) {
         
        SeguimientoLetraFactory.SeguimientoLetra_edit = {};

        SeguimientoLetraFactory.SeguimientoLetra = [];
        SeguimientoLetraFactory.EstadosLetra = [];


        SeguimientoLetraFactory.getLetrasWithFilter = function(scope) {
            // console.log(scope);
            location.href='AdsDetallePago/getLetrasWithFilter/'+scope.fecha_desde+'/'+scope.fecha_hasta+'/'+scope.razon_social;
            // $http.get('AdsDetallePago/getLetrasWithFilter/'+scope.fecha_desde+'/'+scope.fecha_hasta).success(function(data) {
                // console.log(data.datos);
                // angular.copy(data.datos, SeguimientoLetraFactory.SeguimientoLetra);
            // });
        }


        SeguimientoLetraFactory.getEstadoLetra = function() {
            return $http.get('AdsComprobanteVenta/getAllEstadoLetra').success(function(data) {
                angular.copy(data.datos, SeguimientoLetraFactory.EstadosLetra);
            });
        }


        SeguimientoLetraFactory.deleteAttempt = function(id) {
            $modal.open( { 
                templateUrl:'templates_angular/deleteAttemp.html', 
                controller: function($scope, $modalInstance, SeguimientoLetraFactory) {
                    $scope.yes = function() {
                        SeguimientoLetraFactory.delete(id).then(function() { 
                            $modalInstance.close();
                        });                         
                    }
                }
            });
        }      

        SeguimientoLetraFactory.delete = function(id) {
            return $http.delete('AdsMoneda/' + id).success(function(data) {
                angular.copy(data.datos,SeguimientoLetraFactory.SeguimientoLetra);
            });
        }

        SeguimientoLetraFactory.create = function(){
            $modal.open({
                templateUrl: 'templates_angular/DetallePagoController/create.html',
                controller: function($scope, $modalInstance, $filter){
                    $scope.moneda = {};
                    $scope.store = function(){
                        if ( $("#create_form").validationEngine('validate') ) {
                            SeguimientoLetraFactory.store($scope.moneda);
                            $modalInstance.close();
                        };
                    }
                },
                resolve: {
                    
                }
            });
        }

        SeguimientoLetraFactory.edit = function(scope){
            console.log(scope);
            angular.copy(scope, SeguimientoLetraFactory.SeguimientoLetra_edit);
            $modal.open({
                templateUrl: 'templates_angular/DetallePagoController/visualizar.html',
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
                        return SeguimientoLetraFactory.SeguimientoLetra_edit;
                    }
                }
            });
        }

        SeguimientoLetraFactory.update = function(scope,id_estado){ 
            return $http.put('AdsDetallePago/'+id_estado,scope).success(function(data){
                angular.copy(data.datos, SeguimientoLetraFactory.SeguimientoLetra);
            });
        }


        SeguimientoLetraFactory.CambiarEstado = function(scope,id_estado) {
            $modal.open( { 
                templateUrl:'templates_angular/DetallePagoController/cambiar_estado.html', 
                controller: function($scope, $modalInstance, SeguimientoLetraFactory) {
                    $scope.yes = function() {
                        SeguimientoLetraFactory.update(scope,id_estado).then(function() { 
                            $modalInstance.close();
                        });                         
                    }
                }
            });
        }  

        return SeguimientoLetraFactory;
 
    });
   
</script>

@endsection