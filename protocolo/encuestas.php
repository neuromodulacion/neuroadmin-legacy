<?php
include('../functions/funciones_mysql.php');
include('../functions/functions.php');
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

$list = "";

foreach ($encuestas as $valor) {
	
	$list .= $valor.",";
}

//echo strlen($list);
$list = substr($list, 0, -1);
//echo $list;

	$sql_sem1 = "
		SELECT
			preguntas_encuestas.pregunta_id, 
			preguntas_encuestas.encuesta_id, 
			preguntas_encuestas.numero, 
			preguntas_encuestas.pregunta, 
			preguntas_encuestas.respuesta_1, 
			preguntas_encuestas.respuesta_2, 
			preguntas_encuestas.respuesta_3, 
			preguntas_encuestas.respuesta_4, 
			preguntas_encuestas.respuesta_5, 
			preguntas_encuestas.respuesta_6, 
			preguntas_encuestas.respuesta_7, 
			preguntas_encuestas.respuesta_8, 
			preguntas_encuestas.respuesta_9, 
			preguntas_encuestas.respuesta_10, 
			preguntas_encuestas.tipo
		FROM
			preguntas_encuestas
		WHERE
			preguntas_encuestas.encuesta_id in($list)	
	    ";
		//echo "<hr>".$sql_sem1."<hr>";


		//
		$result_sem1 = ejecutar($sql_sem1); 
		$preguntas = "";
		$preguntasx = "";
        $cnt=0;
		
//	$preguntas .= "
//		<input  name='preg_$pregunta_id' type='hidden' id='list' name='list' value='$list' required />
//		<input  name='preg_$pregunta_id' type='hidden' id='encuestas' name='encuestas' value='$encuestas' required />"; 	
		
    while($row_sem1 = mysqli_fetch_array($result_sem1)){
        extract($row_sem1);
		//print_r($row_sem1);
		//echo "<hr>";
		$pregunta = codificacionUTF($pregunta);
		$pregunta = codificacionUTF($pregunta);
		$respuesta_1 = codificacionUTF($respuesta_1);
		$respuesta_2 = codificacionUTF($respuesta_2);
		$respuesta_3 = codificacionUTF($respuesta_3);
		$respuesta_4 = codificacionUTF($respuesta_4);
		$respuesta_5 = codificacionUTF($respuesta_5);
		$respuesta_6 = codificacionUTF($respuesta_6);
		$respuesta_7 = codificacionUTF($respuesta_7);
		$respuesta_8 = codificacionUTF($respuesta_8);
		$respuesta_9 = codificacionUTF($respuesta_9);
		$respuesta_10 = codificacionUTF($respuesta_10);
		

		$cnt++;
		//echo $tipo."<hr>";	
		switch ($tipo) {
			case 'radio': 
				$preguntas .= "<hr>
			        <h4>$numero.- $pregunta</h4><br>								
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
                    	<h4>$numero.- $pregunta</h4><br>								
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
                    	<h4>$numero.- $pregunta</h4><br>								
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
                    	<h4>$numero.- $pregunta</h4><br>								
                        <div class='form-group form-float'>
                            <input class='form-control' name='pregunta_$pregunta_id' type='date' id='pregunta_$pregunta_id' placeholder='$pregunta'  value='' />
                             
                    	</div> 
                	</div>";				
				break;
			case 'number':
			$preguntas .= "<hr>
                    <div>
                    	<h4>$numero.- $pregunta</h4><br>								
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
                    	<h4>$pregunta</h4><br>
                    	<p>$respuesta_1</p><br>								
                	</div>";				
				break;
									
			default:
				
				break;
		}
		
			// echo $pregunta;
	}	
echo $preguntas;