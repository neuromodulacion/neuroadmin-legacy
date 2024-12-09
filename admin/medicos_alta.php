<?php //medicos_alta.php
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

$empresa_id = isset($_POST['empresa_id']) ? (int)$_POST['empresa_id'] : 0;
$medico = isset($_POST['medico']) ? trim($_POST['medico']) : '';

$response = ['success' => false, 'message' => ''];

if($empresa_id > 0 && $medico !== '') {
    $query = "INSERT INTO medicos (medico, empresa_id) VALUES (?, ?)";
    $params = [$medico, $empresa_id];
    $idInsertado = $db->insertar($query, $params);
    if($idInsertado) {
        $response['success'] = true;
        $response['message'] = 'Médico agregado exitosamente.';
    } else {
        $response['message'] = 'Error al agregar el médico.';
    }
} else {
    $response['message'] = 'Datos insuficientes para agregar el médico.';
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode($response);
