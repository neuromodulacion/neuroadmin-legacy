<?php

session_start();
error_reporting(7);
iconv_set_encoding('internal_encoding', 'utf-8'); 
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Monterrey');
setlocale(LC_TIME, 'es_ES.UTF-8');
$_SESSION['time']=mktime();

$ruta="../";
$title = 'INICIO';

extract($_SESSION);
extract($_POST);
extract($_GET);
//print_r($_SESSION);

$hoy = date("Y-m-d");
$ahora = date("H:i:00"); 
$anio = date("Y");
$mes_ahora = date("m");
$mes = strftime("%B");
$dia = date("N");
$semana = date("W");
$titulo ="Agenda";
$genera ="";



include($ruta.'header1.php');
include($ruta.'header2.php'); ?>
<style>
    #signature-pad {
        border: 2px solid #000000;
        
        max-width: 95%; /* Corrección aquí */
        min-width: 200px;
        height: 300px;
        box-sizing: border-box; /* Asegúrate de que el borde está incluido en el ancho */
    }
</style>


<section class="content">
    <div class="container-fluid">
        <!-- ... -->
        <div align="center" class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div style="height: 450px;" class="header">
                        <div align="center" class="container">          	
							<div class="row">
								<div class="col-md-6">
									<h3>Documento firmado</h3>
									<div class="row">
									  <div class="col-xs-12 col-md-6">
									    <a href="#" class="thumbnail">
									      <img src="https://neuromodulaciongdl.com/test/firmas/firma_01.png" alt="...">
									    </a>
									  </div>

									</div>
								</div>
							</div>                       	
					    </div>
						<hr>			                                           
                	</div>
            	</div>
        	</div>
    	</div>
    </div>   
</section>
<?php	
include($ruta.'footer1.php');
include($ruta.'footer2.php');	
?>                    	