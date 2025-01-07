<?php
$ruta = "../../";
require_once($ruta.'functions/conexion_mysqli.php');

// Incluir el archivo de configuración y obtener las credenciales
$configPath = $ruta.'../config.php';

if (!file_exists($configPath)) {
    die('Archivo de configuración no encontrado.');
}

$config = require $configPath;

// Crear una instancia de la clase Mysql
$mysql = new Mysql($config['servidor'], $config['usuario'], $config['contrasena'], $config['baseDatos']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Agregar módulo
    $nombre_modulo = $_POST['nombre_modulo'] ?? null;
    $descripcion = $_POST['descripcion'] ?? null;

    if ($nombre_modulo && $descripcion) {
        $query = "INSERT INTO modulos (nombre_modulo, descripcion) VALUES (?, ?)";
        $result = $mysql->consulta_simple($query, [$nombre_modulo, $descripcion]);

        echo $result ? "Módulo registrado correctamente." : "Error al registrar el módulo.";
    }
	
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Listar módulos
    $query = "SELECT * FROM modulos";
    $result = $mysql->consulta($query);

    header('Content-Type: application/json');
    echo json_encode($result['resultado']);
	
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Editar descripción del módulo
    parse_str(file_get_contents("php://input"), $put_vars);
    $modulo_id = $put_vars['modulo_id'] ?? null;
    $descripcion = $put_vars['descripcion'] ?? null;

    if ($modulo_id && $descripcion) {
        $query = "UPDATE modulos SET descripcion = ? WHERE modulo_id = ?";
        $result = $mysql->consulta_simple($query, [$descripcion, $modulo_id]);

        echo $result ? "Descripción actualizada correctamente." : "Error al actualizar la descripción.";
    } else {
        echo "Datos insuficientes para actualizar.";
    }
}
?>
