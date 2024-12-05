<?php
// Inicia una nueva sesión o reanuda la existente
session_start();

// Configura la notificación de errores para mostrar todos los errores
error_reporting(E_ALL);

// Establece el conjunto de caracteres predeterminado como UTF-8
ini_set('default_charset', 'UTF-8');

// Configura la cabecera HTTP para que el contenido se interprete como HTML con codificación UTF-8
header('Content-Type: text/html; charset=UTF-8');

// Establece la zona horaria predeterminada para la aplicación
// date_default_timezone_set('America/Monterrey'); // Opción comentada para Monterrey
date_default_timezone_set('America/Monterrey');

// Asegurar que se establezca la configuración regional para los nombres de mes y día
setlocale(LC_TIME, 'es_ES.UTF-8');  // Para sistemas Unix
if (stripos(PHP_OS, 'WIN') === 0) {
    setlocale(LC_TIME, 'Spanish_Spain.1252');  // Para sistemas Windows
}

// Duración de la sesión en segundos (90 minutos)
$session_duration = 90 * 60;

// Verifica si la sesión ha expirado
if (isset($_SESSION['start_time']) && (time() - $_SESSION['start_time']) > $session_duration) {
    // Si la sesión ha expirado, destruye la sesión y redirige al usuario a la página de cierre de sesión
    session_unset();
    session_destroy();
    header("Location: https://neuromodulaciongdl.com/cerrar_sesion.php");
    exit();
} else {
    // Si la sesión no ha expirado, actualiza el tiempo de inicio de la sesión
    $_SESSION['start_time'] = time();
}

// Obtiene el nombre del dominio del servidor
$dominio = $_SERVER['HTTP_HOST'];

// Extrae variables de sesión, POST y GET para su uso directo
extract($_SESSION);
extract($_POST);
extract($_GET);

// Definición de variables de fecha y hora actuales
$hoy = date("Y-m-d");  // Fecha actual en formato año-mes-día
$ahora = date("H:i:00"); // Hora actual en formato horas:minutos:segundos
$anio = date("Y");  // Año actual
$mes_ahora = date("m");  // Mes actual en formato numérico
$dia = date("N");  // Día de la semana (1 = Lunes, 7 = Domingo)
$semana = date("W");  // Número de la semana en el año

// Obtener el nombre completo del mes en español
$mes = obtenerMesActual($hoy);

function obtenerMesActual($fecha) {
    $formatter = new IntlDateFormatter(
        'es_ES',  // Configuración regional en español
        IntlDateFormatter::FULL,
        IntlDateFormatter::NONE,
        'UTC',  // Zona horaria
        IntlDateFormatter::GREGORIAN,
        'MMMM'  // Formato de mes completo
    );
    return ucfirst($formatter->format(strtotime($fecha))); // Capitalizar el primer carácter
}


// Obtiene la URL del script actual y la recorta para obtener la ruta relativa
$ubicacion_url = $_SERVER['PHP_SELF']; 
$ubicacion_url = $rest = substr($ubicacion_url, 1 , 100);

// Verifica si la sesión es válida, si no lo es, redirige al usuario a la página de inicio
if ($sesion != "On" || $sesion == "" || $_SESSION['usuario_id'] == '' || $empresa_id == '' || $_SESSION['body'] == '') {
    header("Location: https://neuromodulaciongdl.com/inicio.html"); 
}

// Incluye archivos PHP necesarios para la funcionalidad adicional
include($ruta.'functions/funciones_mysql.php');
include($ruta.'functions/conexion_mysqli.php');

// Incluir el archivo de configuración y obtener las credenciales
$configPath = $ruta.'../config.php';

if (!file_exists($configPath)) {
    die('Archivo de configuración no encontrado.');
}

$config = require $configPath;

// Crear una instancia de la clase Mysql
$mysql = new Mysql($config['servidor'], $config['usuario'], $config['contrasena'], $config['baseDatos']);

// Crear una instancia de la clase Mysql
$conexion = new Mysql($config['servidor'], $config['usuario'], $config['contrasena'], $config['baseDatos']);

// Función auxiliar para sanitizar valores y evitar pasar null a htmlspecialchars()
function sanitizarValor($valor) {
    return htmlspecialchars($valor ?? '', ENT_QUOTES, 'UTF-8');
}

include($ruta.'functions/fotografia.php');
include($ruta.'uso.php');

?>
<!DOCTYPE HTML>
<html>

<head>
    <!-- Establece la codificación de caracteres para el documento -->
    <meta charset="UTF-8">
    <!-- Establece el idioma del contenido -->
    <html lang="es">
    <!-- Indica a los navegadores usar la última versión de IE -->
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <!-- Configura la ventana gráfica para que se ajuste al ancho del dispositivo y deshabilita el zoom -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Título de la página, se extrae de una variable PHP -->
    <title><?php echo $titulo; ?></title>
    
    <!-- Incluye la librería jQuery desde un CDN -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>   
    <!-- <script src="<?php echo $ruta; ?>js/jquery-3.3.1.min.js"></script>  -->    
    
    <!-- Favicon de la página -->
    <link rel="icon" href="<?php echo $ruta.$icono; ?>" type="image/png">
    <!--<link rel="icon" href="<?php echo $ruta; ?>images/logo_aldana_tc.png" type="image/x-icon">-->

    <!-- Google Fonts para tipografía personalizada -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Estilos principales de Bootstrap -->
    <link href="<?php echo $ruta; ?>plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Estilos para el efecto de ondas en los botones -->
    <link href="<?php echo $ruta; ?>plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Estilos para animaciones CSS -->
    <link href="<?php echo $ruta; ?>plugins/animate-css/animate.css" rel="stylesheet" />
      
      
<!-- *************Tronco común ******************** -->  