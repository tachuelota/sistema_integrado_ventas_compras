@extends('templates.layout')
@section('title')
Control  Tipo Cliente
@endsection

@section('head')
    <link href="{{ asset('plugins/morris/morris.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('breadcrumb')
    <h1 style="color:#222d32; font-family: arial;">Tipo Cambio de Moneda<small style="color:#222d32; font-family: arial;"> / Comprobante</small></h1>
    
@endsection
@section('content')


<div ng-app="myApp" ng-controller="TipoCambioMonedaController as TipoCambioMonedaCtrl">
    <div class="row">
        <div class=" col-xs-12 col-md-6 col-md-offset-3">
            
            <div class="box box-solid">
                <div class="box-header " > 
                    <i class="fa fa-dollar"></i>
                    <h3 class="box-title">Tipo de cambio</h3>
                </div>
                <div class="box-body ">
                    <div class="row">
                        <div class="col-md-3 text-right">
                            <label>Valor de Compra</label>
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" ng-model="TipoCambioMonedaCtrl.tipoCambio.valor_compra">
                        </div>
                        <div class="col-md-3 text-right">
                            <label>Valor de Venta</label>
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" ng-model="TipoCambioMonedaCtrl.tipoCambio.valor_venta">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4 col-md-offset-4">
                          <button class="btn btn-success btn-block" data-toggle="tooltip" data-placement="top" title="Aceptar" ng-click="TipoCambioMonedaCtrl.store()"><i class="fa fa-dollar"></i> Guardar</button>
                          
                        </div>
                    </div>
                </div>

                <!-- <div class="box-footer bg-info">
                  
                  
                </div> -->
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

    app.controller('TipoCambioMonedaController', function TipoCambioMonedaController(TipoCambioMonedaFactory){
        
        var vm = this;

        vm.store = function(){
            vm.tipoCambio.fecha = 'HOY';
            TipoCambioMonedaFactory.store(vm.tipoCambio);
        }


    });


    app.factory('TipoCambioMonedaFactory', function TipoCambioMonedaFactory($http, $modal, $filter ) {
         
        TipoCambioMonedaFactory.store = function(personalTransporte) {
                
            $http.post('AdsTipoCambioMoneda', personalTransporte).success(function(data){

                var link = sessionStorage.getItem("item_1");
                if(link == null){
                    link = 'main';
                }
                location.href = link;
            });
        }
 
        return TipoCambioMonedaFactory;
 
    });
    
</script>

@endsection