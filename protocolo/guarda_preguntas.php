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
print_r($_POST);
// echo "<hr>";
extract($_SESSION);
// print_r($_SESSION);
// echo "<hr>";
//$aviso = stripslashes($_POST['aviso']); 
//include('fun_cuestionario.php'); 


	$insert1 ="
	INSERT IGNORE INTO preguntas 
		(
			protocolo_ter_id,
			pregunta,
			respuesta_1,
			respuesta_2,
			respuesta_3,
			respuesta_4,
			respuesta_5,
			respuesta_6,
			respuesta_7,
			respuesta_8,
			respuesta_9,
			respuesta_10,
			tipo
		) 
	VALUE
		(
			$protocolo_ter_id,
			'$pregunta',
			'$respuesta_1',
			'$respuesta_2',
			'$respuesta_3',
			'$respuesta_4',
			'$respuesta_5',
			'$respuesta_6',
			'$respuesta_7',
			'$respuesta_8',
			'$respuesta_9',
			'$respuesta_10',
			'$tipo'
		) ";
	echo "<hr>".$insert1."<hr>";
	  $result_insert = ejecutar($insert1);
	// echo $result_insert."<hr>";

			// $sql = "SELECT
						// *
					// FROM
						// preguntas
					// WHERE
						// protocolo_ter_id = $protocolo_ter_id"; 
// 			
			// echo "<br>".$sql;			
			// $result_sql = ejecutar($sql);				
			// $row = mysqli_fetch_array($result_sql);
			// extract($row);	
			// print_r($row);	
			 echo "<h1>Guardado</h1>";				
			
			$sql_protocolo = "
					SELECT
						*
					FROM
						preguntas
					WHERE
						protocolo_ter_id = $protocolo_ter_id
					ORDER BY 1 asc";
						
		        $result_protocolo=ejecutar($sql_protocolo); 
		            echo $sql_protocolo."<br>";  
		            //echo "<br>";    
		            $cnt=1;
		            $total = 0;
		            $ter="";
		        while($row_protocolo = mysqli_fetch_array($result_protocolo)){
		            extract($row_protocolo);
					//print_r($row_protocolo);	
					echo "$tipo";		            
					$resultado = "";
					switch ($tipo) {
						case 'radio':
							$resultado .="
							<hr>
					        <h1>$cnt . Pregunta :</h1>
					        <h3>$pregunta</h3>
					        <h2 class='card-inside-title'>Respuestas</h2>
					        <div class='' demo-radio-button'>
					            <input name='respuesta$pregunta_id' type='radio' id='radio_1' class='radio-col-$body'  checked />
					            <label id='lradio_1' for='radio_1'>$respuesta_1</label>
					            <input name='respuesta$pregunta_id' type='radio' id='radio_2' class='radio-col-$body' />
					            <label id='lradio_2' for='radio_2'>$respuesta_2</label>
					        ";
							if ($respuesta_3 !== '') { $resultado .="
							            <input name='respuesta$pregunta_id' type='radio' id='radio_3' class='radio-col-$body' />
						            <label id='lradio_3' for='radio_3'>$respuesta_3</label>";		
							}
							if ($respuesta_4 !== '') { $resultado .="
							            <input name='respuesta$pregunta_id' type='radio' id='radio_4' class='radio-col-$body' />
						            <label id='lradio_4' for='radio_4'>$respuesta_4</label>";		
							}
							if ($respuesta_5 !== '') { $resultado .="
							            <input name='respuesta$pregunta_id' type='radio' id='radio_5' class='radio-col-$body' />
						            <label id='lradio_5' for='radio_5'>$respuesta_5</label>";		
							}
							if ($respuesta_6 !== '') { $resultado .="
							            <input name='respuesta$pregunta_id' type='radio' id='radio_6' class='radio-col-$body' />
						            <label id='lradio_6' for='radio_6'>$respuesta_6</label>";		
							}
							if ($respuesta_7 !== '') { $resultado .="
							            <input name='respuesta$pregunta_id' type='radio' id='radio_7' class='radio-col-$body' />
						            <label id='lradio_7' for='radio_7'>$respuesta_7</label>";		
							}
							if ($respuesta_8 !== '') { $resultado .="
							            <input name='respuesta$pregunta_id' type='radio' id='radio_8' class='radio-col-$body' />
						            <label id='lradio_8' for='radio_4'>$respuesta_8</label>";		
							}
							if ($respuesta_9 !== '') { $resultado .="
							            <input name='respuesta$pregunta_id' type='radio' id='radio_9' class='radio-col-$body' />
						            <label id='lradio_9' for='radio_9'>$respuesta_9</label>";		
							}
							if ($respuesta_10 !== '') { $resultado .="
							            <input name='respuesta$pregunta_id' type='radio' id='radio_10' class='radio-col-$body' />
						            <label id='lradio_10' for='radio_10'>$respuesta_10</label>";		
							}
																																			        
							$resultado .="</div>";
							break;
					
						case 'select':
					
							$resultado .="
							<hr>
					        <h1>$cnt . Pregunta :</h1>
					        <h3>$pregunta</h3>
					        <h2 class='card-inside-title'>Respuestas</h2>
                                <select id='respuesta$pregunta_id' name='respuesta$pregunta_id' class='form-control show-tick'>
                                    <option value=''>-- Seleciona tipo de Respuesta --</option>
                                    <option value='$respuesta_1'>$respuesta_1</option>
                                    <option value='$respuesta_2'>$respuesta_3</option>
					        ";
							if ($respuesta_3 !== '') { $resultado .="
						            <option value='$respuesta_3'>$respuesta_3</option>";		
							}
							if ($respuesta_4 !== '') { $resultado .="
						            <option value='$respuesta_4'>$respuesta_4</option>";		
							}
							if ($respuesta_5 !== '') { $resultado .="
						            <option value='$respuesta_5'>$respuesta_5</option>";	
							}
							if ($respuesta_6 !== '') { $resultado .="
						            <option value='$respuesta_6'>$respuesta_6</option>";		
							}
							if ($respuesta_7 !== '') { $resultado .="
						            <option value='$respuesta_7'>$respuesta_7</option>";		
							}
							if ($respuesta_8 !== '') { $resultado .="
						            <option value='$respuesta_8'>$respuesta_8</option>";	
							}
							if ($respuesta_9 !== '') { $resultado .="
						            <option value='$respuesta_9'>$respuesta_9</option>";		
							}
							if ($respuesta_10 !== '') { $resultado .="
						            <option value='$respuesta_10'>$respuesta_10</option>";		
							}
																																			        
							$resultado .="</select></div>";					
							
							break;
					
						case 'text':
							$resultado .="
							<hr>
					        <h1>$cnt . Pregunta :</h1>
					        <h3>$pregunta</h3>
					        <h2 class='card-inside-title'>Respuesta</h2>
					        <div class='form-line'>
								  <input id='respuesta_1' name='respuesta_1' type='text' class='form-control' placeholder='$respuesta_1' />
								</div>        
					        </div>        
					        ";					
							break;
					
						case 'textarea':					
							$resultado .="
							<hr>
					        <h1>Pregunta :<h1>
					        <h3>$pregunta</h3>
					        <h2 class='card-inside-title'>Respuesta</h2>
					        <div class='form-line'>
					            <div class=form-line>
					                <textarea rows='4'  id='respuesta_1' name='respuesta_1'  class='form-control no-resize' placeholder='Por favor responda la pregunta'></textarea>
					            </div>       
					        </div>        
					        ";							
							break;
					
						case 'date':
							$resultado .="
							<hr>
					        <h1>$cnt . Pregunta :</h1>
					        <h3>$pregunta</h3>
					        <h2 class='card-inside-title'>Respuesta</h2>
					        <div class='form-line'>
								  <input id='respuesta_1' name='respuesta_1' type='date' class='form-control' placeholder='$respuesta_1' />
								</div>        
					        </div>        
					        ";		
							break;
					
						case 'number':
							$resultado .="
							<hr>
					        <h1>$cnt . Pregunta :</h1>
					        <h3>$pregunta</h3>
					        <h2 class='card-inside-title'>Respuesta</h2>
					        <div class='form-line'>
								  <input id='respuesta_1' name='respuesta_1' type='number' class='form-control' placeholder='$respuesta_1' />
								</div>        
					        </div>        
					        ";		
							break;
							
						case 'titulo':
						$resultado .="	
							<hr>
					        <h1>$respuesta_1</h1>";																
																											
							break;
							
						case 'instrucciones':
						$resultado .="	
							<hr>
					        <h1>$cnt . Comentario :</h1>
					        <p>$respuesta_1</p>";																
									
							break;												
					}
					$cnt++;
					
	//.0$cresultado .="<a class='btn bg-$body waves-effect' href='' role='button'>Terminar</a>";				
					
	echo $resultado;				
}
 echo"<a id='final' class='btn bg-$body waves-effect' href='' role='button'>Terminar</a>";	

?>