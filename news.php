<?php
include('functions/funciones_mysql.php');
//session_start();
error_reporting(7);
iconv_set_encoding('internal_encoding', 'utf-8'); 
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Monterrey');
setlocale(LC_TIME, 'es_ES.UTF-8');
$_SESSION['time']=mktime();

$ruta="";
$title = 'INICIO';

extract($_SESSION);
extract($_POST);
extract($_GET);


$sql_art ="
SELECT
	articulo.articulo_id as articulo_idx, 
	articulo.titulo as titulox, 
	articulo.titulo_corto as titulo_cortox,
	articulo.descripcion as descripcionx, 
	articulo.f_alta as f_altax
FROM
	articulo
WHERE
	estatus = 'Activo'
ORDER BY articulo_id ASC"; 



$sql ="
SELECT
	articulo.articulo_id, 
	articulo.usuario_id, 
	articulo.titulo, 
	articulo.titulo_corto, 
	articulo.descripcion, 
	articulo.insert_multimedia,
	articulo.multimedia, 
	articulo.autor, 
	articulo.titulo_autor, 
	articulo.imagen_autor, 
	articulo.f_alta, 
	articulo.h_alta, 
	articulo.contenido
FROM
	articulo
WHERE 
	articulo.articulo_id = $articulo_id";    
    
    $result=ejecutar($sql); 
    $row = mysqli_fetch_array($result);
    extract($row);	
	//print_r($row);

?>
<!DOCTYPE html>
<html lang="en">
<head>

     <title><?php echo $titulo_corto; ?></title>
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
     <link rel="stylesheet" href="css/magnific-popup.css">

     <link rel="stylesheet" href="css/font-awesome.min.css">
     <link rel="stylesheet" href="css/animate.css">

     <link rel="stylesheet" href="css/owl.carousel.css">
     <link rel="stylesheet" href="css/owl.theme.default.min.css">

	<link rel="icon" href="../images/favicon.png" type="image/x-icon">
     <!-- MAIN CSS -->
     <link rel="stylesheet" href="css/tooplate-style.css">

</head>
<body id="top" data-spy="scroll" data-target=".navbar-collapse" data-offset="50">

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
                         <span class="email-icon"><i style="color: #0096AA"  class="fa fa-envelope-o"></i><a href="mailto:contacto@neuromodulaciongdl.com?subject=Solicito%20Informacion%20de%20Neuromodulacion&body=Favor%20de%20enviar%20Informacion">contacto@neuromodulaciongdl.com</a></span>
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
                         <li><a href="index.php#top" class="smoothScroll">Inicio</a></li>
                         <li><a href="index.php#about" class="smoothScroll">Acerca de</a></li>
                         <li><a href="index.php#team" class="smoothScroll">Doctores</a></li>
						  <li role="presentation" class="dropdown">
						    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
						      Noticias<span class="caret"></span>
						    </a>
						    <ul class="dropdown-menu">	
						    	<?php
										$result_art = ejecutar($sql_art);
										while($row_sem2 = mysqli_fetch_array($result_art)){ 
											extract($row_sem2);
											?>
											<li><a href="news.php?articulo_id=<?php echo $articulo_idx; ?>" ><?php echo $descripcionx; ?></a></li>								    
								<?php }	 ?>					    						    	            
						    </ul>
						  </li>
                         <li><a href="index.php#google-map" class="smoothScroll">Contacto</a></li>
                         <li class="appointment-btn"><a style="background: #0096AA"  href="#appointment">Solicita una cita</a></li>
                         <li class="appointment-btn"><a style="background: #BBBABA"  href="../inicio.html">Ingreso Medico</a></li>
                    </ul>
               </div>

          </div>
     </section>


     <!-- NEWS DETAIL -->
     <section id="news-detail" data-stellar-background-ratio="0.5">
          <div class="container">
               <div class="row">

                    <div class="col-md-8 col-sm-7">
                         <!-- NEWS THUMB -->
                         <div class="news-detail-thumb">
                              <div class="news-image">                            	                          	
                              		<?php
                              		$foto = '<img src="'.$insert_multimedia.'" class="img-responsive" alt="">';
                              		if ($insert_multimedia == 'Video') {
										  echo $multimedia; 
									  } else { ?>
									  	<img src="<?php echo $multimedia; ?>" class="img-responsive" alt="">
									 <?php }
									                               		
                              		  ?>                                  
                              </div>
                              <h3><?php echo $titulo; ?></h3>
                              
                              <?php echo $contenido; ?>
                              
                              <div class="news-social-share">
                                   <h4>Comparte este artículo</h4>
                                        <a href="#" class="btn btn-primary"><i class="fa fa-facebook"></i>Facebook</a>
                                        <a href="#" class="btn btn-success"><i class="fa fa-twitter"></i>Twitter</a>
                                        <a href="#" class="btn btn-danger"><i class="fa fa-google-plus"></i>Google+</a>
                              </div>
                         </div>
                    </div>

                    <div class="col-md-4 col-sm-5">
                         <div class="news-sidebar">
                              <!-- <div class="news-author">
                                   <h4>Sobre el autor</h4>
                                   <p>Lorem ipsum dolor sit amet, maecenas eget vestibulum justo imperdiet, wisi risus purus augue vulputate voluptate neque.</p>
                              </div> -->

                              <div class="recent-post">
                                   <h4>Noticias Recientes</h4>
							    	<?php
										$result_art = ejecutar($sql_art);
										while($row_sem2 = mysqli_fetch_array($result_art)){ 
											extract($row_sem2); ?>
                                        <div class="media">
                                             <div class="media-object pull-left">
                                                  <a href="news-tms.html"><img src="images/news-image.jpg" class="img-responsive" alt=""></a>
                                             </div>
                                             <div class="media-body">
                                                  <h4 class="media-heading"><a href="news.php?articulo_id=<?php echo $articulo_idx; ?>"><?php echo $titulo_cortox; ?></a></h4>
                                             </div>
                                        </div>											

									<?php }	 ?>	
                              </div>

                              <div class="news-categories">
                                   <h4>Categorias</h4>
                                        <li><a href="#"><i class="fa fa-angle-right"></i> Psiquiatra</a></li>
                                        <li><a href="#"><i class="fa fa-angle-right"></i> Salud</a></li>
                                        <li><a href="#"><i class="fa fa-angle-right"></i> Consulta</a></li>
                              </div>

                              <div class="news-ads sidebar-ads">
                                   <h4>Sidebar Banner Ad</h4>
                              </div>

                              <div class="news-tags">
                                   <h4>Tags</h4>
                                        <li><a href="#">TMS</a></li>
                                        <li><a href="#">Depresion</a></li>
                                        <li><a href="#">Psiquiatra</a></li>
                                        <li><a href="#">Medico</a></li>
                                        <li><a href="#">Doctores</a></li>
                                        <li><a href="#">Social</a></li>
                              </div>
                         </div>
                    </div>
                    
               </div>
          </div>
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
                                   	<a href="mailto:contacto@neuromodulaciongdl.com?subject=Solicito%20Informacion%20de%20Neuromodulacion&body=Favor%20de%20enviar%20Informacion">contacto@neuromodulaciongdl.com</a></p>                              
                              </div>
                         </div>
                    </div>

                    <div class="col-md-4 col-sm-4"> 
                         <div class="footer-thumb"> 
                              <h4 class="wow fadeInUp" data-wow-delay="0.4s">&Uacute;ltimas Noticias</h4>
						    	<?php
									$result_art = ejecutar($sql_art);
									while($row_sem2 = mysqli_fetch_array($result_art)){ 
										extract($row_sem2); ?>
			                              <div class="latest-stories">
			                                   <div class="stories-image">
			                                        <a href="news.php?articulo_id=<?php echo $articulo_idx; ?>">
			                                        	<img src="images/news-image.jpg" class="img-responsive" alt=""></a>
			                                   </div>
			                                   <div class="stories-info">
			                                        <a href="news.php?articulo_id=<?php echo $articulo_idx; ?>"><h5><?php echo $titulo_cortox; ?></h5></a>
			                                        <span><?php echo $f_altax; ?></span>
			                                   </div>
			                              </div>										
							    
								<?php }	 ?>	                              
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
     <script src="js/jquery.magnific-popup.min.js"></script>
     <script src="js/magnific-popup-options.js"></script>
     <script src="js/wow.min.js"></script>
     <script src="js/smoothscroll.js"></script>
     <script src="js/owl.carousel.min.js"></script>
     <script src="js/custom.js"></script>

</body>
</html>