<?php
// Iniciar sesión para acceder a las variables de sesión
session_start();

// Configuración para mostrar todos los errores
error_reporting(E_ALL);

// Configurar la zona horaria y el locale para fechas en español
date_default_timezone_set('America/Monterrey');
// Nota: setlocale puede no funcionar en algunos sistemas operativos si el locale no está instalado
setlocale(LC_TIME, 'es_ES.UTF-8');

// Registrar el tiempo de la sesión actual
$_SESSION['time'] = time();

// Obtener variables de sesión de forma segura
$empresa_id = isset($_SESSION['empresa_id']) ? intval($_SESSION['empresa_id']) : 0;
$usuario_id = isset($_SESSION['usuario_id']) ? intval($_SESSION['usuario_id']) : 0;

$ruta = "../";
include($ruta . 'functions/conexion_mysqli.php');

// Función auxiliar para sanitizar valores y evitar pasar null a funciones que esperan string
function sanitizarValor($valor) {
    return htmlspecialchars($valor ?? '', ENT_QUOTES, 'UTF-8');
}

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
    $nombre = isset($_POST['nombre']) ? sanitizarValor(trim($_POST['nombre'])) : '';
    $usuario = isset($_POST['usuario']) ? sanitizarValor(trim($_POST['usuario'])) : '';
    $celular = isset($_POST['celular']) ? sanitizarValor(trim($_POST['celular'])) : '';
    $domicilio = isset($_POST['domicilio']) ? sanitizarValor(trim($_POST['domicilio'])) : '';
    $horarios = isset($_POST['horarios']) ? sanitizarValor(trim($_POST['horarios'])) : '';
    $observaciones = isset($_POST['observaciones']) ? sanitizarValor(trim($_POST['observaciones'])) : '';
    $especialidad = isset($_POST['especialidad']) ? sanitizarValor(trim($_POST['especialidad'])) : '';

    // Validar campos requeridos
    if (empty($nombre) || empty($usuario) || empty($celular)) {
        die('Nombre, correo electrónico y celular son campos obligatorios.');
    }

    // Validar correo electrónico
    if (!filter_var($usuario, FILTER_VALIDATE_EMAIL)) {
        die('Correo electrónico inválido.');
    }

    // Definir otras variables
    $funcion = 'MEDICO';
    $f_alta = date("Y-m-d");
    $h_alta = date("H:i:s");
    $estatus = 'ACTIVO';
    $organizacion = ''; // Campo vacío por defecto
    $id_bind = ''; // Campo vacío por defecto

    try {
        // Consulta para insertar los datos
        $query = "
            INSERT INTO admin_tem (
                usuario_id, nombre, usuario, organizacion, observaciones, horarios, 
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
        header("Location: posible_referenciador.php?status=success");
        exit();
    } catch (Exception $e) {
        // Manejar errores
        error_log($e->getMessage()); // Registrar el error en el log
        echo "Error al guardar los datos. Por favor, inténtelo de nuevo más tarde.";
    }
} else {
    // Si no se accede mediante POST
    header("Location: alta_medico.php?status=error");
    exit();
}
?>
