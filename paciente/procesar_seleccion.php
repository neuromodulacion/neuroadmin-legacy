<?php
include('../functions/funciones_mysql.php');
include('../functions/email.php');
session_start();
error_reporting(7);
ini_set('default_charset', 'UTF-8'); 
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Monterrey');
setlocale(LC_TIME, 'es_ES.UTF-8');

extract($_POST);

$updatesi = "
	UPDATE pacientes
	SET estatus='$estatus' WHERE paciente_id =$paciente_id";	
	 echo $updatesi."<hr>";
	$result= ejecutar($updatesi);