<!DOCTYPE html>
<html>
    <head>
    <meta charset="UTF-8">
    <title>@yield('title') | Ymatex</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="shortcut icon" href="dist/img/logo_ico.ico">
        @include('templates.head')
        @yield('head')
        <style>
            body {
                zoom: 80% !important;
            }
            #content-aside-right{
                z-index: 5;
                position: fixed;
                top:28%;
                right: 0;
            }

            #aside-right{
                /*position: relative;*/
                display: inline-block;
                padding: 0;
                width: 100%;
            }

            #aside-right li:first-child {
                background: rgba(8,50,106,1);
                vertical-align: middle;
            }

            #aside-right li{
                background: rgba(88,141,204,1);
                color: white;
                list-style: none;
                /*padding: 20px;*/
                cursor: pointer;
                border: 1px solid rgba(255,255,255,.8);

                -webkit-transition: ease .3s;
                -o-transition: ease .3s;
                transition: ease .3s;
            }

            #aside-right li #item-box-icon {
                position: relative;
                display: inline-block;
                padding: 20px;
                padding-left: 27px;
                padding-right: 27px;
            }

            #aside-right li #item-box-text{
                position: relative;
                display: inline-block;
                padding: 20px;
            }

            #aside-right li i{
                font-size: 2em;
            }

        </style>

    </head>
    <body class="skin-blue sidebar-mini">
        <div class="wrapper">
            <!-- Incluye el Header del Sistema -->
            @include('templates.header')
            <!-- Incluye el Menu del Sistema -->
            @include('templates.menu')
            <div class="content-wrapper bg-main" >
                <section class="content-header">
                    <!-- Define el BreadCumb -->
                    @yield('breadcrumb')
                </section>
                <section class="content">    
                    <!-- Define el Contenido -->
                    <div class="row">
                        @yield('content')
                    </div>
                </section>
            </div>
            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                  <b>Version</b> 1.0
                </div>
                <strong>Diseñado por <a href="#" target="_blank" style="font-family:'Poiret One';">[Code]</a>.</strong> Todos los Derechos Reservados.
                <!-- Definde el Footer -->
                @yield('foot')            
            </footer>

        </div>
        @include('templates.footer')
        @yield('script')
    </body>
</html>