<?php

session_start();
error_reporting(7);
iconv_set_encoding('internal_encoding', 'utf-8'); 
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Monterrey');
setlocale(LC_TIME, 'es_ES.UTF-8');
$_SESSION['time']=mktime();

$ruta="../";
$title = 'INICIO';

extract($_SESSION);
extract($_POST);
extract($_GET);
//print_r($_SESSION);

$hoy = date("Y-m-d");
$ahora = date("H:i:00"); 
$anio = date("Y");
$mes_ahora = date("m");
$mes = strftime("%B");
$dia = date("N");
$semana = date("W");
$titulo ="Paciente";
$genera ="";

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
	
<?php
include($ruta.'header2.php');
include('calendario.php');
include('fun_paciente.php');
 ?>
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>PACIENTE</h2>
            </div>
<!-- // ************** Contenido ************** // -->
            <!-- CKEditor -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div style="height: 95%"  class="header">
                        	<h1 align="center">Paciente</h1>
                             	<div class="row">
                             		<div align="left" class="col-xs-12">
		                                <div class="form-line">	                                	
		                                	<?php //print_r($_GET); 
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
													    $result=ejecutar($sql); 
													    $row = mysqli_fetch_array($result);
													    extract($row);		
														
														$f_ini = strftime("%e-%b-%Y",strtotime($f_ini));
																										
														$dia .="<hr><h2><b>Cita</b></h2><br>
														Fecha: $f_ini<br>
														Hora de inicio: $h_ini<br>
														Hora final: $h_fin"; 
														
												} else {
														$sql ="
														SELECT														
															*
														FROM
															pacientes
															WHERE
																pacientes.paciente_id = $paciente_id";
															//echo $sql;	
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
											    $dia = "<hr><h1><b>No. ".$paciente_id." ".$paciente." ".$apaterno." ".$amaterno."<b></h1>";		                                	
	                                			//<a class='btn bg-$body waves-effect' target='_blank' href='pdf_html.php?paciente_id=$paciente_id' role='button'>Descarga Reporte</a>
												$dia .= "								
						                            <button class='btn bg-$body waves-effect m-b-15' type='button' data-toggle='collapse' data-target='#collapseExamplex' aria-expanded='false'
						                                    aria-controls='collapseExamplex'>
						                                Descarga Reporte
						                            </button>
						                            <div class='collapse' id='collapseExamplex'>
						                                <div class='well'>
						                                	<h2><b>* Comentarios para el reporte:</b></h2><br>
						                                	<textarea id='comentarios_rep' class='form-control' rows='3' placeholder='Debe de tener comentarios para descargar el reporte'>$comentarios_reporte</textarea>
						                                	<br><button id='guarda_comentarios' type='button' class='btn bg-teal waves-effect'>Guarda Comentarios</button>
													         <script type='text/javascript'>
												                $('#guarda_comentarios').click(function(){
												                	var paciente_id = '$paciente_id'; 
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
						                                <hr><a $style class='btn bg-$body waves-effect'  id='descarga' target='_blank' href='pdf_html.php?paciente_id=$paciente_id' role='button' >Descarga Reporte  <i class='material-icons'>file_download</i></a>
						                                </div>
						                            </div>	";								
									
												
												$edad = obtener_edad_segun_fecha($f_nacimiento);																									
												$dia .= "<hr>
													<h2><b>Información del Paciente</b></h2><br>
													Celular: $celular<br>Correo electronico: $email<br>Edad: $edad años<br>Sexo: $sexo<hr>
													<h2><b>Datos de Contacto</b></h2><br>
													Contacto: $contacto<br>Parentesco: $parentesco<br>
													Telefonos de contacto: $tel1 - $tel2<hr>
													
				                                    <h2><b>Datos Clinicos</b></h2><br>
				                                    <div class='panel-group' id='accordion_1' role='tablist' aria-multiselectable='true'>
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
				                                    </div>
				                                    <hr><h2><b>Medicamentos</b></h2><br>
				                                    $medicamentos
				                                    
				                                    <hr>
				                                    <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
				                                    <h2><b>Protocolo indicado</b></h2><br>													
												";													
												$dia .= "<table class='table table-bordered'>
															<tr>												   				
												   				<th style='width: 30%;'>Protocolo</th>
												   				<th style='width:  7%;'>Sesiones</th>
												   				<th style='width:  5%;' >Aplicadas</th>
												   				<th style='width:  7%;'>Estatus</th>
												   				<th style='width: 51%;'>Observaciones</th>
															</tr>";
																							
												$sql_sem2 = "
													SELECT
														terapias.terapia_id, 
														protocolo_terapia.protocolo_ter_id, 
														sesiones.sesiones, 
														protocolo_terapia.prot_terapia, 
														terapias.observaciones, 
														terapias.estatus, 
														terapias.paciente_id, 
														sesiones.total_sesion
													FROM
														sesiones
														INNER JOIN
														terapias
														ON 
															sesiones.paciente_id = terapias.paciente_id
														INNER JOIN
														protocolo_terapia
														ON 
															sesiones.protocolo_ter_id = protocolo_terapia.protocolo_ter_id
													WHERE
														terapias.paciente_id = $paciente_id
													ORDER BY protocolo_ter_id asc 
												    ";
													//echo "$sql_sem2 <br>";
										     	$result_sem2=ejecutar($sql_sem2); 
													$total_sesiones = 0;
													$Gtotal = 0;
										    	while($row_sem2 = mysqli_fetch_array($result_sem2)){
											        extract($row_sem2);	
											       // print_r($row_sem2);											        
												   	$dia .= "<tr>									   				
												   				<td>$prot_terapia</td>
												   				<td>$sesiones</td>
												   				<td>$total_sesion</td>
												   				<td>$estatus</td>
												   				<td>$observaciones</td>
															</tr>";   
													  
											        $total_sesiones = $total_sesiones+$sesiones;
											        $Gtotal = $Gtotal+$total_sesion;
										        }

											   	$dia .= "<tr>											   				
											   				<th>Total</th>
											   				<th>$total_sesion</th>
											   				<th>$Gtotal</th>
											   				<th colspan='2'></th>   				
														</tr>"; 										        
										        										        
										        $dia .= "</table></div><hr>
										        <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'><br>
										        <h2><b>Evaluación Graficada</b></h2><br>";
												
												//$dia .= medicion_protocolo($paciente_id);

												$sql_encuestas = "
												SELECT
													encuesta_id, 
													encuesta, 
													descripcion,
													CONCAT('base_encuesta_',encuesta_id) as bases
												FROM
													encuestas";
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
													$sql_basesX = "";
											     	$result_preguntas=ejecutar($sql_preguntas); 
											    	while($row_preguntas = mysqli_fetch_array($result_preguntas)){
												        extract($row_preguntas);			
																								
														$sql_basesX .= "
														( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_encuesta_$encuesta_id.respuesta_$pregunta_id )+";
												
													}
													
														$sql_basesX = substr($sql_basesX, 0, -1);

														$sql_bases .= "
															$sql_basesX as total
														FROM
															base_encuesta_$encuesta_id
														WHERE
															base_encuesta_$encuesta_id.paciente_id = $paciente_id";

										
														$result_bases=ejecutar($sql_bases);
														$cnt_bases = mysqli_num_rows($result_bases);
														//$dia .= $sql_bases."<br> Res".$cnt_bases."<hr>";
														
														if ($cnt_bases >= 1) {
		
															$dia .= $encuesta." - ".$descripcion."<hr>
															<div class='row'>
															  <div class='col-md-5'>";
															$datos = "";															
															$tabla ="													
															<table  class='table table-bordered'>
																<tr>
																	<th>Fecha</th>
																	<th>Resultado</th>
																	<th>Evaluación</th>
																</tr>";
																
															$cnt_calificacion = 1;	
													    	while($row_bases = mysqli_fetch_array($result_bases)){
														        extract($row_bases);
															
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
																$tabla .="
																<tr>
																	<td>$f_captura</td>
																	<td style='text-align: center'>$total</td>
																	<td style='background-color: $color'>$valor</td>
																</tr>
																";
																$datos .= "
																{'y': '$f_captura', '$encuesta': $total},";
																$cnt_calificacion ++;
															}													
															$tabla .="</table>";
															
															$resultado_final = round(($total/$tot_ini)*100,0);
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
															  		<div style='min-width: 100%' id='graph_$encuesta_id'></div>
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
// 														
												// //echo "<hr>";
												// $dia .= "
												// <table style='width: 100%' class='table table-bordered'>
													// <tr >
														// <th style='text-align: center'>Fecha</th>
														// <th style='text-align: center'>PHQ9</th>
														// <th style='text-align: center'>GAD7</th>
														// <th style='text-align: center'>TINITUS</th>
														// <th style='text-align: center'>Y-BOCS</th>
													// </tr>
												// ";
// 												
												// $sql = "SELECT * FROM tabla_temporal_$paciente_id ORDER BY f_captura asc";
												// $result_sql=ejecutar($sql); 
												// $cnt = 1;
												// $cnt_sql = mysqli_num_rows($result_sql);
// 												
											    // while($row_sql = mysqli_fetch_array($result_sql)){
											        // extract($row_sql);		
													// if ($cnt == 1) {
														// $PHQ9_ini = $PHQ9;
														// $GAD7_ini = $GAD7;
														// $TINITUS_ini = $TINITUS;
														// $CPFDL_ini = $CPFDL;	
													// }
// 
// 													
												 	// $color = PHQ9($PHQ9);
													// $color1 = GAD7($GAD7);
													// $color2 = TINITUS($TINITUS);
													// $color3 = CPFDL($CPFDL);
// 														
													// $dia .= "
														// <tr>
															// <td style='text-align: center'>$f_captura</td>
															// <td style='background: $color; text-align: center'>$PHQ9</td>
															// <td style='background: $color1; text-align: center'>$GAD7</td>
															// <td style='background: $color2; text-align: center'>$TINITUS</td>
															// <td style='background: $color3; text-align: center'>$CPFDL</td>
														// </tr>";											   
											       	// $cnt ++;									
												// }
// 		
												// if ($PHQ9 >=1 ) { $total_PHQ9 = round((1-($PHQ9/$PHQ9_ini))*100,0); }
												// if ($GAD7 >=1 ) { $total_GAD7 = round((1-($GAD7/$GAD7_ini))*100,0); }
												// if ($TINITUS >=1 ) { $total_TINITUS = round((1-($TINITUS/$TINITUS_ini))*100,0); }
												// if ($CPFDL >=1 ) { $total_CPFDL = round((1-($CPFDL/$CPFDL_ini))*100,0); }	
// 												
												// $dia .= "
													// <tr>
														// <td style='text-align: center'>Avance</td>
														// <td style='background: ".remision($total_PHQ9)."; text-align: center'>$total_PHQ9%</td>
														// <td style='background: ".remision($total_GAD7)."; text-align: center'>$total_GAD7%</td>
														// <td style='background: ".remision($total_TINITUS)."; text-align: center'>$total_TINITUS%</td>
														// <td style='background: ".remision($total_CPFDL)."; text-align: center'>$total_CPFDL%</td>
													// </tr>";	
// 												
												$dia .= "<hr>
																	<p>
						Adem&aacute;s del gr&aacute;fico de resultados, se puede calcular el porcentaje de reducci&oacute;n de s&iacute;ntomas (Una reducci&oacute;n de 50% de los s&iacute;ntomas se considera respuesta, y reducci&oacute;n mayor a 75% se le llama remisión)
					
					</p>";
												//echo $tabla_sql;
												//echo $paciente_id." ".$grafica;
												
												// $dia .="</div>
													  // <div class='col-md-12'>
													  	// <table style='width: 100%' class='table table-bordered'>
													  		// <tr>
													  			// <td style='background: #39F905; width: 20%; text-align: center'>Sin síntomas</td>
													  			// <td style='background: #A8F905; width: 20%; text-align: center'>Leve</td>
													  			// <td style='background: #EAF905; width: 20%; text-align: center'>Moderado</td>
													  			// <td style='background: #F9B605; width: 20%; text-align: center'>Moderadamente severo</td>
													  			// <td style='background: #F91B05; width: 20%; text-align: center'>Grave</td>
													  		// </tr>													  														  														  		
													  	// </table>
													  // </div>
													// </div>				";
												
												
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
																</tr>";	
												    while($row_sem2 = mysqli_fetch_array($result_sem2)){
												        extract($row_sem2);	
														
												        
												        if ($f_ini <= $hoy) {
															$f_estatus = "Vencido";
															$class = "class='info'";
														} else {
															$f_estatus = "Pendiente";
															$class = "class='success'";
														}
														
												        $f_ini = strftime("%e-%b-%Y",strtotime($f_ini));
												        
												        $dia .= "<tr>
																	<th>$f_ini</th>
																	<th>$h_ini</th>
																	<th>$h_fin</th>
																	<th $class >$f_estatus</th>
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
			                                                    <a role='button' data-toggle='collapse' data-parent='#accordion_1' href='#collapseSesion' aria-expanded='true' aria-controls='collapseSesion'>
			                                                        Historico de Sesiones
			                                                    </a>
			                                                </h4>
			                                            </div>
			                                            <div id='collapseSesion' class='panel-collapse collapse' role='tabpanel' aria-labelledby='headingSesion'>
			                                                <div class='panel-body'>";
                                                
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
													protocolo_terapia.prot_terapia
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
										        
										        //echo $sql_table."<hr>";
										              
												$result_sem2=ejecutar($sql_table); 
												
												$cnt = mysqli_num_rows($result_sem2);
												//echo $cnt." xx<hr>";
												$cnt_a = 1;
												if ($cnt <> 0) {
													$dia .= "<table class='table table-bordered table-striped table-hover dataTable '>
																<tr>
																	<th>Sesión</th>
																	<th>Aplico</th>
																	<th>Terapia</th>
																	<th>Fecha</th>
																	<th>Hora</th>
																	<th>Umbral</th>
																	<th>Observaciones</th>
																</tr>";	
												    while($row_sem2 = mysqli_fetch_array($result_sem2)){
												        extract($row_sem2);	  
												        $f_captura = strftime("%e-%b-%Y",strtotime($f_captura));
												        $dia .= "<tr>
																	<th>$cnt_a</th>
																	<th>$nombre</th>
																	<th>$prot_terapia</th>
																	<th>$f_captura</th>
																	<th>$h_captura</th>
																	<th>$umbral</th>
																	<th>$observaciones</th>
																</tr>";
					        							$cnt_a ++;
													}
													$dia .= "</table>";	                                                 
												}                 
						                       $dia .= "		</div>
											                </div>
			                                            </div>
			                                        </div>
			                                    </div>			        
												";	        
										        									        
										        if ($funcion == 'ADMINISTRADOR' || $funcion == 'SISTEMAS' || $funcion == 'TECNICO') {
										         $dia .= "<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
										         <a class='btn bg-$body waves-effect'href='../protocolo/protocolo.php?paciente_id=$paciente_id' role='button'>Iniciar Protocolo</a></div>";										
													
												}	
												echo $dia;

												// $drop = "DROP TABLE IF EXISTS tabla_temporal_$paciente_id";
												// $result = ejecutar($drop);													

		                                	?>
												
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
          
<?php	include($ruta.'footer2.php');	?>			