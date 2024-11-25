<?php
include('../functions/funciones_mysql.php');
session_start();

// Establecer el nivel de notificación de errores
error_reporting(E_ALL); // Reemplaza `7` por `E_ALL` para usar la constante más clara y recomendada

// Establecer la codificación interna a UTF-8 (ya no se utiliza `iconv_set_encoding`, sino `ini_set`)
ini_set('default_charset', 'UTF-8');

// Configurar la cabecera HTTP con codificación UTF-8
header('Content-Type: text/html; charset=UTF-8');

// Configurar la zona horaria
date_default_timezone_set('America/Monterrey');

// Configurar la localización para manejar fechas y horas en español
setlocale(LC_TIME, 'es_ES.UTF-8');

// Asignar el tiempo actual a la sesión en formato de timestamp
$_SESSION['time'] = time(); // `time()` es el equivalente moderno a `mktime()`


$ruta = "../";
extract($_SESSION);
extract($_POST);
//print_r($_POST);
// echo "<hr>";

//print_r($_SESSION);
// echo "<hr>";
//$aviso = stripslashes($_POST['aviso']); 
$sql = "
SELECT
	pacientes.paciente_id, 
	CONCAT(pacientes.paciente,' ',pacientes.apaterno,' ',pacientes.amaterno) AS paciente, 
	pacientes.email, 
	agenda.agenda_id, 
	agenda.f_ini, 
	agenda.h_ini
FROM
	pacientes
	INNER JOIN
	agenda
	ON 
		pacientes.paciente_id = agenda.paciente_id
WHERE
	agenda.agenda_id = $agenda_id ";
	
$result_agenda = ejecutar($sql); 
$row_agenda = mysqli_fetch_array($result_agenda);
extract($row_agenda);


$f_ini = strftime("%A %e de %B del %Y",strtotime($f_ini));


$cuerpo_correo = "
Estimada/o $paciente:<br>
<br>
Se le confirma su cita para el d&iacute;a $f_ini a las $h_ini<br>
<br>
Atte: Neuromodulaci&oacute;n Gdl

";
$correo = $email;

	//Import PHPMailer classes into the global namespace
	//These must be at the top of your script, not inside a function
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;
	
	//Load Composer's autoloader
	require $ruta.'vendor/autoload.php';
	
	//Create an instance; passing `true` enables exceptions
	$mail = new PHPMailer(true);
    //$mail->setLanguage('es', '/optional/path/to/language/directory/');
	//To load the French version
// Configuración del mensaje
    $mail->CharSet = 'UTF-8'; // Establecer la codificación de caracteres	
	$mail->setLanguage('es', $ruta.'/optional/path/to/language/directory/');

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
    $mail->addAddress($correo, $paciente);     //Add a recipient
    //$mail->addAddress('ellen@example.com');               //Name is optional
    $mail->addReplyTo('no_responder@neuromodulaciongdl.com', 'Neuromodulacion Gdl');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    //Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Confirmación de cita';
    $mail->Body    = $cuerpo_correo;
    $mail->AltBody = $cuerpo_correo;;

    $mail->send();
    echo '<h3>&nbsp;&nbsp;&nbsp;El mensaje se ha sido enviado</h3>';
} catch (Exception $e) {
    echo "No se pudo enviar el mensaje. Mailer Error: {$mail->ErrorInfo}";
}
