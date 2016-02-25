<!DOCTYPE html>
<html>
    <head>
    <meta charset="UTF-8">
    <title>@yield('title') | Vi'Pilarss</title>
    <link rel="shortcut icon" href="dist/img/isotipo_pilarss.png">
        @include('templates.head')
        <style>
            .bg-main{
                background: url('dist/img/bg-main.png') repeat;
            }
        </style>
    </head>
    <body >
        <div class="wrapper" ng-app="myapp" ng-controller="MainCtrl">
            <section class="content">   
                <div class="row">
                    <div  class="container">
                        <h1>Ingresar la llave del sistema</h1>
                        <input type="file" on-read-file="finalizar($fileContent)" />
                    </div>
                    <br>
                    <div class="row">
                        <div class="container">
                            <button class="btn btn-success" ng-click="load_key()">Finalizar</button>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <script src="{{ asset('plugins/jQuery/jquery-2.1.3.js') }}"></script>
        <script type="text/javascript">

        var datos;
            
            var myapp = angular.module('myapp', []);

            myapp.config(function($interpolateProvider){
                    $interpolateProvider.startSymbol('/%');
                    $interpolateProvider.endSymbol('%/');
                });

            myapp.controller('MainCtrl', function ($scope, $http) {
                
                $scope.finalizar = function($fileContent){
                    datos=$fileContent;
                    console.log(datos);
                }

                $scope.load_key = function(){
                    var key = $(datos).find("Direccion_Mac_Activa").text();
                    localStorage.setItem("key_sisgam", key);
                    alert("Llave Registrada Correctamente: "+localStorage.getItem("key_sisgam"));
                    location.href = "/ymatex_sales/public/auth/login";
                }

            });




        myapp.directive('onReadFile', function ($parse) {
                return {
                    restrict: 'A',
                    scope: false,
                    link: function(scope, element, attrs) {
                        var fn = $parse(attrs.onReadFile);
                        
                        element.on('change', function(onChangeEvent) {
                            var reader = new FileReader();
                            
                            reader.onload = function(onLoadEvent) {
                                scope.$apply(function() {
                                    fn(scope, {$fileContent:onLoadEvent.target.result});
                                    
                                });
                            };
                            reader.readAsText((onChangeEvent.srcElement || onChangeEvent.target).files[0]);
                        });
                    }
                };
            });


        </script>

    </body>
</html>

