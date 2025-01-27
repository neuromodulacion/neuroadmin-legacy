<?php

session_start();
error_reporting(7);
iconv_set_encoding('internal_encoding', 'utf-8'); 
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Monterrey');
setlocale(LC_TIME, 'es_ES.UTF-8');
$_SESSION['time']=time();
// 
		// require_once "../vendor/autoload.php";
		// use UAParser\Parser;

		
$ruta = "../";
extract($_POST);
//extract($_GET);
extract($_SESSION);
//print_r($_SESSION);



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
    <link rel="icon" href="<?php echo $ruta; ?>images/logo_aldana_tc.png" type="image/x-icon">

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
	      <!-- <ul class="nav navbar-nav">
	        <li><a href="#">Link</a></li>
	        <li class="dropdown">
	          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
	          <ul class="dropdown-menu">
	            <li><a href="#">Action</a></li>
	            <li><a href="#">Another action</a></li>
	            <li><a href="#">Something else here</a></li>
	            <li role="separator" class="divider"></li>
	            <li><a href="#">Separated link</a></li>
	            <li role="separator" class="divider"></li>
	            <li><a href="#">One more separated link</a></li>
	          </ul>
	        </li>
	      </ul> -->
	      <!-- <form class="navbar-form navbar-left">
	        <div class="form-group">
	          <input type="text" class="form-control" placeholder="Search">
	        </div>
	        <button type="submit" class="btn btn-default">Submit</button>
	      </form> -->
	      <!-- <ul class="nav navbar-nav navbar-right">
	        <li><a href="#">Link</a></li>
	        <li class="dropdown">
	          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
	          <ul class="dropdown-menu">
	            <li><a href="#">Action</a></li>
	            <li><a href="#">Another action</a></li>
	            <li><a href="#">Something else here</a></li>
	            <li role="separator" class="divider"></li>
	            <li><a href="#">Separated link</a></li>
	          </ul>
	        </li>
	      </ul> -->
	    </div><!-- /.navbar-collapse -->
	  </div><!-- /.container-fluid -->
	</nav>
	
<hr>
            <div align="center" class="row clearfix" style="padding: 5px; padding-top: 30px">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">

                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>

                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <form>
                                <div class="row clearfix">
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="number" id="ticket" name="ticket" class="form-control" placeholder="Ticket">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <button id="buscar" type="button" style="background: #0096AA; color: white"  class="btn  btn-lg m-l-15 waves-effect">BUSCAR</button>
				                        <script>
				                            $('#buscar').click(function(){ 
				                            	//alert('Test'); 
				                            	$('#contenido').html(''); 
				                            	$('#contenido2').html('');
				                                var ticket = $('#ticket').val();
				                                if (ticket !==''){
					                                $('#load').show();
					                                $('#buscar').hide();
					                                
					                                var datastring = 'ticket='+ticket;
				                                    $.ajax({
				                                        url: 'busca_ticket.php',
				                                        type: 'POST',
				                                        data: datastring,
				                                        cache: false,
				                                        success:function(html){
				                                        	//alert('Se modifico correctemente');       
				                                            $('#contenido').html(html); 
				                                            $('#buscar').show();

				                                            $('#load').hide();
				                                        }
				                                	});
			                                	}else{
			                                		alert('Debes ingresar el numero de Ticket');
			                                	}
				                            });
				                        </script>                                         
                                    </div>
                                </div>
                            </form>
	                        <div style="display: none" align="center" id="load">
                                <div class="preloader pl-size-xl">
                                    <div class="spinner-layer">
	                                   <div class="spinner-layer pl-teal">
	                                        <div class="circle-clipper left">
	                                            <div class="circle"></div>
	                                        </div>
	                                        <div class="circle-clipper right">
	                                            <div class="circle"></div>
	                                        </div>
	                                    </div>
                                    </div>
                                </div>
                                <h3>Cargando...</h3>			                        	
	                        </div>                             
                            <div align="left" id="contenido"></div>
                            <div align="left" id="contenido2"></div>
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
