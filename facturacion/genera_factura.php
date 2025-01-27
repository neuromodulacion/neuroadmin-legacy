<?php
session_start();
error_reporting(7);
iconv_set_encoding('internal_encoding', 'utf-8'); 
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Monterrey');
setlocale(LC_TIME, 'es_ES.UTF-8');
$_SESSION['time']=time();
// 
		// require_once "../vendor/autoload.php";
		// use UAParser\Parser;
$ruta = "../";
include($ruta.'functions/funciones_mysql.php');
		
extract($_POST);
//extract($_GET);
extract($_SESSION);
//print_r($_SESSION);


$sql ="
SELECT
	cobros.cobros_id, 
	cobros.usuario_id, 
	cobros.tipo, 
	cobros.doctor, 
	cobros.protocolo_ter_id, 
	cobros.f_pago, 
	cobros.importe as aImporte, 
	cobros.f_captura, 
	cobros.h_captura, 
	cobros.otros, 
	cobros.empresa_id, 
	cobros.cantidad as aUnidades, 
	cobros.protocolo, 
	cobros.ticket, 
	cobros.facturado
FROM
	cobros
WHERE
	cobros.ticket = $ticket";	
	
$result =ejecutar($sql); 
$row = mysqli_fetch_array($result);
extract($row);

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <html lang="es">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title><?php echo $titulo; ?></title>
    
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>   
    <!-- <script src="<?php echo $ruta; ?>js/jquery-3.3.1.min.js"></script>  -->    
    <!-- Favicon-->
    <link rel="icon" href="<?php echo $ruta; ?>images/logo_aldana_tc.png" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="<?php echo $ruta; ?>plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="<?php echo $ruta; ?>plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="<?php echo $ruta; ?>plugins/animate-css/animate.css" rel="stylesheet" />
<!-- *************Tronco comun ******************** -->  
 

    <link href="<?php echo $ruta; ?>plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
    
     <!-- Bootstrap Material Datetime Picker Css -->
    <link href="<?php echo $ruta; ?>plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />

    <!-- Bootstrap DatePicker Css -->
    <link href="<?php echo $ruta; ?>plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />

    <!-- Wait Me Css -->
    <link href="<?php echo $ruta; ?>plugins/waitme/waitMe.css" rel="stylesheet" />

    <!-- Bootstrap  Css -->
    <link href="<?php echo $ruta; ?>plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />  
<!-- *************Tronco comun ******************** --> 
    <!-- Custom Css -->
    <link href="<?php echo $ruta; ?>css/style.css" rel="stylesheet">

    <!-- AdminTMS Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="<?php echo $ruta; ?>css/themes/all-themes.css" rel="stylesheet" />
    
</head>

 <body style="background: #0096AA;" >    <!--class="theme-teal" -->
    
	<nav style="background: #0096AA" class="navbar navbar-default">
	  <div class="container-fluid">
	    <!-- Brand and toggle get grouped for better mobile display -->
	    <div class="navbar-header">
	      <!-- <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
	        <span class="sr-only">Toggle navigation</span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button> -->
	      <a style=" color: white" class="navbar-brand" href="#">Neuromodulacion Gdl</a>
	    </div>
	
	    <!-- Collect the nav links, forms, and other content for toggling -->
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	      <!-- <ul class="nav navbar-nav">
	        <li><a href="#">Link</a></li>
	        <li class="dropdown">
	          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
	          <ul class="dropdown-menu">
	            <li><a href="#">Action</a></li>
	            <li><a href="#">Another action</a></li>
	            <li><a href="#">Something else here</a></li>
	            <li role="separator" class="divider"></li>
	            <li><a href="#">Separated link</a></li>
	            <li role="separator" class="divider"></li>
	            <li><a href="#">One more separated link</a></li>
	          </ul>
	        </li>
	      </ul> -->
	      <!-- <form class="navbar-form navbar-left">
	        <div class="form-group">
	          <input type="text" class="form-control" placeholder="Search">
	        </div>
	        <button type="submit" class="btn btn-default">Submit</button>
	      </form> -->
	      <!-- <ul class="nav navbar-nav navbar-right">
	        <li><a href="#">Link</a></li>
	        <li class="dropdown">
	          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
	          <ul class="dropdown-menu">
	            <li><a href="#">Action</a></li>
	            <li><a href="#">Another action</a></li>
	            <li><a href="#">Something else here</a></li>
	            <li role="separator" class="divider"></li>
	            <li><a href="#">Separated link</a></li>
	          </ul>
	        </li>
	      </ul> -->
	    </div><!-- /.navbar-collapse -->
	  </div><!-- /.container-fluid -->
	</nav>

    <div align="center" class="row clearfix" style="padding: 5px; padding-top: 30px">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">

                    <ul class="header-dropdown m-r--5">
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </a>

                        </li>
                    </ul>
                </div>
                
                <div align="left" class="body">
					<h1 align="center">Valida la Información</h1>
				    <h2 align="center">Detalles del Ticket</h2>
					<div class="row">
					  	<div class="col-md-6"> 				    
						    <p><strong>Ticket:</strong> <?php echo htmlspecialchars($ticket); ?></p>
						    <p><strong>Razón Social:</strong> <?php echo htmlspecialchars($cRazonSocial); ?></p>
						    <p><strong>RFC:</strong> <?php echo htmlspecialchars($cRFC); ?></p>
						    <p><strong>Régimen:</strong> <?php echo htmlspecialchars($aRegimen); ?></p>
						    <p><strong>Correo Electronico:</strong> <?php echo htmlspecialchars($email_address); ?></p>
						    <p><strong>Cantidad:</strong> <?php echo htmlspecialchars($aUnidades); ?></p>
						    <p><strong>Importe:</strong> $ <?php echo number_format(htmlspecialchars($aImporte)); ?></p>				    				    
						</div>
					  	<div class="col-md-6">   				    
						    <p><strong>Nombre Calle:</strong> <?php echo htmlspecialchars($cNombreCalle); ?></p>
						    <p><strong>Número Exterior:</strong> <?php echo htmlspecialchars($cNumeroExterior); ?></p>
						    <p><strong>Número Interior:</strong> <?php echo htmlspecialchars($cNumeroInterior); ?></p>
						    <p><strong>Código Postal:</strong> <?php echo htmlspecialchars($cCodigoPostal); ?></p>
						    <p><strong>Colonia:</strong> <?php echo htmlspecialchars($cColonia); ?></p>
						    <p><strong>Ciudad:</strong> <?php echo htmlspecialchars($cCiudad); ?></p>
						    <p><strong>Estado:</strong> <?php echo htmlspecialchars($cEstado); ?></p>
						    <p><strong>País:</strong> <?php echo htmlspecialchars($cPais); ?></p>
						</div>
					</div>	
                    <div align="center">
						<form id="info" action="tu_script_de_procesamiento.php" method="post">
							<input type="hidden" name="ticket" value="<?php echo htmlspecialchars($ticket); ?>">
							<input type="hidden" name="cRazonSocial" value="<?php echo htmlspecialchars($cRazonSocial); ?>">
							<input type="hidden" name="cRFC" value="<?php echo htmlspecialchars($cRFC); ?>">
							<input type="hidden" name="aRegimen" value="<?php echo htmlspecialchars($aRegimen); ?>">
							<input type="hidden" name="cNombreCalle" value="<?php echo htmlspecialchars($cNombreCalle); ?>">
							<input type="hidden" name="cNumeroExterior" value="<?php echo htmlspecialchars($cNumeroExterior); ?>">
							<input type="hidden" name="cNumeroInterior" value="<?php echo htmlspecialchars($cNumeroInterior); ?>">
							<input type="hidden" name="cCodigoPostal" value="<?php echo htmlspecialchars($cCodigoPostal); ?>">
							<input type="hidden" name="cColonia" value="<?php echo htmlspecialchars($cColonia); ?>">
							<input type="hidden" name="cCiudad" value="<?php echo htmlspecialchars($cCiudad); ?>">
							<input type="hidden" name="cEstado" value="<?php echo htmlspecialchars($cEstado); ?>">
							<input type="hidden" name="cPais" value="<?php echo htmlspecialchars($cPais); ?>">
							<input type="hidden" name="email_address" value="<?php echo htmlspecialchars($email_address); ?>">
							<input type="hidden" name="aUnidades" value="<?php echo htmlspecialchars($aUnidades); ?>">
							<input type="hidden" name="aImporte" value="<?php echo htmlspecialchars($aImporte); ?>">
							
							<!-- Resto del formulario -->
							<button id="buscar" type="button" style="background: #0096AA; color: white"  class="btn btn-lg m-l-15 waves-effect">CONFIRMAR</button>
                            <div style="display: none" id="load">
                            	<hr>
                                <div class="preloader pl-size-l">
                                    <div class="spinner-layer pl-teal">
                                        <div class="circle-clipper left">
                                            <div class="circle"></div>
                                        </div>
                                        <div class="circle-clipper right">
                                            <div class="circle"></div>
                                        </div>
                                    </div>
                                </div>
                                <h2>Cargando...</h2>
                            </div>
                            <div id="contenido"></div>
	                        <script>
	                            $('#buscar').click(function(){ 
	                            	//alert('Test'); 
	                            	$('#contenido').html(''); 
	                                var datastring = $('#info').serialize();
	                                $('#load').show();

                                    $.ajax({
                                        url: 'guarda_factura.php',
                                        type: 'POST',
                                        data: datastring,
                                        cache: false,
                                        success:function(html){
                                        	//alert('Se modifico correctemente');       
                                            $('#contenido').html(html); 
                                            $('#load').hide();

                                        }
                                	});
	                            });
	                        </script>							
						</form>
					</div>
               </div>
            </div>
        </div>
    </div>
            

    <!-- Jquery Core Js -->
    <script src="<?php echo $ruta; ?>plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="<?php echo $ruta; ?>plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Select Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/bootstrap-select/js/bootstrap-select.js"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/jquery-slimscroll/jquery.slimscroll.js"></script>


    <!-- Moment Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/momentjs/moment.js"></script>

    <!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

    <!-- Bootstrap Datepicker Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

    <!-- Waves Effect Plugin Js -->
    <!-- Autosize Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/autosize/autosize.js"></script>

    <!-- Moment Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/momentjs/moment.js"></script>


    <!-- Waves Effect Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/node-waves/waves.js"></script>
    
    <!-- Custom Js -->
    <script src="<?php echo $ruta; ?>js/admin.js"></script>
    <script src="<?php echo $ruta; ?>js/pages/ui/tooltips-popovers.js"></script>
    <!-- <script src="<?php echo $ruta; ?>js/pages/tables/jquery-datatable.js"></script> -->
    <script src="<?php echo $ruta; ?>js/pages/forms/basic-form-elements.js"></script>


    <!-- Demo Js -->
    <script src="<?php echo $ruta; ?>js/demo.js"></script>
</body>

</html>        

