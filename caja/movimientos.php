<?php session_start();
$ruta = "../";
$titulo = "Movimientos";

$date_past = date("Y-m-d", strtotime('-7 day'));
$ahora = date("d-m-Y");

include ($ruta . 'header1.php');

if ($fechaInput == "") {
	$fechaInput = $anio . "-" . $mes_ahora;
}

function OptieneMesCorto($mes) {

	if ($mes == 1 || $mes == '1' || $mes == '01') { $xmes = 'Ene';
	}
	if ($mes == 2 || $mes == '2' || $mes == '02') { $xmes = 'Feb';
	}
	if ($mes == 3 || $mes == '3' || $mes == '03') { $xmes = 'Mar';
	}
	if ($mes == 4 || $mes == '4' || $mes == '04') { $xmes = 'Abr';
	}
	if ($mes == 5 || $mes == '5' || $mes == '05') { $xmes = 'May';
	}
	if ($mes == 6 || $mes == '6' || $mes == '06') { $xmes = 'Jun';
	}
	if ($mes == 7 || $mes == '7' || $mes == '07') { $xmes = 'Jul';
	}
	if ($mes == 8 || $mes == '8' || $mes == '08') { $xmes = 'Ago';
	}
	if ($mes == 9 || $mes == '9' || $mes == '09') { $xmes = 'Sep';
	}
	if ($mes == 10 || $mes == '10') { $xmes = 'Oct';
	}
	if ($mes == 11 || $mes == '11') { $xmes = 'Nov';
	}
	if ($mes == 12 || $mes == '12') { $xmes = 'Dic';
	}

	return $xmes;

}

function OptieneMesLargo($mes) {

	if ($mes == 1 || $mes == '1' || $mes == '01') { $xmes = 'Enero';
	}
	if ($mes == 2 || $mes == '2' || $mes == '02') { $xmes = 'Febrero';
	}
	if ($mes == 3 || $mes == '3' || $mes == '03') { $xmes = 'Marzo';
	}
	if ($mes == 4 || $mes == '4' || $mes == '04') { $xmes = 'Abril';
	}
	if ($mes == 5 || $mes == '5' || $mes == '05') { $xmes = 'Mayo';
	}
	if ($mes == 6 || $mes == '6' || $mes == '06') { $xmes = 'Junio';
	}
	if ($mes == 7 || $mes == '7' || $mes == '07') { $xmes = 'Julio';
	}
	if ($mes == 8 || $mes == '8' || $mes == '08') { $xmes = 'Agosto';
	}
	if ($mes == 9 || $mes == '9' || $mes == '09') { $xmes = 'Septiembre';
	}
	if ($mes == 10 || $mes == '10') { $xmes = 'Octubre';
	}
	if ($mes == 11 || $mes == '11') { $xmes = 'Noviembre';
	}
	if ($mes == 12 || $mes == '12') { $xmes = 'Diciembre';
	}

	return $xmes;

}

if ($funcion == 'RECEPCION') {
	$fun_sel = 'AND admin.usuario_id ='.$usuario_id;
} else {
	$fun_sel = '';
}



$mes_sel = date('m', strtotime($fechaInput));
$anio_sel = date('Y', strtotime($fechaInput));
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

<?php
	include ($ruta . 'header2.php');
 ?>

<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>Movimientos</h2>
		</div>

		<!-- // ************** Contenido ************** // -->
		<!-- CKEditor -->
		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div style="height: 95%"  class="header">
						<h1 align="center">Movimientos</h1>
						<hr>
						<div align="right">
							<form action="movimientos.php" method="post">
								<?php  //echo $funcion; ?>
								<div class="row">
									<div class="col-md-6"></div>
									<div class="col-md-3">
										<h2><b>Mes</b></h2>
									</div>
									<div class="col-md-3">
										<input id="fechaInput" name="fechaInput" style="width: 180px" align="center" type="month" class="form-control" value="<?php echo $fechaInput; ?>"/>
									</div>
								</div>

							</form>
							<script>
								$(document).ready(function() {
									// Evento que detecta cambio en el valor del input de fecha
									$('#fechaInput').change(function() {
										// Envía el formulario en el que se encuentra este input
										$(this).closest('form').submit();
									});
								});
							</script>

						</div>
						<hr>
						<h1 style="text-align: center"><b>Movimiento diario en Efectivo</b></h1>
						<hr>
						<div class="row">
							<div class="col-md-12">
                                <div class="panel-group" id="accordion_1" role="tablist" aria-multiselectable="true">                         	 
						  			<?php
									    $sql_cob = "
										SELECT
											fechas.id,
											fechas.fecha
										FROM
											fechas
										WHERE
											YEAR(fechas.fecha) = '$anio_sel'
											AND MONTH(fechas.fecha) = '$mes_sel'
											AND fechas.fecha <= '$hoy'
									    ";									
							     	 // echo $sql_cob."<hr>";
								     	$result_cob=ejecutar($sql_cob);
										$cnt_cob = mysqli_num_rows($result_cob);
										
										if ($cnt_cob <>0) {
	
									    	while($row_cob = mysqli_fetch_array($result_cob)){
									    	extract($row_cob);	
												$date = date("d-m-Y", strtotime($fecha));
												$datex = strftime("%A %d de %B %Y", strtotime($fecha));
	
								    		?>
	                                    <div class="panel panel-col-<?php echo $body; ?>">
	                                        <div class="panel-heading" role="tab" id="headingTwo_1">
	                                            <h4 class="panel-title">
	                                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion_1" href="#collapse_<?php echo $id; ?>" aria-expanded="false"
	                                                   aria-controls="collapse<?php echo $id; ?>">
	                                                    <?php echo $datex." "; ?>
	                                                </a>
	                                            </h4>
	                                        </div>
	                                        <div id="collapse_<?php echo $id; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo $id; ?>">
	                                            <div class="panel-body">
	                                            	<table class="table table-bordered">
	                                            		<tr>
	                                            			<th style="text-align: center">Nombre</th>	                                            			
	                                            			<th style="text-align: center">Abonos</th>
	                                            			<th style="text-align: center">Cobros</th>
	                                            			<th style="text-align: center">Retiros</th>
	                                            			<th style="text-align: center">Pagos</th>
	                                            			<th style="text-align: center">Saldo final</th>
	                                            			<th style="text-align: center">Fondo</th>
	                                            		</tr>
	                                            	
												    <?php
												    	$abonost = 0; $importet = 0; $retirost = 0; $pagost = 0; $saldo_finalt = 0; $saldot = 0;
												    $sql_dia = "
													SELECT
														admin.usuario_id as id_us,
														admin.nombre,
														admin.funcion,
														admin.saldo,
														admin.estatus,
														admin.usuario_id,
														COALESCE ( cobros.importe, 0 ) AS importe,
														COALESCE ( abonos.importe, 0 ) AS abonos,
														COALESCE ( pagos.importe, 0 ) AS pagos,
														COALESCE ( retiros.importe, 0 ) AS retiros,
														(COALESCE ( cobros.importe, 0 ) + COALESCE ( abonos.importe, 0 )) - (COALESCE ( pagos.importe, 0 ) + COALESCE ( retiros.importe, 0 )) AS saldo_final 
													FROM
														admin
														LEFT JOIN ( SELECT usuario_id, SUM( importe ) AS importe FROM cobros WHERE f_captura = '$fecha' AND cobros.f_pago = 'Efectivo' GROUP BY usuario_id ) cobros ON admin.usuario_id = cobros.usuario_id
														LEFT JOIN ( SELECT usuario_id, SUM( importe ) AS importe FROM abonos WHERE f_captura = '$fecha' GROUP BY usuario_id ) abonos ON admin.usuario_id = abonos.usuario_id
														LEFT JOIN ( SELECT usuario_id, SUM( importe ) AS importe FROM pagos WHERE f_captura = '$fecha' AND pagos.f_pago = 'Efectivo' GROUP BY usuario_id ) pagos ON admin.usuario_id = pagos.usuario_id
														LEFT JOIN ( SELECT usuario_id, SUM( importe ) AS importe FROM retiros WHERE f_captura = '$fecha' GROUP BY usuario_id ) retiros ON admin.usuario_id = retiros.usuario_id 
													WHERE
														admin.estatus = 'Activo' 
														AND admin.funcion IN ( 'RECEPCION','ADMINISTRADOR'  ) 
														AND admin.empresa_id = $empresa_id
														$fun_sel
													ORDER BY admin.nombre asc
												    ";									
										     	 	//echo $sql_dia."<hr>";
											     	$result_dia=ejecutar($sql_dia);
													$cnt_dia = mysqli_num_rows($result_dia);
				
											    	while($row_dia = mysqli_fetch_array($result_dia)){
											    	extract($row_dia); 
											    	//print_r($row_dia); 
											    		
											    		$abonost = $abonost+$abonos; 
											    		$importet = $importet+$importe; 
											    		$retirost = $retirost+$retiros; 
											    		$pagost = $pagost+$pagos; 
											    		$saldo_finalt = $saldo_finalt+$saldo_final; 
											    		$saldot = $saldot+$saldo;
											    		
												    	if ($abonos == 0 && $importe == 0 && $retiros == 0 && $pagos == 0 && $saldo_final == 0 && $saldo == 0) {
															
														}else{
													    	?>
		                                            		<tr>
		                                            			<td><?php echo $nombre; ?></td>	                                      			
		                                            			<td style="text-align: right">
		                                            				<a id="m_<?php echo $id_us."_".$id; ?>">$ <?php echo number_format($abonos); ?></a>
	                				                        		<script>
																		$('#m_<?php echo $id_us."_".$id; ?>').click(function() {
														                	var fecha = '<?php echo $fecha; ?>';
																			var usuario_idx = '<?php echo $id_us; ?>'
														                	var tipo_consulta = 'abonos';
														                	var gral = 'unico';

														                    var datastring = 'fecha='+fecha+'&tipo_consulta='+tipo_consulta+'&usuario_idx='+usuario_idx+'&gral='+gral;
														                    //alert(datastring);
																			$('#contenido_modal').html('');
														                    $.ajax({
														                        url: 'consulta_movimientos.php',
														                        type: 'POST',
														                        data: datastring,
														                        cache: false,
														                        success:function(html){   
														                        	//alert(html);  
														                            $('#contenido_modal').html(html);
														                            $('#modal_grafica').click(); 
														                            
														                        }
														                	});																			
																		});
									                        		</script> 
	                                            				</td>
		                                            			<td style="text-align: right">
		                                            				<a id="mi_<?php echo $id_us."_".$id; ?>">$ <?php echo number_format($importe); ?></a>
	                				                        		<script>
																		$('#mi_<?php echo $id_us."_".$id; ?>').click(function() {
														                	var fecha = '<?php echo $fecha; ?>';
																			var usuario_idx = '<?php echo $id_us; ?>'
														                	var tipo_consulta = 'cobros';
														                	var gral = 'unico';

														                    var datastring = 'fecha='+fecha+'&tipo_consulta='+tipo_consulta+'&usuario_idx='+usuario_idx+'&gral='+gral;
														                    //alert(datastring);
																			$('#contenido_modal').html('');
														                    $.ajax({
														                        url: 'consulta_movimientos.php',
														                        type: 'POST',
														                        data: datastring,
														                        cache: false,
														                        success:function(html){   
														                        	//alert(html);  
														                            $('#contenido_modal').html(html);
														                            $('#modal_grafica').click(); 
														                            
														                        }
														                	});																			
																		});
									                        		</script> 		                                            				
		                                            			</td>
		                                            			<td style="text-align: right">
		                                            				<a id="mr_<?php echo $id_us."_".$id; ?>">$ <?php echo number_format($retiros); ?></a>
	                				                        		<script>
																		$('#mr_<?php echo $id_us."_".$id; ?>').click(function() {
														                	var fecha = '<?php echo $fecha; ?>';
																			var usuario_idx = '<?php echo $id_us; ?>'
														                	var tipo_consulta = 'retiros';
														                	var gral = 'unico';

														                    var datastring = 'fecha='+fecha+'&tipo_consulta='+tipo_consulta+'&usuario_idx='+usuario_idx+'&gral='+gral;
														                    //alert(datastring);
																			$('#contenido_modal').html('');
														                    $.ajax({
														                        url: 'consulta_movimientos.php',
														                        type: 'POST',
														                        data: datastring,
														                        cache: false,
														                        success:function(html){   
														                        	//alert(html);  
														                            $('#contenido_modal').html(html);
														                            $('#modal_grafica').click(); 
														                            
														                        }
														                	});																			
																		});
									                        		</script> 		                                            				
		                                            			</td>		                                            				

		                                            			<td style="text-align: right">
		                                            				<a id="mpx_<?php echo $id_us."_".$id; ?>">$ <?php echo number_format($pagos); ?></a>
	                				                        		<script>
																		$('#mpx_<?php echo $id_us."_".$id; ?>').click(function() {
														                	var fecha = '<?php echo $fecha; ?>';
																			var usuario_idx = '<?php echo $id_us; ?>'
														                	var tipo_consulta = 'pagos';
														                	var gral = 'unico';

														                    var datastring = 'fecha='+fecha+'&tipo_consulta='+tipo_consulta+'&usuario_idx='+usuario_idx+'&gral='+gral;
														                    //alert(datastring);
																			$('#contenido_modal').html('');
														                    $.ajax({
														                        url: 'consulta_movimientos.php',
														                        type: 'POST',
														                        data: datastring,
														                        cache: false,
														                        success:function(html){   
														                        	//alert(html);  
														                            $('#contenido_modal').html(html);
														                            $('#modal_grafica').click(); 
														                            
														                        }
														                	});																			
																		});
									                        		</script> 		                                            				
		                                            			</td>
		                                            			<td style="text-align: right">$ <?php echo number_format($saldo_final); ?></td>
		                                            			<td style="text-align: right">$ <?php echo number_format($saldo); ?></td>
		                                            		</tr>
															<?php 
		
														}													
													} ?> 
		                                            		<tr>
		                                            			<td>Total</td>	                                      			
		                                            			<td style="text-align: right">
		                                            				<a id="tm_<?php echo $id_us."_".$id; ?>">$ <?php echo number_format($abonost); ?></a>
	                				                        		<script>
																		$('#tm_<?php echo $id_us."_".$id; ?>').click(function() {
														                	var fecha = '<?php echo $fecha; ?>';
																			var usuario_idx = '<?php echo $id_us; ?>'
														                	var tipo_consulta = 'abonos';
														                	var gral = 'todos';

														                    var datastring = 'fecha='+fecha+'&tipo_consulta='+tipo_consulta+'&usuario_idx='+usuario_idx+'&gral='+gral;
														                    //alert(datastring);
																			$('#contenido_modal').html('');
														                    $.ajax({
														                        url: 'consulta_movimientos.php',
														                        type: 'POST',
														                        data: datastring,
														                        cache: false,
														                        success:function(html){   
														                        	//alert(html);  
														                            $('#contenido_modal').html(html);
														                            $('#modal_grafica').click(); 
														                            
														                        }
														                	});																			
																		});
									                        		</script> 
	                                            				</td>
		                                            			<td style="text-align: right">
		                                            				<a id="tmi_<?php echo $id_us."_".$id; ?>">$ <?php echo number_format($importet); ?></a>
	                				                        		<script>
																		$('#tmi_<?php echo $id_us."_".$id; ?>').click(function() {
														                	var fecha = '<?php echo $fecha; ?>';
																			var usuario_idx = '<?php echo $id_us; ?>'
														                	var tipo_consulta = 'cobros';
														                	var gral = 'todos';

														                    var datastring = 'fecha='+fecha+'&tipo_consulta='+tipo_consulta+'&usuario_idx='+usuario_idx+'&gral='+gral;
														                    //alert(datastring);
																			$('#contenido_modal').html('');
														                    $.ajax({
														                        url: 'consulta_movimientos.php',
														                        type: 'POST',
														                        data: datastring,
														                        cache: false,
														                        success:function(html){   
														                        	//alert(html);  
														                            $('#contenido_modal').html(html);
														                            $('#modal_grafica').click(); 
														                            
														                        }
														                	});																			
																		});
									                        		</script> 		                                            				
		                                            			</td>
		                                            			<td style="text-align: right">
		                                            				<a id="tmr_<?php echo $id_us."_".$id; ?>">$ <?php echo number_format($retirost); ?></a>
	                				                        		<script>
																		$('#tmr_<?php echo $id_us."_".$id; ?>').click(function() {
														                	var fecha = '<?php echo $fecha; ?>';
																			var usuario_idx = '<?php echo $id_us; ?>'
														                	var tipo_consulta = 'retiros';
														                	var gral = 'todos';

														                    var datastring = 'fecha='+fecha+'&tipo_consulta='+tipo_consulta+'&usuario_idx='+usuario_idx+'&gral='+gral;
														                    //alert(datastring);
																			$('#contenido_modal').html('');
														                    $.ajax({
														                        url: 'consulta_movimientos.php',
														                        type: 'POST',
														                        data: datastring,
														                        cache: false,
														                        success:function(html){   
														                        	//alert(html);  
														                            $('#contenido_modal').html(html);
														                            $('#modal_grafica').click(); 
														                            
														                        }
														                	});																			
																		});
									                        		</script> 		                                            				
		                                            			</td>		                                            				

		                                            			<td style="text-align: right">
		                                            				<a id="tmpx_<?php echo $id_us."_".$id; ?>">$ <?php echo number_format($pagost); ?></a>
	                				                        		<script>
																		$('#tmpx_<?php echo $id_us."_".$id; ?>').click(function() {
														                	var fecha = '<?php echo $fecha; ?>';
																			var usuario_idx = '<?php echo $id_us; ?>'
														                	var tipo_consulta = 'pagos';
														                	var gral = 'todos';

														                    var datastring = 'fecha='+fecha+'&tipo_consulta='+tipo_consulta+'&usuario_idx='+usuario_idx+'&gral='+gral;
														                    //alert(datastring);
																			$('#contenido_modal').html('');
														                    $.ajax({
														                        url: 'consulta_movimientos.php',
														                        type: 'POST',
														                        data: datastring,
														                        cache: false,
														                        success:function(html){   
														                        	//alert(html);  
														                            $('#contenido_modal').html(html);
														                            $('#modal_grafica').click(); 
														                            
														                        }
														                	});																			
																		});
									                        		</script> 		                                            				
		                                            			</td>
		                                            			<td style="text-align: right">$ <?php echo number_format($saldo_finalt); ?></td>
		                                            			<td style="text-align: right">$ <?php echo number_format($saldot); ?></td>
		                                            		</tr>													
													</table>
	                                            </div>
	                                        </div>
	                                    </div> 
										<?php } 
									} else {  ?>
							  				<h1><i>Sin Resultados</i></h1> 
									<?php } ?>                                                                    
                                </div>
							</div>
						</div>

<?php if ($funcion <> 'RECEPCION') { ?>
	
						<div class="panel-body">
	                                            	<table class="table table-bordered">
	                                            		<tr>
	                                            			<th style="text-align: center">Nombre</th>	                                            			
	                                            			<th style="text-align: center">Abonos</th>
	                                            			<th style="text-align: center">Cobros</th>
	                                            			<th style="text-align: center">Retiros</th>
	                                            			<th style="text-align: center">Pagos</th>
	                                            			<th style="text-align: center">Saldo final</th>
	                                            			<th style="text-align: center">Fondo</th>
	                                            		</tr>
	                                            	
												    <?php
												    
												    

												    	$abonost = 0; $importet = 0; $retirost = 0; $pagost = 0; $saldo_finalt = 0; $saldot = 0;
												    $sql_dia = "
													SELECT
														admin.usuario_id as id_us,
														admin.nombre,
														admin.funcion,
														admin.saldo,
														admin.estatus,
														admin.usuario_id,
														COALESCE ( cobros.importe, 0 ) AS importe,
														COALESCE ( abonos.importe, 0 ) AS abonos,
														COALESCE ( pagos.importe, 0 ) AS pagos,
														COALESCE ( retiros.importe, 0 ) AS retiros,
														(COALESCE ( cobros.importe, 0 ) + COALESCE ( abonos.importe, 0 )) - (COALESCE ( pagos.importe, 0 ) + COALESCE ( retiros.importe, 0 )) AS saldo_final 
													FROM
														admin
														LEFT JOIN ( SELECT usuario_id, SUM( importe ) AS importe FROM cobros  WHERE month(f_captura) = '$mes_sel' AND year(f_captura) = '$anio_sel' GROUP BY usuario_id ) cobros  ON admin.usuario_id = cobros.usuario_id
														LEFT JOIN ( SELECT usuario_id, SUM( importe ) AS importe FROM abonos  WHERE month(f_captura) = '$mes_sel' AND year(f_captura) = '$anio_sel' GROUP BY usuario_id ) abonos  ON admin.usuario_id = abonos.usuario_id
														LEFT JOIN ( SELECT usuario_id, SUM( importe ) AS importe FROM pagos   WHERE month(f_captura) = '$mes_sel' AND year(f_captura) = '$anio_sel' GROUP BY usuario_id ) pagos   ON admin.usuario_id = pagos.usuario_id
														LEFT JOIN ( SELECT usuario_id, SUM( importe ) AS importe FROM retiros WHERE month(f_captura) = '$mes_sel' AND year(f_captura) = '$anio_sel' GROUP BY usuario_id ) retiros ON admin.usuario_id = retiros.usuario_id 
													WHERE
														admin.estatus = 'Activo' 
														AND admin.funcion IN ( 'RECEPCION','ADMINISTRADOR' ) 
														AND admin.empresa_id = $empresa_id
														$fun_sel
													ORDER BY admin.nombre asc
												    ";									
										     	 	//echo $sql_dia."<hr>";
											     	$result_dia=ejecutar($sql_dia);
													$cnt_dia = mysqli_num_rows($result_dia);
													$id = 0;
													$id_us = "1000";
											    	while($row_dia = mysqli_fetch_array($result_dia)){
											    	extract($row_dia); 
											    	//print_r($row_dia); 
											    		
											    		$abonost = $abonost+$abonos; 
											    		$importet = $importet+$importe; 
											    		$retirost = $retirost+$retiros; 
											    		$pagost = $pagost+$pagos; 
											    		$saldo_finalt = $saldo_finalt+$saldo_final; 
											    		$saldot = $saldot+$saldo;
											    		
												    	if ($abonos == 0 && $importe == 0 && $retiros == 0 && $pagos == 0 && $saldo_final == 0 && $saldo == 0) {
															
														}else{
													    	?>
		                                            		<tr>
		                                            			<td><?php echo $nombre; ?></td>	                                      			
		                                            			<td style="text-align: right">
		                                            				<a id="m_<?php echo $id_us."_".$id; ?>">$ <?php echo number_format($abonos); ?></a>
	                				                        		<script>
																		$('#m_<?php echo $id_us."_".$id; ?>').click(function() {
														                	var fecha = '<?php echo $fecha; ?>';
														                	var mes = '<?php echo $mes_sel; ?>';
														                	var anio = '<?php echo $anio_sel; ?>'; 
																			var usuario_idx = '<?php echo $id_us; ?>'
														                	var tipo_consulta = 'abonos';
														                	var gral = 'unico_total';

														                    var datastring = 'fecha='+fecha+'&mes='+mes+'&anio='+anio+'&tipo_consulta='+tipo_consulta+'&usuario_idx='+usuario_idx+'&gral='+gral;
														                    //alert(datastring);
																			$('#contenido_modal').html('');
														                    $.ajax({
														                        url: 'consulta_movimientos.php',
														                        type: 'POST',
														                        data: datastring,
														                        cache: false,
														                        success:function(html){   
														                        	//alert(html);  
														                            $('#contenido_modal').html(html);
														                            $('#modal_grafica').click(); 
														                            
														                        }
														                	});																			
																		});
									                        		</script> 
	                                            				</td>
		                                            			<td style="text-align: right">
		                                            				<a id="mi_<?php echo $id_us."_".$id; ?>">$ <?php echo number_format($importe); ?></a>
	                				                        		<script>
																		$('#mi_<?php echo $id_us."_".$id; ?>').click(function() {
														                	var fecha = '<?php echo $fecha; ?>';
														                	var mes = '<?php echo $mes_sel; ?>';
														                	var anio = '<?php echo $anio_sel; ?>'; 														                	
																			var usuario_idx = '<?php echo $id_us; ?>'
														                	var tipo_consulta = 'cobros';
														                	var gral = 'unico_total';

														                    var datastring = 'fecha='+fecha+'&mes='+mes+'&anio='+anio+'&tipo_consulta='+tipo_consulta+'&usuario_idx='+usuario_idx+'&gral='+gral;
														                    //alert(datastring);
																			$('#contenido_modal').html('');
														                    $.ajax({
														                        url: 'consulta_movimientos.php',
														                        type: 'POST',
														                        data: datastring,
														                        cache: false,
														                        success:function(html){   
														                        	//alert(html);  
														                            $('#contenido_modal').html(html);
														                            $('#modal_grafica').click(); 
														                            
														                        }
														                	});																			
																		});
									                        		</script> 		                                            				
		                                            			</td>
		                                            			<td style="text-align: right">
		                                            				<a id="mr_<?php echo $id_us."_".$id; ?>">$ <?php echo number_format($retiros); ?></a>
	                				                        		<script>
																		$('#mr_<?php echo $id_us."_".$id; ?>').click(function() {
														                	var fecha = '<?php echo $fecha; ?>';
														                	var mes = '<?php echo $mes_sel; ?>';
														                	var anio = '<?php echo $anio_sel; ?>'; 														                	
																			var usuario_idx = '<?php echo $id_us; ?>'
														                	var tipo_consulta = 'retiros';
														                	var gral = 'unico_total';

														                    var datastring = 'fecha='+fecha+'&mes='+mes+'&anio='+anio+'&tipo_consulta='+tipo_consulta+'&usuario_idx='+usuario_idx+'&gral='+gral;
														                    //alert(datastring);
																			$('#contenido_modal').html('');
														                    $.ajax({
														                        url: 'consulta_movimientos.php',
														                        type: 'POST',
														                        data: datastring,
														                        cache: false,
														                        success:function(html){   
														                        	//alert(html);  
														                            $('#contenido_modal').html(html);
														                            $('#modal_grafica').click(); 
														                            
														                        }
														                	});																			
																		});
									                        		</script> 		                                            				
		                                            			</td>		                                            				

		                                            			<td style="text-align: right">
		                                            				<a id="mpx_<?php echo $id_us."_".$id; ?>">$ <?php echo number_format($pagos); ?></a>
	                				                        		<script>
																		$('#mpx_<?php echo $id_us."_".$id; ?>').click(function() {
														                	var fecha = '<?php echo $fecha; ?>';
														                	var mes = '<?php echo $mes_sel; ?>';
														                	var anio = '<?php echo $anio_sel; ?>'; 														                	
																			var usuario_idx = '<?php echo $id_us; ?>'
														                	var tipo_consulta = 'pagos';
														                	var gral = 'unico_total';

														                    var datastring = 'fecha='+fecha+'&mes='+mes+'&anio='+anio+'&tipo_consulta='+tipo_consulta+'&usuario_idx='+usuario_idx+'&gral='+gral;
														                    //alert(datastring);
																			$('#contenido_modal').html('');
														                    $.ajax({
														                        url: 'consulta_movimientos.php',
														                        type: 'POST',
														                        data: datastring,
														                        cache: false,
														                        success:function(html){   
														                        	//alert(html);  
														                            $('#contenido_modal').html(html);
														                            $('#modal_grafica').click(); 
														                            
														                        }
														                	});																			
																		});
									                        		</script> 		                                            				
		                                            			</td>
		                                            			<td style="text-align: right">$ <?php echo number_format($saldo_final); ?></td>
		                                            			<td style="text-align: right">$ <?php echo number_format($saldo); ?></td>
		                                            		</tr>
															<?php 
																$id++;
														}													
													} 
													$id++;
													?> 
		                                            		<tr>
		                                            			<td>Total</td>	                                      			
		                                            			<td style="text-align: right">
		                                            				<a id="tm_<?php echo $id_us."_".$id; ?>">$ <?php echo number_format($abonost); ?></a>
	                				                        		<script>
																		$('#tm_<?php echo $id_us."_".$id; ?>').click(function() {
														                	var fecha = '<?php echo $fecha; ?>';
														                	var mes = '<?php echo $mes_sel; ?>';
														                	var anio = '<?php echo $anio_sel; ?>'; 														                	
																			var usuario_idx = '<?php echo $id_us; ?>'
														                	var tipo_consulta = 'abonos';
														                	var gral = 'todos_total';

														                    var datastring = 'fecha='+fecha+'&mes='+mes+'&anio='+anio+'&tipo_consulta='+tipo_consulta+'&usuario_idx='+usuario_idx+'&gral='+gral;
														                    //alert(datastring);
																			$('#contenido_modal').html('');
														                    $.ajax({
														                        url: 'consulta_movimientos.php',
														                        type: 'POST',
														                        data: datastring,
														                        cache: false,
														                        success:function(html){   
														                        	//alert(html);  
														                            $('#contenido_modal').html(html);
														                            $('#modal_grafica').click(); 
														                            
														                        }
														                	});																			
																		});
									                        		</script> 
	                                            				</td>
		                                            			<td style="text-align: right">
		                                            				<a id="tmi_<?php echo $id_us."_".$id; ?>">$ <?php echo number_format($importet); ?></a>
	                				                        		<script>
																		$('#tmi_<?php echo $id_us."_".$id; ?>').click(function() {
														                	var fecha = '<?php echo $fecha; ?>';
														                	var mes = '<?php echo $mes_sel; ?>';
														                	var anio = '<?php echo $anio_sel; ?>'; 														                	
																			var usuario_idx = '<?php echo $id_us; ?>'
														                	var tipo_consulta = 'cobros';
														                	var gral = 'todos_total';

														                    var datastring = 'fecha='+fecha+'&mes='+mes+'&anio='+anio+'&tipo_consulta='+tipo_consulta+'&usuario_idx='+usuario_idx+'&gral='+gral;
														                    //alert(datastring);
																			$('#contenido_modal').html('');
														                    $.ajax({
														                        url: 'consulta_movimientos.php',
														                        type: 'POST',
														                        data: datastring,
														                        cache: false,
														                        success:function(html){   
														                        	//alert(html);  
														                            $('#contenido_modal').html(html);
														                            $('#modal_grafica').click(); 
														                            
														                        }
														                	});																			
																		});
									                        		</script> 		                                            				
		                                            			</td>
		                                            			<td style="text-align: right">
		                                            				<a id="tmr_<?php echo $id_us."_".$id; ?>">$ <?php echo number_format($retirost); ?></a>
	                				                        		<script>
																		$('#tmr_<?php echo $id_us."_".$id; ?>').click(function() {
														                	var fecha = '<?php echo $fecha; ?>';
														                	var mes = '<?php echo $mes_sel; ?>';
														                	var anio = '<?php echo $anio_sel; ?>'; 														                	
																			var usuario_idx = '<?php echo $id_us; ?>'
														                	var tipo_consulta = 'retiros';
														                	var gral = 'todos_total';

														                    var datastring = 'fecha='+fecha+'&mes='+mes+'&anio='+anio+'&tipo_consulta='+tipo_consulta+'&usuario_idx='+usuario_idx+'&gral='+gral;
														                    //alert(datastring);
																			$('#contenido_modal').html('');
														                    $.ajax({
														                        url: 'consulta_movimientos.php',
														                        type: 'POST',
														                        data: datastring,
														                        cache: false,
														                        success:function(html){   
														                        	//alert(html);  
														                            $('#contenido_modal').html(html);
														                            $('#modal_grafica').click(); 
														                            
														                        }
														                	});																			
																		});
									                        		</script> 		                                            				
		                                            			</td>		                                            				

		                                            			<td style="text-align: right">
		                                            				<a id="tmpx_<?php echo $id_us."_".$id; ?>">$ <?php echo number_format($pagost); ?></a>
	                				                        		<script>
																		$('#tmpx_<?php echo $id_us."_".$id; ?>').click(function() {
														                	var fecha = '<?php echo $fecha; ?>';
														                	var mes = '<?php echo $mes_sel; ?>';
														                	var anio = '<?php echo $anio_sel; ?>'; 														                	
																			var usuario_idx = '<?php echo $id_us; ?>'
														                	var tipo_consulta = 'pagos';
														                	var gral = 'todos_total';

														                    var datastring = 'fecha='+fecha+'&mes='+mes+'&anio='+anio+'&tipo_consulta='+tipo_consulta+'&usuario_idx='+usuario_idx+'&gral='+gral;
														                    //alert(datastring);
																			$('#contenido_modal').html('');
														                    $.ajax({
														                        url: 'consulta_movimientos.php',
														                        type: 'POST',
														                        data: datastring,
														                        cache: false,
														                        success:function(html){   
														                        	//alert(html);  
														                            $('#contenido_modal').html(html);
														                            $('#modal_grafica').click(); 
														                            
														                        }
														                	});																			
																		});
									                        		</script> 		                                            				
		                                            			</td>
		                                            			<td style="text-align: right">$ <?php echo number_format($saldo_finalt); ?></td>
		                                            			<td style="text-align: right">$ <?php echo number_format($saldot); ?></td>
		                                            		</tr>													
													</table>
	                                            </div>
<?php } ?>
						
						 <button style="display: none" id="modal_grafica" type="button" class="btn btn-default waves-effect m-r-20" data-toggle="modal" data-target="#largeModal">MODAL - LARGE SIZE</button>
						 <!-- Large Size  -->
			            <div class="modal fade" id="largeModal" tabindex="-1" role="dialog">
			                <div class="modal-dialog modal-lg" role="document">
			                    <div class="modal-content">
			                        <div class="modal-header">
			                            <h4 class="modal-title" id="largeModalLabel">Desglose de movimientos</h4>
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
				</div>
			</div>
		</div>
	</div>
</section>
<?php
	include ($ruta . 'footer1.php');
	?>

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

<?php
	include ($ruta . 'footer2.php');
?>