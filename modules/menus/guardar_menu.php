<?php
// Inicia una nueva sesión o reanuda la existente
session_start();
error_reporting(E_ALL);
ini_set('default_charset', 'UTF-8');
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Monterrey');

$ruta ="../../";
include($ruta.'functions/conexion_mysqli.php');

// Incluir el archivo de configuración y obtener las credenciales
$configPath = $ruta.'../config.php';

if (!file_exists($configPath)) {
    die('Archivo de configuración no encontrado.');
}

$config = require $configPath;

// Crear una instancia de la clase Mysql
$mysql = new Mysql($config['servidor'], $config['usuario'], $config['contrasena'], $config['baseDatos']);
print_r($_POST);
try {
    // Verificar si los datos se enviaron por POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Sanitizar y obtener los datos del formulario
        $nombre_m      = htmlspecialchars($_POST['nombre_m']);
        $ruta_menu     = htmlspecialchars($_POST['ruta_menu']);
        $icono_menu    = htmlspecialchars($_POST['icono_menu'], ENT_QUOTES, 'UTF-8');
		$icono_menu    = $_POST['icono_menu'];
        $nivel         = (int)$_POST['nivel'];
        $modulo_id     = (int)$_POST['modulo_id'];
        $autorizacion  = htmlspecialchars($_POST['autorizacion']);
		$tipo_m = ($_POST['tipo_m']);
        // Validar que los campos requeridos no estén vacíos
        if (!empty($nombre_m) && !empty($ruta_menu) && !empty($icono_menu) && !empty($nivel) && !empty($modulo_id)) {
            // Preparar la consulta para insertar en la tabla menus
            if ($tipo_menu == 'principal') {
                // Query para insertar en la tabla menus
                $query = "INSERT INTO menus (nombre_m, ruta_menu, icono_menu, nivel, modulo_id, autorizacion, tipo_m) 
                            VALUES (?, ?, ?, ?, ?, ?, ?)";
                echo "$nombre_m, $ruta_menu, $icono_menu, $nivel, $modulo_id, $autorizacion]";
                // Ejecutar la consulta usando tu método 'consulta_simple'
                $resultado = $mysql->consulta_simple($query, [$nombre_m, $ruta_menu, $icono_menu, $nivel, $modulo_id, $autorizacion,$tipo_m]);
            }else{
                // Query para insertar en la tabla submenus
                $query = "INSERT INTO submenus (menu_id, nombre_s, ruta_submenu, tipo_s, autorizacion,  iconos) 
                            VALUES (?, ?, ?, ?, ?, ?, ?)";
                // Mostrar los valores que se están insertando (para depuración)
                echo "$menu_id, $nombre_m, $ruta_menu, $tipo_m, $autorizacion, $icono_menu";
                // Ejecutar la consulta usando el método 'consulta_simple'
                $resultado = $mysql->consulta_simple($query, [$menu_id, $nombre_m, $ruta_menu, $tipo_m, $autorizacion, $icono_menu]);
            }
            if ($resultado) {
                echo "Los datos se guardaron correctamente.";
            } else {
                echo "Error al guardar los datos.";
            }
        } else {
            echo "Todos los campos obligatorios deben ser completados.";
        }
    } else {
        echo "Acceso no permitido.";
    }
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
// Redirigir al final sin imprimir nada antes:
header("Location: gestionar_menus.php");
?>
