<?php
session_start();
error_reporting(7);
iconv_set_encoding('internal_encoding', 'utf-8'); 
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Monterrey');
setlocale(LC_TIME, 'es_ES.UTF-8');
$_SESSION['time']=mktime();
extract($_SESSION);
extract($_GET);
extract($_POST);
// print_r($_SESSION);
// print_r($_POST);
// print_r($_GET);
//$body="indigo";
$ubicacion_url = $_SERVER['PHP_SELF']; 
$ubicacion_url ='..'.$ubicacion_url;

include($ruta.'functions/funciones_mysql.php');

echo "<hr> hola mundo 1";
////$obj=new Mysql;
$mktime=mktime();
  function OptieneMesLargo($mes){
   
            if ($mes == 1  || $mes == '1' || $mes == '01') { $xmes = 'Enero'; }
            if ($mes == 2  || $mes == '2' || $mes == '02') { $xmes = 'Febrero'; }   
            if ($mes == 3  || $mes == '3' || $mes == '03') { $xmes = 'Marzo'; } 
            if ($mes == 4  || $mes == '4' || $mes == '04') { $xmes = 'Abril'; } 
            if ($mes == 5  || $mes == '5' || $mes == '05') { $xmes = 'Mayo'; }  
            if ($mes == 6  || $mes == '6' || $mes == '06') { $xmes = 'Junio'; } 
            if ($mes == 7  || $mes == '7' || $mes == '07') { $xmes = 'Julio'; } 
            if ($mes == 8  || $mes == '8' || $mes == '08') { $xmes = 'Agosto'; }    
            if ($mes == 9  || $mes == '9' || $mes == '09') { $xmes = 'Septiembre'; }    
            if ($mes == 10 || $mes == '10' ){ $xmes = 'Octubre'; }  
            if ($mes == 11 || $mes == '11' ){ $xmes = 'Noviembre'; }    
            if ($mes == 12 || $mes == '12' ){ $xmes = 'Diciembre'; }  
        return $xmes;       
    } 
  function OptieneMesCorto($mes){
            if ($mes == 1  || $mes == '1' || $mes == '01') { $xmes = 'Ene'; }
        if ($mes == 2  || $mes == '2' || $mes == '02') { $xmes = 'Feb'; }   
        if ($mes == 3  || $mes == '3' || $mes == '03') { $xmes = 'Mar'; }   
        if ($mes == 4  || $mes == '4' || $mes == '04') { $xmes = 'Abr'; }   
        if ($mes == 5  || $mes == '5' || $mes == '05') { $xmes = 'May'; }   
        if ($mes == 6  || $mes == '6' || $mes == '06') { $xmes = 'Jun'; }   
        if ($mes == 7  || $mes == '7' || $mes == '07') { $xmes = 'Jul'; }   
        if ($mes == 8  || $mes == '8' || $mes == '08') { $xmes = 'Ago'; }   
        if ($mes == 9  || $mes == '9' || $mes == '09') { $xmes = 'Sep'; }   
        if ($mes == 10 || $mes == '10' ){ $xmes = 'Oct'; }  
        if ($mes == 11 || $mes == '11' ){ $xmes = 'Nov'; }  
        if ($mes == 12 || $mes == '12' ){ $xmes = 'Dic'; }  
    return $xmes;       
} 
echo "<hr> hola mundo 2";

if ($sesion <>"On") { echo "<hr> hola mundo 2.5"; ?>
<html>
    <head>
        <meta http-equiv="refresh" content="0; url=index.html">
    </head>
    <body>
    </body>
</html>
<?php	
}
echo "<hr> hola mundo 3";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title><?php echo $title; ?></title>
    
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>   
    <!-- <script src="<?php echo $ruta; ?>js/jquery-3.3.1.min.js"></script>  -->
    <!-- Favicon-->
    <!-- <link rel="icon" href="<?php echo valida_fotos_heder($ruta.'images/icon.jpg',$ruta); ?>" type="image/x-icon"> -->

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="<?php echo $ruta; ?>plugins/bootstrap/css/bootstrap.css?<?php echo $mktime; ?>" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="<?php echo $ruta; ?>plugins/node-waves/waves.css?<?php echo $mktime; ?>" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="<?php echo $ruta; ?>plugins/animate-css/animate.css?<?php echo $mktime; ?>" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="<?php echo $ruta; ?>css/style.css?<?php echo $mktime; ?>" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="<?php echo $ruta; ?>css/themes/all-themes.css?<?php echo $mktime; ?>" rel="stylesheet" />
    
    
    <!-- Sweetalert Css -->
    <link href="<?php echo $ruta; ?>plugins/sweetalert/sweetalert.css?<?php echo $mktime; ?>" rel="stylesheet" />



    <!-- Bootstrap DatePicker Css -->
    <link href="<?php echo $ruta; ?>plugins/bootstrap-datepicker/css/bootstrap-datepicker.css?<?php echo $mktime; ?>" rel="stylesheet" />

    <!-- Wait Me Css -->
    <link href="<?php echo $ruta; ?>plugins/waitme/waitMe.css?<?php echo $mktime; ?>" rel="stylesheet" />

    <!-- Bootstrap Select Css -->
    <link href="<?php echo $ruta; ?>plugins/bootstrap-select/css/bootstrap-select.css?<?php echo $mktime; ?>" rel="stylesheet" /> 




</head>
    **hola
<!--calendario-->
<?php
echo "<hr> hola mundo 4";
 ?>
    
</head>

<body class="theme-<?php echo $body; ?>">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Espere por favor...</p>
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
                <a class="navbar-brand" href="<?php echo $ruta; ?>inicio.php">&nbsp;&nbsp;Coto Bahía de Banderas 2784</a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <!-- Call Search -->
                    <!-- <li><a href="javascript:void(0);" class="js-search" data-close="true"><i class="material-icons">search</i></a></li> -->
                    <!-- #END# Call Search -->
                    <!-- Notifications -->
                    <!-- <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                            <i class="material-icons">notifications_active</i>
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
                                            <div class="icon-circle bg-red">
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
                    </li> -->
                    <!-- #END# Notifications -->
                    <!-- Tasks -->
                    <!-- <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                            <i class="material-icons">flag</i>
                            <span class="label-count">9</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">TASKS</li>
                            <li class="body">
                                <ul class="menu tasks">
                                    <li>
                                        <a href="javascript:void(0);">
                                            <h4>
                                                Footer display issue
                                                <small>32%</small>
                                            </h4>
                                            <div class="progress">
                                                <div class="progress-bar bg-pink" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 32%">
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <h4>
                                                Make new buttons
                                                <small>45%</small>
                                            </h4>
                                            <div class="progress">
                                                <div class="progress-bar bg-cyan" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 45%">
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <h4>
                                                Create new dashboard
                                                <small>54%</small>
                                            </h4>
                                            <div class="progress">
                                                <div class="progress-bar bg-teal" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 54%">
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <h4>
                                                Solve transition issue
                                                <small>65%</small>
                                            </h4>
                                            <div class="progress">
                                                <div class="progress-bar bg-orange" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 65%">
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <h4>
                                                Answer GitHub questions
                                                <small>92%</small>
                                            </h4>
                                            <div class="progress">
                                                <div class="progress-bar bg-purple" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 92%">
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="footer">
                                <a href="javascript:void(0);">View All Tasks</a>
                            </li>
                        </ul>
                    </li> -->
                    <!-- #END# Tasks -->
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
                <div style="width: 100%" class="row">
                
                    <div>
                        <div align="center" class="col-md-12"><img id="logo_header" align="center" src="<?php echo valida_fotos_heder($ruta."images/coto.png",$ruta); ?>" width="auto" height="70" alt="Logo" /></div>
                        <!-- <div  class="image" class="col-md-3"><img id="user_header" src="<?php echo valida_fotos_heder($ruta.$foto_user,$ruta); ?>" width="48" height="48" alt="User" /></div> -->
                    </div>
                    
                    
                </div>
                <div class="info-container">
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $nombre_corto; ?></div>
                    <div class="email"><?php echo $email; ?></div>
                    <!-- <div class="btn-group user-helper-dropdown">
                        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="<?php echo $ruta; ?>herramientas/index.php"><i class="material-icons">person</i>Perfil</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="javascript:void(0);"><i class="material-icons">group</i>Socios</a></li>
                            <li><a href="javascript:void(0);"><i class="material-icons">shopping_cart</i>Ventas</a></li>
                            <li><a href="javascript:void(0);"><i class="material-icons">favorite</i>Activos</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="<?php echo $ruta; ?>index.html"><i class="material-icons">input</i>Cerrar Sesión</a></li>
                        </ul>
                    </div> -->
                </div>
            </div>
            <!-- #User Info -->
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li class="header">Menú de Navegación</li>
                    <li <?php if ($ubicacion_url == $ruta.'../inicio.php') { echo 'class="active"'; } ?> >
                        
                        <a href="<?php echo $ruta; ?>inicio.php">
                            <i class="material-icons">home</i>
                            <span>Inicio </span>
                        </a>
                    </li>
                    <?php if ($funcion <> 'NINGUNA') { ?>
                    <li <?php if ($ubicacion_url == '../avisos/avisos.php' || $ubicacion_url == '../acuerdos/acuerdos.php' 
                    || $ubicacion_url == '../entradas/cobros.php' || $ubicacion_url == '../gastos/pagos.php'
                    || $ubicacion_url == '../entradas/fondo.php' || $ubicacion_url == '../herramientas/proyectos.php'
                    || $ubicacion_url == '../entradas/movimientos.php' || $ubicacion_url == '../entradas/movimientos_personal.php' 
                    || $ubicacion_url == '../herramientas/usuarios.php' || $ubicacion_url == '../entradas/transferencia.php') { echo 'class="active"'; } ?>>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">settings</i>
                            <span>Administración</span>
                        </a>
                        <ul class="ml-menu">
                            <li <?php if ($ubicacion_url == '../entradas/cobros.php') { echo 'class="active"'; } ?>>
                                <a href="<?php echo $ruta; ?>entradas/cobros.php">
                                    <i class="material-icons">add_shopping_cart</i>
                                    <span>Cobrar</span>
                                </a>
                            </li>
                            <li <?php if ($ubicacion_url == '../gastos/pagos.php') { echo 'class="active"'; } ?>>
                                <a href="<?php echo $ruta; ?>gastos/pagos.php">
                                    <i class="material-icons">payment</i>
                                    <span>Pagar</span>
                                </a>
                            </li>
                            <li <?php if ($ubicacion_url == '../entradas/transferencia.php') { echo 'class="active"'; } ?>>
                                <a href="<?php echo $ruta; ?>entradas/transferencia.php">
                                    <i class="material-icons">cached</i>
                                    <span>Transferir</span>
                                </a>
                            </li>
                            <li <?php if ($ubicacion_url == '../coto-2784/entradas/movimientos_personal.php') { echo 'class="active"'; } ?>>
                                <a href="<?php echo $ruta; ?>entradas/movimientos_personal.php">
                                    <i class="material-icons">assessment</i>
                                    <span>Movimiento Personal</span>
                                </a>
                            </li>
                            <?php if ($funcion == 'ADMINISTRADOR' || $funcion == 'SECRETARIO') { ?>
                                <li <?php if ($ubicacion_url == '../coto-2784/avisos/avisos.php') { echo 'class="active"'; } ?>>
                                    <a href="<?php echo $ruta; ?>avisos/avisos.php">
                                        <i class="material-icons">announcement</i>
                                        <span>Guardar Aviso</span>
                                    </a>
                                </li>
                                <li <?php if ($ubicacion_url == '../coto-2784/acuerdos/acuerdos.php') { echo 'class="active"'; } ?>>
                                    <a href="<?php echo $ruta; ?>acuerdos/acuerdos.php">
                                        <i class="material-icons">assignment_turned_in</i>
                                        <span>Guardar Acuerdos</span>
                                    </a>
                                </li>
                                <li <?php if ($ubicacion_url == '../coto-2784/entradas/fondo.php') { echo 'class="active"'; } ?>>
                                    <a href="<?php echo $ruta; ?>entradas/fondo.php">
                                        <i class="material-icons">monetization_on</i>
                                        <span>Fondo de caja</span>
                                    </a>
                                </li>
                                <li <?php if ($ubicacion_url == '../coto-2784/entradas/movimientos.php') { echo 'class="active"'; } ?>>
                                    <a href="<?php echo $ruta; ?>entradas/movimientos.php">
                                        <i class="material-icons">assessment</i>
                                        <span>Movimientos</span>
                                    </a>
                                </li>

                                <li <?php if ($ubicacion_url == '../coto-2784/herramientas/proyectos.php') { echo 'class="active"'; } ?>>
                                    <a href="<?php echo $ruta; ?>herramientas/proyectos.php">
                                        <i class="material-icons">assignment</i>
                                        <span>Proyectos</span>
                                    </a>
                                </li>
                                <li <?php if ($ubicacion_url == '../coto-2784/herramientas/usuarios.php') { echo 'class="active"'; } ?>>
                                    <a href="<?php echo $ruta; ?>herramientas/usuarios.php">
                                        <i class="material-icons">people</i>
                                        <span>Usuarios</span>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                    <?php  } ?>
                    <!-- <li <?php if ($ubicacion_url == '../calendario/index.php') { echo 'class="active"'; } ?> >
                        <a href="<?php echo $ruta; ?>calendario/index.php">
                            <i class="material-icons">query_builder</i>
                            <span>Calendario</span>
                        </a>
                    </li> -->
                    
                    <li <?php if ($ubicacion_url == '../avisos/index.php' || $ubicacion_url == '../acuerdos/index.php' ) { echo 'class="active"'; } ?>>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">notifications</i>
                            <span>Notificaciones</span>
                        </a>
                        <ul class="ml-menu">
                            <li <?php if ($ubicacion_url == '../avisos/index.php') { echo 'class="active"'; } ?> >
                                <a href="<?php echo $ruta; ?>avisos/index.php">
                                    <i class="material-icons">notifications</i>
                                    <span>Avisos</span>
                                </a>
                            </li> 
                            <li <?php if ($ubicacion_url == '../acuerdos/index.php') { echo 'class="active"'; } ?> >
                                <a href="<?php echo $ruta; ?>acuerdos/index.php">
                                    <i class="material-icons">monetization_on</i>
                                    <span>Acuerdos de juntas</span>
                                </a>
                            </li>
                    
                        </ul>
                    <li <?php if ($ubicacion_url == '../entradas/index.php' || $ubicacion_url == '../gastos/index.php' 
                     || $ubicacion_url == '../entradas/aportaciones.php' ) { echo 'class="active"'; } ?>>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">monetization_on</i>
                            <span>Aportaciones</span>
                        </a>
                        <ul class="ml-menu">
                            <li <?php if ($ubicacion_url == '../entradas/balance.php') { echo 'class="active"'; } ?> >
                                <a href="<?php echo $ruta; ?>entradas/balance.php">
                                    <i class="material-icons">assignment_turned_in</i>
                                    <span>Balance</span>
                                </a>
                            </li>
                            <li <?php if ($ubicacion_url == '../entradas/index.php') { echo 'class="active"'; } ?> >
                                <a href="<?php echo $ruta; ?>entradas/index.php">
                                    <i class="material-icons">assignment_turned_in</i>
                                    <span>Entradas</span>
                                </a>
                            </li>
                            <li <?php if ($ubicacion_url == '../gastos/index.php') { echo 'class="active"'; } ?> >
                                <a href="<?php echo $ruta; ?>gastos/index.php">
                                    <i class="material-icons">assignment_turned_in</i>
                                    <span>Gastos</span>
                                </a>
                            </li>
                            <li <?php if ($ubicacion_url == '../entradas/aportaciones.php') { echo 'class="active"'; } ?> >
                                <a href="<?php echo $ruta; ?>entradas/aportaciones.php">
                                    <i class="material-icons">monetization_on</i>
                                    <span>Aportaciones</span>
                                </a>
                            </li>
                        </ul>
                    <li <?php if ($ubicacion_url == $ruta.'../password.php') { echo 'class="active"'; } ?> >
                        
                        <a href="<?php echo $ruta; ?>password.php">
                            <i class="material-icons">lock</i>
                            <span>Cambio Contraseña </span>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- #Menu -->
            <!-- Footer -->
            <div class="legal">
                <div class="copyright">
                    &copy; <?php echo date("Y"); ?> <a target="_blank" href="http://sanzintelligentsystems.com/">Sanz Intelligent Systems</b> </a>.<br>Elaborado por Leonardo Sanz
                </div>
                <div class="version">
                    <b>Versión: </b> <?php echo $version; ?>
                </div>
            </div>
            <!-- #Footer -->
        </aside>
        <!-- #END# Left Sidebar -->
        <!-- Right Sidebar -->
        <aside id="rightsidebar" class="right-sidebar">
            <ul class="nav nav-tabs tab-nav-right" role="tablist">
                <li role="presentation" class="active"><a href="#skins" data-toggle="tab">SKINS</a></li>
                <!-- <li role="presentation"><a href="#settings" data-toggle="tab">SETTINGS</a></li> -->
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
                                             window.location.href = "<?php echo "../".$ubicacion_url; ?>";      
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
                                             window.location.href = "<?php echo "../".$ubicacion_url; ?>";      
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
                                             window.location.href = "<?php echo "../".$ubicacion_url; ?>";      
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
                                             window.location.href = "<?php echo "../".$ubicacion_url; ?>";      
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
                                             window.location.href = "<?php echo "../".$ubicacion_url; ?>";      
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
                                             window.location.href = "<?php echo "../".$ubicacion_url; ?>";      
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
                                             window.location.href = "<?php echo "../".$ubicacion_url; ?>";      
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
                                             window.location.href = "<?php echo "../".$ubicacion_url; ?>";      
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
                                             window.location.href = "<?php echo "../".$ubicacion_url; ?>";      
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
                                             window.location.href = "<?php echo "../".$ubicacion_url; ?>";      
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
                                             window.location.href = "<?php echo "../".$ubicacion_url; ?>";      
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
                                             window.location.href = "<?php echo "../".$ubicacion_url; ?>";      
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
                                             window.location.href = "<?php echo "../".$ubicacion_url; ?>";      
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
                                             window.location.href = "<?php echo "../".$ubicacion_url; ?>";      
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
                                             window.location.href = "<?php echo "../".$ubicacion_url; ?>";      
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
                                             window.location.href = "<?php echo "../".$ubicacion_url; ?>";    
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
                                             window.location.href = "<?php echo "../".$ubicacion_url; ?>";     
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
                                             window.location.href = "<?php echo "../".$ubicacion_url; ?>";     
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
                                             window.location.href = "<?php echo "../".$ubicacion_url; ?>";     
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
                                            window.location.href = "<?php echo "../".$ubicacion_url; ?>";   
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
    <?php print_r($_SESSION); ?>