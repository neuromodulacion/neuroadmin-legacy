<?php
// Incluir funciones de conexión a la base de datos
include('../functions/funciones_mysql.php');

// Iniciar sesión para acceder a las variables de sesión
session_start();

// Configuración para mostrar todos los errores
error_reporting(E_ALL);

// Configuración de la codificación interna y la cabecera de contenido
iconv_set_encoding('internal_encoding', 'utf-8'); 
header('Content-Type: text/html; charset=UTF-8');

// Configurar la zona horaria y el locale para fechas en español
date_default_timezone_set('America/Monterrey');
setlocale(LC_TIME, 'es_ES.UTF-8');

// Registrar el tiempo de la sesión actual
$_SESSION['time'] = time();

// Extraer variables de sesión en el ámbito actual
extract($_SESSION);

// Extraer variables de $_POST en el ámbito actual
extract($_POST);

// Validar y limpiar los campos de email y celular eliminando espacios en blanco
$usuario = validarSinEspacio($usuario);
$celular = validarSinEspacio($celular);

$ruta = "../"; // Ruta relativa para incluir archivos

// Usar el espacio de nombres de PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Función para generar una contraseña aleatoria
function generateRandomPassword($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ*-+?%$#';
    $password = '';

    for ($i = 0; $i < $length; $i++) {
        // Generar un índice aleatorio y concatenar el carácter a la contraseña
        $randomIndex = rand(0, strlen($characters) - 1);
        $password .= $characters[$randomIndex];
    }

    return $password;
}

$f_captura = date("Y-m-d"); // Fecha actual
$h_captura = date("H:i:s"); // Hora actual
$mes = substr($mes_ano, 5, 2); // Obtener el mes de una cadena de formato "YYYY-MM"
$ano = substr($mes_ano, 0, 4); // Obtener el año de una cadena de formato "YYYY-MM"

// Consulta para verificar si el usuario ya existe
$sql = "SELECT * FROM admin WHERE usuario ='$usuario'";
$result_insert = ejecutar($sql);
$cnt = mysqli_num_rows($result_insert); // Contar los resultados de la consulta

// Si el usuario ya está registrado, mostrar un mensaje
if ($cnt >= 1) {
    $row = mysqli_fetch_array($result_insert); // Obtener el registro existente
    extract($row); // Extraer variables del registro existente
    ?>

    <!-- HTML para mostrar un mensaje de usuario registrado -->
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <title>Guardado</title>
        <link rel="icon" href="../../favicon.ico" type="image/x-icon">
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
        <link href="../plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
        <link href="../plugins/node-waves/waves.css" rel="stylesheet" />
        <link href="../css/style.css" rel="stylesheet">
    </head>

    <body class="theme-<?php echo $body; ?>">    
        <div style="padding-top: 30px" class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div align="center" style="padding: 20px;" class="five-zero-zero-container card">
                    <h1>Ya capturado anteriormente</h1>
                    <h2>Usuario registrado</h2>
                    <div align="center"> 
                        <div style="width: 90% !important;" align="left">
                            <h2><?php echo $mensaje; ?></h2>
                            Registro: <?php echo $usuario_id; ?><br>
                            Nombre: <?php echo $nombre; ?><br>
                            Correo Electrónico: <?php echo $usuario; ?><br>
                            Teléfono: <?php echo $celular; ?><br><br>               
                            <a href="<?php echo $ruta; ?>menu.php" class="btn bg-green btn-lg waves-effect">CONTINUAR</a>                
                        </div>                
                    </div>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>            

        <script src="../../plugins/jquery/jquery.min.js"></script>
        <script src="../../plugins/bootstrap/js/bootstrap.js"></script>
        <script src="../../plugins/node-waves/waves.js"></script>
    </body>
     
    </html>          

<?php    
} else { 
    // Si el usuario no está registrado, generar una nueva contraseña y registrar al usuario

    $pwd = generateRandomPassword(12); // Generar una contraseña aleatoria

    $f_alta = date("Y-m-d"); // Fecha de alta
    $h_alta = date("H:i:s"); // Hora de alta

    // Insertar nuevo registro en la tabla "admin"
    $insert1 = "
    INSERT IGNORE INTO admin 
        (nombre, usuario, pwd, acceso, funcion, telefono, saldo, observaciones, f_alta, h_alta, estatus, empresa_id) 
    VALUES
        ('$nombre', '$usuario', '$pwd', '0', '$funcion', '$celular', '0', '$observaciones', '$f_alta', '$h_alta', 'Pendiente', $empresa_id)";
    //echo $insert1."<hr>"; // Mostrar consulta para depuración
    $result_insert = ejecutar($insert1);

    // Obtener el último ID de usuario registrado
    $sql = "SELECT max(usuario_id) as usuario_id FROM admin";
    $result_insert = ejecutar($sql);
    $row1 = mysqli_fetch_array($result_insert);
    extract($row1);

    // Insertar configuración del sistema en "herramientas_sistema" para el nuevo usuario
    $insert1 = "
    INSERT IGNORE INTO herramientas_sistema 
        (usuario_id, body, notificaciones) 
    VALUES
        ('$usuario_id', 'teal', 'Si')";
    //echo $insert1."<hr>";
    $result_insert = ejecutar($insert1);

    // Configuración del correo electrónico
    $destinatario = $usuario; 
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
            <b>Nombre:</b> '.$nombre.'<br>
            <b>Correo Electrónico y Usuario:</b> '.$usuario.'<br>
            <b>Celular:</b> '.$celular.'<br>
            <b>Contraseña Provisional:</b> '.$pwd.'<br>
            Atte. Neuromodulación Gdl <br>    
            <a class="btn btn-default" href="https://neuromodulaciongdl.com/confirmacion.php?us='.$usuario_id.'" role="button"><h1>Confirmar</h1></a><br>         
        </div> 
    </div> 
    </body> 
    </html>';

    // Enviar correo usando PHPMailer
    require $ruta.'vendor/autoload.php';
    $mail = new PHPMailer(true);
    $mail->CharSet = 'UTF-8';
    $mail->setLanguage('es', $ruta.'/optional/path/to/language/directory/');

    try {
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host       = 'mail.neuromodulaciongdl.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'no_responder@neuromodulaciongdl.com';
        $mail->Password   = 'S{K?v5%X,u,D';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        // Configuración de los destinatarios
        $mail->setFrom('no_responder@neuromodulaciongdl.com', 'Neuromodulacion Gdl');
        $mail->addAddress($usuario, $nombre);
        $mail->addReplyTo('no_responder@neuromodulaciongdl.com', 'Neuromodulacion Gdl');
        $mail->addBCC('sanzaleonardo@gmail.com');

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = $asunto;
        $mail->Body    = $cuerpo;
        $mail->AltBody = $cuerpo;

        $mail->send();
        $mensaje = '<h4>&nbsp;&nbsp;&nbsp;El mensaje ha sido enviado con éxito</h4>';
    } catch (Exception $e) {
        $mensaje = "No se pudo enviar el mensaje. Mailer Error: {$mail->ErrorInfo}";
    }
?>

<!-- HTML para mostrar el mensaje de éxito de registro -->
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Guardado</title>
    <!-- Favicon-->
    <link rel="icon" href="../../favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="../plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="../plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="../css/style.css" rel="stylesheet">
</head>

<body class="theme-<?php echo $body; ?>">    
    <div style="padding-top: 30px" class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <div align="center" style="padding: 20px;" class="five-zero-zero-container card">
                <!-- Mensaje de confirmación de éxito -->
                <div><h1>Exito</h1></div>
                <div><h2>Se guardo correctamente la información</h2></div>
                <div align="center"> 
                    <div style="width: 90% !important;" align="left">
                        <h2><?php echo $mensaje; ?></h2>
                        <!-- Mostrar información del usuario registrado -->
                        Registro: <?php echo $usuario_id; ?><br>
                        Nombre: <?php echo $nombre; ?><br>
                        Correo Electrónico: <?php echo $usuario; ?><br>
                        Teléfono: <?php echo $celular; ?><br><br>               
                        <!-- Botón para continuar al menú principal -->
                        <a href="<?php echo $ruta; ?>menu.php" class="btn bg-green btn-lg waves-effect">CONTINUAR</a>                
                    </div>                
                </div>
            </div>
        </div>
        <div class="col-md-4"></div>
    </div>            

    <!-- Jquery Core Js -->
    <script src="../../plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="../../plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="../../plugins/node-waves/waves.js"></script>
</body>
 
</html>          

<?php 
} // Fin del else que verifica si el usuario ya existe
?>
