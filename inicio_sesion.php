<?php
// Activar reporte de errores para depuración
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Incluir la clase de conexión
include("functions/conexion_mysqli.php");

// Iniciar la sesión
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Instanciar la conexión a la base de datos
    $conexion = new Mysql();

    // Obtener y sanitizar los datos de entrada
    $user = trim($_POST['username']);
    $pwd = trim($_POST['password']);

    // Consulta SQL para validar usuario y contraseña
    $sql_access = "
        SELECT DISTINCT
            admin.usuario_id,
            admin.nombre,
            admin.usuario,
            admin.pwd,
            admin.acceso,
            admin.funcion,
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
            empresas.body_principal 
        FROM
            admin
            INNER JOIN herramientas_sistema ON admin.usuario_id = herramientas_sistema.usuario_id
            INNER JOIN empresas ON admin.empresa_id = empresas.empresa_id 
        WHERE
            admin.usuario = ? 
            AND admin.pwd = ?
    ";

    // Ejecutar la consulta con parámetros preparados
    $resultado = $conexion->consulta($sql_access, [$user, $pwd]);

    // Verificar si se encontró un usuario que coincida
    if ($resultado['numFilas'] > 0) {
        // Obtener el primer registro del resultado
        $cnt = $resultado['resultado'][0];

        // Configurar las variables de sesión
        $_SESSION['sesion'] = "On";
        $_SESSION['time'] = time();
        $_SESSION['usuario_id'] = $cnt['usuario_id'];
        $_SESSION['nombre'] = $cnt['nombre'];
        $_SESSION['usuario'] = $cnt['usuario'];
        $_SESSION['pwd'] = $cnt['pwd'];
        $_SESSION['acceso'] = $cnt['acceso'];
        $_SESSION['funcion'] = $cnt['funcion'];
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

        // Actualizar el estado del usuario a "Activo"
        $query_update = "UPDATE admin SET actividad = 'Activo' WHERE usuario_id = ?";
        $result_UPDATE = $conexion->consulta_simple($query_update, [$cnt['usuario_id']]);

        // Redirigir al menú principal
        header("Location: menu.php");
        exit();
    } else {
        // Si las credenciales son incorrectas, muestra un mensaje de error
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
                <form action="inicio.html" method="post">
                    <div class="msg">Error de inicio de sesión</div>
                    <div class="alert alert-danger">
                        <?= $mensaje_error ?>
                    </div>
                    <button class="btn btn-block bg-pink waves-effect" type="submit">Volver</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.js"></script>
    <script src="plugins/node-waves/waves.js"></script>
</body>
</html>	