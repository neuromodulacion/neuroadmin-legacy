<?php

session_start();
error_reporting(7);
iconv_set_encoding('internal_encoding', 'utf-8'); 
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Mazatlan');
setlocale(LC_TIME, 'es_ES.UTF-8');
$_SESSION['time']=mktime();
// 
		// require_once "../vendor/autoload.php";
		// use UAParser\Parser;

		
$ruta = "../";
extract($_POST);
//extract($_GET);
extract($_SESSION);
//print_r($_SESSION);

// Definimos las fechas y las imágenes correspondientes
$seminarios = [
    '21-09-2024' => 'seminario_21_sep_24.png',
    '12-10-2024' => 'seminario_12_oct_24.png',
    '09-11-2024' => 'seminario_09_nov_24.png',
    '14-12-2024' => 'seminario_14_dic_24.png',
];

// Obtenemos la fecha actual
$fecha_actual = date('d-m-Y');

// Función para obtener la fecha y la imagen del próximo seminario
function obtenerProximoSeminario($seminarios, $fecha_actual) {
    foreach ($seminarios as $fecha => $imagen) {
        if (strtotime($fecha_actual) <= strtotime($fecha)) {
            return ['fecha' => $fecha, 'imagen' => $imagen];
        }
    }
    // Si ya pasó la última fecha, volvemos a la primera del ciclo
    reset($seminarios);
    return ['fecha' => key($seminarios), 'imagen' => current($seminarios)];
}

$seminario_actual = obtenerProximoSeminario($seminarios, $fecha_actual);


include($ruta.'functions/funciones_mysql.php');

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
    <link rel="icon" href="../images/logo_aldana_tc.png" type="image/x-icon">

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
 

    <link href="<?php echo $ruta; ?>plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
    
     <!-- Bootstrap Material Datetime Picker Css -->
    <link href="<?php echo $ruta; ?>plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />

    <!-- Bootstrap DatePicker Css -->
    <link href="<?php echo $ruta; ?>plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />

    <!-- Wait Me Css -->
    <link href="<?php echo $ruta; ?>plugins/waitme/waitMe.css" rel="stylesheet" />

    <!-- Bootstrap  Css -->
    <link href="<?php echo $ruta; ?>plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />  
<!-- *************Tronco comun ******************** --> 
    <!-- Custom Css -->
    <link href="<?php echo $ruta; ?>css/style.css" rel="stylesheet">

    <!-- AdminTMS Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="<?php echo $ruta; ?>css/themes/all-themes.css" rel="stylesheet" />


    
</head>

 <body style="background: #0096AA;" >    <!--class="theme-teal" -->
    
	<nav style="background: #0096AA" class="navbar navbar-default">
	  <div class="container-fluid">
	    <!-- Brand and toggle get grouped for better mobile display -->
	    <div class="navbar-header">
	      <!-- <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
	        <span class="sr-only">Toggle navigation</span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button> -->
	      <a href="../index.html" style=" color: white" class="navbar-brand">Neuromodulaci&oacute;n Gdl</a>
	      <!-- <a style=" color: white" class="navbar-brand" href="#">Neuromodulacion Gdl</a> -->
	    </div>
	
	    <!-- Collect the nav links, forms, and other content for toggling -->
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	     
	    </div><!-- /.navbar-collapse -->
	  </div><!-- /.container-fluid -->
	</nav>
	
<hr>
<div align="center" class="row clearfix" style="padding: 5px; padding-top: 30px">
	<div class="card" style="padding: 20px padding-top: 30px">		
		<div class="row container">
  			<div class="col-md-1"></div>
  			<div style="text-align: left; padding-left: 10px" class="col-md-10">
	        	<div >
	        		<img style="width: 100%" src="<?php echo $seminario_actual['imagen']; ?>" alt="..." class="img-rounded">
	        	</div>
		        <div style="text-align: center" class="text-center mb-9">
		            <h1>¡10 Becas Disponibles para el <b>Seminario Especializado en Neuromodulación Clínica:</h1></b> 
		            <h2>Innovación y Tecnología en Salud Mental!</h2>
		            <p class="lead">Obtén una de las 10 becas completas disponibles para este curso presencial.</p>
		        </div>
		        <div >
		            <div>
		                <h3>Detalles del Seminario</h3>
		            </div>
		            <div >
		                <p><strong>Fecha:</strong> <?php echo ucfirst(strftime('%A %d de %B de %Y', strtotime($seminario_actual['fecha']))); ?></p>
		                <p><strong>Duración:</strong> 3 horas</p>
		                <p><strong>Modalidad:</strong> Presencial</p>
		                <h5>¿Qué aprenderás?</h5>
		                <ul>
		                    <li>Fundamentos de TMS y tDCS</li>
		                    <li>Protocolos clínicos y aplicaciones terapéuticas</li>
		                    <li>Casos prácticos y sesiones de práctica supervisada</li>
		                    <li>Actualización en investigaciones recientes y avances tecnológicos</li>
		                </ul>
		            </div>
		        </div>
		        <div >
		            <div >
		                <h3>Ponente Principal</h3>
		            </div>
		            <div >
		                <p><strong>Dr. Alejandro Aldana</strong></p>
		                <ul>
		                    <li>Médico y especialista en psiquiatría por la Universidad de Guadalajara (UDEG) y el Instituto Jalisciense de Salud Mental (SALME)</li>
		                    <li>Maestro en educación, innovación y tecnologías por la Universidad del Valle de México</li>
		                    <li>Profesor titular de la especialidad en psiquiatría por la UDEG con sede en el Instituto Jalisciense de Salud Mental</li>
		                    <li>Candidato a Investigador del Sistema Nacional de Investigación</li>
		                    <li>Galardonado del Reconocimiento Nacional a la Calidad en Salud 2023</li>
		                    <li>Miembro de la Sociedad Mexicana de Neuromodulación, Sociedad Mexicana de Neurología y Psiquiatría, Asociación Psiquiátrica Mexicana, y el Colegio de Psiquiatras de Jalisco</li>
		                </ul>
		            </div>
		        </div>
		        <div >
		            <div >
		                <h3>Requisitos para Aplicar</h3>
		            </div>
		            <div >
		                <ul>
		                    <li>Ser médico psiquiatra, neurologo, o afin a la salud mental Titulado.</li>
		                    <li>Estar en activo.</li>
		                </ul>
		            </div>
		        </div>		
			</div>
  			<div class="col-md-1"></div>
				
		<div class="container mt-5">
		    <h2>Registro de Participantes</h2>
		    <form action="procesar_registro.php" method="post">
		        <div class="form-group">
                    <div class="form-line">
		            	<label for="nombre_completo">Nombre Completo:</label>
		            	<input type="text" class="form-control" id="nombre_completo" name="nombre_completo" placeholder="Nombre Completo" required>
		        	</div>
		        </div>
		        <div class="form-group">
                    <div class="form-line">
		            	<label for="profesion">Profesión:</label>
		            	<input type="text" class="form-control" id="profesion" name="profesion" placeholder="Profesión"  required>
		        	</div>
		        </div>
		        <div class="form-group">
                    <div class="form-line">
		            	<label for="celular">Celular:</label>
		            	<input type="text" class="form-control" id="celular" name="celular" placeholder="Celular"  required>
		        	</div>
		        </div>
		        <div class="form-group">
                    <div class="form-line">
		            	<label for="correo">Correo Electrónico:</label>
		            	<input type="email" class="form-control" id="correo" name="correo" placeholder="Correo Electronico"  required>
		        	</div>
		        </div>
		        <input type="hidden" id="seminario" name="seminario" value="<?php echo $seminario_actual['fecha']; ?>"/>
		        <button type="submit" style="background: #0096AA; color: white"  class="btn  btn-lg m-l-15 waves-effect">Registrar</button>
		   <hr>
		    </form>
		</div>
	</div>
</div>
</div>
     <!-- FOOTER -->
     <footer style="color: white" data-stellar-background-ratio="5">
          <div class="container">
               <div class="row">

                    <div class="col-md-4 col-sm-4">
                         <div class="footer-thumb"> 
                              <h4 class="wow fadeInUp" data-wow-delay="0.4s">Informaci&oacute;n de Contacto</h4>
                              <p>"¡Solicita información tu consulta hoy mismo!"</p>

                              <div class="contact-info">
                                   <p><i class="fa fa-phone"></i><a style="color: white" target="_blank" href="https://api.whatsapp.com/send?phone=523334702176&text=Solicito informes de Neuromodulación Gdl">
          33 3470 2176</a></p>
                                   <p><i class="fa fa-envelope-o"></i> 
                                   	<a style="color: white" href="mailto:contacto@neuromodulaciongdl.com?subject=Solicito%20Informacion%20de%20Neuromodulacion&body=Favor%20de%20enviar%20Informacion">contacto@neuromodulaciongdl.com</a></p>                              
                              </div>
                         </div>
                    </div>

                    <div class="col-md-4 col-sm-4"> 
                         <div class="footer-thumb"> 
                              <h4 class="wow fadeInUp" data-wow-delay="0.4s">&Uacute;ltimas Noticias</h4>
                              <div class="latest-stories">
                                   <div class="stories-image">
                                        <a href="../news-tms.html"><img style=" width: 40px" src="../images/news-image.jpg" class="img-responsive" alt=""></a>
                                   </div>
                                   <div class="stories-info">
                                        <a style="color: white;" href="../news-tms.html"><h5>Estimulación Magnética Transcraneal</h5></a>
                                        <span>Agosto 04, 2023</span>
                                   </div>
                              </div>

                              <div class="latest-stories">
                                   <div class="stories-image">
                                        <a href="../news-tdcs.html"><img style=" width: 40px" src="../images/news-image.jpg" class="img-responsive" alt=""></a>
                                   </div>
                                   <div class="stories-info">
                                        <a style="color: white" href="../news-tdcs.html"><h5>Estimulación Transcraneal con tDCS</h5></a>
                                        <span>Agosto 07, 2023</span>
                                   </div>
                              </div>
                         </div>
                    </div>

                    <div class="col-md-4 col-sm-4"> 
                         <div class="footer-thumb">
                              <div class="opening-hours">
                                   <h4 class="wow fadeInUp" data-wow-delay="0.4s">Horario de apertura</h4>
                                   <p>Lunes - Viernes <span>08:00 AM - 8:00 PM</span></p>
                                   <p>S&aacute;bado <span>09:00 AM - 02:00 PM</span></p>
                                   <p>Domingo <span>Cerrado</span></p>
                              </div> 


                              <!-- <ul class="social-icon">
                                   <li><a href="#" class="fa fa-facebook-square" attr="facebook icon"></a></li>
                                   <li><a href="#" class="fa fa-twitter"></a></li>
                                   <li><a href="#" class="fa fa-instagram"></a></li>
                              </ul> -->
                              <!-- </div> -->
                         </div>
                    </div>

                    <div class="col-md-12 col-sm-12 border-top">
                         <div class="col-md-5 col-sm-6">
                              <div class="copyright-text"> 
                                   <p>Copyright &copy; 2023 Neuromodulación Gdl  
                                   
                                   </p>
                              </div>
                         </div>
                         <div class="col-md-5 col-sm-6">
                              <!-- <div class="footer-link"> 
                                   <a href="#">Laboratory Tests</a>
                                   <a href="#">Departments</a>
                                   <a href="#">Insurance Policy</a>
                                   <a href="#">Careers</a>
                              </div> -->
                         </div>
                         <div class="col-md-2 col-sm-2 text-align-center">
                              <div class="angle-up-btn"> 
                                  <a href="../#top" class="smoothScroll wow fadeInUp" data-wow-delay="1.2s"><i class="fa fa-angle-up"></i></a>
                              </div>
                         </div>   
                    </div>
                    
               </div>
          </div>
     </footer>
    <!-- Jquery Core Js -->
     <!-- SCRIPTS -->

    
    <script src="<?php echo $ruta; ?>plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="<?php echo $ruta; ?>plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Select Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/bootstrap-select/js/bootstrap-select.js"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/jquery-slimscroll/jquery.slimscroll.js"></script>


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


    <!-- Waves Effect Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/node-waves/waves.js"></script>
    
    <!-- Custom Js -->
    <script src="<?php echo $ruta; ?>js/admin.js"></script>
    <script src="<?php echo $ruta; ?>js/pages/ui/tooltips-popovers.js"></script>
    <!-- <script src="<?php echo $ruta; ?>js/pages/tables/jquery-datatable.js"></script> -->
    <script src="<?php echo $ruta; ?>js/pages/forms/basic-form-elements.js"></script>


    <!-- Demo Js -->
    <script src="<?php echo $ruta; ?>js/demo.js"></script>
</body>

</html>        

<!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html> -->
