<?php
$ruta="../";
$titulo ="Retiros";


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
                <h2>FONDO ACTUAL</h2>
				<?php echo $ubicacion_url; ?>
            </div>
            
<!-- // ************** Contenido ************** // -->
            <!-- CKEditor -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div style="height: 95%"  class="header">                         	                       	
                        	<h1 align="center">Fondo Actual</h1> 
                    	</div>
						<div  align="center"  style="height: 95%;padding: 25px"   class="content">
							<div class="row">
							  	<div class="col-md-6">
									<?php
								    $sql_medico = "
										SELECT
											admin.usuario_id, 
											admin.saldo
										FROM
											admin
										WHERE
											admin.usuario_id = $usuario_id
											and admin.empresa_id = $empresa_id
								    ";
								    $result_medico=ejecutar($sql_medico); 
								    $row_medico = mysqli_fetch_array($result_medico);
									extract($row_medico);
									
									?>  
									<h1>Saldo en Fondo personal: $<?php echo number_format($saldo); ?></h1>                         								  		
							  		
							  		<table class="table table-bordered" >
							  			<tr>
							  				<th colspan="4" align="center"><h2 align="center"><B>Fondos</B></h2></th>
							  			</tr>								  			
							  			<tr>
							  				<th align="center">ID</th>
							  				<th align="center">Usuarios</th>
							  				<th align="center">Fondo Usuarios</th>
							  			</tr>
							  			<?php
							  			$sql_cobro = "
										SELECT
											admin.usuario_id as usuario_idx,
											admin.nombre as nombrex,
											admin.saldo as saldox,
											admin.estatus as estatusx,
											admin.funcion as funcionx 
										FROM
											admin 
										WHERE
											admin.funcion NOT IN ( 'MEDICO', 'TECNICO' ) 
											AND admin.estatus = 'Activo'
											AND empresa_id = $empresa_id;								  			
							  			";

								    		$result=ejecutar($sql_cobro); 
									    // $row_cobro = mysqli_fetch_array($result);
									    while($row_cob = mysqli_fetch_array($result)){
											extract($row_cob);
									    	?>
									  			<tr>
									  				<td><?php echo $usuario_idx; ?></td> 
									  				<td><?php echo $nombrex; ?></td> 
									  				<td align="right">$&nbsp;<?php echo number_format($saldox); ?></td>
									  			</tr>														
											<?php  }  ?>
						  			</table>	
							  	</div>
							</div>
                    	</div>
                        <div class="footer">                         	                       	
                        	<hr> 
                    	</div>                    	
                	</div>
            	</div>
            	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
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

    <!-- Autosize Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/autosize/autosize.js"></script>

    <!-- Moment Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/momentjs/moment.js"></script>

<?php	include($ruta.'footer2.php');	?>