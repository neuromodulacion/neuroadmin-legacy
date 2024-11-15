<?php

// Inicia la sesión, si no se ha iniciado ya
session_start();

// Incluye el archivo que contiene las funciones de conexión y operaciones con MySQL
include("functions/funciones_mysql.php");

// Verifica si existe una sesión activa para el usuario
if ($_SESSION['usuario_id']) {
    // Obtiene el ID del usuario de la sesión
    $usuario_id = $_SESSION['usuario_id'];
	
    // Prepara una consulta SQL para actualizar el estado de la actividad del usuario a 'Caduco' en la tabla 'admin'
    $query = "UPDATE admin SET actividad = 'Caduco' WHERE usuario_id = $usuario_id";
    
    // Ejecuta la consulta SQL
    $result_UPDATE = ejecutar($query);	
}

// Destruir todas las variables de sesión
$_SESSION = array();

// Finalmente, destruir la sesión
session_destroy();

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Cerrar</title>
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


<!--
Explicación general:

PHP Script:

session_start(): Se utiliza para asegurarse de que la sesión esté iniciada, lo que permite acceder a las variables de sesión.
Incluir funciones MySQL: El archivo "functions/funciones_mysql.php" se incluye para proporcionar las funciones necesarias para ejecutar consultas en la base de datos.
Verificación y actualización del estado del usuario: Si la sesión del usuario está activa, se obtiene su ID y se actualiza su estado a "Caduco" en la tabla admin, lo que indica que la sesión ha finalizado.
Destrucción de la sesión: Todas las variables de sesión se eliminan y la sesión se destruye por completo.

HTML & CSS:

Página de cierre de sesión: Se muestra un mensaje que indica que la sesión se ha cerrado correctamente, junto con un botón para redirigir al usuario a la página de inicio.
Recursos: Se incluyen archivos CSS y JavaScript para manejar el diseño y las interacciones de la página.

JavaScript:

jQuery y otros plugins: Se utilizan para manejar efectos visuales (como ondas y animaciones) y validaciones en la página. 
->