<?php
$ruta="../";
$title = 'ADMINISTRACIÓN';

$titulo ="Administracion";

include($ruta.'header1.php');

$date_past = date("Y-m-d",strtotime('-7 day'));
$ahora = date("d-m-Y");


if ($fechaInput =="") {
	$fechaInput = $anio."-".$mes_ahora;
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
                        		<form action="retiros_reporte.php" method="post">
                        			<?php // echo $fechaInput; ?>
									<div class="row">
									  <div class="col-md-6"></div>
									  <div class="col-md-3"><h2><b>Mes</b></h2></div>
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
								<h1>Fondos</h1> 
								<h3>Usuarios:</h3>  <hr>
								<div class="row">
								  	<div class="col-md-12">
								  		<table style="width: 70%" class="table table-bordered">
								  			<tr>
								  				<th colspan="4" align="center"><h2 align="center"><B>Cobro en efectivo <?php echo $ahora; ?></B></h2></th>
								  			</tr>								  			
								  			<tr>
								  				<th style="text-align: center" >Canal</th>
								  				<th style="text-align: center" >Forma pago</th>
								  				<th style="text-align: center" >Fondo</th>
								  			</tr>
								  			<?php
											    $sql_cob = "
												SELECT
													cobros.doctor,
													cobros.f_pago,
													sum(cobros.importe) as importe 
												FROM
													cobros 
												WHERE
													cobros.empresa_id = $empresa_id
													and cobros.f_pago = 'Efectivo'
													and month(cobros.f_captura) = $mes_sel
													and year(cobros.f_captura) = $anio_sel	
													GROUP BY 1,2
											    ";
												
									     	 	// echo $sql_cob."<hr>";
										     	$result_cob=ejecutar($sql_cob);
												$cnt_cob = mysqli_num_rows($result_cob);
												
												if ($cnt_cob <>0) {
	
											    	while($row_cob = mysqli_fetch_array($result_cob)){
											    	extract($row_cob);	

										    		?>
										  			<tr>
										  				<td><?php echo $doctor; ?></td> 
										  				<td><?php echo $f_pago; ?></td>
										  				<td>$&nbsp;<?php echo number_format($importe); ?></td>
										  			</tr>													
															
													<?php } 
												} else {  ?>
										  			<tr>
										  				<th style="text-align: center" colspan="3"><i>Sin Resultados</i></th> 
										  			</tr>													
													
												<?php } ?>
								  		</table>								

							</div>
								  	<div class="col-md-12">
								  		<table style="width: 70%" class="table table-bordered">
								  			<tr>
								  				<th colspan="4" align="center"><h2 align="center"><B>Retiros del Mes</B></h2></th>
								  			</tr>								  			
								  			<tr>
								  				<th style="text-align: center" >Usuario</th>
								  				<th style="text-align: center" >Nombre</th>
								  				<th style="text-align: center" >Importe</th>
								  			</tr>
								  			<?php
											    $sql_cob = "
												SELECT	
													usuario_id_retira,
													admin.nombre AS retiro,
													sum(retiros.importe) as importe
												FROM
													retiros
													INNER JOIN admin ON retiros.usuario_id_retira = admin.usuario_id
													INNER JOIN admin AS adminx ON retiros.usuario_id = adminx.usuario_id 
												WHERE
													retiros.empresa_id = $empresa_id
													and month(retiros.f_captura) = $mes_sel
													and year(retiros.f_captura) = $anio_sel	
													and admin.usuario_id = 11
													GROUP BY 1,2
											    ";
												
									     	 //echo $sql_cob."<hr>";
										     	$result_cob=ejecutar($sql_cob);
												$cnt_cob = mysqli_num_rows($result_cob);
												
												if ($cnt_cob <>0) {
	
											    	while($row_cob = mysqli_fetch_array($result_cob)){
											    	extract($row_cob);	

										    		?>
										  			<tr>
										  				<td><?php echo $usuario_id_retira; ?></td> 
										  				<td><?php echo $retiro; ?></td>
										  				<td>$&nbsp;<?php echo number_format($importe); ?></td>
										  			</tr>													
															
													<?php } 
												} else {  ?>
										  			<tr>
										  				<th style="text-align: center" colspan="3"><i>Sin Resultados</i></th> 
										  			</tr>													
													
												<?php } ?>
								  		</table>								

							</div>						  	
								  	<div class="col-md-12">
								  		
								  		<table style="width: 100%" class="table table-bordered">
								  			<tr>
								  				<th colspan="4" align="center"><h2 align="center"><B>Retiros</B></h2></th>
								  			</tr>								  			
								  			<tr>
								  				<th style="text-align: center" >Fecha</th>							  				
								  				<th style="text-align: center" >Usuario Retira +</th>
								  				<th style="text-align: center" >Usuario Entrega -</th>
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
													admin.nombre as retiro,
													adminx.nombre as usuario,
													retiros.empresa_id 
												FROM
													retiros
													INNER JOIN admin ON retiros.usuario_id_retira = admin.usuario_id
													INNER JOIN admin as adminx  ON retiros.usuario_id = adminx.usuario_id
												WHERE
													retiros.empresa_id = $empresa_id
													and month(retiros.f_captura) = $mes_sel
													and year(retiros.f_captura) = $anio_sel	
													and admin.usuario_id = 11											
												ORDER BY retiros.usuario_id_retira asc, retiros.f_captura desc
												;								  			
								  			";
										     	// echo $sql_cob."<hr>";
										     	$result_cob=ejecutar($sql_cob);
										    										    	
												$cnt_cob = mysqli_num_rows($result_cob);
												
												if ($cnt_cob <>0) {
											    																 
										    		while($row_cob = mysqli_fetch_array($result_cob)){
												    	extract($row_cob);	
												    	//$f_captura = date("d-m-Y",strtotime($f_captura));
														$f_captura = strftime("%e-%b-%Y",strtotime($f_captura));
												    	?>
											  			<tr>
											  				<td><?php echo $f_captura; ?></td> 	 
											  				<td><?php echo $retiro; ?></td>
											  				<td><?php echo $usuario; ?></td>
											  				<td align="right">$&nbsp;<?php echo number_format($importe); ?></td>
											  			</tr>													
													<?php } 
												
												} else {  ?>
										  			<tr>
										  				<th style="text-align: center" colspan="4"><i>Sin Resultados</i></th> 
										  			</tr>													
													
												<?php } ?>
													
								  		</table>
	
								  	</div>
								  	<?php /*
								  	
									<div class="col-md-12">
								  		<table style="width: 70%" class="table table-bordered">
								  			<tr>
								  				<th colspan="4" align="center"><h2 align="center"><B>Abonos del Mes</B></h2></th>
								  			</tr>								  			
								  			<tr>
								  				<th style="text-align: center" >Usuario</th>
								  				<th style="text-align: center" >Nombre</th>
								  				<th style="text-align: center" >Importe</th>
								  			</tr>
								  			<?php
											    $sql_cob = "
												SELECT	
													usuario_id_retira,
													admin.nombre AS retiro,
													sum(retiros.importe) as importe
												FROM
													retiros
													INNER JOIN admin ON retiros.usuario_id_retira = admin.usuario_id
													INNER JOIN admin AS adminx ON retiros.usuario_id = adminx.usuario_id 
												WHERE
													retiros.empresa_id = $empresa_id
													and month(retiros.f_captura) = $mes_sel
													and year(retiros.f_captura) = $anio_sel	
													GROUP BY 1,2
											    ";
												
									     	 //echo $sql_cob."<hr>";
										     	$result_cob=ejecutar($sql_cob);
												$cnt_cob = mysqli_num_rows($result_cob);
												
												if ($cnt_cob <>0) {
	
											    	while($row_cob = mysqli_fetch_array($result_cob)){
											    	extract($row_cob);	

										    		?>
										  			<tr>
										  				<td><?php echo $usuario_id_retira; ?></td> 
										  				<td><?php echo $retiro; ?></td>
										  				<td>$&nbsp;<?php echo number_format($importe); ?></td>
										  			</tr>													
															
													<?php } 
												} else {  ?>
										  			<tr>
										  				<th style="text-align: center" colspan="3"><i>Sin Resultados</i></th> 
										  			</tr>													
													
												<?php } ?>
								  		</table>								

										</div>								  	
								  									  		
								  		
										<div class="col-md-12">
								  		
								  		<table style="width: 70%"  class="table table-bordered">
								  			<tr>
								  				<th colspan="4" align="center"><h2 align="center"><B>Abonos</B></h2></th>
								  			</tr>								  			
								  			<tr>
								  				<th style="text-align: center" >Fecha</th>
								  				<th style="text-align: center" >Usuario Abona</th>
								  				<th style="text-align: center" >Usuario Recibe</th>
								  				
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
													admin.nombre as abona,
													admin2.nombre as usuario,
													admin.empresa_id 
												FROM
													abonos
													INNER JOIN admin ON abonos.usuario_id_abona = admin.usuario_id 
													INNER JOIN admin as admin2 ON abonos.usuario_id = admin2.usuario_id
												WHERE
													abonos.empresa_id = $empresa_id
													and month(abonos.f_captura) = $mes_sel
													and year(abonos.f_captura) = $anio_sel														
												ORDER BY abonos.usuario_id_abona asc, abonos.f_captura desc
												;								  			
								  			";
										     	 echo $sql_cob."<hr>";
										     	$result_cob=ejecutar($sql_cob); 
										    										    	
												$cnt_cob = mysqli_num_rows($result_cob);
												
												if ($cnt_cob <>0) {
																						     	
											    	while($row_cob = mysqli_fetch_array($result_cob)){
											    	extract($row_cob);	
											    	//$f_captura = date("d-m-Y",strtotime($f_captura));
													$f_captura = strftime("%e-%b-%Y",strtotime($f_captura));
											    	?>
											  			<tr>
											  				<td><?php echo $f_captura; ?></td> 
											  				<td><?php echo $abona; ?></td> 
											  				<td><?php echo $usuario; ?></td> 
											  				
											  				<td align="right">$&nbsp;<?php echo number_format($importe); ?></td>
											  			</tr>													
													<?php } 
												
												} else {  ?>
										  			<tr>
										  				<th style="text-align: center" colspan="4"><i>Sin Resultados</i></th> 
										  			</tr>													
													
												<?php } ?>
								  		</table>
	
								  	</div>	*/?>
								  									  										  	
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