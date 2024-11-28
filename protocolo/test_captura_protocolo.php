<?php
include('../functions/funciones_mysql.php');
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


$ruta = "../";
extract($_POST);
// print_r($_POST);
 echo "<hr>";
extract($_SESSION);
// print_r($_SESSION);
// echo "<hr>";
//$aviso = stripslashes($_POST['aviso']); 
include('fun_protocolo.php');

function esMultiploDe10o15($numero) {
    return ($numero % 10 === 0) || ($numero % 15 === 0);
}

	$f_captura = date("Y-m-d");
	$h_captura = date("H:i:s");
	
	$sql_ter = "
	SELECT
		pacientes.paciente_id, 
		terapias.terapia_id
	FROM
		pacientes
		INNER JOIN
		terapias
		ON 
			pacientes.paciente_id = terapias.paciente_id
	WHERE
		pacientes.paciente_id = $paciente_id";
	//echo $sql_ter."<hr>"; 
	$result_protocolo=ejecutar($sql_ter); 				        
	$row_protocolo = mysqli_fetch_array($result_protocolo);
	    extract($row_protocolo);
	
	$sql = "
	SELECT
		pacientes.paciente_id,
		CONCAT(pacientes.paciente,' ',pacientes.apaterno,' ',pacientes.amaterno) as paciente,
		sum(sesiones.sesiones) as sesiones
	FROM
		pacientes
		INNER JOIN sesiones ON pacientes.paciente_id = sesiones.paciente_id
		INNER JOIN protocolo_terapia ON sesiones.protocolo_ter_id = protocolo_terapia.protocolo_ter_id
		INNER JOIN terapias ON sesiones.terapia_id = terapias.terapia_id 
		AND pacientes.paciente_id = terapias.paciente_id 
	WHERE
		pacientes.paciente_id = $paciente_id
		GROUP BY 1,2 ";                       	
	//echo $sql."<hr>"; 
	$result_protocolo=ejecutar($sql); 				        
	$row_protocolo = mysqli_fetch_array($result_protocolo);
	$cnt_protocolo = mysqli_num_rows($result_protocolo);
	if ($cnt_protocolo<>0) {
		extract($row_protocolo);
	}
	    

	$sql = "
	SELECT
		metricas.metricas_id
	FROM
		metricas
	WHERE
		metricas.paciente_id = $paciente_id";                       	
	//echo $sql."<br>"; 
	$result_protocolo=ejecutar($sql); 				        
	$cnt_mtc = mysqli_num_rows($result_protocolo);
	
	//echo $total_sesion."<hr>";
	
	if ($cnt_mtc == 0 ) {
		$total_sesion = 0; 
	}

//echo $total_sesion."<hr>";

	if ($total_sesion == 0) { ?>
	<div>
		<h1>Primer sesión</h1><hr>
		                            
    	<input name="paciente_id" type="hidden" id="paciente_id" value="<?php echo $paciente_id; ?>" /> 	
		<input name="paciente" type="hidden" id="paciente" value="<?php echo $paciente; ?>" />
		<input name="total_sesion" type="hidden" id="total_sesion" value="1" />
		<input name="prot_terapia" type="hidden" id="prot_terapia" value="<?php echo $prot_terapia; ?>" />
		<input name="protocolo_ter_id" type="hidden" id="protocolo_ter_id" value="<?php echo $protocolo_ter_id; ?>" />
		<input name="terapia_id" type="hidden" id="terapia_id" value="<?php echo $terapia_id; ?>" />
		<input name="tipo" type="hidden" id="tipo" value="inicial" />
		
		<h3>Paciente No. <?php echo $paciente_id." ".$paciente ?></h3>                      
	    <hr>
	    <div>
	    	<h1>MEDIDAS CEFÁLICAS</h1><br>	
		</div><hr>
	    <div>
	    	<h4>NASION-INION *</h4><br>								
	        <div class="form-group form-float">
	            <div class="form-line">                 
	                <input class="form-control" name="nasion" type="number" id="nasion" placeholder='NASION-INION' value="" required/>                
	        	</div> 
	    	</div>
		</div><hr>
	    <div>
	    	<h4>TRAGO-TRAGO *</h4><br>								
	        <div class="form-group form-float">
	            <div class="form-line"> 	                
	                <input class="form-control" name="trago" type="number" id="trago" placeholder='TRAGO-TRAGO' value="" required/>                
	        	</div> 
	    	</div>
		</div><hr>
	    <div>
	    	<h4>CIRCUNFERENCIA CEFÁLIA *</h4><br>								
	        <div class="form-group form-float">
	            <div class="form-line">               
	                <input class="form-control" name="circunferencia_cef" type="number" id="circunferencia_cef"  placeholder='CIRCUNFERENCIA CEFÁLIA' value="" required/>                
	        	</div> 
	    	</div>
		</div><hr>
	    <div>
	    	<h4>BEAM F3</h4><br>								
	        <div id="forma_otros" class="form-line">
	            <a target="_b" class="btn btn-info" href="https://clinicalresearcher.org/F3/" role="button">Ir a sitio</a>                
	    	</div>
		</div><hr>
	    <div>
	    	<h4>X *</h4><br>								
	        <div class="form-group form-float">
	            <div class="form-line"> 	                
	                <input class="form-control" name="x" type="number" id="x"  placeholder='X' value="" required/>                
	        	</div> 
	    	</div>
		</div><hr>  
	    <div>
	    	<h4>Y *</h4><br>								
	        <div class="form-group form-float">
	            <div class="form-line"> 	                
	                <input class="form-control" name="y" type="number" id="y" placeholder='Y' value="" required/>                
	        	</div> 
	    	</div>
		</div><hr>
	    <div>
	    	<h4>UMBRAL MOTOR EN REPOSO *</h4><br>								
	        <div class="form-group form-float">
	            <div class="form-line"> 	                
	                <input class="form-control" name="umbral" type="number" id="umbral"  placeholder='UMBRAL MOTOR EN REPOSO'  value="" required/>                
	        	</div> 
	    	</div>
		</div><hr>	
        <div class='form-group form-float'>
        	<h4>OBSERVACIONES </h4><br>
            <div class='form-line'>
                <textarea class='form-control' id='observaciones' name='observaciones' rows='3' placeholder='OBSERVACIONES' ></textarea>               
            </div>
        </div>	
		<hr>  	                                  
  		<div class="row clearfix demo-button-sizes">
	    	<div id="boton_cnt" style="display: none" class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
	    		<button id="captura" type="button" " class="btn bg-<?php echo $body; ?> btn-block btn-lg waves-effect">CONTINUAR</button>
	    		<button id="submit_test" type="submit" style="display: none" class="btn bg-<?php echo $body; ?> btn-block btn-lg waves-effect">CONTINUAR</button>
			</div>	
		</div> 
	        <script>
		        $('#captura').click(function(){               
		        	//alert("test"); 
				        var emptyFields = $('#guarda_protocolo_ini').find('input[required], select[required], textarea[required]').filter(function() {
				            return this.value === '';
				        });
				        if (emptyFields.length > 0) {
				            emptyFields.each(function() {
				            $('#submit_test').click();
				                //alert('El campo ' + this.name + ' está vacío.');
				            });
				        }else{ 				        	
				        	var datastring = $('#guarda_protocolo_ini').serialize();
		                	$('#contenido').html('');
							$.ajax({
			                    url: 'guarda_captura.php', 
			                    type: 'POST',
			                    data: datastring,
			                    cache: false,
			                    success:function(html){	                    	     
					                $.ajax({
					                    url: 'test_captura_protocolo.php',
					                    type: 'POST',
					                    data: datastring,
					                    cache: false,
					                    success:function(html){	                    	     
					                        $('#contenido').html(html); 
					                        // alert('Test');
					                        //$('#load1').hide();
					                        //$('#muestra_asegurado').click();  
					                    }
					            	}); 
			                    }
			            	});		                	
			        	}	        
		        });  
        	</script>	
	</div>	
<?php
	
} else {
		
?>



    <div class="demo-switch">
    	<h3>Protocolo con Clinimetria</h3>
        <div class="switch">
            <label>NO<input id="col-encuestas" name="col-encuestas" type="checkbox" ><span class="lever switch-col-<?php echo $body; ?>"></span>SI</label>
        </div>
    </div>
        <script type='text/javascript'>
            $('#col-encuestas').click(function(){
			    if ($("#col-encuestas").prop("checked")) {
			      $('#mod-encuestas').show();
			      $('#val_obser_enc').val('');
			    } else {
			      $('#mod-encuestas').hide();
			      $('#val_obser_enc').val('ok');
			    }	                    
            });
        </script> 
	<div id="mod-encuestas" style="display: none">
		<form id="encuesta_protocolo_ini" method="POST"  >  
            <h4>Selecciona</h4><br>	
            <input style='height: 0px; width: 0px' name="val_obser" type="text" id="val_obser_enc" value="ok" required/>
            <div class="demo-checkbox">  

				<?php

			    $sql = " 
					SELECT
						encuestas.encuesta_id,
						encuestas.encuesta,
						encuestas.descripcion,
						(SELECT
						GROUP_CONCAT( CONCAT('\$(\"#md_encuesta_',encuestas.encuesta_id,'\").prop(\"checked\")') SEPARATOR ' || ' ) AS encuesta 
					FROM
						encuestas) as enc_scrip
					FROM
						encuestas 
					ORDER BY
						encuesta ASC			    		    
			    ";
				$result_sql=ejecutar($sql);
			    
			    while($row_sql = mysqli_fetch_array($result_sql)){
			        extract($row_sql);	
				?>  	          	
                <input type="checkbox" id="md_encuesta_<?php echo $encuesta_id; ?>" name="encuestas[]" value="<?php echo $encuesta_id; ?>" class="filled-in chk-col-<?php echo $body; ?>" />
                <label for="md_encuesta_<?php echo $encuesta_id; ?>"  data-toggle="tooltip" data-placement="top" title="<?php echo $descripcion; ?>" >
                	
                	<?php echo $encuesta; ?></label>
                    <script type='text/javascript'>
		                $('#md_encuesta_<?php echo $encuesta_id; ?>').click(function(){		              	
						    if (<?php echo $enc_scrip; ?>) {
						      $('#val_obser_enc').val('ok');
						      $("#ini_protocolo2").prop("disabled", false);
						    } else {
						      $('#val_obser_enc').val('');
						      $("#ini_protocolo2").prop("disabled", true);
						    }		                    
		                });
		            </script> 
				<?php
					}
				echo "<hr>";

				?>

			</div>
		</form>		
		<button id="ini_protocolo2"  name="ini_protocolo2" type="button" class='btn bg-<?php echo $body; ?> waves-effect' disabled>Cargar Clinimetrias</button>
        <script>
	        $('#ini_protocolo2').click(function(){ 
	        	//alert("test");			        	
	        	$('#load_1').show();
	        	var datastring = $('#encuesta_protocolo_ini').serialize();
            	$('#div_encuesta').html('');
				$.ajax({
                    url: 'encuestas.php',
                    type: 'POST',
                    data: datastring,
                    cache: false,
                    success:function(html){	                    	     
                        $('#div_encuesta').html(html); 
                       // alert('Test');
                        $('#load_1').hide();
                        //$('#muestra_asegurado').click();
                    }
            	});		                		        
	        });  
    	</script>		
	</div>
	<div>
		<hr>
		<h1>Sesión <?php echo $total_sesion ?></h1>
        <?php if (esMultiploDe10o15($total_sesion) || $total_sesion ==1) { ?>
	        <div class="alert bg-deep-orange alert-dismissible" role="alert">
	            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	            <h2>Sesión <?php echo $total_sesion ?></h2> En algunos protocolos se recomienda generar encuesta en esta sesión  
	        </div>
        <?php } ?>        		
		<hr>
		<!-- <input type="" /> -->
		<h4>EQUIPO*</h4><br>
		<?php
		
		$sql = "
			SELECT DISTINCT
				equipos.equipo_id, 
				equipos.equipo, 
				equipos.modelo
			FROM
				equipos
			ORDER BY
				2 DESC, 3 ASC ";
				$result = ejecutar($sql); 
				$pregunta = "
					<select id='equipo_ter_id' name='equipo_ter_id' class='form-control show-tick' required>
						<option value=''>Selecciona un Equipo</option>
					        ";
		        $cnt=0;
		    while($row = mysqli_fetch_array($result)){
		        extract($row);
				$pregunta .= "	        	  
			            <option value='$equipo_id'>$equipo - $modelo</option>";				 				                    	    	
			}
				$pregunta .= "</select><hr>";
				echo $pregunta;
?>	



		<input name="protocolo_ter_id" type="hidden" id="protocolo_ter_id" value="<?php echo $protocolo_ter_id; ?>" />
		<input name="terapia_id" type="hidden" id="terapia_id" value="<?php echo $terapia_id; ?>" />
		<input name="paciente_id" type="hidden" id="paciente_id" value="<?php echo $paciente_id; ?>" /> 	
		<input name="paciente" type="hidden" id="paciente" value="<?php echo $paciente; ?>" />
		<input name="total_sesion" type="hidden" id="total_sesion" value="<?php echo $total_sesion; ?>" />
		<input name="prot_terapia" type="hidden" id="prot_terapia" value="<?php echo $prot_terapia; ?>" />
		<input name="tipo" type="hidden" id="tipo" value="protocolo_nuevo" />
	
	    <script>
	        $('#equipo_ter_id').change(function(){ 
	        	//alert('Test'); 
	            var equipo_ter_id = $('#equipo_ter_id').val();
	            var datastring = 'equipo_ter_id='+equipo_ter_id;
	            $('#protocolo_correspondiente').html('');
	            $.ajax({
	                url: 'protocolo_correspondiente.php',
	                type: 'POST',
	                data: datastring,
	                cache: false,
	                success:function(html){
	                	//alert('Se modifico correctemente');       
	                    $('#protocolo_correspondiente').html(html); 
						$('#general').show();
						$('#continuar').show();
						
	                }
	        	});
	        });
	    </script>
	</div>		
	<div id="protocolo_correspondiente"></div>		
	<div style="display: none" id="general">		
		<hr>
		<br>
        <h4>¿Presento al efecto adverso?</h4><br>								
        <div class="demo-radio-button">
        	<input style='height: 0px; width: 0px' name="val_adverso" type="text" id="val_adverso" value="" required/>
            <input name="adverso" type="radio" id="radio_1" value="Si" class='radio-col-<?php echo $body; ?>' />
            <label for="radio_1">Si</label>
          	<script type='text/javascript'>
                $('#radio_1').change(function(){
                	//alert($('#respuesta_1').val());
					var respuesta_1 = $('#radio_1').val();
                    $('#val_adverso').val('si');
                    $('#obserx').show();
                    $("#val_obser").prop('required', true);
                });
            </script>          
            <input name="adverso" type="radio" id="radio_2" value="No" class='radio-col-<?php echo $body; ?>'/>
            <label for="radio_2">No</label>
          	<script type='text/javascript'>
                $('#radio_2').change(function(){
                	//alert($('#respuesta_1').val());
					var respuesta_1 = $('#radio_2').val();
                    $('#val_adverso').val('no');
                    $('#obserx').hide();
                    $("#val_obser").prop('required', false);
                });
            </script>                 
        </div>
        <div style="display: none" id="obserx">
            <HR>
            <h4>Selecciona</h4><br>	
            <input style='height: 0px; width: 0px' name="val_obser" type="text" id="val_obser" value="" required/>
            <div class="demo-checkbox">             	
	                
				<?php
	
			    $sql = " 	    
					SELECT
						adversos.adversos_id, 
						adversos.adverso,
							(SELECT
						GROUP_CONCAT( CONCAT('\$(\"#md_checkbox_',adversos.adversos_id,'\").prop(\"checked\")') SEPARATOR ' || ' ) AS encuesta 
					FROM
						adversos) as adv_scrip
					FROM
						adversos
					ORDER BY
						adverso ASC				    		    
			    ";
				$result_sql=ejecutar($sql);
			    
			    while($row_sql = mysqli_fetch_array($result_sql)){
			        extract($row_sql);	
				?>
	
	        	          	
	            <input type="checkbox" id="md_checkbox_<?php echo $adversos_id; ?>" name="adversos[]" value="<?php echo $adverso; ?>" class="filled-in chk-col-<?php echo $body; ?>" />
	            <label for="md_checkbox_<?php echo $adversos_id; ?>"><?php echo $adverso; ?></label>
	                <script type='text/javascript'>
		                $('#md_checkbox_<?php echo $adversos_id; ?>').click(function(){
		                	
						    if (<?php echo $adv_scrip; ?>) {
						      $('#val_obser').val('ok');
						    } else {
						      $('#val_obser').val('');
						    }		                    
		                });
		            </script> 
				<?php } ?>                               
				<hr>
	            <script type='text/javascript'>
	                $('#md_checkbox_7').click(function(){
						if ($("#md_checkbox_7").prop("checked")) {
					      $('#div_otros').show();
					      $("#div_otros").prop('required', true);
					    } else {
					      $('#div_otros').hide();
					      $("#div_otros").prop('required', false);
					    }							    		                    
	                });
	            </script>
		        <div  style="display: none" id="div_otros">   
			        <label for="md_checkbox_des">Describe otros</label>    
			        <input type="text" id="otros" name="otros"  class="form-control" />                                                                                   
	        	</div>
	    	</div>            	
	    </div>		
		<hr>		
	    <div class='form-group form-float'>
	    	<h4>OBSERVACIONES *</h4><br>
	        <div class='form-line'>
	            <textarea class='form-control' id='observaciones' name='observaciones' rows='3' placeholder='OBSERVACIONES' required></textarea>
	            
	        </div>
	    </div>
	</div> 
    <div style="display: none" align="center" id="load_1">
        <div class="preloader pl-size-xl">
            <div class="spinner-layer">
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
        <h3>Cargando...</h3>			                        	
    </div> 	
	<div id="div_encuesta" ></div>		
		<?php	
	
}

?>
		<hr>
  		<div style="display: none" id="continuar" class="row clearfix demo-button-sizes">
	    	<div id="boton_cnt" class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
	    		<button id="captura1" type="submit" class="btn bg-<?php echo $body; ?> btn-block btn-lg waves-effect">CONTINUAR</button>
	    		<button id="submit_test" type="submit" style="display: none" class="btn bg-<?php echo $body; ?> btn-block btn-lg waves-effect">CONTINUAR</button>
			</div>	
	        <script>
		        $('#captura1').click(function(){ 
		        	//alert("test 1");
				        var emptyFields = $('#guarda_protocolo_ini').find('input[required], select[required], textarea[required]').filter(function() {
				            return this.value === '';
				        });
				        if (emptyFields.length > 0) {
				            emptyFields.each(function() {
				            	//alert('Test 3 '+emptyFields.length);
				            	
						      var fieldName = emptyFields.first().attr('name');
						      var fieldLabel = $('label[for="' + fieldName + '"]').text();
						
						      // Mostrar el mensaje con el nombre o etiqueta del campo vacío
						      alert('Por favor, complete el campo requerido: ' + fieldLabel);				            	
				            	
				            $('#submit_test').click();
				                //alert('El campo ' + this.name + ' está vacío.');
				            });
				        }else{ 				        	
				        	$('#load').show();
				        	var datastring = $('#guarda_protocolo_ini').serialize();
				        	//var datastring1 = $('#encuestas').val();
				        	var datastring1 = $('#encuesta_protocolo_ini').serialize();
		                	$('#contenido').html('');
		                	//alert(datastring);
							$.ajax({
			                    url: 'guarda_captura.php',
			                    type: 'POST',
			                    data:  datastring + '&' +datastring1 ,
			                    cache: false,
			                    success:function(html){	                    	     
			                        $('#contenido').html(html); 
			                        	// alert('Test 2');
			                        $('#load').hide();
			                        //$('#muestra_asegurado').click();
			                    }
			            	});		                	
			        	}	        
		        
		        });  
        	</script>			
		</div> 
</section>
</body>
</html>
