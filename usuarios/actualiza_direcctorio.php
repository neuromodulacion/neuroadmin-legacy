<?php
include('../functions/funciones_mysql.php');
session_start();
error_reporting(7);
iconv_set_encoding('internal_encoding', 'utf-8'); 
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Monterrey');
setlocale(LC_TIME, 'es_ES.UTF-8');
$_SESSION['time']=time();

$ruta = "../";
extract($_SESSION);
extract($_POST);
// print_r($_POST);
// echo "<hr>";

// print_r($_SESSION);
// echo "<hr>";
//$aviso = stripslashes($_POST['aviso']); 

$f_captura = date("Y-m-d");
$h_captura = date("H:i:s"); 

switch ($accion) {
	case 'estatus':
			$update = "
				UPDATE admin
				SET estatus='$estatusx' WHERE usuario_id ='$usuario_id'";		
		break;
	
	case 'funcion':
			$update = "
				UPDATE admin
				SET funcion='$funcionx' WHERE usuario_id ='$usuario_id'";		
		break;
}
echo $update;
$result_update = ejecutar($update);