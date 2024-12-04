<?php
// Iniciar sesión para acceso a variables de sesión
session_start();
error_reporting(E_ALL);

// Ruta para incluir archivos necesarios
$ruta = "../";
include($ruta . 'functions/funciones_mysql.php');
include($ruta . 'functions/conexion_mysqli.php');

// Ruta del archivo de configuración
$configPath = $ruta . '../config.php';

if (!file_exists($configPath)) {
    die('Archivo de configuración no encontrado.');
}

// Obtener la configuración
$config = require $configPath;

// Crear una instancia de la clase Mysql
try {
    $conexion = new Mysql($config['servidor'], $config['usuario'], $config['contrasena'], $config['baseDatos']);
    //echo "Conexión establecida correctamente.";
} catch (Exception $e) {
    die("Error en la conexión: " . $e->getMessage());
}

// Función auxiliar para sanitizar valores y evitar pasar null a htmlspecialchars()
function sanitizarValor($valor) {
    return htmlspecialchars($valor ?? '', ENT_QUOTES, 'UTF-8');
}

// Verificar el método de solicitud
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener el ID del usuario desde la solicitud
    $usuario_idx = isset($_POST['usuario_idx']) ? intval($_POST['usuario_idx']) : 0;

    if ($usuario_idx === 0) {
        echo "ID de usuario no válido.";
        exit();
    }

    try {
        // Actualizar el campo estatus a "desactivado"
        $queryUpdate = "
            UPDATE admin_tem
            SET estatus = 'desactivado'
            WHERE medico_id = ?
        ";

        $resultado = $conexion->consulta_simple($queryUpdate, [$usuario_idx]);

        if ($resultado) {
            echo "Usuario descartado correctamente.";
        } else {
            echo "Ocurrió un error al descartar el usuario.";
        }
    } catch (Exception $e) {
        // Manejo de errores
        error_log("Error al descartar usuario: " . $e->getMessage());
        echo "Ocurrió un error al descartar el usuario.";
    }
} else {
    echo "Método de solicitud no permitido.";
}
?>
