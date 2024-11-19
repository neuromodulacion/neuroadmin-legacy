<?php

$ruta="../";

$hoy = date("Y-m-d");
$ahora = date("H:i:00"); 
$anio = date("Y");
$mes_ahora = date("m");
$mes = strftime("%B");
$dia = date("N");
$semana = date("W");
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

<?php  include($ruta.'header2.php'); ?>

    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>APLICAR PROTOCOLO</h2>
            </div>
            
<!-- // ************** Contenido ************** // -->
            <!-- CKEditor -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div style="height: 95%"  class="header">
                        	<h1 align="center">Protocolos</h1>
                        	<?php if ($paciente_id =='') {?>
								<h3>Paciente</h3>
								<div class="col-sm-10">
							  		<select name="paciente_id" class='form-control show-tick' id="paciente_id"  required>
								  		<option <?php if($paciente_id == ''){ echo "selected";} ?> value="">Seleccionar Paciente</option>
											<?php
												$sql_paciente = "
													SELECT
														pacientes.paciente_id as paciente_idx, 
														CONCAT( pacientes.paciente, ' ', pacientes.apaterno, ' ', pacientes.amaterno ) AS pacientex
													FROM
														pacientes
													WHERE
														pacientes.estatus not in('No interezado','Seguimiento')
													ORDER BY 2 asc";
												$result_paciente = ejecutar($sql_paciente);  
												$cnt_paciente = mysqli_num_rows($result_paciente);
												while($row_paciente = mysqli_fetch_array($result_paciente)){
									            extract($row_paciente); ?>
											<option <?php if($paciente_idx == $paciente_id){ echo "selected";} ?> value="<?php echo $paciente_idx; ?>" ><?php echo $paciente_idx.".- ".$pacientex; ?></option>
											<?php } ?>
									</select>
									
								</div> <hr>  
								<?php }else{ ?>
									<input type="hidden" id="paciente_id" name="paciente_id" value="<?php echo $paciente_id; ?>"/>
								<?php } 

								$tabla ="<table  class='table table-bordered table-striped table-hover dataTable'>
												<tr>
													<th>Id</th>
													<th>Paciente</th>
													<th>Protocolo</th>
													<th>Sesiones</th>
													<th>Total Aplicadas</th>
													<th>Observaciones</th>
												</tr>";
                        	
								 $sql = "
									SELECT
										pacientes.paciente_id,
										pacientes.paciente,
										pacientes.apaterno,
										pacientes.amaterno,
										sesiones.protocolo_ter_id,
										sesiones.sesiones,
										sesiones.total_sesion,
										protocolo_terapia.prot_terapia,
										terapias.estatus,
										terapias.observaciones,
										sesiones.sesion_id,
										sesiones.terapia_id 
									FROM
										pacientes
										INNER JOIN sesiones ON pacientes.paciente_id = sesiones.paciente_id
										INNER JOIN protocolo_terapia ON sesiones.protocolo_ter_id = protocolo_terapia.protocolo_ter_id
										INNER JOIN terapias ON sesiones.terapia_id = terapias.terapia_id 
										AND pacientes.paciente_id = terapias.paciente_id 
									WHERE
										pacientes.paciente_id = $paciente_id";                       	
							        //echo $sql."<hr>"; 
							        $result_protocolo=ejecutar($sql); 
															$total_sesiones = 0;
															$Gtotal = 0;					        
							        while($row_protocolo = mysqli_fetch_array($result_protocolo)){
							            extract($row_protocolo);
							            //print_r($row_protocolo);
							            $tabla .="
												<tr>
													<td style='text-align: center'>$paciente_id</td>
													<td>$paciente $apaterno $amaterno</td>
													<td>$prot_terapia</td>
													<td style='text-align: center'>$sesiones</td>
													<td style='text-align: center'>$total_sesion</td>
													<td>$observaciones</td>
												</tr>";
											        $total_sesiones = $total_sesiones+$sesiones;
											        $Gtotal = $Gtotal+$total_sesion;					            
						            }  
						            
						            $tabla .="
												<tr>
									   				<th style='text-align: center' colspan='3'>Total</th>
									   				<th style='text-align: center'>$total_sesion</th>
									   				<th style='text-align: center'>$Gtotal</th>
									   				<th colspan='2'></th>
												</tr>";
																            
						            $tabla .="</table>"; 
						            echo $tabla;   
?>
							<?php		
							$sql_metrica = "
								SELECT 
									metricas.x, 
									metricas.y, 
									metricas.umbral, 
									metricas.observaciones
								FROM
									metricas
								WHERE
									metricas.paciente_id = $paciente_id
							";		
							$result_metrica=ejecutar($sql_metrica);
							$row_metrica = mysqli_fetch_array($result_metrica);
					        extract($row_metrica);	 
					        //print_r($row_metrica)  						                              	
                        	?>
                        	<table class='table table-bordered table-striped table-hover dataTable '>
                        		<tr>
                        			<th style="text-align: center">X</th>
                        			<th style="text-align: center">Y</th>
                        			<th style="text-align: center">Umbral</th>
                        			<th>Observaciones</th>
                        		</tr>
                        		<tr>
                        			<td style="text-align: center"><?php echo $x; ?></td>
                        			<td style="text-align: center"><?php echo $y; ?></td>
                        			<td style="text-align: center"><?php echo $umbral; ?></td>
                        			<td><?php echo $observaciones; ?></td>
                        		</tr>
                        	</table><hr>

<?php					            
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
                                                
                                     $sql_table ="
                                     SELECT
										admin.usuario_id, 
										admin.nombre, 
										pacientes.paciente_id, 
										CONCAT(pacientes.paciente,' ',pacientes.apaterno,' ',pacientes.amaterno) as paciente, 
										historico_sesion.f_captura, 
										historico_sesion.h_captura, 
										historico_sesion.umbral, 
										historico_sesion.observaciones
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
									WHERE
										historico_sesion.paciente_id = $paciente_id"; 
										              
									$result_sem2=ejecutar($sql_table); 
									
									$cnt = mysqli_num_rows($result_sem2);
									//echo $cnt." xx<hr>";
									$cnt_a = 1;
									if ($cnt <> 0) {
										$dia .= "<table  class='table table-bordered'>
													<tr>
														<th>Sesión</th>
														<th>Aplico</th>
														<th>Paciente</th>
														<th>Fecha</th>
														<th>Hora</th>
														<th>Umbral</th>
														<th>Observaciones</th>
													</tr>";	
									    while($row_sem2 = mysqli_fetch_array($result_sem2)){
									        extract($row_sem2);	  
									        
									        $dia .= "<tr>
														<th style='text-align: center'>$cnt_a</th>
														<th>$nombre</th>
														<th>$paciente</th>
														<th>$f_captura</th>
														<th>$h_captura</th>
														<th style='text-align: center'>$umbral</th>
														<th>$observaciones</th>
													</tr>";
		        							$cnt_a ++;
										}
										$dia .= "</table>";	                                                 
									}                 
			                       $dia .= "
								                </div>
                                            </div>
                                        </div>
                                    </div>			        
									";	   
									
									echo $dia;	
							?>
							

 							<button id="ini_protocolo"  name="ini_protocolo" type="button" class='btn bg-<?php echo $body; ?> waves-effect'>Iniciar Protocolo</button>
			                        <script>
			                            $('#ini_protocolo').click(function(){ 
			                            	//alert('Test'); 
			                                var protocolo_ter_id =  '<?php echo $protocolo_ter_id; ?>';
			                                var prot_terapia =  '<?php echo trim($prot_terapia); ?>';
			                                var paciente_id = $('#paciente_id').val();
			                                if (paciente_id !==''){
				                                $('#load').show();
				                                var sesion_id = '<?php echo $sesion_id; ?>';
				                                var terapia_id = '<?php echo $terapia_id; ?>';
												var total_sesion = '<?php echo $Gtotal+1; ?>';
												var paciente = '<?php echo $paciente.' '.$apaterno.' '.$amaterno; ?>';
				                                var datastring = 'protocolo_ter_id='+protocolo_ter_id+'&prot_terapia='+prot_terapia+'&paciente_id='+paciente_id
				                                +'&sesion_id='+sesion_id +'&terapia_id='+terapia_id +'&total_sesion='+total_sesion+'&paciente='+paciente;
				                                //alert(datastring);
			                                    $.ajax({
			                                        url: 'captura_protocolo.php',
			                                        type: 'POST',
			                                        data: datastring,
			                                        cache: false,
			                                        success:function(html){
			                                        	//alert('Se modifico correctemente');       
			                                            $('#contenido').html(html); 
			                                            $('#boton_cnt').show();
			                                            $('#ini_protocolo').hide();
			                                            $('#load').hide();
			                                            //$('#muestra_asegurado').click();
			                                        }
			                                	});
		                                	}else{
		                                		alert('Debes seleccionar el paciente');
		                                	}
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
				              	<div  id="contenido"></div> 
  
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