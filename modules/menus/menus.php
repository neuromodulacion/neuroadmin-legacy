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
    // Registrar o actualizar menú
    $menu_id = $_POST['menu_id'] ?? null;
    $nombre_m = $_POST['nombre_m'] ?? null;
    $ruta_menu = $_POST['ruta_menu'] ?? null;
    $icono_menu = $_POST['icono_menu'] ?? null;
    $nivel = $_POST['nivel'] ?? null;
    $modulo_id = $_POST['modulo_id'] ?? null;
    $autorizacion = $_POST['autorizacion'] ?? null;

    if ($nombre_m && $ruta_menu) {
        if ($menu_id) {
            // Actualizar menú
            $query = "UPDATE menus SET nombre_m = ?, ruta_menu = ?, icono_menu = ?, nivel = ?, modulo_id = ?, autorizacion = ? WHERE menu_id = ?";
            $params = [$nombre_m, $ruta_menu, $icono_menu, $nivel, $modulo_id, $autorizacion, $menu_id];
        } else {
            // Registrar menú
            $query = "INSERT INTO menus (nombre_m, ruta_menu, icono_menu, nivel, modulo_id, autorizacion) VALUES (?, ?, ?, ?, ?, ?)";
            $params = [$nombre_m, $ruta_menu, $icono_menu, $nivel, $modulo_id, $autorizacion];
        }

        $result = $mysql->consulta_simple($query, $params);
        echo $result ? "Menú " . ($menu_id ? "actualizado" : "registrado") . " correctamente." : "Error al guardar el menú.";
    } else {
        echo "Datos insuficientes para guardar el menú.";
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Listar menús
    $query = "SELECT * FROM menus";
    $result = $mysql->consulta($query);

    header('Content-Type: application/json');
    echo json_encode($result['resultado']);
}
?>
