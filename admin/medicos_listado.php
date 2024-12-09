<?php //medicos_listado.php
$ruta = "../";
include($ruta.'functions/funciones_mysql.php');
include($ruta.'functions/conexion_mysqli.php');
$configPath = $ruta.'../config.php';
if (!file_exists($configPath)) {
    die('Archivo de configuración no encontrado.');
}
$config = require $configPath;

$db = new Mysql($config['servidor'], $config['usuario'], $config['contrasena'], $config['baseDatos']);
$db->conectarse();

// Ajustar empresa_id según tu lógica (ej. de sesión o GET)
//$empresa_id = 1; // Ejemplo

if(isset($_POST['empresa_id'])) {
    $empresa_id = (int)$_POST['empresa_id'];
} elseif(isset($_GET['empresa_id'])) {
    $empresa_id = (int)$_GET['empresa_id'];
}

$response = ['success' => false, 'data' => []];

$query = "SELECT medico_id, medico, empresa_id FROM medicos WHERE empresa_id = ? ORDER BY medico";
$params = [$empresa_id];

$result = $db->consulta($query, $params);
if($result['numFilas'] > 0) {
    $response['success'] = true;
    $response['data'] = $result['resultado'];
} else {
    $response['success'] = true; // Sin errores pero sin datos
    $response['data'] = [];
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode($response);
