<?php

session_start();
error_reporting(7);
iconv_set_encoding('internal_encoding', 'utf-8'); 
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Monterrey');
setlocale(LC_TIME, 'es_ES.UTF-8');
$_SESSION['time']=mktime();
extract($_SESSION);
//print_r($_SESSION);
$ruta="../";
$title = 'Edita';


$hoy = date("Y-m-d");
$ahora = date("H:i:00"); 
$anio = date("Y");
$mes_ahora = date("m");
$titulo ="Directorio"; 

if ($funcion == 'SISTEMAS' || $funcion == 'ADMINISTRADOR' || $funcion == 'TECNICO') {
	$class = "js-exportable";	
	$where = "";
}else{
	$class = "";
	if ($funcion == 'MEDICO'){$where = "AND pacientes.usuario_id = $usuario_id";}else{$where = "";}
}

include($ruta.'header1.php');
//include($ruta.'header.php');
?>
    <link href="<?php echo $ruta; ?>plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
    
     <!-- Bootstrap Material Datetime Picker Css -->
    <link href="<?php echo $ruta; ?>plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />

    <!-- Bootstrap DatePicker Css -->
    <link href="<?php echo $ruta; ?>plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />

    <!-- Wait Me Css -->
    <link href="<?php echo $ruta; ?>plugins/waitme/waitMe.css" rel="stylesheet" />

    <!-- Bootstrap  Css -->
    <link href="<?php echo $ruta; ?>plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />   
    
<?php
include($ruta.'header2.php');
//include($ruta.'header.php'); 

$sql ="
SELECT														
	pacientes.paciente_id, 
	pacientes.usuario_id as usuario_idm, 
	pacientes.paciente, 
	pacientes.apaterno, 
	pacientes.amaterno, 
	pacientes.email, 
	pacientes.celular, 
	pacientes.f_nacimiento, 
	pacientes.sexo, 
	pacientes.contacto, 
	pacientes.parentesco, 
	pacientes.tel1, 
	pacientes.tel2, 
	pacientes.diagnostico, 
	pacientes.resumen_caso, 
	pacientes.diagnostico2, 
	pacientes.diagnostico3, 
	pacientes.medicamentos, 
	pacientes.f_captura, 
	pacientes.h_captura, 
	pacientes.estatus, 
	pacientes.observaciones, 
	pacientes.notificaciones, 
	pacientes.comentarios_reporte,
	pacientes.tratamiento
FROM
	pacientes
	WHERE
		pacientes.paciente_id = $paciente_id";
	echo $sql;	
    $result=ejecutar($sql); 
    $row = mysqli_fetch_array($result);
    extract($row);


?>

    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>PACIENTE</h2>
                 <?php //echo $ubicacion_url."<br>"; 
                // //echo $ruta."proyecto_medico/menu.php"?>
            </div>
<!-- // ************** Contenido ************** // -->
            <!-- CKEditor -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div style="height: 95%"  class="header">
                        	<?php //print_r($row); ?>
                        	<h1 align="center">Edita Pacientes</h1>
                        	<div class="body">

                            <form id="wizard_with_validation" method="POST" action="actualiza_alta.php" >
                            	<input type="hidden" id="paciente_id" name="paciente_id" value="<?php echo $paciente_id; ?>" />
                               <h3>Información del Paciente</h3>
                                <fieldset>                               	
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" id="paciente" name="paciente" value="<?php echo $paciente; ?>" class="form-control" required>
                                            <label class="form-label">Nombre/s*</label>
                                        </div>
                                    </div>
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" id="apaterno" name="apaterno" value="<?php echo $apaterno; ?>" class="form-control" required>
                                            <label class="form-label">Apellido Paterno*</label>
                                        </div>
                                    </div>
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" id="amaterno" name="amaterno" value="<?php echo $amaterno; ?>" class="form-control" required>
                                            <label class="form-label">Apellido Materno*</label>
                                        </div>
                                    </div>
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="email" id="email"  name="email" value="<?php echo $email; ?>" class="form-control" >
                                            <label class="form-label">Correo Electronico</label>
                                        </div>
                                    </div>
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="tel" id="celular" name="celular" value="<?php echo $celular; ?>" class="form-control" required>
                                            <label max="10" class="form-label">Celular*</label>
                                        </div>
                                    </div>
                                    <div class="form-group form-float">
                                    	<h4 class="card-inside-title">Fecha de Nacimiento*</h4>
                                        <div class="form-line">
                                            <input type="date" id="f_nacimiento"  name="f_nacimiento" value="<?php echo $f_nacimiento; ?>" class="form-control" required>
                                            
                                        </div>
                                    </div>
                                    <!-- <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="number" name="age" class="form-control" >
                                            <label class="form-label">Edad</label>
                                        </div>
                                    </div> -->
                                    <!-- <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="number" name="age" class="form-control" >
                                            <label class="form-label">Sexo</label>
                                        </div>
                                    </div> -->
	                                <div class="form-group form-float">
		                                <select class='form-control show-tick' id="sexo" name="sexo" >
	                                        <option <?php if($sexo == "Masculino"){ echo "selected";} ?>  value="Masculino">Masculino</option>
	                                        <option<?php if($sexo == "Femenino"){ echo "selected";} ?>  value="Femenino">Femenino</option>
	                                    </select>  
	                                    <label class="form-label">Sexo</label>               	
	                                </div>
                                </fieldset>
                                
                                <h3>Datos de Contacto</h3>
                                <fieldset>
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" id="contacto" name="contacto" value="<?php echo $contacto; ?>" class="form-control" required>
                                            <label class="form-label">Nombre de Acompañante*</label>
                                        </div>
                                    </div>
                                    <!-- <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="password" id="password" required>
                                            <label class="form-label">Parentesco*</label>
                                        </div>
                                    </div> -->
	                                <div class="form-group form-float">
		                                <select class='form-control show-tick'  id="parentesco" name="parentesco" >
	                                        <option value="">-- Selecciona Parentesco--</option>
	                                        <option <?php if($parentesco == "Papa"){ echo "selected";} ?> value="Papa">Papa</option>
	                                        <option <?php if($parentesco == "Mama"){ echo "selected";} ?> value="Mama">Mama</option>
	                                        <option <?php if($parentesco == "Esposa/o"){ echo "selected";} ?> value="Esposa/o">Esposa/o</option>
	                                        <option <?php if($parentesco == "Hija/o"){ echo "selected";} ?> value="Hija/o">Hija/o</option>
	                                        <option <?php if($parentesco == "Tia/o"){ echo "selected";} ?> value="Tia/o">Tia/o</option>
	                                        <option <?php if($parentesco == "Amistad"){ echo "selected";} ?> value="Amistad">Amistad</option>
	                                        <option <?php if($parentesco == "Asistente"){ echo "selected";} ?> value="Asistente">Asistente</option>
	                                        <option <?php if($parentesco == "Otro"){ echo "selected";} ?> value="Otro">Otro</option>
	                                    </select>  
	                                    <label class="form-label">Parentesco*</label>               	
	                                </div>
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="tel" class="form-control" id="tel1" name="tel1" value="<?php echo $tel1; ?>" required>
                                            <label class="form-label">Telefono 1*</label>
                                        </div>
                                    </div>
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="tel" class="form-control" id="tel2" name="tel2" value="<?php echo $tel2; ?>" >
                                            <label class="form-label">Telefono 2</label>
                                        </div>
                                    </div>
                                </fieldset>

								<h3>Medico Tratante</h3> 
								
	                                <div class="form-group form-float">
		                                <select class='form-control show-tick'  id="usuario_idm" name="usuario_idm" >
	                                        <option value="">-- Selecciona Medico Tratante --</option>
											<?php
												$sql_paciente = "
													SELECT
														admin.usuario_id as usuario_idx,
														admin.nombre,
														admin.usuario,
														admin.funcion,
														admin.estatus 
													FROM
														admin
													WHERE
													admin.funcion in('MEDICO','ADMINISTRADOR')
													ORDER BY nombre ASC";
												$result_paciente = ejecutar($sql_paciente);  
												$cnt_paciente = mysqli_num_rows($result_paciente);
												while($row_paciente = mysqli_fetch_array($result_paciente)){
									            extract($row_paciente); ?>
											<option <?php if($usuario_idx == $usuario_idm){ echo "selected";} ?> value="<?php echo $usuario_idx; ?>" ><?php echo $nombre; ?></option>
											<?php } ?>
	                                    </select>  
	                                    <label class="form-label">Medico Tratante*</label>               	
	                                </div>
	                                
                                <h3>Datos Clinicos</h3>
                                <h4>Coloque los motivos de derivación, elementos clínicos que considere relevantes para tomar en consideración para la aplicación de protocolos de TMS</h4>
                                <fieldset>
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <textarea class="form-control" id="resumen_caso" name="resumen_caso" rows="3" required><?php echo $resumen_caso; ?></textarea>
                                            <label class="form-label">Resumen del caso*</label>
                                        </div>
                                    </div> 
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <textarea class="form-control" id="diagnostico" name="diagnostico" rows="3"  required><?php echo $diagnostico; ?></textarea>
                                            <label class="form-label">Diagóstico (Principal)*</label>
                                        </div>
                                    </div>  
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <textarea class="form-control" id="diagnostico2" name="diagnostico2" rows="3" ><?php echo $diagnostico2; ?></textarea>
                                            <label class="form-label">Diagóstico 2</label>
                                        </div>
                                    </div> 
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <textarea class="form-control" id="diagnostico3" name="diagnostico3"  rows="3" ><?php echo $diagnostico3; ?></textarea>
                                            <label class="form-label">Diagóstico 3</label>
                                        </div>
                                    </div>                            
                                </fieldset>

                                <h3>Tratamiento farmacológico actual</h3>
                                <fieldset>
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <textarea class="form-control" id="medicamentos" name="medicamentos" rows="3"><?php echo $medicamentos; ?></textarea>
                                            <label class="form-label">Medicamentos</label>
                                        </div>
                                    </div> 
                                </fieldset>
                                <h3>Tratamiento no farmacológico actual</h3>
                                <fieldset>
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <textarea class="form-control" id="terapias" name="terapias" rows="3" ><?php echo $terapias; ?></textarea>
                                            <label class="form-label">Terapias alternas</label>
                                        </div>
                                    </div> 
                                </fieldset>

                                <h3>Protocolo que está Indicando</h3>                             
	                                <div class="form-group form-float">
		                                <select class='form-control show-tick'  id="tratamiento" name="tratamiento" >
	                                        
	                                        <option value="">Selecciona</option>
	                                        <option <?php if($tratamiento == "TMS Depresión (10 hz Corteza Dorsolateral Izquierda)"){ echo "selected";} ?> value="TMS Depresión (10 hz Corteza Dorsolateral Izquierda)">TMS Depresión (10 hz Corteza Dorsolateral Izquierda)</option>
	                                        <option <?php if($tratamiento == "TMS Ansiedad>Depresión (1 hz Corteza Dorsolateral Derecha)"){ echo "selected";} ?> value="TMS Ansiedad>Depresión (1 hz Corteza Dorsolateral Derecha)">TMS Ansiedad>Depresión (1 hz Corteza Dorsolateral Derecha)</option>
	                                        <option <?php if($tratamiento == "TMS TOC (2000 pulsos, 1hz Corteza Dorsolateral Derecha)"){ echo "selected";} ?> value="TMS TOC (2000 pulsos, 1hz Corteza Dorsolateral Derecha)">TMS TOC (2000 pulsos, 1hz Corteza Dorsolateral Derecha)</option>
	                                        <option <?php if($tratamiento == "TMS TEPT (10hz, Corteza Dorsolateral Derecha)"){ echo "selected";} ?> value="TMS TEPT (10hz, Corteza Dorsolateral Derecha)">TMS TEPT (10hz, Corteza Dorsolateral Derecha)</option>
	                                        <option <?php if($tratamiento == "TMS Tinnitus (1hz, T3)"){ echo "selected";} ?> value="TMS Tinnitus (1hz, T3)">TMS Tinnitus (1hz, T3)</option>
	                                        <option <?php if($tratamiento == "TMS Alucinaciones auditivas refractarias"){ echo "selected";} ?> value="TMS Alucinaciones auditivas refractarias">TMS Alucinaciones auditivas refractarias</option>
	                                        <option <?php if($tratamiento == "tDCS Depresión"){ echo "selected";} ?> value="tDCS Depresión">tDCS Depresión</option>
	                                        <option <?php if($tratamiento == "tDCS Adicciones"){ echo "selected";} ?> value="tDCS Adicciones">tDCS Adicciones</option>	                                        
	                                        <option <?php if($tratamiento == "tDCS Migraña, Fibromialgia, Dolor"){ echo "selected";} ?> value="tDCS Migraña, Fibromialgia, Dolor">tDCS Migraña, Fibromialgia, Dolor</option>
	                                        <option <?php if($tratamiento == "tDCS TOC"){ echo "selected";} ?> value="tDCS TOC">tDCS TOC</option>
	                                        <option <?php if($tratamiento == "TMS La que determine el equipo técnico"){ echo "selected";} ?> value="TMS La que determine el equipo técnico">TMS La que determine el equipo técnico</option>	        
	                                    	<option <?php if($tratamiento == "tDCS La que determine el equipo técnico"){ echo "selected";} ?> value="tDCS La que determine el equipo técnico">tDCS La que determine el equipo técnico</option>
	                                    </select>  
	                                    <label class="form-label">Protocolo*</label> <br>
	                                                	
	                                </div>                               
                                
                                <h4>Frecuencias altas pueden ayudar a síntomas depresivos, mientras que frecuencias bajas pueden ayudar a síntomas depresivos y de ansiedad. 
                                	Se recomienda tratamientos de 30 Sesiones</h4><br>
                                <fieldset>
								<?php 
                                    // $sql_protocolo = "
									// SELECT
										// protocolo_terapia.protocolo_ter_id, 
										// protocolo_terapia.prot_terapia
									// FROM
										// protocolo_terapia
                                    // ";
                                    // $result_protocolo=ejecutar($sql_protocolo); 
                                        // //echo $cnt."<br>";      
                                        // $saldo_t=0;
                                    // while($row_protocolo = mysqli_fetch_array($result_protocolo)){
                                        // extract($row_protocolo); 
                                        ?> 
                                    <!-- // <div class="form-group form-float">
                                        // <div class="form-line">
                                            // <input max="30" min="0" type="number" class="form-control" id="protocolo<?php echo $protocolo_ter_id; ?>" name="protocolo<?php echo $protocolo_ter_id; ?>" value="0" required>
                                            // <label class="form-label"><?php echo $prot_terapia; ?> Indica el Numero de Sesiones</label>
                                        	// <input type="hidden" id="protocolo_ter_id<?php echo $protocolo_ter_id; ?>" name="protocolo_ter_id<?php echo $protocolo_ter_id; ?>"  value ="<?php echo $protocolo_ter_id; ?>"
                                        	// <hr>
                                        // </div>
                                    // </div>	 -->								
									<?php // } ?>                                	
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <textarea class="form-control" id="observaciones" name="observaciones" rows="3" ><?php echo $observaciones; ?></textarea>
                                            <label class="form-label">Observaciones</label>
                                        </div>
                                    </div>									
	                                <h4>¿Desea recibir notificaciones móviles de cuando contactemos a su paciente y la fecha en la que iniciará?</h4><br>							
		                            <div class="demo-radio-button">
		                            	<input id="valida_notifica" type="text" style="width: 0px; height: 0px" value="<?php echo $notificaciones; ?>" required/>
		                                <input name="notificaciones" type="radio" id="radio_1" value="Si" class="radio-col-<?php echo $body; ?>" <?php if ( $notificaciones == "Si") { echo "checked";} ?>/>
		                                <label for="radio_1">Si</label>
		                                <input name="notificaciones" type="radio" id="radio_2" value="No" class="radio-col-<?php echo $body; ?>" <?php if ( $notificaciones == "No") { echo "checked";} ?>/>
		                                <label for="radio_2">No</label>
		                            </div>
					                <script type='text/javascript'>
						                $('#radio_1').click(function(){		                	
										    $('#valida_notifica').val('Si'); 		                    
						                });
						            </script>  
					                <script type='text/javascript'>
						                $('#radio_2').click(function(){		                	
										    $('#valida_notifica').val('No'); 		                    
						                });
						            </script> 		                                                
                                </fieldset> 
                                <hr>                               
                                <div class="row clearfix demo-button-sizes">
                                	<div class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
                                		<button type="submit" class="btn bg-green btn-block btn-lg waves-effect">GUARDAR</button>
                            		</div>
                        		</div>
                            </form>
                 
                   
                        		
	                       </div>
	                    </div>
	                </div>
	            </div>                        	
			</div>
		</div>
    </section>
<?php	

//include($ruta.'footer.php');

include($ruta.'footer1.php'); ?>


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


<?php include($ruta.'footer2.php');?>