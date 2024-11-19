<?php
// Incluye funciones necesarias para el manejo de la base de datos y API
include('../functions/funciones_mysql.php');
include('../api/funciones_api.php');

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

