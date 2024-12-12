<?php
include('functions/funciones_mysql.php');
include('functions/email.php');
//session_start();
error_reporting(7);
iconv_set_encoding('internal_encoding', 'utf-8'); 
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Monterrey');
setlocale(LC_TIME, 'es_ES.UTF-8');
$_SESSION['time']=time();

$ruta = "../";
extract($_POST);
// print_r($_POST);


$sql = "SELECT
			* 
		FROM
			admin
		WHERE
			usuario ='$email'"; 
$result_insert = ejecutar($sql);
$cnt = mysqli_num_rows($result_insert);
$row = mysqli_fetch_array($result_insert);
extract($row);
// echo $cnt;

if ($cnt == 0) { ?>
	
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Alta</title>
    <!-- Favicon-->
    <link rel="icon" href="../../favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="../plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="../plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="../css/style.css" rel="stylesheet">
</head>

<!-- <body class="five-zero-zero"></body>-->
<body class="theme-<?php echo $body; ?>">	
    <div align="center" class="five-zero-zero-container">
        <div> <h1>No esta registrado este usuario</h1></div>
        <div> <h2>Usuario no registrado favor de registrarse</h2></div>
        <div align="center"> 
			<div style="width: 90% ;!important;" align="left" >
			        	 
				<a href="sign-up.html" class="btn bg-green btn-lg waves-effect">REGISTRARCE</a>     	      	
	    	</div>        		
        </div>
    </div>

	            
    <!-- Jquery Core Js -->
    <script src="../../plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="../../plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="../../plugins/node-waves/waves.js"></script>
</body>

</html> 	

<?php	

}else{ 


$destinatario = $email; 
$asunto = "Recuperación de contraseña ".$nombre; 
 
$cuerpo = ' 
<html> 
<head> 
   <title>Recuperación de contraseña</title> 
</head> 
<body> 
<p>Estimado(a) ' . $nombre . ',</p>
<p>Hemos recibido una solicitud para recuperar su contraseña. A continuación, encontrará su contraseña registrada:</p>
<p><strong>Contraseña:</strong> ' . $pwd . '</p>
<p>Si no solicitó esta recuperación de contraseña, por favor, póngase en contacto con nuestro equipo de soporte inmediatamente.</p>
<p>Saludos cordiales,</p>
<p><strong>Equipo de Soporte</strong><br>
Neuromodulación Gdl</p>
</body> 
</html> 
'; 


// 
$accion = '';
// echo $asunto." asunto<hr>";
// echo $cuerpo." cuerpo<hr>";
// echo $usuario_id." usuario_id<hr>";
// echo $accion." accion<hr>";

$mensaje = correo_electronico_base($asunto,$cuerpo,$usuario_id,$accion);


// echo $mail;
// //$mail = mail($destinatario,$asunto,$cuerpo,$headers); 
// // echo "hola mundo";
// 
// if ($mail == 1) {
	// $mensaje = "<h1>Mensaje Enviado</h1>";
// } else {
	// $mensaje = "<h1>ERROR No Enviado</h1>";
// } 

?>            
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Generado</title>
    <!-- Favicon-->
    <link rel="icon" href="images/favicon.png" type="image/x-icon">

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
<body  align="center"  class="theme-<?php echo $body; ?>">	
	<div align="center" style="padding-top: 10%" class="container">
	    <div style="width: 500px; padding: 15px" align="center" class="card">
	        <div> <h1>Exito</h1></div>
	        <div> <h2>Se mando la contraseña a su correo</h2>
	        	</div>
	        <div align="center"> 
				<h3>Favor de checar su correo para concluir con el proceso</h3>
				<?php echo $mensaje; ?>
				<a href="inicio.html" class="btn bg-green btn-lg waves-effect">CONTINUAR</a>        		
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

<?php } ?>