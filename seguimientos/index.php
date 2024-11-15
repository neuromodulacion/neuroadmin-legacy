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
//print_r($_SESSION);
$hoy = date("Y-m-d");
$ahora = date("H:i:00"); 
$anio = date("Y");
$mes_ahora = date("m");
$titulo ="Solicitudes";
include($ruta.'header1.php');
?>
    <link href="<?php echo $ruta; ?>plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
    
     <!-- Bootstrap Material Datetime Picker Css -->
    <link href="<?php echo $ruta; ?>plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />

    <!-- Bootstrap DatePicker Css -->
    <link href="<?php echo $ruta; ?>plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />

    <!-- Wait Me Css -->
    <link href="<?php echo $ruta; ?>plugins/waitme/waitMe.css" rel="stylesheet" />

    <!-- Bootstrap  Css -->
    <link href="<?php echo $ruta; ?>plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />   
<?php
include($ruta.'header2.php'); 
//print_r($_SESSION);
?>

    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>SISTEMAS</h2>
                <!-- <?php echo $ubicacion_url; 
                echo "<br> $ruta.'/proyecto_medico/menu.php'"?> -->
            </div>
<!-- // ************** Contenido ************** // -->
            <!-- CKEditor -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div style="height: 80%"  class="header">
                        	<h1 align="center">Solicitud de Sistemas</h1>                        	                 	
						    <div class="body">
						        <h2>Enviar Solicitud</h2>
						        <form action="guardar_solicitud.php" method="post">
						            <div class="form-line">
						                <label for="titulo">Título</label>
						                <input type="text" class="form-control" id="titulo" name="titulo" required>
						            </div>
					            
						            <div class="form-line">
						                <label for="descripcion">Descripción</label>
						                <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
						            </div>
						            <div class="form-line">
						                <label for="tipo">Tipo</label>
						                <select class="form-control" id="tipo" name="tipo">
						                    <option value="Mejora">Mejora</option>
						                    <option value="Falla">Falla</option>
						                </select>
						            </div>
						            <div class="form-line">
						                <label for="prioridad">Prioridad</label>
						                <select class="form-control" id="prioridad" name="prioridad">
						                    <option value="Baja">Baja</option>
						                    <option value="Media">Media</option>
						                    <option value="Alta">Alta</option>
						                </select>
						            </div>
						            <hr>
						            <button type="submit" class="btn btn-primary">Enviar</button>
						        </form>
						    </div>                        	                       	
                    	</div>
                	</div>
            	</div>
        	</div>           
        </div>
    </section>
<?php	include($ruta.'footer1.php');	?>

    <!-- Moment Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/momentjs/moment.js"></script>

    <!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

    <!-- Bootstrap Datepicker Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

    <!-- Waves Effect Plugin Js -->
    <!-- Autosize Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/autosize/autosize.js"></script>

    <!-- Moment Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/momentjs/moment.js"></script>

<?php	include($ruta.'footer2.php');	?>