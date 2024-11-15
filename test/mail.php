<?php
include('../functions/funciones_mysql.php');
include('../functions/email.php');
//include('../functions/email.php');

session_start();
error_reporting(7);
iconv_set_encoding('internal_encoding', 'utf-8'); 
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Monterrey');
setlocale(LC_TIME, 'es_ES.UTF-8');
$_SESSION['time']=mktime();
extract($_SESSION);
 
$empresa_id =1;
$destinatario ="contacto@neuromodulaciongdl.com";
$nombre = "Leonardo sanz";
$asunto = "Pruebas";
$cuerpo_correo = "hola  mundo";
$accion =  "Invitacion"; // "RFC"; // "General"; // 
 
echo correo_electronico($destinatario,$asunto,$cuerpo_correo,$nombre,$empresa_id,$accion);
?>
<hr>
hola mundo