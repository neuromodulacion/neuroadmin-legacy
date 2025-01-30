<?php 
$a = "";
$ruta = "../";
$titulo = "Pagos";

include ($ruta . 'header1.php');
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
	// $sql_medico = "
		// SELECT
			// costos_productos.producto, 
			// costos_productos.costos
		// FROM
			// costos_productos
		// WHERE
		// costos_productos.producto = 'terapias'
    // ";
	// $result_medico = ejecutar($sql_medico);
// 
	// $row_medico = mysqli_fetch_array($result_medico);
	// $cnt_medico = mysqli_num_rows($result_medico);
	// if ($cnt_medico >=1) {
		// extract($row_medico);
	// }
	
	//include('fun_protocolo.php');
?>

    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>PAGOS</h2>
				<?php echo $ubicacion_url."<br>"; 
				print_r($_SESSION); ?>
            </div>
           
<!-- // ************** Contenido ************** // -->
            <!-- CKEditor -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div style="height: 95%"  class="header">
							<button style="display: none" id="modal" type="button" class="btn btn-default waves-effect" data-toggle="modal" data-target="#smallModal">MODAL - SMALL SIZE</button>                        	
				            <!-- Small Size -->
				            <div class="modal fade" id="smallModal" tabindex="-1" role="dialog">
				                <div class="modal-dialog modal-sm" role="document">
				                    <div class="modal-content">
				                        <div class="modal-header">
				                            <h4 class="modal-title" id="smallModalLabel">Aviso</h4>
				                        </div>
				                        <div class="modal-body">
				                            <h2 style="color: green" align="center"><b>Pago Realizado</b></h2>
				                            <p style="color: green;font-size: 24px" align="center"><i class="material-icons">done</i><br>Ok</p>
				                        </div>
				                        <div class="modal-footer">
				                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CERRAR</button>
				                        </div>
				                    </div>
				                </div>
				            </div>                        	
                       	
				            <div class="body">
				                <form id="wizard_with_validation" method="POST" action="guarda_pagos.php" >
				                	
				        	<h1 align="center">Pago a Médicos y Proveedores</h1>
				        	<hr>
				            <h2 class="card-inside-title"><b>Seleciona el negocio</b></h2>
				            <hr>
				            <div class="demo-switch">
				                <div class="row clearfix">
				                    <div class="col-sm-6">
				                        <select id="negocio" name="negocio" class="form-control show-tick" required>
				                            <option value="">-- Selecciona Negocio--</option>
				                            <option value="<?php echo $emp_nombre; ?>"><?php echo $emp_nombre; ?></option>
											<?php extract($_SESSION);
				                                $sql_medico = "
													SELECT
														medicos.medico_id, 
														medicos.medico
													FROM
														medicos
													where
														medicos.empresa_id = $empresa_id
				                                ";
				                                $result_medico=ejecutar($sql_medico); 
				                                         
				                                    $saldo_t=0;
				                                while($row_medico = mysqli_fetch_array($result_medico)){ 
				                                	extract($row_medico);
				                                	?>		                                        
				                            <option value="<?php echo $medico; ?>"><?php echo $medico; ?></option>
				                            	<?php } ?>
				                        </select>
										<?php //echo $sql_medico."<br>";  ?>
				                        <script>
											$('#negocio').change(function(){
				                        		var negocio = $('#negocio').val();
				                        		var emp_nombre = '<?php echo $emp_nombre; ?>';
													
													//alert(negocio+" "+emp_nombre);
													if(negocio === emp_nombre){
														 $('#div_terapia').show();
														 $('#div_empresa').show();
															$('#varios_neg').prop('disabled', false);
														 $('#div_otros').hide();
															$('#varios_med').prop('disabled', true);
															$('#pago_terapia').show();
													}else{
														if(negocio === ''){
															 $('#div_terapia').hide();
														}else{
															 $('#div_terapia').show();
														}
														$('#pago_terapia').hide();
														$('#div_empresa').hide();
															$('#varios_neg').val('').change();
															$('#varios_neg').prop('disabled', true);
														$('#div_otros').show();
															$('#varios_med').val('').change();
															$('#varios_med').prop('disabled', false);
													}
				
												});
				                        </script>
				                    </div>                                
				                </div>
				            </div> 				                	
				                <!--<input name="costos" type="hidden" id="costos" value="<?php echo $costos; ?>" /> -->	
				                   	
				                	<fieldset>
				                        <div class="demo-radio-button">
				                        	
											<!-- style="display: none"  -->
				                            <div style="display: none" id="div_terapia" class="row">
				                            	<h3>Tipo de pago</h3>
				                            	<input style='height: 0px; width: 0px' name="val_tipo" type="text" id="val_tipo" value="" required/>
				                            	<div id="pago_terapia" class="col-md-3">
					                                <input name="tipo" type="radio" id="radio_1" value="Pago Medicos" class="radio-col-<?php echo $body; ?>" />
					                                <label for="radio_1">Pago Medicos</label>
										              	<script type='text/javascript'>
															$('#radio_1').change(function() {
																$('#importe').val('');
																$('#concepto').val('');
																$("#concepto").prop('required', false)
																$('#val_tipo').val('ok');
																$('#medico').show();
																$('#varios').hide();
																$('#otro').hide();
																$("#terapeuta").prop('required', true);
																	$('#terapeuta').prop('disabled', false);
																$("#varios_neg").prop('required', false);
																	$('#varios_neg').val('').change();
																	$('#varios_neg').prop('disabled', true);
																$("#varios_med").prop('required', false);
																	$('#varios_med').val('').change();
																	$('#varios_med').prop('disabled', true);
																$("#otros").prop('required', false);
																$('#contenido').html('');
															});
											            </script> 			                                	
												</div>
				                                <div id="pago_varios" class="col-md-3">
					                                <input name="tipo" type="radio" id="radio_2" value="Varios" class="radio-col-<?php echo $body; ?>" />
					                                <label for="radio_2">Varios</label>
										              	<script type='text/javascript'>
															$('#radio_2').change(function(){
											                    $('#importe').val('')
											                    $('#val_tipo').val('ok');
											                    $('#concepto').val('');
											                    $("#concepto").prop('required', true)
											                    $('#medico').hide();
											                    $('#varios').show();
											                    $('#otro').hide();
											                    $("#terapeuta").prop('required', false);
											                    	$('#terapeuta').prop('disabled', true);
					                                    		var negocio = $('#negocio').val();
					                                    		var emp_nombre = '<?php echo $emp_nombre; ?>';
																//alert(negocio+" "+emp_nombre);
																if(negocio === emp_nombre){
																	$("#varios_neg").prop('required', true);
																		$('#varios_neg').val('').change();
																		$('#varios_neg').prop('disabled', false);
																	$("#varios_med").prop('required', false);
																		$('#varios_med').val('').change();
																		$('#varios_med').prop('disabled', true);
																}else{
																	$("#varios_neg").prop('required', false);
																		$('#varios_neg').val('').change();
																		$('#varios_neg').prop('disabled', true);
																	$("#varios_med").prop('required', true);
																		$('#varios_med').val('').change();
																		$('#varios_med').prop('disabled', false);
																}
																
																
																$("#otros").prop('required', false);
																$('#contenido').html('');
															});
											            </script> 
											 	</div>           
				                            	<div id="pago_otros" class="col-md-3">
					                                <input name="tipo" type="radio" id="radio_3" value="Otros" class="radio-col-<?php echo $body; ?>" />
					                                <label for="radio_3">Otros</label>
										              	<script type='text/javascript'>
															$('#radio_3').change(function() {
																$('#importe').val('')
																$('#val_tipo').val('ok');
																$('#concepto').val('');
																$("#concepto").prop('required', true)
																$('#medico').hide();
																$('#varios').hide();
																$('#otro').show();
																$("#terapeuta").prop('required', false);
																	$('#terapeuta').prop('disabled', true);
																$("#varios_neg").prop('required', false);
																	$('#varios_neg').prop('disabled', true);
																	$('#varios_neg').val('').change();
																$("#varios_med").prop('required', false);
																	$('#varios_med').prop('disabled', true);
																	$('#varios_med').val('').change();
																$("#otros").prop('required', true);
																$('#contenido').html('');
															});
											            </script>
									            </div>
									            <div class="col-md-3"></div>
				                        </div>
				                    </div> 
				                        <hr> <!-- style="display: none" -->
				                        <div style="display: none" id="medico" class="form-group form-float">
				                            <label class="form-label">Terapeuta*</label> 
				                            <select class='form-control show-tick'  id="terapeuta" name="terapeuta" required><!--  -->
				                                <option value="">-- Selecciona Terapeuta--</option>
												<?php 	
				                                    $sql_medico = "
													SELECT DISTINCT
														admin.usuario_id AS usuario_idx, 
														admin.nombre
													FROM
														admin
														INNER JOIN
														historico_sesion
														ON 
															admin.usuario_id = historico_sesion.usuario_id
													WHERE
														admin.estatus = 'Activo' AND
														admin.empresa_id = $empresa_id
				                                    ";
													//AND admin.empresa_id = $empresa_id
				                                    $result_medico=ejecutar($sql_medico); 
				                                        echo $cnt."<br>";      
				                                        $saldo_t=0;
				                                    while($row_medico = mysqli_fetch_array($result_medico)){ 
				                                    	extract($row_medico);
				                                    	?>		                                        
				                                <option value="<?php echo $usuario_idx; ?>"><?php echo $nombre; ?></option>
				                                	<?php } ?>
				
				                            </select>  
					                        <script>
												$('#terapeuta').change(function() {
													//alert('Test');
													var usuario_idx = $('#terapeuta').val();
													var datastring = 'usuario_idx=' + usuario_idx;
													//alert(datastring);
													$.ajax({
														url : 'fun_terapeutas.php',
														type : 'POST',
														data : datastring,
														cache : false,
														success : function(html) {
															//alert(html);
															$('#contenido').html(html);
														}
													});
				
												});
					                        </script>		                                    
														                                    
				                            <input type="hidden" name="protocolo_ter_id1" value="0" />              	
				                        </div>
				                       	
										<div id="contenido"></div>
										<!-- style="display: none" -->
				                    	<div  id="varios" style="display: none" class="form-group form-float">					
											<label class="form-label">Varios*</label> 
				                            <div id="div_empresa">
				                                <select id="varios_neg" name="varios_neg" class="form-control show-tick" required><!--  -->
				                                    <option value="">-- Selecciona Motivo--</option>
													<?php
														if ($funcion == 'SISTEMAS' || $funcion == 'ADMINISTRADOR') { 
															$tipo_m = "'negocio','todos'";
														} else {
															$tipo_m = "'todos'";
														}
														
													
					                                    $sql_medico = "
														SELECT
															egresos_menu.nombre, 
															egresos_menu.tipo, 
															egresos_menu.empresa_id
														FROM
															egresos_menu
														WHERE
															egresos_menu.tipo in($tipo_m)
															AND egresos_menu.empresa_id = $empresa_id
					                                    ";
					                                    $result_medico=ejecutar($sql_medico); 
					                                       // echo $sql_medico."<br>";      
					                                        $saldo_t=0;
					                                    while($row_medico = mysqli_fetch_array($result_medico)){ 
					                                    	extract($row_medico);
					                                    	?>		                                        
					                                <option value="<?php echo $nombre; ?>"><?php echo $nombre; ?></option>
					                                	<?php } ?>
				                                </select>
								              	<script type='text/javascript'>
													$('#varios_neg').change(function() {
														var concepto = $('#varios_neg').val();
														$('#concepto').val(concepto);
													});
									            </script>				                                
				                            </div>
				                            <div id="div_otros">
				                                <select id="varios_med" name="varios_med" class="form-control show-tick" required><!-- required -->
				                                    <option value="">-- Selecciona Motivo--</option>
													<?php
				
														$tipo_m = "'todos'";														
														
													
					                                    $sql_medico = "
														SELECT
															egresos_menu.nombre, 
															egresos_menu.tipo, 
															egresos_menu.empresa_id
														FROM
															egresos_menu
														WHERE
															egresos_menu.tipo in($tipo_m)
															AND egresos_menu.empresa_id = $empresa_id
					                                    ";
					                                    $result_medico=ejecutar($sql_medico); 
					                                       // echo $sql_medico."<br>";      
					                                        $saldo_t=0;
					                                    while($row_medico = mysqli_fetch_array($result_medico)){ 
					                                    	extract($row_medico);
					                                    	?>		                                        
					                                <option value="<?php echo $nombre; ?>"><?php echo $nombre; ?></option>
					                                	<?php } ?>
				                                </select>
								              	<script type='text/javascript'>
													$('#varios_med').change(function() {
														var concepto = $('#varios_med').val();
														$('#concepto').val(concepto);
													});
									            </script>				                                
				                            </div>
				                                                                             	
				                    </div>	<!-- style="display: none" -->
				                    <div style="display: none" id="otro" class="form-group form-float">
				                        <label class="form-label">Otros*</label>
				                        <div class="form-line">
				                       		
				                            <input type="otros" class="form-control" id="concepto" name="concepto" ><!-- required -->
				                            
				                        </div>
				                    </div>
				                    
				                    <div class="form-group form-float">
				                        <label class="form-label">Importe*</label>
				                        <div class="form-line">
				                            <input type="text" id="importe" name="importe" class="form-control" value="" required>
				                            
				                        </div>
				                    </div>	
				                    	<label class="form-label">Forma de pago</label> 
				                        <div class="demo-radio-button">	
				                        	<input style='height: 0px; width: 0px' name="val_pago" type="text" id="val_pago" value="" required/>		                            				                                
				                            <input name="f_pago" type="radio" id="radiox_2" value="Transferencia" class="radio-col-<?php echo $body; ?>" />
				                            <label for="radiox_2">Transferencia</label>
								              	<script type='text/javascript'>
													$('#radiox_2').change(function() {
														$('#val_pago').val('ok');
													});
									            </script>				                                
				                            <input name="f_pago" type="radio" id="radiox_3" value="Efectivo" class="radio-col-<?php echo $body; ?>" />
				                            <label for="radiox_3">Efectivo</label>
								              	<script type='text/javascript'>
													$('#radiox_3').change(function() {
														$('#val_pago').val('ok');
													});
									            </script>				                                
				                        </div>
				                        <hr>                                     
				                     <div class="row clearfix demo-button-sizes">
				                    	<div class="col-xs-6 col-sm-3 col-md-2 col-lg-2"> <!-- data-toggle="modal" data-target="#loadModal" -->
				                    		<button id="guarda_btn" type="submit" class="btn bg-green btn-block btn-lg waves-effect">GUARDAR</button>
				                    		<!-- <button type="button" class="btn btn-default waves-effect" data-toggle="modal" data-target="#loadModal">MODAL - SMALL SIZE</button> -->
								              	<script type='text/javascript'>
													$('#guarda_btn').change(function() {
														$('#guarda_btn').prop('disabled', true);
													});
									            </script>
									            <div class="modal fade" id="loadModal" tabindex="-1" role="dialog">
									                <div class="modal-dialog modal-sm" role="document">
									                    <div class="modal-content">
									                        <!-- <div class="modal-header">
									                            <h4 class="modal-title" id="smallModalLabel">Modal title</h4>
									                        </div> -->
									                        <div align="center" class="modal-body">
									                                <div class="preloader pl-size-xl pl-teal">
									                                    <div class="spinner-layer">
									                                        <div class="circle-clipper left">
									                                            <div class="circle"></div>
									                                        </div>
									                                        <div class="circle-clipper right">
									                                            <div class="circle"></div>
									                                        </div>
									                                    </div>
									                                </div>
									                                <h4>Generando...</h4>
									                        </div>
									                    </div>
									                </div>
									            </div>	                                		
					                		</div>
					            		</div>                                                                  		                            
				                    </fieldset>  
				                </form>
				            </div>                    	
                    	</div>
                	</div>
            	</div>
        	</div>         
        </div>
    </section>
    
    <?php if ($a == 1) { ?>	
	    <script>
			$(document).ready(function() {
				$('#modal').click();
			});
	    </script>
 	<?php } ?>   
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