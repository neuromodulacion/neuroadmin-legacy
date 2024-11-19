<?php
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

extract($_SESSION);
//echo "<hr>$paciente_id hola<hr>";
extract($_GET);
extract($_POST);



include('../functions/funciones_mysql.php');

include('../paciente/calendario.php');

include('../paciente/fun_paciente.php');

function tildes($palabra) {
    //Rememplazamos caracteres especiales latinos minusculas
    $encuentra = array('&','<','>','¢','£','¥','€','©','®','™','§','†','‡','¶','•','…','±','¹','²','³','½','¼','¾','µ','°','√','∞','Ω','Σ','μ','←','→','↑','↓','↔','↵','⇐','⇒'
);
     $remplaza = array('&amp;','&lt','&gt','&cent','&pound','&yen','&euro','&copy','&reg','&trade','&sect','&dagger','&Dagger','&para','&bull','&hellip','&plusmn','&sup1','&sup2','&sup3','&frac12','&frac14','&frac34','&micro','&deg','&radic','&infin','&ohm','&sigma','&mu','&larr','&rarr','&uarr','&darr','&harr','&crarr','&lArr','&rArr'

);
    $palabra = str_replace($encuentra, $remplaza, $palabra);
return $palabra;
}



//$paciente_id = 26;

$grafica = "image/imagen_$paciente_id.png";

$sql ="
SELECT
	pacientes.paciente_id, 
	pacientes.usuario_id, 
	CONCAT(pacientes.paciente,' ',pacientes.apaterno,' ',pacientes.amaterno) as paciente, 
	pacientes.email, 
	pacientes.celular, 
	pacientes.f_nacimiento, 
	pacientes.sexo, 
	pacientes.contacto, 
	pacientes.parentesco, 
	pacientes.tel1, 
	pacientes.tel2, 
	pacientes.resumen_caso, 
	pacientes.diagnostico, 
	pacientes.diagnostico2, 
	pacientes.diagnostico3, 
	pacientes.medicamentos, 
	pacientes.f_captura, 
	pacientes.h_captura, 
	pacientes.estatus, 
	pacientes.observaciones, 
	pacientes.notificaciones, 
	pacientes.comentarios_reporte,
	admin.nombre as medico
FROM
	pacientes
	INNER JOIN
	admin
	ON 
		pacientes.usuario_id = admin.usuario_id
WHERE
		pacientes.paciente_id = $paciente_id";
	//echo $sql;	
    $result=ejecutar($sql); 
    $row = mysqli_fetch_array($result);
    extract($row);	

$comentarios_reporte = stripslashes($row["comentarios_reporte"]);    
    
$edad = obtener_edad_segun_fecha($f_nacimiento);

$hoy = date("d-m-Y");

$cuerpo_pdf = "

<html>
<head>
    <title></title>
	<meta charset='UTF-8'>
</head>
<body style='font-family: Arial, sans-serif;'>
	<table style='width: 100%' >
		<tr>
			<td align='center' style='background: #005157; width: 40%'>
				<table style='width: 70%'>
					<tr>
						<td style='color: #FFF; text-align: center;  '><h2>REPORTE</h2></td>
						
					</tr>
					<tr>
						<td style='color: #000;background: #fff; text-align: center; padding: 5px'><h3>DE EVOLUCI&Oacute;N</h3></td>
					</tr>						
				</table>					
			</td>
			<td align='center'  style='background: #fff; width: 60%'>
				<img style='width: auto; height: 150px;' src='../$logo' alt='grafica'>
			</td>
		</tr>
	</table>
	<br><br><br>
	<table>
		<tr>
			<td style='background: #0096AA; width: 200px; padding: 8px; font-size: 12px; color: #FFF'><b>PACIENTE</b></td>
			<td style=' padding: 8px; font-size: 12px'><b>$paciente</b></td>
		</tr>
		<tr>
			<td style='background: #0096AA; width: 200px; padding: 8px; font-size: 12px; color: #FFF'><b>MEDICO TRATANTE</b></td>
			<td style=' padding: 8px; font-size: 12px'><b>$medico</b></td>
		</tr>
		<tr>
			<td style='background: #0096AA; width: 200px; padding: 8px; font-size: 12px; color: #FFF'><b>FECHA</b></td>
			<td style=' padding: 8px; font-size: 12px'><b>$hoy</b></td>
		</tr>						
	</table>
	<br>
	<table style='width: 100%' >
		<tr>
			<td style='background: #005157; width: 100%; padding: 8px; color: #fff'><h3>RESUMEN DEL CASO</h3></td>
		</tr>
		<tr>
			<td style=' width: 100%; padding: 8px; font-size: 14px'><p>$sexo de $edad Diagnostico: $diagnostico</p></td>
		</tr>
		<tr>
			<td style='background: #005157; width: 100%; padding: 8px; color: #fff'><h3>RESUMEN DEL TRATAMIENTO</h3></td>
		</tr>						
	</table>
	<br>
	<table style='width: 100%' >
		<tr style='background: #0096AA; color: #FFF '>
			<th style='text-align: center; padding-top: 10px; padding-bottom: 10px; color: #FFF; width: 10%'>SESI&Oacute;N</th>
			<th style='text-align: center; padding-top: 10px; padding-bottom: 10px; color: #FFF '>FECHA</th>
			<th style='text-align: center; padding-top: 10px; padding-bottom: 10px; color: #FFF '>PROTOCOLO</th>
			<th style='text-align: center; padding-top: 10px; padding-bottom: 10px; color: #FFF '>EFECTOS ADVERSOS</th>
			<th style='text-align: center; padding-top: 10px; padding-bottom: 10px; color: #FFF '>COMENTARIOS</th>
		</tr>";
																			
$sql_sem2 = "
	SELECT
		historico_sesion.f_captura, 
		(  SELECT
	GROUP_CONCAT(DISTINCT adversos.adversos_id SEPARATOR ', ' ) AS adversos
FROM
	efectos_adversos
	INNER JOIN
	adversos
	ON 
		efectos_adversos.adversos = adversos.adverso
WHERE efectos_adversos.historico_id = historico_sesion.historico_id) AS adversos, 
		historico_sesion.observaciones,
		historico_sesion.anodo,
		historico_sesion.catodo,
		equipos.siglas,
		protocolo_terapia.protocolo
	FROM
		historico_sesion
		INNER JOIN
		protocolo_terapia
		ON 
			historico_sesion.protocolo_ter_id = protocolo_terapia.protocolo_ter_id
		INNER JOIN
		equipos
		ON 
			protocolo_terapia.equipo_id = equipos.equipo_id
	WHERE
		historico_sesion.paciente_id = $paciente_id
	ORDER BY
		historico_sesion.historico_id ASC";
		
		//echo "$sql_sem2 <br>";
 	$result_sem2=ejecutar($sql_sem2); 
		$total_sesiones = 0;
		$cnt = 1;
	while($row_sem2 = mysqli_fetch_array($result_sem2)){
        extract($row_sem2);	
       // print_r($row_sem2);
       $observaciones = tildes($observaciones);
       //$observaciones =  utf8_decode($observaciones);		
       
       //$f_captura = date('d-m-y', strtotime($f_captura)) ;
       $f_captura = strftime("%e-%b-%y",strtotime($f_captura));
       if ($siglas == "TMS") {
           $tipo = $protocolo;
       }else{
       	   $tipo = "Anodo ".$anodo."/Catodo ".$catodo;
       }
       									        
	   $cuerpo_pdf .= "
	   <tr>									   				
			<td style='text-align: center; width: 10%; background: #89CFE5; color: #FFF;'><b>$cnt</b></td>
			<td style='text-align: center; width: 10%; background: #EBF5FB;'>$f_captura</td>
			<td style='text-align: center; width: 10%; background: #EBF5FB;'>$tipo</td>
			<td style='width: 10%; background: #EBF5FB;'>$adversos</td>
			<td style='width: 60%; background: #EBF5FB;'>$observaciones</td>
		</tr>";   
			  
	        $cnt++;
        }
				//<img style='width: auto; max-height: 410px; max-width: 100%' src='$grafica' alt='grafica'>
$cuerpo_pdf .= "		
	</table>
	<hr>
	<br>
	Efectos Adversos: Claves ";

		
$sql_sem2 = "
SELECT
	adversos.adversos_id, 
	adversos.adverso
FROM
	adversos";
		
		//echo "$sql_sem2 <br>";
 	$result_sem2=ejecutar($sql_sem2); 
		$total_sesiones = 0;
		$cnt = 1;
	while($row_sem2 = mysqli_fetch_array($result_sem2)){
        extract($row_sem2);	
       // print_r($row_sem2);
       $observaciones = tildes($observaciones);
       //$observaciones =  utf8_decode($observaciones);		
       
       //$f_captura = date('d-m-y', strtotime($f_captura)) ;
       $f_captura = strftime("%e-%b-%y",strtotime($f_captura));
       
       									        
	   $cuerpo_pdf .= " $adversos_id - $adverso,";
  		  
	        $cnt++;
        }		
		// <pagebreak >
$cuerpo_pdf .= "		

	<br>
	<br>
	<table style='width: 100%' >
		<tr>
			<td style='background: #005157; width: 100%; padding: 8px; color: #fff'><h3>EVOLUCION GRAFICADA</h3></td>
			
		</tr>
		";
///////////////////////////////////////////////////////////////// inicia nuevo
$sql_encuestas = "
	SELECT
		encuesta_id, 
		encuesta, 
		descripcion,
		CONCAT('base_encuesta_',encuesta_id) as bases
	FROM
		encuestas
		order by 1 asc";
//$cuerpo_pdf .= $sql_encuestas."<hr>";	
//echo $sql_encuestas."<br>";
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
	//$cuerpo_pdf .= $sql_preguntas."<hr>";	
	$sql_basesX = "";
 	$result_preguntas=ejecutar($sql_preguntas); 
 	$cnt_brake = 1;
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
	WHERE
		base_encuesta_$encuesta_id.paciente_id = $paciente_id
	ORDER BY f_captura desc";

//echo $sql_bases."<hr>";

	$result_bases=ejecutar($sql_bases);
	$cnt_bases = mysqli_num_rows($result_bases);
	//$cuerpo_pdf .= $sql_bases."<br> Res".$cnt_bases."<hr>";
	
	if ($cnt_bases >= 1) {				
		$cuerpo_pdf .="
		<tr>
			<td><hr><h3 align='center'>".$encuesta." - ".$descripcion."</h3><hr></td>
		</tr>
		<tr>
			<td>
				<table>
					<tr>
						<td style='text-align: center; width: 50%'>
							";
							$datos = "";															
							$tabla ="													
							<table >
								<tr>
									<th>Fecha</th>
									<th>Resultado</th>
									<th>Evaluación</th>
								</tr>";
								
							$cnt_calificacion = 1;	
					    	while($row_bases = mysqli_fetch_array($result_bases)){
						        extract($row_bases);
							
							$color = "";
									
								$sql_calificacion = "
								SELECT
									calificaciones.calificacion_id, 
									calificaciones.encuesta_id, 
									calificaciones.min, 
									calificaciones.max, 
									calificaciones.valor, 
									calificaciones.color
								FROM
									calificaciones
								WHERE
									calificaciones.encuesta_id = $encuesta_id
									AND calificaciones.min <= $total 
									AND calificaciones.max >= $total
									";
							
								//$tabla .= $sql_calificacion."<hr>";	
								$result_calificacion = ejecutar($sql_calificacion);	
								
								$row_calificacion = mysqli_fetch_array($result_calificacion);	
								extract($row_calificacion);
								
									if ($cnt_calificacion == 1) {
										$tot_ini = $total;
									}
									$f_ini = strftime("%e-%b-%Y",strtotime($f_captura));
									
									$tabla .="
									<tr>
										<td>$f_ini</td>
										<td style='text-align: center'>$total</td>
										<td style='background-color: $color'>$valor</td>
									</tr>
									";
									$datos .= "
									{'y': '$f_captura', '$encuesta': $total},";
									$cnt_calificacion ++;
								}													
								$tabla .="</table>";
						
								$resultado_final = round(($tot_ini/$total)*100,0);
								$resultado_final = 100 -$resultado_final;
								
								if ($resultado_final < 0) {
									$respuesta = "un Incremento";
								}else{
									$respuesta = "una Disminución";
								}
								$n_grf = "enc_".$encuesta_id."_pac_".$paciente_id;
								
								$grafica = "image/imagen_$n_grf.png";
						
						$cuerpo_pdf .=	$tabla."
						<h4>Se obtuvo $respuesta del $resultado_final% con respecto a la lectura inicial</h4>
						</td>
					

						<td style='text-align: center; width: 50%' ><img style='width: auto; max-height: 410px; max-width: 50%' src='$grafica' alt='grafica'></td>		
						</tr>
					</table>
				</td>
			</tr>																  		
					  	";
					if ($cnt_brake == 3 || $cnt_brake == 6 || $cnt_brake == 9 || $cnt_brake == 12) {
						$cuerpo_pdf .= "<pagebreak >";
					}
					$cnt_brake++;	  	
					  	
		}							
	}

///////////////////////////////////////////////////////////////// termina nuevo																			

		$cuerpo_pdf .=" 	
				
			<tr>
				<td style=' width: 100%; padding: 8px; font-size: 14px'>
					<p>
						Adem&aacute;s del gr&aacute;fico de resultados, se puede calcular el porcentaje de reducci&oacute;n de s&iacute;ntomas (Una reducci&oacute;n de 50% de los s&iacute;ntomas se considera respuesta, y reducci&oacute;n mayor a 75% se le llama remisión)
					
					</p>
				</td>
			</tr>
			<tr>
				<td style='background: #005157; width: 100%; padding: 8px; color: #fff'><h3>COMENTARIOS</h3></td>
			</tr>	
			<tr>
				<td style=' width: 100%; padding: 8px; font-size: 14px'>
					<ul>
						<li></lo>$comentarios_reporte</li>
					</ul>

				</td>
			</tr>								
		</table>		
</body>
";

// echo $cuerpo_pdf;
 

 
// //Require composer autoload
require_once __DIR__ . '/../vendor/autoload.php';


 

// Create an instance of the class:
$mpdf = new \Mpdf\Mpdf();

// Write some HTML code:
$mpdf->WriteHTML($cuerpo_pdf);

// D descarga
// F guarda
// I imprime

// Output a PDF file directly to the browser
$mpdf->Output('Paciente_'.$paciente_id.'.pdf','D');

?>	