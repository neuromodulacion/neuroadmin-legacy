<?php
include ("../funciones/funciones_mysql.php");
    include ("../funciones/funciones.php");     
	
//require("class.phpmailer.php");
require 'php_mailer/class.phpmailer.php';


$mail = new PHPMailer();


		$mail->IsSMTP();                           // tell the class to use SMTP
		$mail->SMTPAuth   = true;                  // enable SMTP authentication
		$mail->Port       = 25;                    // set the SMTP server port
		$mail->Host       = "191.1.1.199"; // SMTP server
		$mail->Username   = "fueradenorma@dish.com.mx";     // SMTP server username
		$mail->Password   = "Dish1200";            // SMTP server password
	
		$mail->IsSendmail();  // tell the class to use Sendmail
	
		$mail->AddReplyTo("fueradenorma@dish.com.mx","Fuera de Norma");
	
		$mail->From       = "fueradenorma@dish.com.mx";
		$mail->FromName   = "Carga de Gasolina";
		$mail->AddAddress("sanzaleonardo@gmail.com");
$mail->IsHTML(true);

$mail->Subject  = "Carga de gasolina del 11/08/2013";
$mail->Body     = 
"<body>
<B>Carga de gasolina</B><BR>
.
<TABLE BORDER='0'>
	<TR><TD>Numero economico   	</TD><TD>3309</TD></TR>
	<TR><TD>Kilometraje</TD><TD>33200 km</TD></TR>
	<TR><TD>Km recorridos</TD><TD>400 km</TD></TR>
	<TR><TD>Litros</TD><TD>40 lts</TD></TR>
	<TR><TD>Rendimiento</TD><TD>50 km por lts</TD></TR>
	<TR><TD>Fecha de carga</TD><TD>10/08/2013</TD></TR>
	<TR><TD>Fecha de captura</TD><TD>14/08/2013</TD></TR>
	</TABLE>
	</BODY>";



$mail->WordWrap = 50;

if(!$mail->Send()) {
  echo 'El mensaje no ha sido enviado.';
  echo 'Mailer error: ' . $mail->ErrorInfo;
} else {
  echo 'El mensaje ha sido enviado.';
}
?>