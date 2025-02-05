<?php
include('functions/funciones_mysql.php'); // Incluye el archivo con la función `ejecutar`

// Inicializa la sesión y configura el entorno
error_reporting(E_ALL);
ini_set('default_charset', 'UTF-8');
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Monterrey');
setlocale(LC_TIME, 'es_ES.UTF-8');

// Define el título y ruta base
$title = 'INICIO';
$ruta = "";

// Consulta de artículos activos
$sql_art = "SELECT
                articulo.articulo_id AS articulo_idx,
                articulo.titulo AS titulox,
                articulo.descripcion AS descripcionx,
                articulo.f_alta AS f_altax
            FROM articulo
            WHERE articulo.estatus = 'Activo'
            ORDER BY articulo.titulo ASC";

// Ejecuta la consulta y obtiene el resultado usando `ejecutar`
$result_art = ejecutar($sql_art);

// Verifica si la consulta se ejecutó correctamente
if (!$result_art) {
    echo "Error al ejecutar la consulta de artículos.";
    exit();
}

// 
// extract($_SESSION);
// extract($_POST);
// extract($_GET);


?>

<!DOCTYPE html>
<html lang="es">
<head>

     <title>Neuro Modulaci&oacute;n Gdl</title>
<!--

Template 2098 Health

http://www.tooplate.com/view/2098-health

-->
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=Edge">
     <meta name="description" content="">
     <meta name="keywords" content="">
     <meta name="author" content="Tooplate">
     <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

     <link rel="stylesheet" href="css/bootstrap.min.css">
     <link rel="stylesheet" href="css/font-awesome.min.css">
     <link rel="stylesheet" href="css/animate.css">
     <link rel="stylesheet" href="css/owl.carousel.css">
     <link rel="stylesheet" href="css/owl.theme.default.min.css">

	<link rel="icon" href="../images/logo_aldana_tc.png" type="image/x-icon">
     <!-- MAIN CSS -->
    <link rel="stylesheet" href="css/tooplate-style.css">

	<!-- <script src="https://www.google.com/recaptcha/enterprise.js?render=6Lf1PlQpAAAAAGNctnH2YTQJQCWugSibNKDvYY3w"></script> -->
	    <script src="https://www.google.com/recaptcha/enterprise.js?render=6LefWXQpAAAAAEVNo3MwhrL5qhPXyIoezmTk8_LP"></script>
  	<!-- Your code -->
</head>


<script>
  function onClick(e) {
    e.preventDefault();
    grecaptcha.enterprise.ready(async () => {
      const token = await grecaptcha.enterprise.execute('6LefWXQpAAAAAEVNo3MwhrL5qhPXyIoezmTk8_LP', {action: 'LOGIN'});
    });
  }
</script>


<body id="top" data-spy="scroll" data-target=".navbar-collapse" data-offset="50">
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v17.0" nonce="7r0oY8qs"></script>
     <!-- PRE LOADER -->
     <section class="preloader">
          <div class="spinner">

               <span class="spinner-rotate"></span>
               
          </div>
     </section>
     <!-- HEADER -->
     <header>
          <div class="container">
               <div class="row">

                    <div class="col-md-3 col-sm-5">
                         <p>Bienvenidos a Neuromodulaci&oacute;n Gdl</p>
                    </div>
                         
                    <div class="col-md-9 col-sm-7 text-align-right">
                         <span class="phone-icon"><i style="color: #0096AA" class="fa fa-phone"></i><a target="_blank" href="https://api.whatsapp.com/send?phone=523334702176&text=Solicito informes de Neuromodulación Gdl">
          33 3470 2176</a></span>
                         <span class="date-icon"><i style="color: #0096AA"  class="fa fa-calendar-plus-o"></i> 9:00 AM - 8:00 PM (Lun-Vie) 10:00 AM - 2:00 PM (S&aacute;b)</span>
                         <span class="email-icon"><i style="color: #0096AA"  class="fa fa-envelope-o"></i><a href="mailto:contacto@neuromodulacion.com.mx?subject=Solicito%20Informacion%20de%20Neuromodulacion&body=Favor%20de%20enviar%20Informacion">contacto@neuromodulacion.com.mx</a></span>
                    </div>

               </div>
          </div>
     </header>

     <!-- MENU -->
     <section class="navbar navbar-default navbar-static-top" role="navigation">
          <div class="container">

               <div class="navbar-header">
                    <button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                         <span class="icon icon-bar"></span>
                         <span class="icon icon-bar"></span>
                         <span class="icon icon-bar"></span>
                    </button>

                    <!-- lOGO TEXT HERE -->
                    <a href="index.php" class="navbar-brand"><i style="color: #0096AA" class="fa fa-user-md"></i> Neuromodulaci&oacute;n Gdl</a>
               </div>

               <!-- MENU LINKS -->
               <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                         <li><a href="#top" class="smoothScroll">Inicio</a></li>
                         <li><a href="#about" class="smoothScroll">Acerca de</a></li>
                         <li><a href="#team" class="smoothScroll">Doctores</a></li>
						  <li role="presentation" class="dropdown">
						    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
						      Noticias<span class="caret"></span>
						    </a>
		                    <ul class="dropdown-menu">
		                        <?php
		                        while ($row = mysqli_fetch_assoc($result_art)) {
		                            echo '<li><a href="news.php?articulo_id=' . htmlspecialchars($row['articulo_idx']) . '">' . htmlspecialchars($row['descripcionx']) . '</a></li>';
		                        }
		                        ?>
		                    </ul>
						  </li>
                         <li><a href="#google-map" class="smoothScroll">Contacto</a></li>
                         <li class="appointment-btn"><a style="background: #0096AA"  href="#appointment">Solicita una cita</a></li>
                         <li class="appointment-btn"><a style="background: #BBBABA"  href="inicio.html">Ingreso Medico</a></li>
                    </ul>
               </div>

          </div>
     </section>

     <!-- HOME -->
     <section id="home" class="slider" data-stellar-background-ratio="0.5">
          <div class="container">
               <div class="row">
                     <div class="owl-carousel owl-theme">
                          <div class="item item-first">
                               <div class="caption">
                                    <div class="col-md-offset-1 col-md-10">
                                         <h3>"Descubre el presente y futuro de la terapia por neuromodulación en nuestro centro de tratamiento avanzado"</h3>
                                         <h1>Neuromodulación GDL</h1>
                                         <a style="background: #0096AA" href="#team" class="section-btn btn btn-default smoothScroll">Conozca a nuestros médicos</a>
                                    </div>
                               </div>
                          </div>

                          <div class="item item-second">
                               <div class="caption">
                                    <div class="col-md-offset-1 col-md-10">
                                         <h3>"Le damos la bienvenida a los tratamientos de vanguardia en neuromodulación: Terapia con Corriente directa y Magnética Transcraneal"</h3>
                                         <h1>Acercamos la Innovación en Tratamientos para la Salud Mental</h1>
                                         <a style="background: #0096AA" href="#about" class="section-btn btn btn-default btn-gray smoothScroll">Más acerca de nosotros</a>
                                    </div>
                               </div>
                          </div>

                          <div class="item item-third">
                               <div class="caption">
                                    <div class="col-md-offset-1 col-md-10">
                                         <h3>"Donde Ciencia y Tecnología Se Unen para Mejorar tu Bienestar Mental"</h3>
                                         <h1>Tus beneficios de salud</h1>
                                         <a style="background: #0096AA" href="#news" class="section-btn btn btn-default btn-blue smoothScroll">Leer historias</a>
                                    </div>
                               </div>
                          </div>
                     </div>
               </div>
          </div>
     </section>


     <!-- ABOUT -->
     <section id="about">
          <div class="container">
               <div class="row">
                    <div class="col-md-6 col-sm-6">
                         <div class="about-info">
                              <h2 class="wow fadeInUp" data-wow-delay="0.6s"><i style="color: #0096AA" class="fa fa-user-md"></i> Bienvenidos a Neuromodulaci&oacute;n Gdl</h2>
                              <div class="wow fadeInUp" data-wow-delay="0.8s">
                                   <p>"En nuestro centro, buscamos ofrecer las terapias por neuromodulación más actualizadas y con mejor evidencia científica, como lo son la Estimulación Transcraneal con Corriente Directa, y Estimulación Magnética Transcraneal, que sean accesibles para las personas en quienes estén indicadas”
									Nuestros equipos cuentan con la aprobación Nacional de COFEPRIS, así como agendas de regulación internacional. Las tecnologías de vanguardia y nuestro equipo de profesionales en salud mental, están aquí para ayudarte a mejorar tu bienestar y tu calidad de vida.</p>
									<b><h3>¿Cómo funciona nuestro servicio?</h3></b><br>
										<p>Neuromodulación GDL opera de manera similar a una farmacia. Es decir, nosotros recibimos la prescripción y referencia por parte de médicos que han determinado que la persona requiere de alguna terapia por neuromodulación. De tal forma que la indicación y seguimiento clínico, seguirá siendo de la o el médico que recomendó neuromodulación, y nuestro equipo le contactará para explicar detalles del procedimiento, calendarizar el número de sesiones que están prescritas, aplicar la técnica de neuromodulación indicada, y reportar los resutados de sus avances a la o el médico que le recomendó.
									</p>
									<b><h3>Quiero recibir Neuromodulación, pero no tengo médico que me asesore</h3></b><br>
										<p>En Neuromodulación GDL, tenemos alianza con Ágape – Unidad Médica de Atención Universal y Especializada, contando con un grupo de especialistas en salud mental que mediante una consulta médica programada pueden revisar su caso particular, establecer diagnóstico y opciones de tratamiento adecuados. Si junto a la o el médico, determinan los objetivos terapéuticos, indicaciones y contraindicaciones de Neuromodulación, éste le registrará su referencia para que nuestro Staff pueda calendarizar las sesiones prescritas.
									</p>
									
									<b><h3>¿Qué es la Neuromodulación?</h3></b><br>
										<p>Es una modalidad de tratamiento que utiliza dispositivos médicos, con tecnología electromagnética, capaz de modificar las funciones eléctricas del cerebro, localizadas en las diferentes áreas de la corteza, sin necesidad ingresar agentes al cuerpo, sin producir dolor, ni requerir sedación para ser aplicadas. A esto también se le conoce como estimulación cerebral no invasiva (NIBS, por sus siglas en inglés).</p>
									
									<p>Se podría pensar que se trata de tratamientos novedosos, sin embargo existen más de 30 años de investigación y aplicación clínica de estas técnicas de intervención, siendo la Estimulación Magnética Transcraneal (TMS), y la Estimulación Transcraneal por Corriente Directa (tDCS), las que han demostrado con sólida evidencia científica, su utilidad en diferentes condiciones de salud como la depresión, ansiedad, migraña, fibromialgia, trastorno obsesivo compulsivo, y una creciente evidencia de su aplicación en adicciones, estrés postraumático, epilepsia y autismo.
									</p>
                              </div>
                              <figure class="profile wow fadeInUp" data-wow-delay="1s">
                                   <img src="images/author-image.jpg" class="img-responsive" alt="">
                                   <figcaption>
                                        <h3>Dr. Alejandro Aldana</h3>
                                        <p>Psiquiatra</p>
                                   </figcaption>
                              </figure>
                         </div>
                    </div>                   
               </div>
          </div>
     </section>
     <!-- TEAM -->
     <section id="team" data-stellar-background-ratio="1">
          <div class="container">
               <div class="row">

                    <div class="col-md-6 col-sm-6">
                         <div class="about-info">
                              <h2 class="wow fadeInUp" data-wow-delay="0.1s">Nuestros Doctores</h2>
                         </div>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-md-4 col-sm-6">
                         <div class="team-thumb wow fadeInUp" data-wow-delay="0.2s">
                              <img src="images/team-image1.jpg" class="img-responsive" alt="">
                               <div class="team-info">
                                    <h3>Dr. Alejandro Aldana</h3>
                                    <p>Psiquiatra</p>
                                    <!-- <p>Director General</p> -->
                                    <div class="team-contact-info">
                                         <p><i class="fa fa-phone"></i> 33 3470 2176</p>
                                         <p><i class="fa fa-envelope-o"></i> <a href="mailto:dr.alejandro.aldana@neuromodulacion.com.mx?subject=Solicito%20Informacion%20de%20Neuromodulacion&body=Favor%20de%20enviar%20Informacion">dr.alejandro.aldana@neuromodulacion.com.mx</a></p>
                                    </div>
                                    <ul class="social-icon">
                                         <li><a href="#" class="fa fa-linkedin-square"></a></li>
                                         <li><a href="#" class="fa fa-envelope-o"></a></li>
                                    </ul>
                               </div>
                         </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                         <div class="team-thumb wow fadeInUp" data-wow-delay="0.4s">
	                          <img src="images/team-image2.jpg" class="img-responsive" alt="">
	                           <div class="team-info">
	                                <h3>Dra. Maritza Flores</h3>                                  
	                                <p>	
	       								Médico de Enlace del Centro de Neuromodulación GDL.<hr>
										Médico Cirujano por la Universidad Autónoma de Guadalajara (UAG).<hr>
										Certificada por la American Heart Association (AHA), Basic Life Support 2019 y 2023.<hr> 
										Miembro de la mesa directiva de la Sociedad Investigadora Estudiantil (SIE) 2018-2021.<hr> 
										Miembro de la mesa directiva de la Sociedad DISE (Doctors Interested in Surgical Education) 2019-2020
									</p>
	                                <!-- <div class="team-contact-info">
	                                     <p><i class="fa fa-phone"></i> 010-070-0170</p>
	                                     <p><i class="fa fa-envelope-o"></i> <a href="#">pregnancy@company.com</a></p>
	                                </div>
	                                <ul class="social-icon">
	                                     <li><a href="#" class="fa fa-facebook-square"></a></li>
	                                     <li><a href="#" class="fa fa-envelope-o"></a></li>
	                                     <li><a href="#" class="fa fa-flickr"></a></li>
	                                </ul> -->
	                           </div>
                         </div>
                    </div>

                    <div class="col-md-4 col-sm-6">
                         <div class="team-thumb wow fadeInUp" data-wow-delay="0.6s">
                              <img src="images/team-image3.jpg" class="img-responsive" alt="">
                              <div class="team-info">
                                    <h3>Dra. Andrea Guillen</h3>
                                    <p>	
           								Médico de Enlace del Centro de Neuromodulación GDL.<hr>
										Médico, cirujano y partero por la Universidad Autónoma de Guadalajara (UAG).<hr>
										Profesora titular del área de Medicina Interna I en la Facultad de Medicina, UAG, asignatura de Neumología.<hr> 
										Miembro de la mesa directiva de la Sociedad Investigadora Estudiantil (SIE) 2018-2021.<hr> 
										Miembro del Colegio Médico Joseph Lister.<hr>
									</p>

                                    <!-- <div class="team-contact-info">
                                         <p><i class="fa fa-phone"></i> 010-040-0140</p>
                                         <p><i class="fa fa-envelope-o"></i> <a href="#">cardio@company.com</a></p>
                                    </div>
                                    <ul class="social-icon">
                                         <li><a href="#" class="fa fa-twitter"></a></li>
                                         <li><a href="#" class="fa fa-envelope-o"></a></li>
                                    </ul> -->
                              </div>
                         </div>
                    </div> 
                    <div class="col-md-4 col-sm-6">
                         <div class="team-thumb wow fadeInUp" data-wow-delay="0.6s">
                              <img src="images/team-image5.jpg" class="img-responsive" alt="">

                                   <div class="team-info">
                                        <h3>Dr. Bryan Felix</h3>
                                        <p>	
               								Médico de Enlace del Centro de Neuromodulación GDL.<hr>
											Médico Cirujano por la Universidad Autónoma de Guadalajara (UAG).<hr>
											Capacitación de simulación nivel instructor en la Universidad Autónoma de Guadalajara 2023.<hr> 
											Certificado por la American Heart Association (AHA), Basic Life Support 2023.
										</p>
                                        <!-- <div class="team-contact-info">
                                             <p><i class="fa fa-phone"></i> 010-040-0140</p>
                                             <p><i class="fa fa-envelope-o"></i> <a href="#">cardio@company.com</a></p>
                                        </div> -->
                                        <!-- <ul class="social-icon">
                                             <li><a href="#" class="fa fa-twitter"></a></li>
                                             <li><a href="#" class="fa fa-envelope-o"></a></li>
                                        </ul> -->
                                   </div>

                         </div>
                    </div>  
                    <div class="col-md-4 col-sm-6">
                         <div class="team-thumb wow fadeInUp" data-wow-delay="0.6s">
                              <img src="images/team-image4.jpg" class="img-responsive" alt="">

                               <div class="team-info">
                                    <h3>Dra. Elizabeth Gutiérrez</h3>
                                    <p>	
           								Médico de Enlace del Centro de Neuromodulación GDL.<hr>
           								Médico cirujano y partero por la Universidad de Guadalajara (UDG).<hr>
										Testimonio de desempeño "Sobresaliente” por el Centro Nacional de Evaluación para la Educación Superior A.C. (CENEVAL) 2022.<hr>
										Acreditada por la Asociación Americana del Corazón e ILCOR para el soporte vital en emergencias cardiovasculares en 2020.<hr>
										<!-- Acreditada por la Asociación Americana del Corazón e Internacional Liasion Committee on Resuscitation (ILCOR) para el soporte vital en emergencias Cardiovasculares 2020<hr> -->
										Certificada por el marco Común Europeo de Referencia para las lenguas B1 (2021)<hr>
										Gestora de la salud en el sistema de educación media superior (UDG) 2015<hr>
										<!-- Médico Cirujano por la Universidad Autónoma de Guadalajara (UAG).<hr>
										Capacitación de simulación nivel instructor en la Universidad Autónoma de Guadalajara 2023.<hr> 
										Certificado por la American Heart Association (AHA), Basic Life Support 2023. -->
									</p>
                                    <!-- <div class="team-contact-info">
                                         <p><i class="fa fa-phone"></i> 010-040-0140</p>
                                         <p><i class="fa fa-envelope-o"></i> <a href="#">cardio@company.com</a></p>
                                    </div>
                                    <ul class="social-icon">
                                         <li><a href="#" class="fa fa-twitter"></a></li>
                                         <li><a href="#" class="fa fa-envelope-o"></a></li>
                                    </ul> -->
                               </div>

                         </div>
                    </div>                                        
                                         
               </div>
          </div>
     </section>


     <!-- NEWS -->
     <section id="news" data-stellar-background-ratio="2.5">
          <div class="container">
               <div class="row">

                    <div class="col-md-12 col-sm-12">
                         <!-- SECTION TITLE -->
                         <div class="section-title wow fadeInUp" data-wow-delay="0.1s">
                              <h2>&Uacute;ltimas noticias</h2>
                         </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                         <!-- NEWS THUMB -->
                         <div class="news-thumb wow fadeInUp" data-wow-delay="0.4s">
                              <a href="news.php?articulo_id=21">
                                   <img src="images/news-image1.jpg" class="img-responsive" alt="">
                              </a>
                              <div class="news-info">
                                   <span>Agosto 04, 2023</span>
                                   <h3><a href="news-tms.html">Acerca de la tecnología TMS</a></h3>
                                   <p>Estimulación Magnetica Transcraneal.</p>
                                   <div class="author">
                                        <img src="images/author-image.jpg" class="img-responsive" alt="">
                                        <div class="author-info">
	                                        <h5>Dr. Alejandro Aldana</h5>
	                                        <p>Psiquiatra</p>
                                        </div>
                                   </div>
                              </div>
                         </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                         <!-- NEWS THUMB -->
                         <div class="news-thumb wow fadeInUp" data-wow-delay="0.6s">
                              <a href="news.php?articulo_id=13">
                                   <img src="images/news-image2.jpg" class="img-responsive" alt="">
                              </a>
                              <div class="news-info">
                                   <span>Agosto 04, 2023</span>
                                   <h3><a href="news-tdcs.html">Acerca de la tecnología tDCS</a></h3>
                                   <p>Estimulación Transcraneal Con corriente directa.</p>
                                   <div class="author">
                                        <img src="images/author-image.jpg" class="img-responsive" alt="">
                                        <div class="author-info">
	                                        <h5>Dr. Alejandro Aldana</h5>
	                                        <p>Psiquiatra</p>
                                        </div>
                                   </div>
                              </div>
                         </div>
                    </div>
<!-- NEWS THUMB -->
                    <!-- <div class="col-md-4 col-sm-6">
                         
                         <div class="news-thumb wow fadeInUp" data-wow-delay="0.8s">
                              <a href="news-detail.html">
                                   <img src="images/news-image3.jpg" class="img-responsive" alt="">
                              </a>
                              <div class="news-info">
                                   <span>January 27, 2018</span>
                                   <h3><a href="news-detail.html">Review Annual Medical Research</a></h3>
                                   <p>Vivamus non nulla semper diam cursus maximus. Pellentesque dignissim.</p>
                                   <div class="author">
                                        <img src="images/author-image.jpg" class="img-responsive" alt="">
                                        <div class="author-info">
                                             <h5>Andrio Abero</h5>
                                             <p>Online Advertising</p>
                                        </div>
                                   </div>
                              </div>
                         </div>
                    </div> -->

               </div>
          </div>
     </section>


     <!-- SOLICITA UNA CITA -->
     <section id="appointment" data-stellar-background-ratio="3">
          <div class="container">
               <div class="row">

                    <div class="col-md-6 col-sm-6">
                         <img src="images/appointment-image.jpg" class="img-responsive" alt="">
                    </div>

                    <div class="col-md-6 col-sm-6">
                         <!-- CONTACT FORM HERE -->
                         <form id="appointment-form" target="_blank" role="form" method="post" action="informes.php">

                              <!-- SECTION TITLE -->
                              <div class="section-title wow fadeInUp" data-wow-delay="0.4s">
                                   <h2>Solicita Informes</h2>
                              </div>

                              <div class="wow fadeInUp" data-wow-delay="0.8s">
                                   <div class="col-md-6 col-sm-6">
                                        <label for="name">Nombre</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Nombre completo">
                                   </div>

                                   <div class="col-md-6 col-sm-6">
                                        <label for="email">Correo</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Tu correo electronico">
                                   </div>

                                   <div class="col-md-6 col-sm-6">
                                        <label for="name">Medico tratante</label>
                                        <input type="text" class="form-control" id="medico" name="medico" placeholder="Nombre en caso de tener">
                                   </div>

                                   <div class="col-md-12 col-sm-12">
                                        <label for="telephone">Numero de Celular</label>
                                        <input type="tel" class="form-control" id="phone" name="phone" placeholder="Celular">
                                        <label for="Message">Mensaje Adicional</label>
                                        <textarea class="form-control" rows="5" id="message" name="message" placeholder="Mensaje"></textarea>
                                        <button  style="background: #0096AA" type="submit" class="form-control" id="cf-submit" name="submit">Envia Mensaje</button>
                                   </div>
                              </div>
                        </form>
                    </div>

               </div>
          </div>
     </section>


     <!-- GOOGLE MAP -->
     <section id="google-map">
     <!-- How to change your own map point
            1. Go to Google Maps
            2. Click on your location point
            3. Click "Share" and choose "Embed map" tab
            4. Copy only URL and paste it within the src="" field below
	-->
          <!-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3647.3030413476204!2d100.5641230193719!3d13.757206847615207!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xf51ce6427b7918fc!2sG+Tower!5e0!3m2!1sen!2sth!4v1510722015945" width="100%" height="350" frameborder="0" style="border:0" allowfullscreen></iframe> -->
    		<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3733.1502497646443!2d-103.38700462607751!3d20.66346540022751!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8428ae7579ec0939%3A0xf8691c23c0b47a54!2sAv.%20de%20los%20Arcos%20876%2C%20Jardines%20del%20Bosque%2C%2044520%20Guadalajara%2C%20Jal.%2C%20M%C3%A9xico!5e0!3m2!1ses-419!2sus!4v1691282797537!5m2!1ses-419!2sus" width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</section>           


     <!-- FOOTER -->
     <footer data-stellar-background-ratio="5">
          <div class="container">
               <div class="row">

                    <div class="col-md-4 col-sm-4">
                         <div class="footer-thumb"> 
                              <h4 class="wow fadeInUp" data-wow-delay="0.4s">Informaci&oacute;n de Contacto</h4>
                              <p>"¡Solicita información tu consulta hoy mismo!"</p>

                              <div class="contact-info">
                                   <p><i class="fa fa-phone"></i><a target="_blank" href="https://api.whatsapp.com/send?phone=523334702176&text=Solicito informes de Neuromodulación Gdl">
          33 3470 2176</a></p>
                                   <p><i class="fa fa-envelope-o"></i> 
                                   	<a href="mailto:contacto@neuromodulacion.com.mx?subject=Solicito%20Informacion%20de%20Neuromodulacion&body=Favor%20de%20enviar%20Informacion">contacto@neuromodulacion.com.mx</a></p>                              
                              </div>
                         </div>
                    </div>

                    <div class="col-md-4 col-sm-4"> 
                         <div class="footer-thumb"> 
                              <h4 class="wow fadeInUp" data-wow-delay="0.4s">Servicios</h4>
                              <div class="latest-stories">
                                   <div class="stories-image">
                                        <a href="news-tms.html"><img src="images/news-image.jpg" class="img-responsive" alt=""></a>
                                   </div>
                                   <div class="stories-info">
                                        <a href="news-tms.html"><h5>Estimulación Magnética Transcraneal</h5></a>
                                        <span>Agosto 04, 2023</span>
                                   </div>
                              </div>

                              <div class="latest-stories">
                                   <div class="stories-image">
                                        <a href="news-tdcs.html"><img src="images/news-image.jpg" class="img-responsive" alt=""></a>
                                   </div>
                                   <div class="stories-info">
                                        <a href="news-tdcs.html"><h5>Estimulación Transcraneal con tDCS</h5></a>
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
                                   
                                   | Design: <a href="http://www.tooplate.com" target="_parent">Tooplate</a></p>
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
                                  <a href="#top" class="smoothScroll wow fadeInUp" data-wow-delay="1.2s"><i class="fa fa-angle-up"></i></a>
                              </div>
                         </div>   
                    </div>
                    
               </div>
          </div>
     </footer>

     <!-- SCRIPTS -->
     <script src="js/jquery.js"></script>
     <script src="js/bootstrap.min.js"></script>
     <script src="js/jquery.sticky.js"></script>
     <script src="js/jquery.stellar.min.js"></script>
     <script src="js/wow.min.js"></script>
     <script src="js/smoothscroll.js"></script>
     <script src="js/owl.carousel.min.js"></script>
     <script src="js/custom.js"></script>

</body>
</html>
