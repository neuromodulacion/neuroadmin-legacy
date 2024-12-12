<?php
$ruta="../";
$titulo ="Paciente";
$genera ="";

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

include($ruta.'header1.php'); ?>

	<!-- JQuery DataTable Css -->
	<link href="<?php echo $ruta; ?>plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.0/html2canvas.min.js"></script>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.2/raphael-min.js"></script>
	<script src="../morris.js-master/morris.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/prettify/r224/prettify.min.js"></script>
	<script src="../morris.js-master/examples/lib/example.js"></script>
	<!--<script src="../morris.js-master/lib/example.js"></script>
	<link rel="stylesheet" href="../morris.js-master/examples/lib/example.css">-->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prettify/r224/prettify.min.css">
	<link rel="stylesheet" href="../morris.js-master/morris.css">
    <!-- Enlace al archivo CSS para el selector de opciones en Bootstrap -->
    <link href="<?php echo $ruta; ?>plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />  
        
    <!-- Custom Css -->
    <link href="<?php echo $ruta; ?>css/style.css" rel="stylesheet">
	<script>
	    document.addEventListener('DOMContentLoaded', function() {
	        CKEDITOR.replace('editor1');
	        CKEDITOR.replace('editor2');
	        CKEDITOR.replace('comentarios_rep');
	    });
	</script> 
	
<?php
include($ruta.'header2.php');
include('calendario.php');
include('fun_paciente.php');
$sql = "
SELECT
	*
FROM
	pacientes
	WHERE
	pacientes.paciente_id = $paciente_id";
			
// echo $sql."<hr>";	
$result=ejecutar($sql); 
$row = mysqli_fetch_array($result);
extract($row);

 ?>
    <section class="content">
        <div id="body" class="container-fluid">
            <div class="block-header">
                <h2>PACIENTE</h2>
				<?php echo $ubicacion_url."<br>"; ?>
            </div>
<!-- // ************** Contenido ************** // -->
            <!-- CKEditor -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div style="height: 95%"  class="header">
							<div class="row clearfix">
								<?php if ($funcion_id == 1) { ?>
									<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
										<button id="botonCopiar2" class="btn btn-primary btn-block waves-effect" data-toggle="tooltip" data-placement="bottom" title="Copia solo los datos del paciente"><i class="material-icons">content_copy</i>  Copiar Datos</button>
									</div>
									<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
										<button id="botonCopiar" class="btn btn-primary btn-block waves-effect" data-toggle="tooltip" data-placement="bottom" title="Copia todos los datos del informe"><i class="material-icons">content_copy</i>  Copiar Informe</button>
									</div>
								<?php }
								if ($acceso_ia == 'si') { ?>
									<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">														
										<button id="botonCopiarx" class="btn bg-<?php echo $body; ?> btn-block waves-effect" data-toggle="tooltip" data-placement="bottom" title="Genera una recomendación apartir de los datos del paciente"><i class="material-icons">send</i>  Recomendacion GPT</button>
									</div>
									<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
										<button id="botonCopiary" class="btn bg-<?php echo $body; ?> btn-block waves-effect" data-toggle="tooltip" data-placement="bottom" title="Genera un informe apartir de los datos, clinimetrias y sesiones"><i class="material-icons">send</i>  Informe GPT</button>
									</div>
								<?php } ?>
							</div>
							<h1 style="text-align: center" >Paciente</h1>
							<h2 style="text-align: center" ><b>No. <?php echo $paciente_id." ".$paciente." ".$apaterno." ".$amaterno; ?><b></h2>
							<hr>
							<!-- Acceso a inteligencia artificial -->
							<?php if ($acceso_ia == 'si') { ?>
 							<div  id="gpt_reporte" style="background: #eee; padding: 5px; display:none" >
							 	<hr>
								<div id="gpt" style="display: flex; justify-content: center; align-items: center;  text-align: center; background-color: #f4f4f4;"></div>
								<div style="display:none; text-align: center" id="loadx">
									<div class="preloader pl-size-xl">
										<div class="spinner-layer">
										<div class="spinner-layer pl-teal">
												<div class="circle-clipper left">
													<div class="circle"></div>
												</div>
												<div class="circle-clipper right">
													<div class="circle"></div>
												</div>
											</div>
										</div>
									</div>
									<h3>Procesando la información...</h3>
									<h5>La generación de la información puede tardar unos minutos.</h5>
								</div> 
								<hr>
							</div>
	                        <br>
  
							<div class="card" style="background: #eee; padding: 10px" >								
								<div class="panel-group" id="accordion_1_info" role="tablist" aria-multiselectable="true">
								    <?php
								    // Validación de contenido en recomendación e informe
								    if (!empty($recomendacion_gpt)) { 
								        $style = ''; 
								        $mensj = ''; 
								    } else {
								        $style = 'style="display: none"'; 
								        $mensj = '<h5>No hay recomendación disponible para este paciente, necesita generarla en caso de que lo necesite.</h5>';
										echo $mensj;
									} 
									
								    // Validación de contenido en recomendación e informe
								    if (!empty($informe_gpt)) { 
								        $style1 = ''; 
								        $mensj1 = ''; 
								    } else {
								        $style1 = 'style="display: none"'; 
								        $mensj1 = '<h5>No hay reporte disponible para este paciente, necesita generarla en caso de que lo necesite.</h5>';
										echo $mensj1;
									} 	
								    ?>
								
								    <!-- Panel para la Recomendación -->
								    <div <?php echo $style; ?> class="panel panel-primary" id="accordion_1x_info">
								        <div class="panel-heading" role="tab" id="headingOne_1_info">
								            <h4 class="panel-title">
								                <a id="recomendacion_btn" role="button" data-toggle="collapse" data-parent="#accordion_1_info" href="#collapseOne_1_info" aria-expanded="true" aria-controls="collapseOne_1_info">
								                    Recomendación
								                </a>
								            </h4>
								        </div>
								        <div id="collapseOne_1_info" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne_1_info">
								            <div class="panel-body card" style="max-width: 100%; margin: 0 auto; padding: 20px;">
												<textarea id="editor1"><?php echo $recomendacion_gpt; ?></textarea>
								            </div>
								        </div>
								    </div>
								    <!-- Panel para el Informe -->
								    <?php if ($funcion !== 'MEDICO') { ?>
							        <div <?php echo $style1; ?> class="panel panel-primary" id="accordion_2x_info">
							            <div class="panel-heading" role="tab" id="headingTwo_1_info">
							                <h4 class="panel-title">
							                    <a id="informe_btn" class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion_1_info" href="#collapseTwo_1_info" aria-expanded="false" aria-controls="collapseTwo_1_info">
							                        Informe
							                    </a>
							                </h4>
							            </div>
							            <div id="collapseTwo_1_info" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo_1_info">
							                <div class="panel-body" style="width: 100%; margin: 0 auto; padding: 20px; overflow: auto; overflow-wrap: break-word;">
											<textarea id="editor2"><?php echo $informe_gpt; ?></textarea>

							                </div>
							            </div>
							        </div>
									<?php } ?>
								</div>

 								<?php if ($funcion !== 'MEDICO' ) {?>                           
                        		<button id="guardarCambios" class="btn btn-success">Guardar Cambios</button>
								<?php } ?>  
								<script>
									document.getElementById('guardarCambios').addEventListener('click', function() {
									    var paciente_id = '<?php echo $paciente_id; ?>'; // ID del paciente
									    var recomendacion_gpt = CKEDITOR.instances.editor1.getData(); // Obtener contenido de editor1
									    var informe_gpt = CKEDITOR.instances.editor2.getData(); // Obtener contenido de editor2
									
									    $.ajax({
									        url: 'guardar_informacion.php', // Archivo PHP que guardará los cambios
									        type: 'POST',
									        data: { 
									            paciente_id: paciente_id,
									            recomendacion_gpt: recomendacion_gpt,
									            informe_gpt: informe_gpt
									        },
									        success: function(response) {
									            var data = JSON.parse(response);
									            if (data.success) {
									                alert('Información guardada correctamente.');
									            } else {
									                alert('No se pudo guardar la información.');
									            }
									        },
									        error: function() {
									            alert('Error al conectar con el servidor.');
									        }
									    });
									});
								</script>
	                        </div>							
							<?php } ?>							
<!-------------------------------------------------------------------------------------------->							              	
							<div class="row">
								<div id="codigo" align="left" class="col-xs-12">
									<div class="caption">
										<div class="row">
											<div class="col-md-6">
												<button class="btn bg-cyan waves-effect m-b-15" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false"
														aria-controls="collapseExample">
													<i class="material-icons">file_upload</i> 
													CARGAR DOCUMENTOS
												</button>	 
											</div>
											<div class="col-md-6">
												<button id='descarga_open' class='btn bg-<?php echo $body; ?> waves-effect m-b-15' type='button' data-toggle='collapse' data-target='#collapseExamplex' aria-expanded='false'
					                                    aria-controls='collapseExamplex'>
													<i class="material-icons">file_download</i>
					                                Descarga Reporte
					                            </button>
											</div>
											<div class="col-md-12">
												<div class="collapse" id="collapseExample">
													<div class="well">	
														<?php
														// Definir el directorio del paciente
														$directory = "uploads/archivos/paciente_" . $paciente_id;
														
														// Verificar si el directorio existe y listar los archivos
														$fileList = [];
														if (is_dir($directory)) {
															$files = scandir($directory);
															foreach ($files as $file) {
																if ($file !== '.' && $file !== '..') {
																	$filePath = "$directory/$file";
																	$fileType = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
																	$fileTypeLabel = in_array($fileType, ['jpg', 'jpeg', 'png', 'gif']) ? 'Imagen' : ($fileType === 'pdf' ? 'PDF' : 'Otro');
																	if ($fileTypeLabel !== 'Otro') { // Ignorar archivos no soportados
																		$fileList[] = [
																			'name' => $file,
																			'type' => $fileTypeLabel,
																			'path' => $filePath
																		];
																	}
																}
															}
														}
														?>
													
														<h3>Subir Archivos</h3>
														<p>Es para subir contratos en PDF, JPG o PNG, máximo 3 MB</p>
														<form id="uploadForm_zz" enctype="multipart/form-data">
															<input type="hidden" name="paciente_id" value="<?php echo $paciente_id; ?>">
															<p><input class="btn btn-primary" type="file" name="file" id="file_zz"></p> 
															<p><input class="btn btn-default" type="button" value="Subir Archivo" id="btnUpload_zz"></p>
														</form>
													
														<div id="status_zz"></div>
														
														<div class="file-list">
															<h3>Archivos del Paciente</h3>
															<ul id="fileList">
																<?php foreach ($fileList as $file): ?>
																	<li>
																		<strong><?php echo htmlspecialchars($file['name']); ?></strong>
																		(<?php echo $file['type']; ?>) - 
																		<a href="<?php echo htmlspecialchars($file['path']); ?>" target="_blank">Ver archivo</a>
																	</li>
																<?php endforeach; ?>
															</ul>
														</div>
													
														<script>
															$(document).ready(function() {
																$("#btnUpload_zz").click(function() {
																	var fileInput = $('#file_zz')[0];
																	var filePath = fileInput.value;
																	var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif|\.pdf)$/i;
																	var paciente_id = '<?php echo $paciente_id; ?>';
																	$('#status_zz').html("Cargando...");
													
																	if (!allowedExtensions.exec(filePath)) {
																		alert('Por favor sube archivos con las extensiones .jpeg/.jpg/.png/.gif/.pdf solamente.');
																		fileInput.value = '';
																		return false;
																	}
													
																	if (fileInput.files[0].size > 3 * 1024 * 1024) {
																		alert('El archivo es demasiado grande. Tamaño máximo permitido: 3 MB.');
																		fileInput.value = '';
																		return false;
																	}
													
																	var formData = new FormData($("#uploadForm_zz")[0]);
																	$("#btnUpload_zz").prop('disabled', true);
													
																	$.ajax({
																		url: 'upload.php',
																		type: 'POST',
																		data: formData,
																		contentType: false,
																		processData: false,
																		success: function(response) {
																			var data = JSON.parse(response);
																			if (data.error) {
																				$('#status_zz').html(data.error);
																			} else {
																				$('#status_zz').html('Archivo subido correctamente.');
																				$("#fileList").append(
																					"<li><strong>" + data.name + "</strong> (" + data.type + ") - " +
																					"<a href='" + data.path + "' target='_blank'>Ver archivo</a></li>"
																				);
																				$('#file_zz').val('');
																			}
																			$("#btnUpload_zz").prop('disabled', false);
																		},
																		error: function() {
																			$('#status_zz').html('Ocurrió un error al subir el archivo.');
																			$("#btnUpload_zz").prop('disabled', false);
																		}
																	});
																});
															});
														</script>
													</div>
												</div>  
											</div>
											<div class="col-md-12">
												<div class='collapse' id='collapseExamplex'>
					                                <div class='well'>
					                                	<h2><b>* Comentarios para el reporte:</b></h2><br>
					                                	<textarea id='comentarios_rep' class='form-control' rows='3' placeholder='Debe de tener comentarios para descargar el reporte'><?php echo $comentarios_reporte; ?></textarea>
					                                	<div id="test"></div>
														<br><button id='guarda_comentarios' type='button' class='btn bg-teal waves-effect'><i class='material-icons'>person</i> Guarda Comentarios</button>
												         <script type='text/javascript'>
											                $('#guarda_comentarios').click(function(){
											                	var paciente_id = '<?php echo $paciente_id ?>'; 
											                	var comentarios_reporte = $( '#comentarios_rep').val();
											                    var datastring = 'comentarios_reporte='+comentarios_reporte+'&paciente_id='+paciente_id;
											                    $.ajax({
											                        url: 'guarda_comentarios.php',
											                        type: 'POST',
											                        data: datastring,
											                        cache: false,
											                        success:function(html){   
											                        	//alert(html);  
											                            $('#descarga').show(); 
											                            
											                        }
											                	});
											                });
											            </script>  
														<!--<button id='edita_comentarios' type='button' class='btn bg-teal waves-effect'><i class='material-icons'>mode_edit</i> Edita Comentarios con IA</button>  -->                   	
														<hr>
														<a $style class='btn bg-<?php echo $body; ?> waves-effect'  id='descarga' target='_blank' href='pdf_html.php?paciente_id=<?php echo $paciente_id; ?>' role='button' >
															Descarga Reporte Doctor 
															<i class='material-icons'>person</i> 
															<i class='material-icons'>file_download</i>
														</a>
														<a $style class='btn bg-<?php echo $body; ?> waves-effect'  id='descarga' target='_blank' href='pdf_html_paciente.php?paciente_id=<?php echo $paciente_id; ?>' role='button' >
															Descarga Reporte Paciente 
															<i class='material-icons'>assignment_ind</i> 
															<i class='material-icons'>file_download</i>
														</a>
					                                </div>
					                            </div>	
											</div>
										</div>                           				                         				
										<hr>
		                                <div class="form-line">	                                	
		                                	<?php //print_r($_GET); 
		                                	// print_r($_SESSION);
		                                	$origen = isset($origen) && !empty($origen) ? $origen : "";
		                                	
												if ($origen == 'agenda'   ) {
													$sql ="
													SELECT
														agenda.*,
														pacientes.*
													FROM
														agenda
														INNER JOIN
														pacientes
														ON 
															agenda.paciente_id = pacientes.paciente_id
														WHERE
															agenda.agenda_id = $agenda_id";
															
														// echo $sql."<hr>";	
													    $result=ejecutar($sql); 
													    $row = mysqli_fetch_array($result);
													    extract($row);		
														
														$f_ini = (new DateTime($f_ini))->format('d-M-Y');
                                                		$f_ini = strtr($f_ini, $meses_espanol); // Reemplazar meses en español                                 
												        
																										
														$dia .="<hr><h2><b>Cita</b></h2><br>
														Fecha: $f_ini<br>
														Hora de inicio: $h_ini<br>
														Hora final: $h_fin"; 
														
												} else {
													$sql ="
													SELECT														
														pacientes.*, 
														admin.nombre as medico
													FROM
														pacientes INNER JOIN admin ON 
														pacientes.usuario_id = admin.usuario_id
													WHERE
														pacientes.paciente_id = $paciente_id";
														//echo $sql;
														// echo $sql."<hr>";	
													    $result=ejecutar($sql); 
													    $row = mysqli_fetch_array($result);
													    extract($row);															
												}	
												
												
												if ($comentarios_reporte =='') {
													$style ="style='display: none'";
												} else {
													$style ='';
												}
	
											    //print_r($row);
											    $dia = "<div  id='codigo_2'  class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
											    ";		                                	

												if ($paquete_id == 12) { ?>
													<div class='row'>
														<div class='col-md-6'><br>
															<a  class='btn bg-<?php echo $body; ?> waves-effect'  id='descarga' target='_blank' href='pdf_tms.php?paciente_id=<?php echo $paciente_id; ?>' role='button' >Descarga Contrato y Condiciones TMS <i class='material-icons'>file_download</i></a>
														</div>
														<div class='col-md-6'><br>
															<a  class='btn bg-<?php echo $body; ?> waves-effect'  id='descarga' target='_blank' href='pdf_tdcs.php?paciente_id=<?php echo $paciente_id; ?>' role='button' >Descarga Contrato y Condiciones TdCS <i class='material-icons'>file_download</i></a>
														</div>
													</div><hr>	
												<?php }

												// echo "hola 3<br>";
											
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
													case 'No interezado':
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
												
												$dia.= "<hr>
												
												";
												?>
											<div class="row">
												<div class="col-md-4"><h3><b>Estatus del Paciente</b> </h3></div>
												<div class="col-md-4"><h3><span class='label <?php echo $span; ?>' ><?php echo $estatus; ?></span></h3></div>
												<div class="col-md-4">
												<button type='button' class='btn bg-<?php echo $body; ?> waves-effect'data-toggle='modal' data-target='#estatuslModal'>
													<i class='material-icons'>mode_edit</i>	Modifica Estatus
												</button>
												</div>
											</div>	
            								
											<!-- Small Size -->
											<div class='modal fade' id='estatuslModal' tabindex='-1' role='dialog'>
												<div class='modal-dialog modal-sm' role='document'>
													<div class='modal-content'>
														<div class='modal-header'>
															<h4 class='modal-title' id='estatuslModalLabel'>Seleccione el Estatus</h4>
														</div>
														<div class='modal-body'>							
															<div class='form-group form-float'>
																<label for='estado'>Estado:</label>
																<select class='form-control show-tick' id='estatus_sel' name='estatus_sel' required>
																	<option value=''>-- Seleccione un Estatus --</option>
																	<option value='Activo' <?php echo ($estatus == "Activo" ? "selected" : "") ?>>Activo</option>
																	<option value='Confirmado' <?php echo ($estatus == "Confirmado" ? "selected" : "") ?>>Confirmado</option>
																	<option value='Eliminado' <?php echo ($estatus == "Eliminado" ? "selected" : "") ?>>Eliminado</option>
																	<option value='Inactivo' <?php echo ($estatus == "Inactivo" ? "selected" : "") ?>>Inactivo</option>
																	<option value='No interezado' <?php echo ($estatus == "No interezado" ? "selected" : "") ?>>No interezado</option>
																	<option value='No localizado' <?php echo ($estatus == "No localizado" ? "selected" : "") ?>>No localizado</option>
																	<option value='Pendiente' <?php echo ($estatus == "Pendiente" ? "selected" : "") ?>>Pendiente</option>
																	<option value='Seguimiento' <?php echo ($estatus == "Seguimiento" ? "selected" : "") ?>>Seguimiento</option>
																	<option value='Remisión' <?php echo ($estatus == "Remisión" ? "selected" : "") ?>>Remisión</option>
																</select>
															</div>
															</div>
														<div class='modal-footer'>
															<button id='btn_estatus' type='button' class='btn btn-primary waves-effect'>GUARDAR</button>
															<script type='text/javascript'>
																$(document).ready(function() {
																	$('#btn_estatus').click(function() {    
																		var estatus = $('#estatus_sel').val();
																		var paciente_id = '<?php echo $paciente_id; ?>';
																		var datastring = 'estatus=' + estatus + '&paciente_id=' + paciente_id;
															
																		$.ajax({
																			url: 'procesar_seleccion.php',
																			type: 'POST',
																			data: datastring,
																			cache: false,
																			success: function(html) {
																				//alert(html);   
																				location.reload(); // Recargar la página tras la respuesta exitosa
																			},
																			error: function(xhr, status, error) {
																				console.log('Error en la petición: ' + error);
																			}
																		});
																	});
																});
															</script>                            
															<button type='button' class='btn btn-danger waves-effect' data-dismiss='modal'>CERRAR</button>
														</div>
													</div>
												</div>
											</div>
												
											<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
												<!-- Espaciado superior -->
												<br>
												<!-- Título principal de la sección -->
												<h2><b>Pagos Registrados</b></h2>
												<br>
												
												<!-- Tabla para mostrar los pagos registrados -->
												<table style='width: auto;' class='table table-bordered'>
													<!-- Encabezado de la tabla -->
													<tr>
														<th style='width: 20%;'>Ticket</th>
														<th style='width: 40%;'>Consulta</th>
														<th style='width: 15%; text-align: center;'>Fecha</th>
														<th style='width: 10%; text-align: center;'>Sesiones</th>
														<th style='width: 15%; text-align: center;'>Importe</th>
													</tr>

													<?php
													// Consulta para obtener los pagos registrados
													$sql_sem2 = "
														SELECT
															cobros.ticket,
															cobros.consulta,
															cobros.f_pago,
															cobros.f_captura,
															cobros.cantidad,
															cobros.importe,
															admin.nombre AS nom_cob
														FROM
															cobros
														INNER JOIN
															admin ON cobros.usuario_id = admin.usuario_id
														WHERE
															cobros.paciente_id = ?
															AND cobros.tipo = ?
															AND cobros.empresa_id = ?";

													// Parámetros para la consulta
													$parametros = [
														$paciente_id, // ID del paciente
														'Terapia',    // Tipo de cobro
														$empresa_id   // ID de la empresa
													];

													// Ejecuta la consulta con la función consulta()
													$result_sem2 = $conexion->consulta($sql_sem2, $parametros);

													// Inicializa acumuladores para totales
													$total_sesiones = 0;
													$Gtotal = 0;

													// Verifica si hay resultados
													if ($result_sem2['numFilas'] === 0) {
														// Si no hay registros, muestra un mensaje en la tabla
														echo "<tr>
																<td colspan='5' style='text-align: center'><b>No hay registros</b></td>
															</tr>";
													} else {
														// Recorre los resultados y construye la tabla
														foreach ($result_sem2['resultado'] as $row) {
															// Sanitiza los valores antes de imprimirlos
															$ticket = htmlspecialchars($row['ticket'], ENT_QUOTES, 'UTF-8');
															
															//$consulta = mb_convert_encoding($row['consulta'], 'UTF-8', 'ISO-8859-1');
															//$consulta = mb_convert_encoding($row['consulta'], 'ISO-8859-1', 'UTF-8');
															if (mb_check_encoding($row['consulta'], 'UTF-8')) {
																$consulta = mb_convert_encoding($row['consulta'], 'ISO-8859-1', 'UTF-8');
															} else {
																$consulta = $row['consulta']; // Ya está en ISO-8859-1 o en una codificación diferente
															}
															
															//$consulta = utf8_encode($row['consulta']);
															$f_pago = htmlspecialchars($row['f_pago'], ENT_QUOTES, 'UTF-8');
															$f_captura = htmlspecialchars($row['f_captura'], ENT_QUOTES, 'UTF-8');
															$cantidad = (int)$row['cantidad'];
															$importe = (float)$row['importe'];
															$nom_cob = htmlspecialchars($row['nom_cob'], ENT_QUOTES, 'UTF-8');

															// Imprime la fila en la tabla
															echo "<tr>
																	<td>$ticket<br>Cobro:<br>$nom_cob</td>
																	<td>$consulta - $f_pago</td>
																	<td style='text-align: center;'>$f_captura</td>
																	<td style='text-align: center;'>$cantidad</td>
																	<td style='text-align: center;'>$ " . number_format($importe, 2) . "</td>
																</tr>";

															// Acumula los totales
															$total_sesiones += $cantidad;
															$Gtotal += $importe;
														}
													}
													?>

													<!-- Imprime la fila con los totales -->
													<tr>
														<th colspan='3'>Total</th>
														<th style='text-align: center;'><?php echo $total_sesiones; ?></th>
														<th style='text-align: center;'><?php echo "$ " . number_format($Gtotal, 2); ?></th>
													</tr>


												</table>
											</div>

											<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
												<?php														
							/***************************************************************** */						
												$edad = obtener_edad_segun_fecha($f_nacimiento);																									
												$dia .= "<hr>
													<h3><b>Información del Paciente</b></h3>
													<br>Celular: $celular<br>Correo electronico: $email
													<br>Edad: $edad años
													<br>Sexo: $sexo<hr>
													<h3><b>Datos de Contacto</b></h3><br>
													Contacto: $contacto<br>Parentesco: $parentesco<br>
													Telefonos de contacto: $tel1 - $tel2<hr>
													
				                                    <h3><b>Datos Clinicos</b></h3><br>
		                                                <h2><b>Resumen del Caso</b></h2><br>				                                    
		                                                <p>$resumen_caso</p><br>
		                                                <h2><b>Diagnóstico (Principal)</b></h2><br>				                                    
		                                                <p>$diagnostico</p><br>		                                                
		                                                <h2><b>Diagnóstico 2</b></h2><br>				                                    
		                                                <p>$diagnostico2</p><br>	
		                                                <h2><b>Diagnóstico 3</b></h2><br>				                                    
		                                                <p>$diagnostico3</p><br>	
	                                                <h3>Medico Tratante</h3> 	
	                                                	<p>$medico</p><br>                                                				                                                													
				                                    <!--<div class='panel-group' id='accordion_1' role='tablist' aria-multiselectable='true'>
				                                        <div class='panel panel-col-$body'>
				                                            <div class='panel-heading' role='tab' id='headingOne_1'>
				                                                <h4 class='panel-title'>
				                                                    <a role='button' data-toggle='collapse' data-parent='#accordion_1' href='#collapseOne_1' aria-expanded='true' aria-controls='collapseOne_1'>
				                                                        Resumen del Caso
				                                                    </a>
				                                                </h4>
				                                            </div>
				                                            <div id='collapseOne_1' class='panel-collapse collapse' role='tabpanel' aria-labelledby='headingOne_1'>
				                                                <div class='panel-body'>
				                                                    $resumen_caso
				                                                </div>
				                                            </div>
				                                        </div>
				                                        <div class='panel panel-col-$body'>
				                                            <div class='panel-heading' role='tab' id='headingTwo_1'>
				                                                <h4 class='panel-title'>
				                                                    <a class='collapsed' role='button' data-toggle='collapse' data-parent='#accordion_1' href='#collapseTwo_1' aria-expanded='false'
				                                                       aria-controls='collapseTwo_1'>
				                                                        Diagnóstico (Principal)
				                                                    </a>
				                                                </h4>
				                                            </div>
				                                            <div id='collapseTwo_1' class='panel-collapse collapse' role='tabpanel' aria-labelledby='headingTwo_1'>
				                                                <div class='panel-body'>
				                                                    $diagnostico
				                                                </div>
				                                            </div>
				                                        </div>
				                                        <div class='panel panel-col-$body'>
				                                            <div class='panel-heading' role='tab' id='headingThree_1'>
				                                                <h4 class='panel-title'>
				                                                    <a class='collapsed' role='button' data-toggle='collapse' data-parent='#accordion_1' href='#collapseThree_1' aria-expanded='false'
				                                                       aria-controls='collapseThree_1'>
				                                                        Diagnóstico 2
				                                                    </a>
				                                                </h4>
				                                            </div>
				                                            <div id='collapseThree_1' class='panel-collapse collapse' role='tabpanel' aria-labelledby='headingThree_1'>
				                                                <div class='panel-body'>
				                                                    $diagnostico2
				                                                </div>
				                                            </div>
				                                        </div>
				                                        <div class='panel panel-col-$body'>
				                                            <div class='panel-heading' role='tab' id='headingTwo_4'>
				                                                <h4 class='panel-title'>
				                                                    <a class='collapsed' role='button' data-toggle='collapse' data-parent='#accordion_4' href='#collapseTwo_4' aria-expanded='false'
				                                                       aria-controls='collapseTwo_4'>
				                                                        Diagnóstico 3
				                                                    </a>
				                                                </h4>
				                                            </div>
				                                            <div id='collapseTwo_4' class='panel-collapse collapse' role='tabpanel' aria-labelledby='headingTwo_4'>
				                                                <div class='panel-body'>
				                                                    $diagnostico3
				                                                </div>
				                                            </div>
				                                        </div>
				                                    </div>-->
				                                    <hr><h3><b>Tratamiento farmacológico actual</b></h3><br>
				                                    $medicamentos
				                                    
				                                    <hr><h3><b>Tratamiento no farmacológico actual</b></h3><br>
				                                    $terapias
				                                    				                                    
				                                    <hr><h3><b>Observaciones</b></h3><br>
				                                    $observaciones
				                                    <hr>
				                                    

				                                    </div>
				                                    <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
				                                    <h3><b>Protocolo que está Indicado:</b></h3> <h2 align='center'><b>$tratamiento</h2></b><hr> 
				                                    <h3><b>Protocolo Aplicado</b></h3><br>													
												";													
												$dia .= "<table style='width: 70%;' class='table table-bordered'>
															<tr>												   				
												   				<th style='width: 50%;'>Protocolo</th>
												   				
												   				<th style='width:  25%;' >Aplicadas</th>
												   				<th style='width:  25%;'>Estatus</th>
												   				
															</tr>";	    
										    	$sql_sem2 ="
											    	SELECT
														historico_sesion.paciente_id,
														historico_sesion.protocolo_ter_id,
														count( protocolo_terapia.prot_terapia ) AS total_sesion,
														CONCAT( protocolo_terapia.prot_terapia, ' ', historico_sesion.anodo, ' ', historico_sesion.catodo ) AS prot_terapia,
														pacientes.estatus 
													FROM
														historico_sesion
														INNER JOIN protocolo_terapia ON historico_sesion.protocolo_ter_id = protocolo_terapia.protocolo_ter_id
														INNER JOIN pacientes ON historico_sesion.paciente_id = pacientes.paciente_id 
													WHERE
														historico_sesion.paciente_id = $paciente_id 
													GROUP BY
														1,2";
													//echo "$sql_sem2 <br>";
										     	$result_sem2=ejecutar($sql_sem2); 
													$total_sesiones = 0;
													$Gtotal = 0;
													$sesiones = isset($sesiones) && !empty($sesiones) ? $sesiones : 0;
													
										    	while($row_sem2 = mysqli_fetch_array($result_sem2)){
											        extract($row_sem2);	
											       // print_r($row_sem2);											        
												   	$dia .= "<tr>									   				
												   				<td>$prot_terapia</td>
												   				
												   				<td>$total_sesion</td>
												   				<td>$estatus</td>
												   				
															</tr>";   
													  
											        $total_sesiones = $total_sesiones+$sesiones;
											        $Gtotal = $Gtotal+$total_sesion;
										        }

											   	$dia .= "<tr>											   				
											   				<th>Total</th>
											   				
											   				<th>$Gtotal</th>
											   				<th ></th>   				
														</tr>"; 										        
										        										        
										        $dia .= "</table></div><hr>";	
										        											
										        
										        $dia .= "<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'><br>
										        <h2><b>Evaluación Graficada</b></h2><br>";
												
												//$dia .= medicion_protocolo($paciente_id);

												$sql_encuestas = "
												SELECT
													encuesta_id, 
													encuesta, 
													descripcion,
													CONCAT('base_encuesta_',encuesta_id) as bases
												FROM
													encuestas
												order by encuesta_id asc";
												
												$wherex = "";
												
												//echo $sql_encuestas."<hr>";	
										     	$result_encuestas=ejecutar($sql_encuestas); 
										    	while($row_encuestas = mysqli_fetch_array($result_encuestas)){
											        extract($row_encuestas);	
												
													$sql_bases = "
													SELECT
														base_encuesta_$encuesta_id.base_id,
														base_encuesta_$encuesta_id.paciente_id,
														base_encuesta_$encuesta_id.usuario_id,
														base_encuesta_$encuesta_id.f_captura,
														base_encuesta_$encuesta_id.h_captura,";												
																										
													$sql_preguntas = "
													SELECT
														preguntas_encuestas.pregunta_id,
														preguntas_encuestas.encuesta_id,
														preguntas_encuestas.numero,
														preguntas_encuestas.pregunta,
														preguntas_encuestas.tipo 
													FROM
														preguntas_encuestas 
													WHERE
														preguntas_encuestas.encuesta_id = $encuesta_id 
														AND preguntas_encuestas.tipo NOT IN ('titulo','instrucciones')";
													//$dia .= $sql_preguntas."<hr>";
													$cnt = 1;	
													$sql_basesX = "";
											     	$result_preguntas=ejecutar($sql_preguntas); 
											    	while($row_preguntas = mysqli_fetch_array($result_preguntas)){
												        extract($row_preguntas);			
																								
														$sql_basesX .= "
														( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta LIKE base_encuesta_$encuesta_id.respuesta_$pregunta_id and respuestas.encuesta_id = $encuesta_id )+";
														//echo $cnt." - ".$pregunta_id."<br>";
														if ( $cnt == 1) {
															//echo $cnt." - ".$pregunta_id."<br>";
															$wherex .= "AND base_encuesta_$encuesta_id.respuesta_$pregunta_id <>''";
														}
														
														$cnt++;
													}
													
														$cnt = 1;
													
														$sql_basesX = substr($sql_basesX, 0, -1);

														$sql_bases .= "
															$sql_basesX as total
														FROM
															base_encuesta_$encuesta_id
														WHERE
															base_encuesta_$encuesta_id.paciente_id = $paciente_id 
															$wherex
														ORDER BY f_captura DESC";

														//echo $sql_bases."<hr>";

														

														$result_bases=ejecutar($sql_bases);
														//echo $result_bases." result_bases<br>";
														$cnt_bases = mysqli_num_rows($result_bases);
														//echo " Res".$cnt_bases."<br>";
														$wherex="";
														
														if ($cnt_bases >= 1) {
															//echo "<h1>Hola mundo</h1><br>";
															$dia .= $encuesta_id." - ".$encuesta." - ".$descripcion."<br>
															<div class='row'>
															  <div class='col-md-5'>";
															$datos = "";															
															$tabla ="													
															<table class='table table-bordered'>
																<tr>
																	<th>Fecha</th>
																	<th>Resultado</th>
																	<th>Evaluación</th>
																	<th></th>
																</tr>";
															//echo $tabla."<hr>";	
															$cnt_calificacion = 1;	
													    	while($row_bases = mysqli_fetch_array($result_bases)){
														        extract($row_bases);

																if ($total === null) {
																	$total = 0;
																	$tabla ="													
																	<table class='table table-bordered'>
																		<tr>
																			<td>$f_captura</td>
																			<th colspan='3'>Clinimetria con error</th>
																		</tr>";
																}else{

																
																

															$color = "";

																if ($encuesta_id == 11 && $cnt == $cnt_bases) {
																	$extra = "";
																} else {
																	
																	if ($encuesta_id == 11 ) {
																		$extra = " AND extra='ok'";
																	} else {
																		$extra = "";
																	}
																	
																}																
																
																$cnt++;
																
															$sql_calificacion = "
															SELECT
																calificaciones.calificacion_id, 
																calificaciones.encuesta_id, 
																calificaciones.min, 
																calificaciones.max, 
																calificaciones.valor, 
																calificaciones.color
															FROM
																calificaciones
															WHERE
																calificaciones.encuesta_id = $encuesta_id													
																AND calificaciones.max >= $total
																AND calificaciones.min <= $total 
																$extra";
																
																
																
															// $tabla .= $sql_calificacion."<br>";	
															//echo $sql_calificacion."<hr>";
															$result_calificacion = ejecutar($sql_calificacion);	
															$cnt_calificacion = mysqli_num_rows($result_calificacion);
															$row_calificacion = mysqli_fetch_array($result_calificacion);
															if ($cnt_calificacion <> 0) {
																extract($row_calificacion);
															}	
															
															
																if ($cnt_calificacion == 1) {
																	$tot_ini = $total;
																}
																//$encuesta_id - $base_id
																
																$rutaxx = $ruta."paciente/clinimetria.php?paciente_id=".$paciente_id."&encuesta_id=".$encuesta_id."&base_id=".$base_id;
																
																

																
																
																$tabla .="
																<tr>
																	<td>$f_captura</td>
																	<td style='text-align: center'>$total</td>
																	<td style='background-color: $color'>$valor</td>
																	<td> <a class='btn bg-$body waves-effect' target='_blank' href='$rutaxx'>
																             <i class='material-icons'>visibility</i> <B>Ver</B>
																         </a> 
															        </td>
																</tr>
																";
																
																//echo $tabla."<hr>";
																$datos .= "
																{'y': '$f_captura', '$encuesta': $total},";
																$cnt_calificacion ++;
																}
															}													
															$tabla .="</table>";
															
															if ($total != 0) {
																$resultado_final = round(($tot_ini / $total) * 100, 0);
															} else {
																$resultado_final = 0; // O un valor predeterminado
															}
															

															//$resultado_final = round(($tot_ini/$total)*100,0);
															//$resultado_final = round(($total/$tot_ini)*100,0);
															$resultado_final = 100 -$resultado_final;
															
															if ($resultado_final < 0) {
																$respuesta = "un Incremento";
															}else{
																$respuesta = "una Disminución";
															}
															$n_grf = "enc_".$encuesta_id."_pac_".$paciente_id;
															$dia .=	$tabla."<h4>Se obtuvo $respuesta del $resultado_final% con respecto a la lectura inicial</h4>
															</div>
															  	<div class='col-md-7'>
															  		<div style='width: 510px' id='graph_$encuesta_id'></div>
																	<script> 
																		var week_data = [$datos];													
																		Morris.Line({
																		  element: 'graph_$encuesta_id',
																		  data: week_data,
																		  xkey: 'y',
																		  ykeys: ['$encuesta'],
																		  labels: ['$encuesta'],
																		  labelColor: ['#005157', '#007580', '#89CFE5','#FFDA00','#FFDA00','#BBBABA'],
													  					  lineColors: ['#005157', '#007580', '#89CFE5','#FFDA00','#FFDA00','#BBBABA'],			  
																		});	
																	</script>
																	
																	<script>
																	  window.addEventListener('DOMContentLoaded', function() {
																	    html2canvas(document.getElementById('graph_$encuesta_id')).then(function(canvas) {
																	      // Convierte el canvas en base64
																	      var imgData = canvas.toDataURL('image/png');
																	
																	      // Datos adicionales a enviar
																	      var datosAdicionales = {
																	        paciente_id: '$n_grf'
																	      };
																	
																	      // Combina los datos adicionales con la imagen en un solo objeto
																	      var requestData = Object.assign({}, datosAdicionales, { image: imgData });
																	
																	      // Envía los datos al servidor utilizando una solicitud AJAX con jQuery
																	      $.ajax({
																	        url: 'guardar_imagen.php',
																	        type: 'POST',
																	        data: requestData,
																	        success: function(response) {
																	          // alert('La imagen se ha guardado correctamente.');
																	        }
																	      });
																	    });  
																	  });
																	</script>																																  		
															  	</div>
															</div>
															<hr>";
															
															
														}
																								
		
												
												//$dia .= "<div style='min-width: 100%' id='graph'></div>";
												//$grafica = medicion_protocolo($paciente_id);
																	
												}
												
																	
													$dia .= "<hr><div class='row'>
													  <div class='col-md-12'>";													

												$dia .= "<hr>
																	<p>
						Adem&aacute;s del gr&aacute;fico de resultados, se puede calcular el porcentaje de reducci&oacute;n de s&iacute;ntomas (Una reducci&oacute;n de 50% de los s&iacute;ntomas se considera respuesta, y reducci&oacute;n mayor a 75% se le llama remisión)
					
					</p>";
												
										      	$dia .= "</div>
										      	<hr><br>
										      	<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
										      	<br>
										      	<h2><b>Agenda</b></h2><br>";
										        
										        $sql ="SELECT
														agenda.f_ini,  
														agenda.h_ini, 
														agenda.h_fin, 
														agenda.paciente_id
													FROM
														agenda
													WHERE
														agenda.paciente_id = $paciente_id";
												//echo $sql." xx";
												$sql = "
												SELECT
													agenda.f_ini,
													agenda.h_ini,
													agenda.h_fin,
													agenda.paciente_id,
													(
													SELECT
														protocolo_terapia.terapia 
													FROM
														historico_sesion
														INNER JOIN protocolo_terapia ON historico_sesion.protocolo_ter_id = protocolo_terapia.protocolo_ter_id 
													WHERE
														historico_sesion.paciente_id = agenda.paciente_id 
														AND historico_sesion.f_captura = agenda.f_ini 
														LIMIT 1
													) AS terapia 
												FROM
													agenda 
												WHERE
													agenda.paciente_id = $paciente_id";				
										        $result_sem2=ejecutar($sql); 
												$cnt = mysqli_num_rows($result_sem2);
												//echo $cnt." xx<hr>";
												if ($cnt <> 0) {
													$dia .= "<table  class='table table-bordered'>
																<tr>
																	<th>Día</th>
																	<th>Hora Inicio</th>
																	<th>Hora Fin</th>
																	<th>Estatus</th>
																	<th>Terapia tomada</th>
																</tr>";	
												    while($row_sem2 = mysqli_fetch_array($result_sem2)){
												        extract($row_sem2);	
														
												        
												        if ($f_ini <= $hoy) {
												        	if ($terapia <>'') {
																$f_estatus = "Asistido";
																$class = "class='info'";												        																	
															} else {
																$f_estatus = "Vencido";
																$class = "class='warning'";																
															}
															

														} else {
															$f_estatus = "Pendiente";
															$class = "class='success'";
														}

													
														$f_ini = (new DateTime($f_ini))->format('d-M-Y');
                                                		$f_ini = strtr($f_ini, $meses_espanol); // Reemplazar meses en español                                 
												        
												        $dia .= "<tr>
																	<th>$f_ini</th>
																	<th>$h_ini</th>
																	<th>$h_fin</th>
																	<th $class >$f_estatus</th>
																	<th>$terapia</th>
																</tr>";
												        
												        
													}
													$dia .= "</table></div><hr>";														
												} 
												
												$dia .= "<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
										        <h2><b>Sesiones</b></h2><br>"; 
										        
										        
												$dia .= "	        
												<div class='panel-group' id='accordion_1' role='tablist' aria-multiselectable='true'>
			                                        <div class='panel panel-col-$body'>
			                                            <div class='panel-heading' role='tab' id='headingSesion'>
			                                                <h4 class='panel-title'>
			                                                    <a id='sesiones_open' role='button' data-toggle='collapse' data-parent='#accordion_1' href='#collapseSesion' aria-expanded='true' aria-controls='collapseSesion'>
			                                                        Historico de Sesiones
			                                                    </a>
			                                                </h4>
			                                            </div>
			                                            <div id='collapseSesion' class='panel-collapse collapse' role='tabpanel' aria-labelledby='headingSesion'>
			                                                <div class='panel-body'>";
                                                extract($_SESSION);
			                                   	$sql_table ="
												SELECT
													admin.usuario_id, 
													admin.nombre, 
													pacientes.paciente_id, 
													CONCAT( pacientes.paciente, ' ', pacientes.apaterno, ' ', pacientes.amaterno ) AS paciente, 
													historico_sesion.f_captura, 
													historico_sesion.h_captura, 
													historico_sesion.umbral, 
													historico_sesion.observaciones, 
													protocolo_terapia.prot_terapia, 
													historico_sesion.historico_id
												FROM
													historico_sesion
													INNER JOIN
													admin
													ON 
														historico_sesion.usuario_id = admin.usuario_id
													INNER JOIN
													pacientes
													ON 
														historico_sesion.paciente_id = pacientes.paciente_id
													INNER JOIN
													protocolo_terapia
													ON 
														historico_sesion.protocolo_ter_id = protocolo_terapia.protocolo_ter_id
												WHERE
													historico_sesion.paciente_id = $paciente_id
												ORDER BY f_captura asc, h_captura asc"; 
										        
										      // echo $sql_table."<hr>";
										              
												$result_sem2=ejecutar($sql_table); 
												
												$cnt = mysqli_num_rows($result_sem2);
												//echo $cnt." xx<hr>";
												$cnt_a = 1;
												if ($cnt <> 0) {
													$dia .= "<table class='table table-bordered table-striped table-hover dataTable '>
																<tr>
																	<th>Sesión</th>
																	<th>Aplico</th>
																	<th>Protocolo</th>
																	<th>Fecha</th>
																	<th>Hora</th>
																	<th>Umbral</th>
																	<th>Observaciones</th>
																</tr>";	
												// Array de meses en español
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
															    'Dec' => 'Dic'
															];
																															
																
												    while($row_sem2 = mysqli_fetch_array($result_sem2)){
												        extract($row_sem2);	  

															// Convertir la fecha
															$date = new DateTime($f_captura);
															$today = $date->format('d-M-Y');
															
															// Reemplazar el mes en inglés por español
															$f_captura = strtr($today, $meses_espanol);
												        
												        	
												        //echo "<h1>$funcion</h1>";
												        //$f_captura = strftime("%e-%b-%Y",strtotime($f_captura));
												        
												        if ($funcion == 'ADMINISTRADOR' || $funcion == 'SISTEMAS' || $funcion == 'TECNICO') {
												        	
															$boton ="
																		<div class='row'>																		  	
																		  	<div align='right' class='col-md-12'>
																		  		<button id='hist_$historico_id' style='width: 5px; height: 5px' class='btn btn-info' data-toggle='tooltip' data-placement='top' data-toggle='modal' data-target='#defaultModal' title='Editar' type='button'></button>
																		         <script type='text/javascript'>
																	                $('#hist_$historico_id').click(function(){	
																	                	var option = 'trae'
																	                	var historico_id = '$historico_id'; 
																	                	var paciente_id = '$paciente_id';
																	                    var datastring = 'historico_id='+historico_id+'&paciente_id='+paciente_id+'&option='+option;
																	                    $.ajax({
																	                        url: 'edita_comentario.php',
																	                        type: 'POST',
																	                        data: datastring,
																	                        cache: false,
																	                        success:function(html){    
																	                            $('#edit_contenido').html(html); 
																	                            $('#modal_edit').click();
																	                        }
																	                	});
																	                });
																	            </script>																	  		
																	  		</div>
																		  	<div class='col-md-12'>$observaciones</div>
																		</div>					
															";
														}
												        
												        
												        $dia .= "<tr>
																	<th>$cnt_a</th>
																	<th>$nombre</th>
																	<th>$prot_terapia</th>
																	<th>$f_captura</th>
																	<th>$h_captura</th>
																	<th>$umbral</th>
																	<th id='cont_$historico_id'>
																		$boton
																	</th>
																</tr>";
					        							$cnt_a ++;
													}
													$dia .= "
															</table>
																<button style='display: none' id='modal_edit' type='button' class='btn btn-default waves-effect m-r-20' data-toggle='modal' data-target='#defaultModal'>MODAL - DEFAULT SIZE</button>
													            <div class='modal fade' id='defaultModal' tabindex='-1' role='dialog'>
													                <div class='modal-dialog' role='document'>
													                    <div class='modal-content'>
													                        <div class='modal-header'>
													                            <h4 class='modal-title' id='defaultModalLabel'>Modifica Observaciones</h4>
													                        </div>
													                        <div id='edit_contenido' class='modal-body'>
	
													                        </div>
													                        <div class='modal-footer'>
													                            <button id='guarda' type='button' class='btn bg-$body waves-effect'>GUARDA CAMBIOS</button>
													                            
													                            <button id='cerrar' type='button' class='btn btn-danger waves-effect' data-dismiss='modal'>CERRAR</button>
													                        </div>
													                    </div>
													                </div>
													            </div>	";	                                                 
												}                 
						                       $dia .= "		</div>
											                </div>
			                                            </div>
			                                        </div>
			                                    </div>			        
												";	        

												//extract($_SESSION);												
																						        	
										      //  echo "<h1>xxx $funcion</h1>";									        
										        if ($funcion == 'ADMINISTRADOR' || $funcion == 'SISTEMAS' || $funcion == 'TECNICO' || $funcion == 'COORDINADOR') {
										         $dia .= "<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
										         <a class='btn bg-$body waves-effect'href='../protocolo/protocolo.php?paciente_id=$paciente_id' role='button'>Iniciar Protocolo</a></div>";										
													
												}	
												echo $dia;

												// $drop = "DROP TABLE IF EXISTS tabla_temporal_$paciente_id";
												// $result = ejecutar($drop);													
											
										
		                                	?>
													                                	
											<script>
												document.getElementById('botonCopiarx').addEventListener('click', function() {
													var codigo = document.getElementById('codigo_2');
													var rango = document.createRange();
													rango.selectNode(codigo);
													window.getSelection().removeAllRanges();
													window.getSelection().addRange(rango);
													var contenidoCopiado = codigo.innerText || codigo.textContent;
													document.execCommand('copy');
													window.getSelection().removeAllRanges();

													$('#gpt_reporte').show();
													$("#gpt").html('');
													$('#loadx').show();
													
													
													var paciente_id = "<?php echo $paciente_id; ?>";
													var fecha = "<?php echo $hoy; ?>";
													var requestData = { 
														sistema: 'Recomendación del caso y del tratamiento...',
														paciente_id: paciente_id,
														accion: 'recomendacion',
														fecha: fecha,
														tipo: 'reporte',
														contenido: contenidoCopiado
													};

													$.ajax({
														url: 'chat_gpt.php',
														type: 'POST',
														data: requestData,
														success: function(html) {
															$("#gpt").html('<h1>El Informe de Recomendación se generó correctamente</h1><br><h4>Se recomienda revisar, modificar y/o corregir la información según sea necesario, incluir el protocolo a aplicar y GUARDAR los cambios.</h4>'); 
															$('#loadx').hide();
															
															// Actualizar el contenido del editor1 con la recomendación generada
															CKEDITOR.instances.editor1.setData(html);
															$('#recomendacion_btn').click();
															$('#accordion_1x_info').show();
														}
													});
												});

											</script>
											<script>
												document.getElementById('botonCopiary').addEventListener('click', function() {
													$('#sesiones_open').click();
													$('#descarga_open').click();
													var codigo = document.getElementById('codigo');
													var rango = document.createRange();
													rango.selectNode(codigo);
													window.getSelection().removeAllRanges();
													window.getSelection().addRange(rango);
													var contenidoCopiado = codigo.innerText || codigo.textContent;
													document.execCommand('copy');
													window.getSelection().removeAllRanges();

													$('#gpt_reporte').show();
													$("#gpt").html('');
													$('#loadx').show();

													var paciente_id = "<?php echo $paciente_id; ?>";
													var fecha = "<?php echo $hoy; ?>";
													var requestData = { 
														sistema: 'Informe con resumen del caso y del tratamiento...',
														paciente_id: paciente_id,
														accion: 'informe',
														fecha: fecha,
														tipo: 'informe',
														contenido: contenidoCopiado
													};

													$.ajax({
														url: 'chat_gpt.php',
														type: 'POST',
														data: requestData,
														success: function(html) {
															$("#gpt").html('<h1>Informe Generado Correctamente</h1><br><h4>Por favor, revise, modifique y/o corrija la información según sea necesario, del protocolo y las clinimetrías aplicadas. No olvide GUARDAR los cambios.</h4>'); 
															$('#loadx').hide();
															
															// Actualizar el contenido del editor2 con el informe generado
															CKEDITOR.instances.editor2.setData(html);
															$('#informe_btn').click();
															$('#accordion_2x_info').show();
														}
													});
												});

											</script>

<script>
    $(document).ready(function() {
        $('#edita_comentarios').on('click', function() {
            // Obtener el contenido del textarea
            var contenidoComentarios = $('#comentarios_rep').val().trim();

            if (contenidoComentarios === "") {
                alert("Por favor, ingresa comentarios antes de proceder.");
                return;
            }

            // Mostrar elementos de carga y ocultar otros si es necesario
            $('#gpt_reporte').show();
            $("#gpt").html('');
            $('#loadx').show();

            // Variables PHP pasadas al JavaScript
            var paciente_id = "<?php echo addslashes($paciente_id); ?>";
            var fecha = "<?php echo addslashes($hoy); ?>";

            // Datos a enviar en la solicitud AJAX
            var requestData = { 
                sistema: 'Recomendación del caso y del tratamiento...',
                paciente_id: paciente_id,
                accion: 'observaciones',
                fecha: fecha,
                tipo: 'reporte',
                contenido: contenidoComentarios
            };

            // Realizar la solicitud AJAX
            $.ajax({
                url: 'chat_gpt.php', // Asegúrate de que esta ruta sea correcta
                type: 'POST',
                data: requestData,
                success: function(response) {
                    // Manejar la respuesta del servidor
                    $("#gpt").html('<h1>El Informe de Recomendación se generó correctamente</h1><br><h4>Se recomienda revisar, modificar y/o corregir la información según sea necesario, incluir el protocolo a aplicar y GUARDAR los cambios.</h4>'); 
                    $('#loadx').hide();
                    
                    // Actualizar el contenido del editor1 con la recomendación generada (si usas CKEditor)
                    
                    CKEDITOR.instances.comentarios_rep.setData(response);
                    
					$("#test").html(response);
                    // Mostrar otros elementos o realizar otras acciones según sea necesario
                    //$('#recomendacion_btn').click();
                    //$('#accordion_1x_info').show();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // Manejar errores
                    alert("Ocurrió un error al procesar la solicitud: " + textStatus);
                    $('#loadx').hide();
                }
            });
        });
    });
</script>

											<script>
												document.getElementById('botonCopiar').addEventListener('click', function() {
												    var codigo = document.getElementById('codigo');
												    var rango = document.createRange();
												    rango.selectNode(codigo);
												    window.getSelection().removeAllRanges(); // Elimina rangos existentes
												    window.getSelection().addRange(rango); // Selecciona el texto del código
												    document.execCommand('copy'); // Ejecuta el comando de copia
												    window.getSelection().removeAllRanges(); // Elimina el rango seleccionado
												    alert('Información copiado al portapapeles'); // Opcional: muestra una alerta
												});			
											</script> 
											<script>
												document.getElementById('botonCopiar2').addEventListener('click', function() {
												    var codigo = document.getElementById('codigo_2');
												    var rango = document.createRange();
												    rango.selectNode(codigo);
												    window.getSelection().removeAllRanges(); // Elimina rangos existentes
												    window.getSelection().addRange(rango); // Selecciona el texto del código
												    document.execCommand('copy'); // Ejecuta el comando de copia
												    window.getSelection().removeAllRanges(); // Elimina el rango seleccionado
												    alert('Datos copiado al portapapeles'); // Opcional: muestra una alerta
												});			
											</script> 																			
											<script> 
												var week_data = <?php echo $grafica; ?>
												Morris.Line({
												  element: 'graph',
												  data: week_data,
												  xkey: 'y',
												  ykeys: ['PHQ9', 'GAD7', 'TINITUS', 'CPFDL'],
												  labels: ['PHQ9', 'GAD7', 'TINITUS', 'CPFDL'],
												  labelColor: ['#005157', '#007580', '#89CFE5','#FFDA00','#FFDA00','#BBBABA'],
							  					  lineColors: ['#005157', '#007580', '#89CFE5','#FFDA00','#FFDA00','#BBBABA'],			  
												});	
											</script>
										  <button style="display: none"  id="myButton" onclick="handleClick()">Botón</button>   
										<script>
										  window.addEventListener('DOMContentLoaded', function() {
										    html2canvas(document.getElementById('graph')).then(function(canvas) {
										      // Convierte el canvas en base64
										      var imgData = canvas.toDataURL('image/png');
										
										      // Datos adicionales a enviar
										      var datosAdicionales = {
										        paciente_id: '<?php echo $paciente_id; ?>'
										      };
										
										      // Combina los datos adicionales con la imagen en un solo objeto
										      var requestData = Object.assign({}, datosAdicionales, { image: imgData });
										
										      // Envía los datos al servidor utilizando una solicitud AJAX con jQuery
										      $.ajax({
										        url: 'guardar_imagen.php',
										        type: 'POST',
										        data: requestData,
										        success: function(response) {
										          // alert('La imagen se ha guardado correctamente.');
										        }
										      });
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
    </section>
<?php	include($ruta.'footer1.php');	?>

	<!-- Jquery DataTable Plugin Js -->
	<script src="<?php echo $ruta; ?>plugins/jquery-datatable/jquery.dataTables.js"></script>
	<script src="<?php echo $ruta; ?>plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
	<script src="<?php echo $ruta; ?>plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
	<script src="<?php echo $ruta; ?>plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
	<script src="<?php echo $ruta; ?>plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
	<script src="<?php echo $ruta; ?>plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
	<script src="<?php echo $ruta; ?>plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
	<script src="<?php echo $ruta; ?>plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
	<script src="<?php echo $ruta; ?>plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>

	<script src="<?php echo $ruta; ?>js/pages/tables/jquery-datatable.js"></script>

	<!-- Autosize Plugin Js -->
	<script src="<?php echo $ruta; ?>plugins/autosize/autosize.js"></script>

	<!-- Moment Plugin Js -->
	<script src="<?php echo $ruta; ?>plugins/momentjs/moment.js"></script>

	<!-- Jquery Knob Plugin Js -->
	<script src="<?php echo $ruta; ?>plugins/jquery-knob/jquery.knob.min.js"></script>

	<!-- Custom Js -->
	<script src="<?php echo $ruta; ?>js/pages/charts/jquery-knob.js"></script>  
	<script src="<?php echo $ruta; ?>js/pages/ui/tooltips-popovers.js"></script>


	<!-- Jquery Knob Plugin Js -->
	<script src="<?php echo $ruta; ?>plugins/jquery-knob/jquery.knob.min.js"></script>

	<!-- Ckeditor -->
	<script src="<?php echo $ruta; ?>plugins/ckeditor/ckeditor.js"></script>       

	<!-- TinyMCE -->
	<!-- <script src="<?php echo $ruta; ?>plugins/tinymce/tinymce.js"></script> -->


	<!-- <script src="<?php echo $ruta; ?>js/pages/forms/editors.js"></script>         -->
		
<?php	include($ruta.'footer2.php');	?>			