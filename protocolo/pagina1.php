<!DOCTYPE HTML>
<html>

<head>
    <meta charset="UTF-8">
    <html lang="es">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Pagina</title>
    
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>   
    <!-- <script src="../js/jquery-3.3.1.min.js"></script>  -->    
    <!-- Favicon-->
    <link rel="icon" href="../images/logo_aldana_tc.png" type="image/png">
    <!--<link rel="icon" href="../images/logo_aldana_tc.png" type="image/x-icon">-->

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="../plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="../plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="../plugins/animate-css/animate.css" rel="stylesheet" />
      
    <!-- Custom Css -->
    <link href="../css/style.css" rel="stylesheet">

    <!-- AdminTMS Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="../css/themes/all-themes.css" rel="stylesheet" />

    <style>
        /* CSS adicional para manejar la expansión del contenido */
        .content-expanded {
            margin-left: 0 !important;
            width: 100% !important;
        }
    </style>
</head>

<body class="theme-teal">
    <!-- Page Loader -->
    <!-- <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-teal">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Espere por favor cargando...</p>
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
                <a class="navbar-brand" href="../menu.php">Admin<b>Neuromodulación</b> - Sistema de administración de Neuromodulacion GDL</a>
                <button id="toggle-menu" class="btn btn-primary">Ocultar/Mostrar Menú</button>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <!-- Notifications -->
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                            <i class="material-icons">notifications</i>
                            <span class="label-count">0</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">NOTIFICACIONES</li>
                            <li class="body">
                                <ul class="menu">
                                                                            
                                    <li>
                                        <a href="../paciente/pendientes.php">
                                            <div class="icon-circle bg-light-green">
                                                <i class="material-icons">notifications</i> <!--event-->
                                            </div>
                                            <div class="menu-info">
                                                <h4>0 nuevos pacientes</h4>
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
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: white"><b></b></div>
                    <div class="email"  style="color: white"><b>sanzaleonardo@hotmail.com</b></div>
                    <div class="btn-group user-helper-dropdown">
                        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="..//usuarios/perfil.php"><i class="material-icons">person</i>Perfil</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="../cerrar_sesion.php"><i class="material-icons">input</i>Cierre de Sesión</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- #User Info -->
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li class="header">Menú de Navegación</li>
                    <li>
                        <a href="../menu.php">
                            <i class="material-icons">home</i>
                            <span>Inicio</span>
                        </a>
                    </li>  
                        
                    <li>
                        <a href="../reporte/dashboard.php">
                            <i class="material-icons">dashboard</i>
                            <span>Dashboard</span>
                        </a>
                    </li> 
                                        
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">assignment_ind</i>
                            <span>Pacientes</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="../paciente/alta.php">
                                    <i class="material-icons">person_add</i>
                                    <span>Alta Paciente</span>
                                </a>
                            </li> 
                            <li>
                                <a href="../paciente/pendientes.php">
                                    <i class="material-icons">notifications</i>
                                    <span>Pacientes Pendientes</span>
                                </a>
                            </li>
                            <li>
                                <a href="../paciente/seguimientos.php">
                                    <i class="material-icons">notifications</i>
                                    <span>Seguimientos</span>
                                </a>
                            </li>
                            <li>
                                <a href="../paciente/directorio.php">
                                    <i class="material-icons">book</i>
                                    <span>Pacientes</span>
                                </a>
                            </li>
                            <li>
                                <a href="../agenda/agenda.php">
                                    <i class="material-icons">event</i>
                                    <span>Agenda Neuromodulación</span>
                                </a>
                            </li>
                        </ul> 
                    </li> 
                      
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">assignment</i>
                            <span>Reportes</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="../reporte/protocolos.php">
                                    <i class="material-icons">assessment</i>
                                    <span>Reporte de Protocolos</span>
                                </a>
                            </li> 
                            <li>
                                <a href="../reporte/tecnicos.php">
                                    <i class="material-icons">assessment</i>
                                    <span>Reporte de Técnicos</span>
                                </a>
                            </li>  
                        </ul> 
                    </li>
 
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">assignment</i>
                            <span>Reportes Financieros</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="../caja/administracion.php">
                                    <i class="material-icons">monetization_on</i>
                                    <span>Administración</span>
                                </a>
                            </li>     
                            <li>
                                <a href="../caja/movimientos.php">
                                    <i class="material-icons">monetization_on</i>
                                    <span>Movimientos Efectivo</span>
                                </a>
                            </li>    
                            <li>
                                <a href="javascript:void(0);" class="menu-toggle">
                                    <i class="material-icons">monetization_on</i>
                                    <span>Balance por Mes</span>
                                </a>
                                <ul class="ml-menu">
                                    <li>
                                        <a href="../caja/balance_mes.php?us=Neuromodulacion GDL">
                                            <span>Neuromodulacion GDL</span>
                                        </a>
                                    </li>                        
                                    <li>
                                        <a href="../caja/balance_mes.php?us=Dr. Alejandro Aldana">
                                            <span>Dr. Alejandro Aldana</span>
                                        </a>
                                    </li>                                          
                                </ul>
                            </li>                                
                            <li>
                                <a href="../caja/fondo.php">
                                    <i class="material-icons">monetization_on</i>
                                    <span>Fondo de Cajas</span>
                                </a>
                            </li>
                        </ul> 
                    </li>
                                         
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">monetization_on</i>
                            <span>Caja</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="../caja/cobro.php">
                                    <i class="material-icons">add_shopping_cart</i>
                                    <span>Cobro</span>
                                </a>
                            </li>
                            <li>
                                <a href="../caja/pagos.php">
                                    <i class="material-icons">payment</i>
                                    <span>Pagos</span>
                                </a>
                            </li>                                  
                            <li>
                                <a href="../caja/corte.php">
                                    <i class="material-icons">cached</i>
                                    <span>Corte</span>
                                </a>
                            </li>  
                        </ul> 
                    </li> 
                                          
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">assignment_ind</i>
                            <span>Protocolos</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="../protocolo/clinimetria.php">
                                    <i class="material-icons">playlist_add</i>
                                    <span>Alta Clinimetria</span>
                                </a>
                            </li>
                            <li>
                                <a href="../protocolo/catalogo_clinimetria.php">
                                    <i class="material-icons">content_paste</i>
                                    <span>Clinimetrias</span>
                                </a>
                            </li>                             
                            <li>
                                <a href="../protocolo/estatus.php">
                                    <i class="material-icons">content_paste</i>
                                    <span>Estatus Protocolos</span>
                                </a>
                            </li> 
                            <li>
                                <a href="../protocolo/protocolo.php">
                                    <i class="material-icons">receipt</i>
                                    <span>Aplicar Protocolo</span>
                                </a>
                            </li>
                        </ul> 
                    </li> 
                                           
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">people</i>
                            <span>Usuarios</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="../usuarios/directorio.php">
                                    <i class="material-icons">book</i>
                                    <span>Medico</span>
                                </a>
                            </li> 
                            <li>
                                <a href="../usuarios/alta_medico.php">
                                    <i class="material-icons">person_add</i>
                                    <span>Alta Medico o Usuario</span>
                                </a>
                            </li>  
                            <li>
                                <a href="../usuarios/genera_invitacion.php">
                                    <i class="material-icons">person_add</i>
                                    <span>Invitación de Usuario</span>
                                </a>
                            </li>           
                        </ul> 
                    </li>                      
                        
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">settings</i>
                            <span>Seguimientos Sistema</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="../seguimientos/index.php">
                                    <i class="material-icons">settings</i>
                                    <span>Solicitud a Sistemas</span>
                                </a>
                            </li> 
                            <li>
                                <a href="../seguimientos/seguimientos.php">
                                    <i class="material-icons">build</i>
                                    <span>Seguimientos</span>
                                </a>
                            </li>  
                        </ul> 
                    </li>                      
                                          
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">web</i>
                            <span>Pagina Web</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="../noticias/carrusel.php">
                                    <i class="material-icons">desktop_mac</i>
                                    <span>Carrusel</span>
                                </a>
                            </li> 
                            <li>
                                <a href="../noticias/personal.php">
                                    <i class="material-icons">desktop_mac</i>
                                    <span>Personal</span>
                                </a>
                            </li> 
                            <li>
                                <a href="javascript:void(0);" class="menu-toggle">
                                    <span>Noticias</span>
                                </a>
                                <ul class="ml-menu">
                                    <li>
                                        <a href="../noticias/directorio.php">
                                            <i class="material-icons">assignment</i>
                                            <span>Noticias</span>
                                        </a>
                                    </li> 
                                    <li>
                                        <a href="../noticias/alta.php">
                                            <i class="material-icons">note_add</i>
                                            <span>Alta Noticias</span>
                                        </a>
                                    </li>  
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- #Menu -->
            <!-- Footer -->
            <div class="legal">
                <div class="copyright">
                    &copy; 2023 - 2024 <a href="javascript:void(0);">AdminNeuromodulación</a>.
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
                            <div class="red"></div>
                            <span id="red">Red</span>
                        </li>
                        <script>
                            $("#red").click(function(){ 
                                var color_body = 'red';
                                var ruta = "../";
                                var usuario_id = "5";
                                var datastring = 'color_body='+color_body+'&usuario_id='+usuario_id+'&ruta='+ruta;
                                //alert(datastring);
                                $.ajax({
                                    url: "../herramientas/body.php",
                                    type: "POST",
                                    data: datastring, 
                                    cache: false,
                                    success:function(html){
                                        //alert(html);
                                        window.location.href = "../protocolo/pagina.php";      
                                    }
                                });
                            });
                        </script> 
                        <li id="pink" data-theme="pink">
                            <div class="pink"></div>
                            <span>Pink</span>
                        </li>
                        <script>
                            $("#pink").click(function(){ 
                                var color_body = 'pink';
                                var ruta = "../";
                                var usuario_id = "5";
                                var datastring = 'color_body='+color_body+'&usuario_id='+usuario_id+'&ruta='+ruta;
                                $.ajax({
                                    url: "../herramientas/body.php",
                                    type: "POST",
                                    data: datastring, 
                                    cache: false,
                                    success:function(html){
                                        window.location.href = "../protocolo/pagina.php";      
                                    }
                                });
                            });
                        </script>
                        <li id="purple" data-theme="purple">
                            <div class="purple"></div>
                            <span id="purple">Purple</span>
                        </li>
                        <script>
                            $("#purple").click(function(){ 
                                var color_body = 'purple';
                                var ruta = "../";
                                var usuario_id = "5";
                                var datastring = 'color_body='+color_body+'&usuario_id='+usuario_id+'&ruta='+ruta;
                                $.ajax({
                                    url: "../herramientas/body.php",
                                    type: "POST",
                                    data: datastring, 
                                    cache: false,
                                    success:function(html){
                                        window.location.href = "../protocolo/pagina.php";      
                                    }
                                });
                            });
                        </script>
                        <li id="deep-purple" data-theme="deep-purple">
                            <div class="deep-purple"></div>
                            <span>Deep Purple</span>
                        </li>
                        <script>
                            $("#deep-purple").click(function(){ 
                                var color_body = 'deep-purple';
                                var ruta = "../";
                                var usuario_id = "5";
                                var datastring = 'color_body='+color_body+'&usuario_id='+usuario_id+'&ruta='+ruta;
                                $.ajax({
                                    url: "../herramientas/body.php",
                                    type: "POST",
                                    data: datastring, 
                                    cache: false,
                                    success:function(html){
                                        window.location.href = "../protocolo/pagina.php";      
                                    }
                                });
                            });
                        </script>
                        <li id="indigo" data-theme="indigo">
                            <div class="indigo"></div>
                            <span>Indigo</span>
                        </li>
                        <script>
                            $("#indigo").click(function(){ 
                                var color_body = 'indigo';
                                var ruta = "../";
                                var usuario_id = "5";
                                var datastring = 'color_body='+color_body+'&usuario_id='+usuario_id+'&ruta='+ruta;
                                $.ajax({
                                    url: "../herramientas/body.php",
                                    type: "POST",
                                    data: datastring, 
                                    cache: false,
                                    success:function(html){
                                        window.location.href = "../protocolo/pagina.php";      
                                    }
                                });
                            });
                        </script>
                        <li id="blue" data-theme="blue">
                            <div class="blue"></div>
                            <span>Blue</span>
                        </li>
                        <script>
                            $("#blue").click(function(){ 
                                var color_body = 'blue';
                                var ruta = "../";
                                var usuario_id = "5";
                                var datastring = 'color_body='+color_body+'&usuario_id='+usuario_id+'&ruta='+ruta;
                                $.ajax({
                                    url: "../herramientas/body.php",
                                    type: "POST",
                                    data: datastring, 
                                    cache: false,
                                    success:function(html){
                                        window.location.href = "../protocolo/pagina.php";      
                                    }
                                });
                            });
                        </script>
                        <li id="light-blue" data-theme="light-blue">
                            <div class="light-blue"></div>
                            <span>Light Blue</span>
                        </li>
                        <script>
                            $("#light-blue").click(function(){ 
                                var color_body = 'light-blue';
                                var ruta = "../";
                                var usuario_id = "5";
                                var datastring = 'color_body='+color_body+'&usuario_id='+usuario_id+'&ruta='+ruta;
                                $.ajax({
                                    url: "../herramientas/body.php",
                                    type: "POST",
                                    data: datastring, 
                                    cache: false,
                                    success:function(html){
                                        window.location.href = "../protocolo/pagina.php";      
                                    }
                                });
                            });
                        </script>
                        <li id="cyan" data-theme="cyan">
                            <div class="cyan"></div>
                            <span>Cyan</span>
                        </li>
                        <script>
                            $("#cyan").click(function(){ 
                                var color_body = 'cyan';
                                var ruta = "../";
                                var usuario_id = "5";
                                var datastring = 'color_body='+color_body+'&usuario_id='+usuario_id+'&ruta='+ruta;
                                $.ajax({
                                    url: "../herramientas/body.php",
                                    type: "POST",
                                    data: datastring, 
                                    cache: false,
                                    success:function(html){
                                        window.location.href = "../protocolo/pagina.php";      
                                    }
                                });
                            });
                        </script>
                        <li id="teal" data-theme="teal" class="active">
                            <div class="teal"></div>
                            <span>Teal</span>
                        </li>
                        <script>
                            $("#teal").click(function(){ 
                                var color_body = 'teal';
                                var ruta = "../";
                                var usuario_id = "5";
                                var datastring = 'color_body='+color_body+'&usuario_id='+usuario_id+'&ruta='+ruta;
                                $.ajax({
                                    url: "../herramientas/body.php",
                                    type: "POST",
                                    data: datastring, 
                                    cache: false,
                                    success:function(html){
                                        window.location.href = "../protocolo/pagina.php";      
                                    }
                                });
                            });
                        </script>

                        <li id="aldana" data-theme="aldana">
                            <div class="aldana"></div>
                            <span>Aldana</span>
                        </li>
                        <script>
                            $("#aldana").click(function(){ 
                                var color_body = 'aldana';
                                var ruta = "../";
                                var usuario_id = "5";
                                var datastring = 'color_body='+color_body+'&usuario_id='+usuario_id+'&ruta='+ruta;
                                $.ajax({
                                    url: "../herramientas/body.php",
                                    type: "POST",
                                    data: datastring, 
                                    cache: false,
                                    success:function(html){
                                        window.location.href = "../protocolo/pagina.php";      
                                    }
                                });
                            });
                        </script>
                            
                        <li id="green" data-theme="green">
                            <div class="green"></div>
                            <span>Green</span>
                        </li>
                        <script>
                            $("#green").click(function(){ 
                                var color_body = 'green';
                                var ruta = "../";
                                var usuario_id = "5";
                                var datastring = 'color_body='+color_body+'&usuario_id='+usuario_id+'&ruta='+ruta;
                                $.ajax({
                                    url: "../herramientas/body.php",
                                    type: "POST",
                                    data: datastring, 
                                    cache: false,
                                    success:function(html){
                                        window.location.href = "../protocolo/pagina.php";      
                                    }
                                });
                            });
                        </script>
                        <li id="light-green" data-theme="light-green">
                            <div class="light-green"></div>
                            <span>Light Green</span>
                        </li>
                        <script>
                            $("#light-green").click(function(){ 
                                var color_body = 'light-green';
                                var ruta = "../";
                                var usuario_id = "5";
                                var datastring = 'color_body='+color_body+'&usuario_id='+usuario_id+'&ruta='+ruta;
                                $.ajax({
                                    url: "../herramientas/body.php",
                                    type: "POST",
                                    data: datastring, 
                                    cache: false,
                                    success:function(html){
                                        window.location.href = "../protocolo/pagina.php";      
                                    }
                                });
                            });
                        </script>
                        <li id="lime" data-theme="lime">
                            <div class="lime"></div>
                            <span>Lime</span>
                        </li>
                        <script>
                            $("#lime").click(function(){ 
                                var color_body = 'lime';
                                var ruta = "../";
                                var usuario_id = "5";
                                var datastring = 'color_body='+color_body+'&usuario_id='+usuario_id+'&ruta='+ruta;
                                $.ajax({
                                    url: "../herramientas/body.php",
                                    type: "POST",
                                    data: datastring, 
                                    cache: false,
                                    success:function(html){
                                        window.location.href = "../protocolo/pagina.php";      
                                    }
                                });
                            });
                        </script>
                        <li id="yellow" data-theme="yellow">
                            <div class="yellow"></div>
                            <span>Yellow</span>
                        </li>
                        <script>
                            $("#yellow").click(function(){ 
                                var color_body = 'yellow';
                                var ruta = "../";
                                var usuario_id = "5";
                                var datastring = 'color_body='+color_body+'&usuario_id='+usuario_id+'&ruta='+ruta;
                                $.ajax({
                                    url: "../herramientas/body.php",
                                    type: "POST",
                                    data: datastring, 
                                    cache: false,
                                    success:function(html){
                                        window.location.href = "../protocolo/pagina.php";      
                                    }
                                });
                            });
                        </script>
                        <li id="amber" data-theme="amber">
                            <div class="amber"></div>
                            <span>Amber</span>
                        </li>
                        <script>
                            $("#amber").click(function(){ 
                                var color_body = 'amber';
                                var ruta = "../";
                                var usuario_id = "5";
                                var datastring = 'color_body='+color_body+'&usuario_id='+usuario_id+'&ruta='+ruta;
                                $.ajax({
                                    url: "../herramientas/body.php",
                                    type: "POST",
                                    data: datastring, 
                                    cache: false,
                                    success:function(html){
                                        window.location.href = "../protocolo/pagina.php";      
                                    }
                                });
                            });
                        </script>
                        <li id="orange" data-theme="orange">
                            <div class="orange"></div>
                            <span>Orange</span>
                        </li>
                        <script>
                            $("#orange").click(function(){ 
                                var color_body = 'orange';
                                var ruta = "../";
                                var usuario_id = "5";
                                var datastring = 'color_body='+color_body+'&usuario_id='+usuario_id+'&ruta='+ruta;
                                $.ajax({
                                    url: "../herramientas/body.php",
                                    type: "POST",
                                    data: datastring, 
                                    cache: false,
                                    success:function(html){
                                        window.location.href = "../protocolo/pagina.php";      
                                    }
                                });
                            });
                        </script>
                        <li id="deep-orange" data-theme="deep-orange">
                            <div class="deep-orange"></div>
                            <span>Deep Orange</span>
                        </li>
                        <script>
                            $("#deep-orange").click(function(){ 
                                var color_body = 'deep-orange';
                                var ruta = "../";
                                var usuario_id = "5";
                                var datastring = 'color_body='+color_body+'&usuario_id='+usuario_id+'&ruta='+ruta;
                                $.ajax({
                                    url: "../herramientas/body.php",
                                    type: "POST",
                                    data: datastring, 
                                    cache: false,
                                    success:function(html){  
                                        window.location.href = "../protocolo/pagina.php";    
                                    }
                                });
                            });
                        </script>
                        <li id="brown" data-theme="brown">
                            <div class="brown"></div>
                            <span>Brown</span>
                        </li>
                        <script>
                            $("#brown").click(function(){ 
                                var color_body = 'brown';
                                var ruta = "../";
                                var usuario_id = "5";
                                var datastring = 'color_body='+color_body+'&usuario_id='+usuario_id+'&ruta='+ruta;
                                $.ajax({
                                    url: "../herramientas/body.php",
                                    type: "POST",
                                    data: datastring, 
                                    cache: false,
                                    success:function(html){ 
                                        window.location.href = "../protocolo/pagina.php";     
                                    }
                                });
                            });
                        </script>
                        <li id="grey" data-theme="grey">
                            <div class="grey"></div>
                            <span>Grey</span>
                        </li>
                        <script>
                            $("#grey").click(function(){ 
                                var color_body = 'grey';
                                var ruta = "../";
                                var usuario_id = "5";
                                var datastring = 'color_body='+color_body+'&usuario_id='+usuario_id+'&ruta='+ruta;
                                $.ajax({
                                    url: "../herramientas/body.php",
                                    type: "POST",
                                    data: datastring, 
                                    cache: false,
                                    success:function(html){ 
                                        window.location.href = "../protocolo/pagina.php";     
                                    }
                                });
                            });
                        </script>
                        <li id="blue-grey" data-theme="blue-grey">
                            <div class="blue-grey"></div>
                            <span>Blue Grey</span>
                        </li>
                        <script>
                            $("#blue-grey").click(function(){ 
                                var color_body = 'blue-grey';
                                var ruta = "../";
                                var usuario_id = "5";
                                var datastring = 'color_body='+color_body+'&usuario_id='+usuario_id+'&ruta='+ruta;
                                $.ajax({
                                    url: "../herramientas/body.php",
                                    type: "POST",
                                    data: datastring, 
                                    cache: false,
                                    success:function(html){ 
                                        window.location.href = "../protocolo/pagina.php";     
                                    }
                                });
                            });
                        </script>
                        <li id="black" data-theme="black">
                            <div class="black"></div>
                            <span>Black</span>
                        </li>
                        <script>
                            $("#black").click(function(){ 
                                var color_body = 'black';
                                var ruta = "../";
                                var usuario_id = "5";
                                var datastring = 'color_body='+color_body+'&usuario_id='+usuario_id+'&ruta='+ruta;
                                $.ajax({
                                    url: "../herramientas/body.php",
                                    type: "POST",
                                    data: datastring, 
                                    cache: false,
                                    success:function(html){  
                                        window.location.href = "../protocolo/pagina.php";   
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
                                    <label><input type="checkbox" checked><span class="lever switch-col-teal"></span></label>
                                </div>
                            </li>
                            <li>
                                <span>Email Redirect</span>
                                <div class="switch">
                                    <label><input type="checkbox"><span class="lever switch-col-teal"></span></label>
                                </div>
                            </li>
                        </ul>
                        <p>SYSTEM SETTINGS</p>
                        <ul class="setting-list">
                            <li>
                                <span>Notifications</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever switch-col-teal"></span></label>
                                </div>
                            </li>
                            <li>
                                <span>Auto Updates</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever switch-col-teal"></span></label>
                                </div>
                            </li>
                        </ul>
                        <p>ACCOUNT SETTINGS</p>
                        <ul class="setting-list">
                            <li>
                                <span>Offline</span>
                                <div class="switch">
                                    <label><input type="checkbox"><span class="lever switch-col-teal"></span></label>
                                </div>
                            </li>
                            <li>
                                <span>Location Permission</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever switch-col-teal"></span></label>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </aside>
        <!-- #END# Right Sidebar -->
    </section>
    <section class="content">
        <div class="container-fluid content-container">
            <div class="block-header">
                <h2>PAGINA EJEMPLO</h2>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div style="height: 95%" class="header">
                            <h1 align="center">Contenido</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Modal -->
    <div class="modal fade" id="sessionModal" tabindex="-1" role="dialog" aria-labelledby="sessionModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sessionModalLabel">Sesión por expirar</h5>
                </div>
                <div class="modal-body">
                    Tu sesión está a punto de expirar. ¿Deseas continuar?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="continueSession">Continuar sesión</button>
                    <button type="button" class="btn btn-danger" id="endSession">Terminar sesión</button>
                </div>
            </div>
        </div>
    </div>

    <audio id="alertSound" src="../functions/Public-announcement-bell-sound-effect.mp3" preload="auto"></audio>

    <script>
    $(document).ready(function() {
        var sessionDuration = 5400; // 90 minutos en segundos
        var alertTime = sessionDuration - 60; // 1 minuto antes de expirar

        setTimeout(function() {
            console.log("Mostrando modal de sesión por expirar");
            // Mostrar el modal
            $('#sessionModal').modal('show');
            console.log("Reproduciendo sonido de alerta");
            // Reproducir sonido de alerta
            var alertSound = $('#alertSound')[0];
            alertSound.play().then(function() {
                console.log("El sonido de alerta está reproduciéndose");
            }).catch(function(error) {
                console.error("Error al reproducir el sonido de alerta:", error);
            });
        }, alertTime * 1000);

        $('#continueSession').click(function() {
            // Llamada AJAX para extender la sesión
            $.ajax({
                url: '../functions/extend_session.php',
                success: function(response) {
                    location.reload(); // Recargar la página para reiniciar el temporizador
                }
            });
        });

        $('#endSession').click(function() {
            // Redirigir al inicio de sesión o página de inicio
            window.location.href = '../cerrar_sesion.php';
        });

        setTimeout(function() {
            // Redirigir al inicio de sesión si no hay respuesta después de 1 minuto
            window.location.href = '../cerrar_sesion.php';
        }, sessionDuration * 1000);

        // Función para comprobar el estado de la sesión cada minuto
        function comprobarEstadoSesion() {
            console.log("Comprobando el estado de la sesión");
            $.ajax({
                url: '../functions/valida_uso.php',
                method: 'POST',
                data: { usuario_id: 5 },
                success: function(response) {
                    console.log("Respuesta del servidor:", response);
                    if (response === 'Caduco') {
                        console.log("La sesión ha caducado. Redirigiendo...");
                        window.location.href = '../cerrar_sesion.php';
                    } else {
                        console.log("La sesión está activa.");
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error en la solicitud AJAX:", status, error);
                }
            });
        }

        // Comprobar la caducidad cada minuto
        setInterval(comprobarEstadoSesion, 60000);          
    });
    
    // Toggle sidebar visibility and expand content
    $('#toggle-menu').click(function() {
        $('#leftsidebar').toggle();
        $('.content-container').toggleClass('content-expanded');
    });
    </script>       

    <!-- Jquery Core Js -->
    <script src="../plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="../plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Select Plugin Js -->
    <script src="../plugins/bootstrap-select/js/bootstrap-select.js"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="../plugins/jquery-slimscroll/jquery.slimscroll.js"></script>
    
    <!-- Moment Plugin Js -->
    <script src="../plugins/momentjs/moment.js"></script>

    <!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src="../plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

    <!-- Bootstrap Datepicker Plugin Js -->
    <script src="../plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="../plugins/node-waves/waves.js"></script>
    
    <!-- Custom Js -->
    <script src="../js/admin.js"></script>
    <script src="../js/pages/ui/dialogs.js"></script>
        
    <script src="../js/pages/ui/tooltips-popovers.js"></script>
    <!-- <script src="../js/pages/tables/jquery-datatable.js"></script> -->
    <script src="../js/pages/forms/basic-form-elements.js"></script>

    <!-- Demo Js -->
    <script src="../js/demo.js"></script>
    
</body>

</html>
