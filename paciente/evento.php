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

//print_r($_SESSION);
// echo "<hr>";
//$aviso = stripslashes($_POST['aviso']); 

$f_registro = date("Y-m-d");
$h_registro = date("H:i:s"); 

$sql = "
	SELECT
		agenda.agenda_id, 
		agenda.paciente_id, 
		agenda.usuario_id, 
		agenda.f_ini, 
		agenda.h_ini, 
		agenda.f_fin, 
		agenda.h_fin, 
		agenda.f_registro, 
		agenda.h_registro, 
		agenda.color, 
		CONCAT( pacientes.paciente, ' ', pacientes.apaterno, ' ', pacientes.amaterno ) AS paciente, 
		agenda.observ, 
		pacientes.email, 
		pacientes.celular, 
		admin.nombre
	FROM
		agenda
		INNER JOIN
		pacientes
		ON 
			agenda.paciente_id = pacientes.paciente_id
		INNER JOIN
		admin
		ON 
			pacientes.usuario_id = admin.usuario_id
	WHERE
		agenda.agenda_id = $id";
//echo $sql;
$result_insert = ejecutar($sql);
$row = mysqli_fetch_array($result_insert);
//echo "<hr>".$result_insert."<hr>";

extract($row);
//print_r($row);


?>


<form class="form-evento" method="POST" id="form_guarda_agenda" >
	<input type="hidden" id="agenda_id" name="agenda_id" value="<?php echo $agenda_id; ?>"/>
	<div class="modal-body">
		<div id="contenido"></div>
		<div class="form-group">
			<label for="title" class="col-sm-2 control-label">Titulo</label>

			<div class="col-sm-10">
				
		  		<select name="paciente_id" class='form-control show-tick' id="paciente_id" disabled required>
			  		<option <?php if($paciente_id == ''){ echo "selected";} ?> value="">Seleccionar</option>
						<?php
							$sql_paciente = "
								SELECT
									pacientes.paciente_id as paciente_idx, 
									CONCAT( pacientes.paciente, ' ', pacientes.apaterno, ' ', pacientes.amaterno ) AS pacientex
								FROM
									pacientes
								WHERE
									pacientes.estatus not in('No interezado','Seguimiento') 
								ORDER BY 2 asc";
							$result_paciente = ejecutar($sql_paciente);  
							$cnt_paciente = mysqli_num_rows($result_paciente);
							while($row_paciente = mysqli_fetch_array($result_paciente)){
				            extract($row_paciente); ?>
						<option <?php if($paciente_idx == $paciente_id){ echo "selected";} ?> value="<?php echo $paciente_idx; ?>" ><?php echo $paciente_idx.".- ".$pacientex; ?></option>
						<?php } ?>
				</select>
			</div>
			
			<div class="col-sm-12">
				<hr>
			</div>
			<label for="title" class="col-sm-2 control-label">Fecha inicio</label>
			<div class="col-sm-4">
			  	<input type="date" name="f_ini" class="form-control" id="f_ini" placeholder="Fecha inicio" value="<?php echo $f_ini; ?>" disabled required>
			  	<script>
			        $('#f_ini').change(function(){    
				        var f_ini = $('#f_ini').val();
				        $('#f_fin').val(f_ini);  
			        });  
	        	</script>
			</div>
	
			<label for="title" class="col-sm-2 control-label">Hora inicio</label>
			<div class="col-sm-4">
			  <input type="time" name="h_ini" class="form-control" id="h_ini" placeholder="Hora inicio" value="<?php echo $h_ini; ?>" disabled required>
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
			  <input type="date" name="f_fin" class="form-control" id="f_fin" placeholder="Fecha final" value="<?php echo $f_fin; ?>" disabled required>
			</div>
	
			<label for="title" class="col-sm-2 control-label">Hora final</label>
			<div class="col-sm-4">
			  <input type="time" name="h_fin" class="form-control" id="h_fin" placeholder="Hora final" value="<?php echo $h_fin; ?>" disabled required>
			</div>
			<div class="col-sm-12">
				<hr>
			</div>
			<label for="title" class="col-sm-2 control-label">Descripcion</label>
			<div class="col-sm-10">
	            <div class="form-line">
	                <textarea rows='4' id='observ' name='observ' class='form-control no-resize' placeholder='Descripcion' disabled required><?php echo $observ; ?></textarea>
	            </div>			
				
			  <!-- <input type="text" name="observ" class="form-control" id="observ" placeholder="Descripcion" value="<?php echo $observ; ?>"> -->
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
				<?php if ($funcion == 'SISTEMAS' || $funcion == 'ADMINISTRADOR' || $funcion == 'TECNICO' || $funcion == 'RECEPCION'  ) { ?>
				<button type="button" id="editar" class="btn bg-<?php echo $body; ?>"><i class="material-icons">mode_edit</i> Editar</button>
			  	<script>
			        $('#editar').click(function(){ 
			        	$('#f_ini').prop('disabled', false);
			        	$('#h_ini').prop('disabled', false);
			        	$('#f_fin').prop('disabled', false);
			        	$('#h_fin').prop('disabled', false);
			        	$('#paciente_id').prop('disabled', false);
			        	$('#observ').prop('disabled', false);   
  						$('#guarda_agenda').show();
  						$('#protocolo').hide();
  						$('#datos').hide();
  						$('#correo').hide();
  						$('#whatsapp').hide();
  						$('#editar').hide();
  						$('#eliminar').hide();
  						$('#close').hide();
			        });  
	        	</script>
	        	<?php } ?>
	        	<?php if ($funcion == 'SISTEMAS' || $funcion == 'ADMINISTRADOR' || $funcion == 'TECNICO' ) { ?>
				<a id="protocolo" class='btn bg-<?php echo $body; ?> waves-effect'href='../protocolo/protocolo.php?paciente_id=<?php echo $paciente_id; ?>' role='button'><i class="material-icons">send</i> Iniciar Protocolo</a>
				
				<a id="datos" class="btn bg-<?php echo $body; ?> waves-effect" href="<?php echo $ruta; ?>paciente/info_paciente.php?paciente_id=<?php echo $paciente_id; ?>">
					<i class="material-icons">description</i>Datos
				</a>
				<button id="correo" type="button" class="btn bg-<?php echo $body; ?>" ><i class="material-icons">email</i>Correo</button>
		        <script>
			        $('#correo').click(function(){    
			        	//alert("test");			        	
			        	var datastring = $('#form_guarda_agenda').serialize();
			        	//alert(datastring)
	                	$('#guardado').html('');
	                	$('#load').show();
                        
                        $('#cerrar').hide();
                        $('#guarda_agenda').hide();
  						$('#protocolo').hide();
  						$('#datos').hide();
  						$('#correo').hide();
  						$('#whatsapp').hide();
  						$('#editar').hide();
  						$('#eliminar').hide();
  						               	
						$.ajax({
		                    url: 'confirma_agenda.php',
		                    type: 'POST',
		                    data: datastring,
		                    cache: false,
		                    success:function(html){	                    	     
		                        $('#guardado').html(html);
		                        $('#load').hide(); 
		                        //alert(html);

		                    }
		            	});		                	        
			        });  
	        	</script>			
				<a id="whatsapp" class="btn bg-<?php echo $body; ?> waves-effect"  target="_blank" href="https://api.whatsapp.com/send?phone=52<?php echo $celular; ?>&text=Buen día <?php echo $paciente; ?> enviamos este mensaje para recordarle la cita del d&iacute;a <?php $f_ini = strftime("%A %e de %B del %Y",strtotime($f_ini)); echo $f_ini; ?> a las <?php echo $h_ini; ?> para su Terapia Electromagn&eacute;tica Transcraneal Atte. Neuromodulación Gdl">
					<img align="left" border="0" src="<?php echo $ruta; ?>images/WhatsApp.png"  style="width: 25px;  " >
			 	</a>
			 	<?php } ?>
			</div>
			<div class="col-sm-12">
				<hr><br>
			</div>
	        	
	        	<?php if ($funcion == 'SISTEMAS' || $funcion == 'ADMINISTRADOR' || $funcion == 'TECNICO' ) { ?>			
			<div class="col-sm-12"> 		  	
			  	<button type="button" id="eliminar" class="btn btn-danger"><i class="material-icons">delete_forever</i>Eliminar</button>
		        <script>
			        $('#eliminar').click(function(){    
			        	//alert("test");			        	
			        	var datastring = $('#form_guarda_agenda').serialize();
			        	//alert(datastring)
	                	$('#guardado').html('');
	                	$('#load').show();
                        
                        $('#cerrar').hide();
                        $('#guarda_agenda').hide();
  						$('#protocolo').hide();
  						$('#datos').hide();
  						$('#correo').hide();
  						$('#whatsapp').hide();
  						$('#editar').hide();
  						$('#eliminar').hide();
  						$('#close').hide();	                	
						$.ajax({
		                    url: 'elimina_agenda.php',
		                    type: 'POST',
		                    data: datastring,
		                    cache: false,
		                    success:function(html){	                    	     
		                        $('#guardado').html(html);
		                        $('#load').hide(); 
		                        //alert(html);

		                    }
		            	});		                	        
			        });  
	        	</script>	
	        			<?php } ?>  	
				<button id="close" type="button" class="btn btn-info" data-dismiss="modal"><i class="material-icons">close</i>Cerrar</button>
				<button style="display: none" type="button" id="guarda_agenda" name="guarda_agenda" class="btn btn-success"><i class="material-icons">save</i>Guardar</button>
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
			                    url: 'modifica_agenda.php',
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

	  <!-- <div class="form-group">
		<label for="color" class="col-sm-2 control-label">Color</label>
		<div class="col-sm-10">
		  <select name="color" class='form-control show-tick' id="color">
			  <option value="">Seleccionar</option>
			  <option style="color:#0071c5;" value="#0071c5">&#9724; Azul oscuro</option>
			  <option style="color:#40E0D0;" value="#40E0D0">&#9724; Turquesa</option>
			  <option style="color:#008000;" value="#008000">&#9724; Verde</option>						  
			  <option style="color:#FFD700;" value="#FFD700">&#9724; Amarillo</option>
			  <option style="color:#FF8C00;" value="#FF8C00">&#9724; Naranja</option>
			  <option style="color:#FF0000;" value="#FF0000">&#9724; Rojo</option>
			  <option style="color:#000;" value="#000">&#9724; Negro</option>
			  
			</select>
		</div> -->