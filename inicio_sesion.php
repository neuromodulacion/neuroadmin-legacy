<?php
// Activar reporte de errores para depuración
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Definir la ruta al archivo de configuración
$configPath = '../config.php';

// Verificar si el archivo de configuración existe
if (!file_exists($configPath)) {
    die('Archivo de configuración no encontrado.');
}

// Incluir el archivo de configuración y obtener las credenciales
$config = require $configPath;

// Incluir la clase de conexión
include("functions/conexion_mysqli.php");

// Iniciar la sesión
session_start();

// Inicializar la variable $conexion
$conexion = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Instanciar la conexión a la base de datos con las credenciales del archivo de configuración
    try {
        $conexion = new Mysql($config['servidor'], $config['usuario'], $config['contrasena'], $config['baseDatos']);
    } catch (Exception $e) {
        die('Error al conectar a la base de datos. Por favor, inténtelo más tarde.');
    }

    // Obtener y sanitizar los datos de entrada
    $user = trim($_POST['username']);
    $pwd = trim($_POST['password']);

    // Filtrar y sanitizar la entrada del nombre de usuario
    $user = filter_var($user, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Consulta SQL para obtener el usuario por nombre de usuario
    $sql_access = "
        SELECT DISTINCT
            admin.usuario_id, 
            admin.nombre, 
            admin.usuario, 
            admin.pwd, 
            admin.acceso, 
            admin.funcion, 
            admin.funcion_id,
            admin.saldo, 
            admin.observaciones, 
            admin.estatus, 
            herramientas_sistema.perfil_id, 
            herramientas_sistema.foto, 
            herramientas_sistema.nombre_corto, 
            herramientas_sistema.body, 
            herramientas_sistema.notificaciones, 
            empresas.empresa_id, 
            empresas.emp_nombre, 
            empresas.icono, 
            empresas.logo, 
            empresas.web, 
            empresas.acceso_ia,
            empresas.bind,
            empresas.body_principal, 
            empresas.paquete_id,
            sucursales.nombre_sucursal
        FROM
            admin
            INNER JOIN
            herramientas_sistema
            ON 
                admin.usuario_id = herramientas_sistema.usuario_id
            INNER JOIN
            empresas
            ON 
                admin.empresa_id = empresas.empresa_id
            INNER JOIN
            sucursales
            ON 
                admin.sucursal_id = sucursales.sucursal_id
        WHERE
            admin.usuario = ?
    ";

    // Ejecutar la consulta con parámetros preparados
    $resultado = $conexion->consulta($sql_access, [$user]);

    // Verificar si se encontró un usuario que coincida
    if ($resultado['numFilas'] > 0) {
        // Obtener el primer registro del resultado
        $cnt = $resultado['resultado'][0];

        // Verificar si la contraseña en la base de datos es un hash o texto plano
        if (password_verify($pwd, $cnt['pwd'])) {
            // La contraseña es correcta y está hashada

            // Continuar con el inicio de sesión
        } elseif ($pwd === $cnt['pwd']) {
            // La contraseña es correcta pero no está hashada

            // Hash la contraseña y actualízala en la base de datos
            $hashed_password = password_hash($pwd, PASSWORD_DEFAULT);
            $update_query = "UPDATE admin SET pwd = ? WHERE usuario_id = ?";
            $conexion->consulta_simple($update_query, [$hashed_password, $cnt['usuario_id']]);

            // Actualizar el valor de 'pwd' en $cnt con el hash nuevo
            $cnt['pwd'] = $hashed_password;

            // Continuar con el inicio de sesión
        } else {
            // Contraseña incorrecta
            $mensaje_error = "Usuario o contraseña incorrectos. Por favor, inténtelo de nuevo.";
        }

        // Si la contraseña es correcta, proceder con el inicio de sesión
        if (!isset($mensaje_error)) {
            // Regenerar el ID de sesión para prevenir ataques de fijación de sesión
            session_regenerate_id(true);

            // Consulta para obtener la última versión
            $query = "SELECT version FROM versiones ORDER BY version_id DESC LIMIT 1";
            $resultado = $conexion->consulta($query);

            // Verifica y muestra el resultado
            if ($resultado['numFilas'] > 0) {
                $_SESSION['version'] = $resultado['resultado'][0]['version'];
            } else {
                echo "No se encontraron versiones en la tabla.";
            }


            // Configurar las variables de sesión
            $_SESSION['sesion'] = "On";
            $_SESSION['time'] = time();
            $_SESSION['usuario_id'] = $cnt['usuario_id'];
            $_SESSION['nombre'] = $cnt['nombre'];
            $_SESSION['usuario'] = $cnt['usuario'];
            // No almacenar la contraseña en la sesión por razones de seguridad
            $_SESSION['acceso'] = $cnt['acceso'];
            $_SESSION['funcion'] = $cnt['funcion'];
            $_SESSION['funcion_id'] = $cnt['funcion_id'];
            $_SESSION['saldo'] = $cnt['saldo'];
            $_SESSION['observaciones'] = $cnt['observaciones'];
            $_SESSION['perfil_id'] = $cnt['perfil_id'];
            $_SESSION['foto'] = $cnt['foto'];
            $_SESSION['nombre_corto'] = $cnt['nombre_corto'];
            $_SESSION['body'] = $cnt['body'];
            $_SESSION['notificaciones'] = $cnt['notificaciones'];
            $_SESSION['estatus'] = $cnt['estatus'];
            $_SESSION['mktime'] = time();
            $_SESSION['empresa_id'] = $cnt['empresa_id'];
            $_SESSION['emp_nombre'] = $cnt['emp_nombre'];
            $_SESSION['icono'] = $cnt['icono'];
            $_SESSION['logo'] = $cnt['logo'];
            $_SESSION['web'] = $cnt['web'];
            $_SESSION['body_principal'] = $cnt['body_principal'];
            $_SESSION['nombre_sucursal'] = $cnt['nombre_sucursal'];
            $_SESSION['bind'] = $cnt['bind'];
            $_SESSION['acceso_ia'] = $cnt['acceso_ia'];
            $_SESSION['paquete_id'] = $cnt['paquete_id'];

            // Actualizar el estado del usuario a "Activo"
            $query_update = "UPDATE admin SET actividad = 'Activo' WHERE usuario_id = ?";
            $conexion->consulta_simple($query_update, [$cnt['usuario_id']]);

            // Redirigir al menú principal
            header("Location: menu.php");
            exit();
        }
    } else {
        // Usuario no encontrado
        $mensaje_error = "Usuario o contraseña incorrectos. Por favor, inténtelo de nuevo.";
    }
} else {
    $mensaje_error = "Método de solicitud no permitido.";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Admin TSM</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <script src="https://www.google.com/recaptcha/enterprise.js?render=6LefWXQpAAAAAEVNo3MwhrL5qhPXyIoezmTk8_LP"></script>
</head>
<body class="login-page">
    <div class="login-box">
        <div class="logo">
            <a href="javascript:void(0);">Admin<b>Neuromodulación</b></a>
            <small>Administrador de Neuromodulación</small>
        </div>
        <div class="card">
            <div class="body">
                <?php if (isset($mensaje_error)): ?>
                    <form action="inicio.html" method="post">
                        <div class="msg">Error de inicio de sesión</div>
                        <div class="alert alert-danger">
                            <?= htmlspecialchars($mensaje_error, ENT_QUOTES, 'UTF-8') ?>
                        </div>
                        <button class="btn btn-block bg-pink waves-effect" type="submit">Volver</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.js"></script>
    <script src="plugins/node-waves/waves.js"></script>
</body>
</html>
