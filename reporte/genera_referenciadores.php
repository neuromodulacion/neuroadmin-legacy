<?php
// Iniciar la sesión del usuario
session_start();

// Configurar el nivel de reporte de errores (7 muestra errores y advertencias)
error_reporting(7);

// Establecer la codificación interna a UTF-8 para las funciones de conversión de cadenas
iconv_set_encoding('internal_encoding', 'utf-8');

// Enviar cabecera HTTP para especificar que el contenido es HTML con codificación UTF-8
header('Content-Type: text/html; charset=UTF-8');

// Establecer la zona horaria predeterminada
date_default_timezone_set('America/Monterrey');

// Configurar la localización en español para fechas y horas
setlocale(LC_TIME, 'es_ES.UTF-8');

// Guardar la hora actual en la sesión
$_SESSION['time'] = time();

// Definir la ruta base para acceder a otros archivos
$ruta = "../";


// Extraer todas las variables de sesión y POST para usarlas como variables simples
extract($_SESSION);
extract($_POST);
//print_r($_POST);
// Dependiendo del valor de la variable $tipo_consulta, realizar acciones diferentes
switch ($tipo_consulta) {
    // Caso para una consulta del tipo 'total'
    case 'Total':
        ?>
        <!-- Mostrar el nombre del médico en un título centrado -->
        <h1 style="text-align: center"><b><?php echo $medico; ?></b></h1>

        <!-- Tabla para mostrar los resultados de la consulta -->
        <table class="table table-bordered">
            <tr>
                <th>No.</th>
                <th>Paciente</th>
                <th>Sesiones</th>
                <th>TMS</th>
                <th>tDCS</th>
                <th>Datos</th>
                <th>Médico</th>
            </tr>
        
        <?php
        // Consulta SQL para obtener los datos de los pacientes y las terapias
        $sql = "
            SELECT
                pacientes.paciente_id,
                pacientes.paciente,
                pacientes.apaterno,
                pacientes.amaterno,
                ( SELECT COUNT(*) FROM historico_sesion AS hs WHERE hs.paciente_id = pacientes.paciente_id ) AS sesiones,
                (
                SELECT COUNT(*) 
                FROM historico_sesion
                INNER JOIN protocolo_terapia ON historico_sesion.protocolo_ter_id = protocolo_terapia.protocolo_ter_id 
                WHERE protocolo_terapia.terapia = 'TMS' 
                AND historico_sesion.paciente_id = pacientes.paciente_id 
                ) AS TMS,
                (
                SELECT COUNT(*) 
                FROM historico_sesion
                INNER JOIN protocolo_terapia ON historico_sesion.protocolo_ter_id = protocolo_terapia.protocolo_ter_id 
                WHERE protocolo_terapia.terapia = 'tDCS' 
                AND historico_sesion.paciente_id = pacientes.paciente_id 
                ) AS tDCS,
                (SELECT admin.nombre FROM admin WHERE admin.usuario_id = pacientes.usuario_id) AS medico 
			FROM
				historico_sesion
				INNER JOIN pacientes ON historico_sesion.paciente_id = pacientes.paciente_id
				INNER JOIN admin ON pacientes.usuario_id = admin.usuario_id 
			WHERE
				historico_sesion.f_captura = ( SELECT MIN( hs.f_captura ) FROM historico_sesion hs WHERE hs.paciente_id = historico_sesion.paciente_id ) 
	           	AND MONTH(historico_sesion.f_captura) = $mes 
            	AND YEAR(historico_sesion.f_captura) = $anio
            	AND admin.empresa_id = $empresa_id 
            GROUP BY 1, 2, 3, 4
            ORDER BY 8 ASC";
         // echo $sql;   
        // Mostrar la consulta SQL (para depuración)
        //echo $sql."<hr>";  

        // Ejecutar la consulta
        $result = ejecutar($sql); 

        // Obtener el número de filas resultantes
        $cnt = mysqli_num_rows($result);

        // Verificar si hay resultados
        if ($cnt != 0) {
            // Mostrar cada fila de los resultados
            while($row = mysqli_fetch_array($result)){
                extract($row);  // Extraer las variables de la fila actual
                ?>
                <tr>
                    <td><?php echo $paciente_id; ?></td>
                    <td><?php echo $paciente." ".$apaterno." ".$amaterno; ?></td>
                    <td><?php echo $sesiones; ?></td>
                    <td><?php echo $TMS; ?></td>
                    <td><?php echo $tDCS; ?></td>
                    <td>
                        <!-- Botón para ver más información del paciente -->
                        <a target="_blank" class="btn bg-blue waves-effect" href="<?php echo $ruta; ?>paciente/info_paciente.php?paciente_id=<?php echo $paciente_id; ?>">
                            <i class="material-icons">chat</i> <B>Datos</B>
                        </a>
                    </td>
                    <td><?php echo $medico; ?></td>                  
                </tr>
                <?php
            }
        } else { 
            // Si no hay registros, mostrar un mensaje
            ?>
            <tr>
                <td style="text-align: center" colspan="5"><h1></h1><b>No hay registros</b></td>
            </tr>
            <?php 
        }
        ?>
        </table>
        <?php
    break;

   // Caso para una consulta del tipo 'TMS'
    case 'TMS':
        ?>
        <!-- Mostrar el nombre del médico en un título centrado -->
        <h1 style="text-align: center"><b><?php echo $medico; ?></b></h1>

        <!-- Tabla para mostrar los resultados de la consulta -->
        <table class="table table-bordered">
            <tr>
                <th>No.</th>
                <th>Paciente</th>
                <th>Sesiones</th>
                <th>TMS</th>
                <th>tDCS</th>
                <th>Datos</th>
                <th>Médico</th>
            </tr>
        
        <?php
        // Consulta SQL para obtener los datos de los pacientes y las terapias
        $sql = "
			SELECT
			    pacientes.paciente_id,
			    pacientes.paciente,
			    pacientes.apaterno,
			    pacientes.amaterno,
			    (SELECT COUNT(*) FROM historico_sesion AS hs WHERE hs.paciente_id = pacientes.paciente_id) AS sesiones,
			    (
			        SELECT
			            COUNT(*) 
			        FROM
			            historico_sesion
			        INNER JOIN protocolo_terapia ON historico_sesion.protocolo_ter_id = protocolo_terapia.protocolo_ter_id 
			        WHERE
			            protocolo_terapia.terapia = 'TMS' 
			            AND historico_sesion.paciente_id = pacientes.paciente_id
			    ) AS TMS,
			    (
			        SELECT
			            COUNT(*) 
			        FROM
			            historico_sesion
			        INNER JOIN protocolo_terapia ON historico_sesion.protocolo_ter_id = protocolo_terapia.protocolo_ter_id 
			        WHERE
			            protocolo_terapia.terapia = 'tDCS' 
			            AND historico_sesion.paciente_id = pacientes.paciente_id
			    ) AS tDCS,
			    (SELECT admin.nombre FROM admin WHERE admin.usuario_id = pacientes.usuario_id) AS medico
			FROM
			    historico_sesion
			INNER JOIN pacientes ON historico_sesion.paciente_id = pacientes.paciente_id
			INNER JOIN admin ON pacientes.usuario_id = admin.usuario_id
			WHERE
			    historico_sesion.f_captura = (
			        SELECT MIN(hs.f_captura)
			        FROM historico_sesion hs
			        WHERE hs.paciente_id = historico_sesion.paciente_id
			    )
			    AND MONTH(historico_sesion.f_captura) = $mes
			    AND YEAR(historico_sesion.f_captura) = $anio
			    AND admin.empresa_id = $empresa_id
			    -- Filtrar pacientes que han recibido TMS
			    AND EXISTS (
			        SELECT 1 
			        FROM historico_sesion hs2
			        INNER JOIN protocolo_terapia pt ON hs2.protocolo_ter_id = pt.protocolo_ter_id
			        WHERE pt.terapia = 'TMS' 
			        AND hs2.paciente_id = pacientes.paciente_id
			    )
			GROUP BY
			    1, 2, 3, 4
			ORDER BY
			    8 ASC;";
         // echo $sql;   
        // Mostrar la consulta SQL (para depuración)
        //echo $sql."<hr>";  

        // Ejecutar la consulta
        $result = ejecutar($sql); 

        // Obtener el número de filas resultantes
        $cnt = mysqli_num_rows($result);

        // Verificar si hay resultados
        if ($cnt != 0) {
            // Mostrar cada fila de los resultados
            while($row = mysqli_fetch_array($result)){
                extract($row);  // Extraer las variables de la fila actual
                ?>
                <tr>
                    <td><?php echo $paciente_id; ?></td>
                    <td><?php echo $paciente." ".$apaterno." ".$amaterno; ?></td>
                    <td><?php echo $sesiones; ?></td>
                    <td><?php echo $TMS; ?></td>
                    <td><?php echo $tDCS; ?></td>
                    <td>
                        <!-- Botón para ver más información del paciente -->
                        <a target="_blank" class="btn bg-blue waves-effect" href="<?php echo $ruta; ?>paciente/info_paciente.php?paciente_id=<?php echo $paciente_id; ?>">
                            <i class="material-icons">chat</i> <B>Datos</B>
                        </a>
                    </td>
                    <td><?php echo $medico; ?></td>                  
                </tr>
                <?php
            }
        } else { 
            // Si no hay registros, mostrar un mensaje
            ?>
            <tr>
                <td style="text-align: center" colspan="5"><h1></h1><b>No hay registros</b></td>
            </tr>
            <?php 
        }
        ?>
        </table>
        <?php
    break;
	
   // Caso para una consulta del tipo 'tDCS'
    case 'tDCS':
        ?>
        <!-- Mostrar el nombre del médico en un título centrado -->
        <h1 style="text-align: center"><b><?php echo $medico; ?></b></h1>

        <!-- Tabla para mostrar los resultados de la consulta -->
        <table class="table table-bordered">
            <tr>
                <th>No.</th>
                <th>Paciente</th>
                <th>Sesiones</th>
                <th>TMS</th>
                <th>tDCS</th>
                <th>Datos</th>
                <th>Médico</th>
            </tr>
        
        <?php
        // Consulta SQL para obtener los datos de los pacientes y las terapias
        $sql = "
			SELECT
			    pacientes.paciente_id,
			    pacientes.paciente,
			    pacientes.apaterno,
			    pacientes.amaterno,
			    (SELECT COUNT(*) FROM historico_sesion AS hs WHERE hs.paciente_id = pacientes.paciente_id) AS sesiones,
			    (
			        SELECT
			            COUNT(*) 
			        FROM
			            historico_sesion
			        INNER JOIN protocolo_terapia ON historico_sesion.protocolo_ter_id = protocolo_terapia.protocolo_ter_id 
			        WHERE
			            protocolo_terapia.terapia = 'TMS' 
			            AND historico_sesion.paciente_id = pacientes.paciente_id
			    ) AS TMS,
			    (
			        SELECT
			            COUNT(*) 
			        FROM
			            historico_sesion
			        INNER JOIN protocolo_terapia ON historico_sesion.protocolo_ter_id = protocolo_terapia.protocolo_ter_id 
			        WHERE
			            protocolo_terapia.terapia = 'tDCS' 
			            AND historico_sesion.paciente_id = pacientes.paciente_id
			    ) AS tDCS,
			    (SELECT admin.nombre FROM admin WHERE admin.usuario_id = pacientes.usuario_id) AS medico
			FROM
			    historico_sesion
			INNER JOIN pacientes ON historico_sesion.paciente_id = pacientes.paciente_id
			INNER JOIN admin ON pacientes.usuario_id = admin.usuario_id
			WHERE
			    historico_sesion.f_captura = (
			        SELECT MIN(hs.f_captura)
			        FROM historico_sesion hs
			        WHERE hs.paciente_id = historico_sesion.paciente_id
			    )
			    AND MONTH(historico_sesion.f_captura) = $mes
			    AND YEAR(historico_sesion.f_captura) = $anio
			    AND admin.empresa_id = $empresa_id
			    -- Filtrar pacientes que han recibido TMS
			    AND EXISTS (
			        SELECT 1 
			        FROM historico_sesion hs2
			        INNER JOIN protocolo_terapia pt ON hs2.protocolo_ter_id = pt.protocolo_ter_id
			        WHERE pt.terapia = 'tDCS' 
			        AND hs2.paciente_id = pacientes.paciente_id
			    )
			GROUP BY
			    1, 2, 3, 4
			ORDER BY
			    8 ASC;";
         // echo $sql;   
        // Mostrar la consulta SQL (para depuración)
        //echo $sql."<hr>";  

        // Ejecutar la consulta
        $result = ejecutar($sql); 

        // Obtener el número de filas resultantes
        $cnt = mysqli_num_rows($result);

        // Verificar si hay resultados
        if ($cnt != 0) {
            // Mostrar cada fila de los resultados
            while($row = mysqli_fetch_array($result)){
                extract($row);  // Extraer las variables de la fila actual
                ?>
                <tr>
                    <td><?php echo $paciente_id; ?></td>
                    <td><?php echo $paciente." ".$apaterno." ".$amaterno; ?></td>
                    <td><?php echo $sesiones; ?></td>
                    <td><?php echo $TMS; ?></td>
                    <td><?php echo $tDCS; ?></td>
                    <td>
                        <!-- Botón para ver más información del paciente -->
                        <a target="_blank" class="btn bg-blue waves-effect" href="<?php echo $ruta; ?>paciente/info_paciente.php?paciente_id=<?php echo $paciente_id; ?>">
                            <i class="material-icons">chat</i> <B>Datos</B>
                        </a>
                    </td>
                    <td><?php echo $medico; ?></td>                  
                </tr>
                <?php
            }
        } else { 
            // Si no hay registros, mostrar un mensaje
            ?>
            <tr>
                <td style="text-align: center" colspan="5"><h1></h1><b>No hay registros</b></td>
            </tr>
            <?php 
        }
        ?>
        </table>
        <?php
    break;	
    // Caso para una consulta del tipo 'diaria'
    case 'diaria':
        ?>
        <!-- Mostrar el nombre del médico en un título centrado -->
        <h1 style="text-align: center"><b><?php echo $medico; ?></b></h1>

        <!-- Tabla para mostrar los resultados de la consulta diaria -->
        <table class="table table-bordered">
            <tr>
                <th>No.</th>
                <th>Paciente</th>
                <th>Sesiones</th>
                <th>TMS</th>
                <th>tDCS</th>
                <th>Datos</th>
            </tr>
        
        <?php
        // Consulta SQL para obtener los datos de los pacientes y las terapias diarias
        $sql = "
            SELECT
                pacientes.paciente_id,
                pacientes.paciente,
                pacientes.apaterno,
                pacientes.amaterno,
                (SELECT COUNT(*) FROM historico_sesion AS hs WHERE hs.paciente_id = pacientes.paciente_id) AS sesiones,
                (
                SELECT COUNT(*) 
                FROM historico_sesion
                INNER JOIN protocolo_terapia ON historico_sesion.protocolo_ter_id = protocolo_terapia.protocolo_ter_id 
                WHERE protocolo_terapia.terapia = 'TMS' 
                AND historico_sesion.paciente_id = pacientes.paciente_id 
                ) AS TMS,
                (
                SELECT COUNT(*) 
                FROM historico_sesion
                INNER JOIN protocolo_terapia ON historico_sesion.protocolo_ter_id = protocolo_terapia.protocolo_ter_id 
                WHERE protocolo_terapia.terapia = 'tDCS' 
                AND historico_sesion.paciente_id = pacientes.paciente_id 
                ) AS tDCS 
            FROM historico_sesion
            INNER JOIN pacientes ON historico_sesion.paciente_id = pacientes.paciente_id 
            WHERE pacientes.usuario_id = $usuario_idx 
            AND historico_sesion.f_captura = (SELECT MIN(hs.f_captura) FROM historico_sesion hs WHERE hs.paciente_id = historico_sesion.paciente_id)
            AND MONTH(historico_sesion.f_captura) = $mes 
            AND YEAR(historico_sesion.f_captura) = $anio 
            GROUP BY 1, 2, 3, 4";
            
        // Mostrar la consulta SQL (para depuración)
        //echo $sql."<hr>"; 

        // Ejecutar la consulta
        $result = ejecutar($sql);

        // Obtener el número de filas resultantes
        $cnt = mysqli_num_rows($result);

        // Verificar si hay resultados
        if ($cnt != 0) {
            // Mostrar cada fila de los resultados
            while($row = mysqli_fetch_array($result)){
                extract($row);  // Extraer las variables de la fila actual
                ?>
                <tr>
                    <td><?php echo $paciente_id; ?></td>
                    <td><?php echo $paciente." ".$apaterno." ".$amaterno; ?></td>
                    <td><?php echo $sesiones; ?></td>
                    <td><?php echo $TMS; ?></td>
                    <td><?php echo $tDCS; ?></td>
                    <td>
                        <!-- Botón para ver más información del paciente -->
                        <a target="_blank" class="btn bg-blue waves-effect" href="<?php echo $ruta; ?>paciente/info_paciente.php?paciente_id=<?php echo $paciente_id; ?>">
                            <i class="material-icons">chat</i> <B>Datos</B>
                        </a>
                    </td>
                </tr>
                <?php
            }
        } else { 
            // Si no hay registros, mostrar un mensaje
            ?>
            <tr>
                <td style="text-align: center" colspan="5"><h1></h1><b>No hay registros</b></td>
            </tr>
            <?php 
        }

    break;
    // Caso para una consulta del tipo 'total'
    case 'total_usuario':
        ?>
        <!-- Mostrar el nombre del médico en un título centrado -->
        <h1 style="text-align: center"><b><?php echo $medico; ?></b></h1>

        <!-- Tabla para mostrar los resultados de la consulta -->
        <table class="table table-bordered">
            <tr>
                <th>No.</th>
                <th>Paciente</th>
                <th>Sesiones</th>
                <th>TMS</th>
                <th>tDCS</th>
                <th>Datos</th>
                <th>Médico</th>
            </tr>
        
        <?php
        // Consulta SQL para obtener los datos de los pacientes y las terapias
        $sql = "
            SELECT
                pacientes.paciente_id,
                pacientes.paciente,
                pacientes.apaterno,
                pacientes.amaterno,
                ( SELECT COUNT(*) FROM historico_sesion AS hs WHERE hs.paciente_id = pacientes.paciente_id ) AS sesiones,
                (
                SELECT COUNT(*) 
                FROM historico_sesion
                INNER JOIN protocolo_terapia ON historico_sesion.protocolo_ter_id = protocolo_terapia.protocolo_ter_id 
                WHERE protocolo_terapia.terapia = 'TMS' 
                AND historico_sesion.paciente_id = pacientes.paciente_id 
                ) AS TMS,
                (
                SELECT COUNT(*) 
                FROM historico_sesion
                INNER JOIN protocolo_terapia ON historico_sesion.protocolo_ter_id = protocolo_terapia.protocolo_ter_id 
                WHERE protocolo_terapia.terapia = 'tDCS' 
                AND historico_sesion.paciente_id = pacientes.paciente_id 
                ) AS tDCS,
                (SELECT admin.nombre FROM admin WHERE admin.usuario_id = pacientes.usuario_id) AS medico 
			FROM
				historico_sesion
				INNER JOIN pacientes ON historico_sesion.paciente_id = pacientes.paciente_id
				INNER JOIN admin ON pacientes.usuario_id = admin.usuario_id 
			WHERE
				historico_sesion.f_captura = ( SELECT MIN( hs.f_captura ) FROM historico_sesion hs WHERE hs.paciente_id = historico_sesion.paciente_id ) 
            	AND historico_sesion.f_captura BETWEEN DATE_SUB(CURDATE(), INTERVAL 13 MONTH) AND CURDATE()
            	AND admin.empresa_id = $empresa_id 
            	AND admin.usuario_id = $usuario_idx
            GROUP BY 1, 2, 3, 4
            ORDER BY 8 ASC";
         // echo $sql;   
        // Mostrar la consulta SQL (para depuración)
        //echo $sql."<hr>";  

        // Ejecutar la consulta
        $result = ejecutar($sql); 

        // Obtener el número de filas resultantes
        $cnt = mysqli_num_rows($result);

        // Verificar si hay resultados
        if ($cnt != 0) {
            // Mostrar cada fila de los resultados
            while($row = mysqli_fetch_array($result)){
                extract($row);  // Extraer las variables de la fila actual
                ?>
                <tr>
                    <td><?php echo $paciente_id; ?></td>
                    <td><?php echo $paciente." ".$apaterno." ".$amaterno; ?></td>
                    <td><?php echo $sesiones; ?></td>
                    <td><?php echo $TMS; ?></td>
                    <td><?php echo $tDCS; ?></td>
                    <td>
                        <!-- Botón para ver más información del paciente -->
                        <a target="_blank" class="btn bg-blue waves-effect" href="<?php echo $ruta; ?>paciente/info_paciente.php?paciente_id=<?php echo $paciente_id; ?>">
                            <i class="material-icons">chat</i> <B>Datos</B>
                        </a>
                    </td>
                    <td><?php echo $medico; ?></td>                  
                </tr>
                <?php
            }
        } else { 
            // Si no hay registros, mostrar un mensaje
            ?>
            <tr>
                <td style="text-align: center" colspan="5"><h1></h1><b>No hay registros</b></td>
            </tr>
            <?php 
        }
        ?>
        </table>
        <?php
    break;
	
    case 'total_global':
		
if ($tipo == 'Total') {
        ?>
        <!-- Mostrar el nombre del médico en un título centrado -->
        <h1 style="text-align: center"><b><?php echo $medico; ?></b></h1>

        <!-- Tabla para mostrar los resultados de la consulta -->
        <table class="table table-bordered">
            <tr>
                <th>No.</th>
                <th>Paciente</th>
                <th>Sesiones</th>
                <th>TMS</th>
                <th>tDCS</th>
                <th>Datos</th>
                <th>Médico</th>
            </tr>
        
        <?php
        // Consulta SQL para obtener los datos de los pacientes y las terapias
        $sql = "
            SELECT
                pacientes.paciente_id,
                pacientes.paciente,
                pacientes.apaterno,
                pacientes.amaterno,
                ( SELECT COUNT(*) FROM historico_sesion AS hs WHERE hs.paciente_id = pacientes.paciente_id ) AS sesiones,
                (
                SELECT COUNT(*) 
                FROM historico_sesion
                INNER JOIN protocolo_terapia ON historico_sesion.protocolo_ter_id = protocolo_terapia.protocolo_ter_id 
                WHERE protocolo_terapia.terapia = 'TMS' 
                AND historico_sesion.paciente_id = pacientes.paciente_id 
                ) AS TMS,
                (
                SELECT COUNT(*) 
                FROM historico_sesion
                INNER JOIN protocolo_terapia ON historico_sesion.protocolo_ter_id = protocolo_terapia.protocolo_ter_id 
                WHERE protocolo_terapia.terapia = 'tDCS' 
                AND historico_sesion.paciente_id = pacientes.paciente_id 
                ) AS tDCS,
                (SELECT admin.nombre FROM admin WHERE admin.usuario_id = pacientes.usuario_id) AS medico 
			FROM
				historico_sesion
				INNER JOIN pacientes ON historico_sesion.paciente_id = pacientes.paciente_id
				INNER JOIN admin ON pacientes.usuario_id = admin.usuario_id 
			WHERE
				historico_sesion.f_captura = ( SELECT MIN( hs.f_captura ) FROM historico_sesion hs WHERE hs.paciente_id = historico_sesion.paciente_id ) 
	           	AND historico_sesion.f_captura BETWEEN DATE_SUB(CURDATE(), INTERVAL 13 MONTH) AND CURDATE()
            	AND admin.empresa_id = $empresa_id 
            GROUP BY 1, 2, 3, 4
            ORDER BY 8 ASC";
         // echo $sql;   
        // Mostrar la consulta SQL (para depuración)
        //echo $sql."<hr>";  

        // Ejecutar la consulta
        $result = ejecutar($sql); 

        // Obtener el número de filas resultantes
        $cnt = mysqli_num_rows($result);

        // Verificar si hay resultados
        if ($cnt != 0) {
            // Mostrar cada fila de los resultados
            while($row = mysqli_fetch_array($result)){
                extract($row);  // Extraer las variables de la fila actual
                ?>
                <tr>
                    <td><?php echo $paciente_id; ?></td>
                    <td><?php echo $paciente." ".$apaterno." ".$amaterno; ?></td>
                    <td><?php echo $sesiones; ?></td>
                    <td><?php echo $TMS; ?></td>
                    <td><?php echo $tDCS; ?></td>
                    <td>
                        <!-- Botón para ver más información del paciente -->
                        <a target="_blank" class="btn bg-blue waves-effect" href="<?php echo $ruta; ?>paciente/info_paciente.php?paciente_id=<?php echo $paciente_id; ?>">
                            <i class="material-icons">chat</i> <B>Datos</B>
                        </a>
                    </td>
                    <td><?php echo $medico; ?></td>                  
                </tr>
                <?php
            }
        } else { 
            // Si no hay registros, mostrar un mensaje
            ?>
            <tr>
                <td style="text-align: center" colspan="5"><h1></h1><b>No hay registros</b></td>
            </tr>
            <?php 
        }
        ?>
        </table>
        <?php	
} else {
	
        ?>
        <!-- Mostrar el nombre del médico en un título centrado -->
        <h1 style="text-align: center"><b><?php echo $medico; ?></b></h1>

        <!-- Tabla para mostrar los resultados de la consulta -->
        <table class="table table-bordered">
            <tr>
                <th>No.</th>
                <th>Paciente</th>
                <th>Sesiones</th>
                <th>TMS</th>
                <th>tDCS</th>
                <th>Datos</th>
                <th>Médico</th>
            </tr>
        
        <?php
        // Consulta SQL para obtener los datos de los pacientes y las terapias
        $sql = "
			SELECT
			    pacientes.paciente_id,
			    pacientes.paciente,
			    pacientes.apaterno,
			    pacientes.amaterno,
			    (SELECT COUNT(*) FROM historico_sesion AS hs WHERE hs.paciente_id = pacientes.paciente_id) AS sesiones,
			    (
			        SELECT
			            COUNT(*) 
			        FROM
			            historico_sesion
			        INNER JOIN protocolo_terapia ON historico_sesion.protocolo_ter_id = protocolo_terapia.protocolo_ter_id 
			        WHERE
			            protocolo_terapia.terapia = 'TMS' 
			            AND historico_sesion.paciente_id = pacientes.paciente_id
			    ) AS TMS,
			    (
			        SELECT
			            COUNT(*) 
			        FROM
			            historico_sesion
			        INNER JOIN protocolo_terapia ON historico_sesion.protocolo_ter_id = protocolo_terapia.protocolo_ter_id 
			        WHERE
			            protocolo_terapia.terapia = 'tDCS' 
			            AND historico_sesion.paciente_id = pacientes.paciente_id
			    ) AS tDCS,
			    (SELECT admin.nombre FROM admin WHERE admin.usuario_id = pacientes.usuario_id) AS medico
			FROM
			    historico_sesion
			INNER JOIN pacientes ON historico_sesion.paciente_id = pacientes.paciente_id
			INNER JOIN admin ON pacientes.usuario_id = admin.usuario_id
			WHERE
			    historico_sesion.f_captura = (
			        SELECT MIN(hs.f_captura)
			        FROM historico_sesion hs
			        WHERE hs.paciente_id = historico_sesion.paciente_id
			    )
			    AND historico_sesion.f_captura BETWEEN DATE_SUB(CURDATE(), INTERVAL 13 MONTH) AND CURDATE()
			    AND admin.empresa_id = $empresa_id
			    
			    AND EXISTS (
			        SELECT 1 
			        FROM historico_sesion hs2
			        INNER JOIN protocolo_terapia pt ON hs2.protocolo_ter_id = pt.protocolo_ter_id
			        WHERE pt.terapia = '$tipo' 
			        AND hs2.paciente_id = pacientes.paciente_id
			    )
			GROUP BY
			    1, 2, 3, 4
			ORDER BY
			    8 ASC;";
         // echo $sql;   
        // Mostrar la consulta SQL (para depuración)
        //echo $sql."<hr>";  

        // Ejecutar la consulta
        $result = ejecutar($sql); 

        // Obtener el número de filas resultantes
        $cnt = mysqli_num_rows($result);

        // Verificar si hay resultados
        if ($cnt != 0) {
            // Mostrar cada fila de los resultados
            while($row = mysqli_fetch_array($result)){
                extract($row);  // Extraer las variables de la fila actual
                ?>
                <tr>
                    <td><?php echo $paciente_id; ?></td>
                    <td><?php echo $paciente." ".$apaterno." ".$amaterno; ?></td>
                    <td><?php echo $sesiones; ?></td>
                    <td><?php echo $TMS; ?></td>
                    <td><?php echo $tDCS; ?></td>
                    <td>
                        <!-- Botón para ver más información del paciente -->
                        <a target="_blank" class="btn bg-blue waves-effect" href="<?php echo $ruta; ?>paciente/info_paciente.php?paciente_id=<?php echo $paciente_id; ?>">
                            <i class="material-icons">chat</i> <B>Datos</B>
                        </a>
                    </td>
                    <td><?php echo $medico; ?></td>                  
                </tr>
                <?php
            }
        } else { 
            // Si no hay registros, mostrar un mensaje
            ?>
            <tr>
                <td style="text-align: center" colspan="5"><h1></h1><b>No hay registros</b></td>
            </tr>
            <?php 
        }
        ?>
        </table>
        <?php
        }
    break;		
}
