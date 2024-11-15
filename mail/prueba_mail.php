<html>
<head>
<title>PHPMailer - SMTP advanced test with authentication</title>
</head>
<body>

<?php

require_once('php_mailer/class.phpmailer.php');
//include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch

$mail->IsSMTP(); // telling the class to use SMTP

try {
    
// 
        $mail->Mailer="smtp";
        $mail->Helo = "www.dish.com.mx";
        $mail->SMTPAuth   = false;//true;
        //$mail->SMTPSecure = "tls";
        $mail->Port       = 25;//587;
        $mail->Host       = "191.1.55.44";//"smtp.office365.com";
        //$mail->Username   = "en_norma_calidad@dish.com.mx";
        //$mail->Password   = "Enn0rm4*";
        $mail->IsSMTP();
        $mail->AddReplyTo("santiago.sanz@dish.com.mx; luis.ibarra@dish.com.mx");
        $mail->From       = "fueradenorma@dish.com.mx";
        $mail->FromName   = "Aseguramiento Especial";   
    
  // $mail->Host       = "smtp.office365.com"; // SMTP server
  // $mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
  // $mail->SMTPAuth   = true;                  // enable SMTP authentication
  // $mail->Host       = "smtp.office365.com"; // sets the SMTP server
  // $mail->Port       = 587;//25;//                    // set the SMTP port for the GMAIL server
  // $mail->Username   = "fueradenorma@dish.com.mx"; // SMTP account username
  // $mail->Password   = "Fu3r4N0r!";        // SMTP account password
  
  
  $mail->AddReplyTo('fueradenorma@dish.com.mx', 'First Last');
  $mail->AddAddress('santiago.sanz@dish.com.mx', 'John Doe');
  $mail->AddAddress('sanzaleonardo@gmail.com', 'John Doe');
  $mail->AddAddress('sanzaleonardo@hotmail.com', 'John Doe');
  $mail->AddAddress('sanzaleonardo@yahoo.com.mx.com', 'John Doe');
  $mail->SetFrom('fueradenorma@dish.com.mx', 'First Last');
  $mail->AddReplyTo('fueradenorma@dish.com.mx', 'First Last');
  $mail->Subject = 'Fuera de Norma Cliente 14657052 Empresa 1343 Cuadrilla 14269';
  $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
  $mail->MsgHTML('test');//$mail->MsgHTML(file_get_contents('contents.html'));
  $mail->AddAttachment('../prueba/BASE ROJO GOMEZ_2013-09-30.pdf');      // attachment
//  $mail->AddAttachment('images/phpmailer_mini.gif'); // attachment
  $mail->Send();
  echo "Message Sent OK</p>\n";
} catch (phpmailerException $e) {
  echo $e->errorMessage(); //Pretty error messages from PHPMailer
} catch (Exception $e) {
  echo $e->getMessage(); //Boring error messages from anything else!
}
?>

</body>
</html>
