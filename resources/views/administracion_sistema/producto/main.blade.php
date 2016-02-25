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
                    
                    <div  class="col-md-12"> 
                        <table class="table table-striped text-center"  datatable="ng" dt-instance="dtInstance" style="font-size: 12px;">
                            <thead >
                                <tr>
                                    <th>ITEM</th>
                                    <th>CODIGO PRODUCTO</th>
                                    <th>PRODUCTO</th>
                                    <th>UNIDAD DE MEDIDA</th>
                                    <!--<th>PESO</th>-->
                                    <!-- <th>STOCK</th> -->
                                    <th>PRECIO UNITARIO</th>
                                    <th>IMAGEN</th>
                                    <th style="width : 150px;">ACCION</th>
                                </tr>
                            </thead>
                            <tbody >
                                <tr ng-repeat="x in ProductoCtrl.productos | filter: ProductoCtrl.buscar_producto">
                                    <td>/% $index + 1 %/ </td>
                                    <td>/% x.codigo_producto %/ </td>
                                    <td>/% x.nombre_producto %/ </td>
                                    <td>/% x.unidad_medida.nombre_unidad_medida %/ </td>
                                    <!--<td>/% x.peso %/ </td>-->
                                    <!-- <td>/% x.stock %/ </td> -->
                                    <td>/% x.precio_unitario %/ </td>
                                    <td> <a href="#" ng-click="ProductoCtrl.MostrarImagen(x.imagen_producto)"><i class="fa fa-search fa-2x"></a></i> </td>
                                    <td>
                                        <a ng-click="ProductoCtrl.edit(x)" class="btn btn-success">
                                            <i class="fa fa-edit" data-toggle="tooltip" title="Modificar"></i>
                                        </a>
                                        <a ng-click="ProductoCtrl.eliminar(x.id)" class="btn btn-danger">
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
              <li ng-click="ProductoCtrl.create()" class=" ">
                <div id="item-box-icon">
                    <i class="fa fa-plus"></i> 
                </div>
                <div id="item-box-text"> REGISTRAR PRODUCTO</div>
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
    var variable_nombre;
 
    app.config(function($interpolateProvider){
        $interpolateProvider.startSymbol('/%');
        $interpolateProvider.endSymbol('%/');
    });

    app.controller('ProductoController', function ProductoController(ProductoFactory){
        var vm = this;

        vm.productos = ProductoFactory.Productos;
        vm.composicion = ProductoFactory.Composicion;
        vm.titulo = ProductoFactory.Titulo;
        vm.hilatura = ProductoFactory.Hilatura;
        vm.tipoProducto = ProductoFactory.TipoProducto;
        vm.tipoTela = ProductoFactory.TipoTela;

        ProductoFactory.getAllProductos();
        ProductoFactory.getAllUnidadMedida();
        ProductoFactory.getAllComposicion();
        ProductoFactory.getAllTitulo();
        ProductoFactory.getAllHilatura();
        ProductoFactory.getAllTipoProducto();
        ProductoFactory.getAllTipoTela();
        ProductoFactory.getAllColor();

        vm.eliminar = function(id_cliente){
            ProductoFactory.deleteAttempt(id_cliente);
        }
        
        vm.create = function(){

            ProductoFactory.create();
        }

        vm.edit = function(Cliente){
            ProductoFactory.edit(Cliente);
        }

          
        vm.MostrarImagen = function(Imagen){
            ProductoFactory.MostrarImagen(Imagen);
        }

          
 
    });


    app.factory('ProductoFactory', function ProductoFactory($http, $modal, $filter, upload ) {
         
        ProductoFactory.Producto_edit = {};

        ProductoFactory.Productos = [];
        ProductoFactory.UnidadMedida = [];
        ProductoFactory.Composicion = [];
        ProductoFactory.Titulo = [];
        ProductoFactory.Hilatura = [];
        ProductoFactory.TipoProducto = [];
        ProductoFactory.TipoTela = [];
        ProductoFactory.Color = [];

        ProductoFactory.getAllProductos = function() {

            return $http.get('AdsProducto/getAllProductos').success(function(data) {
                angular.copy(data.datos, ProductoFactory.Productos);
            });
        } 

        ProductoFactory.getAllComposicion = function() {
            return $http.get('AdsComposicion/getAllComposicion').success(function(data) {
                angular.copy(data.datos, ProductoFactory.Composicion );
            });
        } 
        ProductoFactory.getAllTitulo = function() {
            return $http.get('AdsTitulo/getAllTitulo').success(function(data) {
                angular.copy(data.datos, ProductoFactory.Titulo );
            });
        } 
        ProductoFactory.getAllHilatura = function() {
            return $http.get('AdsHilatura/getAllHilatura').success(function(data) {
                angular.copy(data.datos, ProductoFactory.Hilatura );
            });
        } 
        ProductoFactory.getAllTipoProducto = function() {
            return $http.get('AdsTipoProducto/getAllTipoProducto').success(function(data) {
                angular.copy(data.datos, ProductoFactory.TipoProducto );
            });
        } 

        ProductoFactory.getAllTipoTela = function() {
            return $http.get('AdsTipoTela/getAllTipoTela').success(function(data) {
                angular.copy(data.datos, ProductoFactory.TipoTela );
            });
        } 
        ProductoFactory.getAllColor = function() {
            return $http.get('AdsColor/getAllColor').success(function(data) {
                angular.copy(data.datos, ProductoFactory.Color );
            });
        } 

        ProductoFactory.getAllUnidadMedida = function() {

            return $http.get('AdsUnidadMedida/getAllUnidadMedida').success(function(data) {
                angular.copy(data.datos, ProductoFactory.UnidadMedida );
            });
        } 

        ProductoFactory.MostrarImagen = function(Imagen) {
            $modal.open( { 
                templateUrl:'templates_angular/ProductoController/imagen.html', 
                controller: function($scope, $modalInstance, ProductoFactory, Url_Imagen) {
                    
                    $scope.url_imagen = Url_Imagen;
 
                },
                resolve: {
                    Url_Imagen : function(){
                        return Imagen;
                    }
                }
 
            });
        } 


        ProductoFactory.deleteAttempt = function(id) {
            $modal.open( { 
                templateUrl:'templates_angular/deleteAttemp.html', 
                controller: function($scope, $modalInstance, ProductoFactory) {
                    
                    $scope.yes = function() {
                        ProductoFactory.delete(id).then(function() { 
                            $modalInstance.close();
                        });                         
                    }
 
                }
 
            });
        }      

        ProductoFactory.delete = function(id) {
            return $http.delete('AdsProducto/' + id).success(function(data) {
                angular.copy(data.datos,ProductoFactory.Productos);
            });
        }


        ProductoFactory.create = function(){

            $modal.open({
                templateUrl: 'templates_angular/ProductoController/create.html',
                controller: function($scope, $modalInstance, $filter, UnidadMedida, Composicion, Titulo, Hilatura, TipoProducto, TipoTela, Color){
                    $scope.producto = {};
                    $scope.unidadmedida = UnidadMedida;
                    $scope.composicion = Composicion;
                    $scope.titulo = Titulo;
                    $scope.hilatura = Hilatura;
                    $scope.tipoproducto = TipoProducto;
                    $scope.tipotela = TipoTela;
                    $scope.color = Color;

                    $scope.store = function(){
                        if ( $("#create_form").validationEngine('validate') ) {
                            ProductoFactory.store($scope.producto);
                            $modalInstance.close();
                        };
                    }

                    $scope.ImgChange = function(){
                            window.mostrarVistaPrevia = function mostrarVistaPrevia() {

                                var Archivos, Lector;
                                Archivos = jQuery('#div_mostrar_imagen #archivo')[0].files;
                                if (Archivos.length > 0) {

                                    Lector = new FileReader();
                                    Lector.onloadend = function(e) {
                                        var origen, tipo;

                                        //Envia la imagen a la pantalla
                                        origen = e.target; //objeto FileReader
                                        //Prepara la información sobre la imagen
                                        tipo = window.obtenerTipoMIME(origen.result.substring(0, 30));

                                        jQuery('#infoNombre').text(Archivos[0].name + ' (Tipo: ' + tipo + ')');
                                        jQuery('#infoTamaño').text('Tamaño: ' + e.total + ' bytes');
                                        //Si el tipo de archivo es válido lo muestra, 
                                        //sino muestra un mensaje 
                                        if (tipo !== 'image/jpeg' && tipo !== 'image/png' && tipo !== 'image/gif') {
                                            // jQuery('#vistaPrevia').attr('src', window.imagenVacia);
                                            alert('El formato de imagen no es válido: debe seleccionar una imagen JPG, PNG o GIF.');
                                        } else {
                                            jQuery('#vistaPrevia').attr('src', origen.result);
                                            // jQuery('#vistaPrevia').attr('width', '300px');
                                            window.obtenerMedidas();
                                        }

                                    };
                                    Lector.onerror = function(e) {
                                    }
                                    Lector.readAsDataURL(Archivos[0]);

                                } else {
                                    var objeto = jQuery('#archivo');
                                    objeto.replaceWith(objeto.val('').clone());
                                    jQuery('#vistaPrevia').attr('src', window.imagenVacia);
                                    jQuery('#infoNombre').text('[Seleccione una imagen]');
                                    jQuery('#infoTamaño').text('');
                                };


                            };

                            //Lee el tipo MIME de la cabecera de la imagen
                            window.obtenerTipoMIME = function obtenerTipoMIME(cabecera) {
                                return cabecera.replace(/data:([^;]+).*/, '\$1');
                            }

                            //Obtiene las medidas de la imagen y las agrega a la 
                            //etiqueta infoTamaño
                            window.obtenerMedidas = function obtenerMedidas() {
                                jQuery('<img/>').bind('load', function(e) {

                                    var tamaño = jQuery('#infoTamaño').text() + '; Medidas: ' + this.width + 'x' + this.height;

                                    jQuery('#infoTamaño').text(tamaño);

                                }).attr('src', jQuery('#vistaPrevia').attr('src'));
                            }

                            jQuery(document).ready(function() {
                                //Cargamos la imagen "vacía" que actuará como Placeholder
                                jQuery('#vistaPrevia').attr('src', window.imagenVacia);

                                //El input del archivo lo vigilamos con un "delegado"
                                jQuery('#div_mostrar_imagen').on('change', '#archivo', function(e) {
                                    window.mostrarVistaPrevia();
                                });

                                //El botón Cancelar lo vigilamos normalmente
                                jQuery('#cancelar').on('click', function(e) {
                                    var objeto = jQuery('#archivo');
                                    objeto.replaceWith(objeto.val('').clone());

                                    jQuery('#vistaPrevia').attr('src', window.imagenVacia);
                                });

                            });

                    }

              },
                resolve: {
                    UnidadMedida : function(){
                        return ProductoFactory.UnidadMedida;
                    },
                    Composicion : function(){
                        return ProductoFactory.Composicion;
                    },
                    Titulo : function(){
                        return ProductoFactory.Titulo;
                    },
                    Hilatura : function(){
                        return ProductoFactory.Hilatura;
                    },
                    TipoProducto : function(){
                        return ProductoFactory.TipoProducto;
                    },
                    TipoTela : function(){
                        return ProductoFactory.TipoTela;
                    },
                    Color : function(){
                        return ProductoFactory.Color;
                    }
                }

            });


        }
        
        ProductoFactory.store = function(Producto) {
 
            if(Producto.file!=null){
                upload.uploadFile(Producto.file);
                Producto.file_nombre = Producto.file.name;
            }
            $http.post('AdsProducto', Producto).success(function(data){
                if(data.datos == 'duplicidad'){
                    console.log('DUPLICIDAD')
                    alert('Este Producto ya existe');
                }else{
                    angular.copy(data.datos,ProductoFactory.Productos);
                            console.log('SE GRABO CORRECTAMENTE')
                }

            });
        }

        ProductoFactory.edit = function(Producto){
            console.log(Producto);
            angular.copy(Producto, ProductoFactory.Producto_edit);
            $modal.open({
                templateUrl: 'templates_angular/ProductoController/editar.html',
                controller: function($scope, $modalInstance, Producto_edit,  UnidadMedida, Composicion, Titulo, Hilatura, TipoProducto, TipoTela, Color){
                    $scope.producto = Producto_edit;
                    $scope.unidadmedida = UnidadMedida;
                    $scope.composicion = Composicion;
                    $scope.titulo = Titulo;
                    $scope.hilatura = Hilatura;
                    $scope.tipoproducto = TipoProducto;
                    $scope.tipotela = TipoTela;
                    $scope.color = Color;

                    $scope.update = function(){
                        if( $("#edit_form").validationEngine('validate') ){
                            ProductoFactory.update($scope.producto);
                            $modalInstance.close();
                        }
                    }


                    $scope.ImgChange = function(){
                            window.mostrarVistaPrevia = function mostrarVistaPrevia() {

                                var Archivos, Lector;
                                Archivos = jQuery('#div_mostrar_imagen #archivo')[0].files;
                                if (Archivos.length > 0) {

                                    Lector = new FileReader();
                                    Lector.onloadend = function(e) {
                                        var origen, tipo;

                                        //Envia la imagen a la pantalla
                                        origen = e.target; //objeto FileReader
                                        //Prepara la información sobre la imagen
                                        tipo = window.obtenerTipoMIME(origen.result.substring(0, 30));

                                        jQuery('#infoNombre').text(Archivos[0].name + ' (Tipo: ' + tipo + ')');
                                        jQuery('#infoTamaño').text('Tamaño: ' + e.total + ' bytes');
                                        //Si el tipo de archivo es válido lo muestra, 
                                        //sino muestra un mensaje 
                                        if (tipo !== 'image/jpeg' && tipo !== 'image/png' && tipo !== 'image/gif') {
                                            // jQuery('#vistaPrevia').attr('src', window.imagenVacia);
                                            alert('El formato de imagen no es válido: debe seleccionar una imagen JPG, PNG o GIF.');
                                        } else {
                                            jQuery('#vistaPrevia').attr('src', origen.result);
                                            // jQuery('#vistaPrevia').attr('width', '300px');
                                            window.obtenerMedidas();
                                        }

                                    };
                                    Lector.onerror = function(e) {
                                    }
                                    Lector.readAsDataURL(Archivos[0]);

                                } else {
                                    var objeto = jQuery('#archivo');
                                    objeto.replaceWith(objeto.val('').clone());
                                    jQuery('#vistaPrevia').attr('src', window.imagenVacia);
                                    jQuery('#infoNombre').text('[Seleccione una imagen]');
                                    jQuery('#infoTamaño').text('');
                                };


                            };

                            //Lee el tipo MIME de la cabecera de la imagen
                            window.obtenerTipoMIME = function obtenerTipoMIME(cabecera) {
                                return cabecera.replace(/data:([^;]+).*/, '\$1');
                            }

                            //Obtiene las medidas de la imagen y las agrega a la 
                            //etiqueta infoTamaño
                            window.obtenerMedidas = function obtenerMedidas() {
                                jQuery('<img/>').bind('load', function(e) {

                                    var tamaño = jQuery('#infoTamaño').text() + '; Medidas: ' + this.width + 'x' + this.height;

                                    jQuery('#infoTamaño').text(tamaño);

                                }).attr('src', jQuery('#vistaPrevia').attr('src'));
                            }

                            jQuery(document).ready(function() {
                                //Cargamos la imagen "vacía" que actuará como Placeholder
                                jQuery('#vistaPrevia').attr('src', window.imagenVacia);

                                //El input del archivo lo vigilamos con un "delegado"
                                jQuery('#div_mostrar_imagen').on('change', '#archivo', function(e) {
                                    window.mostrarVistaPrevia();
                                });

                                //El botón Cancelar lo vigilamos normalmente
                                jQuery('#cancelar').on('click', function(e) {
                                    var objeto = jQuery('#archivo');
                                    objeto.replaceWith(objeto.val('').clone());

                                    jQuery('#vistaPrevia').attr('src', window.imagenVacia);
                                });

                            });

                    }

                },
                resolve: {
                    Producto_edit : function(){
                        return ProductoFactory.Producto_edit;
                    },
                    UnidadMedida : function(){
                        return ProductoFactory.UnidadMedida;
                    },
                    Composicion : function(){
                        return ProductoFactory.Composicion;
                    },
                    Titulo : function(){
                        return ProductoFactory.Titulo;
                    },
                    Hilatura : function(){
                        return ProductoFactory.Hilatura;
                    },
                    TipoProducto : function(){
                        return ProductoFactory.TipoProducto;
                    },
                    TipoTela : function(){
                        return ProductoFactory.TipoTela;
                    },
                    Color : function(){
                        return ProductoFactory.Color;
                    }
                }
            });
        }


        ProductoFactory.update = function(Producto){ 

            if(Producto.file!=null){
                upload.uploadFile(Producto.file);
                Producto.file_nombre = Producto.file.name;
            }
            else{
                Producto.file_nombre = Producto.imagen_producto;
            }

            $http.put('AdsProducto/'+Producto.id,Producto).success(function(data){
                angular.copy(data.datos, ProductoFactory.Productos);
            });
        }
 

        return ProductoFactory;
 
    });


    app.directive('uploaderModel',['$parse', function ($parse){
        return {
            restrict: 'A',
            link: function (scope, iElement, iAttrs)
            {
                iElement.on('change', function(e)
                {
                    $parse(iAttrs.uploaderModel).assign(scope, iElement[0].files[0]);
                });
            }
        };
    }]);

    app.service('upload',['$http', '$q', function ($http, $q){
        this.uploadFile = function(file)
        {
            var deferred = $q.defer();
            var formData = new FormData()
            formData.append('file', file);
            return $http.post('AdsProducto/UploadImage', formData,{
                headers: {
                    "Content-type": undefined
                },
                transformRequest: angular.identity
            })
            .success(function(res)
            {
                return res;
            })
            .error(function(msg, code)
            {
                deferred.reject(msg);
            })
            // return deferred.promise;
        }
    }]);


        






//Este string contiene una imagen de 1px*1px color blanco
window.imagenVacia = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==';

window.mostrarVistaPrevia = function mostrarVistaPrevia() {
    var Archivos, Lector;

    Archivos = jQuery('#archivo')[0].files;
    if (Archivos.length > 0) {

        Lector = new FileReader();
        Lector.onloadend = function(e) {
            var origen, tipo;

            //Envia la imagen a la pantalla
            origen = e.target; //objeto FileReader
            //Prepara la información sobre la imagen
            tipo = window.obtenerTipoMIME(origen.result.substring(0, 30));

            jQuery('#infoNombre').text(Archivos[0].name + ' (Tipo: ' + tipo + ')');
            jQuery('#infoTamaño').text('Tamaño: ' + e.total + ' bytes');
            variable_nombre = Archivos[0].name;
            //Si el tipo de archivo es válido lo muestra, 
            //sino muestra un mensaje 
            if (tipo !== 'image/jpeg' && tipo !== 'image/png' && tipo !== 'image/gif') {
                jQuery('#vistaPrevia').attr('src', window.imagenVacia);
                alert('El formato de imagen no es válido: debe seleccionar una imagen JPG, PNG o GIF.');
            } else {
                jQuery('#vistaPrevia').attr('src', origen.result);
                // jQuery('#vistaPrevia').attr('width', '300px');
                window.obtenerMedidas();
            }

        };
        Lector.onerror = function(e) {
        }
        Lector.readAsDataURL(Archivos[0]);

    } else {
        var objeto = jQuery('#archivo');
        objeto.replaceWith(objeto.val('').clone());
        jQuery('#vistaPrevia').attr('src', window.imagenVacia);
        jQuery('#infoNombre').text('[Seleccione una imagen]');
        jQuery('#infoTamaño').text('');
    };


};

//Lee el tipo MIME de la cabecera de la imagen
window.obtenerTipoMIME = function obtenerTipoMIME(cabecera) {
    return cabecera.replace(/data:([^;]+).*/, '\$1');
}

//Obtiene las medidas de la imagen y las agrega a la 
//etiqueta infoTamaño
window.obtenerMedidas = function obtenerMedidas() {
    jQuery('<img/>').bind('load', function(e) {

        var tamaño = jQuery('#infoTamaño').text() + '; Medidas: ' + this.width + 'x' + this.height;

        jQuery('#infoTamaño').text(tamaño);

    }).attr('src', jQuery('#vistaPrevia').attr('src'));
}

jQuery(document).ready(function() {
    //Cargamos la imagen "vacía" que actuará como Placeholder
    jQuery('#vistaPrevia').attr('src', window.imagenVacia);

    //El input del archivo lo vigilamos con un "delegado"
    jQuery('#div_mostrar_imagen').on('change', '#archivo', function(e) {
        window.mostrarVistaPrevia();
    });

    //El botón Cancelar lo vigilamos normalmente
    jQuery('#cancelar').on('click', function(e) {
        var objeto = jQuery('#archivo');
        objeto.replaceWith(objeto.val('').clone());

        jQuery('#vistaPrevia').attr('src', window.imagenVacia);
    });

});

    
</script>


@endsection