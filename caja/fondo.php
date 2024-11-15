<?php

session_start();
error_reporting(7);
iconv_set_encoding('internal_encoding', 'utf-8'); 
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Monterrey');
setlocale(LC_TIME, 'es_ES.UTF-8');
$_SESSION['time']=mktime();

$ruta="../";
$title = 'BALANCE MENSUAL';

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
$titulo ="Retiros";

if ($fechaInput =="") {
	$fechaInput = $anio."-".$mes_ahora;
}


$mes_sel = date('m', strtotime($fechaInput));
$anio_sel = date('Y', strtotime($fechaInput));

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
									     	// echo $sql_cobro." hola<hr>";
											
									     	//$result=ejecutar($sql_cobro); 
											// echo " hola 1<hr>";

								    		$result=ejecutar($sql_cobro); 
									    // $row_cobro = mysqli_fetch_array($result);
									    while($row_cob = mysqli_fetch_array($result)){
											extract($row_cob);
											//print_r($row_cob);
											
											/*
											$cnt_cobro = mysql_num_rows($result_cobro);
											echo $result_cobro." hola 2<hr>";
											 /*
										// if ($cnt_cobro <>0) {												
									    	while($row_cob = mysqli_fetch_array($result_cobro)){
									    	extract($row_cob);	
											print_r($row_cob);
									    	//$f_captura = date("d-m-Y",strtotime($f_captura));
											// $f_captura = strftime("%e-%b-%Y",strtotime($f_captura));
											 * */
											 
									    	?>
									  			<tr>
									  				<td><?php echo $usuario_idx; ?></td> 
									  				<td><?php echo $nombrex; ?></td> 
									  				<td align="right">$&nbsp;<?php echo number_format($saldox); ?></td>
									  			</tr>														
											<?php /* } 
											} else {  ?>
									  			<tr>
									  				<th style="text-align: center" colspan="3"><i>Sin Resultados</i></th> 
									  			</tr>													
													
										<?php */ }  ?>
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

    <!-- Waves Effect Plugin Js -->
    <!-- Autosize Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/autosize/autosize.js"></script>

    <!-- Moment Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/momentjs/moment.js"></script>


<?php	include($ruta.'footer2.php');	?>