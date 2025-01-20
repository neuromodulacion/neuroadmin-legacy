<?php
session_start();

// Establecer el nivel de notificación de errores
error_reporting(E_ALL); // Reemplaza `7` por `E_ALL` para usar la constante más clara y recomendada

// Establecer la codificación interna a UTF-8 (ya no se utiliza `iconv_set_encoding`, sino `ini_set`)
ini_set('default_charset', 'UTF-8');

// Configurar la cabecera HTTP con codificación UTF-8
header('Content-Type: text/html; charset=UTF-8');

// Configurar la zona horaria
//date_default_timezone_set('America/Monterrey');

// Establece la zona horaria predeterminada para la aplicación
$timezone = $_SESSION['timezone']; // nos trae la zona horaria de la sesion
date_default_timezone_set($timezone);

// Asegurar que se establezca la configuración regional para los nombres de mes y día
setlocale(LC_TIME, 'es_ES.UTF-8');  // Para sistemas Unix
if (stripos(PHP_OS, 'WIN') === 0) {
    setlocale(LC_TIME, 'Spanish_Spain.1252');  // Para sistemas Windows
}

// Asignar el tiempo actual a la sesión en formato de timestamp
$_SESSION['time'] = time(); // `time()` es el equivalente moderno a `mktime()`

$dominio = $_SERVER['HTTP_HOST'];		
extract($_SESSION);
extract($_POST);
extract($_GET);

require($ruta.'vendor/autoload.php');

// Incluye archivos PHP necesarios para la funcionalidad adicional
include($ruta.'functions/funciones_mysql.php');
/*
include($ruta.'functions/conexion_mysqli.php');

// Incluir el archivo de configuración y obtener las credenciales
$configPath = $ruta.'../config.php';

if (!file_exists($configPath)) {
    die('Archivo de configuración no encontrado.');
}

$config = require $configPath;

// Crear una instancia de la clase Mysql
$mysql = new Mysql($config['servidor'], $config['usuario'], $config['contrasena'], $config['baseDatos']);*/
