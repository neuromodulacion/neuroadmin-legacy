<?php

// Define la ruta base para las inclusiones de archivos y establece el título de la página
$ruta = "../";
$title = 'INICIO';

// Inicializa variables con la fecha y hora actuales
$hoy = date("Y-m-d");
$ahora = date("H:i:00"); 
$anio = date("Y");
$mes_ahora = date("m");
$titulo = "Altas"; // Título específico de la sección actual

// Incluye la primera parte del encabezado (header) de la página
include($ruta.'header1.php');
?>

    <!-- Enlace al archivo CSS para los estilos de DataTables -->
    <link href="<?php echo $ruta; ?>plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
    
    <!-- Enlace al archivo CSS para el selector de fechas en Material Design -->
    <link href="<?php echo $ruta; ?>plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />

    <!-- Enlace al archivo CSS para el selector de fechas en Bootstrap -->
    <link href="<?php echo $ruta; ?>plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />

    <!-- Enlace al archivo CSS para el efecto de espera "Wait Me" -->
    <link href="<?php echo $ruta; ?>plugins/waitme/waitMe.css" rel="stylesheet" />

    <!-- Enlace al archivo CSS para el selector de opciones en Bootstrap -->
    <link href="<?php echo $ruta; ?>plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />   

<?php
// Incluye la segunda parte del encabezado (header) de la página
include($ruta.'header2.php'); 
?>

    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>ALTAS</h2>
                <!-- Ejemplo de comentario en HTML para mostrar la ruta de ubicación -->
                <!-- <?php echo $ubicacion_url."<br>"; ?> -->
            </div>
       
            <!-- Inicio del contenido principal de la página -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>ALTA DE PACIENTE</h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="javascript:void(0);">Action</a></li>
                                        <li><a href="javascript:void(0);">Another action</a></li>
                                        <li><a href="javascript:void(0);">Something else here</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <!-- Formulario para el registro de un nuevo paciente -->
                            <form id="wizard_with_validation" method="POST" action="guarda_alta.php" >
                            	
                               <h3>Información del Paciente</h3>
                                <fieldset>
                                    <!-- Campo para el nombre del paciente -->
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" id="paciente" name="paciente" class="form-control" required>
                                            <label class="form-label">Nombre/s*</label>
                                        </div>
                                    </div>
                                    <!-- Campo para el apellido paterno del paciente -->
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" id="apaterno" name="apaterno" class="form-control" required>
                                            <label class="form-label">Apellido Paterno*</label>
                                        </div>
                                    </div>
                                    <!-- Campo para el apellido materno del paciente -->
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" id="amaterno" name="amaterno" class="form-control" required>
                                            <label class="form-label">Apellido Materno*</label>
                                        </div>
                                    </div>

									<p><b>¿Cuenta con Correo?</b></p>   
									<div class="switch">
									    <label>No<input id="valmail" name="valmail" type="checkbox" checked><span class="lever"></span>Si</label>
									</div>  <br>                                  
									<!-- Campo para el correo electrónico del paciente -->
									<div class="form-group form-float" id="email-container">
									    <div class="form-line">
									        <input type="email" id="email"  name="email" class="form-control" required>
									        <label class="form-label">Correo Electrónico*</label>
									    </div>
									</div>
									
									<!-- Campo oculto por defecto -->
									<input type="hidden" id="email2" name="email" value="remisiones_bind@neuromodulaciongdl.com" class="form-control" disabled>
									
									<!-- Incluyendo jQuery -->
									<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
									
									<script>
									    $(document).ready(function(){
									        // Al cargar la página, verificar el estado inicial del checkbox
									        toggleEmailField();
									
									        // Escuchar el cambio del checkbox
									        $('#valmail').change(function() {
									            toggleEmailField();
									        });
									
									        function toggleEmailField() {
									            if ($('#valmail').is(':checked')) {
									                // Si el checkbox está marcado, mostrar el campo de correo, habilitar y agregar "required"
									                $('#email-container').show();
									                $('#email').prop('required', true).prop('disabled', false);
									                // Deshabilitar el campo oculto
									                $('#email2').prop('disabled', true);
									            } else {
									                // Si no está marcado, ocultar el campo de correo, quitar "required" y deshabilitar
									                $('#email-container').hide();
									                $('#email').prop('required', false).prop('disabled', true);
									                // Habilitar el campo oculto
									                $('#email2').prop('disabled', false);
									            }
									        }
									    });
									</script>

                                   
                                    
                                    <!-- Campo para el número de celular del paciente -->
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="tel" id="celular" name="celular" class="form-control" required>
                                            <label max="10" class="form-label">Celular*</label>
                                        </div>
                                    </div>
                                    <!-- Campo para la fecha de nacimiento del paciente -->
                                    <div class="form-group form-float">
                                    	<h4 class="card-inside-title">Fecha de Nacimiento*</h4>
                                        <div class="form-line">
                                            <input type="date" id="f_nacimiento"  name="f_nacimiento" class="form-control" required>
                                        </div>
                                    </div>
                                    <!-- Selector para el sexo del paciente -->
	                                <div class="form-group form-float">
		                                <select class='form-control show-tick' id="sexo" name="sexo" >
	                                        <option value="">-- Selecciona el Sexo--</option>
	                                        <option value="Masculino">Masculino</option>
	                                        <option value="Femenino">Femenino</option>
	                                    </select>  
	                                    <label class="form-label">Sexo</label>               	
	                                </div>
                                </fieldset>
                                
                                <h3>Datos de Contacto</h3>
                                <fieldset>
                                    <!-- Campo para el nombre del acompañante o familiar del paciente -->
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" id="contacto" name="contacto" class="form-control" required>
                                            <label class="form-label">Nombre de Acompañante y/o Familiar*</label>
                                        </div>
                                    </div>
                                    <!-- Selector para el parentesco del contacto -->
	                                <div class="form-group form-float">
		                                <select class='form-control show-tick'  id="parentesco" name="parentesco" >
	                                        <option value="">-- Selecciona Parentesco--</option>
	                                        <option value="Papa">Papa</option>
	                                        <option value="Mama">Mama</option>
	                                        <option value="Esposa/o">Esposa/o</option>
	                                        <option value="Hija/o">Hija/o</option>
	                                        <option value="Tia/o">Tia/o</option>
	                                        <option value="Amistad">Amistad</option>
	                                        <option value="Asistente">Asistente</option>
	                                        <option value="Otro">Otro</option>
	                                    </select>  
	                                    <label class="form-label">Parentesco*</label>               	
	                                </div>
                                    <!-- Campo para el primer número de teléfono de contacto -->
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="tel" class="form-control" id="tel1" name="tel1" required>
                                            <label class="form-label">Telefono 1*</label>
                                        </div>
                                    </div>
                                    <!-- Campo para el segundo número de teléfono de contacto (opcional) -->
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="tel" class="form-control" id="tel2" name="tel2" >
                                            <label class="form-label">Telefono 2</label>
                                        </div>
                                    </div>
                                </fieldset>

                                <h3>Medico Tratante</h3> 
                                <!-- Selector para seleccionar al médico tratante del paciente -->
	                                <div class="form-group form-float">
		                                <select class='form-control show-tick'  id="usuario_idm" name="usuario_idm" >
	                                        <option value="">-- Selecciona Medico Tratante --</option>
											<?php
                                                // Consulta SQL para obtener los médicos tratantes disponibles
												$sql_paciente = "
													SELECT
														admin.usuario_id AS usuario_idx,
														admin.nombre,
														admin.usuario,
														admin.funcion,
														admin.estatus 
													FROM
														admin 
													WHERE
														admin.estatus = 'Activo' 
														AND admin.funcion IN ( 'MEDICO', 'ADMINISTRADOR','COORDINADOR' ) 
														AND admin.empresa_id = $empresa_id 
														AND admin.estatus = 'Activo' 
													ORDER BY
														nombre ASC";
												$result_paciente = ejecutar($sql_paciente);  
												$cnt_paciente = mysqli_num_rows($result_paciente);
												while($row_paciente = mysqli_fetch_array($result_paciente)){
									            extract($row_paciente); ?>
											    <!-- Opciones para seleccionar al médico -->
											<option <?php if($usuario_idx == $usuario_idm){ echo "selected";} ?> value="<?php echo $usuario_idx; ?>" ><?php echo $nombre; ?></option>
											<?php } ?>
	                                    </select>  
	                                    <label class="form-label">Medico Tratante*</label>               	
	                                </div> 

                                <h3>Datos Clinicos</h3>
                                <h4>Coloque los motivos de derivación, elementos clínicos que considere relevantes para tomar en consideración para la aplicación de protocolos de TMS</h4>
                                <fieldset>
                                    <!-- Campo para el resumen del caso clínico -->
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <textarea class="form-control" id="resumen_caso" name="resumen_caso" rows="3" required></textarea>
                                            <label class="form-label">Resumen del caso*</label>
                                        </div>
                                    </div> 
                                    <!-- Campo para el diagnóstico principal -->
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <textarea class="form-control" id="diagnostico" name="diagnostico" rows="3" required></textarea>
                                            <label class="form-label">Diagóstico (Principal)*</label>
                                        </div>
                                    </div>  
                                    <!-- Campo para un segundo diagnóstico (opcional) -->
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <textarea class="form-control" id="diagnostico2" name="diagnostico2" rows="3" ></textarea>
                                            <label class="form-label">Diagóstico 2</label>
                                        </div>
                                    </div> 
                                    <!-- Campo para un tercer diagnóstico (opcional) -->
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <textarea class="form-control" id="diagnostico3" name="diagnostico3" rows="3" ></textarea>
                                            <label class="form-label">Diagóstico 3</label>
                                        </div>
                                    </div>                            
                                </fieldset>

                                <h3>Tratamiento farmacológico actual</h3>
                                <fieldset>
                                    <!-- Campo para listar los medicamentos actuales del paciente -->
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <textarea class="form-control" id="medicamentos" name="medicamentos" rows="3" ></textarea>
                                            <label class="form-label">Medicamentos</label>
                                        </div>
                                    </div> 
                                </fieldset>

                                <h3>Tratamiento no farmacológico actual</h3>
                                <fieldset>
                                    <!-- Campo para listar las terapias alternas actuales del paciente -->
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <textarea class="form-control" id="terapias" name="terapias" rows="3" ></textarea>
                                            <label class="form-label">Terapias alternas</label>
                                        </div>
                                    </div> 
                                </fieldset>

                                <h3>Protocolo que está Indicando</h3>
                                <!-- Selector para elegir el protocolo de tratamiento -->
	                                <div class="form-group form-float">
		                                <select class='form-control show-tick'  id="tratamiento" name="tratamiento" >
	                                        <option value="">Selecciona</option>
	                                        <option value="TMS Depresión (10 hz Corteza Dorsolateral Izquierda)">TMS Depresión (10 hz Corteza Dorsolateral Izquierda)</option>
	                                        <option value="TMS Ansiedad>Depresión (1 hz Corteza Dorsolateral Derecha)">TMS Ansiedad>Depresión (1 hz Corteza Dorsolateral Derecha)</option>
	                                        <option value="TMS TOC (2000 pulsos, 1hz Corteza Dorsolateral Derecha)">TMS TOC (2000 pulsos, 1hz Corteza Dorsolateral Derecha)</option>
	                                        <option value="TMS TEPT (10hz, Corteza Dorsolateral Derecha)">TMS TEPT (10hz, Corteza Dorsolateral Derecha)</option>
	                                        <option value="TMS Tinnitus (1hz, T3)">TMS Tinnitus (1hz, T3)</option>
	                                        <option value="TMS Alucinaciones auditivas refractarias">TMS Alucinaciones auditivas refractarias</option>
	                                        <option value="tDCS Depresión">tDCS Depresión</option>
	                                        <option value="tDCS Adicciones">tDCS Adicciones</option>	                                        
	                                        <option value="tDCS Migraña, Fibromialgia, Dolor">tDCS Migraña, Fibromialgia, Dolor</option>
	                                        <option value="tDCS TOC">tDCS TOC</option>
	                                        <option value="TMS La que determine el equipo técnico">TMS La que determine el equipo técnico</option>	        
	                                    	<option value="tDCS La que determine el equipo técnico">tDCS La que determine el equipo técnico</option>
	                                    </select>  
	                                    <label class="form-label">Protocolo*</label> <br>
	                                </div>
	                                                                
                                 <h4>Frecuencias altas pueden ayudar a síntomas depresivos, mientras que frecuencias bajas pueden ayudar a síntomas depresivos y de ansiedad. 
                                	Se recomienda tratamientos de 30 Sesiones</h4><br>
                                
                                    <!-- Campo para agregar observaciones adicionales -->
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <textarea class="form-control" id="observaciones" name="observaciones" rows="3" ></textarea>
                                            <label class="form-label">Observaciones</label>
                                        </div>
                                    </div>									
	                                <h4>¿Desea recibir notificaciones móviles de cuando contactemos a su paciente y la fecha en la que iniciará?</h4><br>								
		                            <div class="demo-radio-button">
		                                <input name="notificaciones" type="radio" id="radio_1" value="Si" class="radio-col-<?php echo $body; ?>" checked/>
		                                <label for="radio_1">Si</label>
		                                <input name="notificaciones" type="radio" id="radio_2" value="No" class="radio-col-<?php echo $body; ?>" />
		                                <label for="radio_2">No</label>
		                            </div>
                                     
                                </fieldset> 
                                <hr>                               
                                <div class="row clearfix demo-button-sizes">
                                	<div class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
                                		<!-- Botón para guardar los datos del paciente -->
                                		<button type="submit" class="btn bg-green btn-block btn-lg waves-effect">GUARDAR</button>
                            		</div>
                        		</div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Fin del formulario avanzado con validación -->
              
        </div>
    </section>

<?php 
// Incluye el primer pie de página (footer)
include($ruta.'footer1.php'); 
?>

    <!-- Enlaces a los scripts necesarios para la funcionalidad de la página -->
    <script src="<?php echo $ruta; ?>plugins/momentjs/moment.js"></script>
    <script src="<?php echo $ruta; ?>plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
    <script src="<?php echo $ruta; ?>plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script src="<?php echo $ruta; ?>plugins/autosize/autosize.js"></script>
    <script src="<?php echo $ruta; ?>plugins/momentjs/moment.js"></script>

<?php 
// Incluye el segundo pie de página (footer)
include($ruta.'footer2.php'); 
?>

