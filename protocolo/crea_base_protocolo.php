<?php
// crea_base_protocolo.php

include('../functions/funciones_mysql.php');
session_start();
error_reporting(7);
iconv_set_encoding('internal_encoding', 'utf-8'); 
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Monterrey');
setlocale(LC_TIME, 'es_ES.UTF-8');
$_SESSION['time']=mktime();


include('fun_protocolo.php');

$ruta = "../";
extract($_SESSION);
// print_r($_SESSION);
 
extract($_POST);
// print_r($_POST);
// $protocolo_ter_id = 5;

$encuesta_id = 12;

// $x = crea($protocolo_ter_id);

$x = crea_new($encuesta_id);

echo $x;
