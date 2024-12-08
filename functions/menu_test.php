<!-- Menu principal de navegación -->
<div class="menu">
    <ul class="list">
        <!-- Encabezado del menú -->
        <li class="header">Menú de Navegación</li>
        <!-- Elemento del menú: Inicio 
        <li <?php if ($ubicacion_url == $ruta.'menu.php') { echo 'class="active"'; } ?>>
            <a href="<?php echo $ruta; ?>menu.php">
                <i class="material-icons">home</i>
                <span>Inicio</span>
            </a>
        </li>-->
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
                    admin.funcion_id
                FROM
                    menus
                    INNER JOIN paquete_modulo ON menus.modulo_id = paquete_modulo.modulo_id
                    INNER JOIN paquetes ON paquete_modulo.paquete_id = paquetes.paquete_id
                    INNER JOIN empresas ON paquetes.paquete_id = empresas.paquete_id
                    INNER JOIN admin ON empresas.empresa_id = admin.empresa_id 
                WHERE
                    admin.usuario_id = ? 
                    AND FIND_IN_SET(admin.funcion_id, menus.autorizacion) > 0
                    ORDER BY 1 ASC
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

                            // Consulta para obtener las rutas adicionales con tipo 'liga'
                            $query_rutas_adicionales = "
                                SELECT
                                    submenus.ruta_submenu
                                FROM
                                    submenus
                                WHERE
                                    submenus.tipo_s = 'liga'
                                    AND submenus.menu_id = ?
                            ";
                            $params_rutas_adicionales = [$menu_id];
                            $resultado_rutas_adicionales = $mysql->consulta($query_rutas_adicionales, $params_rutas_adicionales);
                            
                            // Extraer rutas adicionales de la consulta
                            $rutas_adicionales = array_column($resultado_rutas_adicionales['resultado'] ?? [], 'ruta_submenu');
                            
                            // Consulta dinámica para submenús con autorización
                            $query2 = "
                                SELECT
                                    submenus.ruta_submenu,
                                    submenus.nombre_s,
                                    submenus.iconos,
                                    submenus.tipo_s
                                FROM
                                    submenus
                                WHERE
                                    submenus.menu_id = ?
                                    AND submenus.autorizacion LIKE ?
                            ";
                            $funcion = '%' . $fila1['funcion_id'] . '%';
                            $params2 = [$menu_id, $funcion];
                            $resultado2 = $mysql->consulta($query2, $params2);
                            
                            // Agregar rutas de submenús al arreglo
                            $rutas_dinamicas = array_column($resultado2['resultado'] ?? [], 'ruta_submenu');
                            
                            // Combinar las rutas adicionales y las dinámicas
                            $rutas_activas = array_merge($rutas_adicionales, $rutas_dinamicas);
                            
                            // Determinar si la URL actual está activa
                            $es_activo = in_array($ubicacion_url, $rutas_activas);
                            ?>
                            <li <?php echo $es_activo ? 'class="active"' : ''; ?>>
                                <a href="javascript:void(0);" class="menu-toggle">
                                    <?php echo $icono_menu; ?>
                                    <span><?php echo $nombre_m; ?></span>
                                </a>
                                <ul class="ml-menu">
                                    <?php
                                    // Generar submenús dinámicamente
                                    foreach ($resultado2['resultado'] ?? [] as $fila2) {
                                        $ruta_submenu = $fila2['ruta_submenu'];
                                        $nombre_s = $fila2['nombre_s'];
                                        $iconos = $fila2['iconos'];
                                        $tipo_s = $fila2['tipo_s'];
                                        switch ($tipo_s) {
                                            case 'liga':
                                                ?>
                                                <li <?php echo ($ubicacion_url == $ruta_submenu) ? 'class="active"' : ''; ?>>
                                                    <a href="<?php echo $ruta . $ruta_submenu; ?>">
                                                        <?php echo $iconos; ?>
                                                        <span><?php echo $nombre_s; ?></span>
                                                    </a>
                                                </li>
                                                <?php
                                                break;

                                            case 'etiqueta':
                                                ?>
                                                <li style="background-color: #eee"  <?php echo ($ubicacion_url == $ruta_submenu) ? 'class="active"' : ''; ?>>
                                                    <a href="<?php echo $ruta . $ruta_submenu; ?>">
                                                        <?php echo $iconos; ?>
                                                        <span><?php echo $nombre_s; ?></span>
                                                    </a>
                                                </li>
                                                <?php
                                                break;
                                                
                                            case 'balance':
                                                ?>
                                                
                                                <li <?php if ($ubicacion_url == 'caja/balance_mes.php' || $ubicacion_url == 'caja/balance_mes.php?us='.$emp_nombre) { echo 'class="active"'; } ?>>
                                                    <a href="javascript:void(0);" class="menu-toggle">
                                                        <?php echo $icono_menu; ?>
                                                        <span><?php echo $nombre_m; ?></span>
                                                    </a>
                                                    <ul class="ml-menu">
                                                        <!-- Submenú: Balance del usuario actual -->
                                                        <li>
                                                            <a href="<?php echo $ruta; ?>caja/balance_mes.php?us=<?php echo $emp_nombre; ?>">
                                                                <span><?php echo $emp_nombre; ?></span>
                                                            </a>
                                                        </li>
                                                        <!-- Submenú: Balance por cada médico registrado en la empresa -->
                                                        <?php
                                                            $sql_medico = "
                                                                SELECT
                                                                    medicos.medico_id, 
                                                                    medicos.medico
                                                                FROM
                                                                    medicos
                                                                WHERE
                                                                    medicos.empresa_id = $empresa_id
                                                            ";
                                                            $result_medico = ejecutar($sql_medico); 
                                                            while ($row_medico = mysqli_fetch_array($result_medico)) { 
                                                                extract($row_medico);
                                                        ?>
                                                        <li>
                                                            <a href="<?php echo $ruta; ?>caja/balance_mes.php?us=<?php echo $medico; ?>">
                                                                <span><?php echo $medico; ?></span>
                                                            </a>
                                                        </li>
                                                        <?php } ?>
                                                    </ul>
                                                </li>
                    
                                                <?php
                                                break;
                                        }

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