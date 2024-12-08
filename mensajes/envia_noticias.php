<?php
$ruta = "../";
//envia_noticias.php
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

$empras_id = isset($_POST['empresa_id']) ? (int)$_POST['empresa_id'] : 0;
$usuario_id = isset($_POST['usuario_id']) && $_POST['usuario_id'] !== '' ? (int)$_POST['usuario_id'] : null;
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

$response = ['success' => false, 'message' => ''];

if ($empras_id > 0 && $message !== '') {
    $query = "INSERT INTO notices (empresa_id, usuario_id, message) VALUES (?, ?, ?)";
    $params = [$empras_id, $usuario_id, $message];
    $idInsertado = $db->insertar($query, $params);
    if ($idInsertado) {
        $response['success'] = true;
        $response['message'] = 'Aviso enviado con éxito.';
    } else {
        $response['message'] = 'Error al enviar el aviso.';
    }
} else {
    $response['message'] = 'Datos insuficientes para enviar el aviso.';
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode($response);
