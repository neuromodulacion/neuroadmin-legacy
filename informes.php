<?php
include('functions/funciones_mysql.php');
//session_start();
error_reporting(7);
iconv_set_encoding('internal_encoding', 'utf-8'); 
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Monterrey');
setlocale(LC_TIME, 'es_ES.UTF-8');
$_SESSION['time']=mktime();

	//Import PHPMailer classes into the global namespace
	//These must be at the top of your script, not inside a function
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

$ruta = "";
extract($_POST);	
//print_r($_POST);

$f_alta = date("Y-m-d");
$h_alta = date("H:i:s"); 
$insert1 ="
	INSERT IGNORE INTO informes 
		(
			name,
			email,
			medico,
			phone,
			message,
			f_alta,
			h_alta ,
			estatus
		) 
	VALUE
		(
			'$name',
			'$email',
			'$medico',
			'$phone',
			'$message',
			'$f_alta',
			'$h_alta',
			'Pendiente'
		) ";
      //echo $insert1."<br>";
$result_insert = ejecutar($insert1);


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Alta</title>
    <!-- Favicon-->
    <link rel="icon" href="<?php echo $ruta; ?>/images/logo_aldana_tc.png" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="<?php echo $ruta; ?>plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="<?php echo $ruta; ?>plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="<?php echo $ruta; ?>css/style.css" rel="stylesheet">
</head>

<!-- <body class="five-zero-zero"></body>-->
<body class="theme-<?php echo $body; ?>">	
    <div align="center" class="five-zero-zero-container">
        <div> <h1>Se envio solicitud</h1></div>
        <!-- <div> <h2>Usuario registrado intente recuperar su contraseña</h2></div> -->
        <div align="center"> 
			<div style="width: 90% ;!important;" align="left" >
				<!-- <h2><?php echo $mensaje; ?></h2> -->
			        	
			        	<b>Nombre:</b> <?php echo $name; ?><br>
			        	<b>Correo Electronico:</b> <?php echo $email; ?><br>
			        	<b>Celular:</b> <?php echo $phone; ?><br>
			        	<b>Medico tratante:</b> <?php echo $medico; ?><br>
			        	<b>Mensaje:</b> <?php echo $message; ?><br><hr>
			        	 
				<a href="index.html" class="btn bg-green btn-lg waves-effect">CONTINUAR</a>     	      	
	    	</div>        		
        </div>
    </div>

	            
    <!-- Jquery Core Js -->
    <script src="<?php echo $ruta; ?>plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="<?php echo $ruta; ?>plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/node-waves/waves.js"></script>
</body>

</html> 	