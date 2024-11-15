<?php
// Definir la ruta base para las inclusiones de archivos
$ruta = "../";

// Obtener la fecha actual en formato "YYYY-MM-DD"
$hoy = date("Y-m-d");

// Obtener la hora actual en formato "HH:MM:00"
$ahora = date("H:i:00"); 

// Obtener el año actual
$anio = date("Y");

// Obtener el mes actual en formato numérico "MM"
$mes_ahora = date("m");

// Definir el título de la página
$titulo = "Menú TMS";

// Incluir la primera parte del header que contiene configuraciones iniciales
include($ruta.'header1.php');

// Incluir archivos CSS adicionales necesarios para el funcionamiento de la página
?>
    <!-- Estilos para la tabla de datos de JQuery DataTable -->
    <link href="<?php echo $ruta; ?>plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
    
    <!-- Estilos para el selector de fecha y hora con Bootstrap Material -->
    <link href="<?php echo $ruta; ?>plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />

    <!-- Estilos para el selector de fecha de Bootstrap -->
    <link href="<?php echo $ruta; ?>plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />

    <!-- Estilos para el plugin "Wait Me" que muestra un indicador de carga -->
    <link href="<?php echo $ruta; ?>plugins/waitme/waitMe.css" rel="stylesheet" />

    <!-- Estilos para el select de Bootstrap -->
    <link href="<?php echo $ruta; ?>plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />   

<?php  
// Incluir la segunda parte del header que contiene la barra de navegación y el menú
include($ruta.'header2.php'); ?>

    <!-- Inicio del contenido principal de la página -->
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>INICIO</h2>
            </div>
			<!-- Contenido principal de la página -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <!-- Encabezado de la tarjeta que muestra el nombre de la empresa -->
                        <div style="height: 95%" class="header">
                            <h1 class="mt-5">Carga de Kilometraje</h1>
                        </div>
                        <!-- Contenido de la página -->
                        <div class="body">
                            <!-- Formulario de carga de kilometraje -->
                            <form action="procesar_carga.php" method="post" enctype="multipart/form-data" class="mt-4">
                                <div class="form-group">
                                    <label for="foto">Selecciona la foto:</label>
                                    <input type="file" class="form-control-file" id="foto" name="foto" accept="image/*" required>
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">                         
	                                    <label for="kilometraje">Kilometraje:</label> 
	                                    <input type="number" class="form-control" id="kilometraje" name="kilometraje" step="any" required> 
	                                                                      	
                                    </div>
                                </div>                                
                                <button type="submit" class="btn btn-primary">Enviar</button>
                            </form>
                        </div>
                    	</div>
                	</div>
            	</div>
        	</div>
    </section>

<?php 
// Incluir la primera parte del footer que contiene scripts y configuraciones iniciales del pie de página
include($ruta.'footer1.php'); 
?>

    <!-- Scripts adicionales necesarios para la funcionalidad de la página -->

    <!-- Plugin Moment para manejar fechas y horas -->
    <script src="<?php echo $ruta; ?>plugins/momentjs/moment.js"></script>

    <!-- Plugin para el selector de fecha y hora con Bootstrap Material -->
    <script src="<?php echo $ruta; ?>plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

    <!-- Plugin para el selector de fecha de Bootstrap -->
    <script src="<?php echo $ruta; ?>plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

    <!-- Plugin para efecto de ondas en los botones -->
    <script src="<?php echo $ruta; ?>plugins/waves/waves.js"></script>

    <!-- Plugin Autosize para ajustar automáticamente el tamaño de los campos de texto -->
    <script src="<?php echo $ruta; ?>plugins/autosize/autosize.js"></script>

    <!-- Repetición del plugin Moment para garantizar su disponibilidad -->
    <script src="<?php echo $ruta; ?>plugins/momentjs/moment.js"></script>

<?php 
// Incluir la segunda parte del footer que finaliza la estructura del pie de página
include($ruta.'footer2.php'); 
?>
