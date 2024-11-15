<?php
session_start();
error_reporting(E_ALL);
ini_set('default_charset', 'UTF-8');
header('Content-Type: text/html; charset=UTF-8');
//date_default_timezone_set('America/Monterrey');
date_default_timezone_set('America/Mazatlan');
setlocale(LC_TIME, 'es_ES.UTF-8');

$dominio = $_SERVER['HTTP_HOST'];		
extract($_SESSION);
extract($_POST);
extract($_GET);

require($ruta.'vendor/autoload.php');
include($ruta.'functions/funciones_mysql.php');

