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

//extract($_SESSION);
//print_r($_SESSION);


$hoy = date("Y-m-d");
$ahora = date("H:i:00"); 
$anio = date("Y");
$mes_ahora = date("m");
$titulo ="Participantes Registrados";


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
                <h2>Participantes Registrados</h2>
                <?php echo $ubicacion_url."<br>"; 
                //echo $ruta."proyecto_medico/menu.php"?>
            </div>
<!-- // ************** Contenido ************** // -->
            <!-- CKEditor -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div style="height: 95%"  class="header">
                        	<h1 align="center">Participantes Registrados</h1>
                        	<hr>
							<div class="table-responsive">
							    <table style="width: 100%" class="table table-bordered">
							        <thead>
							            <tr>
							                <th>ID</th>
							                <th>Nombre Completo</th>
							                <th>Profesión</th>
							                <th>Celular</th>
							                <th>Correo Electrónico</th>
							                <th>Fecha Registro</th>
							                <th>Estatus</th>
							                <th>Validación</th>
							            </tr>
							        </thead>
							        <tbody>
							            <?php
							            //include '../functions/funciones_mysql.php';
							            $sql = "SELECT * FROM participantes";
								        $result_protocolo=ejecutar($sql); 
								            //echo $cnt."<br>";  
								            //echo "<br>";    
								            $cnt = mysqli_num_rows($result_protocolo);
								            $total = 0;
								            $ter="";
							
										if ($cnt > 0) {
							                while($row = mysqli_fetch_array($result_protocolo)){
												$f_captura = $row['fecha_registro'];
												$today = strftime( '%d-%b-%Y %I:%M:%S %p', strtotime( $f_captura) );
												$id = $row['id'];
							                    echo "<tr>
							                            <td>{$row['id']}</td>
							                            <td>{$row['nombre_completo']}</td>
							                            <td>{$row['profesion']}</td>
							                            <td>{$row['celular']}</td>
							                            <td>{$row['correo']}</td>							                            
							                            <td>{$today}</td>
							                            <td>{$row['estatus']}</td>
							                            <td>
							                            	<button id='boton_{$id}' class='btn bg-$body' type='button'>Validación</button>
							                            </td>
							                          </tr>"; ?>
							                          
							                        <script>
							                            $('#boton_<?php echo $id; ?>').click(function(){ 
							                                var id = '<?php echo $id; ?>';
							                                $('#boton_id').val(id);
							                                $('#modal').click();
							                                $('#info').html(''); 
							                                var datastring = 'id='+id;
						                                    $.ajax({
						                                        url: 'validaciones.php',
						                                        type: 'POST',
						                                        data: datastring,
						                                        cache: false,
						                                        success:function(html){    
						                                            $('#info').html(html); 
						                                            //$('#load1').hide();
						                                            //$('#muestra_asegurado').click();
						                                        }
						                                	});							                                						                                
							                            });
							                        </script>							                          
							                          
							                          
											<?php		  
							                }
							            } else {
							                echo "<tr><td colspan='5'>No hay participantes registrados.</td></tr>";
							            }
							            ?>
							        </tbody>
							    </table>
							</div>

				            <button style="display: none" id="modal" type="button" class="btn btn-default waves-effect m-r-20" data-toggle="modal" data-target="#defaultModal">MODAL - DEFAULT SIZE</button>
				            <div class="modal fade" id="defaultModal" tabindex="-1" role="dialog">
				                <div class="modal-dialog" role="document">
				                    <div class="modal-content">
											<form action="guardar_estatus.php" method="post">
								                <div class="modal-header">
								                    <h5 class="modal-title" id="estatusModalLabel">Selecciona la acción</h5>
								                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								                        <span aria-hidden="true">&times;</span>
								                    </button>
								                </div>	
								                <hr>						                    
							                    <div class="modal-body">
							                        <div class="row">
							                            <div class="col-md-4">
							                            	<input type="hidden" id="boton_id" name="id" value=""/>
							                                <p>Estatus</p>
							                                <div class="demo-radio-button">
							                                    <input name="estatus" type="radio" id="radio_1" value="No Contactado" class="with-gap radio-col-primary" />
							                                    <label for="radio_1">No Contactado</label>
							
							                                    <input name="estatus" type="radio" id="radio_2" value="Invitado" class="with-gap radio-col-primary" />
							                                    <label for="radio_2">Invitado</label>
							
							                                    <input name="estatus" type="radio" id="radio_3" value="Rechazado" class="with-gap radio-col-primary" />
							                                    <label for="radio_3">Rechazado</label>
							
							                                    <input name="estatus" type="radio" id="radio_4" value="Asistió" class="with-gap radio-col-primary" />
							                                    <label for="radio_4">Asistió</label>
							                                </div>				
							                            </div>
							                            <div class="col-md-8">
							                                <p>Observaciones</p>
							                                <div class="form-group">
							                                    <div class="form-line">
							                                        <textarea id="observaciones" name="observaciones" rows="4" class="form-control no-resize" placeholder="Registra las observaciones"></textarea>
							                                    </div>
							                                </div>  	
							                            </div>
							                        </div>                                              
							                    </div>
							                    <div id="info" class="container"></div>
							                    <hr>
							                    <div class="modal-footer">
							                        <button type="button" class="btn bg-red" data-dismiss="modal">Cerrar</button>
							                        <button type="submit" class="btn bg-<?php echo $body; ?>">Guardar</button>
							                    </div>
							                </form> 
				                    </div>
				                </div>
				            </div>
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