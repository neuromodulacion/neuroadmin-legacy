<?php
// Iniciar la sesión del usuario
session_start();

// Configurar el nivel de reporte de errores (7 muestra errores y advertencias)
error_reporting(7);

// Establecer la codificación interna a UTF-8 para las funciones de conversión de cadenas
iconv_set_encoding('internal_encoding', 'utf-8');

// Enviar cabecera HTTP para especificar que el contenido es HTML con codificación UTF-8
header('Content-Type: text/html; charset=UTF-8');

// Establecer la zona horaria predeterminada
date_default_timezone_set('America/Monterrey');

// Configurar la localización en español para fechas y horas
setlocale(LC_TIME, 'es_ES.UTF-8');

// Guardar la hora actual en la sesión
$_SESSION['time'] = time();

// Definir la ruta base para acceder a otros archivos
$ruta = "../";


$hoy = date("Y-m-d");
$ahora = date("H:i:00"); 
$anio = date("Y");
$mes_ahora = date("m");
$titulo ="Protocolos";


if ($mes_nav =='') {
	$mes_nav = $mes_ahora;
}

if ($anio_nav =='') {
	$anio_nav = $anio;
}
//include($ruta.'header.php'); 
if ($funcion == 'SISTEMAS' || $funcion == 'ADMINISTRADOR') {
	$class = "js-exportable";	
	$where = "";
}else{
	$class = "";
	if ($funcion == 'MEDICO'){$where = "AND pacientes.usuario_id = $usuario_id";}else{$where = "";}
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
                <h2>REPORTE DE PROTOCOLOS</h2>
                <?php echo $ubicacion_url."<br>"; 
                //echo $ruta."proyecto_medico/menu.php"?>
            </div>
<!-- // ************** Contenido ************** // -->
            <!-- CKEditor -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div style="height: 95%"  class="header">
                        	<h1 align="center">Reporte de Técnicos</h1>
                        	<hr>
								<div class="row">
									<div class="col-xs-3"></div>
								  	<div class="col-xs-3">
										<div style="padding: 3px" >
											<select class="form-control" id="mes_nav" name="mes_nav">
												<option <?php if($mes_nav == "01"){ echo "selected";} ?> value="01">Enero</option>
												<option <?php if($mes_nav == "02"){ echo "selected";} ?> value="02">Febrero</option>
												<option <?php if($mes_nav == "03"){ echo "selected";} ?> value="03">Marzo</option>
												<option <?php if($mes_nav == "04"){ echo "selected";} ?> value="04">Abril</option>
												<option <?php if($mes_nav == "05"){ echo "selected";} ?> value="05">Mayo</option>
												<option <?php if($mes_nav == "06"){ echo "selected";} ?> value="06">Junio</option>
												<option <?php if($mes_nav == "07"){ echo "selected";} ?> value="07">Julio</option>
												<option <?php if($mes_nav == "08"){ echo "selected";} ?> value="08">Agosto</option>
												<option <?php if($mes_nav == "09"){ echo "selected";} ?> value="09">Septiembre</option>
												<option <?php if($mes_nav == "10"){ echo "selected";} ?> value="10">Octubre</option>
												<option <?php if($mes_nav == "11"){ echo "selected";} ?> value="11">Noviembre</option>
												<option <?php if($mes_nav == "12"){ echo "selected";} ?> value="12">Diciembre</option>
		
											</select>
											<script>
											  $('#mes_nav').change(function(){ 
											    //alert('test');
											    
												var mes_nav = $('#mes_nav').val();
												var anio_nav = $('#anio_nav').val();
											    // Asignar la URL de destino según el valor seleccionado en el <select>
												var newUrl = 'https://neuromodulaciongdl.com/reporte/protocolos.php?anio_nav='+anio_nav+'&mes_nav='+mes_nav; // Aquí debes colocar la URL de destino a la que deseas redireccionar
											
											    // Redireccionar a la nueva URL
											    window.location.href = newUrl;
											  });
											</script>											
										</div>								  	
								  	</div>
								  	<div class="col-xs-3">
										<div style="padding: 3px" id="anio_nav_">
											<select class="form-control" id="anio_nav" name="anio_nav">
												<?php
													$sql_anio ="
													SELECT
														year(fechas.fecha) as anio,
														COUNT(*) as cnt
													FROM
														fechas 
														GROUP BY 1;";
											        $result_anio=ejecutar($sql_anio); 
												    while($row_anio = mysqli_fetch_array($result_anio)){
												        extract($row_anio);																										
												?>
														<option <?php if($anio_nav == $anio){ echo "selected";} ?> value="<?php echo $anio; ?>"><?php echo $anio; ?></option>
												<?php } ?>
											</select>
											<script>
											  $('#anio_nav').change(function(){ 
											    //alert('test');
											    
												var mes_nav = $('#mes_nav').val();
												var anio_nav = $('#anio_nav').val();
											    // Asignar la URL de destino según el valor seleccionado en el <select>
												var newUrl = 'https://neuromodulaciongdl.com/reporte/protocolos.php?anio_nav='+anio_nav+'&mes_nav='+mes_nav; // Aquí debes colocar la URL de destino a la que deseas redireccionar
											
											    // Redireccionar a la nueva URL
											    window.location.href = newUrl;
											  });
											</script>
										</div>									  		
								  	</div>
								  	<div class="col-xs-3"></div>
								</div>                        	
								<hr>
							                        
								<?php                        	
								$sql ="
								SELECT
									fechas.fecha,
									fechas.semana,
									fechas.dia 
								FROM
									fechas 
								WHERE
									MONTH ( fechas.fecha ) = $mes_nav
									AND YEAR ( fechas.fecha ) = $anio_nav 
									AND fechas.fecha <= '$hoy'";
							//8echo $sql."<hr>";
											
						        $result_sem=ejecutar($sql); 
								$cnt = mysqli_num_rows($result_sem);
								$tr = '<tr>';
								$th = '<th>Protocolo</th>';
								$td = '<tr>';
								$table = "
								<table style='max-width: 100%; font-size: 10px' class='table table-bordered js-exportable'>";
								//echo $cnt." xx<hr>";
									
								$cnt1 = 1;
								$sql1 = "
									SELECT
										protocolo_terapia.protocolo_ter_id,
										protocolo_terapia.prot_terapia,";
							    while($row_sem = mysqli_fetch_array($result_sem)){
							        extract($row_sem);	
									//print_r($row_sem);
									$fechax = $fecha;							
							        $fecha = strftime("%e",strtotime($fecha));
							        $th .= "<th style='background: #FFF'>$fecha</th>";
									
									if ($cnt == $cnt1) {
										$sql1 .= "
										(SELECT
											COUNT(*) 
										FROM
											historico_sesion
											INNER JOIN protocolo_terapia as protocolo_terapia$cnt1 ON historico_sesion.protocolo_ter_id = protocolo_terapia$cnt1.protocolo_ter_id 
										WHERE
											historico_sesion.f_captura = '$fechax' 
											AND historico_sesion.protocolo_ter_id = protocolo_terapia.protocolo_ter_id ) as fecha$cnt1 ";										
									} else {
										$sql1 .= "
										(SELECT
											COUNT(*) 
										FROM
											historico_sesion
											INNER JOIN protocolo_terapia as protocolo_terapia$cnt1 ON historico_sesion.protocolo_ter_id = protocolo_terapia$cnt1.protocolo_ter_id 
										WHERE
											historico_sesion.f_captura = '$fechax' 
											AND historico_sesion.protocolo_ter_id = protocolo_terapia.protocolo_ter_id ) as fecha$cnt1, ";									
									}

									$cnt1++;								
							        
								}
									$sql1 .=" FROM
													protocolo_terapia 
												WHERE
													protocolo_terapia.estatus = 'Activo'";
								//echo $sql1;
									$result_sem1=ejecutar($sql1); 
							    while($row_sem1 = mysqli_fetch_array($result_sem1)){
							        extract($row_sem1);	
							        //print_r($row_sem1);

							        $td .= "<tr><td>$prot_terapia</td>";
							        for ($i=1; $i < $cnt1 ; $i++) {
							        		
							        	
							        	$fechay = "fecha".$i;	
							        	if ($$fechay <> 0) {
											$class =" style='background: #D1F2EB'";
										} else {
											$class =" style='background: #FFF'";
										}
										 
										$td .= "<td $class>".$$fechay."</td>";
										
										//$con_graf ='';
									}
									$td .= "</tr>";
									
									//$resultado .= '{"y": "'.$nombre.'", "PHQ9": '.$PHQ9.', "GAD7": '.$GAD7.'},';
							    }    										
							$table .= "<tr>".$th.$td;
							$table.= "</tr></table>";
							
							echo $table;
							
							$sql_user = "
								SELECT
									protocolo_terapia.protocolo_ter_id as usuario_id, 
									protocolo_terapia.prot_terapia, 
									protocolo_terapia.estatus
								FROM
									protocolo_terapia
								WHERE protocolo_terapia.estatus = 'Activo'";
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
									$prot_terapia = substr($prot_terapia, 0, 40); 	
									$ykeys .= "'$prot_terapia',";
									$labels	.= "'$prot_terapia',";					
									if ($cnt == $cnt1) {
										$sql2 .= "
										( SELECT COUNT(*) FROM historico_sesion WHERE historico_sesion.f_captura = fechas.fecha AND historico_sesion.protocolo_ter_id = $usuario_id ) AS usuario_user_$usuario_id";										
									} else {
										$sql2 .= "
										( SELECT COUNT(*) FROM historico_sesion WHERE historico_sesion.f_captura = fechas.fecha AND historico_sesion.protocolo_ter_id = $usuario_id ) AS usuario_user_$usuario_id,";									
									}
									$cnt1++;							
							}
							
							$sql2 .= " FROM
										fechas 
									WHERE
										MONTH ( fechas.fecha ) = $mes_nav 
										AND YEAR ( fechas.fecha ) = $anio_nav 
										AND fechas.fecha <= '$hoy';";									
								//echo $sql2."<hr>";	
								$result_user2 = ejecutar($sql2); 
								$grafica = "[ ";
								
						    while($row_sem2 = mysqli_fetch_array($result_user2)){
						        extract($row_sem2);	
						        //print_r($row_sem2);
						        //$f_captura = strftime("%e-%b-%Y",strtotime($fecha));     
						     	$grafica .="{ y: '$fecha',"; 
						     
								$sql_user = "
									SELECT
										protocolo_terapia.protocolo_ter_id as usuario_id,
										protocolo_terapia.prot_terapia
									FROM
										protocolo_terapia
									WHERE
										protocolo_terapia.estatus = 'Activo'";
										
									$result_user = ejecutar($sql_user); 
									$cnt = mysqli_num_rows($result_user);
									$cnt1 = 1;
									$sql2 = "
									SELECT
										fechas.fecha,";
							    while($row_sem1 = mysqli_fetch_array($result_user)){
							        extract($row_sem1);
							        $prot_terapia = substr($prot_terapia, 0, 40); 
									$user = "usuario_user_$usuario_id"; 
									$grafica .= "'$prot_terapia' : ".$$user.", ";
								}						     
							     
						      	$grafica .= " },";
						        
					        }	
							$grafica .= " ]";
							//echo $grafica;								
                        	?>
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