<?php
$ruta = "../";
//marca_noticias.php
// Incluye archivos PHP necesarios para la funcionalidad adicional
include($ruta.'functions/funciones_mysql.php');
include($ruta.'functions/conexion_mysqli.php');

// Incluir el archivo de configuración y obtener las credenciales
$configPath = $ruta.'../config.php';

if (!file_exists($configPath)) {
    die('Archivo de configuración no encontrado.');
}

$config = require $configPath;

// Crear una instancia de la clase Mysql
$mysql = new Mysql($config['servidor'], $config['usuario'], $config['contrasena'], $config['baseDatos']);

// Crear una instancia de la clase Mysql
$db = new Mysql($config['servidor'], $config['usuario'], $config['contrasena'], $config['baseDatos']);
$db->conectarse();
$db->conectarse();

$usuario_id = isset($_POST['usuario_id']) ? (int)$_POST['usuario_id'] : 0;
$notice_id = isset($_POST['notice_id']) ? (int)$_POST['notice_id'] : 0;
$response = ['success' => false, 'message' => ''];

if ($usuario_id > 0 && $notice_id > 0) {
    // Verificar si ya existe un registro de lectura
    $checkQuery = "SELECT id FROM notice_reads WHERE notice_id = ? AND usuario_id = ?";
    $checkParams = [$notice_id, $usuario_id];
    $checkResult = $db->consulta($checkQuery, $checkParams);

    if ($checkResult['numFilas'] > 0) {
        // Ya existe un registro, actualizarlo a leído
        $readId = $checkResult['resultado'][0]['id'];
        $updateQuery = "UPDATE notice_reads SET is_read = 1, read_at = NOW() WHERE id = ?";
        $updateParams = [$readId];
        $filasAfectadas = $db->actualizar($updateQuery, $updateParams);
        if ($filasAfectadas > 0) {
            $response['success'] = true;
            $response['message'] = 'Aviso marcado como leído.';
        } else {
            $response['message'] = 'No se pudo marcar el aviso como leído.';
        }
    } else {
        // No existe registro, crearlo
        $insertQuery = "INSERT INTO notice_reads (notice_id, usuario_id, is_read, read_at) VALUES (?, ?, 1, NOW())";
        $insertParams = [$notice_id, $usuario_id];
        $idInsertado = $db->insertar($insertQuery, $insertParams);
        if ($idInsertado) {
            $response['success'] = true;
            $response['message'] = 'Aviso marcado como leído.';
        } else {
            $response['message'] = 'No se pudo marcar el aviso como leído.';
        }
    }
} else {
    $response['message'] = 'Faltan datos para marcar el aviso como leído.';
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode($response);
