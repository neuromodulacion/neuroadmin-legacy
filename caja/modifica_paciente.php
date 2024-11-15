<?php
// Incluye funciones necesarias para el manejo de la base de datos y API
include('../functions/funciones_mysql.php');
include('../api/funciones_api.php');

// Inicia la sesión para mantener las variables de sesión a lo largo del script
session_start();

// Configura el nivel de reporte de errores, mostrando solo advertencias
error_reporting(7);

// Configura la codificación interna a UTF-8 para evitar problemas con caracteres especiales
iconv_set_encoding('internal_encoding', 'utf-8');

// Establece la cabecera HTTP para que el contenido se interprete como HTML con codificación UTF-8
header('Content-Type: text/html; charset=UTF-8');

// Configura la zona horaria predeterminada para la aplicación
date_default_timezone_set('America/Monterrey');

// Establece la configuración regional para el manejo de fechas y tiempos en español (España)
setlocale(LC_TIME, 'es_ES.UTF-8');

// Guarda el tiempo actual en la sesión
$_SESSION['time'] = mktime();

// Establece la ruta base para las inclusiones de archivos
$ruta = "../";

// Extrae las variables de la sesión y las convierte en variables locales
extract($_SESSION);
// print_r($_SESSION); // Comentar o eliminar en producción

// Extrae las variables enviadas por POST y las convierte en variables locales
extract($_POST);
// print_r($_POST); // Comentar o eliminar en producción

// Variables para capturar la fecha y hora actuales
$f_captura = date("Y-m-d");
$h_captura = date("H:i:s");

// Verifica si la modificación es para un paciente existente basado en su ID
if ($tipo_mod == 'paciente_cons_id') {
    // Construye la consulta SQL para actualizar la información del paciente en la base de datos
	$update ="
	UPDATE paciente_consultorio
	SET
		paciente_consultorio.paciente = '$paciente',
		paciente_consultorio.apaterno = '$apaterno',
		paciente_consultorio.amaterno = '$amaterno' ,
		paciente_consultorio.celular = '$celular' ,
		paciente_consultorio.email = '$email' 
	WHERE 
		paciente_consultorio.paciente_cons_id = $paciente_cons_id
	";

    // Ejecuta la consulta de actualización
	$result_insert = ejecutar($update);	
		
    // Llama a la función que sincroniza o modifica el cliente en el sistema externo "bind"
	modifica_cliente_bind_consulta($paciente_cons_id);			
}  
?>

