<?php /*
session_start();
error_reporting(E_ALL & ~E_NOTICE);

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Reporta todos los errores excepto los avisos
ini_set('default_charset', 'UTF-8');
// Establece la codificación de caracteres predeterminada
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Monterrey');
setlocale(LC_TIME, 'es_ES.UTF-8');
// Puede necesitar ajustes para Windows
$_SESSION['time'] = time();
// Guarda la hora actual en la sesión

$ruta = "../";
// Asegúrate de que esta ruta sea segura y adecuada
$empresa_id = 1;

include ($ruta . 'functions/conexion_test.php');

$mysql = new Mysql();

$query = "
	SELECT
		medicos.medico_id, 
		medicos.medico
	FROM
		medicos
	where
		medicos.empresa_id = ?";

// Incluye los caracteres de porcentaje en el valor del parámetro.
$params = [$empresa_id];

// 's' indica que el parámetro es una cadena (string)
$types = 'i';

$resultado = $mysql -> consulta($query, $params, $types);
// print_r($query);
// print_r($params);
// print_r($resultado);
// Verificar los resultados y procesarlos
if ($resultado['numFilas'] > 0) {
	// Recorre cada fila del resultado
	foreach ($resultado['resultado'] as $fila) {
		//while ($fila = mysqli_fetch_assoc($resultado['resultado'])) {
		extract($fila);
		print_r($fila);
	}
} else {
	echo "No se encontraron resultados.";
}*/
?>