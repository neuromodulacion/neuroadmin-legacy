<?php
session_start();

// Establecer el nivel de notificación de errores
error_reporting(E_ALL); // Reemplaza `7` por `E_ALL` para usar la constante más clara y recomendada

// Establecer la codificación interna a UTF-8 (ya no se utiliza `iconv_set_encoding`, sino `ini_set`)
ini_set('default_charset', 'UTF-8');

// Configurar la cabecera HTTP con codificación UTF-8
header('Content-Type: text/html; charset=UTF-8');

// Configurar la zona horaria
date_default_timezone_set('America/Monterrey');

// Configurar la localización para manejar fechas y horas en español
setlocale(LC_TIME, 'es_ES.UTF-8');

// Asignar el tiempo actual a la sesión en formato de timestamp
$_SESSION['time'] = time(); // `time()` es el equivalente moderno a `mktime()`


$ruta="../";

$hoy = date("Y-m-d");
$ahora = date("H:i:00"); 
$anio = date("Y");
$mes_ahora = date("m");
$mes = strftime("%B");
$dia = date("N");
$semana = date("W");
$titulo ="Agenda";
$genera ="";



include($ruta.'header1.php');

include('calendario.php');

 $mes_largo =OptieneMesLargo($mes_ahora);
 $dia = dia_semana($dia);
 
	$sql_sem1 = "
	SELECT
		*
	FROM
		fechas
	WHERE
		fechas.semana= $semana and YEAR(fecha) = $anio
    ";
	//	echo "$sql_sem1 <br>";
    $result_sem1=ejecutar($sql_sem1); 
   
        $cnt=1;
        $total = 0;
        $ter="";
    while($row_sem1 = mysqli_fetch_array($result_sem1)){
        extract($row_sem1);
		if ($cnt == 1) { $dia_ini = $fecha; } 
		if ($cnt == 7) { $dia_fin = $fecha; } 
		$cnt++;
	} 
 
//include($ruta.'header.php');
?>
    <!-- JQuery DataTable Css -->
    <link href="<?php echo $ruta; ?>plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

<?php  include($ruta.'header2.php'); ?>

    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>AGENDA</h2>
                <!-- <?php echo $ubicacion_url."<br>"; 
                //echo $ruta."proyecto_medico/menu.php"?> -->
              
            </div>
<!-- // ************** Contenido ************** // -->
            <!-- CKEditor -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div style="height: 95%"  class="header">
                        	<h1 align="center">Agenda</h1>
                             	<div class="row">
                             		<div align="right" class="col-xs-1">
		                                <div class="form-line">
		                                    
			                                <button id="buscar" name="buscar" type="button" class="btn bg-<?php echo $body; ?> waves-effect">
			                                    <i class="material-icons">search</i>
			                                </button>
		                                </div>
				                        <script>
				                            $('#buscar').click(function(){ 
				                            	//alert($('#dia_busca').val()); 
				                                $('#calendario').html(''); 
				                                $('#load_modal').show(); 
				                                var semana = '<?php echo $semana; ?>';
				                                var anio = '<?php echo $anio; ?>';
				                                var mes_largo = '<?php echo $mes_largo; ?>'; 
				                                var body ='<?php echo $body; ?>';
				                                var accion = 'busca';
				                                var dia_ini = $('#dia_busca').val();
				                                var dia_fin = $('#dia_busca').val();
				                                var datastring = 'semana='+semana+'&anio='+anio+'&mes_largo='+mes_largo+'&body='+body+'&accion='+accion+'&dia_ini='+dia_ini+'&dia_fin='+dia_fin;
				                                //alert(datastring);
			                                    $.ajax({
			                                        url: 'busca_calendario.php',
			                                        type: 'POST',
			                                        data: datastring,
			                                        cache: false,
			                                        success:function(html){     
			                                            $('#calendario').html(html); 
			                                            //$('#load1').hide();
			                                            //$('#muestra_asegurado').click();
			                                        }
			                                	});
				                            });
				                        </script>                             			
                         			</div>
                             	<div align="left" class="col-xs-4">
                                    <h2 class="card-inside-title">Buscar una Fecha</h2>
                                    <div  >
		                            <input type="date" id="dia_busca" name="=dia_busca" class="form-control" value="<?php echo $hoy; ?>">    
		                                
		                                
		                                
                                        <!-- <span class="input-group-addon">
                                            <i class="material-icons">date_range</i>
                                        </span> -->
                                    </div> 
                             	</div>  
                             	<div align="left" class="col-xs-6">
						            <button type="button" data-color="<?php echo $body; ?>" class="btn bg-<?php echo $body; ?> waves-effect" data-toggle="modal" data-target="#largeModal">Agendar Cita</button>                
						            <div class="modal fade" id="largeModal" tabindex="-1" role="dialog">
						                <div class="modal-dialog modal-lg" role="document">
						                    <div class="modal-content">
						                        <div class="modal-header">
						                            <h4 class="modal-title" id="largeModalLabel">Agendar Cita</h4>
						                        </div>
						                        <div class="modal-body">
							                        <div class="row">
															<div class="form-group">
															    <div class="col-sm-2">
															    	<label for="inputEmail3" class="control-label"># Paciente</label>
															      	<input type="number" class="form-control" id="paciente_id" value="<?php echo $paciente_id; ?>">
															    </div>
															</div>
															<div class="form-group">
															    <div class="col-sm-3">
															    	<label for="inputEmail3" class="control-label">Nombre</label>
															      	<input type="text" class="form-control" id="paciente"  value="<?php echo $paciente; ?>">
															    </div>
															</div>
															<div class="form-group">
															    <div class="col-sm-3">
															    	<label for="inputEmail3" class="control-label">Apellido Paterno</label>
															      	<input type="text" class="form-control" id="apaterno"  value="<?php echo $apaterno; ?>">
															    </div>
															</div>
															<div class="form-group">
															    <div class="col-sm-3">
															    	<label for="inputEmail3" class="control-label">Apellido Materno</label>
															      	<input type="text" class="form-control" id="amaterno" value="<?php echo $amaterno; ?>" >
															    </div>
															</div>
																							
					                             		<!-- <div align="right" class="col-xs-6">	
							                                <div class="form-line">
							                                    <input type="text" id="busca_paciente" name="=busca_paciente" class="form-control" placeholder="Busca Paciente" value="">         
							                               </div>
						                               	</div>  -->	
							                             <div align="left" class="col-xs-1">
							                         			<button id="buscar1" name="buscar1" type="button" class="btn bg-<?php echo $body; ?> waves-effect">
								                                    <i class="material-icons">search</i>
								                                </button>
							                             </div> 
								                        <script>
								                            $('#buscar1').click(function(){ 
								                            	//alert($('#dia_busca').val());
								                            	$('#load_modal').show();  
								                                $('#contenido').html(''); 
								                                var paciente_id = $('#paciente_id').val();
								                                var paciente = $('#paciente').val();
								                                var apaterno = $('#apaterno').val();
								                                var amaterno = $('#amaterno').val();

								                                var body = '<?php echo $body; ?>';
								                                
								                                var datastring = 'paciente_id='+paciente_id+'&body='+body+"&paciente="+paciente+'&apaterno='+apaterno+"&amaterno="+amaterno;
								                                //alert(datastring);
							                                    $.ajax({
							                                        url: 'busca_agenda.php',
							                                        type: 'POST',
							                                        data: datastring,
							                                        cache: false,
							                                        success:function(html){     
							                                            $('#contenido').html(html); 
							                                            $('#load_modal').hide();
							                                            //$('#muestra_asegurado').click();
							                                        }
							                                	});
								                            });
								                        </script> 						                             
						                             </div>  
						                             <hr>
					                             	<div style="display: none" align="center" id="load_modal">
						                                <div class="preloader pl-size-xl">
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
					                                <div align="center" id="contenido2">				                             	
							                            <div align="center" id="contenido">
							                            	<?php 	
							                            	//print_r($_GET);       
							                            		$paciente = strtoupper($paciente);
																$apaterno = strtoupper($apaterno);
																$amaterno = strtoupper($amaterno);
																
																echo busca_agenda($paciente_id,$paciente,$apaterno,$amaterno,$body,$genera);
							                            	?>                      	
						
															
							                            </div><hr>
								                        <div class="modal-footer">

								                        </div>					                             				                        	
													</div>	
						                        </div>

						                    </div>
						                </div>
						            </div> 
                             	</div>                              	
                             </div>  
                            <!-- Large Size -->
                                	

                            <div id="calendario">
            
                            <?php
                            
                            echo calendario($semana,$anio,$mes_largo,$genera,$body,$accion,$dia_ini,$dia_fin);
 
								?>			                			                			                	
			                </table>                                	
                            </div>
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

    <!-- Autosize Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/autosize/autosize.js"></script>

    <!-- Moment Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/momentjs/moment.js"></script>


<?php	include($ruta.'footer2.php');	?>