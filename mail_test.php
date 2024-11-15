<?php
include('functions/funciones_mysql.php');
session_start();
error_reporting(7);
iconv_set_encoding('internal_encoding', 'utf-8'); 
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Monterrey');
setlocale(LC_TIME, 'es_ES.UTF-8');
$_SESSION['time']=mktime();

$ruta = "";
extract($_POST);
//print_r($_POST);
// echo "<hr>";
extract($_SESSION);
$cuerpo_correo = "Pueba";
$correo = "sanzaleonardo@gmail.com";

	//Import PHPMailer classes into the global namespace
	//These must be at the top of your script, not inside a function
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;
	
	//Load Composer's autoloader
	require 'vendor/autoload.php';
	
	//Create an instance; passing `true` enables exceptions
	$mail = new PHPMailer(true);
    //$mail->setLanguage('es', '/optional/path/to/language/directory/');
	//To load the French version
	$mail->setLanguage('es', '/optional/path/to/language/directory/');

try {
    //Server settings
    $mail->SMTPDebug = 0; //SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'mail.neuromodulaciongdl.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'no_responder@neuromodulaciongdl.com';                     //SMTP username
    $mail->Password   = 'S{K?v5%X,u,D';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('no_responder@neuromodulaciongdl.com', 'Neuromodulacion Gdl');
    $mail->addAddress('sanzaleonardo@gmail.com', 'Joe User');     //Add a recipient
    //$mail->addAddress('ellen@example.com');               //Name is optional
    $mail->addReplyTo('sanzaleonardo@hotmail.com', 'Information');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    //Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Aqui esta el tema';
    $mail->Body    = 'Este es el cuerpo del mensaje HTML <b>in bold!</b>';
    $mail->AltBody = 'Este es el cuerpo en texto sin formato para clientes de correo que no son HTML';

    $mail->send();
    echo '<h1>El mensaje ha sido enviado</h1>';
} catch (Exception $e) {
    echo "No se pudo enviar el mensaje. Mailer Error: {$mail->ErrorInfo}";
}
