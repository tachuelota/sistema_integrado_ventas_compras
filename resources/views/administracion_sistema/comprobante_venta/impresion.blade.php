<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Comprobante de Venta</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
	<link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />    

	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
</head>
<body onload="window.print();">
	<div class="container">
		
	                    <div class="row">
	                         <div class="col-xs-12 text-center">
	                             <h2>Factura de Venta</h2>
	                         </div>
	                     </div> 
	                    <form id="form_cabecera">
	                    <hr>
	                    <div class="row">
	                        <div class="col-xs-2">
	                            Nª Serie:
	                        </div>
	                        <div class="col-xs-2">
	                            <span><?php echo $cabecera['serie']; ?></span>
	                        </div>
	                        <div class="col-xs-1">
	                            Moneda:
	                        </div>
	                        <div class="col-xs-2">
	                            <span> <?php echo $cabecera['moneda']['nombre_moneda']; ?></span>
	                        </div>
	                    </div>
	                    <div class="row">
	                        <div class="col-xs-2">
	                            Nª Comprobante: 
	                        </div>
	                        <div class="col-xs-2">
	                            <span><?php echo $cabecera['numero']; ?></span>
	                        </div>
	                        <div class="col-xs-1">
	                            Fecha:
	                        </div>
	                        <div class="col-xs-2">
	                            <span><?php echo $cabecera['fecha']; ?></span>
	                        </div>
	                        <div class="col-xs-2">
	                            Hora:
	                        </div>
	                        <div class="col-xs-2">
	                            <span><?php echo $cabecera['hora']; ?></span>
	                        </div>
	                    </div>
	                    <hr>

	                    <div class="row">
	                        <div class="col-xs-2">
	                            Cliente: 
	                        </div>
	                        <div class="col-xs-4">
	                            <span><?php echo $cabecera['cliente']['razon_social']; ?></span>
	                                
	                        </div>
	                        <div class="col-xs-3 text-right">
	                            RUC: 
	                        </div>
	                        <div class="col-xs-3">
	                            <span><?php echo $cabecera['cliente']['ruc']; ?></span>
	                        </div>

	                    </div>
	                    <div class="row">
	                        <div class="col-xs-2">
	                            Direccion: 
	                        </div>
	                        <div class="col-xs-10">
	                            <span><?php echo $cabecera['direccion']; ?></span>
	                        </div>
	                    </div>
	                    </form>
	                    <hr>
	                    
	                    <hr>

	                    <div class="row">
	                        <div  class="col-xs-12">       
	                            <table class="table table-striped text-center" >
	                                <thead >
	                                    <tr>
	                                        <th>ITEM</th>
	                                        <th>CANTIDAD</th>
	                                        <th>DESCRIPCION</th>
	                                        <th>PRECIO</th>
	                                        <th>VALOR TOTAL / IMPORTE</th>
	                                    </tr>
	                                </thead>
	                                <tbody>
	                                	<?php
	                                		foreach ($detalle as $key => $value) {
	                                			?>
				                                    <tr>
				                                        <td><?php echo$key; ?></td>
				                                        <td><?php echo$value['cantidad']; ?></td>
				                                        <td><?php echo$value['producto']; ?></td>
				                                        <td><?php echo$value['precio']; ?></td>
				                                        <td><?php echo$value['cantidad']*$value['precio']; ?></td>
				                                    </tr>
			                                    <?php
	                                		}
	                                	?>	
	                                </tbody>
	                            </table>
	                        </div>
	                    </div>
	                    <div class="row">
	                        <div class="col-xs-2 col-xs-offset-8 text-right">
	                            <label>SubTotal : </label>
	                        </div>
	                        <div class="col-xs-2">
	                            <span><?php echo $totales['subtotal']; ?></span>
	                        </div>
	                    </div>

	                    <div class="row">
	                        <div class="col-xs-2 col-xs-offset-8 text-right">
	                            <label>IGV : </label>
	                        </div>
	                        <div class="col-xs-2">
	                            <span><?php echo $totales['igv']; ?></span>
	                        </div>
	                    </div>

	                    <div class="row">
	                        <div class="col-xs-2 col-xs-offset-8 text-right">
	                            <label>Total : </label>
	                        </div>
	                        <div class="col-xs-2">
	                            <span><?php echo $totales['total']; ?></span>
	                        </div>
	                    </div>

	                    <div class="row">
	                        <div class="col-xs-2 col-xs-offset-8 text-right">
	                            <label>Retencion  : </label>
	                        </div>
	                        <div class="col-xs-2">
	                            <span><?php echo $totales['retencion']; ?></span>
	                        </div>
	                    </div>

	                    <div class="row">
	                        <div class="col-xs-2 col-xs-offset-8 text-right">
	                            <label>Importe Aplicado : </label>
	                        </div>
	                        <div class="col-xs-2">
	                            <span><?php echo $totales['importe_aplicado']; ?></span>
	                        </div>
	                    </div>
	</div>
<script src="{{ asset('plugins/jQuery/jquery-2.1.3.js') }}"></script>

<script src="{{ asset('dist/js/app.min.js') }}" type="text/javascript"></script>

</body>
</html>