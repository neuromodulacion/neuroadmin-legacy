<?php
// Iniciar sesión para acceder a las variables de sesión
session_start();

// Configuración para mostrar todos los errores
error_reporting(E_ALL);

// Configuración de la codificación interna y la cabecera de contenido
iconv_set_encoding('internal_encoding', 'utf-8'); 
header('Content-Type: text/html; charset=UTF-8');

// Configurar la zona horaria y el locale para fechas en español
date_default_timezone_set('America/Monterrey');
setlocale(LC_TIME, 'es_ES.UTF-8');

// Registrar el tiempo de la sesión actual
$_SESSION['time'] = time();

// Extraer variables de sesión en el ámbito actual
extract($_SESSION);

$ruta = "../";
include($ruta . 'functions/conexion_mysqli.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ruta del archivo de configuración
    $configPath = $ruta . '../config.php';

    if (!file_exists($configPath)) {
        die('Archivo de configuración no encontrado.');
    }

    // Obtener la configuración
    $config = require $configPath;

    // Crear conexión
    $conexion = new Mysql($config['servidor'], $config['usuario'], $config['contrasena'], $config['baseDatos']);

    // Capturar los datos del formulario y sanitizar
    $nombre = trim(filter_var($_POST['nombre'], FILTER_SANITIZE_STRING));
    $usuario = trim(filter_var($_POST['usuario'], FILTER_SANITIZE_EMAIL));
    $celular = trim(filter_var($_POST['celular'], FILTER_SANITIZE_STRING));
    $domicilio = trim(filter_var($_POST['domicilio'], FILTER_SANITIZE_STRING));
    $horarios = trim(filter_var($_POST['horarios'], FILTER_SANITIZE_STRING));
    $especialidad = trim(filter_var($_POST['observaciones'], FILTER_SANITIZE_STRING));
    $funcion = 'MEDICO';
    $f_alta = date("Y-m-d");
    $h_alta = date("H:i:s");
    $estatus = 'ACTIVO';
    $empresa_id = intval($_SESSION['empresa_id']);
    $usuario_id = intval($_SESSION['usuario_id']);
    $observaciones = trim(filter_var($_POST['especialidad'], FILTER_SANITIZE_STRING));
    $organizacion = ''; // Campo vacío por defecto
    $id_bind = ''; // Campo vacío por defecto

    try {
        // Consulta para insertar los datos
        $query = "
            INSERT INTO admin_tem (
                usuario_id,nombre, usuario, organizacion, observaciones, horarios, 
                funcion, f_alta, h_alta, estatus, telefono, empresa_id, 
                id_bind, especialidad, domicilio
            ) VALUES (
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
            )
        ";

        // Ejecutar la consulta
        $conexion->consulta_simple($query, [
            $usuario_id, $nombre, $usuario, $organizacion, $observaciones, $horarios,
            $funcion, $f_alta, $h_alta, $estatus, $celular, $empresa_id,
            $id_bind, $especialidad, $domicilio
        ]);

        // Redirigir con mensaje de éxito
        header("Location: alta_medico.php?status=success");
        exit();
    } catch (Exception $e) {
        // Manejar errores
        echo "Error al guardar los datos: " . $e->getMessage();
    }
} else {
    // Si no se accede mediante POST
    header("Location: alta_medico.php?status=error");
    exit();
}
?>
