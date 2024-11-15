<?php
// crea_base_protocolo.php

include('../functions/funciones_mysql.php');
session_start();
error_reporting(7);
iconv_set_encoding('internal_encoding', 'utf-8'); 
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Monterrey');
setlocale(LC_TIME, 'es_ES.UTF-8');
$_SESSION['time']=mktime();

$paciente_id = 101;

	$sql_encuestas = "
	SELECT
		encuesta_id, 
		encuesta, 
		descripcion,
		CONCAT('base_encuesta_',encuesta_id) as bases
	FROM
		encuestas
	order by encuesta_id asc";
	echo $sql_encuestas."<hr>";	
 	$result_encuestas=ejecutar($sql_encuestas); 
	while($row_encuestas = mysqli_fetch_array($result_encuestas)){
        extract($row_encuestas);	
	
		$sql_bases = "
		SELECT
			base_encuesta_$encuesta_id.base_id,
			base_encuesta_$encuesta_id.paciente_id,
			base_encuesta_$encuesta_id.usuario_id,
			base_encuesta_$encuesta_id.f_captura,
			base_encuesta_$encuesta_id.h_captura,";												
															
		$sql_preguntas = "
		SELECT
			preguntas_encuestas.pregunta_id,
			preguntas_encuestas.encuesta_id,
			preguntas_encuestas.numero,
			preguntas_encuestas.pregunta,
			preguntas_encuestas.tipo 
		FROM
			preguntas_encuestas 
		WHERE
			preguntas_encuestas.encuesta_id = $encuesta_id 
			AND preguntas_encuestas.tipo NOT IN ('titulo','instrucciones')";
		//$dia .= $sql_preguntas."<hr>";	
		$sql_basesX = "";
     	$result_preguntas=ejecutar($sql_preguntas); 
    	while($row_preguntas = mysqli_fetch_array($result_preguntas)){
	        extract($row_preguntas);			
													
			$sql_basesX .= "
			( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta LIKE base_encuesta_$encuesta_id.respuesta_$pregunta_id and respuestas.encuesta_id = $encuesta_id )+";
	
		}
		
			$sql_basesX = substr($sql_basesX, 0, -1);

			$sql_bases .= "
				$sql_basesX as total
			FROM
				base_encuesta_$encuesta_id
";
//			WHERE
//				base_encuesta_$encuesta_id.paciente_id = $paciente_id
			echo $sql_bases."<hr>";
			
			$result_bases=ejecutar($sql_bases);
			$cnt_bases = mysqli_num_rows($result_bases);
			//$dia .= $sql_bases."<br> Res".$cnt_bases."<hr>";
			
			if ($cnt_bases >= 1) {

				// $dia .= $encuesta." - ".$descripcion."<hr>
				// <div class='row'>
				  // <div class='col-md-5'>";
				// $datos = "";															
				// $tabla ="													
				// <table  class='table table-bordered'>
					// <tr>
						// <th>Fecha</th>
						// <th>Resultado</th>
						// <th>Evaluación</th>
					// </tr>";
					
				$cnt_calificacion = 1;	
		    	while($row_bases = mysqli_fetch_array($result_bases)){
			        extract($row_bases);
				
					$update = "
						update base_encuesta_$encuesta_id
						set
							base_encuesta_$encuesta_id.total = $total
						where base_encuesta_$encuesta_id.base_id = $base_id	
						";
					echo $update."<br>";
					$result_update = ejecutar($update);					
				
				// $color = "";
// 					
				// $sql_calificacion = "
				// SELECT
					// calificaciones.calificacion_id, 
					// calificaciones.encuesta_id, 
					// calificaciones.min, 
					// calificaciones.max, 
					// calificaciones.valor, 
					// calificaciones.color
				// FROM
					// calificaciones
				// WHERE
					// calificaciones.encuesta_id = $encuesta_id
					// AND calificaciones.min <= $total 
					// AND calificaciones.max >= $total";
// 					
				// //$tabla .= $sql_calificacion."<hr>";	
				// $result_calificacion = ejecutar($sql_calificacion);	
// 				
				// $row_calificacion = mysqli_fetch_array($result_calificacion);	
				// extract($row_calificacion);
// 				
					// if ($cnt_calificacion == 1) {
						// $tot_ini = $total;
					// }
					// $tabla .="
					// <tr>
						// <td>$f_captura</td>
						// <td style='text-align: center'>$total</td>
						// <td style='background-color: $color'>$valor</td>
					// </tr>
					// ";
					// $datos .= "
					// {'y': '$f_captura', '$encuesta': $total},";
					// $cnt_calificacion ++;
				}													
				// $tabla .="</table>";
// 				
				// $resultado_final = round(($total/$tot_ini)*100,0);
				// $resultado_final = 100 -$resultado_final;
// 				
				// if ($resultado_final < 0) {
					// $respuesta = "un Incremento";
				// }else{
					// $respuesta = "una Disminución";
				// }

				
				
			}
echo $dia;													
echo $tabla."<hr>";
	$dia="";
	//$dia .= "<div style='min-width: 100%' id='graph'></div>";
	//$grafica = medicion_protocolo($paciente_id);
						
	}
	
	
	
	//echo $tabla;
					