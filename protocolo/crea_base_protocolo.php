<?php
// crea_base_protocolo.php

include('../functions/funciones_mysql.php');
session_start();

// Establecer el nivel de notificación de errores
error_reporting(E_ALL); // Reemplaza `7` por `E_ALL` para usar la constante más clara y recomendada

// Establecer la codificación interna a UTF-8 (ya no se utiliza `iconv_set_encoding`, sino `ini_set`)
ini_set('default_charset', 'UTF-8');

// Configurar la cabecera HTTP con codificación UTF-8
header('Content-Type: text/html; charset=UTF-8');

// Configurar la zona horaria
date_default_timezone_set('America/Monterrey');

// Configurar la localización para manejar fechas y horas en español
setlocale(LC_TIME, 'es_ES.UTF-8');

// Asignar el tiempo actual a la sesión en formato de timestamp
$_SESSION['time'] = time(); // `time()` es el equivalente moderno a `mktime()`


include('fun_protocolo.php');

$ruta = "../";
extract($_SESSION);
// print_r($_SESSION);
 
extract($_POST);
// print_r($_POST);
// $protocolo_ter_id = 5;

$encuesta_id = 13;

// $x = crea($protocolo_ter_id);

$x = crea_new($encuesta_id);

echo $x;
