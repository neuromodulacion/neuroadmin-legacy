<?php
// Activar reporte de errores para depuración
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('default_charset', 'UTF-8');
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Monterrey');
setlocale(LC_TIME, 'es_ES.UTF-8');

// Iniciar la sesión
session_start();
$_SESSION['time'] = time();

// Definir la ruta al archivo de configuración
$configPath = '../config.php';

// Verificar si el archivo de configuración existe
if (!file_exists($configPath)) {
    die('Archivo de configuración no encontrado.');
}

// Incluir el archivo de configuración y obtener las credenciales
$config = require $configPath;

// Incluir la clase de conexión
require_once "functions/conexion_mysqli.php";

// Obtener y sanitizar los datos de entrada
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$medico = isset($_POST['medico']) ? trim($_POST['medico']) : '';
$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

$f_alta = date("Y-m-d");
$h_alta = date("H:i:s");

// Validar que los campos requeridos no estén vacíos
if (empty($name) || empty($email) || empty($message)) {
    $mensaje_error = "Por favor, complete todos los campos obligatorios.";
} else {
    // Crear instancia de la clase Mysql con las credenciales del archivo de configuración
    try {
        $mysql = new Mysql($config['servidor'], $config['usuario'], $config['contrasena'], $config['baseDatos']);
    } catch (Exception $e) {
        die('Error al conectar a la base de datos. Por favor, inténtelo más tarde.');
    }

    // Preparar la consulta de inserción con parámetros
    $insert1 = "
        INSERT IGNORE INTO informes 
            (
                name,
                email,
                medico,
                phone,
                message,
                f_alta,
                h_alta,
                estatus
            ) 
        VALUES
            (
                ?, ?, ?, ?, ?, ?, ?, 'Pendiente'
            )";

    // Ejecutar la consulta con parámetros preparados
    $params = [$name, $email, $medico, $phone, $message, $f_alta, $h_alta];

    $result_insert = $mysql->insertar($insert1, $params);

    if ($result_insert === false) {
        // Manejar el error si la inserción falla
        $mensaje_error = "Error al guardar la información. Por favor, inténtelo de nuevo.";
    } else {
        // Inserción exitosa, continuar con el resto del código
        $mensaje_exito = "Solicitud enviada exitosamente.";
    }
}
?>
<!-- HTML para mostrar el mensaje de éxito o error de registro -->
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Guardado</title>
    <!-- Favicon-->
    <link rel="icon" href="../../favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body class="theme-<?php echo isset($body) ? htmlspecialchars($body) : ''; ?>">
    <div style="padding-top: 30px" class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <div align="center" style="padding: 20px;" class="five-zero-zero-container card">
                <?php if (isset($mensaje_error)): ?>
                    <div><h1>Error</h1></div>
                    <div align="center">
                        <div style="width: 90% !important;" align="left">
                            <p><?php echo htmlspecialchars($mensaje_error); ?></p>
                            <a href="index.html" class="btn bg-red btn-lg waves-effect">Volver</a>
                        </div>
                    </div>
                <?php else: ?>
                    <div><h1><?php echo htmlspecialchars($mensaje_exito); ?></h1></div>
                    <div align="center">
                        <div style="width: 90% !important;" align="left">
                            <b>Nombre:</b> <?php echo htmlspecialchars($name); ?><br>
                            <b>Correo Electrónico:</b> <?php echo htmlspecialchars($email); ?><br>
                            <b>Celular:</b> <?php echo htmlspecialchars($phone); ?><br>
                            <b>Médico tratante:</b> <?php echo htmlspecialchars($medico); ?><br>
                            <b>Mensaje:</b> <?php echo nl2br(htmlspecialchars($message)); ?><br><hr>
                            <a href="index.html" class="btn bg-green btn-lg waves-effect">CONTINUAR</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-md-4"></div>
    </div>

    <!-- Jquery Core Js -->
    <script src="plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="plugins/node-waves/waves.js"></script>
</body>

</html>
