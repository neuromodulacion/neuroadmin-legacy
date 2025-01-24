<?php

$ruta="../";
$titulo ="Clinimetria";
$genera ="";

include($ruta.'header1.php'); 
include('fun_clinimetria.php'); 

$encuesta = $encuesta ?? ''; // Valor predeterminado si no está definido
$descripcion = $descripcion ?? ''; // Valor predeterminado si no está definido

?>

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
	
<?php
include($ruta.'header2.php');
include('calendario.php');
include('fun_paciente.php');
 ?>
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>CLINIMETRIA</h2>
                
				<?php
				// Validar que $paciente_id esté definido y sea un número entero
				if (!isset($paciente_id) || !is_numeric($paciente_id)) {
					die('ID de paciente inválido.');
				}

				// Consulta preparada segura
				$sql = "
					SELECT 
						paciente_id,
						paciente,
						apaterno,
						amaterno 
					FROM 
						pacientes 
					WHERE 
						paciente_id = ?
				";

				// Usando la clase Mysql personalizada
				$resultado = $mysql->consulta($sql, [$paciente_id]);

				if ($resultado['numFilas'] > 0) {
					// Extraer la primera fila del resultado
					$row = $resultado['resultado'][0];

					// Asignar cada campo a una variable
					$paciente_id = $row['paciente_id'];
					$paciente = codificacionUTF($row['paciente']);
					$apaterno = codificacionUTF($row['apaterno']);
					$amaterno = codificacionUTF($row['amaterno']);
				} else {
					die('Paciente no encontrado.');
				}
				?>

            </div>
<!-- // ************** Contenido ************** // -->
            <!-- CKEditor -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div style="height: 95%"  class="header">
                        	<h1 align="center">Paciente <?php echo "No. ".$paciente_id." ".$paciente." ".$apaterno." ".$amaterno; ?></h1>
                        	
							<?php

								$sql_bases = "
								SELECT
									base_encuesta_$encuesta_id.base_id,
									base_encuesta_$encuesta_id.paciente_id,
									base_encuesta_$encuesta_id.usuario_id,
									base_encuesta_$encuesta_id.f_captura,
									base_encuesta_$encuesta_id.h_captura,
									base_encuesta_$encuesta_id.*,";												
																					
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
								$sql_basesX = "";
						     	$result_preguntas=ejecutar($sql_preguntas); 
						    	while($row_preguntas = mysqli_fetch_array($result_preguntas)){
							        extract($row_preguntas);			
																			
									$sql_basesX .= "
									( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta LIKE base_encuesta_$encuesta_id.respuesta_$pregunta_id and respuestas.encuesta_id = $encuesta_id )+";
							
								}
								
									$sql_basesX = substr($sql_basesX, 0, -1);

									$sql_bases .= "
										$sql_basesX as total
									FROM
										base_encuesta_$encuesta_id
									WHERE
										base_encuesta_$encuesta_id.paciente_id = $paciente_id
										and base_encuesta_$encuesta_id.base_id = $base_id
									ORDER BY f_captura DESC";

									//echo $sql_bases."<hr>";
									
									$result_bases=ejecutar($sql_bases);
									$cnt_bases = mysqli_num_rows($result_bases);
									//$dia .= $sql_bases."<br> Res".$cnt_bases."<hr>";
									
									if ($cnt_bases >= 1) {

										$dia .= $encuesta." - ".codificacionUTF($descripcion)."<hr>
										<div class='row'>
										  <div class='col-md-5'>";
										$datos = "";															
										$tabla ="													
										<table style='width: 50%'  class='table table-bordered'>
											<tr>
												<th>Fecha</th>
												<th>Resultado</th>
												<th>Evaluación</th>
											</tr>";
											
										$cnt_calificacion = 1;	
								    	while($row_bases = mysqli_fetch_array($result_bases)){
									        extract($row_bases);
											//print_r($row_bases);
											
										$color = "";
											
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
											AND calificaciones.min <= $total 
											AND calificaciones.max >= $total";
											
										//$tabla .= $sql_calificacion."<hr>";	
										$result_calificacion = ejecutar($sql_calificacion);	
										
										$row_calificacion = mysqli_fetch_array($result_calificacion);	
										extract($row_calificacion);
										
											if ($cnt_calificacion == 1) {
												$tot_ini = $total;
											}
											//$encuesta_id - $base_id
											$tabla .="
											<tr>
												<td>$f_captura</td>
												<td style='text-align: center'>$total</td>
												<td style='background-color: $color'>".codificacionUTF($valor)."</td>
											</tr>
											";

											$cnt_calificacion ++;
										}													
										$tabla .="</table>";
										
										$resultado_final = round(($tot_ini/$total)*100,0);
										//$resultado_final = round(($total/$tot_ini)*100,0);
										$resultado_final = 100 -$resultado_final;
										
										if ($resultado_final < 0) {
											$respuesta = "un Incremento";
										}else{
											$respuesta = "una Disminución";
										}
										$n_grf = "enc_".$encuesta_id."_pac_".$paciente_id;
	
									}
																
									echo $tabla;

									$sql_sem1 = "
										SELECT
											preguntas_encuestas.pregunta_id, 
											preguntas_encuestas.encuesta_id, 
											preguntas_encuestas.numero, 
											preguntas_encuestas.pregunta, 
											preguntas_encuestas.respuesta_1 as respuestax_1, 
											preguntas_encuestas.respuesta_2 as respuestax_2, 
											preguntas_encuestas.respuesta_3 as respuestax_3, 
											preguntas_encuestas.respuesta_4 as respuestax_4, 
											preguntas_encuestas.respuesta_5 as respuestax_5, 
											preguntas_encuestas.respuesta_6 as respuestax_6, 
											preguntas_encuestas.respuesta_7 as respuestax_7, 
											preguntas_encuestas.respuesta_8 as respuestax_8, 
											preguntas_encuestas.respuesta_9 as respuestax_9, 
											preguntas_encuestas.respuesta_10 as respuestax_10, 
											preguntas_encuestas.tipo
										FROM
											preguntas_encuestas
										WHERE
											preguntas_encuestas.encuesta_id =$encuesta_id	
									    ";
										//echo "<hr>".$sql_sem1."<hr>";

										$result_sem1 = ejecutar($sql_sem1); 
										$preguntas = "";
										$preguntasx = "";
								        $cnt=0;
		
									//	$preguntas .= "
									//		<input  name='preg_$pregunta_id' type='hidden' id='list' name='list' value='$list' required />
									//		<input  name='preg_$pregunta_id' type='hidden' id='encuestas' name='encuestas' value='$encuestas' required />"; 	
										
								    while($row_sem1 = mysqli_fetch_array($result_sem1)){
								        extract($row_sem1);
										// print_r($row_sem1);
										//echo "<hr>";
										$cnt++;
										//echo $tipo."<hr>";
										// echo 'respuesta_'.$pregunta_id.'<br>';
										
										$respuestax = 'respuesta_'.$pregunta_id;
										$pregunta = codificacionUTF($pregunta);
										 // echo $respuestax_1.'<br>';
										 // echo $$respuestax.'<hr>';
			
										switch ($tipo) {
											case 'radio': 
											
											if ($respuestax_1 == $$respuestax) { $checked_1 = "checked";} else {$checked_1 = "";}
											if ($respuestax_2 == $$respuestax) { $checked_2 = "checked";} else {$checked_2 = "";}
											if ($respuestax_3 == $$respuestax) { $checked_3 = "checked";} else {$checked_3 = "";}
											if ($respuestax_4 == $$respuestax) { $checked_4 = "checked";} else {$checked_4 = "";}
											if ($respuestax_5 == $$respuestax) { $checked_5 = "checked";} else {$checked_5 = "";}
											if ($respuestax_6 == $$respuestax) { $checked_6 = "checked";} else {$checked_6 = "";}
											if ($respuestax_7 == $$respuestax) { $checked_7 = "checked";} else {$checked_7 = "";}
											if ($respuestax_8 == $$respuestax) { $checked_8 = "checked";} else {$checked_8 = "";}
											if ($respuestax_9 == $$respuestax) { $checked_9 = "checked";} else {$checked_9 = "";}

											if ($respuestax_10 == $$respuestax) { $checked_10 = "checked";} else {$checked_10 = "";}
																				
											
												$preguntas .= "<hr>
											        <h4>$numero.- $pregunta</h4><br>								
											        <div class='demo-radio-button'>
											        	<input style='height: 0px; width: 0px' name='preg_$pregunta_id' type='text' id='preg_$pregunta_id' value='' required />  
											            <input name='pregunta_$pregunta_id' type='radio' id='respuestax_1$pregunta_id' value='$respuestax_1' $checked_1 disabled />		            
											            <label for='respuestax_1$pregunta_id'>".codificacionUTF($respuestax_1)."</label>   
									            		<script type='text/javascript'>
									                            $('#respuestax_1$pregunta_id').click(function(){ $('#preg_$pregunta_id').val('ok'); });										
									                    </script>
											            <input name='pregunta_$pregunta_id' type='radio' id='respuestax_2$pregunta_id' value='$respuestax_2' $checked_2 disabled />		            
											            <label for='respuestax_2$pregunta_id'>".codificacionUTF($respuestax_2)."</label>   
									            		<script type='text/javascript'>
									                            $('#respuestax_2$pregunta_id').click(function(){ $('#preg_$pregunta_id').val('ok'); });										
									                  </script>";
								 				if ($respuestax_3 <> "" ) {
													$preguntas .= "
									 		            <input name='pregunta_$pregunta_id' type='radio' id='respuestax_3$pregunta_id' value='$respuestax_3' $checked_3 disabled />		            
											            <label for='respuestax_3$pregunta_id'>".codificacionUTF($respuestax_3)."</label>   
									            		<script type='text/javascript'>
									                            $('#respuestax_3$pregunta_id').click(function(){ $('#preg_$pregunta_id').val('ok'); });										
									                    </script>";										 
												 }
								 				if ($respuestax_4 <> "" ) {
													$preguntas .= "
									 		            <input name='pregunta_$pregunta_id' type='radio' id='respuestax_4$pregunta_id' value='$respuestax_4' $checked_4 disabled />		            
											            <label for='respuestax_4$pregunta_id'>".codificacionUTF($respuestax_4)."</label>   
									            		<script type='text/javascript'>
									                            $('#respuestax_4$pregunta_id').click(function(){ $('#preg_$pregunta_id').val('ok'); });										
									                    </script>";										 
												 }                  
								 				if ($respuestax_5 <> "" ) {
													$preguntas .= "
									 		            <input name='pregunta_$pregunta_id' type='radio' id='respuestax_5$pregunta_id' value='$respuestax_5' $checked_5 disabled />		            
											            <label for='respuestax_5$pregunta_id'>".codificacionUTF($respuestax_5)."</label>   
									            		<script type='text/javascript'>
									                            $('#respuestax_5$pregunta_id').click(function(){ $('#preg_$pregunta_id').val('ok'); });										
									                    </script>";										 
												 }
								 				if ($respuestax_6 <> "" ) {
													$preguntas .= "
									 		            <input name='pregunta_$pregunta_id' type='radio' id='respuestax_6$pregunta_id' value='$respuestax_6' $checked_6 disabled />		            
											            <label for='respuestax_6$pregunta_id'>".codificacionUTF($respuestax_6)."</label>   
									            		<script type='text/javascript'>
									                            $('#respuestax_6$pregunta_id').click(function(){ $('#preg_$pregunta_id').val('ok'); });										
									                    </script>";										 
												 }				 
								 				if ($respuestax_7 <> "" ) {
													$preguntas .= "
									 		            <input name='pregunta_$pregunta_id' type='radio' id='respuestax_7$pregunta_id' value='$respuestax_7' $checked_7 disabled />		            
											            <label for='respuestax_7$pregunta_id'>".codificacionUTF($respuestax_7)."</label>   
									            		<script type='text/javascript'>
									                            $('#respuestax_7$pregunta_id').click(function(){ $('#preg_$pregunta_id').val('ok'); });										
									                    </script>";										 
												 }
								 				if ($respuestax_8 <> "" ) {
													$preguntas .= "
									 		            <input name='pregunta_$pregunta_id' type='radio' id='respuestax_8$pregunta_id' value='$respuestax_8' $checked_8 disabled />		            
											            <label for='respuestax_8$pregunta_id'>".codificacionUTF($respuestax_8)."</label>   
									            		<script type='text/javascript'>
									                            $('#respuestax_8$pregunta_id').click(function(){ $('#preg_$pregunta_id').val('ok'); });										
									                    </script>";										 
												 }
								 				if ($respuestax_9 <> "" ) {
													$preguntas .= "
									 		            <input name='pregunta_$pregunta_id' type='radio' id='respuestax_9$pregunta_id' value='$respuestax_9' $checked_9 disabled />		            
											            <label for='respuestax_9$pregunta_id'>".codificacionUTF($respuestax_9)."</label>   
									            		<script type='text/javascript'>
									                            $('#respuestax_9$pregunta_id').click(function(){ $('#preg_$pregunta_id').val('ok'); });										
									                    </script>";										 
												 }				 
								 				if ($respuestax_10 <> "" ) {
													$preguntas .= "
									 		            <input name='pregunta_$pregunta_id' type='radio' id='respuestax_10$pregunta_id' value='$respuestax_10' $checked_10 disabled />		            
											            <label for='respuestax_10$pregunta_id'>".codificacionUTF($respuestax_10)."</label>   
									            		<script type='text/javascript'>
									                            $('#respuestax_10$pregunta_id').click(function(){ $('#preg_$pregunta_id').val('ok'); });										
									                    </script>";										 
												 }				 				                     
										    	$preguntas .= "</div>";
										
												
												break;
											case 'select':
											$preguntas .= "<hr>
								                    <div>
								                    	<h4>$numero.- $pregunta</h4><br>								
								                        <div class='form-group form-float'>
								                            
											                <select id='pregunta_$pregunta_id' name='pregunta_$pregunta_id' class='form-control show-tick'>
											                    <option value=''>-- Seleciona tipo de Respuesta --</option>
											                    <option value='$respuestax_1'>".codificacionUTF($respuestax_1)."</option>
											                    <option value='$respuestax_2'>".codificacionUTF($respuestax_2)."</option>";
												 				if ($respuestax_3 <> "" ) { $preguntas .= "<option value='$respuestax_3'>".codificacionUTF($respuestax_3)."</option>"; }			                    
															    if ($respuestax_4 <> "" ) { $preguntas .= "<option value='$respuestax_4'>".codificacionUTF($respuestax_3)."</option>"; }
															    if ($respuestax_5 <> "" ) { $preguntas .= "<option value='$respuestax_5'>".codificacionUTF($respuestax_3)."</option>"; }
																if ($respuestax_6 <> "" ) { $preguntas .= "<option value='$respuestax_6'>".codificacionUTF($respuestax_3)."</option>"; }
																if ($respuestax_7 <> "" ) { $preguntas .= "<option value='$respuestax_7'>".codificacionUTF($respuestax_3)."</option>"; }
																if ($respuestax_8 <> "" ) { $preguntas .= "<option value='$respuestax_8'>".codificacionUTF($respuestax_3)."</option>"; }
																if ($respuestax_9 <> "" ) { $preguntas .= "<option value='$respuestax_9'>".codificacionUTF($respuestax_3)."</option>"; }
																if ($respuestax_10 <> "" ) { $preguntas .= "<option value='$respuestax_10'>".codificacionUTF($respuestax_3)."</option>"; }                			                    			      
											      $preguntas .= "              
								                            </select> 
								                    	</div> 
								                	</div>";			
												
												break;
										
											case 'text':
											$preguntas .= "<hr>
								                    <div>
								                    	<h4>$numero.- $pregunta</h4><br>								
								                        <div class='form-group form-float'>
								                           
								                            <input class='form-control' name='pregunta_$pregunta_id' type='text' id='pregunta_$pregunta_id' placeholder='$pregunta'   value='".codificacionUTF($$respuestax)."'disabled />
								                             
								                    	</div> 
								                	</div>";				
												break;
											case 'textarea':
											$preguntas .= "<hr>			
								                <div class='form-group form-float'>
								                    <div class='form-line'>
								                        <textarea class='form-control' id='observaciones$pregunta_id' name='observaciones$pregunta_id' rows='3' required>".codificacionUTF($$respuestax)."</textarea>
								                        <label class='form-label'>Observaciones</label>
								                    </div>
								                </div>";
												break;
										
											case 'date':
											$preguntas .= "<hr>
								                    <div>
								                    	<h4>$numero.- $pregunta</h4><br>								
								                        <div class='form-group form-float'>
								                            <input class='form-control' name='pregunta_$pregunta_id' type='date' id='pregunta_$pregunta_id' placeholder='$pregunta'  value='".codificacionUTF($$respuestax)."'disabled />
								                             
								                    	</div> 
								                	</div>";				
												break;
											case 'number':
											$preguntas .= "<hr>
								                    <div>
								                    	<h4>$numero.- $pregunta</h4><br>								
								                        <div class='form-group form-float'>
								                            <input class='form-control' name='pregunta_$pregunta_id' type='number' id='pregunta_$pregunta_id' placeholder='$pregunta'  value='".codificacionUTF($$respuestax)."'disabled />
								                             
								                    	</div> 
								                	</div>";				
												break;
										
											case 'titulo':
												
											$preguntas .= "<hr>
								                    <div>
								                    	<h1>$pregunta</h1><br>								
								                	</div>";				
												break;
											case 'instrucciones':
												
											$preguntas .= "<hr>
								                    <div>
								                    	<h4>$pregunta</h4><br>
								                    	<p>".codificacionUTF($respuestax_1)."</p><br>								
								                	</div>";				
												break;
																	
											default:
												
												break;
										}
										
											// echo $pregunta;
									}	
								echo $preguntas;
?>                        	                    	
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
          
<?php	include($ruta.'footer2.php');	?>			