<?php
include('../functions/funciones_mysql.php');
error_reporting(7);
iconv_set_encoding('internal_encoding', 'utf-8'); 
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Monterrey');
setlocale(LC_TIME, 'es_ES.UTF-8');
$_SESSION['time']=mktime();

include('funciones_api.php');

//echo agrega_cliente_bind(101);

	$sql_protocolo = "
		SELECT
			paciente_consultorio.paciente_cons_id,
			paciente_consultorio.paciente_id,
			CONCAT( paciente_consultorio.paciente, ' ', paciente_consultorio.apaterno, ' ', paciente_consultorio.amaterno ) AS paciente,
			paciente_consultorio.celular,
			paciente_consultorio.email,
			paciente_consultorio.empresa_id,
			paciente_consultorio.id_bind,
			paciente_consultorio.f_alta,
			paciente_consultorio.validacion 
		FROM
			paciente_consultorio 
		WHERE
			(ISNULL( paciente_consultorio.id_bind ) or paciente_consultorio.id_bind LIKE '%message%')
		ORDER BY
			paciente_consultorio.paciente ASC
			"; 
        $result_protocolo=ejecutar($sql_protocolo); 

        while($row_protocolo = mysqli_fetch_array($result_protocolo)){
            extract($row_protocolo);
			
			$id_bind = agrega_cliente_bind_consulta($paciente_cons_id);
			
			echo $paciente_cons_id.' '.$paciente.' '.$apaterno.' '.$amaterno."<br>";
			echo $id_bind."<hr>";	
			
		}
//			id_bind LIKE '%message%' 	

	$sql_protocolo = "
	SELECT
		pacientes.paciente_id,
		pacientes.usuario_id,
		pacientes.empresa_id,
		pacientes.paciente,
		pacientes.apaterno,
		pacientes.amaterno,
		pacientes.email,
		pacientes.celular,
		pacientes.f_captura,
		pacientes.estatus,
		pacientes.id_bind 
	FROM
		pacientes 
	WHERE
		(ISNULL( pacientes.id_bind ) or pacientes.id_bind LIKE '%message%')
		AND pacientes.estatus <> 'Eliminado'
			"; 
        $result_protocolo=ejecutar($sql_protocolo); 
            //echo $cnt."<br>";  
            //echo "<br>";    
            $cnt=1;
            $total = 0;
            $ter="";
        while($row_protocolo = mysqli_fetch_array($result_protocolo)){
            extract($row_protocolo);
			echo agrega_cliente_bind($paciente_id)."<hr>";
			//echo agrega_cliente_bind($paciente_id)."<hr>";
		}



?>