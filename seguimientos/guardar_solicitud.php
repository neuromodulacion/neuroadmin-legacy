<?php
include('../functions/funciones_mysql.php');
include('../functions/email.php');
session_start();
error_reporting(7);
ini_set('default_charset', 'UTF-8'); 
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Monterrey');
setlocale(LC_TIME, 'es_ES.UTF-8');
$_SESSION['time']=time();

$ruta = "../";
extract($_SESSION);
extract($_POST);

$f_registro = date("Y-m-d");
$h_registro = date("H:i:s");


// Obtener datos del formulario
$titulo = $_POST['titulo'];
$descripcion = $_POST['descripcion'];
$tipo = $_POST['tipo'];
$prioridad = $_POST['prioridad'];

// Insertar en la base de datos
$sql = "
INSERT INTO solicitudes 
	(titulo, descripcion, tipo, prioridad, estado, usuario_id, empresa_id) 
VALUES 
	('$titulo', '$descripcion', '$tipo', '$prioridad', 'Pendiente', '$usuario_id', '$empresa_id')";
$result_insert = ejecutar($sql);


$asunto = "Solicitud a Sistemas de ".$titulo;
$cuerpo_correo = "Se agenda la siguiente solicitud:<br>".$descripcion."<br><br><br>Tipo: ".$tipo."<br>Prioridad: ".$prioridad."<br> Estatus: ".$estado;
$accion = "correo simple";

echo correo_electronico_sitema($asunto,$cuerpo_correo,$usuario_id,$accion);


?>            
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Guardado</title>
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
<body class="theme-<?php echo $body; ?>"><br><br><br>	
	<div class="row">
	  <div class="col-md-4"></div>
	  	<div class="col-md-4">
		    <div  align="center" style="padding: 20px;" class="five-zero-zero-container card">
		        <div> <h1>Exito</h1></div>
		        <div> <h2>Se guardo la información</h2></div>
		        <div align="center"> 
					<div style="width: 90% ;!important;" align="left" >
						<h2>Se genero la solicitud de <?php echo $tipo; ?></h2>
						<?php echo $descripcion; ?>
						<div style="width: 90% ;!important;" align="left" >
					    	Registro: <?php echo $result_insert; ?><br>
					    	Nombre: <?php echo $nombre; ?><br>
							Prioridad: <?php echo $prioridad; ?><br> 	      	
						</div> 
						<a href="<?php echo $ruta; ?>/seguimientos/seguimientos.php" class="btn bg-green btn-lg waves-effect">CONTINUAR</a>   	      	
			    	</div>        		
		        </div>
		    </div>
		</div>
	  	<div class="col-md-4"></div>
	</div>	
	            
    <!-- Jquery Core Js -->
    <script src="../../plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="../../plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="../../plugins/node-waves/waves.js"></script>
</body>

</html>  