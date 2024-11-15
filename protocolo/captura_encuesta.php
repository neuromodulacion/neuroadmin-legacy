<?php
include('../functions/funciones_mysql.php');
session_start();
error_reporting(7);
iconv_set_encoding('internal_encoding', 'utf-8'); 
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Monterrey');
setlocale(LC_TIME, 'es_ES.UTF-8');
$_SESSION['time']=mktime();

$ruta = "../";
extract($_POST);
// print_r($_POST);
 echo "<hr>";
extract($_SESSION);
// print_r($_SESSION);
// echo "<hr>";
//$aviso = stripslashes($_POST['aviso']); 
include('fun_protocolo.php');

$f_captura = date("Y-m-d");
$h_captura = date("H:i:s");

?>
		
		<h1>Comienza la sesión <?php echo $total_sesion ?> y cuestionario</h1>
		<h4>TERAPIA *</h4><br>
<?php

$sql = "
	SELECT
		protocolo_terapia.protocolo_ter_id, 
		protocolo_terapia.prot_terapia
	FROM
		protocolo_terapia";
		$result = ejecutar($sql); 
		$pregunta = "
			<select id='protocolo_ter_id' name='protocolo_ter_id' class='form-control show-tick' required>
				<option value=''>Seleccina una Terapia</option>
			        ";
        $cnt=0;
    while($row = mysqli_fetch_array($result)){
        extract($row);
		$pregunta .= "	        	  
	            <option value='$protocolo_ter_id'>$prot_terapia</option>";				 				                    	    	
	}
		$pregunta .= "</select><hr>";
		echo $pregunta;
?>
		<script>         
	        $('#protocolo_ter_id').change(function(){ 
	        	//alert('Test');         	
	        		var protocolo_ter_id = $('#protocolo_ter_id').val();
	        		var	tipo = 'encuesta';	
	        		var datastring = 'protocolo_ter_id='+protocolo_ter_id+'&tipo='+tipo;
	                $.ajax({
	                    url: 'guarda_captura.php',
	                    type: 'POST',
	                    data: datastring,
	                    cache: false,
	                    success:function(html){	                    	     
	                        $('#encuesta').html(html); 
	                        //alert('Test');
	                        //$('#load1').hide();
	                        //$('#muestra_asegurado').click();
	                    }
	            	}); 
				});
        </script>
    	<input name="paciente_id" type="hidden" id="paciente_id" value="<?php echo $paciente_id; ?>" /> 	
		<input name="paciente" type="hidden" id="paciente" value="<?php echo $paciente; ?>" />
		<input name="total_sesion" type="hidden" id="total_sesion" value="1" />
		<input name="prot_terapia" type="hidden" id="prot_terapia" value="<?php echo $prot_terapia; ?>" />
		<input name="tipo" type="hidden" id="tipo" value="preguntas_protocolo" />
		<!-- <input name="protocolo_ter_id" type="hidden" id="protocolo_ter_id" value="<?php echo $protocolo_ter_id; ?>" />		 -->
		
	    <div>
	    	
	    	<h4>UMBRAL MOTOR % *</h4><br>								
	        <div class="form-group form-float">
	            <div class="form-line"> 
	                
	                <input class="form-control" name="umbral" type="number" id="umbral" value="" placeholder="UMBRAL MOTOR %" required/>                
	        	</div> 
	    	</div>
		</div><hr>
		<div id="encuesta"></div>
		<hr>
            <h4>¿Presento al efecto adverso?</h4><br>								
            <div class="demo-radio-button">
            	<input style='height: 0px; width: 0px' name="val_adverso" type="text" id="val_adverso" value="" required/>
                <input name="adverso" type="radio" id="radio_1" value="Si" />
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
                <input name="adverso" type="radio" id="radio_2" value="No"/>
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
                    <input type="checkbox" id="md_checkbox_21" name="adversos[]" value="SENSIBILIDAD LOCAL" class="filled-in chk-col-<?php echo $body; ?>" />
                    <label for="md_checkbox_21">SENSIBILIDAD LOCAL</label>
	                    <script type='text/javascript'>
			                $('#md_checkbox_21').click(function(){
							    if ($("#md_checkbox_21").prop("checked") || $("#md_checkbox_22").prop("checked") || $("#md_checkbox_23").prop("checked") || $("#md_checkbox_24").prop("checked") || $("#md_checkbox_25").prop("checked") || $("#md_checkbox_26").prop("checked")) {
							      $('#val_obser').val('ok');
							    } else {
							      $('#val_obser').val('');
							    }		                    
			                });
			            </script> 
                    <input type="checkbox" id="md_checkbox_22" name="adversos[]" value="CEFALEA"  class="filled-in chk-col-<?php echo $body; ?>" />
                    <label for="md_checkbox_22">CEFALEA</label>
	                    <script type='text/javascript'>
			                $('#md_checkbox_22').click(function(){
							    if ($("#md_checkbox_21").prop("checked") || $("#md_checkbox_22").prop("checked") || $("#md_checkbox_23").prop("checked") || $("#md_checkbox_24").prop("checked") || $("#md_checkbox_25").prop("checked") || $("#md_checkbox_26").prop("checked")) {
							      $('#val_obser').val('ok');
							    } else {
							      $('#val_obser').val('');
							    }		                    
			                });
			            </script>                       
                    <input type="checkbox" id="md_checkbox_23" name="adversos[]" value="CONVULSIÓN"  class="filled-in chk-col-<?php echo $body; ?>" />
                    <label for="md_checkbox_23">CONVULSIÓN</label>
	                    <script type='text/javascript'>
			                $('#md_checkbox_23').click(function(){
							    if ($("#md_checkbox_21").prop("checked") || $("#md_checkbox_22").prop("checked") || $("#md_checkbox_23").prop("checked") || $("#md_checkbox_24").prop("checked") || $("#md_checkbox_25").prop("checked") || $("#md_checkbox_26").prop("checked")) {
							      $('#val_obser').val('ok');
							    } else {
							      $('#val_obser').val('');
							    }		                    
			                });
			            </script>                    
                    <input type="checkbox" id="md_checkbox_24" name="adversos[]" value="DOLOR"  class="filled-in chk-col-<?php echo $body; ?>" />
                    <label for="md_checkbox_24">DOLOR</label>  
	                    <script type='text/javascript'>
			                $('#md_checkbox_24').click(function(){
							    if ($("#md_checkbox_21").prop("checked") || $("#md_checkbox_22").prop("checked") || $("#md_checkbox_23").prop("checked") || $("#md_checkbox_24").prop("checked") || $("#md_checkbox_25").prop("checked") || $("#md_checkbox_26").prop("checked")) {
							      $('#val_obser').val('ok');
							    } else {
							      $('#val_obser').val('');
							    }		                    
			                });
			            </script>                    
                    <input type="checkbox" id="md_checkbox_25" name="adversos[]" value="MAREO"  class="filled-in chk-col-<?php echo $body; ?>" />
                    <label for="md_checkbox_25">MAREO</label>
	                    <script type='text/javascript'>
			                $('#md_checkbox_25').click(function(){
							    if ($("#md_checkbox_21").prop("checked") || $("#md_checkbox_22").prop("checked") || $("#md_checkbox_23").prop("checked") || $("#md_checkbox_24").prop("checked") || $("#md_checkbox_25").prop("checked") || $("#md_checkbox_26").prop("checked")) {
							      $('#val_obser').val('ok');
							    } else {
							      $('#val_obser').val('');
							    }		                    
			                });
			            </script>                    
                    <input type="checkbox" id="md_checkbox_26" name="adversos[]" value="OTROS"  class="filled-in chk-col-<?php echo $body; ?>" />
                    <label for="md_checkbox_26">OTROS</label>
	                    <script type='text/javascript'>
			                $('#md_checkbox_26').click(function(){
							    if ($("#md_checkbox_21").prop("checked") || $("#md_checkbox_22").prop("checked") || $("#md_checkbox_23").prop("checked") || $("#md_checkbox_24").prop("checked") || $("#md_checkbox_25").prop("checked") || $("#md_checkbox_26").prop("checked")) {
							      $('#val_obser').val('ok');
							    } else {
							      $('#val_obser').val('');
							    }
								if ($("#md_checkbox_26").prop("checked")) {
							      $('#div_otros').show();
							      $("#div_otros").prop('required', true);
							    } else {
							      $('#div_otros').hide();
							      $("#div_otros").prop('required', false);
							    }							    		                    
			                });
			            </script>
			         <div  style="display: none" id="div_otros">   
				        <label for="md_checkbox_26">Describe otros</label>    
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
		<hr>
  		<div class="row clearfix demo-button-sizes">
	    	<div id="boton_cnt" class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
	    		<button id="captura1" type="submit" class="btn bg-<?php echo $body; ?> btn-block btn-lg waves-effect">CONTINUAR</button>
	    		<button id="submit_test" type="submit" style="display: none" class="btn bg-<?php echo $body; ?> btn-block btn-lg waves-effect">CONTINUAR</button>
			</div>	
	        <script>
		        $('#captura1').click(function(){ 
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
				        	$('#load').show();
				        	var datastring = $('#guarda_protocolo_ini').serialize();
		                	$('#contenido').html('');
							$.ajax({
			                    url: 'guarda_captura.php',
			                    type: 'POST',
			                    data: datastring,
			                    cache: false,
			                    success:function(html){	                    	     
			                        $('#contenido').html(html); 
			                        //alert('Test');
			                        $('#load').hide();
			                        //$('#muestra_asegurado').click();
			                    }
			            	});		                	
			        	}	        
		        
		        });  
        	</script>			
		</div> 		