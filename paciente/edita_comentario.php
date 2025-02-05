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

//include('../uso.php');

	extract($_POST);

switch ($option) {
	case 'guarda': 
		
		$update ="
		UPDATE historico_sesion
		SET
			historico_sesion.observaciones = '$observaciones',
			historico_sesion.protocolo_ter_id = '$protocolo_ter_id' 
		WHERE 
			historico_sesion.historico_id = $historico_id
		";
	
		 echo "<hr>".$update."<hr>";
		$result_insert = ejecutar($update);		
		
		
		break;
	
	case 'trae':
		
		$sql = "
		SELECT
			historico_sesion.historico_id,
			historico_sesion.observaciones, 
			historico_sesion.protocolo_ter_id, 
			protocolo_terapia.equipo_id
		FROM
			historico_sesion
			INNER JOIN protocolo_terapia ON historico_sesion.protocolo_ter_id = protocolo_terapia.protocolo_ter_id 
		WHERE
			historico_sesion.historico_id = $historico_id"; 
		//echo $sql."<hr>";
			
		$result_insert = ejecutar($sql);
			 
		$row = mysqli_fetch_array($result_insert);
		extract($row);
		?>
		


	<div><h4>PROTOCOLO *</h4><br>
		<?php
			$sql = "
				SELECT
					protocolo_terapia.protocolo_ter_id as protocolo_ter_idx, 
					protocolo_terapia.prot_terapia
				FROM
					protocolo_terapia
						WHERE protocolo_terapia.estatus = 'Activo'
						AND protocolo_terapia.equipo_id = $equipo_id";
				//echo $sql."<hr>";		
					$result = ejecutar($sql); 
		?>
			
		<select id='protocolo_ter_id_<?php echo $historico_id; ?>' name='protocolo_ter_id_<?php echo $historico_id; ?>' class='form-control show-tick' required>
			<option value=''>Selecciona un Protocolo</option>

			<?php
			    while($row = mysqli_fetch_array($result)){
			        extract($row); ?>				        	  
				    <option  <?php if($protocolo_ter_idx == $protocolo_ter_id){ echo "selected";} ?>  value='<?php echo $protocolo_ter_idx; ?>'><?php echo $prot_terapia ?></option>				 				                    	    	
			<?php	} ?>

		</select>
		
		<h3>Nota de evolución</h3>
		<fieldset>
		    <div class="form-group form-float">
		        <div class="form-line">
		            <textarea class="form-control" id="observaciones_<?php echo $historico_id; ?>" name="observaciones_<?php echo $historico_id; ?>" rows="3" ><?php echo $observaciones; ?></textarea>
		        </div>
		    </div> 
		</fieldset>
        <script type='text/javascript'>
            $('#guarda').click(function(){	
            	var option = 'guarda'
            	var historico_id = '<?php echo $historico_id; ?>'; 
            	var paciente_id = '<?php echo $paciente_id; ?>';
				var observaciones = $('#observaciones_<?php echo $historico_id; ?>').val();
				var protocolo_ter_id = $('#protocolo_ter_id_<?php echo $historico_id; ?>').val();
                var datastring = 'historico_id='+historico_id+'&paciente_id='+paciente_id+'&observaciones='+observaciones+'&option='+option+'&protocolo_ter_id='+protocolo_ter_id;
                //alert(datastring);
                $.ajax({
                    url: 'edita_comentario.php',
                    type: 'POST',
                    data: datastring,
                    cache: false,
                    success:function(html){ 
                    	//alert(html);  
                        window.location.href = "info_paciente.php?paciente_id=<?php echo $paciente_id; ?>";             
                    }
            	});
            });
        </script>
<?php		
		break;
}

