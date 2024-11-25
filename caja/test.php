<?php
$ruta="../";

$hoy = date("Y-m-d");
$ahora = date("H:i:00"); 
$anio = date("Y");
$mes_ahora = date("m");
$mes = strftime("%B");
$dia = date("N");
$semana = date("W");
$titulo ="Directorio";
$genera ="";

include($ruta.'header1.php');?>
    
   <!-- JQuery DataTable Css -->
    <link href="<?php echo $ruta; ?>plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

    <!-- 
    <!-- Bootstrap Material Datetime Picker Css -->
    <link href="<?php echo $ruta; ?>plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />

    <!-- Bootstrap DatePicker Css -->
    <link href="<?php echo $ruta; ?>plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />

    <!-- Wait Me Css -->
    <link href="<?php echo $ruta; ?>plugins/waitme/waitMe.css" rel="stylesheet" />

    <!-- Bootstrap Select Css -->
    <link href="<?php echo $ruta; ?>plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" /> 
  -->
<?php  include($ruta.'header2.php'); 
//print_r($_SESSION)
?>


    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>DIRECTORIO</h2>
                <?php // echo $ubicacion_url."<br>"; 
                //echo $ruta."proyecto_medico/menu.php"?>
            </div>
<!-- // ************** Contenido ************** // -->
            <!-- CKEditor -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div style="height: 95%"  class="header">
                        	<h1 align="center">Directorio</h1>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">								  			
										  			<tr>
										  				<th style="text-align: center; width: 100px" >Fecha</th>
										  				<th style="text-align: center; width: 100px" >Ticket</th>
										  				<th style="text-align: center; width: 60px" >Solicita Factura</th>
										  				<th style="text-align: center" >Paciente</th>
										  				<th style="text-align: center; width: 180px" >Usuario</th>
										  				<th style="text-align: center; width: 100px" >Forma de pago</th>
										  				<th style="text-align: center; width: 80px" >Tipo</th>
										  				<th style="text-align: center; width: 80px" >Importe</th>
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
																(
															SELECT DISTINCT
																CONCAT( paciente_consultorio.paciente, ' ', paciente_consultorio.apaterno, ' ', paciente_consultorio.amaterno ) AS paciente
															FROM
																paciente_consultorio 
															WHERE
																paciente_consultorio.paciente_cons_id = cobros.paciente_cons_id 
															) AS paciente_con,												
															cobros.empresa_id,
															admin.nombre, 
															cobros.req_factura, 
															cobros.ticket
														FROM
															cobros
															INNER JOIN admin ON cobros.usuario_id = admin.usuario_id 
														WHERE
															cobros.empresa_id = $empresa_id 
															AND cobros.tipo = 'Terapia'
															AND MONTH(f_captura) = $mes_sel
															AND YEAR(f_captura) = $anio_sel
														ORDER BY
															cobros.f_captura DESC								  			
										  			";
												     	// echo $sql_cob."<hr>";
												     	$result_cob=ejecutar($sql_cob); 
												    	
														$cnt_cob = mysqli_num_rows($result_cob);
														
														if ($cnt_cob <>0) {
													    	
													    	while($row_cob = mysqli_fetch_array($result_cob)){
													    	extract($row_cob);	
													    	$f_captura = strftime("%e-%b-%Y",strtotime($f_captura));
													    	
													    	if ($paciente == '') {
																$paciente = $paciente_con;
															} 
															
													    	
													    	
													    	?>
													  			<tr>
													  				<td  style="text-align: center" ><?php echo $f_captura." T ".$h_captura; ?></td>
													  				<td>
													  					<a target="_blank" href="pdf_html.php?ticket=<?php echo $ticket; ?>" role="button"><?php echo $ticket; ?></a>
													  				</td> 
													  				<td style="text-align: center" ><?php echo $req_factura; ?></td>
													  				<td><?php echo $paciente_id." - ".$paciente; ?></td>
													  				<td><?php echo $nombre; ?></td>
													  				<td><?php echo $f_pago; ?></td> 
													  				<td><?php echo $tipo; ?></td>
													  				<td align="right">$&nbsp;<?php echo number_format($importe); ?></td>
													  			</tr>													
															
															<?php } 
														} else {  ?>
												  			<tr>
												  				<th style="text-align: center" colspan="6"><i>Sin Resultados</i></th> 
												  			</tr>													
															
														<?php } ?>
		
										  		</table>
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




<?php	include($ruta.'footer2.php');	?>