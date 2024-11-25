<?php
$ruta = '';
// Iniciar sesión de forma segura
session_start();

// Incluir el archivo que contiene las funciones de conexión y operaciones con MySQL
include($ruta.'functions/conexion_mysqli.php');

// Incluir el archivo de configuración y obtener las credenciales
$configPath = $ruta.'../config.php';

if (!file_exists($configPath)) {
    die('Archivo de configuración no encontrado.');
}

$config = require $configPath;

// Crear instancia de la clase Mysql
$mysql = new Mysql($config['servidor'], $config['usuario'], $config['contrasena'], $config['baseDatos']);

// Verifica si existe una sesión activa y valida el ID del usuario
if (isset($_SESSION['usuario_id']) && is_numeric($_SESSION['usuario_id'])) {
    // Obtiene el ID del usuario de la sesión
    $usuario_id = intval($_SESSION['usuario_id']); // Convierte a entero para mayor seguridad

    // Prepara y ejecuta una consulta SQL para actualizar el estado de la actividad del usuario
    $query = "UPDATE admin SET actividad = ? WHERE usuario_id = ?";
    $params = ['Caduco', $usuario_id];
    
    try {
        $filasAfectadas = $mysql->actualizar($query, $params);
        if ($filasAfectadas > 0) {
            // Log opcional: actividad actualizada correctamente
        }
    } catch (Exception $e) {
        error_log("Error al actualizar la actividad: " . $e->getMessage());
    }
}

// Destruye todas las variables de sesión
$_SESSION = [];

// Finalmente, destruye la sesión
session_destroy();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Cerrar Sesión</title>
    <!-- Favicon -->
    <link rel="icon" href="images/logo_aldana_tc.png" type="image/png">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    <!-- Bootstrap Core Css -->
    <link href="plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
    <!-- Waves Effect Css -->
    <link href="plugins/node-waves/waves.css" rel="stylesheet" />
    <!-- Animation Css -->
    <link href="plugins/animate-css/animate.css" rel="stylesheet" />
    <!-- Custom Css -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body class="signup-page">
    <div class="signup-box">
        <div class="logo">
            <a href="javascript:void(0);">Admin<b>Neuromodulación</b></a>
            <small>Administrador de Neuromodulación</small>
        </div>
        <div class="card">
            <div class="body">
                <!-- Muestra un mensaje de cierre de sesión y un botón para volver al inicio -->
                <form id="sign_up" action="alta_usuario.php" method="POST">
                    <h1>Sesión Cerrada</h1>
                    <!-- Botón para redirigir a la página de inicio -->
                    <a href="inicio.html" class="btn btn-block btn-lg bg-pink waves-effect" type="button">INICIO</a>
                </form>
            </div>
        </div>
    </div>

    <!-- Jquery Core Js -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap Core Js -->
    <script src="plugins/bootstrap/js/bootstrap.js"></script>
    <!-- Waves Effect Plugin Js -->
    <script src="plugins/node-waves/waves.js"></script>
    <!-- Validation Plugin Js -->
    <script src="plugins/jquery-validation/jquery.validate.js"></script>
    <!-- Custom Js -->
    <script src="js/admin.js"></script>
    <script src="js/pages/examples/sign-up.js"></script>
</body>
</html>
