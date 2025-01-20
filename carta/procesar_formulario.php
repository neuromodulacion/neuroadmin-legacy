<?php
session_start();
extract($_SESSION);
print_r($_POST);

error_reporting(7);
iconv_set_encoding('internal_encoding', 'utf-8'); 
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Monterrey');
setlocale(LC_TIME, 'es_ES.UTF-8');

// Establecer la ruta base para incluir archivos y recursos
$ruta = "../";

// Incluir el archivo de funciones MySQL necesarias para interactuar con la base de datos
include($ruta.'functions/funciones_mysql.php');

// Incluir la librería PHPMailer para el envío de correos electrónicos
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

/**
 * Función para enviar un correo electrónico con PHPMailer.
 * 
 * @param string $asunto El asunto del correo electrónico.
 * @param string $cuerpo_correo El cuerpo del correo electrónico en formato HTML.
 * @param string|null $adjunto La ruta al archivo adjunto (si existe).
 * @param string $email La dirección de correo electrónico del destinatario.
 * 
 * @return string Mensaje de éxito o error en el envío del correo.
 */
function correo_electronico_base($asunto, $cuerpo_correo, $adjunto, $email) {
    // Consulta para obtener datos del usuario remitente
    $sql = "
        SELECT
            admin.usuario_id, 
            admin.nombre, 
            admin.usuario, 
            admin.empresa_id
        FROM
            admin
        WHERE
            admin.usuario_id = 11"; 
            
    $result = ejecutar($sql);
    $row = mysqli_fetch_array($result);
    extract($row);

    // Configuración del correo electrónico
    $e_mail = "contacto@neuromodulacion.com.mx";
    $pwd = "1n%v&_*&FFc~";
    $puerto = 465;
    $host = "mail.neuromodulacion.com.mx";
    $emp_nombre = "Contacto";

    // Requiere PHPMailer (gestión de correos)
    require '../vendor/autoload.php';

    // Crear una instancia de PHPMailer
    $mail = new PHPMailer(true);
    $mail->CharSet = 'UTF-8';
    $mail->setLanguage('es', 'optional/path/to/language/directory/');

    try {
        // Configuración del servidor SMTP
        $mail->SMTPDebug = 0; // Cambia a 0 para desactivar el debug
        $mail->isSMTP();
        $mail->Host = $host;
        $mail->SMTPAuth = true;
        $mail->Username = $e_mail;
        $mail->Password = $pwd;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = $puerto;

        // Configuración de los destinatarios
        $mail->setFrom($e_mail, $emp_nombre);
        $mail->addAddress($email); // Destinatario principal
        $mail->addReplyTo($e_mail, $emp_nombre);
        $mail->addBCC('contacto@neuromodulacion.com.mx'); // Copia oculta
        $mail->addCC('sanzaleonardo@gmail.com'); // Copia visible

        // Adjuntar archivo si existe
        if ($adjunto && file_exists($adjunto)) {
            $mail->addAttachment($adjunto);
        }

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = $asunto;
        $mail->Body = $cuerpo_correo;
        $mail->AltBody = strip_tags($cuerpo_correo); // Texto alternativo para clientes que no soportan HTML

        // Enviar el correo
        $mail->send();
        $mensaje = '<h3>&nbsp;&nbsp;&nbsp;El archivo ha sido enviado con éxito al correo '.$email.'</h3>';
    } catch (Exception $e) {
        $mensaje = "No se pudo enviar el mensaje. Mailer Error: {$mail->ErrorInfo}";
    }

    return $mensaje;
}

// Verificar si la solicitud se hizo por método POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recibir y procesar los datos del formulario
    $nombre = $_POST['nombre'];
    $sexo = $_POST['sexo'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $padecimiento = $_POST['padecimiento'];
    $raza = $_POST['raza'];
    $sexo_perro = $_POST['sexo_perro'];
    $esterilizado = $_POST['esterilizado'];
    $nombre_mascota = $_POST['nombre_mascota'];
    $edad_perro = $_POST['edad_perro'];
	$email = $_POST['email'];

    // Insertar los datos en la base de datos
    $sql = "
		INSERT INTO registros_carta_perro 
			( 
				nombre, 
				sexo, 
				fecha_nacimiento, 
				padecimiento, 
				raza, 
				sexo_perro, 
				esterilizado, 
				nombre_mascota, 
				edad_perro, 
				email,
				empresa_id )
		VALUES
			(
				'$nombre',
				'$sexo',
				'$fecha_nacimiento',
				'$padecimiento',
				'$raza',
				'$sexo_perro',
				'$esterilizado',
				'$nombre_mascota',
				'$edad_perro',
				'$email',
				$empresa_id)";
	echo $sql."<hr>";
    if (ejecutar($sql)) {
        //echo "Registro guardado exitosamente.";
		echo 'hola<hr>';
        // Obtener el ID del último registro insertado
        $sql = "
			SELECT
				max(registros_carta_perro.id) as id
			FROM
				registros_carta_perro";
		$result_insert = ejecutar($sql);
		$row = mysqli_fetch_array($result_insert);
		extract($row);

		// Incluir archivos adicionales para manejar pacientes
		include('../paciente/calendario.php');
		include('../paciente/fun_paciente.php');

        // Función para reemplazar caracteres especiales en el texto
		function tildes($palabra) {
		    $encuentra = array('&','<','>','¢','£','¥','€','©','®','™','§','†','‡','¶','•','…','±','¹','²','³','½','¼','¾','µ','°','√','∞','Ω','Σ','μ','←','→','↑','↓','↔','↵','⇐','⇒');
		     $remplaza = array('&amp;','&lt','&gt','&cent','&pound','&yen','&euro','&copy','&reg','&trade','&sect','&dagger','&Dagger','&para','&bull','&hellip','&plusmn','&sup1','&sup2','&sup3','&frac12','&frac14','&frac34','&micro','&deg','&radic','&infin','&ohm','&sigma','&mu','&larr','&rarr','&uarr','&darr','&harr','&crarr','&lArr','&rArr');
		    $palabra = str_replace($encuentra, $remplaza, $palabra);
		    return $palabra;
		}

		// Obtener la fecha actual en formato largo
		$hoy = strftime("%e de %B del %Y");
		
        // Consultar los datos del registro insertado
		$sql = "
		SELECT
			registros_carta_perro.id,
			registros_carta_perro.nombre,
			registros_carta_perro.sexo,
			registros_carta_perro.fecha_nacimiento,
			registros_carta_perro.padecimiento,
			registros_carta_perro.raza,
			registros_carta_perro.sexo_perro,
			registros_carta_perro.esterilizado,
			registros_carta_perro.nombre_mascota,
			registros_carta_perro.edad_perro,
			registros_carta_perro.fecha_captura 
		FROM
			registros_carta_perro 
		WHERE
			registros_carta_perro.id = $id";
		$result_insert = ejecutar($sql);
		$row = mysqli_fetch_array($result_insert);
		extract($row);
		
		// Seleccionar una versión aleatoria del texto de la carta
		$version = rand(1, 6);
		
		// Calcular la edad en años según la fecha de nacimiento
		$anios = obtener_edad_segun_fecha($fecha_nacimiento);
		
        // Definir el tratamiento según el sexo y la edad
		switch ($sexo) {
			case 'Masculino':
				if ($anios <= 15) { $sexo = "el niño "; } 
				elseif ($anios >= 16 && $anios <= 21) { $sexo = "el joven ";} 
				elseif ($anios >= 22) { $sexo = "el Sr. ";}
				$nacimiento = " nacido el ".strftime("%e de %B del %Y",strtotime($fecha_nacimiento));
				break;
				
			case 'Femenino':
				if ($anios <= 15) { $sexo = "la niña "; } 
				elseif ($anios >= 16 && $anios <= 21) { $sexo = "la Srta. ";} 
				elseif ($anios >= 22) { $sexo = "la Sra. ";}
				$nacimiento = " nacida el ".strftime("%e de %B del %Y",strtotime($fecha_nacimiento));		
				break;
		}
		
        // Verificar si la mascota está esterilizada y definir el texto correspondiente
		if ($esterilizado == "Si") {
			if ($sexo_perro == "Macho") {
				$esterilizado = " que se encuentra esterilizado";
			} else {
				$esterilizado = " que se encuentra esterilizada";
			}
		} else {
			$esterilizado = "";
		} 
		
        // Descripción de la mascota
		$mascota = $nombre_mascota.$esterilizado." de ".$edad_perro." años";
		
        // Generar el contenido de la carta según la versión seleccionada
		switch ($version) {
		    case 1:
		        $resultado = "<b>A quien corresponda:</b><br><br>
		        <p>Por medio de la presente, certifico que $sexo $nombre,$nacimiento, se encuentra bajo mi tratamiento por una condición de discapacidad emocional denominada Trastorno de Angustia, la cual está reconocida en el Manual Diagnóstico y Estadístico de los Trastornos Mentales (DSM-5).</p><br>
		        <p>Es fundamental que la pasajera cuente con el acompañamiento de su mascota, un $raza de nombre $mascota, como animal de apoyo emocional, tanto durante el viaje como en las actividades que realice en su destino.</p><br>
		        <p>Agradezco de antemano la atención prestada a esta solicitud y me mantengo disponible para cualquier aclaración o duda adicional.</p>";
		        break;
		    
		    case 2:
		        $resultado = "<b>A quien corresponda:</b><br><br>
		        <p>Por la presente, hago constar que $sexo $nombre,$nacimiento, se encuentra bajo mi tratamiento debido a un Trastorno de Angustia, reconocido en el Manual Diagnóstico y Estadístico de los Trastornos Mentales (DSM-5).</p><br>
		        <p>La paciente requiere el apoyo y compañía de su mascota, un $raza llamado $mascota, como animal de apoyo emocional, durante el viaje y para las actividades en su lugar de destino.</p><br>
		        <p>Quedo agradecido por su atención a esta carta y me mantengo a disposición para cualquier aclaración que sea necesaria.</p>";
		        break;
		    
		    case 3:
		        $resultado = "<b>A quien corresponda:</b><br><br>
		        <p>Por medio de la presente, certifico que $sexo $nombre,$nacimiento, está recibiendo tratamiento bajo mi supervisión por una condición emocional denominada Trastorno de Angustia, reconocida en el DSM-5.</p><br>
		        <p>Es necesario que la paciente cuente con la compañía de su mascota, un $raza de nombre $mascota, como animal de apoyo emocional durante su viaje y en las actividades en su destino.</p><br>
		        <p>Agradezco la atención prestada a esta solicitud y quedo a su disposición para cualquier duda o aclaración que pueda surgir.</p>";
		        break;
		    
		    case 4:
		        $resultado = "<b>A quien corresponda:</b><br><br>
		        <p>Certifico mediante la presente que $sexo $nombre,$nacimiento, está bajo tratamiento médico por una discapacidad emocional conocida como Trastorno de Angustia, tal como se describe en el DSM-5.</p><br>
		        <p>La paciente necesita el apoyo y la compañía de su mascota, un $raza de nombre $mascota, como animal de apoyo emocional tanto durante el viaje como en las actividades en su destino.</p><br>
		        <p>Agradezco de antemano su atención a esta comunicación y quedo disponible para cualquier consulta o aclaración adicional.</p>";
		        break;
		    
		    case 5:
		        $resultado = "<b>A quien corresponda:</b><br><br>
		        <p>Por la presente, certifico que $sexo $nombre,$nacimiento, se encuentra bajo mi tratamiento debido a un Trastorno de Angustia, una discapacidad emocional reconocida en el Manual Diagnóstico y Estadístico de los Trastornos Mentales (DSM-5).</p><br>
		        <p>Es imprescindible que la pasajera cuente con la compañía de su mascota, un $raza llamado $mascota, como animal de apoyo emocional durante su viaje y en las actividades que realice en su destino.</p><br>
		        <p>Agradezco su atención a la presente y quedo a su disposición para cualquier aclaración o información adicional que sea requerida.</p>";
		        break;
		    
		    case 6:
		        $resultado = "<b>A quien corresponda:</b><br><br>
		        <p>Por la presente hago constar que actualmente estoy tratando a $sexo $nombre, $nacimiento, por una discapacidad emocional llamada Trastorno de Angustia, la cual es reconocida en el Manual de Diagnóstico y Estadística de los Trastornos Mentales (DSM 5).</p><br>
		        <p>La persona pasajera necesita apoyo emocional y acompañamiento por su mascota de raza $raza de nombre $mascota, como animal de apoyo emocional, durante el viaje y/o para actividades en su destino.</p><br>
		        <p>Agradecido por la atención brindada a la presente, y sin otro particular, quedo atento a cualquier duda o aclaración.</p>";
		        break;
		
		    default:
		        $resultado = "Versión no válida. Por favor, selecciona un valor entre 1 y 6.";
		        break;
		}
		
        // Preparar el contenido HTML para el PDF
		$cuerpo_pdf = "
		<html>
		<head>
		    <title></title>
			<meta charset='UTF-8'>
		</head>
		<body style='font-family: Arial, sans-serif;'>
			<div style='margin: 20px; padding: 20px;'>
			<table style='width: 100%' >
				<tr>
					<td align='center'  style='background: #fff; width: 50%'>
						<img style='width: auto; height: 180px;' src='../images/logo_psiquiatria.png' alt='grafica'>
					</td>		
					<td align='right' style='background: #fff; width: 50%; font-family: Times'>
							<p>Av. de los Arcos 876, Jardines del Bosque.<br>
							Guadalajara, Jalisco. CP. 44520<br>
							dr.alejandro.aldana@hotmail.com<br>
							3312613701</p><br>
							<b>$hoy</b>
							
					</td>
				</tr>
			</table>
			<table>
				<tr>
					<td colspan='2' style='padding: 8px; font-family: Times'>
						$resultado
					</td>
				</tr>
				<tr>
					<td align='center'  style='background: #fff; width: 60%; height: 550px;'>
						
					</td>
					<td align='left'  style='background: #fff; width: 40%; padding-top: 300px'>
						<img style='width: auto; height: 150px;' src='../images/firma.png' alt='grafica'>
					</td>				
				</tr>
				<tr>
					<td colspan='2' align='right' style='font-family: Times'>
						<p><b>DR JESÚS ALEJANDRO ALDANA LÓPEZ</b><br><br>
						Universidad de Guadalajara - Médico Cirujano y Partero 8465806; Especialista en Psiquiatría 14058107
						Universidad del Valle de México - Maestro en Educación con Orientación en Innovación y Tecnologías 13061936</p>
					</td>
				</tr>					
			</table>
			</div>
			<pagebreak />
			<div style='margin: 0; padding: 0;'>
				<img style='width: 100%; height: 140%;' src='../images/cedula_aldana.jpg' alt='grafica'>
			</div>			
		</body>
		";

        // Generar y guardar el PDF utilizando la librería mPDF
		require_once __DIR__ . '/../vendor/autoload.php';

		// Create an instance of the class:
		$mpdf = new \Mpdf\Mpdf([
		    'margin_top' => 0,
		    'margin_bottom' => 0,
		    'margin_left' => 0,
		    'margin_right' => 0
		]);		
		
		$mpdf->WriteHTML($cuerpo_pdf);
		$adjunto = 'Carta_Paciente_'.$id.'.pdf';
		$mpdf->Output($adjunto,'F');

        // Preparar y enviar el correo electrónico con el PDF adjunto
		$asunto = "Solicitud de Acompañamiento de Animal de Apoyo Emocional - $sexo $nombre";
		$cuerpo_correo = "
			Estimado/a $sexo $nombre:<br>
			<p>Espero que este mensaje le encuentre bien.</p>
			<p>Adjunto a este correo encontrará una carta que certifica que $sexo $nombre, $nacimiento, se encuentra bajo mi tratamiento debido a una condición de discapacidad emocional denominada Trastorno de Angustia, según lo estipulado en el Manual Diagnóstico y Estadístico de los Trastornos Mentales (DSM-5).</p>
			<p>En la carta se especifica la necesidad fundamental de que $sexo $nombre cuente con el acompañamiento de su mascota, $raza de nombre $mascota, como animal de apoyo emocional tanto durante su viaje como en las actividades que realizará en su destino.</p>
			<p>Agradezco de antemano la atención que pueda brindar a esta solicitud. Quedo a su disposición para cualquier aclaración o información adicional que pueda requerir.</p>
			<p>Atentamente</p>
			<p>DR JESÚS ALEJANDRO ALDANA LÓPEZ
			Universidad de Guadalajara - Médico Cirujano y Partero 8465806; Especialista en Psiquiatría 14058107
			Universidad del Valle de México - Maestro en Educación con Orientación en Innovación y Tecnologías 13061936</p>	
		";
?>
<?php		
		$resultado = correo_electronico_base($asunto, $cuerpo_correo, $adjunto, $email );	
		
        // Actualizar el estado de la invitación en la base de datos a "usado"
		$update = "
			UPDATE invitaciones
			SET 
				invitaciones.estatus ='usado'
			WHERE
				invitaciones.time = $time";
		$result_update = ejecutar($update);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formato para carta de perro apoyo emocional</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

 <body style="background: #ffffff;" >    <!--class="theme-teal" -->
    
	<nav style="background: #0096AA" class="navbar navbar-default">
	  <div class="container-fluid">
	    <!-- Brand and toggle get grouped for better mobile display -->
	    <div class="navbar-header">
	      <!-- <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
	        <span class="sr-only">Toggle navigation</span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button> -->
	      <a href="../index.html" style=" color: white" class="navbar-brand">Neuromodulaci&oacute;n Gdl</a>
	      <!-- <a style=" color: white" class="navbar-brand" href="#">Neuromodulacion Gdl</a> -->
	    </div>
	
	    <!-- Collect the nav links, forms, and other content for toggling -->
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	     
	    </div><!-- /.navbar-collapse -->
	  </div><!-- /.container-fluid -->
	</nav>	
	<hr>	
	<div class="container">
		<div style="padding: 30px; padding-top: 50px !important" class="jumbotron">
		  <h1><?php echo $resultado; ?></h1>
		  <p>Correo enviado exitosamente al destinatario con la certificación del perro de apoyo emocional.</p>
		  <p><a class="btn btn-success btn-lg" href="../index.html" role="button">Concluir</a></p>
		</div>		
	</div>
</body>
</html>	
	
<?php		
    } else {
        echo "Error al guardar el registro.";
    }
}
?>