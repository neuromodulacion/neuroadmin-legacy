<?php
// optiene_noticias.php
session_start();
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

if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['funcion_id'])) {
    $response = ['success' => false, 'message' => 'Usuario no autenticado.'];
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($response);
    exit();
}

$usuario_id_session = (int)$_SESSION['usuario_id'];
$funcion_id = (int)$_SESSION['funcion_id'];

$empresa_id = isset($_GET['empresa_id']) ? (int)$_GET['empresa_id'] : 0;
$usuario_id = (isset($_GET['usuario_id']) && $_GET['usuario_id'] !== '') ? (int)$_GET['usuario_id'] : null;

$response = ['success' => false, 'data' => []];

if ($empresa_id > 0) {
    if ($usuario_id !== null) {
        // Mostrar notificaciones generales (usuario_id IS NULL) y las específicas para este usuario
        $query = "
        SELECT 
            n.id,
            n.usuario_id,
            n.message,
            n.created_at,
            admin.nombre AS nombre_usuario,
            IF(nr.is_read IS NULL, 0, nr.is_read) AS is_read
        FROM notices n
        LEFT JOIN notice_reads nr ON n.id = nr.notice_id AND nr.usuario_id = ?
        LEFT JOIN admin ON n.usuario_id = admin.usuario_id
        WHERE n.empresa_id = ?
          AND (n.usuario_id = ? OR n.usuario_id IS NULL)
        ORDER BY n.created_at DESC;
        ";
        $params = [$usuario_id, $empresa_id, $usuario_id];

        $result = $db->consulta($query, $params);
        if ($result['numFilas'] > 0) {
            $response['success'] = true;
            $response['data'] = $result['resultado'];
        } else {
            $response['success'] = true;
            $response['data'] = [];
        }
    } else {
        $response['message'] = 'No se especificó usuario_id.';
    }
} else {
    $response['message'] = 'empresa_id no válido.';
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode($response);
