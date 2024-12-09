<?php
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

$medico_id = isset($_POST['medico_id']) ? (int)$_POST['medico_id'] : 0;
$response = ['success' => false, 'message' => ''];

if($medico_id > 0) {
    $query = "DELETE FROM medicos WHERE medico_id = ?";
    $params = [$medico_id];
    $filasAfectadas = $db->eliminar($query, $params);
    if($filasAfectadas > 0) {
        $response['success'] = true;
        $response['message'] = 'Médico eliminado correctamente.';
    } else {
        $response['message'] = 'No se pudo eliminar el médico.';
    }
} else {
    $response['message'] = 'ID inválido.';
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode($response);
