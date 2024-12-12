<!-- *************Tronco común ******************** --> 
<!-- Carga de la hoja de estilos personalizada -->
<link href="<?php echo $ruta; ?>css/style.css" rel="stylesheet">

<!-- Carga de temas para AdminTMS. Se puede elegir un tema específico de css/themes o cargar todos los temas -->
<link href="<?php echo $ruta; ?>css/themes/all-themes.css" rel="stylesheet" />
</head>

<body class="theme-<?php echo $body; ?>">

    <!-- Page Loader (Cargador de Página) -->
    <!-- Este código genera un cargador de página mientras la página se carga completamente -->
   <!-- 
    <div class="page-loader-wrapper">
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
            <h2>Espere por favor, cargando...</h2>
            <h4>Esto podría tomar unos segundos dependiendo del contenido.</h4>
        </div>
    </div>
-->
    <!-- #END# Page Loader -->

    <!-- Overlay For Sidebars (Superposición para las barras laterales) -->
    <!-- Este div crea una superposición que oscurece el contenido cuando una barra lateral está activa -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->

    <!-- Search Bar (Barra de búsqueda) -->
    <!-- Esta sección es la barra de búsqueda que aparece en la parte superior de la página -->
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

    <!-- Top Bar (Barra superior) -->
    <!-- Esta es la barra de navegación principal que contiene el logotipo y los elementos de navegación -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <!-- Botón para colapsar el menú en dispositivos móviles -->
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <!-- Logotipo y enlace a la página principal -->
                <a class="navbar-brand" href="<?php echo $ruta; ?>menu.php">Admin<b>Neuromodulación</b> - Sistema de administración de <?php echo $emp_nombre; ?></a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <!-- Notifications (Notificaciones) -->
                    <?php
                    // Consulta SQL para obtener el número de pacientes pendientes
					$sql_protocolo = "
					SELECT
						paciente_id
					FROM
						pacientes
					WHERE
						pacientes.estatus = 'Pendiente'
						and pacientes.empresa_id = $empresa_id
			        ";
			        $result_protocolo=ejecutar($sql_protocolo);    
		            $cnt= mysqli_num_rows($result_protocolo); 

                    $query = "SELECT COUNT(*) AS totalPendientes
                    FROM notices n
                    LEFT JOIN notice_reads nr ON n.id = nr.notice_id AND nr.usuario_id = ?
                    WHERE n.empresa_id = ?
                    AND (n.usuario_id = ? OR n.usuario_id IS NULL)
                    AND (nr.is_read = 0 OR nr.is_read IS NULL)";
          
                    $params = [$usuario_id, $empresa_id, $usuario_id];
                    $result = $mysql->consulta($query, $params);
                    
                    if ($result['numFilas'] > 0) {
                        $totalPendientes = $result['resultado'][0]['totalPendientes'];
                      //  echo "Total de mensajes pendientes: " . $totalPendientes;
                    } else {
                      //  echo "No hay mensajes pendientes.";
          }                    
                        $notificationCount = $cnt + $totalPendientes; 
                        $iconColor = ($notificationCount > 0) ? 'red' : 'white';
                    ?>
                    <li class="dropdown">
                        <!-- Icono de notificaciones con contador -->
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                            <i class="material-icons" style="color: <?php echo $iconColor; ?>;">notifications</i>
                            <span class="label-count"><?php echo $notificationCount; ?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">NOTIFICACIONES</li>
                            <li class="body">
                                <ul class="menu">
                                    <li>
                                        <!-- Enlace a la lista de pacientes pendientes -->
                                        <a href="<?php echo $ruta; ?>paciente/pendientes.php">
                                            <div class="icon-circle bg-light-green">
                                                <i class="material-icons">notifications</i>
                                            </div>
                                            <div class="menu-info">
                                                <h4><?php echo $cnt; ?> nuevos pacientes</h4>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo $ruta; ?>mensajes/mis_mensajes.php">
                                            <div class="icon-circle bg-blue-grey">
                                                <i class="material-icons">comment</i>
                                            </div>
                                            <div class="menu-info">
                                                <h4><?php echo $totalPendientes; ?> Nuevos Avisos</h4>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="footer">
                                <!-- Enlace para ver todas las notificaciones -->
                                <a href="javascript:void(0);">Ver todas las notificaciones</a>
                            </li>
                        </ul>
                    </li>
      
                    <!-- #END# Notifications -->
                    
                    <!-- Botón para abrir la barra lateral derecha -->
                    <li class="pull-right"><a href="javascript:void(0);" class="js-right-sidebar" data-close="true"><i class="material-icons">more_vert</i></a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- #Top Bar -->

    <section>
        <!-- Left Sidebar (Barra lateral izquierda) -->
        <!-- Esta es la barra lateral izquierda que contiene información del usuario y el menú de navegación -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info (Información del usuario) -->
            <div class="user-info">
                <div class="image">
                    <!-- Espacio para la imagen del usuario -->
                    <!-- <img src="images/user.png" width="48" height="48" alt="User" /> -->
                    <br>
                </div>
                <div class="info-container"><br>
                    <!-- Muestra el nombre y el correo electrónico del usuario -->
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: white"><?php echo "<b>".$nombre."</b>"; ?></div>
                    <div class="email"  style="color: white"><?php echo "<b>".$usuario."<br>".$funcion."</b>"; ?></div>
                    <div class="btn-group user-helper-dropdown">
                        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                        <ul class="dropdown-menu pull-right">
                            <!-- Enlace al perfil del usuario -->
                            <li><a href="<?php echo $ruta; ?>usuarios/perfil.php"><i class="material-icons">person</i>Perfil</a></li>
                            <li role="separator" class="divider"></li>
                            <!-- Enlace para cerrar sesión -->
                            <li><a href="<?php echo $ruta; ?>cerrar_sesion.php"><i class="material-icons">input</i>Cierre de Sesión</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- #User Info -->

            <!-- Inclusión del menú de navegación dinámico -->
            <?php include($ruta.'functions/menu_test.php'); ?>

            <!-- Footer (Pie de página) -->
            <!-- Información de copyright y versión del sistema -->
            <div class="legal">
                <div class="copyright">
                    &copy; <?php echo $anio ?> <a href="javascript:void(0);">AdminNeuromodulación</a>.
                </div>
                <div class="version">
                    <b>Version: </b> <?php echo $version; ?>
                </div>
            </div>
            <!-- #Footer -->
        </aside>
        <!-- #END# Left Sidebar -->

        <!-- Right Sidebar (Barra lateral derecha) -->
        <!-- Esta es la barra lateral derecha que contiene configuraciones adicionales y selección de temas -->
        <aside id="rightsidebar" class="right-sidebar">
            <ul class="nav nav-tabs tab-nav-right" role="tablist">
                <li role="presentation" class="active"><a href="#skins" data-toggle="tab">SKINS</a></li>
                <li role="presentation"><a href="#settings" data-toggle="tab">SETTINGS</a></li>
            </ul>
            <!-- Selección de colores y configuraciones generales -->
            <div class="tab-content">
                <!-- Inclusión de la funcionalidad de selección de colores desde un archivo separado -->
				<?php include($ruta.'functions/colores_sistema.php'); ?>
                <div role="tabpanel" class="tab-pane fade" id="settings">
                    <div class="demo-settings">
                        <p>GENERAL SETTINGS</p>
                        <ul class="setting-list">
                            <li>
                                <!-- Configuración para reportar el uso del panel -->
                                <span>Report Panel Usage</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever switch-col-<?php echo $body; ?>"></span></label>
                                </div>
                            </li>
                            <li>
                                <!-- Redirección de correos electrónicos -->
                                <span>Email Redirect</span>
                                <div class="switch">
                                    <label><input type="checkbox"><span class="lever switch-col-<?php echo $body; ?>"></span></label>
                                </div>
                            </li>
                        </ul>
                        <p>SYSTEM SETTINGS</p>
                        <ul class="setting-list">
                            <li>
                                <!-- Configuración de notificaciones -->
                                <span>Notifications</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever switch-col-<?php echo $body; ?>"></span></label>
                                </div>
                            </li>
                            <li>
                                <!-- Configuración de actualizaciones automáticas -->
                                <span>Auto Updates</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever switch-col-<?php echo $body; ?>"></span></label>
                                </div>
                            </li>
                        </ul>
                        <p>ACCOUNT SETTINGS</p>
                        <ul class="setting-list">
                            <li>
                                <!-- Configuración para el estado sin conexión -->
                                <span>Offline</span>
                                <div class="switch">
                                    <label><input type="checkbox"><span class="lever switch-col-<?php echo $body; ?>"></span></label>
                                </div>
                            </li>
                            <li>
                                <!-- Permisos de ubicación -->
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
