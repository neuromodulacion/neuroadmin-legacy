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
// echo "<hr>";
extract($_SESSION);
// print_r($_SESSION);
// echo "<hr>";
//$aviso = stripslashes($_POST['aviso']); 
include('fun_protocolo.php');

	$pregunta = "";

	$pregunta .= "
	<div><h4>PROTOCOLO *</h4><br>
		";
	$sql = "
		SELECT DISTINCT
			protocolo_terapia.protocolo_ter_id, 
			protocolo_terapia.prot_terapia, 
			protocolo_terapia.terapia
		FROM
			protocolo_terapia
				WHERE protocolo_terapia.estatus = 'Activo'
				AND protocolo_terapia.equipo_id = $equipo_ter_id";
		//echo $sql."<hr>";		
			$result = ejecutar($sql); 
			$pregunta .= "
			
				<select id='protocolo_ter_id' name='protocolo_ter_id' class='form-control show-tick' required>
					<option value=''>Selecciona un Protocolo</option>
				        ";
        $cnt=0;
    while($row = mysqli_fetch_array($result)){
        extract($row);
		$pregunta .= "	        	  
	            <option value='$protocolo_ter_id'>$prot_terapia</option>";				 				                    	    	
	}
		$pregunta .= "</select><hr>";


switch ($terapia) {
	case 'TMS':

	$pregunta .= "
			<div>	
			    <h4>UMBRAL MOTOR % *</h4><br>					
			    <div class='form-group form-float'>
			        <div class='form-line'> 
			            <input class='form-control' name='umbral' type='number' id='umbral' value='' placeholder='UMBRAL MOTOR %' required/>                
			        </div> 
			    </div>
			    <div class='checkbox'>
			        <label>
			            <input type='checkbox' id='umbral_new' name='umbral_new' value='ok' class='filled-in chk-col-$body' />
			            <span>Guarda nuevo valor de Umbral</span>
			        </label>
			    </div>	
			    <hr>	    
			    <div class='form-group'>
			        <label for='tms_cnt' class='col-sm-3 control-label'>Contador D:</label>
			        <div class='col-sm-9 form-line'>
			            <input type='text' class='form-control' id='tms_cnt' name='tms_cnt' value='0' placeholder='Contador D'>
			        </div>
			    </div>
			    <br>
			    <div class='form-group'>
			        <label for='tms_d' class='col-sm-3 control-label'>Contador N:</label>
			        <div class='col-sm-9 form-line'>
			            <input type='text' class='form-control' id='tms_d' name='tms_d' value='0' placeholder='Contador N'>
			        </div>
			    </div>
			    <br>
			</div>
";
	echo $pregunta;		
		break;
		

	case 'tDCS':

	$pregunta .= "
	    
	    	
    	<h4>ANODO *</h4><br>								
        <div >
            <div >   
			<select id='anodo' name='anodo' class='form-control show-tick' required>
				<option value=''>Selecciona una Posición</option>
				<option value='A1'>A1</option>
				<option value='A2'>A2</option>
				<option value='F3'>F3</option>
				<option value='F4'>F4</option>
				<option value='F7'>F7</option>
				<option value='F8'>F8</option>
				<option value='Fz'>Fz</option>
				<option value='C3'>C3</option>
				<option value='C4'>C4</option>
				<option value='Cz'>Cz</option>
				<option value='WR'>WR</option>
				<option value='BR'>BR</option>
				<option value='Fp1'>Fp1</option>
				<option value='Fp2'>Fp2</option>
				<option value='O1'>O1</option>
				<option value='O2'>O2</option>
				<option value='Pz'>Pz</option>
				<option value='P3'>P3</option>
				<option value='P4'>P4</option>
				<option value='V1'>V1</option>
				<option value='T3'>T3</option>
				<option value='T4'>T4</option>
				<option value='T5'>T5</option>
				<option value='T6'>T6</option>
				<option value='Hombro derecho<'>Hombro derecho</option>
	        </select><hr>
    	<h4>CATODO *</h4><br>								
        <div >
            <div >   
			<select id='catodo' name='catodo' class='form-control show-tick' required>
				<option value=''>Selecciona una Posición</option>
				<option value='A1'>A1</option>
				<option value='A2'>A2</option>
				<option value='F3'>F3</option>
				<option value='F4'>F4</option>
				<option value='F7'>F7</option>
				<option value='F8'>F8</option>
				<option value='Fz'>Fz</option>
				<option value='C3'>C3</option>
				<option value='C4'>C4</option>
				<option value='Cz'>Cz</option>
				<option value='WR'>WR</option>
				<option value='BR'>BR</option>
				<option value='Fp1'>Fp1</option>
				<option value='Fp2'>Fp2</option>
				<option value='O1'>O1</option>
				<option value='O2'>O2</option>
				<option value='Pz'>Pz</option>
				<option value='P3'>P3</option>
				<option value='P4'>P4</option>
				<option value='V1'>V1</option>
				<option value='T3'>T3</option>
				<option value='T4'>T4</option>
				<option value='T5'>T5</option>
				<option value='T6'>T6</option>
				<option value='Hombro derecho<'>Hombro derecho</option>
	        </select>	<hr>
	            <div class='demo-switch'>
		    	<h4>POLARIDAD</h4>
		        <div class='switch'>
		            <label>Normal<input id='polaridad_id'  type='checkbox' ><span class='lever switch-col-$body'></span>Inversa</label>
		            <input type='hidden' id='polaridad' name='polaridad' value='Normal'>
		            <script type='text/javascript'>
			            $('#polaridad_id').click(function(){
						    if ($('#polaridad').prop('checked')) {
						      $('#polaridad').val('Inversa');
						    } else {
						      $('#polaridad').val('Normal');
						    }	                    
			            });
			        </script>		            
		        </div>
		    </div>
			        ";				
    

                
    $pregunta .= "
         	</div> 
    	</div>
	  		      	
	</div>";
		
	echo $pregunta;			
		break;
}



?>