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
    
    <!-- Light Gallery Plugin Css -->
    <link href="<?php echo $ruta; ?>plugins/light-gallery/css/lightgallery.css" rel="stylesheet">
      

<?php  
// Incluir la segunda parte del header que contiene la barra de navegación y el menú
include($ruta.'header2.php'); ?>

    <!-- Inicio del contenido principal de la página -->
<section class="content">
    <style>
      /* Estilo para las imágenes dentro de la galería */
      #aniimated-thumbnials img {
          max-width: 100%;
          max-height: 200px;
          object-fit: cover; /* Mantener la proporción de la imagen */
          display: block;
          margin: 0 auto; /* Centrar las imágenes */
      }
      
      /* Asegurar que los contenedores no se desborden */
      .thumbnail {
          height: 200px; /* Fija la altura del contenedor */
          overflow: hidden; /* Esconde las partes de la imagen que sobresalgan */
      }
    </style>	
    <div class="container-fluid">
        <!-- Image Gallery -->
        <div class="block-header">
            <h2>
                IMAGE GALLERY
                            </h2>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            GALLERY
                            <small>All pictures from your upload folder</small>
                        </h2>
                    </div>
					<div class="body">
                        <div id="aniimated-thumbnials" class="list-unstyled row clearfix">
                            <?php
								// Define the folder where the images are stored
								$folderPath = '../uploads/';
								// Get all image files from the folder
								$images = glob($folderPath . "*.{jpg,png,jpeg}", GLOB_BRACE);
								
								// Loop through the images and display them
								foreach ($images as $image) {
								    // Remove the "../" from the beginning of the image path
								    $cleanPath = str_replace('../', '', $image);
								
								    // Get the full URL of the image
								    $fullImagePath = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $cleanPath;
								
								    echo '
								    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
								        <a href="'.$fullImagePath.'" data-sub-html="'.$fullImagePath.'">
								            <img class="img-responsive thumbnail" src="'.$fullImagePath.'">
								        </a>
								    </div>
								    ';
								}
                            ?>
                        </div>
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

    <!-- Light Gallery Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/light-gallery/js/lightgallery-all.js"></script>

    <!-- Custom Js -->
    <script src="<?php echo $ruta; ?>js/pages/medias/image-gallery.js"></script>


<?php 
// Incluir la segunda parte del footer que finaliza la estructura del pie de página
include($ruta.'footer2.php'); 
?>
