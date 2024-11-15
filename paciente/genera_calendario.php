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


include('calendario.php');
//include('../functions/funciones_mysql.php');

//print_r($_POST);
$genera ="remoto";


echo calendario($semana,$anio,$mes_largo,$genera,$body,$accion,$dia_ini,$dia_fin);