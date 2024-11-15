<?php include ("../funciones/funciones_mysql.php");
    include ("../funciones/funciones.php");     
    
    $conexion = conectar("dish_calidad"); 		
	$sql = "SELECT * FROM admin_gasolina WHERE id = 77; ";
	$result = ejecutar($sql,$conexion);
	$row = mysql_fetch_assoc($result);
	$usuario = $row["usuario"];
	$num_eco = $row["num_eco"];		
	$f_carga = $row["f_carga"];
	$f_captura = $row["f_captura"];
	$hr_captura = $row["hr_captura"];
	$estado = $row["estado"];
	$importe = $row["importe"];
	$kilometraje = $row["kilometraje"];
	$litros = $row["litros"];
	$latitud = $row["latitud"];
	$longitud = $row["longitud"];
	$ruta = $row["ruta"];		
	$foto1 = 'images/km_antes.jpg';	
	$foto2 = 'images/km_despues.jpg';
	$foto3 = 'images/ticket.jpg';
	

	/**
	* Simple example script using PHPMailer with exceptions enabled
	* @package phpmailer
	* @version $Id$
	*/
	
	require 'php_mailer/class.phpmailer.php';
	
	try {
		$mail = new PHPMailer(true); //New instance, with exceptions enabled
	
		$body= '
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  	<head>
    	<title>Reporte de Gasolina</title>
    	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  	</head>
	<body>
		<form>
			<fieldset>
				<legend>Datos de captura</legend>
				<p><label for="usuario">Usuario: </label>
				<input type="text" name="usuario" id="usuario" readonly="readonly" value='.$usuario.' /></p>
				<p><label for="f_captura">Fecha de Captura: </label>
				<input type="text" name="f_captura" id="f_captura" readonly="readonly" value='.$f_captura.' /></p>
				<p><label for="hr_captura">Hora de Captura: </label>
				<input type="text" name="hr_captura" id="hr_captura" readonly="readonly" value='.$hr_captura.' /></p>
			</fieldset>
			<fieldset>
				<legend>Datos de la carga</legend>
				<p><label for="f_carga">Fecha de la carga: </label>
				<input type="text" name="f_carga" id="f_carga" readonly="readonly" value='.$f_carga.' /></p>
				<p><label for="estado">Estado: </label>
				<input type="text" name="estado" id="estado" readonly="readonly" value='.$estado.' /></p>
				<p><label for="num_eco">Número económico: </label>
				<input type="text" name="num_eco" id="num_eco" readonly="readonly" value='.$num_eco.' /></p>
				<p><label for="importe">Importe: </label>
				<input type="text" name="importe" id="importe" readonly="readonly" value='.$importe.' /></p>
				<p><label for="kilometraje">Kilomentraje: </label>
				<input type="text" name="kilometraje" id="kilometraje" readonly="readonly" value='.$kilometraje.' /></p>
				<p><label for="litros">Litros: </label>
				<input type="text" name="litros" id="litros" readonly="readonly" value='.$litros.' /></p>
			</fieldset>
			<fieldset>
				<legend>Ubicación y evidencia</legend>				
				<img src="http://maps.googleapis.com/maps/api/staticmap?markers='.$latitud.','.$longitud.'&zoom=10&size=650x600&sensor=false">
			</fieldset>
		</form>
		<br /><br />
		<form action="#" method="post" enctype="multipart/form-data"> <!--valida_gasolina.php-->
			<fieldset>
				<legend>Corregir</legend>
				<input type="hidden" name="usuario" id="usuario" readonly="readonly" value='.$usuario.' />
				<input type="hidden" name="f_captura" id="f_captura" readonly="readonly" value='.$f_captura.' />
				<input type="hidden" name="hr_captura" id="hr_captura" readonly="readonly" value='.$hr_captura.' />
				<input type="hidden" name="f_carga" id="f_carga" readonly="readonly" value='.$f_carga.' />
				<input type="hidden" name="estado" id="estado" readonly="readonly" value='.$estado.' />
				<input type="hidden" name="num_eco" id="num_eco" readonly="readonly" value='.$num_eco.' />
				<input type="hidden" name="importe" id="importe" readonly="readonly" value='.$importe.' />
				<input type="hidden" name="kilometraje" id="kilometraje" readonly="readonly" value='.$kilometraje.' />
				<input type="hidden" name="litros" id="litros" readonly="readonly" value='.$litros.' />
				<p><label for="usr">Usuario: </label>
				<input type="text" name="usr" id="usr" value="" /></p>
				<p><label for="pwd">Contraseña: </label>
				<input type="password" name="pwd" id="pwd" value="" /></p>
				<input type="submit" value="Corregir" />
			</fieldset>
		</form>
		<br /><br />
		<form  action="#" method="post" enctype="multipart/form-data"> <!--liberar_gasolina.php-->
			<fieldset>
				<legend>Liberar</legend>
				<input type="hidden" name="usuario" id="usuario" readonly="readonly" value='.$usuario.' />
				<input type="hidden" name="f_captura" id="f_captura" readonly="readonly" value='.$f_captura.' />
				<input type="hidden" name="hr_captura" id="hr_captura" readonly="readonly" value='.$hr_captura.' />
				<input type="hidden" name="f_carga" id="f_carga" readonly="readonly" value='.$f_carga.' />
				<input type="hidden" name="estado" id="estado" readonly="readonly" value='.$estado.' />
				<input type="hidden" name="num_eco" id="num_eco" readonly="readonly" value='.$num_eco.' />
				<input type="hidden" name="importe" id="importe" readonly="readonly" value='.$importe.' />
				<input type="hidden" name="kilometraje" id="kilometraje" readonly="readonly" value='.$kilometraje.' />
				<input type="hidden" name="litros" id="litros" readonly="readonly" value='.$litros.' />
				<p><label for="usr">Usuario: </label>
				<input type="text" name="usr" id="usr" value="" /></p>
				<p><label for="pwd">Contraseña: </label>
				<input type="password" name="pwd" id="pwd" value="" /></p>
				<input type="submit" value="Liberar" />
			</fieldset>
		</form>
	</body>
</html>';
	
		$mail->IsSMTP();                           // tell the class to use SMTP
		$mail->SMTPAuth   = true;                  // enable SMTP authentication
		$mail->Port       = 25;                    // set the SMTP server port
		$mail->Host       = "191.1.1.199"; // SMTP server
		$mail->Username   = "fueradenorma@dish.com.mx";     // SMTP server username
		$mail->Password   = "Dish1200";            // SMTP server password
	
		$mail->IsSendmail();  // tell the class to use Sendmail
	
		$mail->AddReplyTo("fueradenorma@dish.com.mx","Fuera de Norma");
	
		$mail->From       = "fueradenorma@dish.com.mx";
		$mail->FromName   = "Fuera de Norma";
		
		$xsql = "SELECT * FROM test;";
		$xresult = ejecutar($xsql,$conexion);
		
		while ($xrow = mysql_fetch_array ($xresult)) {
	  		$mail->Subject  = "Gasolina";	
	  		$mail->AltBody    = "¡Para ver el mensaje utilice un visor de correo electrponico compatible con HTML, por favor!"; // optional, comment out and test
	  		$mail->WordWrap   = 80; // set word wrap
		  	$mail->MsgHTML($body);
		  	$mail->AddAddress($xrow["correo"], $xrow["nombre"]);
		  	$mail->AddAttachment($foto1);
			$mail->AddAttachment($foto2);
			$mail->AddAttachment($foto3);
			$mail->IsHTML(true); // send as HTML
		  	if(!$mail->Send()) {
		    	echo "Mailer Error (" . str_replace("@", "&#64;", $xrow["correo"]) . ') ' . $mail->ErrorInfo . '<br>';
		  	} else {
		    	echo "Message sent to :" . $xrow["nombre"] . ' (' . str_replace("@", "&#64;", $xrow["correo"]) . ')<br>';
		  	}
		  	// Clear all addresses and attachments for next loop
		  	$mail->ClearAddresses();
		  	$mail->ClearAttachments();
		}
		echo 'Mensaje Enviado.';
	} catch (phpmailerException $e) {
		echo $e->errorMessage();
	} ?>