<?php

session_start();
error_reporting(7);
iconv_set_encoding('internal_encoding', 'utf-8'); 
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Monterrey');
setlocale(LC_TIME, 'es_ES.UTF-8');
$_SESSION['time']=mktime();

//$ruta = "";
extract($_POST);
//print_r($_POST);
extract($_SESSION);
//print_r($_SESSION);

$ubicacion_url = $_SERVER['PHP_SELF']; 
$ubicacion_url = $ubicacion_url;
$ubicacion_url = $rest = substr($ubicacion_url, 17 , 100);

if ($sesion !== "On") {
	header('Location: ../index.html');
}
include($ruta.'functions/funciones_mysql.php');
//'..'.
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title><?php echo $titulo; ?></title>
    
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>   
    <!-- <script src="<?php echo $ruta; ?>js/jquery-3.3.1.min.js"></script>  -->    
    <!-- Favicon-->
    <link rel="icon" href="<?php echo $ruta; ?>favicon.ico" type="image/x-icon">

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
   
   <!-- ********************************** --> 
   <!-- Bootstrap Material Datetime Picker Css -->
    <link href="<?php echo $ruta; ?>plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />

    <!-- Bootstrap DatePicker Css -->
    <link href="<?php echo $ruta; ?>plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />

    <!-- Wait Me Css -->
    <link href="<?php echo $ruta; ?>plugins/waitme/waitMe.css" rel="stylesheet" />

    <!-- Bootstrap Select Css -->
    <link href="<?php echo $ruta; ?>plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
    
   <!-- ********************************** -->
    <!-- JQuery DataTable Css -->
    <link href="<?php echo $ruta; ?>plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

    
    <!-- Sweet Alert Css -->
    <link href="<?php echo $ruta; ?>plugins/sweetalert/sweetalert.css" rel="stylesheet" />


    <!-- Morris Chart Css-->
<?php if ($ubicacion_url <> "paciente/alta.php") { ?>
    <link href="<?php echo $ruta; ?>plugins/morrisjs/morris.css" rel="stylesheet" />     
<?php }   ?>    

    <!-- JQuery DataTable Css -->
    <link href="<?php echo $ruta; ?>plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

<!-- *************Tronco comun ******************** --> 
    <!-- Custom Css -->
    <link href="<?php echo $ruta; ?>css/style.css" rel="stylesheet">

    <!-- AdminTMS Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="<?php echo $ruta; ?>css/themes/all-themes.css" rel="stylesheet" />
</head>

<body class="theme-<?php echo $body; ?>">
	
    <!-- Page Loader -->
    <!--<div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-<?php echo $body; ?>">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Please wait...</p>
        </div>
    </div>
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <!-- Search Bar -->
    <div class="search-bar">
        <div class="search-icon">
            <i class="material-icons">search</i>
        </div>
        <input type="text" placeholder="START TYPING...">
        <div class="close-search">
            <i class="material-icons">close</i>
        </div>
    </div>
    <!-- #END# Search Bar -->
    <!-- Top Bar -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="<?php echo $ruta; ?>index.html">ADMINTMS - Sistema de administración de Terapia Magnetica Transcraneal</a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <!-- Call Search -->
                    <li><a href="javascript:void(0);" class="js-search" data-close="true"><i class="material-icons">search</i></a></li>
                    <!-- #END# Call Search -->
                    <!-- Notifications -->
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                            <i class="material-icons">notifications</i>
                            <span class="label-count">7</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">NOTIFICATIONS</li>
                            <li class="body">
                                <ul class="menu">
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="icon-circle bg-light-green">
                                                <i class="material-icons">person_add</i>
                                            </div>
                                            <div class="menu-info">
                                                <h4>12 new members joined</h4>
                                                <p>
                                                    <i class="material-icons">access_time</i> 14 mins ago
                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="icon-circle bg-cyan">
                                                <i class="material-icons">add_shopping_cart</i>
                                            </div>
                                            <div class="menu-info">
                                                <h4>4 sales made</h4>
                                                <p>
                                                    <i class="material-icons">access_time</i> 22 mins ago
                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="icon-circle bg-<?php echo $body; ?>">
                                                <i class="material-icons">delete_forever</i>
                                            </div>
                                            <div class="menu-info">
                                                <h4><b>Nancy Doe</b> deleted account</h4>
                                                <p>
                                                    <i class="material-icons">access_time</i> 3 hours ago
                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="icon-circle bg-orange">
                                                <i class="material-icons">mode_edit</i>
                                            </div>
                                            <div class="menu-info">
                                                <h4><b>Nancy</b> changed name</h4>
                                                <p>
                                                    <i class="material-icons">access_time</i> 2 hours ago
                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="icon-circle bg-blue-grey">
                                                <i class="material-icons">comment</i>
                                            </div>
                                            <div class="menu-info">
                                                <h4><b>John</b> commented your post</h4>
                                                <p>
                                                    <i class="material-icons">access_time</i> 4 hours ago
                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="icon-circle bg-light-green">
                                                <i class="material-icons">cached</i>
                                            </div>
                                            <div class="menu-info">
                                                <h4><b>John</b> updated status</h4>
                                                <p>
                                                    <i class="material-icons">access_time</i> 3 hours ago
                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="icon-circle bg-purple">
                                                <i class="material-icons">settings</i>
                                            </div>
                                            <div class="menu-info">
                                                <h4>Settings updated</h4>
                                                <p>
                                                    <i class="material-icons">access_time</i> Yesterday
                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="footer">
                                <a href="javascript:void(0);">View All Notifications</a>
                            </li>
                        </ul>
                    </li>
                    <!-- #END# Notifications -->
                    
                    <li class="pull-right"><a href="javascript:void(0);" class="js-right-sidebar" data-close="true"><i class="material-icons">more_vert</i></a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info">
                <div class="image">
                    <!-- <img src="images/user.png" width="48" height="48" alt="User" /> -->
                    <br>
                </div>
                <div class="info-container"><br>
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: white"><?php echo "<b>".$nombre_corto."</b>"; ?></div>
                    <div class="email"  style="color: white"><?php echo "<b>".$usuario."</b>"; ?></div>
                    <div class="btn-group user-helper-dropdown">
                        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="javascript:void(0);"><i class="material-icons">person</i>Prefil</a></li>
                            <li role="separator" class="divider"></li>
                            <!-- <li><a href="javascript:void(0);"><i class="material-icons">group</i>Followers</a></li>
                            <li><a href="javascript:void(0);"><i class="material-icons">shopping_cart</i>Sales</a></li>
                            <li><a href="javascript:void(0);"><i class="material-icons">favorite</i>Likes</a></li>
                            <li role="separator" class="divider"></li> -->
                            <li><a href="javascript:void(0);"><i class="material-icons">input</i>Cierre de Sesión</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- #User Info -->
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li class="header">Menú de Navegación</li>
                    <li <?php if ($ubicacion_url == $ruta.'menu.php') { echo 'class="active"'; } ?> >   
                        <a href="<?php echo $ruta; ?>menu.php">
                            <i class="material-icons">home</i>
                            <span>Inicio</span>
                        </a>
                    </li>  
	                <li <?php if ($ubicacion_url == 'paciente/alta.php' || $ubicacion_url == 'paciente/pendientes.php' || $ubicacion_url == 'paciente/solicitud.php' 
					 || $ubicacion_url == 'paciente/seguimiento.php' || $ubicacion_url == 'paciente/directorio.php' || $ubicacion_url == 'paciente/historico.php' 
					  || $ubicacion_url == 'paciente/agenda.php'  ) { echo 'class="active"'; } ?>>
	                    <a href="javascript:void(0);" class="menu-toggle">
	                        <i class="material-icons">assignment_ind</i>
	                        <span>Pacientes</span>
	                    </a>
	                    <ul class="ml-menu">
	                        <li <?php if ($ubicacion_url == 'paciente/alta.php') { echo 'class="active"'; } ?> >
	                            <a href="<?php echo $ruta; ?>paciente/alta.php">
	                                <i class="material-icons">person_add</i>
	                                <span>Alta Paciente</span>
	                            </a>
	                        </li> 
	                        <li <?php if ($ubicacion_url == 'paciente/pendientes.php') { echo 'class="active"'; } ?> >
	                            <a href="<?php echo $ruta; ?>paciente/pendientes.php">
	                                <i class="material-icons">notifications</i>
	                                <span>Pacientes Pendientes</span>
	                            </a>
	                        </li>
	                        <li <?php if ($ubicacion_url == 'paciente/solicitud.php') { echo 'class="active"'; } ?> >
	                            <a href="<?php echo $ruta; ?>paciente/solicitud.php">
	                                <i class="material-icons">assignment</i>
	                                <span>Solicitud Protocolo</span>
	                            </a>
	                        </li> 
	                        <li <?php if ($ubicacion_url == 'paciente/seguimiento.php') { echo 'class="active"'; } ?> >
	                            <a href="<?php echo $ruta; ?>paciente/seguimiento.php">
	                                <i class="material-icons">supervisor_account</i>
	                                <span>Seguimiento</span>
	                            </a>
	                        </li>
	                        <li <?php if ($ubicacion_url == 'paciente/directorio.php') { echo 'class="active"'; } ?> >
	                            <a href="<?php echo $ruta; ?>paciente/directorio.php">
	                                <i class="material-icons">book</i>
	                                <span>Directorio</span>
	                            </a>
	                        </li>	
	                        <li <?php if ($ubicacion_url == 'paciente/historico.php') { echo 'class="active"'; } ?> >
	                            <a href="<?php echo $ruta; ?>paciente/historico.php">
	                                <i class="material-icons">trending_up</i>
	                                <span>Historico Terapias</span>
	                            </a>
	                        </li> 
	                        <li <?php if ($ubicacion_url == 'paciente/agenda.php') { echo 'class="active"'; } ?> >
	                            <a href="<?php echo $ruta; ?>paciente/agenda.php">
	                                <i class="material-icons">event</i>
	                                <span>Agenda</span>
	                            </a>
	                        </li>                 
		                  </ul> 
	                  </li> 
	                <li <?php if ($ubicacion_url == 'reporte/protocolos.php' || $ubicacion_url == 'reporte/tecnicos.php' 
					|| $ubicacion_url == 'reporte/ingresos.php' || $ubicacion_url == 'reporte/cobros.php' ) { echo 'class="active"'; } ?>>
	                    <a href="javascript:void(0);" class="menu-toggle">
	                        <i class="material-icons">assignment</i>
	                        <span>Reportes</span>
	                    </a>
	                    <ul class="ml-menu">
	                        <li <?php if ($ubicacion_url == 'reporte/protocolos.php') { echo 'class="active"'; } ?> >
	                            <a href="<?php echo $ruta; ?>reporte/protocolos.php">
	                                <i class="material-icons">assessment</i>
	                                <span>Reporte de Protocolos</span>
	                            </a>
	                        </li> 
	                        <li <?php if ($ubicacion_url == 'reporte/tecnicos.php') { echo 'class="active"'; } ?> >
	                            <a href="<?php echo $ruta; ?>reporte/tecnicos.php">
	                                <i class="material-icons">assessment</i>
	                                <span>Reporte de Técnicos</span>
	                            </a>
	                        </li>  
	                        <li <?php if ($ubicacion_url == 'reporte/ingresos.php') { echo 'class="active"'; } ?> >
	                            <a href="<?php echo $ruta; ?>reporte/ingresos.php">
	                                <i class="material-icons">assessment</i>
	                                <span>Reporte de Ingresos Egresos</span>
	                            </a>
	                        </li>     
	                        <li <?php if ($ubicacion_url == 'reporte/cobros.php') { echo 'class="active"'; } ?> >
	                            <a href="<?php echo $ruta; ?>reporte/cobros.php">
	                                <i class="material-icons">assessment</i>
	                                <span>Reporte de Cobros</span>
	                            </a>
	                        </li>         
		                  </ul> 
	                  </li> 	
	                <li <?php if ($ubicacion_url == 'caja/corte.php' || $ubicacion_url == 'caja/cobro.php'  || $ubicacion_url == 'caja/pagos.php'
					 || $ubicacion_url == 'caja/fondo.php' || $ubicacion_url == 'caja/retiros.php') { echo 'class="active"'; } ?>>
	                    <a href="javascript:void(0);" class="menu-toggle">
	                        <i class="material-icons">monetization_on</i>
	                        <span>Caja</span>
	                    </a>
	                    <ul class="ml-menu">
	                        <li <?php if ($ubicacion_url == 'caja/cobro.php') { echo 'class="active"'; } ?> >
	                            <a href="<?php echo $ruta; ?>caja/cobro.php">
	                                <i class="material-icons">add_shopping_cart</i>
	                                <span>Cobro</span>
	                            </a>
	                        </li> 
	                        <li <?php if ($ubicacion_url == 'caja/corte.php') { echo 'class="active"'; } ?> >
	                            <a href="<?php echo $ruta; ?>caja/corte.php">
	                                <i class="material-icons">cached</i>
	                                <span>Corte</span>
	                            </a>
	                        </li>  
	                        <li <?php if ($ubicacion_url == 'caja/pagos.php') { echo 'class="active"'; } ?> >
	                            <a href="<?php echo $ruta; ?>caja/pagos.php">
	                                <i class="material-icons">payment</i>
	                                <span>Pagos</span>
	                            </a>
	                        </li>  
	                        <li <?php if ($ubicacion_url == 'caja/retiros.php') { echo 'class="active"'; } ?> >
	                            <a href="<?php echo $ruta; ?>caja/retiros.php">
	                                <i class="material-icons">cached</i>
	                                <span>Retiros</span>
	                            </a>
	                        </li>    
	                        <li <?php if ($ubicacion_url == 'caja/fondo.php') { echo 'class="active"'; } ?> >
	                            <a href="<?php echo $ruta; ?>caja/fondo.php">
	                                <i class="material-icons">monetization_on</i>
	                                <span>Fondo de Caja</span>
	                            </a>
	                        </li>       
		                  </ul> 
	                  </li> 	
	                <li <?php if ($ubicacion_url == 'protocolo/alta.php' || $ubicacion_url == 'protocolo/estatus.php'  || $ubicacion_url == 'protocolo/protocolo.php'
					 || $ubicacion_url == 'protocolo/alta_consultorio.php' || $ubicacion_url == 'protocolo/consultorio.php') { echo 'class="active"'; } ?>>
	                    <a href="javascript:void(0);" class="menu-toggle">
	                        <i class="material-icons">assignment_ind</i>
	                        <span>Protocolos</span>
	                    </a>
	                    <ul class="ml-menu">
	                        <li <?php if ($ubicacion_url == 'protocolo/alta.php') { echo 'class="active"'; } ?> >
	                            <a href="<?php echo $ruta; ?>protocolo/alta.php">
	                                <i class="material-icons">playlist_add</i>
	                                <span>Alta Protocolo</span>
	                            </a>
	                        </li> 
	                        <li <?php if ($ubicacion_url == 'protocolo/estatus.php') { echo 'class="active"'; } ?> >
	                            <a href="<?php echo $ruta; ?>protocolo/estatus.php">
	                                <i class="material-icons">content_paste</i>
	                                <span>Estatus Protocolos</span>
	                            </a>
	                        </li>   
	                        <li <?php if ($ubicacion_url == 'protocolo/protocolo.php') { echo 'class="active"'; } ?> >
	                            <a href="<?php echo $ruta; ?>protocolo/protocolo.php">
	                                <i class="material-icons">receipt</i>
	                                <span>Aplicar Protocolo</span>
	                            </a>
	                        </li>   
	                        <li <?php if ($ubicacion_url == 'protocolo/alta_consultorio.php') { echo 'class="active"'; } ?> >
	                            <a href="<?php echo $ruta; ?>protocolo/alta_consultorio.php">
	                                <i class="material-icons">library_add</i>
	                                <span>Alta de Consultorio TMS</span>
	                            </a>
	                        </li> 
	                        <li <?php if ($ubicacion_url == 'protocolo/consultorio.php') { echo 'class="active"'; } ?> >
	                            <a href="<?php echo $ruta; ?>protocolo/consultorio.php">
	                                <i class="material-icons">library_books</i>
	                                <span>Consultorio TMS</span>
	                            </a>
	                        </li>           
		                  </ul> 
	                  </li> 
	                <li <?php if ($ubicacion_url == 'usuarios/directorio.php' || $ubicacion_url == 'usuarios/alta_medico.php' || $ubicacion_url == 'usuarios/alta_usuario.php' ) { echo 'class="active"'; } ?>>
	                    <a href="javascript:void(0);" class="menu-toggle">
	                        <i class="material-icons">people</i>
	                        <span>Usuarios</span>
	                    </a>
	                    <ul class="ml-menu">
	                        <li <?php if ($ubicacion_url == 'usuarios/directorio.php') { echo 'class="active"'; } ?> >
	                            <a href="<?php echo $ruta; ?>usuarios/directorio.php">
	                                <i class="material-icons">book</i>
	                                <span>Directorio General</span>
	                            </a>
	                        </li> 
	                        <li <?php if ($ubicacion_url == 'usuarios/alta_medico.php') { echo 'class="active"'; } ?> >
	                            <a href="<?php echo $ruta; ?>usuarios/alta_medico.php">
	                                <i class="material-icons">person_add</i>
	                                <span>Agrega Medico</span>
	                            </a>
	                        </li>  
	                        <li <?php if ($ubicacion_url == 'usuarios/alta_usuario.php') { echo 'class="active"'; } ?> >
	                            <a href="<?php echo $ruta; ?>usuarios/alta_usuario.php">
	                                <i class="material-icons">person_add</i>
	                                <span>Agrega Usuarios</span>
	                            </a>
	                        </li>             
		                  </ul> 
	                  </li>                      
	                           
	                <!-- <li <?php if ($ubicacion_url == '../avisos/index.php' || $ubicacion_url == '../acuerdos/index.php' ) { echo 'class="active"'; } ?>>
	                    <a href="javascript:void(0);" class="menu-toggle">
	                        <i class="material-icons">settings</i>
	                        <span>Administracion</span>
	                    </a>
	                    <ul class="ml-menu">
	                        <li <?php if ($ubicacion_url == '../avisos/index.php') { echo 'class="active"'; } ?> >
	                            <a href="<?php echo $ruta; ?>avisos/index.php">
	                                <i class="material-icons">person_add</i>
	                                <span>Alta Paciente</span>
	                            </a>
	                        </li> 
                
		                  </ul> 
	                  </li>  -->   
					<li <?php if ($ubicacion_url == 'analisis/analisis.php') { echo 'class="active"'; } ?> >
                            <a href="<?php echo $ruta; ?>analisis/analisis.php">
                                <i class="material-icons">equalizer</i>
                                <span>Analisis Protocolos</span>
                            </a>
                    </li>  
                </ul>
            </div>
            <!-- #Menu -->
            <!-- Footer -->
            <div class="legal">
                <div class="copyright">
                    &copy; 2023 - 2024 <a href="javascript:void(0);">AdminTMS </a>.
                </div>
                <div class="version">
                    <b>Version: </b> 1.0.5
                </div>
            </div>
            <!-- #Footer -->
        </aside>
        <!-- #END# Left Sidebar -->
        <!-- Right Sidebar -->
        <aside id="rightsidebar" class="right-sidebar">
            <ul class="nav nav-tabs tab-nav-right" role="tablist">
                <li role="presentation" class="active"><a href="#skins" data-toggle="tab">SKINS</a></li>
                <li role="presentation"><a href="#settings" data-toggle="tab">SETTINGS</a></li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active in active" id="skins">
                    <ul class="demo-choose-skin">
                        <li id="red" data-theme="red">
                            <div  class="red" <?php if ($body=='red') { echo 'class="active"'; } ?> ></div>
                            <span id="red">Red</span>
                        </li>
                            <script>
                                $("#red").click(function(){ 
                                    var color_body = 'red';
                                    var ruta = "<?php echo $ruta; ?>";
                                    var user_id = "<?php echo $user_id; ?>";
                                    var datastring = 'color_body='+color_body+'&user_id='+user_id+'&ruta='+ruta;
                                   //alert(datastring);
                                    $.ajax({
                                        url: "<?php echo $ruta; ?>herramientas/body.php",
                                        type: "POST",
                                        data: datastring, 
                                        cache: false,
                                        success:function(html){
                                            //alert(html);
                                             window.location.href = "<?php echo $ruta.$ubicacion_url; ?>";      
                                         }
                                                            });
                                });
                            </script> 
                        <li id="pink" data-theme="pink"  <?php if ($body=='pink') { echo 'class="active"'; } ?> >
                            <div class="pink"></div>
                            <span >Pink</span>
                        </li>
                            <script>
                                $("#pink").click(function(){ 
                                    var color_body = 'pink';
                                    var ruta = "<?php echo $ruta; ?>";
                                    var user_id = "<?php echo $user_id; ?>";
                                    var datastring = 'color_body='+color_body+'&user_id='+user_id+'&ruta='+ruta;
                                    $.ajax({
                                        url: "<?php echo $ruta; ?>herramientas/body.php",
                                        type: "POST",
                                        data: datastring, 
                                        cache: false,
                                        success:function(html){
                                             window.location.href = "<?php echo $ruta.$ubicacion_url; ?>";      
                                         }
                                                            });
                                });
                            </script>
                        <li id="purple" data-theme="purple" <?php if ($body=='purple') { echo 'class="active"'; } ?> >
                            <div class="purple"></div>
                            <span id="purple">Purple</span>
                        </li>
                            <script>
                                $("#purple").click(function(){ 
                                    var color_body = 'purple';
                                    var ruta = "<?php echo $ruta; ?>";
                                    var user_id = "<?php echo $user_id; ?>";
                                    var datastring = 'color_body='+color_body+'&user_id='+user_id+'&ruta='+ruta;
                                    $.ajax({
                                        url: "<?php echo $ruta; ?>herramientas/body.php",
                                        type: "POST",
                                        data: datastring, 
                                        cache: false,
                                        success:function(html){
                                             window.location.href = "<?php echo $ruta.$ubicacion_url; ?>";      
                                         }
                                                           });
                                });
                            </script>
                        <li id="deep-purple" data-theme="deep-purple" <?php if ($body=='deep-purple') { echo 'class="active"'; } ?> >
                            <div class="deep-purple"></div>
                            <span>Deep Purple</span>
                        </li>
                            <script>
                                $("#deep-purple").click(function(){ 
                                    var color_body = 'deep-purple';
                                    var ruta = "<?php echo $ruta; ?>";
                                    var user_id = "<?php echo $user_id; ?>";
                                    var datastring = 'color_body='+color_body+'&user_id='+user_id+'&ruta='+ruta;
                                    $.ajax({
                                        url: "<?php echo $ruta; ?>herramientas/body.php",
                                        type: "POST",
                                        data: datastring, 
                                        cache: false,
                                        success:function(html){
                                             window.location.href = "<?php echo $ruta.$ubicacion_url; ?>";      
                                         }
                                                            });
                                });
                            </script>
                        <li id="indigo" data-theme="indigo" <?php if ($body=='indigo') { echo 'class="active"'; } ?> >
                            <div class="indigo"></div>
                            <span>Indigo</span>
                        </li>
                            <script>
                                $("#indigo").click(function(){ 
                                    var color_body = 'indigo';
                                    var ruta = "<?php echo $ruta; ?>";
                                    var user_id = "<?php echo $user_id; ?>";
                                    var datastring = 'color_body='+color_body+'&user_id='+user_id+'&ruta='+ruta;
                                    $.ajax({
                                        url: "<?php echo $ruta; ?>herramientas/body.php",
                                        type: "POST",
                                        data: datastring, 
                                        cache: false,
                                        success:function(html){
                                             window.location.href = "<?php echo $ruta.$ubicacion_url; ?>";      
                                         }
                                                           });
                                });
                            </script>
                        <li id="blue" data-theme="blue" <?php if ($body=='blue') { echo 'class="active"'; } ?> >
                            <div class="blue"></div>
                            <span>Blue</span>
                        </li>
                            <script>
                                $("#blue").click(function(){ 
                                    var color_body = 'blue';
                                    var ruta = "<?php echo $ruta; ?>";
                                    var user_id = "<?php echo $user_id; ?>";
                                    var datastring = 'color_body='+color_body+'&user_id='+user_id+'&ruta='+ruta;
                                    $.ajax({
                                        url: "<?php echo $ruta; ?>herramientas/body.php",
                                        type: "POST",
                                        data: datastring, 
                                        cache: false,
                                        success:function(html){
                                             window.location.href = "<?php echo $ruta.$ubicacion_url; ?>";      
                                         }
                                     });
                                });
                            </script>
                        <li id="light-blue" data-theme="light-blue" <?php if ($body=='light-blue') { echo 'class="active"'; } ?> >
                            <div class="light-blue"></div>
                            <span>Light Blue</span>
                        </li>
                            <script>
                                $("#light-blue").click(function(){ 
                                    var color_body = 'light-blue';
                                    var ruta = "<?php echo $ruta; ?>";
                                    var user_id = "<?php echo $user_id; ?>";
                                    var datastring = 'color_body='+color_body+'&user_id='+user_id+'&ruta='+ruta;
                                    $.ajax({
                                        url: "<?php echo $ruta; ?>herramientas/body.php",
                                        type: "POST",
                                        data: datastring, 
                                        cache: false,
                                        success:function(html){
                                             window.location.href = "<?php echo $ruta.$ubicacion_url; ?>";      
                                         }
                                                            });
                                });
                            </script>
                        <li id="cyan" data-theme="cyan" <?php if ($body=='cyan') { echo 'class="active"'; } ?> >
                            <div class="cyan"></div>
                            <span>Cyan</span>
                        </li>
                            <script>
                                $("#cyan").click(function(){ 
                                    var color_body = 'cyan';
                                    var ruta = "<?php echo $ruta; ?>";
                                    var user_id = "<?php echo $user_id; ?>";
                                    var datastring = 'color_body='+color_body+'&user_id='+user_id+'&ruta='+ruta;
                                    $.ajax({
                                        url: "<?php echo $ruta; ?>herramientas/body.php",
                                        type: "POST",
                                        data: datastring, 
                                        cache: false,
                                        success:function(html){
                                             window.location.href = "<?php echo $ruta.$ubicacion_url; ?>";      
                                         }
                                                           });
                                });
                            </script>
                        <li id="teal" data-theme="teal" <?php if ($body=='teal') { echo 'class="active"'; } ?> >
                            <div class="teal"></div>
                            <span>Teal</span>
                        </li>
                            <script>
                                $("#teal").click(function(){ 
                                    var color_body = 'teal';
                                    var ruta = "<?php echo $ruta; ?>";
                                    var user_id = "<?php echo $user_id; ?>";
                                    var datastring = 'color_body='+color_body+'&user_id='+user_id+'&ruta='+ruta;
                                    $.ajax({
                                        url: "<?php echo $ruta; ?>herramientas/body.php",
                                        type: "POST",
                                        data: datastring, 
                                        cache: false,
                                        success:function(html){
                                             window.location.href = "<?php echo $ruta.$ubicacion_url; ?>";      
                                         }
                                                           });
                                });
                            </script>
                        <li id="green" data-theme="green" <?php if ($body=='green') { echo 'class="active"'; } ?> >
                            <div class="green"></div>
                            <span>Green</span>
                        </li>
                            <script>
                                $("#green").click(function(){ 
                                    var color_body = 'green';
                                    var ruta = "<?php echo $ruta; ?>";
                                    var user_id = "<?php echo $user_id; ?>";
                                    var datastring = 'color_body='+color_body+'&user_id='+user_id+'&ruta='+ruta;
                                    $.ajax({
                                        url: "<?php echo $ruta; ?>herramientas/body.php",
                                        type: "POST",
                                        data: datastring, 
                                        cache: false,
                                        success:function(html){
                                             window.location.href = "<?php echo $ruta.$ubicacion_url; ?>";      
                                         }
                                                            });
                                });
                            </script>
                        <li id="light-green" data-theme="light-green" <?php if ($body=='light-green') { echo 'class="active"'; } ?> >
                            <div class="light-green"></div>
                            <span>Light Green</span>
                        </li>
                            <script>
                                $("#light-green").click(function(){ 
                                    var color_body = 'light-green';
                                    var ruta = "<?php echo $ruta; ?>";
                                    var user_id = "<?php echo $user_id; ?>";
                                    var datastring = 'color_body='+color_body+'&user_id='+user_id+'&ruta='+ruta;
                                    $.ajax({
                                        url: "<?php echo $ruta; ?>herramientas/body.php",
                                        type: "POST",
                                        data: datastring, 
                                        cache: false,
                                        success:function(html){
                                             window.location.href = "<?php echo $ruta.$ubicacion_url; ?>";      
                                         }
                                                           });
                                });
                            </script>
                        <li id="lime" data-theme="lime" <?php if ($body=='lime') { echo 'class="active"'; } ?> >
                            <div class="lime"></div>
                            <span>Lime</span>
                        </li>
                            <script>
                                $("#lime").click(function(){ 
                                    var color_body = 'lime';
                                    var ruta = "<?php echo $ruta; ?>";
                                    var user_id = "<?php echo $user_id; ?>";
                                    var datastring = 'color_body='+color_body+'&user_id='+user_id+'&ruta='+ruta;
                                    $.ajax({
                                        url: "<?php echo $ruta; ?>herramientas/body.php",
                                        type: "POST",
                                        data: datastring, 
                                        cache: false,
                                        success:function(html){
                                             window.location.href = "<?php echo $ruta.$ubicacion_url; ?>";      
                                         }
                                                           });
                                });
                            </script>
                        <li id="yellow" data-theme="yellow" <?php if ($body=='yellow') { echo 'class="active"'; } ?> >
                            <div class="yellow"></div>
                            <span>Yellow</span>
                        </li>
                            <script>
                                $("#yellow").click(function(){ 
                                    var color_body = 'yellow';
                                    var ruta = "<?php echo $ruta; ?>";
                                    var user_id = "<?php echo $user_id; ?>";
                                    var datastring = 'color_body='+color_body+'&user_id='+user_id+'&ruta='+ruta;
                                    $.ajax({
                                        url: "<?php echo $ruta; ?>herramientas/body.php",
                                        type: "POST",
                                        data: datastring, 
                                        cache: false,
                                        success:function(html){
                                             window.location.href = "<?php echo $ruta.$ubicacion_url; ?>";      
                                         }
                                                           });
                                });
                            </script>
                        <li id="amber" data-theme="amber" <?php if ($body=='amber') { echo 'class="active"'; } ?> >
                            <div class="amber"></div>
                            <span>Amber</span>
                        </li>
                            <script>
                                $("#amber").click(function(){ 
                                    var color_body = 'yeamberllow';
                                    var ruta = "<?php echo $ruta; ?>";
                                    var user_id = "<?php echo $user_id; ?>";
                                    var datastring = 'color_body='+color_body+'&user_id='+user_id+'&ruta='+ruta;
                                    $.ajax({
                                        url: "<?php echo $ruta; ?>herramientas/body.php",
                                        type: "POST",
                                        data: datastring, 
                                        cache: false,
                                        success:function(html){
                                             window.location.href = "<?php echo $ruta.$ubicacion_url; ?>";      
                                         }
                                                           });
                                });
                            </script>
                        <li id="orange" data-theme="orange" <?php if ($body=='orange') { echo 'class="active"'; } ?> >
                            <div class="orange"></div>
                            <span>Orange</span>
                        </li>
                            <script>
                                $("#orange").click(function(){ 
                                    var color_body = 'orange';
                                    var ruta = "<?php echo $ruta; ?>";
                                    var user_id = "<?php echo $user_id; ?>";
                                    var datastring = 'color_body='+color_body+'&user_id='+user_id+'&ruta='+ruta;
                                    $.ajax({
                                        url: "<?php echo $ruta; ?>herramientas/body.php",
                                        type: "POST",
                                        data: datastring, 
                                        cache: false,
                                        success:function(html){
                                             window.location.href = "<?php echo $ruta.$ubicacion_url; ?>";      
                                         }
                                                           });
                                });
                            </script>
                        <li id="deep-orange" data-theme="deep-orange" <?php if ($body=='deep-orange') { echo 'class="active"'; } ?> >
                            <div class="deep-orange"></div>
                            <span>Deep Orange</span>
                        </li>
                            <script>
                                $("#deep-orange").click(function(){ 
                                    var color_body = 'deep-orange';
                                    var ruta = "<?php echo $ruta; ?>";
                                    var user_id = "<?php echo $user_id; ?>";
                                    var datastring = 'color_body='+color_body+'&user_id='+user_id+'&ruta='+ruta;
                                    $.ajax({
                                        url: "<?php echo $ruta; ?>herramientas/body.php",
                                        type: "POST",
                                        data: datastring, 
                                        cache: false,
                                        success:function(html){  
                                             window.location.href = "<?php echo $ruta.$ubicacion_url; ?>";    
                                         }
                                                           });
                                });
                            </script>
                        <li id="brown" data-theme="brown" <?php if ($body=='brown') { echo 'class="active"'; } ?> >
                            <div class="brown"></div>
                            <span>Brown</span>
                        </li>
                            <script>
                                $("#brown").click(function(){ 
                                    var color_body = 'brown';
                                    var ruta = "<?php echo $ruta; ?>";
                                    var user_id = "<?php echo $user_id; ?>";
                                    var datastring = 'color_body='+color_body+'&user_id='+user_id+'&ruta='+ruta;
                                    $.ajax({
                                        url: "<?php echo $ruta; ?>herramientas/body.php",
                                        type: "POST",
                                        data: datastring, 
                                        cache: false,
                                        success:function(html){ 
                                             window.location.href = "<?php echo $ruta.$ubicacion_url; ?>";     
                                         }
                                                           });
                                });
                            </script>
                        <li id="grey" data-theme="grey" <?php if ($body=='grey') { echo 'class="active"'; } ?> >
                            <div class="grey"></div>
                            <span>Grey</span>
                        </li>
                            <script>
                                $("#grey").click(function(){ 
                                    var color_body = 'grey';
                                    var ruta = "<?php echo $ruta; ?>";
                                    var user_id = "<?php echo $user_id; ?>";
                                    var datastring = 'color_body='+color_body+'&user_id='+user_id+'&ruta='+ruta;
                                    $.ajax({
                                        url: "<?php echo $ruta; ?>herramientas/body.php",
                                        type: "POST",
                                        data: datastring, 
                                        cache: false,
                                        success:function(html){ 
                                             window.location.href = "<?php echo $ruta.$ubicacion_url; ?>";     
                                         }
                                                           });
                                });
                            </script>
                        <li id="blue-grey" data-theme="blue-grey" <?php if ($body=='blue-grey') { echo 'class="active"'; } ?> >
                            <div class="blue-grey"></div>
                            <span>Blue Grey</span>
                        </li>
                            <script>
                                $("#blue-grey").click(function(){ 
                                    var color_body = 'blue-grey';
                                    var ruta = "<?php echo $ruta; ?>";
                                    var user_id = "<?php echo $user_id; ?>";
                                    var datastring = 'color_body='+color_body+'&user_id='+user_id+'&ruta='+ruta;
                                    $.ajax({
                                        url: "<?php echo $ruta; ?>herramientas/body.php",
                                        type: "POST",
                                        data: datastring, 
                                        cache: false,
                                        success:function(html){ 
                                             window.location.href = "<?php echo $ruta.$ubicacion_url; ?>";     
                                         }
                                                    });
                                });
                            </script>
                        <li id="black" data-theme="black" <?php if ($body=='black') { echo 'class="active"'; } ?> >
                            <div class="black"></div>
                            <span>Black</span>
                        </li>
                            <script>
                                $("#black").click(function(){ 
                                    var color_body = 'black';
                                    var ruta = "<?php echo $ruta; ?>";
                                    var user_id = "<?php echo $user_id; ?>";
                                    var datastring = 'color_body='+color_body+'&user_id='+user_id+'&ruta='+ruta;
                                    $.ajax({
                                        url: "<?php echo $ruta; ?>herramientas/body.php",
                                        type: "POST",
                                        data: datastring, 
                                        cache: false,
                                        success:function(html){  
                                            window.location.href = "<?php echo $ruta.$ubicacion_url; ?>";   
                                         }

                                        });
                                });
                            </script>
                    </ul>
                    
                </div>
                <div role="tabpanel" class="tab-pane fade" id="settings">
                    <div class="demo-settings">
                        <p>GENERAL SETTINGS</p>
                        <ul class="setting-list">
                            <li>
                                <span>Report Panel Usage</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever switch-col-<?php echo $body; ?>"></span></label>
                                </div>
                            </li>
                            <li>
                                <span>Email Redirect</span>
                                <div class="switch">
                                    <label><input type="checkbox"><span class="lever switch-col-<?php echo $body; ?>"></span></label>
                                </div>
                            </li>
                        </ul>
                        <p>SYSTEM SETTINGS</p>
                        <ul class="setting-list">
                            <li>
                                <span>Notifications</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever switch-col-<?php echo $body; ?>"></span></label>
                                </div>
                            </li>
                            <li>
                                <span>Auto Updates</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever switch-col-<?php echo $body; ?>"></span></label>
                                </div>
                            </li>
                        </ul>
                        <p>ACCOUNT SETTINGS</p>
                        <ul class="setting-list">
                            <li>
                                <span>Offline</span>
                                <div class="switch">
                                    <label><input type="checkbox"><span class="lever switch-col-<?php echo $body; ?>"></span></label>
                                </div>
                            </li>
                            <li>
                                <span>Location Permission</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever switch-col-<?php echo $body; ?>"></span></label>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </aside>
        <!-- #END# Right Sidebar -->
    </section>




