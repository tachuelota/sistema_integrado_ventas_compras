@extends('templates.layout')

@section('title')
Control  Tipo liente
@endsection

@section('head')
    <link href="{{ asset('plugins/morris/morris.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('breadcrumb')
    <h1>Lista  Tipo liente<small> / Control  Tipo liente</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{asset('/')}}"><i class="fa fa-home"></i> Principal</a></li>
        <li><a href="{{asset('/')}}"><i class="fa fa-fw fa-shopping-cart"></i> Control Perfil Tipo liente</a></li>
        <li class="active"><i class="fa fa-fw fa-building-o"></i> Lista  Tipo liente</li>
    </ol>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 col-lg-10 col-lg-offset-1">
        <div class="box box-warning box-solid"><br></br>          
            
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-10 col-lg-offset-1">
                    <div class="box box-warning box-solid">
                        <div class="box-header with-border">
                            <i class="fa fa-users"></i>
                            <h3 class="box-title"> Lista  Tipo liente</h3>
                          </div>
                        <div class="box-body">
                            <table id="table_main" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Nombre  Tipo liente</th>
                                        <th>xxxxxxx</th>
                                        <th>xxxxxx</th>
                                        <th></th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>xxxx</td>
                                        <td>xxx</td>
                                        <td>xx</td>
                                        <td><a href="" class="btn btn-warning editasiento"><i class="fa fa-edit" data-toggle="tooltip" ></i></a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
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
    $(function () {
            $("#table_main").dataTable();

});
    
</script>

@endsection