<?php
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