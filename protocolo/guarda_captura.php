<?php
include('../functions/funciones_mysql.php');
session_start();
error_reporting(E_ALL);
ini_set('default_charset', 'UTF-8');
header('Content-Type: text/html; charset=UTF-8');
//date_default_timezone_set('America/Monterrey');
date_default_timezone_set('America/Mazatlan');
setlocale(LC_TIME, 'es_ES.UTF-8');
$_SESSION['time']=time();


include('fun_protocolo.php');

$ruta = "../";
extract($_SESSION);
// print_r($_SESSION);
 
extract($_POST);
// print_r($_POST);
 echo "<hr>";
function tildes($palabra) {
    //Rememplazamos caracteres especiales latinos minusculas
    $encuentra = array('&','<','>','¢','£','¥','€','©','®','™','§','†','‡','¶','•','…','±','¹','²','³','½','¼','¾','µ','°','√','∞','Ω','Σ','μ','←','→','↑','↓','↔','↵','⇐','⇒'
);
     $remplaza = array('&amp;','&lt','&gt','&cent','&pound','&yen','&euro','&copy','&reg','&trade','&sect','&dagger','&Dagger','&para','&bull','&hellip','&plusmn','&sup1','&sup2','&sup3','&frac12','&frac14','&frac34','&micro','&deg','&radic','&infin','&ohm','&sigma','&mu','&larr','&rarr','&uarr','&darr','&harr','&crarr','&lArr','&rArr'

);
    $palabra = str_replace($encuentra, $remplaza, $palabra);
return $palabra;
}



// echo "<hr>";
$observaciones = stripslashes($_POST['observaciones']); 
$observaciones = tildes($observaciones);


$f_captura = date("Y-m-d");
$h_captura = date("H:i:s");

//echo $observaciones."<BR>";
if ($tms_cnt == '') { $tms_cnt = 0; }
if ($tms_d == '') { $tms_d = 0; }

switch ($tipo) {

	case 'inicial':
		$insert = "
			INSERT IGNORE INTO metricas 
			( 	
				metricas.paciente_id, 
				metricas.nasion, 
				metricas.trago, 
				metricas.circunferencia, 
				metricas.x, 
				metricas.y,
				metricas.umbral,
				metricas.observaciones,
				metricas.terapia_id,
				metricas.f_captura,
				metricas.h_captura,
				metricas.usuario_id
			)
				values
			( 
				$paciente_id,
				$nasion,
				$trago,
				$circunferencia_cef,
				$x,
				$y,
				$umbral,
				'$observaciones',
				$terapia_id,
				'$f_captura',
				'$h_captura',
				$usuario_id
			)
		";	
		// echo $insert;
		$result_insert = ejecutar($insert);

			$update = "
				update terapias
				set
				terapias.estatus = 'Activo'
				where terapias.paciente_id = $paciente_id	
				";
			// echo $update;
			$result_update = ejecutar($update);			

			$update = "
				update pacientes
				set
				pacientes.estatus = 'Activo'
				where pacientes.paciente_id = $paciente_id	
				";
			// echo $update;
			$result_update = ejecutar($update);	
		
		// $update = "
			// update sesiones
			// set
			// sesiones.total_sesion = (sesiones.total_sesion +1)
			// where sesiones.paciente_id = $paciente_id
			// and protocolo_ter_id = $protocolo_ter_id	
		// ";
		// echo $update;
		// $result_update = ejecutar($update);	
// 		
		// echo "<h1>Capturado</h1>";
		
		break;

	case 'encuesta':
		
		echo elementos($protocolo_ter_id);
		
		break;

	case 'preguntas_protocolo':

		//print_r($_POST);
		
		$insert = "
			INSERT IGNORE INTO historico_sesion 
			( 	
				historico_sesion.protocolo_ter_id,
				historico_sesion.paciente_id,
				historico_sesion.empresa_id,
				historico_sesion.usuario_id,
				historico_sesion.f_captura,
				historico_sesion.h_captura,
				historico_sesion.umbral,
				historico_sesion.tms_cnt, 
				historico_sesion.tms_d,
				historico_sesion.adverso,
				historico_sesion.observaciones,
				historico_sesion.anodo,
				historico_sesion.catodo,
				historico_sesion.polaridad
			)
				values
			( 
				$protocolo_ter_id,
				$paciente_id,
				$empresa_id,
				$usuario_id,
				'$f_captura',
				'$h_captura',
				$umbral,
				$tms_cnt,
				$tms_d,
				'$adverso',
				'$observaciones',
				'$anodo',
				'$catodo',
				'$polaridad'

			)
		";	
		// echo $insert."<hr>";
		$result_insert = ejecutar($insert);		

		$sql_hist ="
			SELECT
				max(historico_sesion.historico_id) as historico_id
			FROM
				historico_sesion";
			$result_hist = ejecutar($sql_hist);
			$row_hist = mysqli_fetch_array($result_hist);
			extract($row_hist);	
		if (!empty($adversos)) {
			foreach ($adversos as $valor) {
			
				if ($valor == 'OTROS') {
					$otros = strtoupper($otros);
					$insert = "
						INSERT IGNORE INTO efectos_adversos 
						( 
							protocolo_ter_id,
							paciente_id,
							historico_id,
							adversos
						)
							values
						( 	
							$protocolo_ter_id,
							$paciente_id,
							$historico_id,
							'$otros'							
						)
					";	
					//echo $insert;
					$result_insert = ejecutar($insert);			
				}else{
					$insert = "
						INSERT IGNORE INTO efectos_adversos 
						( 
							protocolo_ter_id,
							paciente_id,
							historico_id,
							adversos
						)
							values
						( 	
							$protocolo_ter_id,
							$paciente_id,
							$historico_id,
							'$valor'							
						)
					";	
					//echo $insert;
					$result_insert = ejecutar($insert);		
				}					
			    //echo $valor . "<br>";
			}
		}
		
		$sql_valida ="
		SELECT
			*
		FROM
			sesiones
		WHERE
			sesiones.paciente_id = $paciente_id
			and protocolo_ter_id = $protocolo_ter_id
		";
		$result_valida = ejecutar($sql_valida);
		$cnt_valida = mysqli_num_rows($result_valida);
		
		if ($cnt_valida == 0) {
						
			$sql_terapia ="
			SELECT
				terapias.terapia_id
			FROM
				terapias
			WHERE
				terapias.paciente_id = $paciente_id
			";
			$result_terapia = ejecutar($sql_terapia);
			$row_terapia = mysqli_fetch_array($result_terapia);					
			extract($row_terapia);				
			
			$insert = "
				INSERT IGNORE INTO sesiones 
				( 	
					sesiones.terapia_id, 
					sesiones.protocolo_ter_id, 
					sesiones.paciente_id, 
					sesiones.sesiones, 
					sesiones.total_sesion, 
					sesiones.f_alta, 
					sesiones.h_alta
				)
					values
				( 
					$terapia_id,
					$protocolo_ter_id,
					$paciente_id,
					0,
					1,					
					'$f_captura',
					'$h_captura'
				)
			";	
			//echo $insert."<hr>";
			$result_insert = ejecutar($insert);			
		} else {							
			$update = "
				update sesiones
				set
				sesiones.total_sesion = (sesiones.total_sesion +1)
				where sesiones.paciente_id = $paciente_id
				and protocolo_ter_id = $protocolo_ter_id	
				";
			//echo $update;
			$result_update = ejecutar($update);				
		}

			$update = "
				update terapias
				set
				terapias.estatus = 'Activo'
				where terapias.paciente_id = $paciente_id	
				";
			//echo $update;
			$result_update = ejecutar($update);	


			$update = "
				update pacientes
				set
				pacientes.estatus = 'Activo'
				where pacientes.paciente_id = $paciente_id	
				";
			//echo $update;
			$result_update = ejecutar($update);	
			
			if ($umbral_new == 'ok') {
				$update = "
					update metricas
					set
					metricas.umbral = '$umbral'
					where metricas.paciente_id = $paciente_id	
					";
				//echo $update;
				$result_update = ejecutar($update);	
			}			
//****************falta guardar las preguntas
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
		//echo $sql_sem1."<hr>";
		$result_sem1 = ejecutar($sql_sem1);
		$cnt_se1 = mysqli_num_rows($result_sem1);
		
		$insert_c ="INSERT IGNORE INTO base_protocolo_$protocolo_ter_id 
			( base_protocolo_$protocolo_ter_id.paciente_id,
			  base_protocolo_$protocolo_ter_id.usuario_id,
			  base_protocolo_$protocolo_ter_id.f_captura,
			  base_protocolo_$protocolo_ter_id.h_captura,";
		$insert_v ="values
			( $paciente_id,
			  $usuario_id,
			  '$f_captura',
			  '$h_captura',";	
			$cnt =1;	 
    while($row_sem1 = mysqli_fetch_array($result_sem1)){
        extract($row_sem1);
		$respuesta = 'pregunta_'.$pregunta_id;
		if ($tipo <> 'instrucciones' && $tipo <> 'titulo') {						
			if ($cnt_se1 <> $cnt) {
				$insert_c .="base_protocolo_$protocolo_ter_id.respuesta_$pregunta_id,";
				$insert_v .="'".$$respuesta."',";
			} else {
				$insert_c .="base_protocolo_$protocolo_ter_id.respuesta_$pregunta_id";
				$insert_v .="'".$$respuesta."'";
			}			
		}
		$cnt ++;
	}		
		
		$insert = $insert_c.") ".$insert_v.")";
	    echo $insert;
	    $result_insert = ejecutar($insert);
		
		
		echo "<h1>Capturado</h1><hr>
		<div class='row'>
		  	<div style='padding: 8px' class='col-md-3'>
		  		<a class='btn bg-$body btn-block btn-lg waves-effect' href='protocolo.php?paciente_id=$paciente_id' role='button' >Captura otra</a>
			</div>
	  		<div style='padding: 8px' class='col-md-3'>
	  			<a class='btn bg-red btn-block btn-lg waves-effect'href='https://neuromodulaciongdl.com/menu.php' role='button' >Terminar</a>
			</div>
	  		<div class='col-md-6'>
			</div>			
		</div>
		";	
		
		
		break;	

	case 'protocolo_ordinario':
		
		//print_r($_POST);
		
		$insert = "
			INSERT IGNORE INTO historico_sesion 
			( 	
				historico_sesion.protocolo_ter_id,
				historico_sesion.paciente_id,
				historico_sesion.empresa_id,
				historico_sesion.usuario_id,
				historico_sesion.f_captura,
				historico_sesion.h_captura,
				historico_sesion.umbral,
				historico_sesion.tms_cnt, 
				historico_sesion.tms_d,
				historico_sesion.adverso,
				historico_sesion.observaciones,
				historico_sesion.anodo,
				historico_sesion.catodo,
				historico_sesion.polaridad
			)
				values
			( 
				$protocolo_ter_id,
				$paciente_id,
				$empresa_id,
				$usuario_id,
				'$f_captura',
				'$h_captura',
				$umbral,
				$tms_cnt,
				$tms_d,
				'$adverso',
				'$observaciones',
				'$anodo',
				'$catodo',
				'$polaridad'

			)
		";	
	 // echo $insert."<hr>";
		$result_insert = ejecutar($insert);		


		$sql_hist ="
			SELECT
				max(historico_sesion.historico_id) as historico_id
			FROM
				historico_sesion";
			$result_hist = ejecutar($sql_hist);
			$row_hist = mysqli_fetch_array($result_hist);
			extract($row_hist);	

			
		if (!empty($adversos)) {			
			foreach ($adversos as $valor) {
			
				if ($valor == 'OTROS') {
					$otros = strtoupper($otros);
					$insert = "
						INSERT IGNORE INTO efectos_adversos 
						( 
							protocolo_ter_id,
							paciente_id,
							historico_id,
							adversos
						)
							values
						( 	
							$protocolo_ter_id,
							$paciente_id,
							$historico_id,
							'$otros'							
						)
					";	
					//echo $insert;
					$result_insert = ejecutar($insert);			
				}else{
					$insert = "
						INSERT IGNORE INTO efectos_adversos 
						( 
							protocolo_ter_id,
							paciente_id,
							historico_id,
							adversos
						)
							values
						( 	
							$protocolo_ter_id,
							$paciente_id,
							$historico_id,
							'$valor'							
						)
					";	
					//echo $insert;
					$result_insert = ejecutar($insert);		
				}					
			    //echo $valor . "<br>";
			}			
		}		
		
						
		$sql_valida ="
		SELECT
			*
		FROM
			sesiones
		WHERE
			sesiones.paciente_id = $paciente_id
			and protocolo_ter_id = $protocolo_ter_id
		";
		$result_valida = ejecutar($sql_valida);
		$cnt_valida = mysqli_num_rows($result_valida);
		
		if ($cnt_valida == 0) {
						
			$sql_terapia ="
			SELECT
				terapias.terapia_id
			FROM
				terapias
			WHERE
				terapias.paciente_id = $paciente_id
			";
			//echo $sql_terapia."<hr>";
			$result_terapia = ejecutar($sql_terapia);
			$row_terapia = mysqli_fetch_array($result_terapia);					
			extract($row_terapia);				
			
			$insert = "
				INSERT IGNORE INTO sesiones 
				( 	
					sesiones.terapia_id, 
					sesiones.protocolo_ter_id, 
					sesiones.paciente_id, 
					sesiones.sesiones, 
					sesiones.total_sesion, 
					sesiones.f_alta, 
					sesiones.h_alta
				)
					values
				( 
					$terapia_id,
					$protocolo_ter_id,
					$paciente_id,
					0,
					1,					
					'$f_captura',
					'$h_captura'
				)
			";	
			//echo $insert."<hr>";
			$result_insert = ejecutar($insert);			
		} else {							
			$update = "
				update sesiones
				set
				sesiones.total_sesion = (sesiones.total_sesion +1)
				where sesiones.paciente_id = $paciente_id
				and protocolo_ter_id = $protocolo_ter_id	
				";
			//echo $update."<hr>";
			$result_update = ejecutar($update);				
		}

			$update = "
				update terapias
				set
				terapias.estatus = 'Activo'
				where terapias.paciente_id = $paciente_id	
				";
			//echo $update."<hr>";
			$result_update = ejecutar($update);	


			$update = "
				update pacientes
				set
				pacientes.estatus = 'Activo'
				where pacientes.paciente_id = $paciente_id	
				";
			//echo $update;
			$result_update = ejecutar($update);	

			
			if ($umbral_new == 'ok') {
				$update = "
					update metricas
					set
					metricas.umbral = '$umbral'
					where metricas.paciente_id = $paciente_id	
					";
				//echo $update;
				$result_update = ejecutar($update);	
			}				
					
		echo "<h1>Capturado</h1><hr>
		<div class='row'>
		  	<div style='padding: 8px' class='col-md-3'>
		  		<a class='btn bg-$body btn-block btn-lg waves-effect' href='protocolo.php?paciente_id=$paciente_id' role='button' >Captura otra</a>
			</div>
	  		<div style='padding: 8px' class='col-md-3'>
	  			<a class='btn bg-red btn-block btn-lg waves-effect'href='https://neuromodulaciongdl.com/menu.php' role='button' >Terminar</a>
			</div>
	  		<div class='col-md-6'>
			</div>			
		</div>
		";		
		
		break;		
	
	case 'protocolo_nuevo':

		//print_r($_POST);
		
		if ($umbral =='') {
			$umbral = 0;
		} 
		
		
		$insert = "
			INSERT IGNORE INTO historico_sesion 
			( 	
				historico_sesion.protocolo_ter_id,
				historico_sesion.paciente_id,
				historico_sesion.empresa_id,
				historico_sesion.usuario_id,
				historico_sesion.f_captura,
				historico_sesion.h_captura,
				historico_sesion.umbral,
				historico_sesion.tms_cnt, 
				historico_sesion.tms_d,
				historico_sesion.adverso,
				historico_sesion.observaciones,
				historico_sesion.anodo,
				historico_sesion.catodo,
				historico_sesion.polaridad
			)
				values
			( 
				$protocolo_ter_id,
				$paciente_id,
				$empresa_id,
				$usuario_id,
				'$f_captura',
				'$h_captura',
				$umbral,
				$tms_cnt,
				$tms_d,
				'$adverso',
				'$observaciones',
				'$anodo',
				'$catodo',
				'$polaridad'

			)
		";	
		// echo $insert."<hr>";
		$result_insert = ejecutar($insert);		


		$sql_hist ="
			SELECT
				max(historico_sesion.historico_id) as historico_id
			FROM
				historico_sesion";
			$result_hist = ejecutar($sql_hist);
			$row_hist = mysqli_fetch_array($result_hist);
			extract($row_hist);	

			
		if (!empty($adversos)) {			
			foreach ($adversos as $valor) {
			
				if ($valor == 'OTROS') {
					$otros = strtoupper($otros);
					$insert = "
						INSERT IGNORE INTO efectos_adversos 
						( 
							protocolo_ter_id,
							paciente_id,
							historico_id,
							adversos
						)
							values
						( 	
							$protocolo_ter_id,
							$paciente_id,
							$historico_id,
							'$otros'							
						)
					";	
					//echo $insert;
					$result_insert = ejecutar($insert);			
				}else{
					$insert = "
						INSERT IGNORE INTO efectos_adversos 
						( 
							protocolo_ter_id,
							paciente_id,
							historico_id,
							adversos
						)
							values
						( 	
							$protocolo_ter_id,
							$paciente_id,
							$historico_id,
							'$valor'							
						)
					";	
					//echo $insert;
					$result_insert = ejecutar($insert);		
				}					
			    //echo $valor . "<br>";
			}			
		}		
		
						
		$sql_valida ="
		SELECT
			*
		FROM
			sesiones
		WHERE
			sesiones.paciente_id = $paciente_id
			and protocolo_ter_id = $protocolo_ter_id
		";
		$result_valida = ejecutar($sql_valida);
		$cnt_valida = mysqli_num_rows($result_valida);
		
		if ($cnt_valida == 0) {
						
			$sql_terapia ="
			SELECT
				terapias.terapia_id
			FROM
				terapias
			WHERE
				terapias.paciente_id = $paciente_id
			";
			//echo $sql_terapia."<hr>";
			$result_terapia = ejecutar($sql_terapia);
			$row_terapia = mysqli_fetch_array($result_terapia);					
			extract($row_terapia);				
			
			$insert = "
				INSERT IGNORE INTO sesiones 
				( 	
					sesiones.terapia_id, 
					sesiones.protocolo_ter_id, 
					sesiones.paciente_id, 
					sesiones.sesiones, 
					sesiones.total_sesion, 
					sesiones.f_alta, 
					sesiones.h_alta
				)
					values
				( 
					$terapia_id,
					$protocolo_ter_id,
					$paciente_id,
					0,
					1,					
					'$f_captura',
					'$h_captura'
				)
			";	
			//echo $insert."<hr>";
			$result_insert = ejecutar($insert);			
		} else {							
			$update = "
				update sesiones
				set
				sesiones.total_sesion = (sesiones.total_sesion +1)
				where sesiones.paciente_id = $paciente_id
				and protocolo_ter_id = $protocolo_ter_id	
				";
			//echo $update."<hr>";
			$result_update = ejecutar($update);				
		}

			$update = "
				update terapias
				set
				terapias.estatus = 'Activo'
				where terapias.paciente_id = $paciente_id	
				";
			//echo $update."<hr>";
			$result_update = ejecutar($update);	


			$update = "
				update pacientes
				set
				pacientes.estatus = 'Activo'
				where pacientes.paciente_id = $paciente_id	
				";
			//echo $update;
			$result_update = ejecutar($update);	

			
			if ($umbral_new == 'ok') {
				$update = "
					update metricas
					set
					metricas.umbral = '$umbral'
					where metricas.paciente_id = $paciente_id	
					";
				//echo $update;
				$result_update = ejecutar($update);	
			}	
			
			$tabla_enc = "";		
/// guarda las encuestas
		if (!empty($encuestas)) {
			
				$tabla_enc ="
					<table style='width: 70%' class='table table-bordered'>
						<tr>
							<th>Clinimetria</th>
							<th>Capturado</th>
						</tr>
							";
										
			foreach ($encuestas as $valor) {
				//echo $valor."string";

				
								
				$sql_sem1 = "
					SELECT
						preguntas_encuestas.pregunta_id,
						preguntas_encuestas.encuesta_id,
						preguntas_encuestas.tipo 
					FROM
						preguntas_encuestas 
					WHERE
						preguntas_encuestas.encuesta_id = $valor 
						AND preguntas_encuestas.tipo NOT IN ( 'titulo', 'instrucciones' );
				    ";
					//echo $sql_sem1."<hr>";
					$result_sem1 = ejecutar($sql_sem1);
					$cnt_se1 = mysqli_num_rows($result_sem1);
					
					$insert_c ="INSERT IGNORE INTO base_encuesta_$valor 
						( base_encuesta_$valor.paciente_id,
						  base_encuesta_$valor.usuario_id,
						  base_encuesta_$valor.f_captura,
						  base_encuesta_$valor.h_captura,";
					$insert_v ="values
						( $paciente_id,
						  $usuario_id,
						  '$f_captura',
						  '$h_captura',";	
						$cnt =1;	 
			    while($row_sem1 = mysqli_fetch_array($result_sem1)){
			        extract($row_sem1);
					$respuesta = 'pregunta_'.$pregunta_id;
					if ($tipo <> 'instrucciones' && $tipo <> 'titulo') {						
						if ($cnt_se1 <> $cnt) {
							$insert_c .="base_encuesta_$valor.respuesta_$pregunta_id,";
							$insert_v .="'".$$respuesta."',";
						} else {
							$insert_c .="base_encuesta_$valor.respuesta_$pregunta_id";
							$insert_v .="'".$$respuesta."'";
						}			
					}
					$cnt ++;
				}		
					
					$insert = $insert_c.") ".$insert_v.")";
				    // echo $insert."<hr>";
				    $result_insert = ejecutar($insert);				
				

					$sql_clini = "
					SELECT
						base_encuesta_$valor.paciente_id, 
						base_encuesta_$valor.usuario_id, 
						base_encuesta_$valor.f_captura, 
						base_encuesta_$valor.h_captura
					FROM
						base_encuesta_$valor
					WHERE
						base_encuesta_$valor.paciente_id = $paciente_id AND
						base_encuesta_$valor.usuario_id = $usuario_id AND
						base_encuesta_$valor.f_captura = '$f_captura' AND 
						base_encuesta_$valor.h_captura = '$h_captura'";
					
							$result_valida = ejecutar($sql_clini);
							$cnt_valida = mysqli_num_rows($result_valida);
							if ($cnt_valida ==1) { 
								$exito ="<b><p style='color: green'>Grabado Exitosamente <i class='material-icons'>check</i></p></b>";
							} else {
								$exito ="<b><p style='color: red'>Error no se Grabo <i class='material-icons'>close</i></p></b>";
							}
							
					
					$sql_clini2 = "
					SELECT
						encuestas.encuesta_id, 
						encuestas.encuesta, 
						encuestas.descripcion
					FROM
						encuestas
					WHERE
						encuestas.encuesta_id = $valor";
							$result_valida2 = ejecutar($sql_clini2);
							$row_clini2 = mysqli_fetch_array($result_valida2);
							extract($row_clini2);		
									$tabla_enc .="
											<tr>
												<td>$descripcion</td>
												<td>$exito</td>
											</tr>
												";			
				
				
			}
			
				$tabla_enc .="</tabla>";
		}
		
		
					
		echo "<h1>Capturado</h1>	
		$tabla_enc 
		 
		<div class='row'>
	  	
		  	<div style='padding: 8px' class='col-md-3'>
		  		<a class='btn bg-$body btn-block btn-lg waves-effect' href='protocolo.php?paciente_id=$paciente_id' role='button' >Captura otra</a>
			</div>
	  		<div style='padding: 8px' class='col-md-3'>
	  			<a class='btn bg-red btn-block btn-lg waves-effect'href='https://neuromodulaciongdl.com/menu.php' role='button' >Terminar</a>
			</div>
	  		<div class='col-md-6'>
			</div>			
		</div><hr>
		";				
						
		break;	
					
	default:
		
		break;
}