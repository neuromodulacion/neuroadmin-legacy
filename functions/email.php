<?php

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

function correo_electronico_invitacion($correo_pac,$asunto,$cuerpo_correo,$paciente,$empresa_id){


//correo_electronico($correo,$asunto,$cuerpo_correo,$nombre,$empresa_id)
//echo "$correo , $correo_pac , $pwd , $tipo_email , $puerto , $asunto , $cuerpo_correo , $host , $emp_nombre , $paciente , $empresa_id <hr>";
	//Import PHPMailer classes into the global namespace
	//These must be at the top of your script, not inside a function		
	//Load Composer's autoloader

$sql = "SELECT
	empresas.empresa_id, 
	empresas.emp_nombre, 
	empresas.web, 
	empresas.e_mail, 
	empresas.pdw, 
	empresas.tipo_email, 
	empresas.puerto, 
	empresas.`host` as e_host
FROM
	empresas
WHERE
	empresas.empresa_id = $empresa_id"; 
			
$result = ejecutar($sql);
//echo $sql."<hr>";
//echo "<hr>";
$row = mysqli_fetch_array($result);
extract($row);
//print_r($row);	

	
	if ($tipo_email == 'normal') {


			
	require '../vendor/autoload.php';			
			//Create an instance; passing `true` enables exceptions
			$mail = new PHPMailer(true);
		    //$mail->setLanguage('es', '/optional/path/to/language/directory/');
			//To load the French version
			// Configuración del mensaje
		    $mail->CharSet = 'UTF-8'; // Establecer la codificación de caracteres	
			$mail->setLanguage('es', '../optional/path/to/language/directory/');
		
		try {
		    //Server settings
		    $mail->SMTPDebug = 7; //SMTP::DEBUG_SERVER;                      //Enable verbose debug output
		    $mail->isSMTP();                                            //Send using SMTP
		    $mail->Host       = $e_host; //'mail.neuromodulacion.com.mx'; // 'mail.neuromodulaciongdl.com';  //  $e_host; //                 //Set the SMTP server to send through
		    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
		    $mail->Username   = $e_mail; //  'contacto@neuromodulacion.com.mx'; // 'no_responder@neuromodulaciongdl.com';                    //SMTP username
		    $mail->Password   = $pdw; // '1n%v&_*&FFc~'; // 'S{K?v5%X,u,D';                              //SMTP password
		    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
		    $mail->Port       = $puerto; //   465;                            //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
		    		
		    //Recipients
		    $mail->setFrom($e_mail, $emp_nombre);
		    $mail->addAddress($correo_pac, $paciente);     //Add a recipient
		    //$mail->addAddress('ellen@example.com');               //Name is optional
		    $mail->addReplyTo($e_mail, $emp_nombre);
		    //$mail->addCC('cc@example.com');
		    $mail->addBCC('sanzaleonardo@gmail.com');
		
		    //Attachments
		    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
		    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
		
		    //Content
		    $mail->isHTML(true);                                  //Set email format to HTML
		    $mail->Subject = $asunto;
		    $mail->Body    = $cuerpo_correo;
		    $mail->AltBody = $cuerpo_correo;
		
		    $mail->send();
		    $echo = '<h3>&nbsp;&nbsp;&nbsp;El mensaje ha sido enviado con éxito</h3>';
		} catch (Exception $e) {
		    $echo = "No se pudo enviar el mensaje. Mailer Error: {$mail->ErrorInfo}";
		}
	
		
	} else {

						
			$datos = array(
			    "correo" => $correo_pac,
			    "to" => $correo_pac,
			    "asunto" => $asunto,
			    "cuerpo_correo" => $cuerpo_correo,
			    "destinatario" => $paciente,
			    "emp_nombre" => $emp_nombre,
			    "con_copia" => 'sanzaleonardo@gmail.com',
				"web" => $web
			);
			
			
			// Para convertirlo a JSON
			//$jsonData = json_encode($datos, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
			//echo $jsonData."<hr>";
			$jsonData = json_encode($datos, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
			if ($jsonData === false) {
			    echo "Error al codificar JSON: " . json_last_error_msg();
			    exit; // O maneja este caso según sea necesario
			}
									
			
			
			// URL del webhook al que quieres enviar el JSON
			//$webhookUrl = 'https://hook.us1.make.com/ea7mg55ssyirdwy77na63z2m64xobwt2';
			$webhookUrl = 'https://hook.us1.make.com/hv9d2gykl8td76sglnm5yzby4jbnmf5e';
			// Inicializa cURL
			$ch = curl_init($webhookUrl);
			
			// Configura las opciones de cURL para la petición
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			    'Content-Type: application/json',
			    'Content-Length: ' . strlen($jsonData))
			);
			
			// Envía la petición y guarda la respuesta 
			$response = curl_exec($ch);
			
			// Cierra el recurso cURL
			curl_close($ch);
			
			// Opcional: Maneja la respuesta
			//echo $response."<hr>";
			//print_r($datos);
			if ($response == 'Accepted') {
				$echo = '<h3>&nbsp;&nbsp;&nbsp;El mensaje ha sido enviado con éxito '.$response.'</h3>';
			} else {
				$echo = "No se pudo enviar el mensaje $response";
			}
			

		}
	
   return $echo; 
} 		
 
function correo_electronico($correo_pac,$asunto,$cuerpo_correo,$paciente,$empresa_id,$accion){


//correo_electronico($correo,$asunto,$cuerpo_correo,$nombre,$empresa_id)
//echo "$correo , $correo_pac , $pwd , $tipo_email , $puerto , $asunto , $cuerpo_correo , $host , $emp_nombre , $paciente , $empresa_id <hr>";
	//Import PHPMailer classes into the global namespace
	//These must be at the top of your script, not inside a function		
	//Load Composer's autoloader

$sql = "SELECT
	empresas.empresa_id, 
	empresas.emp_nombre, 
	empresas.web, 
	empresas.e_mail, 
	empresas.pdw, 
	empresas.tipo_email, 
	empresas.puerto, 
	empresas.`host` as e_host
FROM
	empresas
WHERE
	empresas.empresa_id = $empresa_id"; 
			
$result = ejecutar($sql);
//echo $sql."<hr>";
echo "<hr>";
$row = mysqli_fetch_array($result);
extract($row);
// print_r($row);	
	
//echo "$e_mail , $correo_pac , $pdw , $tipo_email , $puerto , $asunto , $cuerpo_correo , $e_host , $emp_nombre , $paciente , $empresa_id <hr>";
	
// 		
// $e_mail = "contacto@neuromodulacion.com.mx";
// $pwd = "1n%v&_*&FFc~";
// $puerto = "465";
// $host = "mail.neuromodulacion.com.mx";
// $tipo_email = 'normal';	
// $emp_nombre = "Contacto";

	
	if ($tipo_email == 'normal') {


			
	require '../vendor/autoload.php';			
			//Create an instance; passing `true` enables exceptions
			$mail = new PHPMailer(true);
		    //$mail->setLanguage('es', '/optional/path/to/language/directory/');
			//To load the French version
			// Configuración del mensaje
		    $mail->CharSet = 'UTF-8'; // Establecer la codificación de caracteres	
			$mail->setLanguage('es', '../optional/path/to/language/directory/');
		
		try {
		    //Server settings
		    $mail->SMTPDebug = 0; // 7; //SMTP::DEBUG_SERVER;  //                    //Enable verbose debug output
		    $mail->isSMTP();                                            //Send using SMTP
		    $mail->Host       = $e_host; //'mail.neuromodulacion.com.mx'; // 'mail.neuromodulaciongdl.com';  //  $e_host; //                 //Set the SMTP server to send through
		    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
		    $mail->Username   = $e_mail; //  'contacto@neuromodulacion.com.mx'; // 'no_responder@neuromodulaciongdl.com';                    //SMTP username
		    $mail->Password   = $pdw; // '1n%v&_*&FFc~'; // 'S{K?v5%X,u,D';                              //SMTP password
		    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
		    $mail->Port       = $puerto; //   465;                            //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
		    		
		    //Recipients
		    $mail->setFrom($e_mail, $emp_nombre);
		    $mail->addAddress($correo_pac, $paciente);     //Add a recipient
		    //$mail->addAddress('ellen@example.com');               //Name is optional
		    $mail->addReplyTo($e_mail, $emp_nombre);
		    //$mail->addCC('cc@example.com');
		    $mail->addBCC('sanzaleonardo@gmail.com');
		
		    //Attachments
		    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
		    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
		
		    //Content
		    $mail->isHTML(true);                                  //Set email format to HTML
		    $mail->Subject = $asunto;
		    $mail->Body    = $cuerpo_correo;
		    $mail->AltBody = $cuerpo_correo;
		
		    $mail->send();
		    $echo = '<h3>&nbsp;&nbsp;&nbsp;El mensaje ha sido enviado con éxito</h3>';
		} catch (Exception $e) {
		    $echo = "No se pudo enviar el mensaje. Mailer Error: {$mail->ErrorInfo}";
		}
	
		
	} else {

						
			$datos = array(
			    "correo" => $correo_pac,
			    "to" => $correo_pac,
			    "asunto" => $asunto,
			    "cuerpo_correo" => $cuerpo_correo,
			    "destinatario" => $paciente,
			    "emp_nombre" => $emp_nombre,
			    "con_copia" => 'sanzaleonardo@gmail.com',
				"web" => $web,
				"accion" => $accion
			);
			
			
			// Para convertirlo a JSON
			//$jsonData = json_encode($datos, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
			//echo $datos."<hr>";
			//print_r($datos);
			$jsonData = json_encode($datos, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
			if ($jsonData === false) {
			    echo "Error al codificar JSON: " . json_last_error_msg();
			    exit; // O maneja este caso según sea necesario
			}
									
			
			
			// URL del webhook al que quieres enviar el JSON
			//$webhookUrl = 'https://hook.us1.make.com/ea7mg55ssyirdwy77na63z2m64xobwt2';
			$webhookUrl = 'https://hook.us1.make.com/udra1c1t87rmxh8vw4h12jfdxts65u8h';
			// Inicializa cURL
			$ch = curl_init($webhookUrl);
			
			// Configura las opciones de cURL para la petición
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			    'Content-Type: application/json',
			    'Content-Length: ' . strlen($jsonData))
			);
			
			// Envía la petición y guarda la respuesta 
			$response = curl_exec($ch);
			
			// Cierra el recurso cURL
			curl_close($ch);
			
			// Opcional: Maneja la respuesta
			//echo $response."<hr>";
			//print_r($datos);
			if ($response == 'Accepted') {
				$echo = '<h3>&nbsp;&nbsp;&nbsp;El mensaje ha sido enviado con éxito '.$response.'</h3>';
			} else {
				$echo = "No se pudo enviar el mensaje $response";
			}
			

		}
	//echo $echo."<hr>";
   return $echo; 
} 		
 
function correo_electronico_sitema($asunto,$cuerpo_correo,$usuario_id,$accion){


//correo_electronico($correo,$asunto,$cuerpo_correo,$nombre,$empresa_id)
//echo "$correo , $correo_pac , $pwd , $tipo_email , $puerto , $asunto , $cuerpo_correo , $host , $emp_nombre , $paciente , $empresa_id <hr>";
	//Import PHPMailer classes into the global namespace
	//These must be at the top of your script, not inside a function		
	//Load Composer's autoloader

$sql = "
	SELECT
		admin.usuario_id, 
		admin.nombre, 
		admin.usuario, 
		admin.empresa_id
	FROM
		admin
	WHERE
		admin.usuario_id = $usuario_id"; 
			
$result = ejecutar($sql);
// echo $sql."<hr>";
// echo "<hr>";
$row = mysqli_fetch_array($result);
extract($row);

   // Configuración de correo electrónico
    $e_mail = "contacto@neuromodulacion.com.mx";
    $pwd = "1n%v&_*&FFc~";
    $puerto = 465;
    $host = "mail.neuromodulacion.com.mx";
    $emp_nombre = "Contacto";

    // Requiere PHPMailer
    require '../vendor/autoload.php';

    //Crear una instancia de PHPMailer
    $mail = new PHPMailer(true);
    $mail->CharSet = 'UTF-8';
    $mail->setLanguage('es', '../optional/path/to/language/directory/');

    try {
        // Configuración del servidor SMTP
        $mail->SMTPDebug = 7; // Cambia a 0 para desactivar el debug
        $mail->isSMTP();
        $mail->Host = $host;
        $mail->SMTPAuth = true;
        $mail->Username = $e_mail;
        $mail->Password = $pwd;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = $puerto;

        // Recipientes
        $mail->setFrom($e_mail, $emp_nombre);
        $mail->addAddress($usuario, $nombre);
        $mail->addReplyTo($e_mail, $emp_nombre);
        $mail->addBCC('contacto@neuromodulacion.com.mx');
        $mail->addCC('sanzaleonardo@gmail.com');

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = $asunto;
        $mail->Body = $cuerpo_correo;
        $mail->AltBody = strip_tags($cuerpo_correo);

        // Enviar el correo
        $mail->send();
        echo '<h3>&nbsp;&nbsp;&nbsp;El mensaje ha sido enviado con éxito</h3>';
    } catch (Exception $e) {
        echo "No se pudo enviar el mensaje. Mailer Error: {$mail->ErrorInfo}";
    }

    return;
} 

// function correo_electronico_base($asunto,$cuerpo_correo,$usuario_id,$accion){
// 
// 
// $sql = "
	// SELECT
		// admin.usuario_id, 
		// admin.nombre, 
		// admin.usuario, 
		// admin.empresa_id
	// FROM
		// admin
	// WHERE
		// admin.usuario_id = $usuario_id"; 
// 			
// $result = ejecutar($sql);
// // echo $sql."<hr>";
// // echo "<hr>";
// $row = mysqli_fetch_array($result);
// extract($row);
// 
   // // Configuración de correo electrónico
    // $e_mail = "contacto@neuromodulacion.com.mx";
    // $pwd = "1n%v&_*&FFc~";
    // $puerto = 465;
    // $host = "mail.neuromodulacion.com.mx";
    // $emp_nombre = "Contacto";
// 
    // // Requiere PHPMailer
    // require 'vendor/autoload.php';
// 
    // //Crear una instancia de PHPMailer
    // $mail = new PHPMailer(true);
    // $mail->CharSet = 'UTF-8';
    // $mail->setLanguage('es', 'optional/path/to/language/directory/');
// 
    // try {
        // // Configuración del servidor SMTP
        // $mail->SMTPDebug = 0; // Cambia a 0 para desactivar el debug //7
        // $mail->isSMTP();
        // $mail->Host = $host;
        // $mail->SMTPAuth = true;
        // $mail->Username = $e_mail;
        // $mail->Password = $pwd;
        // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        // $mail->Port = $puerto;
// 
        // // Recipientes
        // $mail->setFrom($e_mail, $emp_nombre);
        // $mail->addAddress($usuario, $nombre);
        // $mail->addReplyTo($e_mail, $emp_nombre);
        // $mail->addBCC('contacto@neuromodulacion.com.mx');
        // $mail->addCC('sanzaleonardo@gmail.com');
// 
        // // Contenido del correo
        // $mail->isHTML(true);
        // $mail->Subject = $asunto;
        // $mail->Body = $cuerpo_correo;
        // $mail->AltBody = strip_tags($cuerpo_correo);
// 
        // // Enviar el correo
        // $mail->send();
        // $mensaje = '<h3>&nbsp;&nbsp;&nbsp;El mensaje ha sido enviado con éxito</h3>';
    // } catch (Exception $e) {
        // $mensaje = "No se pudo enviar el mensaje. Mailer Error: {$mail->ErrorInfo}";
    // }
// 
    // return $mensaje;
// } 


function correo_electronico_base($asunto, $cuerpo_correo, $usuario_id, $adjunto = null) {
    $sql = "
        SELECT
            admin.usuario_id, 
            admin.nombre, 
            admin.usuario, 
            admin.empresa_id
        FROM
            admin
        WHERE
            admin.usuario_id = $usuario_id"; 
            
    $result = ejecutar($sql);
    $row = mysqli_fetch_array($result);
    extract($row);

    // Configuración de correo electrónico
    $e_mail = "contacto@neuromodulacion.com.mx";
    $pwd = "1n%v&_*&FFc~";
    $puerto = 465;
    $host = "mail.neuromodulacion.com.mx";
    $emp_nombre = "Contacto";

    // Requiere PHPMailer
    require 'vendor/autoload.php';

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

        // Recipientes
        $mail->setFrom($e_mail, $emp_nombre);
        $mail->addAddress($usuario, $nombre);
        $mail->addReplyTo($e_mail, $emp_nombre);
        $mail->addBCC('contacto@neuromodulacion.com.mx');
        $mail->addCC('sanzaleonardo@gmail.com');

        // Adjuntar archivo si existe
        if ($adjunto && file_exists($adjunto)) {
            $mail->addAttachment($adjunto);
        }

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = $asunto;
        $mail->Body = $cuerpo_correo;
        $mail->AltBody = strip_tags($cuerpo_correo);

        // Enviar el correo
        $mail->send();
        $mensaje = '<h3>&nbsp;&nbsp;&nbsp;El mensaje ha sido enviado con éxito</h3>';
    } catch (Exception $e) {
        $mensaje = "No se pudo enviar el mensaje. Mailer Error: {$mail->ErrorInfo}";
    }

    return $mensaje;
}
