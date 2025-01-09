<?php
// guarda_retiro.php

// Ajusta la ruta a tu estructura de archivos
$ruta = "../";

// Si usas un archivo para configuraciones globales o funciones de arranque:
include($ruta.'functions/fun_inicio.php');

// Para enviar correos con PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Capturamos fecha y hora actuales
$f_captura = date("Y-m-d");
$h_captura = date("H:i:s");

// Validar que sea una solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Incluir la clase de conexión a la base de datos
    include($ruta.'functions/conexion_mysqli.php');

    // Incluir archivo de configuración donde tengas las credenciales
    $configPath = $ruta.'../config.php';
    if (!file_exists($configPath)) {
        die('Archivo de configuración no encontrado.');
    }
    $config = require $configPath;

    // Crear instancia de conexión
    $conexion = new Mysql(
        $config['servidor'],
        $config['usuario'],
        $config['contrasena'],
        $config['baseDatos']
    );

    // 1) Sanitizar y capturar los datos de formulario
    //    Sustituimos FILTER_SANITIZE_STRING (obsoleto) por strip_tags() + htmlspecialchars()
    //    para evitar inyección de HTML y otros riesgos.
    $usernamex = trim(strip_tags($_POST['usernamex']));
    $usernamex = htmlspecialchars($usernamex, ENT_QUOTES, 'UTF-8');

    // Para la contraseña, no solemos mostrarla en ningún lugar, 
    // pero igual podemos "trim()" para quitar espacios en blanco.
    $passwordx = trim($_POST['passwordx']);

    // Convertir a float (en caso de que importe contenga valor decimal)
    $importe = floatval($_POST['importe']);

    // Datos del usuario logueado (entidad que entrega el dinero)
    // Asegúrate de tener session_start() en tu lógica previa.
    $usuario_id   = intval($_SESSION['usuario_id']);
    $empresa_id   = intval($_SESSION['empresa_id']);
    $nombreSesion = $_SESSION['nombre'];      // Nombre de quien entrega
    $correoEntrega = $_SESSION['usuario'];    // Correo (o usuario) de quien entrega (opcional para envíos de mail)

    // 2) Verificar si existe un usuario *autorizado* que pueda recibir el retiro
    //    (ADMINISTRADOR, SISTEMAS, RECEPCION, etc.), distinto al que entrega.
    $sql_access = "
        SELECT 
            admin.usuario_id       AS usuario_id_retira,
            admin.nombre           AS nombrex,
            admin.pwd              AS pwdAlmacenado
        FROM admin
        WHERE admin.usuario = ?
          AND admin.funcion IN ('ADMINISTRADOR', 'SISTEMAS', 'RECEPCION')
          AND admin.usuario_id <> ?
          AND admin.empresa_id = ?
    ";

    // Ejecutar consulta con parámetros
    $resultado = $conexion->consulta($sql_access, [
        $usernamex,
        $usuario_id,
        $empresa_id
    ]);

    // Verificamos si hay un registro
    if ($resultado['numFilas'] === 1) {
        // Datos del registro
        $usuario_data      = $resultado['resultado'][0];
        $usuario_id_retira = intval($usuario_data['usuario_id_retira']);
        $nombrex           = $usuario_data['nombrex'];
        $pwdAlmacenado     = $usuario_data['pwdAlmacenado'];

        // 3) Verificar la contraseña
        //    a) Si coincide el hash -> OK
        //    b) Si coincide en texto plano -> "Hash on the fly"
        //    c) Caso contrario -> error
        if (password_verify($passwordx, $pwdAlmacenado)) {
            // Contraseña hash OK
        } elseif ($passwordx === $pwdAlmacenado) {
            // Contraseña en texto plano
            $hashedPwd = password_hash($passwordx, PASSWORD_DEFAULT);
            $updateQuery = "UPDATE admin SET pwd = ? WHERE usuario_id = ?";
            $conexion->consulta_simple($updateQuery, [
                $hashedPwd,
                $usuario_id_retira
            ]);
            // Actualizamos variable local
            $pwdAlmacenado = $hashedPwd;
        } else {
            // Contraseña incorrecta
            echo "<h1 style='color: red'>Contraseña incorrecta</h1>
                  <h3>No se aplicó ningún retiro</h3>";
            exit; // Terminamos la ejecución
        }

        // 4) Insertar datos en la tabla 'retiros'
        $sql_insert_retiro = "
            INSERT IGNORE INTO retiros
                (usuario_id, f_captura, h_captura, importe, usuario_id_retira, empresa_id, nombrex)
            VALUES
                (?, ?, ?, ?, ?, ?, ?)
        ";
        $conexion->consulta_simple($sql_insert_retiro, [
            $usuario_id,
            $f_captura,
            $h_captura,
            $importe,
            $usuario_id_retira,
            $empresa_id,
            $nombrex
        ]);

        // 5) Insertar abono (tabla 'abonos') para el usuario que recibe
        $sql_insert_abono = "
            INSERT IGNORE INTO abonos
                (usuario_id, f_captura, h_captura, importe, usuario_id_abona, empresa_id, nombrex)
            VALUES
                (?, ?, ?, ?, ?, ?, ?)
        ";
        $conexion->consulta_simple($sql_insert_abono, [
            $usuario_id_retira,
            $f_captura,
            $h_captura,
            $importe,
            $usuario_id,
            $empresa_id,
            $nombreSesion // Nombre de quien entrega
        ]);

        // 6) Actualizar saldos
        //    - Al que retira (+) 
        //    - Al que entrega (-)
        $sql_up_retira = "UPDATE admin SET saldo = saldo + ? WHERE usuario_id = ?";
        $conexion->consulta_simple($sql_up_retira, [
            $importe,
            $usuario_id_retira
        ]);

        $sql_up_entrega = "UPDATE admin SET saldo = saldo - ? WHERE usuario_id = ?";
        $conexion->consulta_simple($sql_up_entrega, [
            $importe,
            $usuario_id
        ]);

        // 7) Mensaje de éxito
        echo "<h1 style='color: green'>
              Se retiró correctamente $".number_format($importe)."
              </h1>";

        // 8) Enviar correo de notificación
        sendEmailNotification(
            $usernamex,      // correo de quien autoriza
            $nombrex,        // nombre de quien autoriza
            $importe,
            $correoEntrega,  // correo (o usuario) de quien entrega
            $nombreSesion    // nombre de quien entrega
        );

    } else {
        // Usuario no autorizado o no encontrado
        echo "<h1 style='color: red'>Usuario no autorizado o no encontrado</h1>
              <h3>No se aplicó ningún retiro</h3>";
    }
}

/**
 * Envía correo de notificación del retiro.
 * Ajusta la configuración SMTP (host, user, pass) a tu servidor real.
 */
function sendEmailNotification($correoAutoriza, $nombreAutoriza, $importe, $correoEntrega, $nombreEntrega) {
    // Si no lo tienes en el autoload de Composer, deberías hacer:
    // require_once '../vendor/autoload.php';
    // O la ruta a tu PHPMailer (PHPMailer.php, SMTP.php, Exception.php)

    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host       = 'mail.neuromodulacion.com.mx'; // Ajusta a tu servidor SMTP
        $mail->SMTPAuth   = true;
        $mail->Username   = 'contacto@neuromodulacion.com.mx'; // Usuario SMTP
        $mail->Password   = '1n%v&_*&FFc~';                   // Contraseña SMTP
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587; // Puerto para TLS

        // Codificación
        $mail->CharSet    = 'UTF-8';
        // Nivel de debug (0 = desactivado, 1 = errores, 2 = verbose)
        $mail->SMTPDebug  = 0;

        // Destinatarios principales
        $mail->addAddress($correoEntrega, $nombreEntrega); // Quien entrega
        $mail->addCC($correoAutoriza, $nombreAutoriza);    // Quien autoriza

        // Otros destinatarios en copia (opcional)
        $mail->addCC('admin@neuromodulaciongdl.com', 'Admin Neuromodulación');
        $mail->addCC('sanzaleonardo@gmail.com', 'Leonardo Sanz');

        // Contenido del mensaje
        $mail->isHTML(true);
        $mail->Subject = 'Notificación de Retiro de Efectivo: '.date('d-m-Y H:i:s');
        
        $mail->Body = "
            <p>Hola,</p>
            <p>Se ha realizado un retiro de efectivo.</p>
            <ul>
                <li><strong>Retira:</strong> {$nombreAutoriza}</li>
                <li><strong>Entrega:</strong> {$nombreEntrega}</li>
                <li><strong>Fecha y hora:</strong> ".date('d-m-Y H:i:s')."</li>
                <li><strong>Importe:</strong> $".number_format($importe)."</li>
            </ul>
            <p>Saludos.</p>
        ";

        $mail->send();
        // echo "Correo enviado con éxito"; // si deseas mostrarlo
    } catch (Exception $e) {
        echo "No se pudo enviar el correo. Error: {$mail->ErrorInfo}";
    }
}
?>


<?php /*
$ruta="../";
// Función de cabecera
include($ruta.'functions/fun_inicio.php');
// Archivos para correos
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Capturar fecha y hora actuales
$f_captura = date("Y-m-d");
$h_captura = date("H:i:s");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Instanciar conexión a la base de datos
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
            admin.usuario_id as usuario_id_retira, 
            admin.nombre as nombrex,
            admin.pwd
        FROM
            admin
        WHERE
            admin.usuario = ?
            AND admin.funcion IN ('ADMINISTRADOR','SISTEMAS','RECEPCION')
            AND admin.usuario_id <> ?
            AND admin.empresa_id = ?";
			
	//echo $sql_access;
// Depuración: Verificar los valores recibidos
//var_dump($usernamex, $passwordx, $empresa_id);

			
    $resultado = $conexion->consulta($sql_access, [$usernamex, $usuario_id, $empresa_id]);

    if ($resultado['numFilas'] === 1) {
        $usuario_data = $resultado['resultado'][0];
        $usuario_id_retira = $usuario_data['usuario_id_retira'];
        $nombrex = $usuario_data['nombrex'];
        $hashed_pwd = $usuario_data['pwd'];

        // Verificar la contraseña hashada
        if (password_verify($passwordx, $hashed_pwd)) {
            // Insertar en retiros
            $insert_retiros = "
                INSERT IGNORE INTO retiros 
                (
                    usuario_id, 
                    f_captura, 
                    h_captura, 
                    importe, 
                    usuario_id_retira, 
                    empresa_id,
                    nombrex
                )
                VALUES 
                (?, ?, ?, ?, ?, ?, ?)";
            $conexion->consulta_simple($insert_retiros, [$usuario_id, $f_captura, $h_captura, $importe, $usuario_id_retira, $empresa_id, $nombrex]);

            // Insertar en abonos
            $insert_abonos = "
                INSERT IGNORE INTO abonos 
                (
                    usuario_id, 
                    f_captura, 
                    h_captura, 
                    importe, 
                    usuario_id_abona, 
                    empresa_id,
                    nombrex
                )
                VALUES 
                (?, ?, ?, ?, ?, ?, ?)";
            $conexion->consulta_simple($insert_abonos, [$usuario_id_retira, $f_captura, $h_captura, $importe, $usuario_id, $empresa_id, $_SESSION['nombre']]);

            // Actualizar saldos
            $update_retira = "UPDATE admin SET saldo = saldo + ? WHERE usuario_id = ?";
            $conexion->consulta_simple($update_retira, [$importe, $usuario_id_retira]);

            $update_recibe = "UPDATE admin SET saldo = saldo - ? WHERE usuario_id = ?";
            $conexion->consulta_simple($update_recibe, [$importe, $usuario_id]);

            echo "<h1 style='color: green'>Se retiró correctamente $".number_format($importe)." </h1>";

            // Enviar notificación por correo
            sendEmailNotification($usernamex, $nombrex, $importe, $_SESSION['usuario'], $_SESSION['nombre']);
        } else {
            echo "<h1 style='color: red'>Contraseña incorrecta</h1>
            <h3>No se aplicó ningún retiro</h3>";
        }
    } else {
        echo "<h1 style='color: red'>Usuario no autorizado o no encontrado</h1>
        <h3>No se aplicó ningún retiro</h3>";
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
        $mail->Port = 587; // Cambiado a 587 para TLS

        // Configuración de la codificación de caracteres
        $mail->CharSet = 'UTF-8';
		
        // Habilitar el depurado
        $mail->SMTPDebug = 0; // Cambia a 2 para un depurado más detallado
        $mail->Debugoutput = 'html';

        // Destinatario
		$mail->addAddress($usuario,$nombre); 
		$mail->addCC($usernamex,$nombrex);
		$mail->addCC('admin@neuromodulaciongdl.com', 'Georgina Ramirez');      
		$mail->addCC('sanzaleonardo@gmail.com', 'Leonardo Sanz');        


        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = 'Notificación de Retiro de Efectivo'.date('d-m-Y T H:i:s');
        $mail->Body = "
        Hola,<br><br>
        Se ha realizado un retiro de efectivo.<br><br>
        Retira: $nombrex<br>
        Entrega: $nombre<br>
        Fecha: ".date('d-m-Y T H:i:s')."
        Importe: $".number_format($importe)."<br><br>
        Saludos.";

        $mail->send();
        echo 'El mensaje ha sido enviado con éxito';
    } catch (Exception $e) {
        echo "No se pudo enviar el mensaje. Error de correo: {$mail->ErrorInfo}";
    }
}*/
?>


<?php /*
$ruta="../";
// funcion de cabecera
include($ruta.'functions/fun_inicio.php');
// archivos para correos
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$f_captura = date("Y-m-d");
$h_captura = date("H:i:s");

$sql_access = "
    SELECT
        admin.usuario_id as usuario_id_retira, 
        admin.nombre as nombrex
    FROM
        admin
    WHERE
        admin.usuario = '$usernamex'
        AND admin.pwd = '$passwordx'
        AND admin.funcion in('ADMINISTRADOR','SISTEMAS','RECEPCION')
        AND admin.usuario_id <> '$usuario_id'
        AND admin.empresa_id = $empresa_id";

$ejecuta_access = ejecutar($sql_access);
$row = mysqli_fetch_array($ejecuta_access);
$cnt = mysqli_num_rows($ejecuta_access);

if ($cnt >= 1) {
    extract($row);
    
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
            values
        ( 
            $usuario_id,
            '$f_captura',
            '$h_captura',
            $importe,
            $usuario_id_retira,
            $empresa_id,
            '$nombrex'
        )
    ";    
    $result_insert_retiros = ejecutar($insert_retiros);        

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
            values
        ( 
            $usuario_id_retira,
            '$f_captura',
            '$h_captura',
            $importe,
            $usuario_id,
            $empresa_id,
            '$nombre'
        )
    ";    
    $result_insert_abonos = ejecutar($insert_abonos);            

    $update_retira = "
        update admin
        set
        admin.saldo = (admin.saldo+$importe)
        where admin.usuario_id = $usuario_id_retira    
    ";
    $result_update_retira = ejecutar($update_retira);                

    $update_recibe = "
        update admin
        set
        admin.saldo = (admin.saldo-$importe)
        where admin.usuario_id = $usuario_id    
    ";
    $result_update_recibe = ejecutar($update_recibe);    
    
    echo "<h1 style='color: green'>Se retiro correctamente $".number_format($importe)." </h1>";

    // Enviar notificación por correo
    sendEmailNotification($usernamex, $nombrex, $importe, $usuario, $nombre);
} else {
    echo "<h1 style='color: red'>Contraseña Incorrecta o Usuario no autorizado</h1>
    <h3>No se aplico ningún retiro</h3>";
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
        $mail->Port = 587; // Cambiado a 587 para TLS

        // Configuración de la codificación de caracteres
        $mail->CharSet = 'UTF-8';
		
        // Habilitar el depurado
        $mail->SMTPDebug = 0; // Cambia a 2 para un depurado más detallado
        $mail->Debugoutput = 'html';

        // Destinatario
		$mail->addAddress($usuario,$nombre); 
		$mail->addCC($usernamex,$nombrex);
		$mail->addCC('admin@neuromodulaciongdl.com', 'Georgina Ramirez');      
		$mail->addCC('sanzaleonardo@gmail.com', 'Leonardo Sanz');        


        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = 'Notificación de Retiro de Efectivo'.date('d-m-Y T H:i:s');
        $mail->Body = "
        Hola,<br><br>
        Se ha realizado un retiro de efectivo.<br><br>
        Retira: $nombrex<br>
        Entrega: $nombre<br>
        Fecha: ".date('d-m-Y T H:i:s')."
        Importe: $".number_format($importe)."<br><br>
        Saludos.";

        $mail->send();
        echo 'El mensaje ha sido enviado con éxito';
    } catch (Exception $e) {
        echo "No se pudo enviar el mensaje. Error de correo: {$mail->ErrorInfo}";
    }
}*/
?>