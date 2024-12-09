<?php
// optiene_noticias.php

session_start(); // Iniciar la sesión

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

// Extraer variables de sesión
if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['funcion_id'])) {
    $response = ['success' => false, 'message' => 'Usuario no autenticado.'];
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($response);
    exit();
}

$usuario_id_session = (int)$_SESSION['usuario_id'];
$funcion_id = (int)$_SESSION['funcion_id'];

$empresa_id = isset($_GET['empresa_id']) ? (int)$_GET['empresa_id'] : 0;
$usuario_id = isset($_GET['usuario_id']) && $_GET['usuario_id'] !== '' ? (int)$_GET['usuario_id'] : null;

$response = ['success' => false, 'data' => []];

if ($empresa_id > 0) {
    if ($usuario_id !== null) {
        if (in_array($funcion_id, [1, 5, 7])) {
            // Consulta para usuarios con funcion_id 1, 5, 7
            $query = "
            SELECT
                n.id,
                n.usuario_id, -- ID del usuario de la notificación
                n.message, -- Mensaje de la notificación
                n.created_at, -- Fecha de creación
                admin.nombre AS nombre_usuario, -- Nombre del usuario del administrador
                IF(nr.is_read IS NULL, 0, nr.is_read) AS is_read -- Indica si la notificación fue leída
            FROM
                notices n
                LEFT JOIN notice_reads nr ON n.id = nr.notice_id -- Relación sin considerar usuario_id
                LEFT JOIN admin ON n.usuario_id = admin.usuario_id -- Relación con la tabla de administradores
            WHERE
                n.empresa_id = ? -- Filtra notificaciones por empresa
            ORDER BY
                n.created_at DESC; -- Ordena por fecha de creación descendente";
            $params = [$usuario_id, $empresa_id];
        } else {
            // Consulta para otros usuarios
            $query = "
            SELECT 
                n.id, -- ID de la notificación
                n.usuario_id, -- Usuario de la notificación (puede ser NULL cuando es para todos)
                n.message, -- Mensaje de la notificación
                n.created_at, -- Fecha de creación de la notificación
                admin.nombre AS nombre_usuario, -- Nombre del usuario que creó la notificación (NULL si usuario_id es NULL)
                IF(nr.is_read IS NULL, 0, nr.is_read) AS is_read -- Indica si la notificación fue leída por el usuario especificado
            FROM notices n
            LEFT JOIN notice_reads nr 
                ON n.id = nr.notice_id AND nr.usuario_id = ? -- Filtra lecturas para el usuario específico
            LEFT JOIN admin 
                ON n.usuario_id = admin.usuario_id -- Relaciona notificaciones con administradores
            WHERE 
                n.empresa_id = ? -- Filtra notificaciones por empresa
                AND (n.usuario_id = ? OR n.usuario_id IS NULL) -- Incluye notificaciones específicas de usuario o generales
            ORDER BY 
                n.created_at DESC; -- Ordena las notificaciones más recientes primero
            ";
            $params = [$usuario_id, $empresa_id, $usuario_id];
        }
    } else {
        // Consulta cuando NO se especifica usuario_id
        $query = "SELECT
                    n.id,
                    n.empresa_id,
                    n.usuario_id,
                    n.message,
                    n.created_at,
                    admin.nombre AS nombre_usuario,
                    0 AS is_read
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
?>
