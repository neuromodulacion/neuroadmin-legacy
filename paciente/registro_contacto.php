<?php
// Definir la ruta base para las inclusiones de archivos
$ruta = "../";

// Variables de fecha y hora actuales
$hoy = date("Y-m-d"); // Fecha actual en formato YYYY-MM-DD
$ahora = date("H:i:00"); // Hora actual en formato HH:MM:00
$anio = date("Y"); // Año actual
$mes_ahora = date("m"); // Mes actual en formato numérico
$mes = strftime("%B"); // Nombre del mes en formato de cadena
$dia = date("N"); // Número del día de la semana (1=Lunes, 7=Domingo)
$semana = date("W"); // Número de la semana del año

$titulo ="Registro Contacto"; 

include($ruta.'header1.php');
//include($ruta.'header.php');
?>
    <!-- JQuery DataTable Css -->
    <link href="<?php echo $ruta; ?>plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

<?php
include($ruta.'header2.php');
//include($ruta.'header.php'); ?>

    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>REGISTRO DE CONTACTO</h2>
            </div>
<!-- // ************** Contenido ************** // -->
            <!-- CKEditor -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div style="height: 95%"  class="header">
                        	<h1 align="center">Registro de contacto</h1>
                        	
							<div class="row clearfix">
				                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				                    <div class="card">
				                        <div class="header">
				                            <h2>
				                                REGISTRO DE CONTACTO
				                            </h2>
				                        </div>
				                        <div class="body"> 
				                        	<form id="wizard_with_validation" method="POST" action="guarda_registro.php" >
					                        	<input name="paciente_id" type="hidden" id="paciente_id" value="<?php echo $paciente_id; ?>" />
					                        	
					                        	<h3>Paciente No. <?php echo $paciente_id." ".$paciente." ".$apaterno." ".$amaterno ?></h3>                      
					                            <h4>¿Se contacto al paciente?</h4><br>								
					                            <div class="demo-radio-button">
					                            	<input style="height: 0px; width: 0px" name="id_1" type="text" id="id_1" value="" required />
					                                <input name="contacto" type="radio" id="contacto_1" value="Si" />
					                                <label for="contacto_1">Si</label>                              
					                                <input name="contacto" type="radio" id="contacto_2" value="No"/>
					                                <label for="contacto_2">No</label>
				                            	</div>     
					                        		<script type='text/javascript'>
								                            $('#contacto_1').click(function(){ 
								                                $('#f_observaciones').hide(); 
								                                $('#encuesta').show(); 
								                                $('#id_1').val('ok'); 
								                                $("#id_2").prop('required', false);
								                                $("#id_3").prop('required', true);
								                                $("#id_4").prop('required', true);
								                                $("#id_5").prop('required', true);
								                                $("#id_6").prop('required', true);
							                            	});
														
							                        </script>  
					                        		<script type='text/javascript'>
								                            $('#contacto_2').click(function(){ 
								                            	$('#f_observaciones').show(); 
								                                $('#encuesta').hide();  				                            	
				                             					$('#id_1').val('ok');
				                             					$("#id_2").prop('required', true);
								                                $("#id_3").prop('required', false);
								                                $("#id_4").prop('required', false);
								                                $("#id_5").prop('required', false);
								                                $("#id_6").prop('required', false);                             					
							                            	});										
							                        </script>  					                                                     	 
				                        		<div style="display:none;" id="f_observaciones">
													<h4>¿Motivo por el que no se contacto?</h4><br>
													<input style="height: 0px; width: 0px" name="id_2" type="text" id="id_2" value="" />								
						                            <div class="demo-radio-button">
						                                <input name="no_contacto" type="radio" id="no_contacto_1" value="No contestan" />
						                                <label for="no_contacto_1">No contestan</label>
						                                <input name="no_contacto" type="radio" id="no_contacto_2" value="Manda a buzón"/>
						                                <label for="no_contacto_2">Manda a buzón</label>
						                                <input name="no_contacto" type="radio" id="no_contacto_3" value="No conocen al paciente"/>
						                                <label for="no_contacto_3">No conocen al paciente</label>
						                                <input name="no_contacto" type="radio" id="no_contacto_4" value="No se encuentra"/>
						                                <label for="no_contacto_4">No se encuentra</label>	
						                                <input name="no_contacto" type="radio" id="no_contacto_5" value="Ya no esta interezado"/>
						                                <label for="no_contacto_5">Ya no esta interezado</label>		                                	                                
					                            	</div>                         			
					                        		<script type='text/javascript'>
								                            $('#no_contacto_1').click(function(){ $('#id_2').val('ok'); });										
							                        </script>
					                        		<script type='text/javascript'>
								                            $('#no_contacto_2').click(function(){ $('#id_2').val('ok'); });										
							                        </script>
					                        		<script type='text/javascript'>
								                            $('#no_contacto_3').click(function(){ $('#id_2').val('ok'); });										
							                        </script>
					                        		<script type='text/javascript'>
								                            $('#no_contacto_4').click(function(){ $('#id_2').val('ok'); });										
							                        </script>		
					                        		<script type='text/javascript'>
								                            $('#no_contacto_5').click(function(){ $('#id_2').val('ok'); });										
							                        </script>			                        	                        			                        			                        
				                        		</div>
						                        <div style="display:none;" id="encuesta">
													<h4>¿Se informo de los beneficios?</h4><br>	
													<input style="height: 0px; width: 0px" name="id_3" type="text" id="id_3" value="" />							
						                            <div class="demo-radio-button">
						                                <input name="beneficios" type="radio" id="beneficios_1" value="Si" />
						                                <label for="beneficios_1">Si</label>
						                                <input name="beneficios" type="radio" id="beneficios_2" value="No"/>
						                                <label for="beneficios_2">No</label>
						                        		<script type='text/javascript'>
									                            $('#beneficios_1').click(function(){ $('#id_3').val('ok'); });										
								                        </script>
						                        		<script type='text/javascript'>
									                            $('#beneficios_2').click(function(){ $('#id_3').val('ok'); });										
								                        </script>			                        		                                
					                            	</div> 
						                            <h4>¿Se informo del costo?</h4><br>	
						                            <input style="height: 0px; width: 0px" name="id_4" type="text" id="id_4" value="" />							
						                            <div class="demo-radio-button">
						                                <input name="costo" type="radio" id="costo_1" value="Si" />
						                                <label for="costo_1">Si</label>
						                                <input name="costo" type="radio" id="costo_2" value="No"/>
						                                <label for="costo_2">No</label>
						                        		<script type='text/javascript'>
									                            $('#costo_1').click(function(){ $('#id_4').val('ok'); });										
								                        </script>
						                        		<script type='text/javascript'>
									                            $('#costo_2').click(function(){ $('#id_4').val('ok'); });										
								                        </script>		                                
					                            	</div>
						                            <h4>¿Se informo de las forma de pago?</h4><br>
						                            <input style="height: 0px; width: 0px" name="id_5" type="text" id="id_5" value="" />								
						                            <div class="demo-radio-button">
						                                <input name="f_pago" type="radio" id="f_pago_1" value="Si" />
						                                <label for="f_pago_1">Si</label>
						                                <input name="f_pago" type="radio" id="f_pago_2" value="No"/>
						                                <label for="f_pago_2">No</label>
						                        		<script type='text/javascript'>
									                            $('#f_pago_1').click(function(){ $('#id_5').val('ok'); });										
								                        </script>
						                        		<script type='text/javascript'>
									                            $('#f_pago_2').click(function(){ $('#id_5').val('ok'); });										
								                        </script>		                                
					                            	</div> 
						                            <h4>¿Desea empezar tratamiento?</h4><br>
						                            <input style="height: 0px; width: 0px" name="id_6" type="text" id="id_6" value="" />								
						                            <div class="demo-radio-button">
						                                <input name="ini_tratamiento" type="radio" id="ini_tratamiento_1" value="Si" />
						                                <label for="ini_tratamiento_1">Si</label>
						                                <input name="ini_tratamiento" type="radio" id="ini_tratamiento_2" value="No"/>
						                                <label for="ini_tratamiento_2">No</label>
						                        		<script type='text/javascript'>
									                            $('#ini_tratamiento_1').click(function(){ $('#id_6').val('ok'); });										
								                        </script>
						                        		<script type='text/javascript'>
									                            $('#ini_tratamiento_2').click(function(){ $('#id_6').val('ok'); });										
								                        </script>		                                
					                            	</div>   			                            	  
					                            	  
					                        		<script type='text/javascript'>
								                            $('#ini_tratamiento_1').click(function(){ 
								                                $('#tratamiento').hide();
								                                $('#formas_pago').show();
								                                $("#id_7").prop('required', true); 	
								                                $("#id_8").prop('required', false);	
								                                $("#id_9").prop('required', false);
								                                $("#id_10").prop('required', false);	
								                                $("#f_contacto_prox").prop('required', false);				                                	                                  
							                            	});
														
							                        </script>  
					                        		<script type='text/javascript'>
								                            $('#ini_tratamiento_2').click(function(){ 
								                            	$('#tratamiento').show();
								                            	$('#formas_pago').hide(); 
								                                $("#id_7").prop('required', false);
								                                $("#id_8").prop('required', true);
								                                $("#id_9").prop('required', true);
								                                $("#id_10").prop('required', true);
								                                $("#f_contacto_prox").prop('required', true);
							                            	});										
							                        </script> 	  
							                        <div style="display: none" id="formas_pago"> 
							                            <h4>¿Cual va a ser su forma de pago?</h4><br>
							                            <input style="height: 0px; width: 0px" name="id_7" type="text" id="id_7" value="" />								
							                            <div class="demo-radio-button">
							                                <input name="forma_pago" type="radio" id="forma_pago_1" value="Por sesión" />
							                                <label for="forma_pago_1">Por sesión</label>
							                                <input name="forma_pago" type="radio" id="forma_pago_2" value="Todo el tratamiento en efectivo o transferencia"/>
							                                <label for="forma_pago_2">Todo el tratamiento en efectivo o transferencia</label>
							                                <input name="forma_pago" type="radio" id="forma_pago_3" value="Todo el tratamiento en tarjeta credito"/>
							                                <label for="forma_pago_3">Todo el tratamiento en tarjeta credito</label>
							                                <input name="forma_pago" type="radio" id="forma_pago_4" value="Todo el tratamiento en TC Meses sin Intereses"/>
							                                <label for="forma_pago_4">Todo el tratamiento en TC Meses sin Intereses</label>		
							                                <input name="forma_pago" type="radio" id="forma_pago_5" value="No sabe en este momento"/>
							                                <label for="forma_pago_5">No sabe en este momento</label>	
						                        		
							                        		<script type='text/javascript'>
										                            $('#forma_pago_1').click(function(){ $('#id_7').val('ok'); });										
									                        </script>
							                        		<script type='text/javascript'>
										                            $('#forma_pago_2').click(function(){ $('#id_7').val('ok'); });										
									                        </script>
							                        		<script type='text/javascript'>
										                            $('#forma_pago_3').click(function(){ $('#id_7').val('ok'); });										
									                        </script>
							                        		<script type='text/javascript'>
										                            $('#forma_pago_4').click(function(){ $('#id_7').val('ok'); });										
									                        </script>		
							                        		<script type='text/javascript'>
										                            $('#forma_pago_5').click(function(){ $('#id_7').val('ok'); });										
									                        </script>						                        			                        				                                			                                	                                			                                
						                            	</div>			                         
							                         
							                        </div>                          	  
					                            	<div style="display: none" id="tratamiento">	                            		   	                         	
							                            <h4>¿Motivo por el cual no desea empezar tratamiento en este momento?</h4><br>
							                            <input style="height: 0px; width: 0px" name="id_8" type="text" id="id_8" value="" />								
							                            <div class="demo-radio-button">
							                                <input name="no_tratamiento" type="radio" id="no_tratamiento_1" value="Tengo que consultar con un familiar" />
							                                <label for="no_tratamiento_1">Tengo que consultar con un familiar</label>
							                                <input name="no_tratamiento" type="radio" id="no_tratamiento_2" value="No dispongo de la cantidad de pago en este momento"/>
							                                <label for="no_tratamiento_2">No dispongo de la cantidad de pago en este momento</label>
							                                <input name="no_tratamiento" type="radio" id="no_tratamiento_3" value="Voy a ver otras alternativas"/>
							                                <label for="no_tratamiento_3">Voy a ver otras alternativas</label>
							                                
							                               	<input name="no_tratamiento" type="radio" id="no_tratamiento_4" value="Otros"/>
							                                <label for="no_tratamiento_4">Otros</label>
						                            	</div>  
						                        		<script type='text/javascript'>
									                            $('#no_tratamiento_1').click(function(){ 
									                                $('#forma_otros').hide();
									                                $('#id_8').val('ok');				                                  
								                            	});
								                        </script> 	
						                        		<script type='text/javascript'>
									                            $('#no_tratamiento_2').click(function(){ 
									                                $('#forma_otros').hide();
									                                $('#id_8').val('ok');				                                  
								                            	});
								                        </script>
						                        		<script type='text/javascript'>
									                            $('#no_tratamiento_3').click(function(){ 
									                                $('#forma_otros').hide();
									                                $('#id_8').val('ok');				                                  
								                            	});
								                        </script>
						                        		<script type='text/javascript'>
									                            $('#no_tratamiento_4').click(function(){ 
									                                $('#forma_otros').show();
									                                $('#id_8').val('ok');				                                  
								                            	});
								                        </script>			                        			                        			                        	                            	
						 	                            <div style="display: none" id="forma_otros">
						 	                            	<h4>Describe otros</h4><br>								
								                            <div id="forma_otros" class="form-line">
								                                <label class="form-label">Otros</label>
								                                <input class="form-control" name="otros" type="text" id="otros" value="" />
								                                 
							                            	</div> 
						                            	</div>
							                            <h4>¿Le podemos contactar mas adelante?</h4><br>
							                            <input style="height: 0px; width: 0px" name="id_9" type="text" id="id_9" value="" />								
							                            <div class="demo-radio-button">
							                                <input name="new_contacto" type="radio" id="new_contacto_1" value="Si" />
							                                <label for="new_contacto_1">Si</label>
							                                <input name="new_contacto" type="radio" id="new_contacto_2" value="No"/>
							                                <label for="new_contacto_2">No</label>
						                            	</div> 
						                        		<script type='text/javascript'>
									                            $('#new_contacto_1').click(function(){ 
									                                $('#fecha_contacto').show(); 
									                                $('#id_9').val('ok');				                                  
								                            	});
								                        </script>  
						                        		<script type='text/javascript'>
									                            $('#new_contacto_2').click(function(){ 
									                            	$('#fecha_contacto').hide();
									                            	$('#id_9').val('ok');
								                            	});										
								                        </script>		                            	
						                            	<div style="display: none" id="fecha_contacto">
							 	                            <h4>¿Fecha aproximada de contacto?</h4><br>								
								                            <div >
								                                <label for="f_pago_1">Fecha</label>
								                                <input class="form-control"  name="f_contacto_prox" type="date" id="f_contacto_prox" value="<?php echo $hoy; ?>" />
								                                
							                            	</div> 
						                            	</div>		                        	
							                        </div>    	                     	
					                            </div> 
				                                     <div class="form-group form-float">
				                                        <div class="form-line">
				                                            <textarea class="form-control" id="observaciones" name="observaciones" rows="3" required></textarea>
				                                            <label class="form-label">Observaciones</label>
				                                        </div>
				                                    </div>                           	
				                            	                           	   
				                                <hr>                               
				                                <div class="row clearfix demo-button-sizes">
				                                	<div class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
				                                		<button type="submit" class="btn bg-green btn-block btn-lg waves-effect">GUARDAR</button>
				                            		</div>
				                        		</div>
				                            </form>                            	                        	
				                        </div>
				                    </div>
				                </div>
				            </div>                        	
                    	</div>
                	</div>
            	</div>
        	</div>
              

        </div>
    </section>
<?php	

//include($ruta.'footer.php');

include($ruta.'footer1.php'); ?>


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



<?php include($ruta.'footer2.php');?>