<?php
// Definir la ruta base para incluir archivos
$ruta="../";
// Obtener la fecha actual en formato "YYYY-MM-DD"
$hoy = date("Y-m-d");
// Obtener la hora actual en formato "HH:MM:00"
$ahora = date("H:i:00");
// Obtener el año actual
$anio = date("Y");
// Obtener el mes actual en formato numérico "MM"
$mes_ahora = date("m");
// Definir el título de la página actual
$titulo = "Directorio"; 

// Incluir la primera parte del header que contiene configuraciones iniciales
include($ruta.'header1.php');
//include($ruta.'header.php'); // Este es un include comentado que podrías utilizar si decides cambiar el header
?>
    <!-- Inclusión de los estilos para DataTable de JQuery -->
    <link href="<?php echo $ruta; ?>plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

<?php
// Incluir la segunda parte del header con la barra de navegación y el menú
include($ruta.'header2.php');

// Condicional para definir la clase y los criterios de filtro en base a la función del usuario
if ($funcion == 'SISTEMAS' || $funcion == 'ADMINISTRADOR' || $funcion == 'TECNICO' || $funcion == 'COORDINADOR'  || $funcion == 'REPRESENTANTE') {
    // Si el usuario es uno de los mencionados, se permite la exportación de la tabla
    $class = "js-exportable";  
    // Filtro por empresa
    $where = "AND pacientes.empresa_id=$empresa_id ";
} else {
    // Para otros usuarios, se establece una clase básica sin opciones de exportación
    $class = "js-basic-example";
    // Si el usuario es médico, solo se muestran los pacientes asociados a él
    if ($funcion == 'MEDICO') {
        $where = " AND pacientes.empresa_id=$empresa_id AND pacientes.usuario_id = $usuario_id";
    } else {
        // Si es otra función, no se aplica ningún filtro adicional
        $where = "";
    }
}
?>

<!-- Inicio de la sección de contenido principal -->
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <!-- Título de la página -->
            <h2>DIRECTORIO</h2>
            <!-- Depuración opcional para imprimir los datos de la sesión -->
            <?php //print_r($_SESSION); ?>
        </div>

        <!-- Contenedor del contenido principal -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div style="height: 95%" class="header">
                        <!-- Título de la sección -->
                        <h1 align="center">Directorio Pacientes</h1>                        
                        <div class="body">
                            <div class="table-responsive">
                                <!-- Tabla de pacientes, con opciones de exportación si están habilitadas -->
                                <table class="table table-bordered table-striped table-hover dataTable <?php echo $class; ?>">
                                    <thead>
                                        <tr>
                                            <!-- Columnas de la tabla -->
                                            <th style="display: none"></th>
                                            <th style="max-width: 10px">ID</th>
                                            <th style="min-width: 40px">Fecha</th>
                                            <th style="min-width: 120px">Nombre</th>
                                            <th style="max-width: 15px">TMS</th> 
                                            <th style="max-width: 15px">tDCS</th>                                          
                                            <th style="min-width: 50px">Celular</th>
                                            <th style="min-width: 40px">Estatus</th>
                                            <th style="min-width: 220px">Acción</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>                                          
                                            <!-- Filtros o pie de tabla -->
                                            <th style="display: none"></th>
                                            <th style="max-width: 10px">ID</th>
                                            <th style="min-width: 40px">Fecha</th>
                                            <th style="min-width: 120px">Nombre</th>
                                            <th style="max-width: 15px">TMS</th> 
                                            <th style="max-width: 15px">tDCS</th>                                          
                                            <th style="min-width: 50px">Celular</th>
                                            <th style="min-width: 40px">Estatus</th>
                                            <th style="min-width: 220px">Acción</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php
                                    // Consulta SQL para obtener la información de los pacientes
                                    $sql_protocolo = "
                                        SELECT DISTINCT
                                            pacientes.*,
                                            estatus_paciente.color,
                                            estatus_paciente.rgb,
                                            estatus_paciente.class,
                                            (SELECT DISTINCT COUNT(*) AS total_sesion FROM historico_sesion WHERE historico_sesion.paciente_id = pacientes.paciente_id) AS total_sesion,
                                            (SELECT DISTINCT COUNT(*) AS total_tms FROM historico_sesion INNER JOIN protocolo_terapia ON historico_sesion.protocolo_ter_id = protocolo_terapia.protocolo_ter_id WHERE historico_sesion.paciente_id = pacientes.paciente_id AND protocolo_terapia.terapia = 'TMS') AS total_TMS,
                                            (SELECT DISTINCT COUNT(*) AS total_tdcs FROM historico_sesion INNER JOIN protocolo_terapia ON historico_sesion.protocolo_ter_id = protocolo_terapia.protocolo_ter_id WHERE historico_sesion.paciente_id = pacientes.paciente_id AND protocolo_terapia.terapia = 'tDCS') AS total_tDCS,
                                            (SELECT SUM(cobros.cantidad) AS total FROM cobros WHERE cobros.empresa_id = $empresa_id AND cobros.paciente_id = pacientes.paciente_id ORDER BY cobros.f_captura ASC) AS cnt_pagos,
                                            (SELECT SUM(cobros.importe) AS total FROM cobros WHERE cobros.empresa_id = pacientes.empresa_id AND cobros.paciente_id = pacientes.paciente_id ORDER BY cobros.f_captura ASC) AS pago,
                                            admin.nombre AS medico
                                        FROM
                                            pacientes
                                        INNER JOIN estatus_paciente ON pacientes.estatus = estatus_paciente.estatus
                                        INNER JOIN admin ON pacientes.usuario_id = admin.usuario_id 
                                        WHERE
                                            pacientes.estatus <>'Eliminado' AND pacientes.empresa_id = $empresa_id $where
                                        ORDER BY f_captura DESC
                                    ";
                                    // Mostrar la consulta SQL (opcional para depuración)
                                    //echo $sql_protocolo."<br>";
                                    //echo $sql_protocolo."<hr>";

                                    // Ejecutar la consulta y almacenar el resultado
                                    $result_protocolo = ejecutar($sql_protocolo); 
                                    $cnt = 0;  // Contador de pacientes
                                    $total = 0;  // Total de pacientes

                                    // Iterar sobre los resultados de la consulta y construir las filas de la tabla
                                    while ($row_protocolo = mysqli_fetch_array($result_protocolo)) {
                                        extract($row_protocolo);
                                        if ($class == 'bg-yellow') {
                                            $class = "class='$class' style='color: black !important;'";
                                        } else {
                                            $class = "class='$class'";
                                        }
										
										$pago = is_null($pago) ? 0 : $pago;
										$cnt_pagos = is_null($cnt_pagos) ? 0 : $cnt_pagos;

                                    	//echo "<hr>Paciente: $paciente_id, Pago: $pago, cnt_pagos: $cnt_pagos, Fecha Captura: $f_captura, Sesiones: $total_sesion<br>";
                                    
										// Convertir la fecha al formato deseado
										$date = new DateTime($f_captura);
										$today = $date->format('d-M-y');

                                        $terapias = $total_TMS + $total_tDCS;  // Calcular el total de terapias

                                        // Lógica para mostrar mensajes basados en el estado de pagos y terapias
                                        if ($terapias >= 1 && $pago == 0 && $cnt_pagos == 0 && $f_captura >= '2024-04-01') {
                                            $pagos = $terapias * 1000;
                                            $span = '<span class="label label-danger">Falta Pago de $' . number_format($pagos) . '</span>';
                                        } else {
											if ($pago == 0 && $cnt_pagos == 0 && $f_captura >= '2024-04-01') {
                                                   
                                                    $span = '<span class="label label-warning">Sin Saldo ' . $pago . '</span>';												
											} else {
	                                            // Otras condiciones relacionadas con el pago y las terapias
	                                            if ($pago == 30000 || $pago == 24000 || $pago == 15000 || $cnt_pagos == 30) {
	                                            	
	                                                $terapias_pag = 30;
	                                                if (($terapias == $terapias_pag && $pago != 0) || ($terapias == $cnt_pagos)) {
	                                                	
	                                                    $span = '<span class="label label-primary">Concluido las sesiones</span>';
	                                                } else {
	                                                    	
	                                                    $span = '<span class="label label-success">Con saldo disponible<br>Restan '.($cnt_pagos-$total_sesion).' terapias</span>';
	                                                }
	                                            } elseif ($pago < 24000) {
	                                                $terapias_pag = $pago / 1000;
	                                                if ($terapias > $terapias_pag && $pago >= 0 && $f_captura >= '2024-04-01') {
	                                                	
	                                                    $pagos = ($terapias - $terapias_pag) * 1000;
	                                                    $span = '<span class="label label-danger">Falta Pago de $' . number_format($pagos) . '</span>';
	                                                } else {	
	                                                    switch ($estatus) {
	                                                        case 'Pendiente':
	                                                        
	                                                            $span = '';
	                                                            break;
	                                                        case 'Confirmado':
	                                                        
	                                                            $span = '<span class="label label-warning">Pendiente de Saldo ' . $pago . '</span>';
	                                                            break;
	                                                        case 'Seguimiento':
	                                                        
	                                                            $span = '<span class="label label-warning">Sin Saldo ' . $pago . '</span>';
	                                                            break;
	                                                        case 'Activo':
																
	                                                            $terapias_pag = $pago / 1000;
																
	                                                            if ($terapias == $terapias_pag && $pago != 0) {

	                                                                $span = '<span class="label label-warning">Concluido el saldo</span>';
	                                                            } else {
           	                                                        if (($cnt_pagos-$total_sesion)<0 && $f_captura >= '2024-04-01') {
																		//$span = '<span class="label label-warning">Concluido el saldo</span>';
												                        $pagos = ($terapias - $terapias_pag) * 1000;
	                                                    				$span = '<span class="label label-danger">Falta Pago de $' . number_format($pagos) . '</span>';							
																	} else {
																		if (($cnt_pagos-$total_sesion)<0) {
																			$span = '<span class="label label-warning">Concluido el saldo</span>';
																		} else {
																			$span = '<span class="label label-success">Con saldo disponible<br>Restan '.($cnt_pagos-$total_sesion).' terapias</span>';
																		}
																	}                 			
	                                                            }
	                                                            break;
	                                                    }
	                                                }
	                                            } else {
	                                                $span = '<span class="label label-success">Saldo $' . $pago . '</span>';
	                                            }
												
											}
												                                            
                                        }
                                        // Incrementar el contador de pacientes
                                        $cnt++;
                                    ?>  
                                        <!-- Renderizar la fila de la tabla con los datos del paciente -->
                                        <tr>
                                            <td style="display: none"><?php echo $cnt; ?></td>
                                            <td><?php echo $paciente_id; ?></td>
                                            <td><?php echo $today; ?><br><?php // echo $f_captura; ?></td>
                                            <td>
                                                <b><?php echo $paciente . " " . $apaterno . " " . $amaterno; ?></b>
                                                <br>
                                                <i><?php echo $medico; ?></i>
                                            </td>
                                            <td><?php echo $total_TMS; ?></td>
                                            <td><?php echo $total_tDCS; ?></td>
                                            <td><?php echo $celular; ?></td>
                                            <td <?php echo $class; ?>><?php echo $estatus; ?><br><?php echo $span; ?></td>
                                            <td>
                                                <!-- Botones de acción para cada paciente -->
                                                <div class="btn-group" role="group">
                                                    <!-- Botón para ver la agenda del paciente -->
                                                    <a class="btn bg-cyan waves-effect" href="<?php echo $ruta; ?>agenda/agenda.php?paciente_id=<?php echo $paciente_id; ?>">
                                                        <i class="material-icons">call_missed_outgoing</i> <B>Agenda</B>
                                                    </a>
                                                    <!-- Botón para ver información del paciente -->
                                                    <a class="btn bg-blue waves-effect" href="<?php echo $ruta; ?>paciente/info_paciente.php?paciente_id=<?php echo $paciente_id; ?>">
                                                        <i class="material-icons">chat</i> <B>Datos</B>
                                                    </a>
                                                    <!-- Botón para editar los datos del paciente -->
                                                    <a class="btn btn-info waves-effect" href="<?php echo $ruta; ?>paciente/paciente_edit.php?paciente_id=<?php echo $paciente_id; ?>">
                                                        <i class="material-icons">edit</i> <B>Edit</B>
                                                    </a>                                        
                                                </div>                                       
                                            </td>
                                        </tr>
                                    <?php 
                                        // Reiniciar el mensaje de alerta de pago
                                        $span = ''; 
                                    } 
                                    ?>     
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php 
// Incluir la primera parte del footer que contiene scripts iniciales
include($ruta.'footer1.php'); 
?>

<!-- Incluir los scripts necesarios para el funcionamiento de DataTable -->
<script src="<?php echo $ruta; ?>plugins/jquery-datatable/jquery.dataTables.js"></script>
<script src="<?php echo $ruta; ?>plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
<script src="<?php echo $ruta; ?>plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
<script src="<?php echo $ruta; ?>plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
<script src="<?php echo $ruta; ?>plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
<script src="<?php echo $ruta; ?>plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
<script src="<?php echo $ruta; ?>plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
<script src="<?php echo $ruta; ?>plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
<script src="<?php echo $ruta; ?>plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>

<!-- Inicializar el DataTable para la tabla -->
<script src="<?php echo $ruta; ?>js/pages/tables/jquery-datatable.js"></script>

<?php 
// Incluir la segunda parte del footer que finaliza la estructura HTML
include($ruta.'footer2.php'); 
?>
                                                            