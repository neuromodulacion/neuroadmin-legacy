<html>
<head>
<title>PHPMailer - SMTP advanced test with authentication</title>
</head>
<body>

<?php

require_once('../class.phpmailer.php');
//include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch

$mail->IsSMTP(); // telling the class to use SMTP

try {
  $mail->Host       = "mail.neuromodulaciongdl.com"; // SMTP server
  $mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
  $mail->SMTPAuth   = true;                  // enable SMTP authentication
  $mail->Host       = "mail.neuromodulaciongdl.com"; // sets the SMTP server
  $mail->Port       = 465; // 26;                    // set the SMTP port for the GMAIL server
  $mail->Username   = "no_responder@neuromodulaciongdl.com"; // SMTP account username
  $mail->Password   = "wSJ-yiwpGp*z";        // SMTP account password
  $mail->AddReplyTo('no_responder@neuromodulaciongdl.com', 'First Last');
  $mail->AddAddress('sanzaleonardo@gmail.com', 'John Doe');
  $mail->SetFrom('no_responder@neuromodulaciongdl.com', 'First Last');
  $mail->AddReplyTo('no_responder@neuromodulaciongdl.com', 'First Last');
  $mail->Subject = 'PHPMailer Test Subject via mail(), advanced';
  $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
  $mail->MsgHTML(file_get_contents('contents.html'));
  $mail->AddAttachment('images/phpmailer.gif');      // attachment
  $mail->AddAttachment('images/phpmailer_mini.gif'); // attachment
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
