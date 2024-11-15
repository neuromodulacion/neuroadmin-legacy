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

$sql_paciente ="
SELECT
	encuestas.encuesta_id, 
	encuestas.encuesta, 
	encuestas.descripcion
FROM
	encuestas
";
	$result_paciente = ejecutar($sql_paciente);
	
while($row_paciente = mysqli_fetch_array($result_paciente)){
    extract($row_paciente);
	echo "<hr>";
	echo "Paciente ".$paciente_id."<br>";
	
	$base_encuesta ="base_encuesta_".$encuesta_id;
	
	$sql = "
	SELECT
		$base_encuesta.base_id, 
		$base_encuesta.paciente_id, 
		$base_encuesta.usuario_id, 
		$base_encuesta.f_captura, 
		$base_encuesta.h_captura, 
		historico_sesion.historico_id, 
		historico_sesion.sesion
	FROM
		$base_encuesta
		INNER JOIN
		historico_sesion
		ON 
			$base_encuesta.paciente_id = historico_sesion.paciente_id AND
			$base_encuesta.f_captura = historico_sesion.f_captura AND
			$base_encuesta.h_captura = historico_sesion.h_captura
		";
	
	echo $sql."<hr>";
		$result = ejecutar($sql);
	
	$cnt = 1;
	$sesion = 1;
	
	while($row = mysqli_fetch_array($result)){
	    extract($row);

			//echo $cnt." historico_id ".$historico_id." Paciente ".$paciente_id." Sesion ".$sesion." f_captura ".$f_captura." h_captura ".$h_captura."<br>";
			$update = "
				update $base_encuesta
				set
					$base_encuesta.historico_id = $historico_id
				where $base_encuesta.base_id = $base_id	
				";
			echo $update."<br><br>";
			$result_update = ejecutar($update);			
			
			$sesion ++;	

		$cnt ++;
	}
}
