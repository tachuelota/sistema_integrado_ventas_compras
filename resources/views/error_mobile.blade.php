<!DOCTYPE html>
<html>
    <head>
    <meta charset="UTF-8">
    <title>@yield('title') | Vi'Pilarss</title>
    <link rel="shortcut icon" href="dist/img/isotipo_pilarss.png">
        @include('templates.head')
        <style>
            p{
                padding-top: 5vm;
            }
        </style>
    </head>
    <body>
        
            <section class="content">   
                <div class="row">
                    <p>Este usuario no tiene permisos para acceder al sistema desde dispositivos moviles </p>
                    <a href="{{ url('/auth/logout') }}" class="btn btn-default btn-flat btn_user_footer">Cerrar Sesion</a>
                </div>
            </section>

        <script src="{{ asset('plugins/jQuery/jquery-2.1.3.js') }}"></script>
    </body>
</html>

