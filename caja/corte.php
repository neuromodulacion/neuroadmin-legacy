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
$titulo ="Corte";

if ($fechaInput =="") {
	$fechaInput = $hoy;
}

function OptieneMesCorto($mes){

		if ($mes == 1  || $mes == '1' || $mes == '01') { $xmes = 'Ene'; }
		if ($mes == 2  || $mes == '2' || $mes == '02') { $xmes = 'Feb'; }	
		if ($mes == 3  || $mes == '3' || $mes == '03') { $xmes = 'Mar'; }	
		if ($mes == 4  || $mes == '4' || $mes == '04') { $xmes = 'Abr'; }	
		if ($mes == 5  || $mes == '5' || $mes == '05') { $xmes = 'May'; }	
		if ($mes == 6  || $mes == '6' || $mes == '06') { $xmes = 'Jun'; }	
		if ($mes == 7  || $mes == '7' || $mes == '07') { $xmes = 'Jul'; }	
		if ($mes == 8  || $mes == '8' || $mes == '08') { $xmes = 'Ago'; }	
		if ($mes == 9  || $mes == '9' || $mes == '09') { $xmes = 'Sep'; }	
		if ($mes == 10 || $mes == '10' ){ $xmes = 'Oct'; }	
		if ($mes == 11 || $mes == '11' ){ $xmes = 'Nov'; }	
		if ($mes == 12 || $mes == '12' ){ $xmes = 'Dic'; }  

	return $xmes;     	

} 

function OptieneMesLargo($mes){

 		if ($mes == 1  || $mes == '1' || $mes == '01') { $xmes = 'Enero'; }
		if ($mes == 2  || $mes == '2' || $mes == '02') { $xmes = 'Febrero'; }	
		if ($mes == 3  || $mes == '3' || $mes == '03') { $xmes = 'Marzo'; }	
		if ($mes == 4  || $mes == '4' || $mes == '04') { $xmes = 'Abril'; }	
		if ($mes == 5  || $mes == '5' || $mes == '05') { $xmes = 'Mayo'; }	
		if ($mes == 6  || $mes == '6' || $mes == '06') { $xmes = 'Junio'; }	
		if ($mes == 7  || $mes == '7' || $mes == '07') { $xmes = 'Julio'; }	
		if ($mes == 8  || $mes == '8' || $mes == '08') { $xmes = 'Agosto'; }	
		if ($mes == 9  || $mes == '9' || $mes == '09') { $xmes = 'Septiembre'; }	
		if ($mes == 10 || $mes == '10' ){ $xmes = 'Octubre'; }	
		if ($mes == 11 || $mes == '11' ){ $xmes = 'Noviembre'; }	
		if ($mes == 12 || $mes == '12' ){ $xmes = 'Diciembre'; }  

	return $xmes;     	

}  


$mes_sel = date('m', strtotime($fechaInput));
$anio_sel = date('Y', strtotime($fechaInput));


$date_past = date("Y-m-d",strtotime('-7 day'));

//$usuario_id = 127;
//include('fun_protocolo.php');
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
                <h2>CORTE</h2>
            </div>
            
<!-- // ************** Contenido ************** // -->
            <!-- CKEditor -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div style="height: 95%"  class="header">
                        	<h1 align="center">Corte</h1> 
                        	<hr>
                        	<div align="right">
                        		<form action="corte.php" method="post">
                        			<?php // echo $fechaInput; ?>
                        			<input id="fechaInput" name="fechaInput" style="width: 180px" align="center" type="date" class="form-control" value="<?php echo $fechaInput; ?>"/>
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
							<?php
							// print_r($_SESSION);
							//$usuario_id = 127;
							//echo $hoy."<hr>".$date_past."<hr>";
							    $sql_medico = "
									SELECT
										admin.usuario_id, 
										admin.saldo
									FROM
										admin
									WHERE
										admin.usuario_id = $usuario_id
							    ";
								// echo $sql_medico."<hr>";
							    $result_medico=ejecutar($sql_medico); 
							
							    $row_medico = mysqli_fetch_array($result_medico);
								extract($row_medico);
								
								?>  
								<h1>Saldo en Fondo: $<?php echo number_format($saldo); ?></h1> 
								<h3>Movimientos de los ultimos 7 días:</h3>  <hr>
								<div class="row">
								  	<div class="col-md-12">
								  		<table  class="table table-bordered">
								  			<tr>
								  				<th colspan="4" align="center"><h2 align="center"><B>Cobros</B></h2></th>
								  			</tr>								  			
								  			<tr>
								  				<th style="text-align: center" >Fecha</th>
								  				<th style="text-align: center" >Ticket</th>
								  				<th style="text-align: center" >Solicita Factura</th>								  				
								  				<th style="text-align: center" >Paciente</th>
								  				<th style="text-align: center" >Forma de pago</th>
								  				<th style="text-align: center" >Tipo</th>
								  				<th style="text-align: center" >Importe</th>
								  			</tr>
								  			<?php
								  			$sql_cob = "
												SELECT
													cobros.cobros_id,
													cobros.usuario_id,
													cobros.tipo,
													cobros.doctor,
													cobros.protocolo_ter_id,
													cobros.f_pago,
													cobros.importe,
													cobros.f_captura,
													cobros.h_captura,
													cobros.otros,
													cobros.paciente_id,
													(
													SELECT
														CONCAT( pacientes.paciente, ' ', pacientes.apaterno, ' ', pacientes.amaterno ) AS paciente 
													FROM
														pacientes 
													WHERE
														pacientes.paciente_id = cobros.paciente_id 
													) AS paciente,	
													cobros.empresa_id,
													cobros.paciente_cons_id,
													cobros.paciente_consulta,
													cobros.consulta,
													cobros.ticket,
													cobros.facturado,
													cobros.email,
													cobros.req_factura 
												FROM
													cobros
												WHERE
													cobros.usuario_id = $usuario_id
													and cobros.f_captura = '$fechaInput'
												ORDER BY cobros.f_captura desc
																			  			
								  			";
										     	//echo $sql_cob."<hr>";
										     	$result_cob=ejecutar($sql_cob); 
									    	while($row_cob = mysqli_fetch_array($result_cob)){
										    	extract($row_cob);	
										    	$f_captura = strftime("%e-%b-%Y",strtotime($f_captura));
									    		if ($paciente == '') {
													$paciente = $paciente_consulta;
													$paciente_id = '';
												} 
										    	?>
								  			<tr>
								  				<td style="text-align: center" ><?php echo $f_captura."<br>".$h_captura; ?></td> 
								  				<td>
								  					<a target="_blank" href="pdf_html.php?ticket=<?php echo $ticket; ?>" role="button"><?php echo $ticket; ?></a>
								  				</td> 
								  				<td><?php echo $req_factura; ?></td>								  				
								  				<td><?php echo $paciente_id." - ".$paciente; ?></td>
								  				<td><?php echo $f_pago; ?></td> 
								  				<td><?php echo $tipo; ?></td>
								  				<td align="right">$&nbsp;<?php echo number_format($importe); ?></td>
								  			</tr>													
													
											<?php } ?>

								  		</table>
								  		
								  	</div>
								  	<div class="col-md-12">
								  		
								  		<table class="table table-bordered">
								  			<tr>
								  				<th colspan="4" align="center"><h2 align="center"><B>Pagos</B></h2></th>
								  			</tr>								  			
								  			<tr>
								  				<th  style="text-align: center" >Fecha</th>
								  				<th style="text-align: center" >Forma de pago</th>
								  				<th style="text-align: center" >Tipo</th>
								  				<th style="text-align: center" >Concepto</th>
								  				<th style="text-align: center" >Importe</th>
								  			</tr>
								  			<?php
								  			$sql_cob = "
												SELECT
													pagos.pagos_id, 
													pagos.usuario_id, 
													pagos.f_captura, 
													pagos.h_captura, 
													pagos.importe, 
													pagos.tipo, 
													pagos.concepto, 
													pagos.f_pago, 
													pagos.terapeuta, 
													pagos.empresa_id
												FROM
													pagos
												WHERE
													pagos.usuario_id = $usuario_id
													and pagos.f_captura = '$fechaInput'
												ORDER BY pagos.f_captura desc
												;								  			
								  			";
										     	// echo $sql_cob."<hr>";
										     	$result_cob=ejecutar($sql_cob); 
										    	while($row_cob = mysqli_fetch_array($result_cob)){
										    	extract($row_cob);	
										    	$f_captura = strftime("%e-%b-%Y",strtotime($f_captura));
										    	?>
								  			<tr>
								  				<td><?php echo $f_captura."<br>".$h_captura; ?></td> 
								  				<td><?php echo $f_pago; ?></td> 
								  				<td><?php echo $tipo; ?></td>
								  				<td><?php echo $concepto; ?></td>
								  				<td align="right">$&nbsp;<?php echo number_format($importe); ?></td>
								  			</tr>													
													
											<?php } ?>
								  		</table>
	
								  	</div>
								  	<div class="col-md-12">
								  		
								  		<table style="width: 500px" class="table table-bordered">
								  			<tr>
								  				<th colspan="4" style="text-align: center" ><h2 style="text-align: center" ><B>Retiros</B></h2></th>
								  			</tr>								  			
								  			<tr>
								  				<th style="text-align: center" >Fecha</th>
								  				<th style="text-align: center" >Usuario Retira</th>
								  				<th style="text-align: center" >Importe</th>
								  			</tr>
								  			<?php
								  			$sql_cob = "
												SELECT
													retiros.retiros_id, 
													retiros.usuario_id, 
													retiros.usuario_id_retira, 
													retiros.f_captura, 
													retiros.h_captura, 
													retiros.importe, 
													admin.nombre, 
													retiros.empresa_id
												FROM
													retiros INNER JOIN admin ON retiros.usuario_id_retira = admin.usuario_id
												WHERE
													retiros.usuario_id = $usuario_id
												ORDER BY retiros.f_captura desc
												limit 15;								  			
								  			";
										     	// echo $sql_cob."<hr>";
										     	$result_cob=ejecutar($sql_cob); 
										    	while($row_cob = mysqli_fetch_array($result_cob)){
										    	extract($row_cob);	
										    	//$f_captura = date("d-m-Y",strtotime($f_captura));
												$f_captura = strftime("%e-%b-%Y",strtotime($f_captura));
										    	?>
								  			<tr>
								  				<td style="text-align: center" ><?php echo $f_captura."<br>".$h_captura; ?></td> 
								  				<td><?php echo $nombre; ?></td> 
								  				<td align="right">$&nbsp;<?php echo number_format($importe); ?></td>
								  			</tr>													
													
											<?php } ?>
								  		</table>
	
								  	</div>
								  	
							  	
								  									  		
								  		<div align="center"  class="col-md-12">
								  			<hr>
								  			<button type="button" class="btn bg-<?php echo $body; ?> waves-effect m-r-20" data-toggle="modal" data-target="#retiroModal">Retirar</button>
								            <div class="modal fade" id="retiroModal" tabindex="-1" role="dialog">
								                <div class="modal-dialog" role="document">
							                    	<form id="retirar_fondo" method="POST"  >								                	
									                    <div class="modal-content">
									                        <div class="modal-header">
									                            <h4 class="modal-title" id="defaultModalLabel">Retiro de Efectivo</h4>
									                        </div>
									                        <div id="contenido" class="modal-body">
									                        	<h3>Saldo en Caja: $<?php echo number_format($saldo); ?></h3>
											                    <div class="input-group">
											                        <span class="input-group-addon">
											                            <i class="material-icons">attach_money</i>
											                        </span> 
											                        <div class="form-line">
											                            <input type="number" class="form-control" id="importe1" name="importe" placeholder="Saldo a Retirar" value="" required >
											                        </div>
											                    </div>								                        	
											                    <div class="input-group">
											                        <span class="input-group-addon">
											                            <i class="material-icons">person</i>
											                        </span> 
											                        <div class="form-line">
											                            <input type="email" class="form-control" id="usernamex1" name="usernamex" placeholder="Correo electronico" value="" required >
											                        </div>
											                    </div>
											                    <div class="input-group">
											                        <span class="input-group-addon">
											                            <i class="material-icons">lock</i>
											                        </span>
											                        <div class="form-line">
											                            <input type="password" class="form-control" id="passwordx1" name="passwordx" placeholder="Contraseña" value="" autocomplete="off" required>
											                        </div>
											                    </div>
									                        </div>
									                        <div class="modal-footer">
									                            <button id="retira" type="button" class="btn btn-link waves-effect">RETIRAR</button>
									                            <button id="submit_test" type="submit" style="display: none" class="btn btn-link waves-effect">RETIRAR</button>
														        <script>
															        $('#retira').click(function(){          
															        	//alert("test"); 
																	        var emptyFields = $('#retirar_fondo').find('input[required], select[required], textarea[required]').filter(function() {
																	            return this.value === '';
																	        });
																	        if (emptyFields.length > 0) {
																	            emptyFields.each(function() {
																	            $('#submit_test').click();
																	                //alert('El campo ' + this.name + ' está vacío.');
																	            });
																	        }else{ 				        	
																	        	var datastring = $('#retirar_fondo').serialize();
																	        	//alert(datastring);
															                	$('#contenido').html('');
																				$.ajax({
																                    url: 'guarda_retiro.php', 
																                    type: 'POST',
																                    data: datastring,
																                    cache: false,
																                    success:function(html){	  
																                    	//alert(html);                  	     
																		                $('#contenido').html(html); 
																		                $('#retira').hide();
																                    }
																            	});		                	
																        	}	        
															        
															        });  
													        	</script>
									        	
									                            <!-- <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CERRAR</button> -->
									                            <a id="retira_boton" class="btn btn-link waves-effect" href="corte.php" role="button">CERRAR</a>
									                        </div>
								                        </form>
								                    </div>
								                </div>
								            </div>	
								            <hr>		
								  		</div>	
									<div class="col-md-12">
								  		
								  		<table style="width: 500px" class="table table-bordered">
								  			<tr>
								  				<th colspan="4" style="text-align: center" ><h2 style="text-align: center" ><B>Abonos</B></h2></th>
								  			</tr>								  			
								  			<tr>
								  				<th style="text-align: center" >Fecha</th>
								  				<th style="text-align: center" >Usuario Abona</th>
								  				<th style="text-align: center" >Importe</th>
								  			</tr>
								  			<?php
								  			$sql_cob = "
												SELECT
													abonos.abono_id, 
													abonos.usuario_id, 
													abonos.usuario_id_abona, 
													abonos.f_captura, 
													abonos.h_captura, 
													abonos.importe, 
													admin.nombre, 
													admin.empresa_id
												FROM
													abonos
													INNER JOIN admin ON abonos.usuario_id_abona = admin.usuario_id
												WHERE
													abonos.usuario_id = $usuario_id
												ORDER BY abonos.f_captura desc
												limit 15;								  			
								  			";
										     	// echo $sql_cob."<hr>";
										     	$result_cob=ejecutar($sql_cob); 
										    	while($row_cob = mysqli_fetch_array($result_cob)){
										    	extract($row_cob);	
										    	//$f_captura = date("d-m-Y",strtotime($f_captura));
												$f_captura = strftime("%e-%b-%Y",strtotime($f_captura));
										    	?>
								  			<tr>
								  				<td style="text-align: center" ><?php echo $f_captura."<br>".$h_captura; ?></td> 
								  				<td><?php echo $nombre; ?></td> 
								  				<td align="right">$&nbsp;<?php echo number_format($importe); ?></td>
								  			</tr>													
													
											<?php } ?>
								  		</table>
	
								  	</div>
									<div align="center" class="col-md-12">
										
							  			<button type="button" class="btn bg-<?php echo $body; ?> waves-effect m-r-20" data-toggle="modal" data-target="#abonarModal">Abonar</button>
							            <div class="modal fade" id="abonarModal" tabindex="-1" role="dialog">
							                <div class="modal-dialog" role="document">
						                    	<form id="abonar_fondo" method="POST"  >								                	
								                    <div class="modal-content">
								                        <div class="modal-header">
								                            <h4 class="modal-title" id="defaultModalLabel">Abonar de Efectivo</h4>
								                        </div>
								                        <div id="contenido_abona" class="modal-body">
								                        	<h3>Saldo en Caja: $<?php echo number_format($saldo); ?></h3>
										                    <div class="input-group">
										                        <span class="input-group-addon">
										                            <i class="material-icons">attach_money</i>
										                        </span> 
										                        <div class="form-line">
										                            <input type="number" class="form-control" id="importe2" name="importe" placeholder="Saldo a Abonar" value="" required >
										                        </div>
										                    </div>								                        	
										                    <div class="input-group">
										                        <span class="input-group-addon">
										                            <i class="material-icons">person</i>
										                        </span> 
										                        <div class="form-line">
										                            <input type="email" class="form-control" id="usernamex2" name="usernamex" placeholder="Correo electronico" value="" required >
										                        </div>
										                    </div>
										                    <div class="input-group">
										                        <span class="input-group-addon">
										                            <i class="material-icons">lock</i>
										                        </span>
										                        <div class="form-line">
										                            <input type="password" class="form-control" id="passwordx2" name="passwordx" placeholder="Contraseña" value="" autocomplete="off" required>
										                        </div>
										                    </div>
								                        </div>
								                        <div class="modal-footer">
								                            <button id="abona" type="button" class="btn btn-link waves-effect">ABONAR</button>
								                            <button id="submit_abona" type="submit" style="display: none" class="btn btn-link waves-effect">ABONAR</button>
								                           
													        <script>
														        $('#abona').click(function(){          
														        	//alert("test"); 
																        var emptyFields = $('#abonar_fondo').find('input[required], select[required], textarea[required]').filter(function() {
																            return this.value === '';
																        });
																        if (emptyFields.length > 0) {
																            emptyFields.each(function() {
																            $('#submit_abona').click();
																                //alert('El campo ' + this.name + ' está vacío.');
																            });
																        }else{ 				        	
																        	var datastring = $('#abonar_fondo').serialize();
														                	$('#contenido_abona').html('');
																			$.ajax({
															                    url: 'guarda_abono.php', 
															                    type: 'POST',
															                    data: datastring,
															                    cache: false,
															                    success:function(html){	  
															                    	//alert('test');                  	     
																	                $('#contenido_abona').html(html); 
																	                $('#abona').hide();
															                    }
															            	});		                	
															        	}	        
														        
														        });  
												        	</script>
								                            <!-- <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CERRAR</button> -->
								                            <a class="btn btn-link waves-effect" href="corte.php" role="button">CERRAR</a>
								                        </div>									                        
							                        </form>
							                    </div>
							                </div>
							            </div>	
							  		</div>								  										  										  	
								</div>								                   	
        	                <!-- <div align="center" class="image">
			                    <img  src= "<?php echo $ruta.'images/menu.jpg'; ?>" style="max-width:100%;width:auto;height:auto;" />
			                </div> -->
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