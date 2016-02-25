<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
	    <title>Login | Ymatex</title>

		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
	    <link href="{{ asset('dist/css/AdminLTE.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('plugins/iCheck/all.css') }}" rel="stylesheet" type="text/css" />
	    <!-- FontAwesome 4.3.0 -->
		<!-- <link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'> -->
		<style>
			@import url(http://fonts.googleapis.com/css?family=Muli);
			body{
				margin: 0;
				padding: 0;
				-webkit-background-size: cover;
				background-size: cover;
				font-family: 'Muli';
				font-weight: bold;
			}
			#contenido{
				
			    /*background: url('../../public/dist/img/fondo_login.jpeg');*/
				/*-webkit-filter: blur(5px);*/
			    display: table;
			    position: relative;
			    width: 100%;
			    height: 100vh;
			}
			#fondo_login{
				position: absolute;
			    /*background: url('../../public/dist/img/fondo_login.jpeg');*/
				/*-webkit-filter: blur(3px) grayscale(.5) sepia(.2);*/
				-webkit-background-size: cover;
				background-size: cover;
				width: 100%;
				height: 100vh;
			}

			#login_logo{
				padding: 30px;
			}

			#centrar_contenido {
			    display: table-cell;
			    text-align: center;
			    vertical-align: middle;
			}

			#login_box{
				display: inline-block;
				position: relative;
				padding: 25px;
				width: 400px;
				height: 340px;
			    background: rgba(255,255,255,.6);
			    -webkit-box-shadow: 0 0 5px 5px rgba(0,0,0,.1);
			    box-shadow: 0 0 5px 5px rgba(0,0,0,.1);
			}
			#login_box input{
				margin: 8px;
				height: 50px;
			}
			#login_box button{
				margin: 8px;
				height: 44px;
				background: #b7b6b6;
				-webkit-filter: blur(0px);
			}


			@media screen and (max-width: 240px) {
				#login_box input{
					margin: 8px;
					height: 50px;
				}
				#login_box button{
					margin: 8px;
					height: 44px;
					background: #b7b6b6;
				}
			}

			@media screen and (max-width: 430px) {
			  	#login_logo{
			  		padding: 0;
				}
				#login_box{
					width: auto;
					left: 0;
				}
			}
			@media screen and (max-width: 600px) {
			  #login_box{
					width: auto;
				}
			}
			/*@media (min-width: 992px) {
			  #login_box{
				width: 450px;
				}
			}
			@media (min-width: 1200px) {
			  #login_box{
				width: 450px;
				}
			}*/
		</style>

	</head>
	<body>
		<img id="fondo_login" src="../dist/img/fondo2.jpg" alt="">
		<section id="contenido">
			<div id="centrar_contenido">
				<div id="login_box" style="border-radius: 50px;padding-right: 35px;">
				<div id="login_logo" style="padding-bottom: 15px;">
					<!-- <img src="dist/img/logo.png" alt=""> -->
					<img src="../dist/img/logo.png" alt="" style="width:230px;">
				</div>
					<form role="form" method="POST" action="{{ url('/auth/login') }}">
			            <input type="hidden" name="_token" value="{{ csrf_token() }}">
			            <input type="hidden" id="disp" name="disp">
			            <input type="hidden" id="valor_mac" name="valor_mac">
			            <div class="">
			                <div class="">
				                <input style="height: 35px;font-size: 12px;" type="text" class="form-control"  name="s_LoginUsuario" value="{{ old('s_LoginUsuario') }}" placeholder="USUARIO">
			                </div>
			                <div class="">
				                <input style="height: 35px;font-size: 12px;" type="password" class="form-control" name="p_PasswordUsuario" placeholder="CONTRASEÑA">
			                </div>
			            </div>
			            <div class="">
			            	<div class="row">
								<div class="col-md-12">
				                	<button id="login" type="submit" class="btn btn-block">CONECTARME</button>
				            	</div>
				           	</div>
			            </div>
			        </form>
					@if (count($errors) > 0)
			            <div class="alert alert-danger">
			              	<strong>
			              		Whoops!
			              	</strong> 
			              	There were some problems with your input.<br>
			              	<ul>
			                	@foreach ($errors->all() as $error)
			                  		<li>{{ $error }}</li>
			                	@endforeach
			              	</ul>
			            </div>
			        @endif
				</div>
			</div>
	    </section>
	    
	    <script src="{{ asset('plugins/jQuery/jQuery-2.1.3.min.js') }}"></script>
	    <!-- iCheck 1.0.1 -->
	    <script src="{{ asset('plugins/iCheck/icheck.min.js') }}" type="text/javascript"></script>    
	    <!-- Bootstrap 3.3.2 JS -->
	    <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
	    <script type='text/javascript'>
	    //Red color scheme for iCheck
	    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
	      checkboxClass: 'icheckbox_flat-green',
	      radioClass: 'iradio_flat-green'
	    });
		// // DETERMINAR SI ES MOVIL O ORDENADOR DE ESCRITORIO
		// window.onload=function(){
		// 	var device = navigator.userAgent
		// 	if (
		// 			device.match(/Iphone/i)|| device.match(/Ipod/i)|| 
		// 			device.match(/Android/i)|| device.match(/J2ME/i)|| 
		// 			device.match(/BlackBerry/i)|| device.match(/iPhone|iPad|iPod/i)|| 
		// 			device.match(/Opera Mini/i)|| device.match(/IEMobile/i)|| 
		// 			device.match(/Mobile/i)|| device.match(/Windows Phone/i)|| 
		// 			device.match(/windows mobile/i)|| device.match(/windows ce/i)|| 
		// 			device.match(/webOS/i)|| device.match(/palm/i)|| 
		// 			device.match(/bada/i)|| device.match(/series60/i)|| 
		// 			device.match(/nokia/i)|| device.match(/symbian/i)|| 
		// 			device.match(/HTC/i)
		// 		)
		// 	{ 
		// 		// SI ES MOVIL
		// 		$('#disp').val("mobile");

		// 	}
		// 	else
		// 	{
		// 		// SI ES PC DE ESCRITORIO
		// 		$('#disp').val("desktop")
		// 		if(!localStorage.getItem("key_sisgam")){
		// 		location.href="../cargar_llave";
		// 	}

		// 	}


		// 	//Luego damos valor de la mac
		// 	$("#valor_mac").val(localStorage.getItem("key_sisgam"));



		// }
	    </script>
 	</body>
</html>
