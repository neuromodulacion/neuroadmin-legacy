<?php
$ruta="../";
$titulo ="Reporte";

$hoy = date("Y-m-d");
$ahora = date("H:i:00"); 
$anio = date("Y");
$mes_ahora = date("m");
$mes = strftime("%B");
$dia = date("N");
$semana = date("W");

include($ruta.'header1.php');
?>
    <link href="<?php echo $ruta; ?>plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
    <link href="<?php echo $ruta; ?>plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />
    <link href="<?php echo $ruta; ?>plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />
    <link href="<?php echo $ruta; ?>plugins/waitme/waitMe.css" rel="stylesheet" />
    <link href="<?php echo $ruta; ?>plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />   
    <script src="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.0/html2canvas.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.2/raphael-min.js"></script>
	<script src="../morris.js-master/morris.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/prettify/r224/prettify.min.js"></script>
	<script src="../morris.js-master/examples/lib/example.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prettify/r224/prettify.min.css">
	<link rel="stylesheet" href="../morris.js-master/morris.css">
<?php
include($ruta.'header2.php'); 
?>
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>Reporte de Medicos Referenciadores</h2>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div style="height: 95%" class="header">
                        	<h1 align="center">Reporte de Medicos Referenciadores</h1>
                        	<hr>
							<?php     
							$td_id = 1; 
							$time="SET lc_time_names = 'es_ES'";
							$result_sem=ejecutar($time);
							$sql ="
								SELECT DISTINCT YEAR(fechas.fecha) AS anio, MONTH(fechas.fecha) AS mes, DATE_FORMAT(fechas.fecha, '%b') AS mes_corto 
								FROM fechas 
								WHERE fechas.fecha BETWEEN DATE_SUB(CURDATE(), INTERVAL 13 MONTH) AND CURDATE() 
								ORDER BY anio ASC, mes ASC";
					        $result_sem=ejecutar($sql); 
							$th = "<th><p style='width: 120px'>Mes</p></th>";
							$td = "";
							$table = "<div class='table-responsive'>
							<table style='width: 100%; font-size: 12px' class='table table-bordered js-exportable'>";
							$cnt_total = "";	
							$cnt1 = 1;
							$sql1 = "
								SELECT
									admin.usuario_id as usuario_idx,
									admin.nombre,";
							$cnt = mysqli_num_rows($result_sem);
							$fecha_cnt = 0;
							$count_expressions = array();
						    while($row_sem = mysqli_fetch_array($result_sem)){
						        extract($row_sem);	
						        $fecha_cnt ++; 
						        $mesx ="mesx".$fecha_cnt;
						        $aniox ="aniox".$fecha_cnt;
						        $$aniox = $anio;
						        $$mesx = $mes;	
						        $th .= "<th style='background: #FFF; text-align: center'>$anio<br>$mes_corto</th>";
						        $count_expr = "
						            COUNT(
						                DISTINCT CASE WHEN MONTH(pps.primera_sesion) = $mes 
						                AND YEAR(pps.primera_sesion) = $anio 
						                THEN pps.paciente_id END
						            ) AS fecha$fecha_cnt";
						        $count_expressions[] = "
						            COUNT(
						                DISTINCT CASE WHEN MONTH(pps.primera_sesion) = $mes 
						                AND YEAR(pps.primera_sesion) = $anio 
						                THEN pps.paciente_id END
						            )";
						        if ($cnt == $cnt1) {
						            $sql1 .= $count_expr . " ";
						        } else {
						            $sql1 .= $count_expr . ",";
						        }
								$cnt1++;								
						    }
						    $th .= "<th style='background: #FFF; text-align: center'>Total</th>";
						    $total_expr = implode(" + ", $count_expressions);
						    $sql1 .= ", ($total_expr) AS total";
							$sql1 .=" 
								FROM admin
								LEFT JOIN (
								    SELECT
								        pac.usuario_id,
								        hs.paciente_id,
								        MIN(hs.f_captura) AS primera_sesion
								    FROM historico_sesion hs
								    INNER JOIN pacientes pac ON hs.paciente_id = pac.paciente_id
								    GROUP BY hs.paciente_id, pac.usuario_id
								) AS pps ON admin.usuario_id = pps.usuario_id
								WHERE
								    admin.funcion IN ('MEDICO', 'ADMINISTRADOR')
								    AND admin.estatus = 'Activo'
								    AND admin.empresa_id = $empresa_id
								    AND pps.paciente_id IS NOT NULL
								GROUP BY admin.usuario_id, admin.nombre
								ORDER BY total desc
									";
									//echo $sql1;
							$result_sem1=ejecutar($sql1); 
						    while($row_sem1 = mysqli_fetch_array($result_sem1)){
						        extract($row_sem1);
						        $td .= "<tr><td>$nombre</td>";
						        for ($i=1; $i < $cnt1 ; $i++) {
						        	$mesy = "mesx".$i;
						        	$anioy = "aniox".$i;
						        	$fechay = "fecha".$i;	
						        	if ($$fechay <> 0) {
										$class =" style='background: #D1F2EB'";
										$class_tx = "success";
									} else {
										$class =" style='background: #FFF'";
										$class_tx = "default";
									}
									$script_tx = "
		                        	<script>
										$('#boton_tdx_".$td_id."').click(function() {											
											var mes = '".$$mesy."'
											var anio = '".$$anioy."'
											var mes_corto = '".$mes_corto."' 
											var usuario_idx = '".$usuario_idx."'
						                	var tipo_consulta = 'diaria';
											var medico = '".$nombre."'
						                    var datastring = 'mes='+mes+'&mes_corto='+'$mes_corto'+'&anio='+anio+'&tipo_consulta='+tipo_consulta+'&usuario_idx='+usuario_idx+'&medico='+medico;
											$('#contenido_modal').html('');
						                    $.ajax({
						                        url: 'genera_referenciadores.php',
						                        type: 'POST',
						                        data: datastring,
						                        cache: false,
						                        success:function(html){   
						                            $('#contenido_modal').html(html);
						                            $('#modal_grafica').click(); 
						                        }
						                	});																				
										});
		                        	</script> 								
									";								
									$td .= "<td><button id='boton_tdx_".$td_id."' type='button' class='btn btn-".$class_tx." waves-effect'>".$$fechay."</button>".$script_tx."</td>";										
									$td_id++;	
								}
								if ($total <> 0) {
									$class =" style='background: #D1F2EB'";
									$class_tx = "success";
								} else {
									$class =" style='background: #FFF'";
									$class_tx = "default";
								}
								$script_tx = "
								<script>
									$('#boton_tdx_".$td_id."').click(function() {											
										var tipo_consulta = 'total_usuario';
										var usuario_idx = '".$usuario_idx."'
										var medico = '".$nombre."'
										var datastring = 'tipo_consulta='+tipo_consulta+'&usuario_idx='+usuario_idx+'&medico='+medico;
										$('#contenido_modal').html('');
										$.ajax({
											url: 'genera_referenciadores.php',
											type: 'POST',
											data: datastring,
											cache: false,
											success:function(html){   
												$('#contenido_modal').html(html);
												$('#modal_grafica').click(); 
											}
										});																				
									});
								</script> 								
								";								
								$td .= "<td><button id='boton_tdx_".$td_id."' type='button' class='btn btn-".$class_tx." waves-effect'>".$total."</button>".$script_tx."</td>";										
								$td_id++;
								$td .= "</tr>";
						    }
							$time="SET lc_time_names = 'es_ES'";
							$result_sem=ejecutar($time);
							$sql ="
								SELECT DISTINCT YEAR(fechas.fecha) AS anio, MONTH(fechas.fecha) AS mes, DATE_FORMAT(fechas.fecha, '%b') AS mes_corto 
								FROM fechas 
								WHERE fechas.fecha BETWEEN DATE_SUB(CURDATE(), INTERVAL 13 MONTH) AND CURDATE() 
								ORDER BY anio ASC, mes ASC";
					        $result_sem=ejecutar($sql); 
							$cnt1 = 1;
							$sql1 = "
									SELECT
									'Total' as totals,";
							$sql2 = "
									SELECT
									'TMS' as totals,";									
							$sql3 = "
									SELECT
									'tDCS' as totals,";									
							$cnt = mysqli_num_rows($result_sem);
							$fecha_cnt = 0;
							$count_expressions = array();
						    while($row_sem = mysqli_fetch_array($result_sem)){
						        extract($row_sem);	
						        $fecha_cnt ++; 
						        $mesx ="mesx".$fecha_cnt;
						        $aniox ="aniox".$fecha_cnt;
						        $$aniox = $anio;
						        $$mesx = $mes;	
								$count_expr = "
								COUNT(
									DISTINCT CASE WHEN MONTH(pps.primera_sesion) = $mes 
									AND YEAR(pps.primera_sesion) = $anio 
									THEN pps.paciente_id END
								) AS fecha$fecha_cnt";
								$count_expressions[] = "
								COUNT(
									DISTINCT CASE WHEN MONTH(pps.primera_sesion) = $mes 
									AND YEAR(pps.primera_sesion) = $anio 
									THEN pps.paciente_id END
								)";
								if ($cnt == $cnt1) {
									$sql1 .= $count_expr . " ";
									$sql2 .= $count_expr . " ";
									$sql3 .= $count_expr . " ";
								} else {
									$sql1 .= $count_expr . ",";
									$sql2 .= $count_expr . ",";
									$sql3 .= $count_expr . ",";
								}
								$cnt1++;								
						    }
						    //$th .= "<th style='background: #FFF; text-align: center'>Total</th>";
						    $total_expr = implode(" + ", $count_expressions);
						    $sql1 .= ", ($total_expr) AS total";
							$sql1 .=" 
								FROM (
								    SELECT
								        pac.usuario_id,
								        hs.paciente_id,
								        MIN(hs.f_captura) AS primera_sesion
								    FROM historico_sesion hs
								    INNER JOIN pacientes pac ON hs.paciente_id = pac.paciente_id
								    GROUP BY hs.paciente_id, pac.usuario_id
								) AS pps
								INNER JOIN admin ON pps.usuario_id = admin.usuario_id
								WHERE
								    admin.funcion IN ('MEDICO', 'ADMINISTRADOR')
								    AND admin.estatus = 'Activo'
								    AND admin.empresa_id = $empresa_id
								    AND pps.paciente_id IS NOT NULL
								";

						    $sql2 .= ", ($total_expr) AS total";
							$sql2 .=" 
								FROM
								(
								    SELECT
								        pac.usuario_id,
								        hs.paciente_id,
								        MIN(hs.f_captura) AS primera_sesion,
								        hs.protocolo_ter_id
								    FROM
								        historico_sesion hs
								        INNER JOIN pacientes pac ON hs.paciente_id = pac.paciente_id
								    GROUP BY
								        hs.paciente_id,
								        pac.usuario_id
								) AS pps
								INNER JOIN admin ON pps.usuario_id = admin.usuario_id
								INNER JOIN protocolo_terapia pt ON pps.protocolo_ter_id = pt.protocolo_ter_id
								WHERE
								    admin.funcion IN ('MEDICO', 'ADMINISTRADOR')
								    AND admin.estatus = 'Activo'
								    AND admin.empresa_id = $empresa_id
								    AND pps.paciente_id IS NOT NULL
								    AND pt.terapia = 'TMS'
								";

						    $sql3 .= ", ($total_expr) AS total";
							$sql3 .=" 
								FROM
								(
								    SELECT
								        pac.usuario_id,
								        hs.paciente_id,
								        MIN(hs.f_captura) AS primera_sesion,
								        hs.protocolo_ter_id
								    FROM
								        historico_sesion hs
								        INNER JOIN pacientes pac ON hs.paciente_id = pac.paciente_id
								    GROUP BY
								        hs.paciente_id,
								        pac.usuario_id
								) AS pps
								INNER JOIN admin ON pps.usuario_id = admin.usuario_id
								INNER JOIN protocolo_terapia pt ON pps.protocolo_ter_id = pt.protocolo_ter_id
								WHERE
								    admin.funcion IN ('MEDICO', 'ADMINISTRADOR')
								    AND admin.estatus = 'Activo'
								    AND admin.empresa_id = $empresa_id
								    AND pps.paciente_id IS NOT NULL
								    AND pt.terapia = 'tDCS'
								";

							
							// echo $sql1."<hr>";
							// echo $sql2."<hr>";
							// echo $sql3."<hr>";
							$test = $sql1." UNION ALL ".$sql2." UNION ALL ".$sql3;
							// echo $test."<hr>";
								
							// $result_sem1=ejecutar($sql1); 
							$result_sem1=ejecutar($test); 
						    while($row_sem1 = mysqli_fetch_array($result_sem1)){
						        extract($row_sem1);
						        $td .= "<tr><td><b>$totals</b></td>";
						        for ($i=1; $i < $cnt1 ; $i++) {
						        	$mesy = "mesx".$i;
						        	$anioy = "aniox".$i;
						        	$fechay = "fecha".$i;	
						        	$valor = $$fechay;
								    $anio = $$anioy;
								    $mes = $$mesy;
								    $total_pacientes = $valor;
								    $mes_corto_anio = date('M', mktime(0, 0, 0, $mes, 10)) . " - $anio";

	
									
									switch ($totals) {
										case 'Total':
										    $data_morris[] = [
										        'y' => $mes_corto_anio,
										        'pacientes' => $total_pacientes
										    ];											
											break;
										
										case 'TMS':
											$z =$i-1;
											$data_morris[$z]['tms'] = (int)$total_pacientes;											
											break;

										case 'tDCS':
											$z =$i-1;
											$data_morris[$z]['tdcs'] = (int)$total_pacientes;											
											break;
																				
									}
									

								    						        	
						        	if ($$fechay <> 0) {
										$class =" style='background: #D1F2EB'";
										$class_tx = "success";
									} else {
										$class =" style='background: #FFF'";
										$class_tx = "default";
									}
									$script_tx = "
		                        	<script>
										$('#boton_tdx_".$td_id."').click(function() {											
											var mes = '".$$mesy."'
											var anio = '".$$anioy."'
											var mes_corto = '".$mes_corto."' 
						                	var tipo_consulta = '".$totals."';
						                    var datastring = 'mes='+mes+'&mes_corto='+'$mes_corto'+'&anio='+anio+'&tipo_consulta='+tipo_consulta;
											$('#contenido_modal').html('');
						                    $.ajax({
						                        url: 'genera_referenciadores.php',
						                        type: 'POST',
						                        data: datastring,
						                        cache: false,
						                        success:function(html){   
						                            $('#contenido_modal').html(html);
						                            $('#modal_grafica').click(); 
						                        }
						                	});																				
										});
		                        	</script> 								
									";								
									$td .= "<td><button id='boton_tdx_".$td_id."' type='button' class='btn btn-".$class_tx." waves-effect'>".$$fechay."</button>".$script_tx."</td>";										
									$td_id++;	
								}
								if ($total <> 0) {
									$class =" style='background: #D1F2EB'";
									$class_tx = "success";
								} else {
									$class =" style='background: #FFF'";
									$class_tx = "default";
								}
								$script_tx = "
								<script>
									$('#boton_tdx_".$td_id."').click(function() {											
										var tipo_consulta = 'total_global';
										var tipo = '".$totals."';
										var datastring = 'tipo_consulta='+tipo_consulta+'&tipo='+tipo;
										$('#contenido_modal').html('');
										$.ajax({
											url: 'genera_referenciadores.php',
											type: 'POST',
											data: datastring,
											cache: false,
											success:function(html){   
												$('#contenido_modal').html(html);
												$('#modal_grafica').click(); 
											}
										});																				
									});
								</script> 								
								";								
								$td .= "<td><button id='boton_tdx_".$td_id."' type='button' class='btn btn-".$class_tx." waves-effect'>".$total."</button>".$script_tx."</td>";										
								$td_id++;
								$td .= "</tr>";
						    }    										
							$table .= "<tr>".$th."</tr>".$td."</table></div>";
							echo $table;
							
							echo "<hr>";
							//print_r($data_morris);
                        ?>

                        <!-- Gráfica -->
                        <div id="morris-area-chart"></div>
                        <script>
                        $(document).ready(function() {
                            new Morris.Line({
                                element: 'morris-area-chart',
                                data: <?php echo json_encode($data_morris); ?>,
                                xkey: 'y',
                                ykeys: ['pacientes', 'tms', 'tdcs'],
                                labels: ['Pacientes', 'TMS', 'tDCS'],
                                lineColors: ['#0b62a4', '#FF0000', '#00FF00'],
                                parseTime: false,
                                resize: true
                            });
                        });
                        </script>
                        <hr>
                        <table style="width: 230px">
                        	<td style="width: 70px; background-color: #0b62a4; color: #FFFFFF; text-align: center"><b>Pacientes</b></td>
                        	<td style="width: 10px"></td>
                        	<td style="width: 70px; background-color: #FF0000; color: #FFFFFF; text-align: center"><b>TMS</b></td>
                        	<td style="width: 10px"></td>
                        	<td style="width: 70px; background-color: #00FF00; color: #FFFFFF; text-align: center"><b>tDCS</b></td>
                        </table>
                    	</div>
                	</div>
            	</div>
        	</div>
    <table style='background: #D1F2EB'></table>
    <button style="display: none" id="modal_grafica" type="button" class="btn btn-default waves-effect m-r-20" data-toggle="modal" data-target="#largeModal">MODAL - LARGE SIZE</button>
    <div class="modal fade" id="largeModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="largeModalLabel">Detalle de Pacientes</h4>
                </div>
                <div id="contenido_modal" class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CERRAR</button>
                </div>
            </div>
        </div>
    </div> 
        </div>
    </section>
<?php	include($ruta.'footer1.php');	?>
    <script src="<?php echo $ruta; ?>plugins/momentjs/moment.js"></script>
    <script src="<?php echo $ruta; ?>plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
    <script src="<?php echo $ruta; ?>plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script src="<?php echo $ruta; ?>plugins/autosize/autosize.js"></script>
    <script src="<?php echo $ruta; ?>plugins/momentjs/moment.js"></script>
    <script src="<?php echo $ruta; ?>plugins/jquery-knob/jquery.knob.min.js"></script>
    <script src="<?php echo $ruta; ?>js/pages/charts/jquery-knob.js"></script>   
<?php	include($ruta.'footer2.php');	?>
