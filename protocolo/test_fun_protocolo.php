<?php


$ruta="../";

extract($_SESSION);

function elementos($protocolo_ter_id){

// include('../functions/funciones_mysql.php');

//$pregunta = "hola mundo";

	$sql_sem1 = "
		SELECT
			preguntas.pregunta_id, 
			preguntas.protocolo_ter_id, 
			preguntas.pregunta, 
			preguntas.respuesta_1, 
			preguntas.respuesta_2, 
			preguntas.respuesta_3, 
			preguntas.respuesta_4, 
			preguntas.respuesta_5, 
			preguntas.respuesta_6, 
			preguntas.respuesta_7, 
			preguntas.respuesta_8, 
			preguntas.respuesta_9, 
			preguntas.respuesta_10, 
			preguntas.tipo
		FROM
			preguntas
		WHERE
			preguntas.protocolo_ter_id = $protocolo_ter_id
	    ";
		//echo $sql_sem1."<hr>";
		$result_sem1 = ejecutar($sql_sem1); 
		$preguntas = "";
		$preguntasx = "";
        $cnt=0;
    while($row_sem1 = mysqli_fetch_array($result_sem1)){
        extract($row_sem1);
		//print_r($row_sem1);
		//echo "<hr>";
		$cnt++;
		//echo $tipo."<hr>";	
		switch ($tipo) {
			case 'radio': 
				$preguntas .= "<hr>
			        <h4>$cnt.- $pregunta</h4><br>								
			        <div class='demo-radio-button'>
			        	<input style='height: 0px; width: 0px' name='preg_$pregunta_id' type='text' id='preg_$pregunta_id' value='' required />  
			            <input name='pregunta_$pregunta_id' type='radio' id='respuesta_1$pregunta_id' value='$respuesta_1' />		            
			            <label for='respuesta_1$pregunta_id'>$respuesta_1</label>   
	            		<script type='text/javascript'>
	                            $('#respuesta_1$pregunta_id').click(function(){ $('#preg_$pregunta_id').val('ok'); });										
	                    </script>
			            <input name='pregunta_$pregunta_id' type='radio' id='respuesta_2$pregunta_id' value='$respuesta_2' />		            
			            <label for='respuesta_2$pregunta_id'>$respuesta_2</label>   
	            		<script type='text/javascript'>
	                            $('#respuesta_2$pregunta_id').click(function(){ $('#preg_$pregunta_id').val('ok'); });										
	                  </script>";
 				if ($respuesta_3 <> "" ) {
					$preguntas .= "
	 		            <input name='pregunta_$pregunta_id' type='radio' id='respuesta_3$pregunta_id' value='$respuesta_3' />		            
			            <label for='respuesta_3$pregunta_id'>$respuesta_3</label>   
	            		<script type='text/javascript'>
	                            $('#respuesta_3$pregunta_id').click(function(){ $('#preg_$pregunta_id').val('ok'); });										
	                    </script>";										 
				 }
 				if ($respuesta_4 <> "" ) {
					$preguntas .= "
	 		            <input name='pregunta_$pregunta_id' type='radio' id='respuesta_4$pregunta_id' value='$respuesta_4' />		            
			            <label for='respuesta_4$pregunta_id'>$respuesta_4</label>   
	            		<script type='text/javascript'>
	                            $('#respuesta_4$pregunta_id').click(function(){ $('#preg_$pregunta_id').val('ok'); });										
	                    </script>";										 
				 }                  
 				if ($respuesta_5 <> "" ) {
					$preguntas .= "
	 		            <input name='pregunta_$pregunta_id' type='radio' id='respuesta_5$pregunta_id' value='$respuesta_5' />		            
			            <label for='respuesta_5$pregunta_id'>$respuesta_5</label>   
	            		<script type='text/javascript'>
	                            $('#respuesta_5$pregunta_id').click(function(){ $('#preg_$pregunta_id').val('ok'); });										
	                    </script>";										 
				 }
 				if ($respuesta_6 <> "" ) {
					$preguntas .= "
	 		            <input name='pregunta_$pregunta_id' type='radio' id='respuesta_6$pregunta_id' value='$respuesta_6' />		            
			            <label for='respuesta_6$pregunta_id'>$respuesta_6</label>   
	            		<script type='text/javascript'>
	                            $('#respuesta_6$pregunta_id').click(function(){ $('#preg_$pregunta_id').val('ok'); });										
	                    </script>";										 
				 }				 
 				if ($respuesta_7 <> "" ) {
					$preguntas .= "
	 		            <input name='pregunta_$pregunta_id' type='radio' id='respuesta_7$pregunta_id' value='$respuesta_7' />		            
			            <label for='respuesta_7$pregunta_id'>$respuesta_7</label>   
	            		<script type='text/javascript'>
	                            $('#respuesta_7$pregunta_id').click(function(){ $('#preg_$pregunta_id').val('ok'); });										
	                    </script>";										 
				 }
 				if ($respuesta_8 <> "" ) {
					$preguntas .= "
	 		            <input name='pregunta_$pregunta_id' type='radio' id='respuesta_8$pregunta_id' value='$respuesta_8' />		            
			            <label for='respuesta_8$pregunta_id'>$respuesta_8</label>   
	            		<script type='text/javascript'>
	                            $('#respuesta_8$pregunta_id').click(function(){ $('#preg_$pregunta_id').val('ok'); });										
	                    </script>";										 
				 }
 				if ($respuesta_9 <> "" ) {
					$preguntas .= "
	 		            <input name='pregunta_$pregunta_id' type='radio' id='respuesta_9$pregunta_id' value='$respuesta_9' />		            
			            <label for='respuesta_9$pregunta_id'>$respuesta_9</label>   
	            		<script type='text/javascript'>
	                            $('#respuesta_9$pregunta_id').click(function(){ $('#preg_$pregunta_id').val('ok'); });										
	                    </script>";										 
				 }				 
 				if ($respuesta_10 <> "" ) {
					$preguntas .= "
	 		            <input name='pregunta_$pregunta_id' type='radio' id='respuesta_10$pregunta_id' value='$respuesta_10' />		            
			            <label for='respuesta_10$pregunta_id'>$respuesta_10</label>   
	            		<script type='text/javascript'>
	                            $('#respuesta_10$pregunta_id').click(function(){ $('#preg_$pregunta_id').val('ok'); });										
	                    </script>";										 
				 }				 				                     
		    	$preguntas .= "</div>";
		
				
				break;
			case 'select':
			$preguntas .= "<hr>
                    <div>
                    	<h4>$cnt.- $pregunta</h4><br>								
                        <div class='form-group form-float'>
                            
			                <select id='pregunta_$pregunta_id' name='pregunta_$pregunta_id' class='form-control show-tick'>
			                    <option value=''>-- Seleciona tipo de Respuesta --</option>
			                    <option value='$respuesta_1'>$respuesta_1</option>
			                    <option value='$respuesta_2'>$respuesta_2</option>";
				 				if ($respuesta_3 <> "" ) { $preguntas .= "<option value='$respuesta_3'>$respuesta_3</option>"; }			                    
							    if ($respuesta_4 <> "" ) { $preguntas .= "<option value='$respuesta_4'>$respuesta_3</option>"; }
							    if ($respuesta_5 <> "" ) { $preguntas .= "<option value='$respuesta_5'>$respuesta_3</option>"; }
								if ($respuesta_6 <> "" ) { $preguntas .= "<option value='$respuesta_6'>$respuesta_3</option>"; }
								if ($respuesta_7 <> "" ) { $preguntas .= "<option value='$respuesta_7'>$respuesta_3</option>"; }
								if ($respuesta_8 <> "" ) { $preguntas .= "<option value='$respuesta_8'>$respuesta_3</option>"; }
								if ($respuesta_9 <> "" ) { $preguntas .= "<option value='$respuesta_9'>$respuesta_3</option>"; }
								if ($respuesta_10 <> "" ) { $preguntas .= "<option value='$respuesta_10'>$respuesta_3</option>"; }                			                    			      
			      $preguntas .= "              
                            </select> 
                    	</div> 
                	</div>";			
				
				break;
		
			case 'text':
			$preguntas .= "<hr>
                    <div>
                    	<h4>$cnt.- $pregunta</h4><br>								
                        <div class='form-group form-float'>
                           
                            <input class='form-control' name='pregunta_$pregunta_id' type='text' id='pregunta_$pregunta_id' placeholder='$pregunta' value='' />
                             
                    	</div> 
                	</div>";				
				break;
			case 'textarea':
			$preguntas .= "<hr>			
                <div class='form-group form-float'>
                    <div class='form-line'>
                        <textarea class='form-control' id='observaciones$pregunta_id' name='observaciones$pregunta_id' rows='3' required></textarea>
                        <label class='form-label'>Observaciones</label>
                    </div>
                </div>";
				break;
		
			case 'date':
			$preguntas .= "<hr>
                    <div>
                    	<h4>$cnt.- $pregunta</h4><br>								
                        <div class='form-group form-float'>
                            <input class='form-control' name='pregunta_$pregunta_id' type='date' id='pregunta_$pregunta_id' placeholder='$pregunta'  value='' />
                             
                    	</div> 
                	</div>";				
				break;
			case 'number':
			$preguntas .= "<hr>
                    <div>
                    	<h4>$cnt.- $pregunta</h4><br>								
                        <div class='form-group form-float'>
                            <input class='form-control' name='pregunta_$pregunta_id' type='number' id='pregunta_$pregunta_id' placeholder='$pregunta'  value='' />
                             
                    	</div> 
                	</div>";				
				break;
		
			case 'titulo':
				
			$preguntas .= "<hr>
                    <div>
                    	<h1>$pregunta</h1><br>								
                	</div>";				
				break;
			case 'instrucciones':
				
			$preguntas .= "<hr>
                    <div>
                    	<h4>$cnt.- $pregunta</h4><br>
                    	<p>$respuesta_1</p><br>								
                	</div>";				
				break;
									
			default:
				
				break;
		}
		
			// echo $pregunta;
	}	
return $preguntas;
}


function crea($protocolo_ter_id){

$f_captura = date("Y-m-d");
$h_captura = date("H:i:s");

	$sql_sem1 = "
		SELECT
			preguntas.pregunta_id, 
			preguntas.protocolo_ter_id, 
			preguntas.tipo
		FROM
			preguntas
		WHERE
			preguntas.protocolo_ter_id = $protocolo_ter_id
			
	    ";
		echo $sql_sem1."<hr>";
		$result_sem1 = ejecutar($sql_sem1); 
		$preguntas = "
		CREATE TABLE base_protocolo_$protocolo_ter_id (
			base_id int NOT NULL AUTO_INCREMENT,
			paciente_id int NOT NULL,
			usuario_id int NOT NULL,
			f_captura date NULL,
			h_captura time NULL,
		
 ";
		$preguntasx = "";
        $cnt=0;
		$cnt_sem1 = mysqli_num_rows($result_sem1);
    while($row_sem1 = mysqli_fetch_array($result_sem1)){
        extract($row_sem1);
		//print_r($row_sem1);
		//echo "<hr>";
		$cnt++;
		//echo $tipo."<hr>";	
		switch ($tipo) {
			case 'radio': 
				$preguntas .= "respuesta_$pregunta_id varchar(100)";
				break;
			case 'select':
				$preguntas .= "respuesta_$pregunta_id varchar(100)";							
				break;		
			case 'text':
				$preguntas .= "respuesta_$pregunta_id varchar(100)";				
				break;
			case 'textarea':
				$preguntas .= "respuesta_$pregunta_id text";
				break;
		
			case 'date':
				$preguntas .= "respuesta_$pregunta_id date";				
				break;
			case 'number':
				$preguntas .= "respuesta_$pregunta_id int";				
				break;
		
			case 'titulo':
				$preguntas .= "respuesta_$pregunta_id varchar(100)";				
				break;
			case 'instrucciones':
				$preguntas .= "respuesta_$pregunta_id text";	
				break;
		}
		
		$preguntas .= ", ";
		// if ($cnt_sem1 <> $cnt) {
			// $preguntas .= ", ";
		// }
		 
		//$preguntasx .= $pregunta;
			 //echo $pregunta;
	}	
	
	$preguntas .= " PRIMARY KEY (`base_id`, `paciente_id`, `usuario_id`));";
	
	echo $preguntas."<hr>";
	$result_insert = ejecutar($preguntas);
	
	$update = "
		update protocolo_terapia
		set
		protocolo_terapia.estatus = 'Activo'
		where protocolo_terapia.protocolo_ter_id = $protocolo_ter_id	
		";
	//echo $update;
	$result_update = ejecutar($update);	
	
	$preguntasx ="<h1>Archivos creados</h1>";
	
return $preguntasx;
}


