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
extract($_SESSION);
extract($_POST);
//print_r($_POST);
 echo "<hr>";


$f_registro = date("Y-m-d");
$h_registro = date("H:i:s"); 

?>


<form id="form_guarda_agenda" class="form-evento" method="POST" >
	<input type="hidden" id="agenda_id" name="agenda_id"  value="<?php echo $agenda_id; ?>"/>
		<div class="modal-body">
			<h3 align="center">Agrega Cita</h3>
			<div class="form-group">
			<label for="color" class="col-sm-2 control-label">Paciente</label>
			<div class="col-sm-10">
		  		<select name="paciente_id" class='form-control show-tick' id="paciente_id" required>
			  		<option <?php if($paciente_id == ''){ echo "selected";} ?> value="">Seleccionar</option>
						<?php
							$sql_paciente = "
								SELECT
									pacientes.paciente_id as paciente_idx, 
									CONCAT( pacientes.paciente, ' ', pacientes.apaterno, ' ', pacientes.amaterno ) AS paciente
								FROM
									pacientes
								WHERE
									pacientes.estatus not in('No interezado') and pacientes.empresa_id = $empresa_id
								ORDER BY 2 asc";
							$result_paciente = ejecutar($sql_paciente);  
							$cnt_paciente = mysqli_num_rows($result_paciente);
							while($row_paciente = mysqli_fetch_array($result_paciente)){
				            extract($row_paciente); ?>
						<option <?php if($paciente_idx == $paciente_id){ echo "selected";} ?> value="<?php echo $paciente_idx; ?>" ><?php echo $paciente; ?></option>
						<?php } ?>
				</select>
			</div>	
			<div class="col-sm-12">
				<hr>
			</div>
			<label for="title" class="col-sm-2 control-label">Fecha inicio</label>
			<div class="col-sm-4">
			  	<input type="date" name="f_ini" class="form-control" id="f_ini" placeholder="Fecha inicio" value="<?php echo $f_ini; ?>" required>
		        <script>
			        $('#f_ini').change(function(){    
				        var f_ini = $('#f_ini').val();
				        $('#f_fin').val(f_ini);  
			        });  
	        	</script>			
			</div>

			<label for="title" class="col-sm-2 control-label">Hora inicio</label>
			<div class="col-sm-4">
			  <input type="time" name="h_ini" class="form-control" id="h_ini" placeholder="Hora inicio" value="<?php echo $h_ini; ?>" required>
		        <script>
			        $('#h_ini').change(function(){    

				        var hora = $('#h_ini').val();
				        var horaNueva = sumarMinutos(hora, 30);
				        $('#h_fin').val(horaNueva);

				
				      function sumarMinutos(hora, minutos) {
				        var partes = hora.split(':');
				        var horaActual = parseInt(partes[0]);
				        var minutoActual = parseInt(partes[1]);
				
				        var nuevaHora = horaActual;
				        var nuevoMinuto = minutoActual + minutos;
				
				        if (nuevoMinuto >= 60) {
				          nuevaHora += Math.floor(nuevoMinuto / 60);
				          nuevoMinuto = nuevoMinuto % 60;
				        }
				
				        var horaFormateada = ('0' + nuevaHora).slice(-2);
				        var minutoFormateado = ('0' + nuevoMinuto).slice(-2);
				
				        return horaFormateada + ':' + minutoFormateado;
				      }				        
				         
			        });  
	        	</script>
			</div>
			<div class="col-sm-12">
				<hr>
			</div>
			<label for="title" class="col-sm-2 control-label">Fecha final</label>
			<div class="col-sm-4">
			  <input type="date" name="f_fin" class="form-control" id="f_fin" placeholder="Fecha final" value="<?php echo $f_fin; ?>" required>
			</div>
	
			<label for="title" class="col-sm-2 control-label">Hora final</label>
			<div class="col-sm-4">
			  <input type="time" name="h_fin" class="form-control" id="h_fin" placeholder="Hora final" value="<?php echo $h_fin; ?>" required>
			</div>
			<div class="col-sm-12">
				<hr>
			</div>
			<label for="title" class="col-sm-2 control-label">Descripcion</label>
			<div class="col-sm-10">
	           <div class="form-line">
	                <textarea rows='4' id='observ' name='observ' class='form-control no-resize' placeholder='Descripcion' required><?php echo $observ; ?></textarea>
	            </div>
			</div>
			<div class="col-sm-12">
				<hr>
			</div>		
		</div>				  				  				  				  
	
	</div>
	<div id="guardado"></div>
	<div class="modal-footer">
		<div class="form-group"> 
			<div class="col-sm-12"> 		  	
				<button type="button" id="cerrar" class="btn btn-info" data-dismiss="modal"><i class="material-icons">close</i>Cerrar</button>
				<button type="button" id="guarda_agenda" class="btn btn-success"><i class="material-icons">save</i>Guardar</button>
				<button style="display: none" type="submit" id="submit_test" class="btn btn-success">submit_test</button>
		        <script>
			        $('#guarda_agenda').click(function(){    
			        	//alert("test");
				        var emptyFields = $('#form_guarda_agenda').find('input[required], select[required], textarea[required]').filter(function() {
				            return this.value === '';
				        });
				        if (emptyFields.length > 0) {
				            emptyFields.each(function() {
				            $('#submit_test').click();
				                //alert('El campo ' + this.name + ' está vacío.');
				            });
				        }else{ 				        	
				        	var datastring = $('#form_guarda_agenda').serialize();
				        	//alert(datastring)
		                	$('#guardado').html('');
		                	$('#load').show();
							$.ajax({
			                    url: 'guarda_agenda.php',
			                    type: 'POST',
			                    data: datastring,
			                    cache: false,
			                    success:function(html){	                    	     
			                        $('#guardado').html(html); 
			                        //alert(html);
			                        $('#load').hide();
			                        $('#cerrar').hide();
			                        $('#guarda_agenda').hide();
			                    }
			            	});		                	
			        	}	        
			        });  
	        	</script>					
			</div>
	  	</div>
	</div>
</form> 