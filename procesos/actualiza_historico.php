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
	historico_sesion.paciente_id,
	COUNT(*) AS paciente 
FROM
	historico_sesion 
GROUP BY 1 
ORDER BY paciente_id ASC 
";
	$result_paciente = ejecutar($sql_paciente);
	
while($row_paciente = mysqli_fetch_array($result_paciente)){
    extract($row_paciente);
	echo "<hr>";
	echo "Paciente ".$paciente_id."<br>";
	
	$sql = "
	SELECT
		historico_sesion.historico_id, 
		historico_sesion.empresa_id, 
		historico_sesion.protocolo_ter_id, 
		historico_sesion.paciente_id, 
		historico_sesion.usuario_id, 
		historico_sesion.sesion, 
		historico_sesion.f_captura, 
		historico_sesion.h_captura, 
		historico_sesion.umbral, 
		historico_sesion.anodo, 
		historico_sesion.catodo, 
		historico_sesion.polaridad, 
		historico_sesion.adverso, 
		historico_sesion.observaciones, 
		historico_sesion.pago
	FROM
		historico_sesion
	WHERE
		historico_sesion.paciente_id = $paciente_id
	ORDER BY paciente_id asc, f_captura asc, f_captura asc
	";
	
	//echo $sql."<hr>";
		$result = ejecutar($sql);
	
	$cnt = 1;
	$sesion = 1;
	
	while($row = mysqli_fetch_array($result)){
	    extract($row);

			// echo $cnt." historico_id ".$historico_id." Paciente ".$paciente_id." Sesion ".$sesion." f_captura ".$f_captura." h_captura ".$h_captura."<br>";
			$update = "
				update historico_sesion
				set
					historico_sesion.sesion = '$cnt'
				where historico_sesion.historico_id = '$historico_id'	
				";
			echo $update."<br>";
			$result_update = ejecutar($update);			
			
			$sesion ++;	

		$cnt ++;
	}
}
