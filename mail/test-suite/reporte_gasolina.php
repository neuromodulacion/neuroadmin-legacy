<?php error_reporting(7); 
    iconv_set_encoding('internal_encoding', 'utf-8'); 
    header('Content-Type: text/html; charset=UTF-8');
    date_default_timezone_set('America/Monterrey');
	
    include ("../funciones/funciones_mysql.php");
    include ("../funciones/funciones.php");     
    
    $conexion = conectar("dish_calidad"); 
	$usuario = $_POST["usuario"];
	$completar = $_POST["completar"];
	$num_eco = $_POST["num_eco"];		
	$f_carga = $_POST["f_carga"];
	$f_captura = $_POST["f_captura"];
	$hr_captura = $_POST["hr_captura"];
	$estado = $_POST["estado"];
	$importe = $_POST["importe"];
	$kilometraje = $_POST["kilometraje"];
	$litros = $_POST["litros"];
	$latitud = $_POST["latitud"];
	$longitud = $_POST["longitud"];
	$precision = $_POST["precision"];
	$ruta = $_POST["ruta"];
/*********************************************************************************************************************************************************************************************************************************/ ?>
<!DOCTYPE html>
<html>
	<head>
    	<title>Reporte Gasolina</title>
    	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
 	</head>
  	<body>
		
  	</body>
</html>

<? mysql_close($conexion); ?>