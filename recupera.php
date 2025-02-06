<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
$ruta = "";
// Cargar dependencias de PHPMailer
require 'vendor/autoload.php';

// Incluir funciones necesarias
include('functions/conexion_mysqli.php');  // Conexión segura a MySQL

// Incluir el archivo de configuración y obtener las credenciales
$configPath = $ruta.'../config.php';

if (!file_exists($configPath)) {
    die('Archivo de configuración no encontrado.');
}

$config = require $configPath;

// Crear una instancia de la clase Mysql
$mysql = new Mysql($config['servidor'], $config['usuario'], $config['contrasena'], $config['baseDatos']);
include('functions/email.php');

session_start();
error_reporting(E_ALL);
mb_internal_encoding('UTF-8'); // Reemplazo de `iconv_set_encoding()`
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Monterrey');
setlocale(LC_TIME, 'es_ES.UTF-8');

$_SESSION['time'] = time();

// Sanitizar datos de entrada
$email = $_POST['email'] ?? '';

// Validar que el email no esté vacío
if (empty($email)) {
    die('El email es obligatorio.');
}

// Consulta SQL segura con prepared statements
$sql = "SELECT * FROM admin WHERE usuario = ?";
$params = [$email];

// Ejecutar consulta segura
$result = $mysql->consulta($sql, $params);
$cnt = $result['numFilas'];

if ($cnt == 0) {
?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <title>Alta</title>
        <link rel="icon" href="../../favicon.ico" type="image/x-icon">
        <link href="../plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
        <link href="../plugins/node-waves/waves.css" rel="stylesheet">
        <link href="../css/style.css" rel="stylesheet">
    </head>
    <body class="theme-<?php echo $body; ?>">
        <div style="text-align: center;">
            <h1>No está registrado este usuario</h1>
            <h2>Favor de registrarse</h2>
            <a href="sign-up.html" class="btn bg-green btn-lg waves-effect">REGISTRARSE</a>
        </div>
    </body>
    </html>
<?php
} else {
    // Obtener datos del usuario
    $row = $result['resultado'][0];
    $nombre = $row['nombre'];
    $pwd = $row['password']; // Asegúrate de encriptar las contraseñas en la BD.

    // Cuerpo del correo
    $asunto = "Recuperación de contraseña - $nombre";
    $cuerpo = "
    <html>
    <head>
        <title>Recuperación de contraseña</title>
    </head>
    <body>
        <p>Estimado(a) <strong>$nombre</strong>,</p>
        <p>Hemos recibido una solicitud para recuperar su contraseña.</p>
        <p><strong>Contraseña:</strong> $pwd</p>
        <p>Si no solicitó esta recuperación, contacte a soporte.</p>
        <p>Saludos,<br><strong>Equipo de Neuromodulación GDL</strong></p>
    </body>
    </html>";

    // Configuración del correo
    $mail = new PHPMailer(true);
    try {
        $mail->CharSet = 'UTF-8';
        $mail->isSMTP();
        $mail->Host = 'mail.neuromodulacion.com.mx';
        $mail->SMTPAuth = true;
        $mail->Username = 'contacto@neuromodulacion.com.mx';
        $mail->Password = '1n%v&_*&FFc~'; // ⚠️ Almacena esto en una variable de entorno segura
        $mail->Port = 465;
        $mail->setFrom('contacto@neuromodulacion.com.mx', 'Neuromodulación GDL');
        $mail->addAddress($email, $nombre);
        $mail->addBCC('contacto@neuromodulacion.com.mx');
        $mail->addCC('sanzaleonardo@gmail.com');

        $mail->isHTML(true);
        $mail->Subject = $asunto;
        $mail->Body = $cuerpo;
        $mail->AltBody = strip_tags($cuerpo);

        $mail->send();
        $mensaje = '<h3>El mensaje ha sido enviado con éxito</h3>';
    } catch (Exception $e) {
        $mensaje = "Error al enviar correo: {$mail->ErrorInfo}";
    }
?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <title>Generado</title>
        <link rel="icon" href="images/favicon.png" type="image/x-icon">
        <link href="../plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
        <link href="../plugins/node-waves/waves.css" rel="stylesheet">
        <link href="../css/style.css" rel="stylesheet">
    </head>
    <body class="theme-<?php echo $body; ?>">
        <div align="center" class="container" style="padding-top: 10%">
            <div class="card" style="width: 500px; padding: 15px" align="center">
                <h1>Éxito</h1>
                <h2>Se envió la contraseña a su correo</h2>
                <h3>Revise su correo para continuar</h3>
                <?php echo $mensaje; ?>
                <a href="inicio.html" class="btn bg-green btn-lg waves-effect">CONTINUAR</a>
            </div>
        </div>
    </body>
    </html>
<?php
}
?>
