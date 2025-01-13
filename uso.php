<?php
// Activar reporte de errores para depuración
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Incluir el autoload de Composer
$autoload_path = isset($ruta) ? $ruta . "vendor/autoload.php" : "vendor/autoload.php";

if (file_exists($autoload_path)) {
    require_once $autoload_path;
} else {
    die("Error: No se pudo cargar el autoload de Composer.");
}

use UAParser\Parser;

// Obtener el agente de usuario
$agenteDeUsuario = $_SERVER["HTTP_USER_AGENT"] ?? '';

// Crear una instancia del parseador
$parseador = Parser::create();
$resultado = $parseador->parse($agenteDeUsuario);

// Obtener información del sistema, navegador y dispositivo
$sistema = $resultado->os->toString();
$navegador = $resultado->ua->toString();
$dispositivo = $resultado->device->family;
$ip = $_SERVER['REMOTE_ADDR'] ?? '';

// Obtener la ruta actual del script
$rutas = $_SERVER['SCRIPT_NAME'] ?? '';

// Fechas y horas actuales
$f_captura = date("Y-m-d");
$h_captura = date("H:i:s");
$data_time = date("Y-m-d H:i:s");
$timestamp = time();

$time = time();
$usuario_id = $usuario_id ?? 0;

if ($usuario_id === null) {
    die('Usuario no autenticado.');
}

// Preparar y ejecutar la consulta INSERT utilizando parámetros preparados
$sql_insert = "
    INSERT IGNORE INTO historico_uso 
    (   
        usuario_id, 
        ip, 
        ruta, 
        navegador, 
        sistema_operativo, 
        dispositivo, 
        f_movimiento, 
        h_movimiento
    )
    VALUES
    ( 
        ?, ?, ?, ?, ?, ?, ?, ?
    )
";

$params_insert = [$usuario_id, $ip, $rutas, $navegador, $sistema, $dispositivo, $f_captura, $h_captura];

$result_insert = $mysql->consulta_simple($sql_insert, $params_insert);

if ($result_insert === false) {
    // Manejar el error si la inserción falla
    error_log('Error al insertar en historico_uso: ' . $mysql->error);
}

// Preparar y ejecutar la consulta UPDATE utilizando parámetros preparados
$update = "
    UPDATE admin
    SET
        time = ?,
        actividad = 'Activo',
        hora = ?
    WHERE
        usuario_id = ?
";

$params_update = [$time, $data_time, $usuario_id];

$result_update = $mysql->consulta_simple($update, $params_update);

if ($result_update === false) {
    // Manejar el error si la actualización falla
    error_log('Error al actualizar admin: ' . $mysql->error);
}
?>
