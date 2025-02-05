<?php
$paciente_id = 0;
$ruta="../";
$titulo ="Protocolo";

include('fun_protocolo.php');
include($ruta.'header1.php');
?>
    <!-- JQuery DataTable Css -->
    <link href="<?php echo $ruta; ?>plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
    
     <!-- Bootstrap Material Datetime Picker Css -->
    <link href="<?php echo $ruta; ?>plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />

    <!-- Bootstrap DatePicker Css -->
    <link href="<?php echo $ruta; ?>plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />

    <!-- Wait Me Css -->
    <link href="<?php echo $ruta; ?>plugins/waitme/waitMe.css" rel="stylesheet" />

    <!-- Bootstrap  Css -->
    <link href="<?php echo $ruta; ?>plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />   

<?php  include($ruta.'header2.php'); 

?>

    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>APLICAR PROTOCOLO</h2>
            </div>
            <?php // print_r($_SESSION); echo $sesion;?>
<!-- // ************** Contenido ************** // -->
            <!-- CKEditor -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div style="height: 95%"  class="header">
                        	<h1 align="center">Protocolos</h1>
                        	<?php //print_r($_SESSION);
                        	 if ($paciente_id ==0) {?>
								<h3>Paciente</h3>
								<div class="col-sm-10">
								<select name="paciente_id" class="form-control show-tick" id="paciente_id" required>
									<option value="" <?php echo isset($paciente_id) && ($paciente_id === 0 || $paciente_id === '0') ? "selected" : ""; ?>>
										Seleccionar Paciente
									</option>

									<?php
									// Asegurarse de que $empresa_id esté definido
									$empresa_id = $empresa_id ?? 0; // Valor predeterminado si no está definido

									// Consulta segura para obtener los pacientes
									$sql_paciente = "
										SELECT 
											paciente_id, 
											CONCAT(paciente, ' ', apaterno, ' ', amaterno) AS pacientex, 
											tratamiento 
										FROM pacientes 
										WHERE 
											estatus NOT IN ('No interezado', 'Seguimiento', 'Eliminado') 
											AND empresa_id = ? 
										ORDER BY pacientex ASC";

									// Ejecutar la consulta con el ID de la empresa como parámetro
									$params = [$empresa_id];
									$result_paciente = $mysql->consulta($sql_paciente, $params);

									if ($result_paciente['numFilas'] > 0) {
										foreach ($result_paciente['resultado'] as $row) {
											// Decodificar el valor de pacientex con mb_convert_encoding
											$pacientex_decoded = codificacionUTF($row['pacientex']);

											$selected = isset($paciente_id) && $row['paciente_id'] == $paciente_id ? "selected" : "";
											echo "<option value='{$row['paciente_id']}' $selected>{$row['paciente_id']}.- {$pacientex_decoded}</option>";
										}
									} else {
										echo "<option value='' disabled>No hay pacientes disponibles</option>";
									}
									?>
								</select>
								<script>
									$(document).ready(function () {
										// Manejar el evento change del select paciente_id
										$('#paciente_id').change(function () {
											var paciente_id = $(this).val(); // Obtener el valor seleccionado
											$('#load').show(); // Mostrar el cargador
											// Validar que paciente_id no esté vacío
											if (paciente_id !== '') {
												// Enviar el paciente_id por AJAX a trae_protocolo.php
												$.ajax({
													url: 'trae_protocolo.php', // Archivo PHP que procesará la solicitud
													type: 'POST',
													data: { paciente_id: paciente_id }, // Enviar el paciente_id
													success: function (response) {
														// Cargar el contenido devuelto en el div con id="contenido"
														$('#contenido2').html(response);
														$('#load').hide();
													},
													error: function (xhr, status, error) {
														// Manejo de errores en la solicitud AJAX
														console.error('Error en la solicitud AJAX:', error);
														alert('Ocurrió un error al cargar el protocolo. Por favor, inténtelo de nuevo.');
													}
												});
											} else {
												// Si el paciente_id está vacío, limpiar el contenido
												$('#contenido2').html('');
												$('#load').hide();
											}
										});
									});
								</script>

								</div> <hr>  
								<div id="contenido2"></div>
								<?php
							
									$sesion_id = isset($sesion_id) && !empty($sesion_id) ? $sesion_id : "";
									$terapia_id = isset($terapia_id) && !empty($terapia_id) ? $terapia_id : "";
									$sesion_id = isset($sesion_id) && !empty($sesion_id) ? $sesion_id : "";							
									$prot_terapia = isset($prot_terapia) && !empty($prot_terapia) ? $prot_terapia : "";
									$protocolo_ter_id = isset($protocolo_ter_id) && !empty($protocolo_ter_id) ? $protocolo_ter_id : "";
									
									$paciente = isset($paciente) && !empty($paciente) ? $paciente : "";	
									$apaterno = isset($apaterno) && !empty($apaterno) ? $apaterno : "";	
									$amaterno = isset($amaterno) && !empty($amaterno) ? $amaterno : "";	

									$protocolo_ter_id = $protocolo_ter_id ?? ''; // Inicializar con valor vacío si no está definido
									$prot_terapia = $prot_terapia ?? '';
									$sesion_id = $sesion_id ?? '';
									$terapia_id = $terapia_id ?? '';
									$Gtotal = $Gtotal ?? 0;
									$paciente = ($paciente ?? '') . ' ' . ($apaterno ?? '') . ' ' . ($amaterno ?? '');	
									?>							

									<?php
									}else{ ?>


								<?php  

                                        // Consulta segura para obtener datos del paciente
                                        $sql_paciente = "
                                            SELECT 
                                                CONCAT(paciente, ' ', apaterno, ' ', amaterno) AS paciente,
                                                tratamiento 
                                            FROM pacientes 
                                            WHERE paciente_id = ?";
                                        $params = [$paciente_id]; // Parámetro preparado para la consulta

                                        $result_paciente = $mysql->consulta($sql_paciente, $params);

                                        if ($result_paciente['numFilas'] > 0) {
                                            $row_paciente = $result_paciente['resultado'][0]; // Obtener la primera fila del resultado
											$paciente = mb_convert_encoding($row_paciente['paciente'] ?? 'Paciente no encontrado', 'ISO-8859-1', 'UTF-8');
											$tratamiento = mb_convert_encoding($row_paciente['tratamiento'] ?? 'N/A', 'ISO-8859-1', 'UTF-8');
                                            // Generar la URL del paciente
                                            $rutax = $ruta . 'paciente/info_paciente.php?paciente_id=' . $paciente_id;
                                        } else {
                                            // Manejo de error si el paciente no existe
                                            $paciente = "Paciente no encontrado";
                                            $tratamiento = "N/A";
                                            $rutax = "#"; // URL predeterminada o de error
                                        }

                                        // Construir el encabezado de la tabla
                                        $tabla = "<br>
                                            <h3><b>Protocolo que está Indicado:</b></h3>
                                            <h2 align='center'><b><i>{$tratamiento}</i></b></h2>
                                            <hr>
                                            <table class='table table-bordered table-striped table-hover dataTable'>
                                                <caption style='text-align: center'>
                                                    <h3>
                                                        <b>Paciente No. {$paciente_id} - {$paciente}</b>
                                                        <a class='btn bg-blue waves-effect' href='{$rutax}'>
                                                            <i class='material-icons'>chat</i> <b>Datos</b>
                                                        </a>
                                                    </h3>
                                                </caption>
                                                <thead>
                                                    <tr>
                                                        <th>Equipo</th>
                                                        <th>Protocolo</th>
                                                        <th>Sesiones Aplicadas</th>
                                                    </tr>
                                                </thead>
                                                <tbody>";
                                        
                                        // Consulta para obtener los protocolos del paciente
                                        $sql = "
                                            SELECT 
                                                historico_sesion.paciente_id,
                                                historico_sesion.protocolo_ter_id,
                                                COUNT(protocolo_terapia.prot_terapia) AS total_sesion,
                                                CONCAT(protocolo_terapia.prot_terapia, ' ', historico_sesion.anodo, ' ', historico_sesion.catodo) AS prot_terapia,
                                                pacientes.estatus,
                                                equipos.equipo
                                            FROM 
                                                historico_sesion
                                            INNER JOIN 
                                                protocolo_terapia ON historico_sesion.protocolo_ter_id = protocolo_terapia.protocolo_ter_id
                                            INNER JOIN 
                                                pacientes ON historico_sesion.paciente_id = pacientes.paciente_id
                                            INNER JOIN 
                                                equipos ON protocolo_terapia.equipo_id = equipos.equipo_id
                                            WHERE 
                                                historico_sesion.paciente_id = ?
                                            GROUP BY 
                                                historico_sesion.paciente_id, historico_sesion.protocolo_ter_id";
                                        $params = [$paciente_id]; // Preparar el parámetro para evitar inyección SQL
                                        
                                        $result_protocolo = $mysql->consulta($sql, $params);
                                        
                                        $total_sesiones = 0;
                                        $Gtotal = 0;
                                        
                                        // Procesar los resultados y construir las filas de la tabla
                                        if ($result_protocolo['numFilas'] > 0) {
                                            foreach ($result_protocolo['resultado'] as $row) {
                                                $equipo = codificacionUTF($row['equipo']);
                                                $prot_terapia = $row['prot_terapia'];
                                                $total_sesion = $row['total_sesion'];
                                        
                                                $tabla .= "
                                                    <tr>
                                                        <td>{$equipo}</td>
                                                        <td>{$prot_terapia}</td>
                                                        <td style='text-align: center'>{$total_sesion}</td>
                                                    </tr>";
                                        
                                                $Gtotal += $total_sesion;
                                            }
                                        }
                                        
                                        // Agregar el total de sesiones a la tabla
                                        $tabla .= "
                                            <tr>
                                                <th style='text-align: center' colspan='2'>Total</th>
                                                <th style='text-align: center'>{$Gtotal}</th>
                                            </tr>
                                            </tbody>
                                            </table>";
                                        
                                        // Mostrar la tabla
                                        echo $tabla;
            
                                        // Consulta segura para obtener las métricas del paciente
                                        $sql_metrica = "
                                            SELECT 
                                                metricas.x, 
                                                metricas.y, 
                                                metricas.umbral, 
                                                metricas.observaciones
                                            FROM
                                                metricas
                                            WHERE
                                                metricas.paciente_id = ?";
                                        $params = [$paciente_id]; // Parámetro preparado para la consulta
                                        
                                        // Ejecutar la consulta usando una clase segura como Mysql
                                        $result_metrica = $mysql->consulta($sql_metrica, $params);
                                        
                                        if ($result_metrica['numFilas'] > 0) {
                                            // Obtener la primera fila del resultado
                                            $row_metrica = $result_metrica['resultado'][0];
                                            $x = $row_metrica['x'];
                                            $y = $row_metrica['y'];
                                            $umbral = $row_metrica['umbral'];
                                            $observaciones = $row_metrica['observaciones'];
                                            ?>
                                            <!-- Renderizar la tabla con los resultados -->
                                            <table class="table table-bordered table-striped table-hover dataTable">
                                                <thead>
                                                    <tr>
                                                        <th style="text-align: center">X</th>
                                                        <th style="text-align: center">Y</th>
                                                        <th style="text-align: center">Umbral</th>
                                                        <th>Observaciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td style="text-align: center"><?php echo htmlspecialchars($x); ?></td>
                                                        <td style="text-align: center"><?php echo htmlspecialchars($y); ?></td>
                                                        <td style="text-align: center"><?php echo htmlspecialchars($umbral); ?></td>
                                                        <td><?php echo codificacionUTF($observaciones); ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <hr>
                                            <?php
                                        } else {
                                            echo "<p>No se encontraron métricas para este paciente.</p>";
                                        }

                                        $dia = "
                                            <div class='panel-group' id='accordion_1' role='tablist' aria-multiselectable='true'>
                                                <div class='panel panel-col-$body'>
                                                    <div class='panel-heading' role='tab' id='headingSesion'>
                                                        <h4 class='panel-title'>
                                                            <a role='button' data-toggle='collapse' data-parent='#accordion_1' href='#collapseSesion' aria-expanded='true' aria-controls='collapseSesion'>
                                                                Historico de Sesiones
                                                            </a>
                                                        </h4>
                                                    </div>
                                                    <div id='collapseSesion' class='panel-collapse collapse' role='tabpanel' aria-labelledby='headingSesion'>
                                                        <div class='panel-body'>";
                                        
                                        // Consulta segura para obtener el historial de sesiones
                                        $sql_table = "
                                            SELECT
                                                admin.usuario_id,
                                                admin.nombre,
                                                pacientes.paciente_id,
                                                pacientes.paciente,
                                                pacientes.apaterno,
                                                pacientes.amaterno,
                                                historico_sesion.f_captura,
                                                historico_sesion.h_captura,
                                                historico_sesion.umbral,
                                                historico_sesion.observaciones,
                                                equipos.equipo,
                                                protocolo_terapia.prot_terapia 
                                            FROM
                                                historico_sesion
                                                INNER JOIN admin ON historico_sesion.usuario_id = admin.usuario_id
                                                INNER JOIN pacientes ON historico_sesion.paciente_id = pacientes.paciente_id
                                                INNER JOIN protocolo_terapia ON historico_sesion.protocolo_ter_id = protocolo_terapia.protocolo_ter_id
                                                INNER JOIN equipos ON protocolo_terapia.equipo_id = equipos.equipo_id 
                                            WHERE
                                                historico_sesion.paciente_id = ?
                                            ORDER BY historico_sesion.f_captura ASC";
                                        $params = [$paciente_id]; // Parámetro para consulta preparada
                                        
                                        $result_sem2 = $mysql->consulta($sql_table, $params);
                                        
                                        if ($result_sem2['numFilas'] > 0) {
                                            $dia .= "
                                                <table class='table table-bordered'>
                                                    <thead>
                                                        <tr>
                                                            <th>Sesión</th>
                                                            <th>Aplico</th>
                                                            <th>Equipo</th>
                                                            <th>Hora</th>
                                                            <th>Umbral</th>
                                                            <th>Nota de evolución</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>";
                                        
                                            $meses_espanol = [
                                                'Jan' => 'Ene',
                                                'Feb' => 'Feb',
                                                'Mar' => 'Mar',
                                                'Apr' => 'Abr',
                                                'May' => 'May',
                                                'Jun' => 'Jun',
                                                'Jul' => 'Jul',
                                                'Aug' => 'Ago',
                                                'Sep' => 'Sep',
                                                'Oct' => 'Oct',
                                                'Nov' => 'Nov',
                                                'Dec' => 'Dic',
                                            ];
                                        
                                            $cnt_a = 1;
                                            foreach ($result_sem2['resultado'] as $row) {
                                                //extract($row);
                                                $f_captura = (new DateTime($row['f_captura']))->format('d-M-Y');
                                                $f_captura = strtr($f_captura, $meses_espanol); // Reemplazar meses en español
                                                $observaciones = codificacionUTF($row['observaciones']); // Codificar observaciones
                                                $equipo = codificacionUTF($row['equipo']); // Codificar equipo
                                                $nombre = codificacionUTF($row['nombre']); // Codificar nombre
                                                $nombre = codificacionUTF($row['nombre']); // Codificar nombre
                                                
                                                $dia .= "
                                                    <tr>
                                                        <td style='text-align: center'>{$cnt_a}</td>
                                                        <td>{$nombre}</td>
                                                        <td>{$equipo}</td>
                                                        <td>{$f_captura}<br>{$row['h_captura']}</td>
                                                        <td style='text-align: center'>{$row['umbral']}</td>
                                                        <td>{$observaciones}</td>
                                                    </tr>";
                                        
                                                $cnt_a++;
                                            }
                                        
                                            $dia .= "</tbody></table>";
                                        } else {
                                            $dia .= "<p>No hay historial de sesiones para este paciente.</p>";
                                        }
                                        
                                        $dia .= "
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>";
                                        
                                        echo $dia; 
										?>
										<input type="hidden" id="paciente_id" name="paciente_id" value="<?php echo $paciente_id; ?>"/>
										<input type="hidden" id="protocolo_ter_id" name="protocolo_ter_id" value="<?php echo htmlspecialchars($protocolo_ter_id ?? '', ENT_QUOTES, 'UTF-8'); ?>"/>
										<input type="hidden" id="prot_terapia" name="prot_terapia" value="<?php echo htmlspecialchars($prot_terapia ?? '', ENT_QUOTES, 'UTF-8'); ?>"/>
										<input type="hidden" id="sesion_id" name="sesion_id" value="<?php echo htmlspecialchars($sesion_id ?? '', ENT_QUOTES, 'UTF-8'); ?>"/>
										<input type="hidden" id="terapia_id" name="terapia_id" value="<?php echo htmlspecialchars($terapia_id ?? '', ENT_QUOTES, 'UTF-8'); ?>"/>
										<input type="hidden" id="Gtotal" name="Gtotal" value="<?php echo htmlspecialchars($Gtotal ?? 0, ENT_QUOTES, 'UTF-8'); ?>"/>
										<input type="hidden" id="paciente" name="paciente" value="<?php echo htmlspecialchars(($paciente ?? '') . ' ' . ($apaterno ?? '') . ' ' . ($amaterno ?? ''), ENT_QUOTES, 'UTF-8'); ?>"/>
										<?php
                                    } 

									
							?>
							
                            <hr>
 							<button id="ini_protocolo"  name="ini_protocolo" type="button" class='btn bg-<?php echo $body; ?> waves-effect'  data-toggle="tooltip" data-placement="top" title="Iniciar Protocolo">Iniciar Protocolo</button>
                            <script>
                                $(document).ready(function () {
                                    $('#ini_protocolo').click(function () {
                                        // Valores dinámicos generados por PHP
										// Obtener valores directamente desde los inputs ocultos
										var protocolo_ter_id = $('#protocolo_ter_id').val();
										var prot_terapia = $('#prot_terapia').val();
										var sesion_id = $('#sesion_id').val();
										var terapia_id = $('#terapia_id').val();
										var Gtotal = parseInt($('#Gtotal').val()) || 0;
										var total_sesion = Gtotal+1;
										var paciente = $('#paciente').val();

										// Obtener el ID del paciente del campo de formulario
										var paciente_id = $('#paciente_id').val();										

                                        // Validación: Verificar que paciente_id no sea vacío o 0
                                        if (paciente_id && paciente_id !== 0) {
                                            $('#load').show(); // Mostrar el cargador

                                            // Crear objeto de datos para AJAX
                                            var datastring = {
                                                protocolo_ter_id: protocolo_ter_id,
                                                prot_terapia: prot_terapia,
                                                paciente_id: paciente_id,
                                                sesion_id: sesion_id,
                                                terapia_id: terapia_id,
                                                total_sesion: total_sesion,
                                                paciente: paciente
                                            };
                                            // Llamada AJAX
                                            $.ajax({
                                                url: 'test_captura_protocolo.php',
                                                type: 'POST',
                                                data: datastring,
                                                cache: false,
                                                success: function (html) {
                                                    $('#contenido').html(html);
                                                    $('#boton_cnt').show();
                                                    $('#ini_protocolo').hide();
                                                    $('#load').hide();
                                                },
                                                error: function (xhr, status, error) {
                                                    console.error('Error en la solicitud AJAX:', error);
                                                    alert('Ocurrió un error. Por favor, inténtalo de nuevo.');
                                                    $('#load').hide();
                                                }
                                            });
                                        } else {
                                            alert('Debes seleccionar el paciente');
                                        }
                                    });
                                });
                            </script>

			                        
			                        <div style="display: none" align="center" id="load">
		                                <div class="preloader pl-size-xl">
		                                    <div class="spinner-layer">
			                                   <div class="spinner-layer pl-<?php echo $body; ?>">
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
				              <form id="guarda_protocolo_ini" method="POST"  >          
				              	<div  id="contenido">
				              		
				              	</div> 
				              </form>
				              <?php
				
	
              
				              ?>         				                        							
                    	</div>
                	</div>
            	</div>
        	</div>
        </div>
    </section>
<?php	include($ruta.'footer1.php');	?>

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


<?php	include($ruta.'footer2.php');	?>