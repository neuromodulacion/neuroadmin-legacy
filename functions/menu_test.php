<!-- Menu principal de navegación -->
<div class="menu">
    <ul class="list">
        <!-- Encabezado del menú -->
        <li class="header">Menú de Navegación</li>
        <!-- Elemento del menú: Inicio -->
        <li <?php if ($ubicacion_url == $ruta.'menu.php') { echo 'class="active"'; } ?>>
            <a href="<?php echo $ruta; ?>menu.php">
                <i class="material-icons">home</i>
                <span>Inicio</span>
            </a>
        </li>
        <?php
        try {
            // Primera consulta
            $query1 = "
                SELECT
                    menus.menu_id,
                    menus.modulo_id,
                    menus.nombre_m,
                    menus.icono_menu,
                    menus.ruta_menu,
                    menus.tipo_m,
                    menus.autorizacion,
                    paquetes.nombre_paquete,
                    empresas.empresa_id,
                    empresas.emp_nombre,
                    admin.nombre,
                    admin.funcion_id,
                    admin.funcion 
                FROM
                    menus
                    INNER JOIN paquete_modulo ON menus.modulo_id = paquete_modulo.modulo_id
                    INNER JOIN paquetes ON paquete_modulo.paquete_id = paquetes.paquete_id
                    INNER JOIN empresas ON paquetes.paquete_id = empresas.paquete_id
                    INNER JOIN admin ON empresas.empresa_id = admin.empresa_id 
                WHERE
                    admin.usuario_id = ? 
                    AND FIND_IN_SET(admin.funcion_id, menus.autorizacion) > 0
            ";
            //  echo $query1;                 
            // Ejecutar la primera consulta
            $params1 = [$usuario_id];
            //echo $usuario_id."<hr>";

            $resultado1 = $mysql->consulta($query1, $params1);
            if ($resultado1['numFilas'] > 0) {
                //echo "Resultados de la primera consulta:\n";
                foreach ($resultado1['resultado'] as $fila1) {
                    //print_r($fila1); // Procesa cada fila como necesites
                    // Obtener menu_id para la segunda consulta
                    $menu_id = $fila1['menu_id'];
                    $funcion_id = $fila1['funcion_id'];
                    $tipo_m = $fila1['tipo_m'];
                    $nombre_m = $fila1['nombre_m'];
                    $icono_menu = $fila1['icono_menu'];
                    $ruta_menu = $fila1['ruta_menu'];
                    switch ($tipo_m) {
                        case 'liga':
                            ?>
                            
                            <!-- Elemento del menú: Principal -->
                            <li <?php if ($ubicacion_url == $ruta_menu) { echo 'class="active"'; } ?>>
                                <a href="<?php echo $ruta.$ruta_menu; ?>">
                                    <?php echo $icono_menu; ?>
                                    <span><?php echo $nombre_m; ?></span>
                                </a>
                            </li>
                            <?php
                            break;
                        case 'principal':
                            ?>
                            <li <?php if ($ubicacion_url == 'paciente/alta.php' || $ubicacion_url == 'paciente/pendientes.php' || $ubicacion_url == 'paciente/solicitud.php'  || $ubicacion_url == 'paciente/seguimientos.php' || $ubicacion_url == 'paciente/directorio.php' || $ubicacion_url == 'paciente/historico.php' || $ubicacion_url == 'agenda/agenda.php' || $ubicacion_url == 'carta/cartas_generadas.php' || $funcion == 'COORDINADOR' || $ubicacion_url == 'carta/genera_invitacion.php' || $ubicacion_url == 'paciente/pacientes_consultas.php') { echo 'class="active"'; } ?>>
                            <a href="javascript:void(0);" class="menu-toggle">
                                <?php echo $icono_menu; ?>
                                <span><?php echo $nombre_m; ?></span>
                            </a>
                                <ul class="ml-menu">
                                    <?php
                                        // Segunda consulta
                                        $query2 = "
                                        SELECT
                                            submenus.sub_menu_id, 
                                            submenus.menu_id, 
                                            submenus.nombre_s, 
                                            submenus.ruta_submenu, 
                                            submenus.tipo_s, 
                                            submenus.autorizacion, 
                                            submenus.tema_id, 
                                            submenus.iconos
                                        FROM
                                            submenus
                                        WHERE
                                            submenus.menu_id = ?
                                            AND submenus.autorizacion LIKE ?;
                                    ";
                                    $funcion = '%'.$funcion_id.'%';
                                    
                                    // Ejecutar la segunda consulta con parámetros
                                    $params2 = [$menu_id, $funcion];
                                    $resultado2 = $mysql->consulta($query2, $params2);

                                    if ($resultado2['numFilas'] > 0) {
                                    // echo "Resultados de la segunda consulta para menu_id={$menu_id}:\n";
                                        foreach ($resultado2['resultado'] as $fila2) {
                                            // Obtener menu_id para la segunda consulta
                                            $tipo_s = $fila2['tipo_s'];
                                            $nombre_s = $fila2['nombre_s'];
                                            $iconos = $fila2['iconos'];
                                            $ruta_submenu = $fila2['ruta_submenu'];
                                            switch ($tipo_s) {
                                                case 'liga':
                                                    ?>
                                                    <li <?php if ($ubicacion_url == $ruta_submenu) { echo 'class="active"'; } ?>>
                                                        <a href="<?php echo $ruta.$ruta_submenu; ?>">
                                                            <?php echo $iconos; ?>
                                                            <span><?php echo $nombre_s; ?></span>
                                                        </a>
                                                    </li>
                                                <?php 
                                                    break;
                                                
                                                    case 'etiqueta':
                                                        ?>
                                                        <li <?php if ($ubicacion_url == $ruta_submenu) { echo 'class="active"'; } ?>>
                                                            <a href="#" >
                                                                <!--<?php echo $iconos; ?>-->
                                                                <span><b><?php echo $nombre_s; ?></b></span>
                                                            </a disabled>
                                                        </li>
                                                        
                                                    <?php 
                                                        break;
                                            }
   
                                        }
                                    } else {
                                        echo "No se encontraron resultados en la segunda consulta para menu_id={$menu_id}.\n";
                                    }
                                    ?>
                                </ul>
                            </li>
                            <?php 
                            break;
                    }
                }
            } else {
                echo "No se encontraron resultados en la primera consulta.\n";
            }
        } catch (Exception $e) {
            // Manejo de errores
            echo "Error: " . $e->getMessage();
        }
        ?>
    </ul>  
</div>
<!-- #Menu -->