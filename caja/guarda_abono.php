<?php
$ruta = "../";
// función de cabecera (puede contener session_start(), etc.)
include($ruta.'functions/fun_inicio.php');

// Para PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Fecha y hora actuales
$f_captura = date("Y-m-d");
$h_captura = date("H:i:s");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Incluir conexión a la base de datos
    include($ruta.'functions/conexion_mysqli.php');
    
    // Cargar archivo de configuración
    $configPath = $ruta.'../config.php';
    if (!file_exists($configPath)) {
        die('Archivo de configuración no encontrado.');
    }
    $config = require $configPath;

    // Instanciar la conexión
    $conexion = new Mysql(
        $config['servidor'],
        $config['usuario'],
        $config['contrasena'],
        $config['baseDatos']
    );

    // --------------------------------------------------------------------------------
    // Sanitizar inputs de $_POST (reemplazamos FILTER_SANITIZE_STRING)
    // --------------------------------------------------------------------------------
    // 1) Eliminamos etiquetas HTML con strip_tags
    // 2) Convertimos caracteres especiales con htmlspecialchars
    $usernamex_raw = strip_tags($_POST['usernamex']);
    $usernamex     = htmlspecialchars(trim($usernamex_raw), ENT_QUOTES, 'UTF-8');

    // Contraseña (no aplicamos strip_tags porque queremos comprobar exactitud)
    $passwordx = trim($_POST['passwordx']);

    // Convertir importe a float
    $importe = floatval($_POST['importe']);

    // Recuperar datos de sesión (debe haberse hecho session_start() antes)
    $usuario_id  = intval($_SESSION['usuario_id']); 
    $empresa_id  = intval($_SESSION['empresa_id']);
    $nombre_sesion = $_SESSION['nombre'] ?? ''; // Nombre de quien recibe, si deseas usarlo

    // --------------------------------------------------------------------------------
    // Validar que el usuario que autoriza/abona exista y tenga permisos
    // --------------------------------------------------------------------------------
    $sql_access = "
        SELECT
            admin.usuario_id AS usuario_id_abona,
            admin.usuario    AS correo_abona,
            admin.nombre     AS nombrex,
            admin.pwd
        FROM admin
        WHERE admin.usuario = ?
          AND admin.funcion IN ('ADMINISTRADOR','SISTEMAS','RECEPCION')
          AND admin.usuario_id <> ?
          AND admin.empresa_id = ?
    ";

    // Ejecutar consulta
    $resultado = $conexion->consulta($sql_access, [$usernamex, $usuario_id, $empresa_id]);

    // Validar si se encontró un registro
    if ($resultado['numFilas'] === 1) {
        // Extraemos datos
        $usuario_data      = $resultado['resultado'][0];
        $usuario_id_abona  = $usuario_data['usuario_id_abona'];
        $correo_abona      = $usuario_data['correo_abona']; // Por si quieres usarlo
        $nombrex           = $usuario_data['nombrex'];
        $hashed_pwd        = $usuario_data['pwd'];

        // --------------------------------------------------------------------------------
        // Verificar la contraseña
        // --------------------------------------------------------------------------------
        if (password_verify($passwordx, $hashed_pwd)) {
            // Contraseña correcta (en formato hash)
            // Aquí se realiza el abono:
            
            // (1) Insertar en abonos
            $insert_abonos = "
                INSERT IGNORE INTO abonos 
                (
                    abonos.usuario_id,
                    abonos.f_captura,
                    abonos.h_captura,
                    abonos.importe,
                    abonos.usuario_id_abona,
                    abonos.empresa_id,
                    abonos.nombrex
                )
                VALUES (?, ?, ?, ?, ?, ?, ?)";
            
            $conexion->consulta_simple($insert_abonos, [
                $usuario_id,      // El que recibe el abono
                $f_captura,
                $h_captura,
                $importe,
                $usuario_id_abona, // Quien autoriza (abona)
                $empresa_id,
                $nombrex          // Nombre de quien abona
            ]);

            // (2) Insertar en retiros (porque en la lógica inversa, abonar a $usuario_id es retirar de $usuario_id_abona)
            $insert_retiros = "
                INSERT IGNORE INTO retiros
                (
                    retiros.usuario_id,
                    retiros.f_captura,
                    retiros.h_captura,
                    retiros.importe,
                    retiros.usuario_id_retira,
                    retiros.empresa_id,
                    retiros.nombrex
                )
                VALUES (?, ?, ?, ?, ?, ?, ?)";
            
            $conexion->consulta_simple($insert_retiros, [
                $usuario_id_abona, // Quien está “retirando” el dinero
                $f_captura,
                $h_captura,
                $importe,
                $usuario_id,       // Quien lo recibe
                $empresa_id,
                $nombrex
            ]);

            // (3) Actualizar saldos:
            //     - A quien abona (autoriza) se le descuenta saldo
            //     - A quien recibe se le incrementa saldo
            $update_abona = "UPDATE admin SET saldo = saldo - ? WHERE usuario_id = ?";
            $conexion->consulta_simple($update_abona, [$importe, $usuario_id_abona]);

            $update_recibe = "UPDATE admin SET saldo = saldo + ? WHERE usuario_id = ?";
            $conexion->consulta_simple($update_recibe, [$importe, $usuario_id]);

            // Mensaje de éxito
            echo "<h1 style='color: green'>Se abonó correctamente $".number_format($importe)."</h1>";

            // (4) Enviar notificación de abono
            sendEmailNotification($usernamex, $nombrex, $importe, $_SESSION['usuario'], $nombre_sesion);

        } else {
            // Contraseña incorrecta
            echo "<h1 style='color: red'>Contraseña incorrecta</h1>
                  <h3>No se aplicó ningún abono</h3>";
        }
    } else {
        // No se encontró o no está autorizado
        echo "<h1 style='color: red'>Usuario no autorizado o no encontrado</h1>
              <h3>No se aplicó ningún abono</h3>";
    }
}

/**
 * Envía notificación por correo sobre el abono.
 * Ajusta la configuración SMTP a tu entorno real.
 */
function sendEmailNotification($usernamex, $nombrex, $importe, $usuario, $nombre)
{
    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor de correo
        $mail->isSMTP();
        $mail->Host       = 'mail.neuromodulacion.com.mx'; 
        $mail->SMTPAuth   = true;
        $mail->Username   = 'contacto@neuromodulacion.com.mx'; 
        $mail->Password   = '1n%v&_*&FFc~'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Ajuste de caracteres
        $mail->CharSet = 'UTF-8';

        // Opcional: quién envía el correo
        $mail->setFrom('contacto@neuromodulacion.com.mx', 'Neuromodulacion');

        // Destinatarios
        // Quien recibe (el usuario logueado)
        $mail->addAddress($usuario, $nombre);
        // Quien abona (autoriza)
        $mail->addCC($usernamex, $nombrex);
        // Copias adicionales
        $mail->addCC('admin@neuromodulaciongdl.com', 'Georgina Ramirez');
        $mail->addCC('sanzaleonardo@gmail.com', 'Leonardo Sanz');

        // Contenido
        $mail->isHTML(true);
        $mail->Subject = 'Notificación de Abono de Dinero '.date('d-m-Y H:i:s');
        $mail->Body = "
            Hola,<br><br>
            Se ha realizado un abono de dinero.<br><br>
            <strong>Abona:</strong> $nombrex<br>
            <strong>Recibe:</strong> $nombre<br>
            <strong>Fecha:</strong> ".date('d-m-Y H:i:s')."<br>
            <strong>Importe:</strong> $".number_format($importe)."<br><br>
            Saludos.
        ";

        $mail->send();
        // Si quisieras informar que el mail se envió con éxito:
        // echo 'Correo de notificación enviado correctamente';
    } catch (Exception $e) {
        echo "No se pudo enviar el mensaje. Error de correo: {$mail->ErrorInfo}";
    }
}
?>

<?php /*
$ruta="../";
// función de cabecera
include($ruta.'functions/fun_inicio.php');
// archivos para correos
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$f_captura = date("Y-m-d");
$h_captura = date("H:i:s");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Incluir la conexión a la base de datos
    include($ruta.'functions/conexion_mysqli.php');
    $configPath = $ruta.'../config.php';

    if (!file_exists($configPath)) {
        die('Archivo de configuración no encontrado.');
    }
    $config = require $configPath;

    $conexion = new Mysql($config['servidor'], $config['usuario'], $config['contrasena'], $config['baseDatos']);

    // Obtener y sanitizar entradas
    $usernamex = trim(filter_var($_POST['usernamex'], FILTER_SANITIZE_STRING));
    $passwordx = trim($_POST['passwordx']);
    $importe = floatval($_POST['importe']);
    $usuario_id = intval($_SESSION['usuario_id']); // Debe estar en la sesión
    $empresa_id = intval($_SESSION['empresa_id']);

    // Consulta para validar el usuario
    $sql_access = "
        SELECT
            admin.usuario_id AS usuario_id_abona,
            admin.usuario AS correo_abona,
            admin.nombre AS nombrex,
            admin.pwd
        FROM
            admin
        WHERE
            admin.usuario = ?
            AND admin.funcion IN ('ADMINISTRADOR','SISTEMAS','RECEPCION')
            AND admin.usuario_id <> ?
            AND admin.empresa_id = ?
    ";

    $resultado = $conexion->consulta($sql_access, [$usernamex, $usuario_id, $empresa_id]);

    if ($resultado['numFilas'] === 1) {
        $usuario_data = $resultado['resultado'][0];
        $usuario_id_abona = $usuario_data['usuario_id_abona'];
        $nombrex = $usuario_data['nombrex'];
        $hashed_pwd = $usuario_data['pwd'];

        // Verificar la contraseña hashada
        if (password_verify($passwordx, $hashed_pwd)) {
            // Insertar en abonos
            $insert_abonos = "
                INSERT IGNORE INTO abonos 
                (   
                    abonos.usuario_id, 
                    abonos.f_captura, 
                    abonos.h_captura, 
                    abonos.importe, 
                    abonos.usuario_id_abona, 
                    abonos.empresa_id,
                    abonos.nombrex
                )
                VALUES
                (?, ?, ?, ?, ?, ?, ?)";
            $conexion->consulta_simple($insert_abonos, [$usuario_id, $f_captura, $h_captura, $importe, $usuario_id_abona, $empresa_id, $nombrex]);

            // Insertar en retiros
            $insert_retiros = "
                INSERT IGNORE INTO retiros 
                (   
                    retiros.usuario_id, 
                    retiros.f_captura, 
                    retiros.h_captura, 
                    retiros.importe, 
                    retiros.usuario_id_retira, 
                    retiros.empresa_id,
                    retiros.nombrex
                )
                VALUES
                (?, ?, ?, ?, ?, ?, ?)";
            $conexion->consulta_simple($insert_retiros, [$usuario_id_abona, $f_captura, $h_captura, $importe, $usuario_id, $empresa_id, $nombrex]);

            // Actualizar saldos
            $update_abona = "UPDATE admin SET saldo = saldo - ? WHERE usuario_id = ?";
            $conexion->consulta_simple($update_abona, [$importe, $usuario_id_abona]);

            $update_recibe = "UPDATE admin SET saldo = saldo + ? WHERE usuario_id = ?";
            $conexion->consulta_simple($update_recibe, [$importe, $usuario_id]);

            echo "<h1 style='color: green'>Se abonó correctamente $".number_format($importe)." </h1>";

            // Enviar notificación por correo
            sendEmailNotification($usernamex, $nombrex, $importe, $_SESSION['usuario'], $_SESSION['nombre']);
        } else {
            echo "<h1 style='color: red'>Contraseña incorrecta</h1>
            <h3>No se aplicó ningún abono</h3>";
        }
    } else {
        echo "<h1 style='color: red'>Usuario no autorizado o no encontrado</h1>
        <h3>No se aplicó ningún abono</h3>";
    }
}

function sendEmailNotification($usernamex, $nombrex, $importe, $usuario, $nombre) {
    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor de correo
        $mail->isSMTP();
        $mail->Host = 'mail.neuromodulacion.com.mx'; // Configura el servidor SMTP
        $mail->SMTPAuth = true;
        $mail->Username = 'contacto@neuromodulacion.com.mx'; // Correo SMTP
        $mail->Password = '1n%v&_*&FFc~'; // Contraseña SMTP
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Configuración de la codificación de caracteres
        $mail->CharSet = 'UTF-8';

        $mail->setFrom('contacto@neuromodulacion.com.mx', 'Neuromodulacion');

        // Destinatarios
        $mail->addAddress($usuario, $nombre);
        $mail->addCC($usernamex, $nombrex);
        $mail->addCC('admin@neuromodulaciongdl.com', 'Georgina Ramirez');
        $mail->addCC('sanzaleonardo@gmail.com', 'Leonardo Sanz');

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = 'Notificación de Abono de Dinero '.date('d-m-Y T H:i:s');
        $mail->Body = "
        Hola,<br><br>
        Se ha realizado un abono de dinero.<br><br>
        Abona: $nombrex<br>
        Recibe: $nombre<br> 
        Fecha: ".date('d-m-Y T H:i:s')."
        Importe: $".number_format($importe)."<br><br>
        Saludos.";

        $mail->send();
    } catch (Exception $e) {
        echo "No se pudo enviar el mensaje. Error de correo: {$mail->ErrorInfo}";
    }
}*/
?>