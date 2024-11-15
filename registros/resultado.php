<?php
error_reporting(E_ALL); // Mostrar todos los errores
ini_set('display_errors', 1);
ini_set('default_charset', 'UTF-8'); // Establecer el conjunto de caracteres predeterminado

header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Mazatlan');
setlocale(LC_TIME, 'es_ES.UTF-8');

extract($_POST);
extract($_GET);

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;


include('../functions/funciones_mysql.php');

if (isset($id)) {
    $id = intval($id); // Sanitizar el ID recibido por GET o POST

    $sql ="
    SELECT
        participantes.id, 
        participantes.nombre_completo, 
        participantes.profesion, 
        participantes.celular, 
        participantes.correo, 
        participantes.fecha_registro, 
        participantes.estatus
    FROM
        participantes
    WHERE
        participantes.id = $id";

    // Ejecutar la consulta y manejar errores
    $result = ejecutar($sql);
    if (!$result) {
        die("Error en la consulta SQL: " . mysqli_error($mysqli));
    }

    $row = mysqli_fetch_array($result);
    if (!$row) {
        die("Error al obtener los datos del participante.");
    }

    extract($row);


    include('pdf_correo.php');

    // Configuración de correo electrónico
    $e_mail = "contacto@neuromodulacion.com.mx";
    $pwd = "1n%v&_*&FFc~";
    $puerto = 465;
    $host = "mail.neuromodulacion.com.mx";
    $emp_nombre = "Contacto";

    // Requiere PHPMailer
    $autoload_path = '../vendor/autoload.php';
    if (!file_exists($autoload_path)) {
        die("El archivo autoload.php no se encuentra. Asegúrate de haber ejecutado 'composer install'.");
    }
    require $autoload_path;


	
    // Crear una instancia de PHPMailer
    $mail = new PHPMailer(true);
    $mail->CharSet = 'UTF-8';
    //$mail->setLanguage('es', '../optional/path/to/language/directory/');

    try {
        // Configuración del servidor SMTP
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = $host;
        $mail->SMTPAuth = true;
        $mail->Username = $e_mail;
        $mail->Password = $pwd;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = $puerto;

        // Recipientes
        $mail->setFrom($e_mail, $emp_nombre);
        $mail->addAddress($correo, $nombre_completo);
        $mail->addReplyTo($e_mail, $emp_nombre);
        $mail->addBCC('contacto@neuromodulacion.com.mx');
        $mail->addCC('sanzaleonardo@gmail.com');
		$mail->addCC('dr.alejandro.aldana@gmail.com');


		// Evidence-based_guideline_tDCS_in_neurological_and_psychiatric_disorders_2020.pdf
		// Evidence-based guidelines_on_the_therapeutic_use_of_repetitive_transcranial_magnetic_stimulation_rTMS_An_update_2014–2018.pdf
        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = "Constancia de asistencia al seminario";
        $mail->Body = "<p>Estimado(a) Dr. $nombre_completo,</p>

 <p>Esperamos que este mensaje le encuentre bien. Queremos expresarle nuestro m&aacute;s sincero agradecimiento por su participaci&oacute;n en el &ldquo;Seminario Especializado en Neuromodulaci&oacute;n Cl&iacute;nica: Innovaci&oacute;n y Tecnolog&iacute;a en Salud Mental&rdquo; que se llev&oacute; a cabo el pasado [fecha del seminario]. Su presencia y contribuciones fueron fundamentales para el &eacute;xito del evento.</p>

<p>Como agradecimiento por su participaci&oacute;n, adjuntamos a este correo su constancia de asistencia al seminario. Adem&aacute;s, queremos poner a su disposici&oacute;n los siguientes recursos que pueden ser de gran utilidad en su pr&aacute;ctica cl&iacute;nica:</p>

<ul>
	<li>Presentaci&oacute;n Utilizada Durante el Seminario: Puede acceder a la presentaci&oacute;n completa en el siguiente enlace:
	<ul>
		<li>Presentaci&oacute;n&nbsp;<a href='https://neuromodulaciongdl.com/documentation/biblioteca/Seminario_de_Neuromodulacion.pdf'>[Enlace a la Presentaci&oacute;n]</a> .</li>
	</ul>
	</li>
	<li>Biblioteca de Neuromodulaci&oacute;n: Hemos creado una biblioteca virtual con art&iacute;culos, estudios y materiales educativos sobre neuromodulaci&oacute;n. Puede acceder a la biblioteca aqu&iacute;:
	<ul>
		<li>Biblioteca virtual.&nbsp;&nbsp;<a href='https://drive.google.com/drive/folders/1ktpagI7fus9EZ6C3Mcgd9abTg_xyZRI5'>[Enlace a la Biblioteca]</a></li>
	</ul>
	</li>
	<li>Gu&iacute;a de Pr&aacute;ctica Cl&iacute;nica Basada en Evidencia de rTMS y tDCS: Descargue la gu&iacute;a completa para la aplicaci&oacute;n cl&iacute;nica de rTMS y tDCS aqu&iacute;:
	<ul>
		<li>rTMS.&nbsp;&nbsp;<a href='https://neuromodulaciongdl.com/documentation/biblioteca/Evidence-based guidelines_on_the_therapeutic_use_of_repetitive_transcranial_magnetic_stimulation_rTMS_An_update_2014_2018.pdf'>[Enlace a rTMS]</a></li>
		<li>tDCS.&nbsp;&nbsp;<a href='https://neuromodulaciongdl.com/documentation/biblioteca/Evidence-based_guideline_tDCS_in_neurological_and_psychiatric_disorders_2020.pdf'>[Enlace a tDCS ]</a>.</li>
	</ul>
	</li>
</ul>

<p>Una vez m&aacute;s, le agradecemos su valiosa participaci&oacute;n y esperamos que los conocimientos adquiridos durante el seminario le sean de gran utilidad en su pr&aacute;ctica diaria. Quedamos a su disposici&oacute;n para cualquier consulta o asistencia adicional que pueda necesitar.</p>";

        $mail->AltBody = strip_tags($mail->Body);

        // Adjuntar archivo
        $mail->addAttachment('constancias/diploma_'.$id.'.pdf');

        // Enviar el correo
        $mail->send();
        $mensaje = '<h3>&nbsp;&nbsp;&nbsp;El mensaje ha sido enviado con éxito</h3>';
    } catch (Exception $e) {
        $mensaje = "No se pudo enviar el mensaje. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    $mensaje = "No se recibió un ID válido.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado de la Encuesta</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background: #0096AA;">
    <div class="container mt-5">
        <div align="center" class="card">
            <div class="card-body">
                <a href="index.php"><img style="width: 150px" src="../images/logo_aldana_t.png" class="mb-4" alt="logo-icon"></a>
                <h3 class="card-title">Neuromodulación Gdl</h3>
                <hr>
                <h2 class="card-title">Encuesta de Satisfacción del Seminario</h2>
                <p class="card-text"><h4><?php echo ($mensaje); ?></h4></p>
                <h4>Su constancia de asistencia será enviada a su correo electrónico</h4>
                <a href="https://neuromodulaciongdl.com/" class="btn btn-primary">Terminar</a>
            </div>
        </div>
    </div>
</body>
</html>
