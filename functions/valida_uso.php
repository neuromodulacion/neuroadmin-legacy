<?php
// Establece el nivel de reporte de errores (7 = reporte de errores, excepto E_NOTICE y E_STRICT)
error_reporting(7);

// Establece la codificación interna para las conversiones de caracteres a UTF-8
iconv_set_encoding('internal_encoding', 'utf-8');

// Establece el encabezado de contenido como HTML con codificación UTF-8
header('Content-Type: text/html; charset=UTF-8');

// Configura la zona horaria predeterminada para las funciones de fecha y hora en PHP
date_default_timezone_set('America/Mazatlan');

// Inicia la sesión o la reanuda si ya existe
session_start();

// Extrae las variables almacenadas en $_SESSION y $_POST para hacerlas accesibles directamente
extract($_SESSION);
extract($_POST);

// Obtiene el tiempo actual en segundos desde el Unix Epoch
$hora2 = time();

// Incluye el archivo que contiene las funciones de conexión y operaciones con MySQL
include('funciones_mysql.php');

// Almacena el tiempo actual en la variable $now
$now = time();

// Recupera el valor de 'usuario_id' de la sesión
$other_time = $_SESSION['usuario_id'];

// Calcula la diferencia en segundos entre el tiempo actual y el tiempo almacenado en la sesión
$difference_in_seconds = $now - $other_time;

// Define 90 minutos en segundos (90 minutos * 60 segundos)
$ninety_minutes_in_seconds = 90 * 60;

// Verifica si la diferencia en segundos es mayor a 90 minutos
if ($difference_in_seconds > $ninety_minutes_in_seconds) {
    // Si la diferencia es mayor a 90 minutos, marca la actividad como 'Caduco' en la tabla 'admin'
    echo "La diferencia es mayor a 90 minutos. Ejecutando acción...\n";
    $update = "UPDATE admin SET actividad = 'Caduco' WHERE usuario_id = $usuario_id";
} else {
    // Si la diferencia es menor o igual a 90 minutos, mantiene la actividad como 'Activo'
    echo "La diferencia es menor o igual a 90 minutos. No se ejecuta ninguna acción.\n";
    $update = "UPDATE admin SET actividad = 'Activo' WHERE usuario_id = $usuario_id";
}

// Ejecuta la consulta SQL para actualizar el estado de actividad del usuario en la tabla 'admin'
$result_update = ejecutar($update);

// Consulta SQL para obtener la información actualizada del usuario desde la tabla 'admin'
$sql_cob = "
	SELECT
		admin.usuario_id, 
		admin.time as hora1, 
		admin.actividad
	FROM
		admin
	WHERE usuario_id = $usuario_id
";

// Ejecuta la consulta SQL para obtener la información del usuario
$result_cob = ejecutar($sql_cob);

// Extrae la fila de resultados como un array asociativo
$row_cob = mysqli_fetch_array($result_cob);
extract($row_cob);

// Muestra el estado de la actividad del usuario (Activo o Caduco)
echo $actividad;
?>
<!--
Explicación general:
Configuraciones iniciales:

Error reporting: Configura el nivel de reporte de errores.
Codificación y encabezado: Se asegura de que las conversiones de caracteres y el contenido de salida estén en UTF-8.
Zona horaria: Establece la zona horaria predeterminada para las funciones de fecha y hora.
Sesión y variables:

Se inician las sesiones y se extraen las variables de sesión y POST para simplificar el acceso.
Cálculo de tiempo:

Se calcula la diferencia entre el tiempo actual y el tiempo almacenado en la sesión para determinar si han pasado más de 90 minutos.
Actualización del estado de actividad:

Dependiendo de si han pasado más de 90 minutos, se actualiza el estado del usuario en la tabla admin como "Caduco" o se mantiene como "Activo".
Consulta adicional:

Se recupera la información actualizada del usuario desde la base de datos y se muestra el estado de la actividad.	
-->