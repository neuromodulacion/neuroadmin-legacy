<?php
session_start();
error_reporting(E_ALL);
ini_set('default_charset', 'UTF-8');
//iconv_set_encoding('internal_encoding', 'utf-8'); funcion en desuso
header('Content-Type: text/html; charset=UTF-8');
//date_default_timezone_set('America/Monterrey');
date_default_timezone_set('America/Mazatlan');
setlocale(LC_TIME, 'es_ES.UTF-8');
$_SESSION['time']=time();

$ruta="../";
$title = 'INICIO';

extract($_SESSION);
extract($_POST);


$titulo ="Reporte";

$hoy = date("Y-m-d");
$ahora = date("H:i:00"); 
$anio = date("Y");
$mes_ahora = date("m");
$mes = strftime("%B");
$dia = date("N");
$semana = date("W");


if ($fechaInput =="") {
	$fechaInput = $anio."-".$mes_ahora;
	$mes_sel = $mes_ahora;
	$anio_sel = $anio;
}else{
	$mes_sel = date('m', strtotime($fechaInput));
	$anio_sel = date('Y', strtotime($fechaInput));	
}

include($ruta.'header1.php');
?>
    <link href="<?php echo $ruta; ?>plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
    
     <!-- Bootstrap Material Datetime Picker Css -->
    <link href="<?php echo $ruta; ?>plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />

    <!-- Bootstrap DatePicker Css -->
    <link href="<?php echo $ruta; ?>plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />

    <!-- Wait Me Css -->
    <link href="<?php echo $ruta; ?>plugins/waitme/waitMe.css" rel="stylesheet" />

    <!-- Bootstrap  Css -->
    <link href="<?php echo $ruta; ?>plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />   

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
//print_r($_SESSION);
?>

    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>REPORTE DE TÉCNICOS</h2>

            </div>
<!-- // ************** Contenido ************** // -->
            <!-- CKEditor -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div style="height: 95%"  class="header">
                        	<h1 align="center">Reporte de Técnicos</h1>
                        	<hr>
                        	<?php 
                        		// print_r($_POST);
								// echo $mes_sel."<br>";
								// echo $anio_sel."<br>";
                        	?>
                        	<div align="right">
                        		<form action="reporte_representante.php" method="post">
                        			<?php // echo $fechaInput; ?>
                        			<input id="fechaInput" name="fechaInput" style="width: 180px" align="center" type="month" class="form-control" value="<?php echo $fechaInput; ?>"/>
                        			<input id="us" name="us" align="center" type="hidden" class="form-control" value="<?php echo $us; ?>"/>
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
								$td_id = 1;                    	
								$sql ="
								SELECT
									fechas.id,
									fechas.fecha,
									fechas.semana,
									fechas.dia 
								FROM
									fechas 
								WHERE
									MONTH ( fechas.fecha ) = $mes_sel
									AND YEAR ( fechas.fecha ) = $anio_sel 
									AND fechas.fecha <= '$hoy'";
								//echo $sql."<hr>";
											
						        $result_sem=ejecutar($sql); 

								
								$tr = "<tr>";
								$th = "<th ><p style='width: 250px'>Nombre</p></th>";
								$td = "<tr>";
								$table = "<div class='table-responsive'>
								<table style='width: 100%; font-size: 12px' class='table table-bordered js-exportable'>";
								//echo $cnt." xx<hr>";
									
								$cnt1 = 1;
								$sql1 = "
									SELECT
										admin.usuario_id as usuario_idx,
										admin.nombre,";
								$cnt = mysqli_num_rows($result_sem);
								//echo $cnt." conteo inicial<br>";		
							    while($row_sem = mysqli_fetch_array($result_sem)){
							        extract($row_sem);	
									//echo $cnt1." cnt1<br>";
									//print_r($row_sem);
									$fechax = $fecha;							
							        $fecha_cnt = date("j",strtotime($fecha));
							        $th .= "<th style='background: #FFF; text-align: center'>$fecha_cnt</th>";
									
									if ($cnt == $cnt1) {
										$sql1 .= "
										(SELECT
												COUNT(*) AS cnt  
											FROM
												historico_sesion 
												INNER JOIN admin as admin$fecha_cnt ON historico_sesion.usuario_id = admin$fecha_cnt.usuario_id
											WHERE 
												historico_sesion.f_captura = '$fechax' AND admin$fecha_cnt.usuario_id = admin.usuario_id
											) as fecha$fecha_cnt ";										
									} else {
										$sql1 .= "
										(SELECT
												COUNT(*) AS cnt  
											FROM 
												historico_sesion 
												INNER JOIN admin as admin$fecha_cnt ON historico_sesion.usuario_id = admin$fecha_cnt.usuario_id
											WHERE 
												historico_sesion.f_captura = '$fechax' AND admin$fecha_cnt.usuario_id = admin.usuario_id
											) as fecha$fecha_cnt,";										
									}

									$cnt1++;								
							        
								}
									$sql1 .=" FROM
										admin 
										WHERE 
											admin.funcion in('REPRESENTANTE','ADMINISTRADOR')
											AND admin.estatus = 'Activo'
											AND admin.empresa_id = $empresa_id
											";
								//echo $sql1."<hr><br>";
									$result_sem1=ejecutar($sql1); 
							    while($row_sem1 = mysqli_fetch_array($result_sem1)){
							        extract($row_sem1);	
							        //print_r($row_sem1);

							        $td .= "<tr><td>$nombre</td>";
							        for ($i=1; $i < $cnt1 ; $i++) {
							        		
							        	
							        	$fechay = "fecha".$i;	
							        	if ($$fechay <> 0) {
											$class =" style='background: #D1F2EB'";
											$class_tx = "success";
										} else {
											$class =" style='background: #FFF'";
											$class_tx = "default";
										}
										 
										//$td .= "<td $class>".$$fechay."xx</td>";

										$script_tx = "
		                        		<script>
											$('#boton_tdx_".$td_id."').click(function() {
												
							                	var fecha = '".$anio_sel."-".$mes_sel."-".$i."';
												var usuario_idx = '".$usuario_idx."'
							                	var tipo_consulta = 'diaria';
												var medico = '".$nombre."'
							                    var datastring = 'fecha='+fecha+'&tipo_consulta='+tipo_consulta+'&usuario_idx='+usuario_idx+'&medico='+medico;
							                    //alert(datastring);
												$('#contenido_modal').html('');
							                    $.ajax({
							                        url: 'genera_tecnicos.php',
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
										";								
										$td .= "<td><button id='boton_tdx_".$td_id."' type='button' class='btn btn-".$class_tx." waves-effect'>".$$fechay."</button>".$script_tx."</td>";										
										$td_id++;	
										
										//$con_graf ='';
									}
									$td .= "</tr>";
									
									//$resultado .= '{"y": "'.$nombre.'", "PHQ9": '.$PHQ9.', "GAD7": '.$GAD7.'},';
							    }    										
							$table .= "<tr>".$th.$td."</tr>";
							
							$table .= "<tr><th>Total</th>";
							
							$sql_tot = "
								SELECT
									fechas.id,
									fechas.fecha,
									(SELECT
										COUNT(*) AS cnt 
									FROM
										historico_sesion
									WHERE
										historico_sesion.f_captura = fechas.fecha
									) AS total
								FROM
									fechas
								WHERE
									MONTH(fechas.fecha) = $mes_sel
									AND YEAR(fechas.fecha) = $anio_sel
									AND fechas.fecha <= '$hoy'";
								$result_tot = ejecutar($sql_tot); 

						    while($row_tot = mysqli_fetch_array($result_tot)){
						        extract($row_tot);	
								if ($total >= 1) {
									$class_t = "info";
								} else {
									$class_t = "default";
								}
								$script_t = "
                        		<script>
									$('#boton_".$id."').click(function() {
										
					                	var fecha = '".$fecha."';
					                	var tipo_consulta = 'total'
					                    var datastring = 'fecha='+fecha+'&tipo_consulta='+tipo_consulta;
										$('#contenido_modal').html('');
					                    $.ajax({
					                        url: 'genera_tecnicos.php',
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
								";								
								$table .= "<th><button id='boton_".$id."' type='button' class='btn btn-".$class_t." waves-effect'>".$total."</button>".$script_t."</th>";

		
															
								//$table .= "<th>".$total."</th>";
							}
							
							$table.= "</tr></table><div>";
							
							echo $table;
							
							$sql_user = "
							SELECT
								admin.usuario_id, 
								admin.nombre, 
								admin.funcion
							FROM
								admin
							WHERE 
								admin.funcion in('REPRESENTANTE','ADMINISTRADOR')
								AND admin.estatus = 'Activo'
								AND admin.empresa_id = $empresa_id
								ORDER BY nombre ASC";
								//echo $sql_user;
								$result_user = ejecutar($sql_user); 
								$cnt = mysqli_num_rows($result_user);
								$cnt1 = 1;
								$sql2 = "
								SELECT
									fechas.fecha,";
									$ykeys = "";
									$labels = "";
						    while($row_sem1 = mysqli_fetch_array($result_user)){
						        extract($row_sem1);	
											
									$ykeys .= "'user_$usuario_id',";
									$labels	.= "'$nombre',";					
									if ($cnt == $cnt1) {
										$sql2 .= "
										(
										SELECT
											COUNT(*) 
										FROM
											admin as admin$cnt1
											INNER JOIN registro_visitas ON admin$cnt1.usuario_id = registro_visitas.usuario_id 
										WHERE
											admin$cnt1.usuario_id = 5 
											AND registro_visitas.fecha = fechas.fecha 
											AND admin$cnt1.estatus = 'Activo' 
											AND admin$cnt1.empresa_id = $empresa_id
											";										
									} else {
										$sql2 .= "
										(										
											SELECT
												COUNT(*) 
											FROM
												admin as admin$cnt1
												INNER JOIN registro_visitas ON admin$cnt1.usuario_id = registro_visitas.usuario_id 
											WHERE
												admin$cnt1.usuario_id = 5 
												AND registro_visitas.fecha = fechas.fecha 
												AND admin$cnt1.estatus = 'Activo' 
												AND admin$cnt1.empresa_id = $empresa_id
										) AS usuario_$usuario_id,	";										
									}
									$cnt1++;							
							}
							
							$sql2 .= "FROM
										fechas 
									WHERE
										MONTH ( fechas.fecha ) = $mes_sel 
										AND YEAR ( fechas.fecha ) = $anio_sel 
										AND fechas.fecha <= '$hoy';";									
								echo $sql2."<hr>";	
								$result_user2 = ejecutar($sql2); 
								$grafica = "[ ";
								
						    while($row_sem2 = mysqli_fetch_array($result_user2)){
						        extract($row_sem2);	
						        //print_r($row_sem2);
						        //$f_captura = strftime("%e-%b-%Y",strtotime($fecha));     
						     	$grafica .="{ y: '$fecha',"; 
						     
								$sql_user = "
								SELECT
									admin.usuario_id, 
									admin.nombre
								FROM
									admin
								WHERE admin.funcion in('REPRESENTANTE') AND admin.estatus = 'Activo' AND admin.empresa_id = $empresa_id
								ORDER BY nombre ASC";
									$result_user = ejecutar($sql_user); 
									$cnt = mysqli_num_rows($result_user);
									$cnt1 = 1;
									$sql2 = "
									SELECT
										fechas.fecha,";
							    while($row_sem1 = mysqli_fetch_array($result_user)){
							        extract($row_sem1);
									$user = "usuario_$usuario_id";
									$grafica .= "'user_$usuario_id' : ".$$user.", ";
								}						     
							     
						      	$grafica .= " },";
						        
					        }	
							$grafica .= " ]";
							//echo $grafica;								
                        	?>
                        	</div>
                    	</div>
                	<hr>
                	<h1 align="center">Grafica</h1>
               
                	<div style='width: 100%' id='graph'></div>                        	
					<script> 
						var week_data = <?php echo $grafica; ?>;
						Morris.Line({
						  element: 'graph',
						  data: week_data,
						  xkey: 'y',
						  ykeys: [<?php echo $ykeys; ?>],
						  labels: [<?php echo $labels; ?>],
						  labelColor: ['#ff0000', '#00ff00', '#0000ff','#FFFF00','#FF00FF','#00FFFF'],
						  lineColors: ['#ff0000', '#00ff00', '#0000ff','#FFFF00','#FF00FF','#00FFFF'],
						  
						});	
					</script>
            	</div>
        	</div>
    	</div>
	</div>
              
<table style='background: #D1F2EB'></table>
 <button style="display: none" id="modal_grafica" type="button" class="btn btn-default waves-effect m-r-20" data-toggle="modal" data-target="#largeModal">MODAL - LARGE SIZE</button>
 <!-- Large Size -->
            <div class="modal fade" id="largeModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="largeModalLabel">Detalle de Terapias</h4>
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
    
    <!-- Jquery Knob Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/jquery-knob/jquery.knob.min.js"></script>

    <!-- Custom Js -->
    <script src="<?php echo $ruta; ?>js/pages/charts/jquery-knob.js"></script>   
   

<?php	include($ruta.'footer2.php');	?>