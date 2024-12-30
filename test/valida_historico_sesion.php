<?php
// Iniciar la sesión del usuario
session_start();

// Configurar el nivel de reporte de errores (7 muestra errores y advertencias)
error_reporting(7);

// Establecer la codificación interna a UTF-8 para las funciones de conversión de cadenas
iconv_set_encoding('internal_encoding', 'utf-8');

// Enviar cabecera HTTP para especificar que el contenido es HTML con codificación UTF-8
header('Content-Type: text/html; charset=UTF-8');

// Establecer la zona horaria predeterminada
date_default_timezone_set('America/Monterrey');

// Configurar la localización en español para fechas y horas
setlocale(LC_TIME, 'es_ES.UTF-8');

// Guardar la hora actual en la sesión
$_SESSION['time'] = time();

// Definir la ruta base para acceder a otros archivos
$ruta = "../";


extract($_SESSION);
extract($_POST);
extract($_GET);
//print_r($_SESSION);

$hoy = date("Y-m-d");
$ahora = date("H:i:00"); 
$anio = date("Y");
$mes_ahora = date("m");
$mes = date("m");
$dia = date("N");
$semana = date("W");
$titulo ="ANALISIS";


ini_set('max_execution_time', 300); // 300 segundos (5 minutos)


include($ruta.'functions/funciones_mysql.php');
include($ruta.'functions/functions.php');
include($ruta.'functions/fotografia.php');
//include($ruta.'uso.php');
include($ruta.'paciente/calendario.php');

include($ruta.'paciente/fun_paciente.php');
//uso($usuario_id);
//'..'.
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <html lang="es">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title><?php echo $titulo; ?></title>
    
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>   
    <!-- <script src="<?php echo $ruta; ?>js/jquery-3.3.1.min.js"></script>  -->    
    <!-- Favicon-->
    <link rel="icon" href="<?php echo $ruta.$icono; ?>" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="<?php echo $ruta; ?>plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="<?php echo $ruta; ?>plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="<?php echo $ruta; ?>plugins/animate-css/animate.css" rel="stylesheet" />
<!-- *************Tronco comun ******************** -->  


<!-- *************Tronco comun ******************** --> 
    <!-- Custom Css -->
    <link href="<?php echo $ruta; ?>css/style.css" rel="stylesheet">

    <!-- AdminTMS Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="<?php echo $ruta; ?>css/themes/all-themes.css" rel="stylesheet" />


		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>

		   
</head>

<body style="background-color: #fff" >
<script src="../highcharts/js/highcharts.js"></script>
<script src="../highcharts/js/highcharts-more.js"></script>
<script src="../highcharts/js/modules/exporting.js"></script>

<?php

$sql = "SELECT paciente_id FROM pacientes where paciente_id > 75";
$result = ejecutar($sql);

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result)) {
        extract($row);
        echo "<hr>" . $paciente_id . "<br>";
        //sleep(1); // Espera 1 segundo en cada iteración
        $sql2 = "SELECT * FROM historico_sesion WHERE paciente_id = $paciente_id ORDER BY f_captura ASC, h_captura ASC";
        //echo $sql2 . "<br>";
        $result2 = ejecutar($sql2);

        if ($result2 && mysqli_num_rows($result2) > 0) {
            $cnt = 1;
            while ($row2 = mysqli_fetch_array($result2)) {
                extract($row2);
                $f_captura = formatearFechaCompleta($f_captura);
                echo $cnt . " - " . $f_captura . " " . $h_captura . " Sesión ". $sesion. "<br>";
                //sleep(1);
                if ($sesion == $cnt) {
                    echo "Sesión correcta<br>";
                } else {
                    //sleep(10);
                    $update = "UPDATE historico_sesion SET sesion = '$cnt' WHERE historico_id = $historico_id";
                    //echo $update . "<br>";
                    ejecutar($update);
                }

                $cnt++;
            }
        } else {
            echo "No se encontraron registros en historico_sesion para paciente_id: $paciente_id<br>";
        }
    }
} else {
    echo "No se encontraron pacientes.";
}
