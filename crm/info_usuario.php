<?php
// Definir la ruta base para las inclusiones de archivos
$ruta = "../";

// Establecer la zona horaria predeterminada
date_default_timezone_set('America/Mexico_City'); // Ajusta la zona horaria según tu ubicación

// Variables de fecha y hora actuales
$hoy = date("Y-m-d"); // Fecha actual en formato YYYY-MM-DD
$ahora = date("H:i:00"); // Hora actual en formato HH:MM:00
$anio = date("Y"); // Año actual
$mes_ahora = date("m"); // Mes actual en formato numérico

// Obtener el nombre del mes en español sin usar strftime()
$meses_espanol = [
    '01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo',
    '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio',
    '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre',
    '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre'
];
$mes = $meses_espanol[$mes_ahora];

$dia = date("N"); // Número del día de la semana (1=Lunes, 7=Domingo)
$semana = date("W"); // Número de la semana del año

// Definir el título de la página
$titulo = "Datos Médico";

// Incluir la primera parte del header que contiene configuraciones iniciales
include($ruta . 'header1.php');

// Incluir archivos CSS adicionales necesarios para el funcionamiento de la página
?>
<!-- Estilos para la tabla de datos de JQuery DataTable -->
<link href="<?php echo $ruta; ?>plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

<!-- Estilos para el selector de fecha y hora con Bootstrap Material -->
<link href="<?php echo $ruta; ?>plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />

<!-- Estilos para el selector de fecha de Bootstrap -->
<link href="<?php echo $ruta; ?>plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />

<!-- Estilos para el plugin "Wait Me" que muestra un indicador de carga -->
<link href="<?php echo $ruta; ?>plugins/waitme/waitMe.css" rel="stylesheet" />

<!-- Estilos para el select de Bootstrap -->
<link href="<?php echo $ruta; ?>plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />

<?php
// Incluir la segunda parte del header que contiene la barra de navegación y el menú
include($ruta . 'header2.php');

// Validar y sanitizar los parámetros GET
$usuario_idx = isset($_GET['usuario_idx']) ? intval($_GET['usuario_idx']) : 0;

if ($usuario_idx <= 0) {
    die('ID de usuario inválido.');
}

// Preparar y ejecutar consultas utilizando sentencias preparadas
// Asumiendo que $mysql es la instancia de la clase Mysql

$sql_medico = "
    SELECT
        admin.usuario_id AS medico_id,
        admin.nombre AS nombrex,
        admin.usuario AS usuariox,
        admin.observaciones AS observaciones_med,
        admin.organizacion,
        admin.estatus AS estatusx,
        admin.telefono AS celular,
        admin.especialidad,
        admin.horarios,
        (SELECT COUNT(*) FROM pacientes WHERE pacientes.usuario_id = admin.usuario_id) AS pacientes,
        (SELECT cedula FROM cedulas WHERE cedulas.usuario_id = admin.usuario_id AND cedulas.principal = 'si' LIMIT 1) AS cedula_profesional
    FROM admin
    WHERE admin.empresa_id = ? 
      AND admin.usuario_id = ?
";

// Ejecutar consulta preparada
$params_medico = [$empresa_id, $usuario_idx];
$result_medico = $mysql->consulta($sql_medico, $params_medico);


// Verificar si se encontraron resultados
if ($result_medico['numFilas'] > 0) {
    $row_medico = $result_medico['resultado'][0];

    // Asignar variables de forma segura usando sanitizarValor()
    $medico_id = intval($row_medico['medico_id']);
    $nombrex = sanitizarValor($row_medico['nombrex']);
    $usuariox = sanitizarValor($row_medico['usuariox']);
    $observaciones_med = sanitizarValor($row_medico['observaciones_med']);
    $organizacion = sanitizarValor($row_medico['organizacion']);
    $estatusx = sanitizarValor($row_medico['estatusx']);
    $celular = sanitizarValor($row_medico['celular']);
    $especialidad = sanitizarValor($row_medico['especialidad']);
    $horarios = sanitizarValor($row_medico['horarios']);
    $pacientes = intval($row_medico['pacientes']);
	$cedula_profesional = intval($row_medico['cedula_profesional']);
} else {
    die('Médico no encontrado.');
}

// Obtener datos de ubicación del médico
$sql_ubicacion = "
    SELECT
        ubicacion_medico.ubicacion_id,
        ubicacion_medico.domicilio,
        ubicacion_medico.latitud,
        ubicacion_medico.longitud,
        ubicacion_medico.telefono,
        ubicacion_medico.extension,
        ubicacion_medico.observaciones,
        ubicacion_medico.usuario_id
    FROM
        ubicacion_medico
    WHERE
        ubicacion_medico.usuario_id = ?
";

$params_ubicacion = [ $medico_id ];
$result_ubicacion = $mysql->consulta($sql_ubicacion, $params_ubicacion);

if ($result_ubicacion['numFilas'] > 0) {
    $row_ubicacion = $result_ubicacion['resultado'][0];

    // Asignar variables de forma segura usando sanitizarValor()
    $ubicacion_id = intval($row_ubicacion['ubicacion_id']);
    $domicilio = sanitizarValor($row_ubicacion['domicilio']);
    $latitud = sanitizarValor($row_ubicacion['latitud']);
    $longitud = sanitizarValor($row_ubicacion['longitud']);
    $telefono = sanitizarValor($row_ubicacion['telefono']);
    $extension = sanitizarValor($row_ubicacion['extension']);
    $observaciones = sanitizarValor($row_ubicacion['observaciones']);
} else {
    // Si no hay datos de ubicación, inicializar variables
    $ubicacion_id = null;
    $domicilio = '';
    $latitud = '';
    $longitud = '';
    $telefono = '';
    $extension = '';
    $observaciones = '';
}
?>

<!-- Inicio del contenido principal de la página -->
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>DATOS MÉDICO</h2>
            <?php echo $ubicacion_url."<br>"; ?>
        </div>
        <!-- Contenido principal de la página -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <!-- Encabezado de la tarjeta que muestra el nombre del médico -->
                    <div style="height: 95%" class="header">
                        <form id="wizard_with_validation">
                            <!-- Campo oculto para usuario_id -->
                            <input type="hidden" id="usuario_id" name="usuario_id" value="<?php echo $medico_id; ?>" />

                            <h3>Nombre del Médico <?php echo $medico_id; ?></h3>
                            <fieldset>
                                <!-- Nombre del Médico -->
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" id="nombre" name="nombre" value="<?php echo $nombrex; ?>" class="form-control" required>
                                        <label class="form-label">Nombre(s)*</label>
                                    </div>
                                </div>

                                <!-- Correo Electrónico -->
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="email" id="usuario" name="usuario" class="form-control" value="<?php echo $usuariox; ?>" required>
                                        <label class="form-label">Correo Electrónico*</label>
                                    </div>
                                </div>

                                <!-- Teléfono -->
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="tel" id="celular" name="telefono" class="form-control" value="<?php echo $celular; ?>" required>
                                        <label class="form-label">Celular*</label>
                                    </div>
                                </div>

								<!-- Campo de Cedula Profesional -->
								<div class="form-group form-float">
									<div class="form-line">
										<input type="tel" id="cedula" name="cedula" class="form-control" value="<?php echo $cedula_profesional; ?>" required>
										<label max="10" class="form-label">Cedula Profesional</label>
									</div>
								</div>

                                <!-- Observaciones -->
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <label class="form-label">Observaciones</label>
                                        <textarea id="observaciones_x" name="observaciones" class="form-control"><?php echo $observaciones_med; ?></textarea>
                                    </div>
                                </div>

                                <!-- Especialidad -->
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" id="especialidad" name="especialidad" class="form-control" value="<?php echo $especialidad; ?>" required>
                                        <label class="form-label">Especialidad*</label>
                                    </div>
                                </div>

                                <!-- Horarios -->
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <label class="form-label">Horarios</label>
                                        <textarea id="horarios" name="horarios" class="form-control"><?php echo $horarios; ?></textarea>
                                    </div>
                                </div>

                                <!-- Estatus -->
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <label class="form-label">Estatus</label><br>
                                        <select id="estatus" name="estatus" class="form-control show-tick">
                                            <option value="Activo" <?php if ($estatusx == 'Activo') { echo "selected"; } ?>>Activo</option>
                                            <option value="Pendiente" <?php if ($estatusx == 'Pendiente') { echo "selected"; } ?>>Pendiente</option>
                                            <option value="Inactivo" <?php if ($estatusx == 'Inactivo') { echo "selected"; } ?>>Inactivo</option>
                                            <option value="Bloqueado" <?php if ($estatusx == 'Bloqueado') { echo "selected"; } ?>>Bloqueado</option>
                                        </select>
                                    </div>
                                </div>
                            </fieldset>

                            <div class="row clearfix demo-button-sizes">
                                <div class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
                                    <button type="button" id="guardarBtn" class="btn bg-green btn-block btn-lg waves-effect">GUARDAR</button>
                                </div>
                            </div>
                            <hr>
                        </form>

                        <!-- Script para manejar el envío de datos mediante AJAX -->
                        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
                        <script>
                            // Función AJAX para enviar los datos del formulario sin recargar la página
                            $('#guardarBtn').on('click', function () {
                                // Recolectar los datos del formulario
                                let formData = {
                                    usuario_id: $('#usuario_id').val(),
                                    nombre: $('#nombre').val(),
                                    usuario: $('#usuario').val(),
                                    telefono: $('#celular').val(),
                                    observaciones: $('#observaciones_x').val(),
                                    especialidad: $('#especialidad').val(),
                                    horarios: $('#horarios').val(),
                                    estatus: $('#estatus').val()
                                };

                                // Enviar los datos por AJAX
                                $.ajax({
                                    url: 'actualiza_alta.php', // Archivo donde se procesará la información
                                    type: 'POST',
                                    data: formData,
                                    success: function (response) {
                                        alert("Datos guardados con éxito.");
                                    },
                                    error: function () {
                                        alert("Error al guardar los datos.");
                                    }
                                });
                            });
                        </script>

                        <!-- Aquí continúa el resto del código, incluyendo los paneles de pacientes, visitas, etc., aplicando las mismas mejoras -->

                        <div >
                            <div class="row clearfix">
                                <div class="col-xs-12 ol-sm-12 col-md-12 col-lg-12">
                                    <div class="panel-group" id="accordion_17" role="tablist" aria-multiselectable="true">
                                        <div class="panel panel-col-pink">
                                            <div class="panel-heading" role="tab" id="headingOne_17">
                                                <h4 class="panel-title">
                                                    <a role="button" data-toggle="collapse" data-parent="#accordion_17" href="#collapseOne_17" aria-expanded="true" aria-controls="collapseOne_17">
                                                        <i class="material-icons">account_circle</i> Pacientes
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseOne_17" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne_17">
                                                <div class="panel-body">
                                                	<div class="table-responsive">
	                                                	<h1><?php echo $usuario_idx." ".codificacionUTF($nombrex); ?></h1>
												        <!-- Tabla para mostrar los resultados de la consulta -->
												        <table class="table table-bordered table-striped">
												            <tr>
												                <th style="text-align: center">No.</th>
												                <th style="text-align: center">Meses Inicio</th>
												                <th style="text-align: center">Paciente</th>
												                <th style="text-align: center">Estatus</th>
												                <th style="text-align: center">Sesiones</th>
												                <th style="text-align: center">TMS</th>
												                <th style="text-align: center">tDCS</th>
												                <th style="text-align: center">Datos</th>
												            </tr>
												        
												        <?php
												        // Consulta SQL para obtener los datos de los pacientes y las terapias
												        $sql = "
															SELECT
															    p.paciente_id,
															    p.paciente,
															    p.apaterno,
															    p.amaterno,
															    p.estatus,
															    (SELECT MIN(f_captura) FROM historico_sesion WHERE paciente_id = p.paciente_id) AS f_ini,
															    TIMESTAMPDIFF(MONTH, (SELECT MIN(f_captura) FROM historico_sesion WHERE paciente_id = p.paciente_id), CURDATE()) AS meses_desde_inicio,
															    (SELECT COUNT(*) FROM historico_sesion WHERE paciente_id = p.paciente_id) AS sesiones,
															    (SELECT COUNT(*) 
															     FROM historico_sesion hs
															     INNER JOIN protocolo_terapia pt ON hs.protocolo_ter_id = pt.protocolo_ter_id
															     WHERE hs.paciente_id = p.paciente_id AND pt.terapia = 'TMS') AS TMS,
															    (SELECT COUNT(*) 
															     FROM historico_sesion hs
															     INNER JOIN protocolo_terapia pt ON hs.protocolo_ter_id = pt.protocolo_ter_id
															     WHERE hs.paciente_id = p.paciente_id AND pt.terapia = 'tDCS') AS tDCS,
															    a.nombre AS medico
															FROM
															    pacientes p
															INNER JOIN admin a ON p.usuario_id = a.usuario_id
															WHERE
															    a.empresa_id = $empresa_id 
															    AND a.usuario_id = $medico_id
															ORDER BY
															    f_ini DESC, paciente_id ASC												        
															";
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
												                
																	
																		switch ($estatus) {
																			case 'Activo':
																				$span = "bg-green";
																				break;
																			case 'Confirmado':
																				$span = "bg-light-green";
																				break;
																			case 'Eliminado':
																				$span = "bg-red";
																				break;
																			case 'Inactivo':
																				$span = "bg-red";
																				break;	
																			case 'No interesado':
																				$span = "bg-red";
																				break;
																			case 'No localizado':
																				$span = "bg-orange";
																				break;
																			case 'Pendiente':
																				$span = "bg-amber";
																				break;
																			case 'Seguimiento':
																				$span = "bg-yellow";
																				break;	
																			case 'Remisión':
																				$span = "bg-indigo";
																				break;	
																		}						                
												                ?>
												                <tr>
												                    <td style="text-align: center"><?php echo $paciente_id; ?></td>
												                    <td style="text-align: center"><?php echo $meses_desde_inicio; ?></td>
												                    <td><?php echo codificacionUTF($paciente." ".$apaterno." ".$amaterno); ?></td>
												                    <td class="<?php echo $span; ?>" style="text-align: center"><?php echo $estatus; ?></td>
												                    <td style="text-align: center"><?php echo $sesiones; ?></td>
												                    <td style="text-align: center"><?php echo $TMS; ?></td>
												                    <td style="text-align: center"><?php echo $tDCS; ?></td>
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
												        ?>
												        </table>                                                	
                                                	</div>	
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-col-blue">
                                            <div class="panel-heading" role="tab" id="headingTwo_17">
                                                <h4 class="panel-title">
                                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion_17" href="#collapseTwo_17" aria-expanded="false"
                                                       aria-controls="collapseTwo_17">
                                                        <i class="material-icons">place</i> Registro de Visitas
                                                        
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseTwo_17" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo_17">
                                                <div class="panel-body">
                                                	
													<form id="visitaForm">
													    <!-- Usuario ID (oculto, asumiendo que se obtiene de la sesión o selección previa) -->
													    <input type="hidden" id="usuario_idy" name="usuario_id" value="<?php echo $medico_id; ?>">
													
													    <!-- Detalles de la visita -->
													    <h3>Detalles de la Visita</h3>
													
													    <!-- Fecha de la reunión -->
													    <div class="form-group form-float">
													        <div class="form-line">
													            <input type="date" id="fecha" name="fecha" class="form-control" value="<?php echo $hoy; ?>" required>
													            <label class="form-label">Fecha*</label>
													        </div>
													    </div>
													
													    <!-- Hora de la reunión -->
													    <div class="form-group form-float">
													        <div class="form-line">
													            <input type="time" id="hora" name="hora" value="<?php echo $ahora; ?>" class="form-control" required>
													            <label class="form-label">Hora*</label>
													        </div>
													    </div>
													
													    <!-- Duración de la reunión -->
													    <div class="form-group form-float">
													        <div class="form-line">
													            <input type="number" id="duracion" name="duracion" class="form-control" required>
													            <label class="form-label">Duración (minutos)*</label>
													        </div>
													    </div>
													
													    <!-- Objetivos de la visita -->
													    <h3>Objetivos de la Visita</h3>
													    <div class="form-group form-float">
													        <div class="form-line">
													            <textarea id="objetivo" name="objetivo" class="form-control" rows="3" required></textarea>
													            <label class="form-label">Objetivo de la Visita*</label>
													        </div>
													    </div>
													
													    <!-- Resultados obtenidos -->
													    <h3>Resultados Obtenidos</h3>
													    <div class="form-group form-float">
													        <div class="form-line">
													            <textarea id="resultados" name="resultados" class="form-control" rows="3" required></textarea>
													            <label class="form-label">Resultados Obtenidos*</label>
													        </div>
													    </div>
													
													    <!-- Observaciones -->
													    <h3>Observaciones</h3>
													    <div class="form-group form-float">
													        <div class="form-line">
													            <textarea id="observaciones" name="observaciones" class="form-control" rows="3"></textarea>
													            <label class="form-label">Observaciones</label>
													        </div>
													    </div>
													    
												    
													    
							                            <h2 class="card-inside-title">Programacion de proxima visita</h2>
							                            <div class="demo-switch">
							                                <div class="switch">
							                                    <label>NO<input id="prog_visitas" name="prog_visitas" type="checkbox" checked><span class="lever switch-col-<?php echo $body; ?>"></span>SI</label>
							                                </div>
							                            </div>
							
												        <script type='text/javascript'>
												            $('#prog_visitas').click(function(){
															    if ($("#prog_visitas").prop("checked")) {
															      $('#visitas').show();
															      $('#p_visita').val('SI');
															    } else {
															      $('#visitas').hide();
															      $('#p_visita').val('NO');
															    }	                    
												            });
												        </script> 	 
	 													<input type="hidden" id="p_visita" name="p_visita" value="SI" />
				                       					<div id="visitas">
														    <!-- Resultados obtenidos -->
														    <h3>Proxima visita</h3>
														    <div class="form-group form-float">
														        <div class="form-line">
														            <input type="date" id="f_visita" name="f_visita" class="form-control" value="<?php echo $hoy; ?>" required>
														            <label class="form-label">Proxima visita</label>
														        </div>
														    </div>                       						
				                       					</div>
														<hr>
														
														    <!-- Botón de Enviar con AJAX -->
														    <button type="button" id="submitVisitaBtn" class="btn btn-primary mt-3">Guardar Visita</button>
														</form>
														
														<!-- Script para manejar el envío de datos mediante AJAX -->
														<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
														<script>
															// Función AJAX para enviar los datos del formulario sin recargar la página
															$('#submitVisitaBtn').on('click', function() {
																let formData = {
																	usuario_id: $('#usuario_idy').val(),
																	fecha: $('#fecha').val(),
																	hora: $('#hora').val(),
																	duracion: $('#duracion').val(),
																	objetivo: $('#objetivo').val(),
																	resultados: $('#resultados').val(),
																	observaciones: $('#observaciones').val(),
																	f_visita: $('#f_visita').val(),
																	p_visita: $('#p_visita').val()
																};

																$.ajax({
																	url: 'procesar_visita.php', // Archivo donde se procesará la información
																	type: 'POST',
																	data: formData,
																	success: function(response) {
																		alert("Datos de la visita guardados con éxito.");
																		location.reload(); // Recargar la página después del alert
																	},
																	error: function() {
																		alert("Error al guardar los datos de la visita.");
																		location.reload(); // Recargar la página también en caso de error
																	}
																});
															});
														</script>
	                                                </div>
	                                            </div>
	                                        </div>                                                                         
	                                        <div class="panel panel-col-cyan">
	                                            <div class="panel-heading" role="tab" id="headingFive_17">
	                                                <h4 class="panel-title">
	                                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion_17" href="#collapseFive_17_17" aria-expanded="false"
	                                                       aria-controls="collapseFive_17_17">
	                                                        <i class="material-icons">pin_drop</i> Visitas
	                                                        
	                                                    </a>
	                                                </h4>
	                                            </div>
	                                            <div id="collapseFive_17_17" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive_17">
	                                                <div class="panel-body">	                                        

														<div class="table-responsive">
		                                                	<h1><?php echo $usuario_idx." ".$nombrex; ?></h1>
													        <!-- Tabla para mostrar los resultados de la consulta -->
													        <table class="table table-bordered table-striped">
													            <tr>
													                <th style="text-align: center">No.</th>
													                <th style="text-align: center">Fecha</th>  
													                <th style="text-align: center">Duracion</th>
													                <th style="text-align: center">Objetivo</th>
													                <th style="text-align: center">Resultados</th>
													                <th style="text-align: center">Observaciones</th>
													                <th style="text-align: center">Representate</th>
													                <th style="text-align: center">Proxima Visita</th>
													            </tr>
													        
												        		<?php
															        // Consulta SQL para obtener los datos de los pacientes y las terapias
															        $sql = "
																		SELECT
																			registro_visitas.visita_id,
																			registro_visitas.medico_id,
																			registro_visitas.fecha,
																			registro_visitas.hora,
																			registro_visitas.duracion,
																			registro_visitas.objetivo,
																			registro_visitas.resultados,
																			registro_visitas.observaciones,
																			registro_visitas.usuario_id,
																			registro_visitas.pagado,
																			registro_visitas.p_visita,
																			registro_visitas.f_visita,
																			admin.nombre as nom_representante
																		FROM
																			registro_visitas
																			INNER JOIN admin ON registro_visitas.usuario_id = admin.usuario_id
																		WHERE	
																		    registro_visitas.medico_id = $medico_id									        
																		";
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
															                if ($p_visita == 'SI') {
																				$f_visita = $f_visita;
																			} else {
																				$f_visita = '';
																			}
																														                					                
															                ?>
															                <tr>
															                    <td style="text-align: center"><?php echo $visita_id; ?></td>
															                    <td style="text-align: center"><?php echo $fecha; ?></td>  
															                    <td style="text-align: center"><?php echo $duracion; ?></td>
															                    <td style="text-align: center"><?php echo codificacionUTF($objetivo); ?></td>
															                    <td style="text-align: center"><?php echo codificacionUTF($resultados); ?></td>
															                    <td style="text-align: center"><?php echo codificacionUTF($observaciones); ?></td>
															                    <td style="text-align: center"><?php echo $nom_representante; ?></td> 
															                    <td style="text-align: center"><?php echo $f_visita; ?></td>             
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
                                                		</div>	
	                                                </div>
	                                            </div>
	                                        </div>	                                        
	                                        <div class="panel panel-col-teal">
	                                            <div class="panel-heading" role="tab" id="headingThree_17">
	                                                <h4 class="panel-title">
	                                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion_17" href="#collapseThree_17" aria-expanded="false"
	                                                       aria-controls="collapseThree_17">
	                                                        <i class="material-icons">folder_shared</i> Cortesias
	                                                        
	                                                    </a>
	                                                </h4>
	                                            </div>
	                                            <div id="collapseThree_17" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree_17">
	                                                <div class="panel-body">
	                                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute,
	                                                    non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum
	                                                    eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid
	                                                    single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh
	                                                    helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
	                                                    Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table,
	                                                    raw denim aesthetic synth nesciunt you probably haven't heard of them
	                                                    accusamus labore sustainable VHS.
	                                                </div>
	                                            </div>
	                                        </div>
	                                        <div class="panel panel-col-orange">
	                                            <div class="panel-heading" role="tab" id="headingFour_17">
	                                                <h4 class="panel-title">
	                                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion_17" href="#collapseFour_17" aria-expanded="false"
	                                                       aria-controls="collapseFour_17">
	                                                        <i class="material-icons">person_pin</i> Ubicación de Medico
	                                                    </a>
	                                                </h4>
	                                            </div>
	                                            <div id="collapseFour_17" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour_17">
	                                                <div class="panel-body">

														<form id="geoForm">
														    <!-- Usuario ID (oculto, asumiendo que se obtiene de la sesión o selección previa) -->
														     <input type="hidden" id="usuario_idz" name="usuario_id" value="<?php echo $medico_id; ?>">
														    <!-- Campo Domicilio -->
														    <div class="form-group form-float">
														        <div class="form-line">
														            <input type="text" id="domicilio" name="domicilio" class="form-control" value="<?php echo $domicilio; ?>" required>
														            <label class="form-label">Domicilio*</label>
														        </div>
														    </div>
														
														    <!-- Campo Latitud (solo lectura) -->
														    <div class="form-group form-float">
														        <div class="form-line">
														            <input type="text" id="latitud" name="latitud" class="form-control" value="<?php echo $latitud; ?>" required readonly>
														            <label class="form-label">Latitud*</label>
														        </div>
														    </div>
														
														    <!-- Campo Longitud (solo lectura) -->
														    <div class="form-group form-float">
														        <div class="form-line">
														            <input type="text" id="longitud" name="longitud" class="form-control" value="<?php echo $longitud; ?>" required readonly>
														            <label class="form-label">Longitud*</label>
														        </div>
														    </div>
														
														    <!-- Botón para obtener la ubicación -->
														    <button type="button" id="getLocation" class="btn btn-info waves-effect"><i class="material-icons">my_location</i> Obtener Ubicación</button>
															<hr>
														    <!-- Campo Teléfono -->
														    <div class="form-group form-float">
														        <div class="form-line">
														            <input type="text" id="telefono" name="telefono" class="form-control" value="<?php echo $telefono; ?>" required>
														            <label class="form-label">Teléfono*</label>
														        </div>
														    </div>
														
														    <!-- Campo Extensión -->
														    <div class="form-group form-float">
														        <div class="form-line">
														            <input type="text" id="extension" name="extension" class="form-control" value="<?php echo $extension; ?>">
														            <label class="form-label">Extensión</label>
														        </div>
														    </div>
														
														    <!-- Campo Observaciones -->
														    <div class="form-group form-float">
														        <div class="form-line">
														            <textarea id="observaciones" name="observaciones" class="form-control" rows="3" value="<?php echo $observaciones; ?>"></textarea>
														            <label class="form-label">Observaciones</label>
														        </div>
														    </div>
														
														    <!-- Botón de Enviar con AJAX -->
														    <button type="button" id="submitBtn" class="btn btn-primary mt-3">Guardar</button>
														</form>
														
														<!-- Script para obtener la geolocalización y enviar los datos con AJAX -->
														<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
														<script>
														    // Función para obtener la ubicación y asignarla a los campos de latitud y longitud
														    $('#getLocation').on('click', function() {
														        if (navigator.geolocation) {
														            navigator.geolocation.getCurrentPosition((position) => {
														                let lat = position.coords.latitude;
														                let lon = position.coords.longitude;
														
														                // Asignar valores a los campos de latitud y longitud
														                $('#latitud').val(lat);
														                $('#longitud').val(lon);
														                alert('Ubicación obtenida: Latitud ' + lat + ', Longitud ' + lon);
														            }, () => {
														                alert('No se pudo obtener la ubicación.');
														            });
														                     
														        } else {
														            alert("La geolocalización no es compatible con este navegador.");
														        }
														    });
														
														    // Función AJAX para enviar los datos del formulario sin recargar la página
														    $('#submitBtn').on('click', function() {
														        let formData = {
														            usuario_id: $('#usuario_idz').val(),
														            domicilio: $('#domicilio').val(),
														            latitud: $('#latitud').val(),
														            longitud: $('#longitud').val(),
														            telefono: $('#telefono').val(),
														            extension: $('#extension').val(),
														            observaciones: $('#observaciones').val()
														        };
														
														        $.ajax({
														            url: 'procesar_formulario.php', // Archivo donde se procesará la información
														            type: 'POST',
														            data: formData,
														            success: function(response) {
														                alert("Datos guardados con éxito.");
																		location.reload(); // Recargar la página después del alert
														            },
														            error: function() {
														                alert("Error al guardar los datos.");
																		location.reload(); // Recargar la página después del alert
														            }
														        });
														    });
														</script>
	                                                </div>
	                                            </div>
	                                        </div>
	                                    </div>
	                                </div>
	                            </div>
	                        </div>
                                                	
						<!-- Contenido de la pagina -->
 
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
// Incluir la primera parte del footer que contiene scripts y configuraciones iniciales del pie de página
include($ruta . 'footer1.php');
?>

<!-- Scripts adicionales necesarios para la funcionalidad de la página -->

<!-- Plugin Moment para manejar fechas y horas -->
<script src="<?php echo $ruta; ?>plugins/momentjs/moment.js"></script>

<!-- Plugin para el selector de fecha y hora con Bootstrap Material -->
<script src="<?php echo $ruta; ?>plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

<!-- Plugin para el selector de fecha de Bootstrap -->
<script src="<?php echo $ruta; ?>plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

<!-- Plugin para efecto de ondas en los botones -->
<script src="<?php echo $ruta; ?>plugins/node-waves/waves.js"></script>

<!-- Plugin Autosize para ajustar automáticamente el tamaño de los campos de texto -->
<script src="<?php echo $ruta; ?>plugins/autosize/autosize.js"></script>

<!-- Repetición del plugin Moment para garantizar su disponibilidad -->
<script src="<?php echo $ruta; ?>plugins/momentjs/moment.js"></script>

<?php
// Incluir la segunda parte del footer que finaliza la estructura del pie de página
include($ruta . 'footer2.php');
?>
