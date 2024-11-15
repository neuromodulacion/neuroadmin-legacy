<?php
session_start();
error_reporting(7);
iconv_set_encoding('internal_encoding', 'utf-8'); 
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Monterrey');
setlocale(LC_TIME, 'es_ES.UTF-8');
$_SESSION['time']=mktime();

$ruta = "../";
extract($_POST);
extract($_GET);
extract($_SESSION);
//print_r($_POST);

include('calendario.php');

//include('../functions/funciones_mysql.php');

$genera ="busqueda";

$paciente = strtoupper($paciente);
$apaterno = strtoupper($apaterno);
$amaterno = strtoupper($amaterno);

echo busca_agenda($paciente_id,$paciente,$apaterno,$amaterno,$body,$genera);