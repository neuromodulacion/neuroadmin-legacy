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
    <title>Test</title>

</head>
<body style='font-family: Arial, sans-serif;'>

		<table style='width: 100%' >
			<tr>
				<td align='center' style='background: #005157; width: 40%'>
					<table style='width: 70%'>
						<tr>
							<td style='color: #FFF; text-align: center;  '><h2>REPORTE</h2></td>
							&aacute;
						</tr>
						<tr>
							<td style='color: #000;background: #fff; text-align: center; padding: 5px'><h3>DE EVOLUCI&Oacute;N</h3></td>
						</tr>						
					</table>					
				</td>
				<td align='center'  style='background: #fff; width: 60%'>
					<img style='width: auto; height: 210px;' src='logo_pdf.png' alt='grafica'>
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
				<th style='text-align: center; padding-top: 10px; padding-bottom: 10px; color: #FFF '>UMBRAL MOTOR</th>
				<th style='text-align: center; padding-top: 10px; padding-bottom: 10px; color: #FFF '>EFECTOS ADVERSOS</th>
				<th style='text-align: center; padding-top: 10px; padding-bottom: 10px; color: #FFF '>COMENTARIOS</th>
			</tr>";
																			
			$sql_sem2 = "
				SELECT
					historico_sesion.historico_id, 
					historico_sesion.protocolo_ter_id, 
					historico_sesion.paciente_id, 
					historico_sesion.usuario_id, 
					historico_sesion.f_captura, 
					historico_sesion.h_captura, 
					historico_sesion.umbral,
					historico_sesion.adverso,
				(SELECT
					GROUP_CONCAT(efectos_adversos.adversos SEPARATOR ', ') AS adversos
				FROM
					efectos_adversos
					WHERE efectos_adversos.historico_id = historico_sesion.historico_id ) as adversos,
					historico_sesion.observaciones
				FROM
					historico_sesion
				WHERE
					historico_sesion.paciente_id = $paciente_id
				ORDER BY
					historico_id ASC";
					//echo "$sql_sem2 <br>";
		     	$result_sem2=ejecutar($sql_sem2); 
					$total_sesiones = 0;
					$cnt = 1;
		    	while($row_sem2 = mysqli_fetch_array($result_sem2)){
			        extract($row_sem2);	
			       // print_r($row_sem2);
			       $observaciones = tildes($observaciones);
			       //$observaciones =  utf8_decode($observaciones);		
			       
			       $f_captura = date('d-m-y', strtotime($f_captura)) ;
			       									        
				   $cuerpo_pdf .= "<tr>									   				
				   				<td style='text-align: center; width: 10%; background: #89CFE5; color: #FFF;'><b>$cnt</b></td>
				   				<td style='text-align: center; width: 10%; background: #EBF5FB;'>$f_captura</td>
				   				<td style='text-align: center; width: 10%; background: #EBF5FB;'>$umbral</td>
				   				<td style='width: 30%; background: #EBF5FB;'>$adversos</td>
				   				<td style='width: 40%; background: #EBF5FB;'>$observaciones</td>
							</tr>";   
					  
			        $cnt++;
		        }
		$cuerpo_pdf .= "		
		</table>
		<br>
		<table style='width: 100%' >
			<tr>
				<td style='background: #005157; width: 100%; padding: 8px; color: #fff'><h3>EVOLUCION GRAFICADA</h3></td>

			</tr>
			<tr>
				<td align='center'><img style='width: auto; max-height: 410px; max-width: 100%' src='$grafica' alt='grafica'></td>

			</tr>	
			<tr>
				<td>";
																			
					//echo "<hr>";
					$cuerpo_pdf .= "
					<table style='width: 100%' class='table table-bordered'>
						<tr>
							<th style='text-align: center'>Fecha</th>
							<th style='text-align: center'>PHQ9</th>
							<th style='text-align: center'>GAD7</th>
							<th style='text-align: center'>TINITUS</th>
							<th style='text-align: center'>CPFDL</th>
						</tr>
					";
					
					$sql = "SELECT * FROM tabla_temporal_$paciente_id ORDER BY f_captura asc";
					$result_sql=ejecutar($sql); 
					$cnt = 1;
					$cnt_sql = mysqli_num_rows($result_sql);
					
				    while($row_sql = mysqli_fetch_array($result_sql)){
				        extract($row_sql);		
						if ($cnt == 1) {
							$PHQ9_ini = $PHQ9;
							$GAD7_ini = $GAD7;
							$TINITUS_ini = $TINITUS;
							$CPFDL_ini = $CPFDL;	
						}		
						
						$color = PHQ9($PHQ9);
						$color1 = GAD7($GAD7);
						$color2 = tinitus($TINITUS);
						$color3 = CPFDL($CPFDL);
							
				   $cuerpo_pdf .= "
						<tr>
							<td style='text-align: center'>$f_captura</td>
							<td style='background: $color; text-align: center'>$PHQ9</td>
							<td style='background: $color1; text-align: center'>$GAD7</td>
							<td style='background: $color2; text-align: center'>$TINITUS</td>
							<td style='background: $color3; text-align: center'>$CPFDL</td>
						</tr>";											   
				        $cnt++;										
					}
					
					if ($PHQ9 >=1 ) { $total_PHQ9 = round((1-($PHQ9/$PHQ9_ini))*100,0); }
					if ($GAD7 >=1 ) { $total_GAD7 = round((1-($GAD7/$GAD7_ini))*100,0); }
					if ($TINITUS >=1 ) { $total_TINITUS = round((1-($TINITUS/$TINITUS_ini))*100,0); }
					if ($CPFDL >=1 ) { $total_CPFDL = round((1-($CPFDL/$CPFDL_ini))*100,0); }	
										
					// $total_PHQ9 = round((1-($PHQ9/$PHQ9_ini))*100,0);
					// $total_GAD7 = round((1-($GAD7/$GAD7_ini))*100,0);
					// $total_TINITUS = round((1-($TINITUS/$TINITUS_ini))*100,0);
					// $total_CPFDL = round((1-($CPFDL/$CPFDL_ini))*100,0);
						
					$cuerpo_pdf .= "
						<tr>
							<td style='text-align: center'>Avance</td>
							<td style='background: ".remision($total_PHQ9)."; text-align: center'>$total_PHQ9%</td>
							<td style='background: ".remision($total_GAD7)."; text-align: center'>$total_GAD7%</td>
							<td style='background: ".remision($total_TINITUS)."; text-align: center'>$total_TINITUS%</td>
							<td style='background: ".remision($total_CPFDL)."; text-align: center'>$total_CPFDL%</td>
						</tr>";						
					
					$cuerpo_pdf .= "</table>";
					//echo $tabla_sql;
					//echo $paciente_id." ".$grafica;
					
					$cuerpo_pdf .="	</td>		
					</tr>
					<tr align='center'>
						<td>
						<hr>
						  	<table align='center' style='width: 70%' class='table table-bordered'>
						  		<tr>
						  			<td style='background: #39F905; width: 20%; text-align: center'>Sin síntomas</td>
						  			<td style='background: #A8F905; width: 20%; text-align: center'>Leve</td>
						  			<td style='background: #EAF905; width: 20%; text-align: center'>Moderado</td>
						  			<td style='background: #F9B605; width: 20%; text-align: center'>Moderadamente severo</td>
						  			<td style='background: #F91B05; width: 20%; text-align: center'>Grave</td>
						  		</tr>													  														  														  		
						  	</table></td>
			";
			
		$cuerpo_pdf .=" 	
			</tr>		
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

//echo $cuerpo_pdf;
// Require composer autoload
require_once __DIR__ . '/../vendor/autoload.php';
// Create an instance of the class:
$mpdf = new \Mpdf\Mpdf();

// Write some HTML code:
$mpdf->WriteHTML($cuerpo_pdf);

// D descarga
// F guarda

// Output a PDF file directly to the browser
$mpdf->Output('pdf_file/xpdf_'.$paciente_id.'.pdf','D');

?>	