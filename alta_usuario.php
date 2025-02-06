<?php
include('functions/funciones_mysql.php');
//session_start();
error_reporting(7);
iconv_set_encoding('internal_encoding', 'utf-8'); 
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Monterrey');
setlocale(LC_TIME, 'es_ES.UTF-8');
$_SESSION['time']=time();

	//Import PHPMailer classes into the global namespace
	//These must be at the top of your script, not inside a function
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

$ruta = "";
extract($_POST);
//print_r($_POST);
// echo "<hr>";
//extract($_SESSION);
// print_r($_SESSION);
// echo "<hr>";
//$aviso = stripslashes($_POST['aviso']); 


$sql = "SELECT
			* 
		FROM
			admin
		WHERE
			usuario ='$email'"; 
$result_insert = ejecutar($sql);
$cnt = mysqli_num_rows($result_insert);
$row = mysqli_fetch_array($result_insert);
extract($row);

//echo $cnt."<hr>";
// print_r($row1);

if ($cnt !== 0) { ?>
	
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Alta</title>
    <!-- Favicon-->
    <link rel="icon" href="<?php echo $ruta; ?>favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="<?php echo $ruta; ?>plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="<?php echo $ruta; ?>plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="<?php echo $ruta; ?>css/style.css" rel="stylesheet">
</head>

<!-- <body class="five-zero-zero"></body>-->
<body class="theme-<?php echo $body; ?>">	
    <div align="center" class="five-zero-zero-container">
        <div> <h1>Ya esta registrado anteriormente</h1></div>
        <div> <h2>Usuario registrado intente recuperar su contraseña</h2></div>
        <div align="center"> 
            <div style="width: 90% !important;" align="left" >
				<h2><?php echo $mensaje; ?></h2>
			        	
			        	Nombre: <?php echo $nombre; ?><br>
			        	Correo Electronico: <?php echo $email; ?><br>
			        	 
				<a href="inicio.html" class="btn bg-green btn-lg waves-effect">CONTINUAR</a>     	      	
	    	</div>        		
        </div>
    </div>

	            
    <!-- Jquery Core Js -->
    <script src="<?php echo $ruta; ?>plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="<?php echo $ruta; ?>plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/node-waves/waves.js"></script>
</body>

</html> 	

<?php	

}else{ 




$f_alta = date("Y-m-d");
$h_alta = date("H:i:s"); 
$insert1 ="
	INSERT IGNORE INTO admin 
		(
			nombre,
			usuario,
			pwd,
			acceso,
			funcion,
			saldo,
			observaciones,
			f_alta,
			h_alta ,
			estatus
		) 
	VALUE
		(
			'$namesurname',
			'$email',
			'$password',
			'$acceso',
			'MEDICO',
			'$saldo',
			'$observaciones',
			'$f_alta',
			'$h_alta',
			'Pendiente'
		) ";
      //echo $insert1."<br>";
$result_insert = ejecutar($insert1);
 //echo $result_insert."<Hr>";
 
$sql = "SELECT
			max(usuario_id)  as usuario_id 
		FROM
			admin"; 
$result_insert = ejecutar($sql);
$row1 = mysqli_fetch_array($result_insert);
extract($row1);
//echo "<hr>";

$insert1 ="
	INSERT IGNORE INTO herramientas_sistema 
		(
			usuario_id,
			body,
			notificaciones
		) 
	VALUE
		(
			'$usuario_id',
			'teal',
			'Si'
		) ";
    //  echo $insert1."<br>";
$result_insert = ejecutar($insert1);
// print_r($row1);



$destinatario = $email; 
$asunto = "Alta de Usuario"; 
$cuerpo = ' 
<html> 
<head> 
   <title>Concluye el proceso</title> 
</head> 
<body> 

<div> <h2>Se guardo correctamente la información dale en continuar para confirmar el correo</h2></div>
<div align="center"> 
	<div style="width: 90% ;!important;" align="left" >
    	<a class="btn btn-default" href="https://neuromodulaciongdl.com/confirmacion.php?us='.$usuario_id.'" role="button"><h1>Confirmar</h1></a><br>  	  
		   	      	
	</div> 
</div> 
</body> 
</html> 
'; 

$correo = $email;


	
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
    $mail->addAddress($destinatario, $nombre);     //Add a recipient
    //$mail->addAddress('ellen@example.com');               //Name is optional
    $mail->addReplyTo('no_responder@neuromodulaciongdl.com', 'Neuromodulacion Gdl');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');
	$mail->addBCC('sanzaleonardo@gmail.com');
    //Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $asunto;
    $mail->Body    = $cuerpo;
    $mail->AltBody = $cuerpo;

    $mail->send();
    echo '&nbsp;&nbsp;&nbsp;El mensaje se ha sido enviado';
} catch (Exception $e) {
    echo "No se pudo enviar el mensaje. Mailer Error: {$mail->ErrorInfo}";
}

// //para el envío en formato HTML 
// $headers = "MIME-Version: 1.0\r\n"; 
// $headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
// 
// //dirección del remitente 
// $headers .= "From: Neuromodulación Gdl <no_responder@neuromodulaciongdl.com>\r\n"; 
// 
// //dirección de respuesta, si queremos que sea distinta que la del remitente 
// $headers .= "Reply-To: no_responder@neuromodulaciongdl.com\r\n"; 
// 
// //ruta del mensaje desde origen a destino 
// $headers .= "Return-path: no_responder@neuromodulaciongdl.com\r\n"; 
// 
// //direcciones que recibián copia 
// $headers .= "Cc: sanzaleonardo@gmail.com\r\n"; 
// 
// //direcciones que recibirán copia oculta 
// $headers .= "Bcc: no_responder@neuromodulaciongdl.com\r\n"; 
// 
// 
// 
// $mail = mail($destinatario,$asunto,$cuerpo,$headers); 
// 
// if ($mail == 1) {
	// $mensaje = "<h1>Mensaje Enviado</h1>";
// } else {
	// $mensaje = "<h1>ERROR No Enviado</h1>";
// } 


?>            
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Guardado</title>
    <!-- Favicon-->
    <link rel="icon" href="<?php echo $ruta; ?>images/logo_aldana_tc.png" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="<?php echo $ruta; ?>plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="<?php echo $ruta; ?>plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="<?php echo $ruta; ?>css/style.css" rel="stylesheet">
</head>

<!-- <body class="five-zero-zero"></body>-->
<body class="theme-<?php echo $body; ?>">	
    <div align="center" class="five-zero-zero-container">
        <div> <h1>Exito</h1></div>
        <div> <h2>Se guardo el registro</h2>
        	</div>
        <div align="center"> 
			<h3>Favor de checar su correo para concluir con el proceso</h3>
			<?php echo $mensaje; ?>
			<a href="index.html" class="btn bg-green btn-lg waves-effect">CONTINUAR</a>        		
        </div>
    </div>

	            
    <!-- Jquery Core Js -->
    <script src="plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="plugins/node-waves/waves.js"></script>
</body>

</html>  

<?php } ?>