<?php
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
}
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
}
?>