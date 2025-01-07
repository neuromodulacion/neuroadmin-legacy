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
    // Registrar o actualizar submenú
    $sub_menu_id = $_POST['sub_menu_id'] ?? null;
    $nombre_s = $_POST['nombre_s'] ?? null;
    $ruta_submenu = $_POST['ruta_submenu'] ?? null;
    $iconos = $_POST['iconos'] ?? null;
    $menu_id = $_POST['menu_id'] ?? null;
    $autorizacion = $_POST['autorizacion'] ?? null;

    if ($nombre_s && $ruta_submenu) {
        if ($sub_menu_id) {
            // Actualizar submenú
            $query = "UPDATE submenus SET nombre_s = ?, ruta_submenu = ?, iconos = ?, menu_id = ?, autorizacion = ? WHERE sub_menu_id = ?";
            $params = [$nombre_s, $ruta_submenu, $iconos, $menu_id, $autorizacion, $sub_menu_id];
        } else {
            // Registrar submenú
            $query = "INSERT INTO submenus (nombre_s, ruta_submenu, iconos, menu_id, autorizacion) VALUES (?, ?, ?, ?, ?)";
            $params = [$nombre_s, $ruta_submenu, $iconos, $menu_id, $autorizacion];
        }

        $result = $mysql->consulta_simple($query, $params);
        echo $result ? "Submenú " . ($sub_menu_id ? "actualizado" : "registrado") . " correctamente." : "Error al guardar el submenú.";
    } else {
        echo "Datos insuficientes para guardar el submenú.";
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Listar submenús
    $query = "
        SELECT s.*, m.nombre_m AS menu_nombre 
        FROM submenus s
        LEFT JOIN menus m ON s.menu_id = m.menu_id
    ";
    $result = $mysql->consulta($query);

    header('Content-Type: application/json');
    echo json_encode($result['resultado']);
}
?>
