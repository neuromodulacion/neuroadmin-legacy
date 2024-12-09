<?php
// Inicia la sesión
session_start();

// Configuración inicial
error_reporting(E_ALL);
ini_set('default_charset', 'UTF-8');
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Monterrey');

// Configurar la localización de tiempo
setlocale(LC_TIME, stripos(PHP_OS, 'WIN') === 0 ? 'Spanish_Spain.1252' : 'es_ES.UTF-8');

// Incluye los archivos necesarios
$ruta = "../";
include($ruta . 'functions/funciones_mysql.php');
include($ruta . 'functions/conexion_mysqli.php');

// Verificar si la configuración existe
$configPath = $ruta . '../config.php';
if (!file_exists($configPath)) {
    die('Archivo de configuración no encontrado.');
}
$config = require $configPath;

// Crear conexión usando la clase Mysql
$mysql = new Mysql($config['servidor'], $config['usuario'], $config['contrasena'], $config['baseDatos']);

// Incluye funciones de correo
include('../functions/email.php');

// Variables de sesión y solicitud
extract($_SESSION);
extract($_POST);

$f_captura = date("Y-m-d");
$h_captura = date("H:i:s");

// Consulta para obtener datos de la empresa
$sql_protocolo = "
    SELECT
        emp_nombre, body_principal, icono, logo, web, e_mail, pdw, tipo_email, puerto, `host` AS e_host
    FROM empresas
    WHERE empresa_id = ?";
$result_protocolo = $mysql->consulta($sql_protocolo, [$empresa_id]);
if ($result_protocolo['numFilas'] > 0) {
    $row_protocolo = $result_protocolo['resultado'][0];
    extract($row_protocolo);
} else {
    die('Empresa no encontrada.');
}

// Verificar si el usuario ya existe
$sql_usuario = "SELECT usuario, usuario_id AS usuario_idx FROM admin WHERE usuario = ?";
$result_usuario = $mysql->consulta($sql_usuario, [$usuario]);

if ($result_usuario['numFilas'] > 0) {
    // Si el usuario ya existe, mostrar mensaje
    $row_usuario = $result_usuario['resultado'][0];
    extract($row_usuario);
    include($ruta . 'functions/header_temp.php');
    ?>
    <section class="user-registered">
        <div class="five-zero-zero-container" style="text-align: center;">
            <h1>Ya capturado anteriormente</h1>
            <h2>Usuario registrado</h2>
            <div style="margin: 0 auto; max-width: 600px; text-align: left;">
                <p><strong>Registro:</strong> <?php echo htmlspecialchars($usuario_idx, ENT_QUOTES, 'UTF-8'); ?></p>
                <p><strong>Nombre:</strong> <?php echo htmlspecialchars($nombre ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?></p>
                <p><strong>Correo Electrónico:</strong> <?php echo htmlspecialchars($usuario, ENT_QUOTES, 'UTF-8'); ?></p>
                <a href="recupera.php" class="btn bg-green btn-lg waves-effect">RECUPERAR CONTRASEÑA</a>
            </div>
        </div>
    </section>
    <?php
    include($ruta . 'functions/footer_temp.php');
    exit;
}

// Si el usuario no existe, continuar con el registro
$sql_funcion = "SELECT funcion_id FROM funciones WHERE funcion = ?";
$result_funcion = $mysql->consulta($sql_funcion, [$funcion]);

if ($result_funcion['numFilas'] > 0) {
    $row_funcion = $result_funcion['resultado'][0];
    extract($row_funcion);
} else {
    die('Función no encontrada.');
}

// Insertar nuevo usuario
$f_alta = date("Y-m-d");
$h_alta = date("H:i:s");
$sql_insert_admin = "
    INSERT IGNORE INTO admin (
        nombre, usuario, pwd, acceso, funcion_id, funcion, telefono, saldo, f_alta, h_alta, estatus, empresa_id, sucursal_id
    ) VALUES (?, ?, ?, 0, ?, ?, ?, 0, ?, ?, 'Pendiente', ?, ?)";
$result_insert_admin = $mysql->consulta(
    $sql_insert_admin,
    [$nombre, $usuario, $password_c, $funcion_id, $funcion, $celular, $f_alta, $h_alta, $empresa_id, $sucursal_id]
);

// Obtener ID del nuevo usuario
$sql_max_usuario = "SELECT MAX(usuario_id) AS usuario_id FROM admin";
$result_max_usuario = $mysql->consulta($sql_max_usuario);
$usuario_id = $result_max_usuario['resultado'][0]['usuario_id'];

// Insertar herramientas del sistema
$sql_insert_herramientas = "
    INSERT IGNORE INTO herramientas_sistema (usuario_id, body, notificaciones)
    VALUES (?, ?, 'Si')";
$result_insert_herramientas = $mysql->consulta($sql_insert_herramientas, [$usuario_id, $body_principal]);

// Actualizar invitación
$sql_update_invitacion = "UPDATE invitaciones SET estatus = 'usado' WHERE time = ?";
$result_update_invitacion = $mysql->consulta($sql_update_invitacion, [$timex]);

// Enviar correo electrónico
$destinatario = $usuario;
$asunto = "Alta de Usuario";
$cuerpo = "
    <html>
    <body>
        <h2>Se guardó correctamente la información. Continúa para confirmar tu correo.</h2>
        <p><strong>Nombre:</strong> $nombre</p>
        <p><strong>Correo Electrónico:</strong> $usuario</p>
        <a href='https://$dominio/confirmacion.php?us=$usuario_id'>Confirmar</a>
    </body>
    </html>";
$accion = "normal";
$mail = correo_electronico($usuario, $asunto, $cuerpo, $nombre, $empresa_id, $accion);

// Mostrar mensaje de éxito
include($ruta . 'functions/header_temp.php');
?>
<section class="success-message">
    <div class="five-zero-zero-container" style="text-align: center;">
        <h1>Éxito</h1>
        <h2>Se guardó correctamente la información</h2>
        <div style="margin: 0 auto; max-width: 600px; text-align: left;">
            <p><strong>Registro:</strong> <?php echo htmlspecialchars($usuario_id, ENT_QUOTES, 'UTF-8'); ?></p>
            <p><strong>Nombre:</strong> <?php echo htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8'); ?></p>
            <p><strong>Correo Electrónico:</strong> <?php echo htmlspecialchars($usuario, ENT_QUOTES, 'UTF-8'); ?></p>
        </div>
    </div>
</section>
<?php
include($ruta . 'functions/footer_temp.php');
?>
