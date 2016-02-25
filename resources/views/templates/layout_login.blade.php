<!DOCTYPE html>
<html>
    <head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="dist/img/logo_ico.ico">
    <title>@yield('title') | Maberic Corporacion</title>
        @include('templates.head')
        @yield('head')
    </head>


    <body class="login-page">
    <div class="login-box">
      @yield('content')
    </div><!-- /.login-box -->
    
        @include('templates.footer')
        @yield('script')
    </body>
</html>