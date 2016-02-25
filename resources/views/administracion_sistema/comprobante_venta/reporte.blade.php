@extends('templates.layout')
@section('title')
Control  Tipo Cliente
@endsection

@section('head')

    <style>
        .bar-legend, .line-legend{
            padding: 10px;
            list-style: none;
        }
        .bar-legend li, .line-legend li{
            display:inline-block;
            padding-right: 15px; 
        }
        .bar-legend span, .line-legend span{
            display:inline-block;
            width:35px;
            height:15px;
            margin-right:5px;
        }
        .chart{
            zoom: 125%;
        }
    </style>
    <!-- <link href="{{ asset('plugins/morris/morris.css') }}" rel="stylesheet" type="text/css" /> -->
@endsection

@section('breadcrumb')
    <h1><small></small></h1>
    <ol class="breadcrumb">
        <li><a href="{{asset('/')}}"><i class="fa fa-home"></i> Principal</a></li>
        <li><a href="{{asset('/')}}"><i class="fa fa-fw fa-shopping-cart"></i> Reportes Generales</a></li>
        <li class="active"><i class="fa fa-fw fa-building-o"></i> Reporte de Ventas</li>
    </ol>
@endsection

@section('content')
<div ng-app="myApp" ng-controller="ComprobanteVentaController as LetraCtrl">

    <div class=" col-xs-12 col-md-12 col-lg-11">

        <div class="box box-solid">
            <div class="box-header " > 
                <i class="fa fa-list-ul"></i>
                <h3 class="box-title">Reporte de Ventas</h3>
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
                            <input type="text" id="fecha_desde" class="form-control validate[required]" datepicker-popup="/% format %/" ng-model="LetraCtrl.fecha_desde" is-open="opened_fec_inicio" current-text="Hoy" weeks-text="Semanas" close-text="Cerrar" placeholder="Desde"/>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </span>
                            <input type="text" id="fecha_hasta" class="form-control validate[required]" datepicker-popup="/% format %/" ng-model="LetraCtrl.fecha_hasta" is-open="opened_fec_inicio2" current-text="Hoy" weeks-text="Semanas" close-text="Cerrar" placeholder="Hasta"/>
                        </div>
                    </div>
                    <!-- <div class="col-md-2 text-right" style="padding-top: 4px;">
                        Razon Social: 
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control validate[required]" maxlength="20" ng-model="LetraCtrl.filtro.razon_social">
                    </div> -->
                    <div class="col-md-3">
                        <a href="" class="btn btn-block btn-success" ng-click="LetraCtrl.ventas_2013()"> Exportar <i class="fa fa-file-excel-o "></i></a>
                    </div>
                </div>
                <!-- <hr> -->

            </div>
        </div>   
    </div>  

    <div class=" col-xs-12 col-md-12 col-lg-11">

        <div class="box box-solid">
            <div class="box-header " > 
                <i class="fa fa-list-ul"></i>
                <h3 class="box-title">Reporte de Ventas</h3>
            </div>
            <div class="box-body ">
                <div class="form-group row">
                    <div class="col-md-12" style="padding-top: 4px;">
                        <div class="chart">

                            <canvas id="ventas_mensual" ></canvas>
                        </div>
                    </div>
                    
                </div>
                <!-- <hr> -->

                <div id="leyenda" class="text-center"></div>
            </div>

            <!-- <div class="box-footer"> -->
                
            <!-- </div> -->
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

<script src="{{ asset('plugins/chartjs/Chart.js') }}" type="text/javascript"></script>

@endsection

@section('script')
<script type="text/javascript">

    // var width_graf_1 = angular.element(ventas_mensual).parent()[0].offsetWidth;
    
    // angular.element(ventas_mensual).attr('width',width_graf_1-50);
    // $('#ventas_mensual').css('width',width_graf_1-50);

Chart.defaults.global.responsive = true;

    var app = angular.module('myApp',[ 'ui.bootstrap','ngRoute','angucomplete-alt','datatables']);
 
    app.config(function($interpolateProvider){
        $interpolateProvider.startSymbol('/%');
        $interpolateProvider.endSymbol('%/');
    });

    app.controller('ComprobanteVentaController', function ComprobanteVentaController(ComprobanteVentaFactory){
        
        var vm = this;

        vm.letras = ComprobanteVentaFactory.SeguimientoLetra;
        vm.estados_letra = ComprobanteVentaFactory.EstadosLetra;

        vm.create = function(){
            ComprobanteVentaFactory.create();
        }

        vm.edit = function(scope){
            ComprobanteVentaFactory.edit(scope);
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

            ComprobanteVentaFactory.modal_asociar(scope);
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


        vm.ventas_2013 = function(){

            if(vm.fecha_desde != undefined){
                vm.fecha_desde = new XDate(vm.fecha_desde).toString('yyyy-MM-dd');
            }
            else{
                vm.fecha_desde = null;
            }
            if(vm.fecha_hasta != undefined){
                vm.fecha_hasta = new XDate(vm.fecha_hasta).toString('yyyy-MM-dd');
            }
            else{
                vm.fecha_hasta = null;
            }
            ComprobanteVentaFactory.ventas_2013({fecha_desde:vm.fecha_desde, fecha_hasta:vm.fecha_hasta});
        }

        ComprobanteVentaFactory.getReporteVentaMensual();

    });


    app.factory('ComprobanteVentaFactory', function ComprobanteVentaFactory($http, $modal, $filter ) {
         
        ComprobanteVentaFactory.SeguimientoLetra_edit = {};

        ComprobanteVentaFactory.SeguimientoLetra = [];
        ComprobanteVentaFactory.EstadosLetra = [];
        ComprobanteVentaFactory.datos_2013 = [];
        ComprobanteVentaFactory.datos_2014 = [];
        ComprobanteVentaFactory.datos_2015 = [];


        ComprobanteVentaFactory.getLetrasWithFilter = function(scope) {
                angular.element(div_loader).removeClass('hide');
            // console.log(scope);
            location.href='AdsDetallePago/getLetrasWithFilter/'+scope.fecha_desde+'/'+scope.fecha_hasta+'/'+scope.razon_social;
            // $http.get('AdsDetallePago/getLetrasWithFilter/'+scope.fecha_desde+'/'+scope.fecha_hasta).success(function(data) {
                // console.log(data.datos);
                // angular.copy(data.datos, ComprobanteVentaFactory.SeguimientoLetra);
            // });
                            angular.element(div_loader).addClass('hide');
        }


        ComprobanteVentaFactory.ventas_2013 = function(scope) {
                // angular.element(div_loader).removeClass('hide');
            location.href='AdsComprobanteVenta/ventas_2013/'+JSON.stringify(scope);
                            // angular.element(div_loader).addClass('hide');
        }


        ComprobanteVentaFactory.getReporteVentaMensual = function() {
        angular.element(div_loader).removeClass('hide');
            // 
            $http.get('AdsComprobanteVenta/getReporteVentaMensual2013').success(function(data_1) {
                $http.get('AdsComprobanteVenta/getReporteVentaMensual2014').success(function(data_2) {
                    $http.get('AdsComprobanteVenta/getReporteVentaMensual2015').success(function(data_3) {


                        // Get context with jQuery - using jQuery's .get() method.
                        var ctx = $("#ventas_mensual").get(0).getContext("2d");
                        var options = {
                                ///Boolean - Whether grid lines are shown across the chart
                                    scaleShowGridLines : true,

                                    //String - Colour of the grid lines
                                    scaleGridLineColor : "rgba(0,0,0,.05)",

                                    //Number - Width of the grid lines
                                    scaleGridLineWidth : 1,

                                    //Boolean - Whether to show horizontal lines (except X axis)
                                    scaleShowHorizontalLines: true,

                                    //Boolean - Whether to show vertical lines (except Y axis)
                                    scaleShowVerticalLines: true,

                                    //Boolean - Whether the line is curved between points
                                    bezierCurve : true,

                                    //Number - Tension of the bezier curve between points
                                    bezierCurveTension : 0.4,

                                    //Boolean - Whether to show a dot for each point
                                    pointDot : true,

                                    //Number - Radius of each point dot in pixels
                                    pointDotRadius : 4,

                                    //Number - Pixel width of point dot stroke
                                    pointDotStrokeWidth : 1,

                                    //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
                                    pointHitDetectionRadius : 20,

                                    //Boolean - Whether to show a stroke for datasets
                                    datasetStroke : true,

                                    //Number - Pixel width of dataset stroke
                                    datasetStrokeWidth : 2,

                                    //Boolean - Whether to fill the dataset with a colour
                                    datasetFill : true,

                                    //String - A legend template
                                    legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].strokeColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"

                            };

                   
                        var data = {
                        labels: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Setiembre", "Octubre", "Noviembre", "Diciembre"],
                        datasets: [
                                {
                                    label: "2013",
                                    fillColor: "rgba(220,220,220,0.2)",
                                    strokeColor: "rgba(220,220,220,1)",
                                    pointColor: "rgba(220,220,220,1)",
                                    pointStrokeColor: "#fff",
                                    pointHighlightFill: "#fff",
                                    pointHighlightStroke: "rgba(220,220,220,1)",
                                    data: data_1.datos
                                }
                                ,
                                {
                                    label: "2014",
                                    fillColor: "rgba(151,187,205,0.2)",
                                    strokeColor: "rgba(151,187,205,1)",
                                    pointColor: "rgba(151,187,205,1)",
                                    pointStrokeColor: "#fff",
                                    pointHighlightFill: "#fff",
                                    pointHighlightStroke: "rgba(151,187,205,1)",
                                    data: data_2.datos
                                }
                                ,
                                {
                                    label: "2015",
                                    fillColor: "rgba(131,167,185,0.2)",
                                    strokeColor: "rgba(131,167,185,1)",
                                    pointColor: "rgba(131,167,185,1)",
                                    pointStrokeColor: "#fff",
                                    pointHighlightFill: "#fff",
                                    pointHighlightStroke: "rgba(131,167,185,1)",
                                    data: data_3.datos
                                }
                            ]
                        };


                        // This will get the first returned node in the jQuery collection.
                        var myLineChart = new Chart(ctx).Line(data, options);
                        // myLineChart.destroy();
                        angular.element(leyenda).html(myLineChart.generateLegend());
                        angular.element(div_loader).addClass('hide');

                    });


                });

            });
        }


        ComprobanteVentaFactory.deleteAttempt = function(id) {
            $modal.open( { 
                templateUrl:'templates_angular/deleteAttemp.html', 
                controller: function($scope, $modalInstance, ComprobanteVentaFactory) {
                    $scope.yes = function() {
                        ComprobanteVentaFactory.delete(id).then(function() { 
                            $modalInstance.close();
                        });                         
                    }
                }
            });
        }      

        ComprobanteVentaFactory.delete = function(id) {
            return $http.delete('AdsMoneda/' + id).success(function(data) {
                angular.copy(data.datos,ComprobanteVentaFactory.SeguimientoLetra);
            });
        }

        ComprobanteVentaFactory.create = function(){
            $modal.open({
                templateUrl: 'templates_angular/ComprobanteVentaController/create.html',
                controller: function($scope, $modalInstance, $filter){
                    $scope.moneda = {};
                    $scope.store = function(){
                        if ( $("#create_form").validationEngine('validate') ) {
                            ComprobanteVentaFactory.store($scope.moneda);
                            $modalInstance.close();
                        };
                    }
                },
                resolve: {
                    
                }
            });
        }

        ComprobanteVentaFactory.edit = function(scope){
            console.log(scope);
            angular.copy(scope, ComprobanteVentaFactory.SeguimientoLetra_edit);
            $modal.open({
                templateUrl: 'templates_angular/ComprobanteVentaController/visualizar.html',
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
                        return ComprobanteVentaFactory.SeguimientoLetra_edit;
                    }
                }
            });
        }

        ComprobanteVentaFactory.update = function(scope,id_estado){ 
            return $http.put('AdsDetallePago/'+id_estado,scope).success(function(data){
                angular.copy(data.datos, ComprobanteVentaFactory.SeguimientoLetra);
            });
        }


        return ComprobanteVentaFactory;
 
    });
   
</script>

@endsection