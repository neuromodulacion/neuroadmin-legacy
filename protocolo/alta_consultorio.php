<?php
session_start();

// Establecer el nivel de notificación de errores
error_reporting(E_ALL); // Reemplaza `7` por `E_ALL` para usar la constante más clara y recomendada

// Establecer la codificación interna a UTF-8 (ya no se utiliza `iconv_set_encoding`, sino `ini_set`)
ini_set('default_charset', 'UTF-8');

// Configurar la cabecera HTTP con codificación UTF-8
header('Content-Type: text/html; charset=UTF-8');

// Configurar la zona horaria
date_default_timezone_set('America/Monterrey');

// Configurar la localización para manejar fechas y horas en español
setlocale(LC_TIME, 'es_ES.UTF-8');

// Asignar el tiempo actual a la sesión en formato de timestamp
$_SESSION['time'] = time(); // `time()` es el equivalente moderno a `mktime()`


$ruta="../";
$title = 'INICIO';

extract($_SESSION);
//print_r($_SESSION);
$hoy = date("Y-m-d");
$ahora = date("H:i:00"); 
$anio = date("Y");
$mes_ahora = date("m");
$titulo ="Alta Consultorios";
include($ruta.'header.php'); ?>

    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>ALTA DE CONSULTORIOS</h2>
                <?php echo $ubicacion_url."<br>"; 
                //echo $ruta."proyecto_medico/menu.php"?>
            </div>
<!-- // ************** Contenido ************** // -->
            <!-- CKEditor -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div style="height: 95%"  class="header">
                        	<h1 align="center">Alta de Consultorios</h1>
        	                <!-- <div align="center" class="image">
			                    <img  src= "<?php echo $ruta.'images/menu.jpg'; ?>" style="max-width:100%;width:auto;height:auto;" />
			                </div> -->
                    	</div>
                	</div>
            	</div>
        	</div>
              

        </div>
    </section>
<?php	include($ruta.'footer.php');	?>