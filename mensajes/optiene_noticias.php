<?php
$ruta = "../";
//optiene_noticias.php
include($ruta.'functions/funciones_mysql.php');
include($ruta.'functions/conexion_mysqli.php');

$configPath = $ruta.'../config.php';
if (!file_exists($configPath)) {
    die('Archivo de configuración no encontrado.');
}

$config = require $configPath;

$db = new Mysql($config['servidor'], $config['usuario'], $config['contrasena'], $config['baseDatos']);
$db->conectarse();

$empresa_id = isset($_GET['empresa_id']) ? (int)$_GET['empresa_id'] : 0;
$usuario_id = isset($_GET['usuario_id']) && $_GET['usuario_id'] !== '' ? (int)$_GET['usuario_id'] : null;

$response = ['success' => false, 'data' => []];

if ($empresa_id > 0) {
    if ($usuario_id !== null) {
        // Consulta cuando se especifica un usuario_id
        $query = "SELECT 
                    n.id, 
                    n.usuario_id, 
                    n.message, 
                    n.created_at,
                    IF(nr.is_read IS NULL, 0, nr.is_read) AS is_read,
                    admin.nombre
                  FROM notices n
                  LEFT JOIN notice_reads nr ON n.id = nr.notice_id AND nr.usuario_id = ?
                  LEFT JOIN admin ON n.usuario_id = admin.usuario_id
                  WHERE n.empresa_id = ? AND (n.usuario_id = ? OR n.usuario_id IS NULL)
                  ORDER BY n.created_at DESC";
        $params = [$usuario_id, $empresa_id, $usuario_id];
    } else {
        // Consulta cuando NO se especifica usuario_id
        $query = "SELECT
                    n.id,
                    n.empresa_id,
                    n.usuario_id,
                    n.message,
                    n.created_at,
                    0 AS is_read,
                    admin.nombre
                  FROM notices AS n
                  LEFT JOIN admin ON n.usuario_id = admin.usuario_id
                  WHERE n.empresa_id = ?
                  ORDER BY n.created_at DESC";
        $params = [$empresa_id];
    }

    $result = $db->consulta($query, $params);
    if ($result['numFilas'] > 0) {
        $response['success'] = true;
        $response['data'] = $result['resultado'];
    } else {
        $response['success'] = true;
        $response['data'] = [];
    }
} else {
    $response['message'] = 'empresa_id no válido.';
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode($response);
