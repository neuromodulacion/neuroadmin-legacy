<?php
$ruta = '../';
session_start();

// Establecer el nivel de notificación de errores
// error_reporting(E_ALL); // Reemplaza `7` por `E_ALL` para usar la constante más clara y recomendada
// Notificar solamente errores de ejecución
error_reporting(E_ERROR | E_WARNING | E_PARSE);
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

// Incluye archivos PHP necesarios para la funcionalidad adicional
include($ruta.'functions/funciones_mysql.php');
include($ruta.'functions/conexion_mysqli.php');

// Incluir el archivo de configuración y obtener las credenciales
$configPath = $ruta.'../config.php';

if (!file_exists($configPath)) {
    die('Archivo de configuración no encontrado.');
}

$config = require $configPath;

// Crear una instancia de la clase Mysql
$mysql = new Mysql($config['servidor'], $config['usuario'], $config['contrasena'], $config['baseDatos']);

include('fun_protocolo.php');

$ruta = "../";
extract($_SESSION);
extract($_POST);

function tildes($palabra) {
    //Rememplazamos caracteres especiales latinos minusculas
    $encuentra = array('&','<','>','¢','£','¥','€','©','®','™','§','†','‡','¶','•','…','±','¹','²','³','½','¼','¾','µ','°','√','∞','Ω','Σ','μ','←','→','↑','↓','↔','↵','⇐','⇒'
);
     $remplaza = array('&amp;','&lt','&gt','&cent','&pound','&yen','&euro','&copy','&reg','&trade','&sect','&dagger','&Dagger','&para','&bull','&hellip','&plusmn','&sup1','&sup2','&sup3','&frac12','&frac14','&frac34','&micro','&deg','&radic','&infin','&ohm','&sigma','&mu','&larr','&rarr','&uarr','&darr','&harr','&crarr','&lArr','&rArr'

);
    $palabra = str_replace($encuentra, $remplaza, $palabra);
return $palabra;
}

//echo "<hr>";
//print_r($_SESSION);
//echo "<hr>";
//print_r($_POST);
//echo "<hr>";

// echo "<hr>";
$observaciones = stripslashes($_POST['observaciones']); 
$observaciones = tildes($observaciones);

$f_captura = date("Y-m-d");
$h_captura = date("H:i:s");

$anodo          = !empty($_POST['anodo']) ? $_POST['anodo'] : '';
$catodo         = !empty($_POST['catodo']) ? $_POST['catodo'] : '';
$polaridad      = !empty($_POST['polaridad']) ? $_POST['polaridad'] : '';
$umbral         = !empty($_POST['umbral']) ? $_POST['umbral'] : '';
$tms_cnt        = !empty($_POST['tms_cnt']) ? $_POST['tms_cnt'] : '';
$tms_d          = !empty($_POST['tms_d']) ? $_POST['tms_d'] : '';
$adverso        = !empty($_POST['adverso']) ? $_POST['adverso'] : '';
$observaciones  = !empty($_POST['observaciones']) ? $_POST['observaciones'] : '';
$umbral_new     = !empty($_POST['umbral_new']) ? $_POST['umbral_new'] : '';

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
		
		break;

	case 'encuesta':
		
		echo elementos($protocolo_ter_id);
		
		break;

	case 'preguntas_protocolo':
		//creo que este ya no se utiliza falta validar
		//print_r($_POST);
		//$total_sesion = ($total_sesion+1);
		// guardar la captura de la sesion
		$insert = "
			INSERT IGNORE INTO historico_sesion 
			( 	
				historico_sesion.protocolo_ter_id,
				historico_sesion.paciente_id,
				historico_sesion.empresa_id,
				historico_sesion.usuario_id,
				historico_sesion.sesion,
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
				$total_sesion,
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

		// ejecutar_id devuelve el id del registro insertado	
		$historico_id = ejecutar_id($insert);		
		/*
		$result_insert = ejecutar($insert);
		$sql_hist ="
			SELECT
				max(historico_sesion.historico_id) as historico_id
			FROM
				historico_sesion";
			$result_hist = ejecutar($sql_hist);
			$row_hist = mysqli_fetch_array($result_hist);
			extract($row_hist);	*/

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

		//****************falta guardar las preguntas tengo dudas cone esta seccion
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
			  base_protocolo_$protocolo_ter_id.historico_id,
			  base_protocolo_$protocolo_ter_id.empresa_id,
			  base_protocolo_$protocolo_ter_id.f_captura,
			  base_protocolo_$protocolo_ter_id.h_captura,";

		$insert_v ="values
			( $paciente_id,
			  $usuario_id,
			  $historico_id,
			  $empresa_id,
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
		//$total_sesion = ($total_sesion+1);

		$insert = "
			INSERT IGNORE INTO historico_sesion 
			( 	
				historico_sesion.protocolo_ter_id,
				historico_sesion.paciente_id,
				historico_sesion.empresa_id,
				historico_sesion.usuario_id,
				historico_sesion.sesion,
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
				$total_sesion,
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
		//echo $insert."<hr>";	
		//$historico_id = ejecutar_id($insert);
		
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
		//revisado y funcionando
		//print_r($_POST);
		//$total_sesion = ($total_sesion+1);

		if ($umbral =='') {
			$umbral = 0;
		} 
		
			// Consulta SQL con placeholders
			$query = "
				INSERT IGNORE INTO historico_sesion 
				(
					protocolo_ter_id,
					paciente_id,
					empresa_id,
					usuario_id,
					sesion,
					f_captura,
					h_captura,
					umbral,
					tms_cnt, 
					tms_d,
					adverso,
					observaciones,
					anodo,
					catodo,
					polaridad
				) 
				VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
			";
		
			// Parámetros para la consulta
			$params = [
				$protocolo_ter_id,  // int
				$paciente_id,       // int
				$empresa_id,        // int
				$usuario_id,        // int
				$total_sesion,      // int
				$f_captura,         // string (fecha en formato 'YYYY-MM-DD')
				$h_captura,         // string (hora en formato 'HH:MM:SS')
				$umbral,            // int
				$tms_cnt,           // int
				$tms_d,             // int
				$adverso,           // string
				$observaciones,     // string
				$anodo,             // string
				$catodo,            // string
				$polaridad          // string
			];
		
			// Ejecutar la consulta
			$resultado = $mysql->consulta_simple($query, $params);
		
			if ($resultado) {
				//echo "Registro insertado exitosamente <br>.";
			} else {
				//echo "Error al insertar el registro <br>. ".$resultado;
			}

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

					// Consulta SQL con placeholders
					$query = "
						INSERT IGNORE INTO efectos_adversos 
						(
							protocolo_ter_id,
							paciente_id,
							historico_id,
							adversos
						) 
						VALUES (?, ?, ?, ?)
					";

					// Parámetros para la consulta
					$params = [
						$protocolo_ter_id,  // int
						$paciente_id,       // int
						$historico_id,      // int
						$otros              // string
					];

					// Ejecutar la consulta
					$resultado = $mysql->consulta_simple($query, $params);

					if ($resultado) {
						//echo "Registro insertado exitosamente.";
					} else {
						//echo "Error al insertar el registro. ".$resultado;
					}								
				}else{
					// Consulta SQL con placeholders
					$query = "
						INSERT IGNORE INTO efectos_adversos 
						(
							protocolo_ter_id,
							paciente_id,
							historico_id,
							adversos
						) 
						VALUES (?, ?, ?, ?)
					";

					// Parámetros para la consulta
					$params = [
						$protocolo_ter_id,  // int
						$paciente_id,       // int
						$historico_id,      // int
						$valor              // string
					];

					// Ejecutar la consulta
					$resultado = $mysql->consulta_simple($query, $params);

					if ($resultado) {
						//echo "Registro insertado exitosamente.";
					} else {
						//echo "Error al insertar el registro.";
					}		
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
			
			// Consulta SQL con placeholders
			$query = "
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
				VALUES (?, ?, ?, ?, ?, ?, ?)
			";

			// Parámetros para la consulta
			$params = [
				$terapia_id,        // int
				$protocolo_ter_id,  // int
				$paciente_id,       // int
				0,                  // int (valor fijo)
				1,                  // int (valor fijo)
				$f_captura,         // string (fecha en formato 'YYYY-MM-DD')
				$h_captura          // string (hora en formato 'HH:MM:SS')
			];

			// Ejecutar la consulta
			$resultado = $mysql->consulta_simple($query, $params);

			if ($resultado) {
				//echo "Registro insertado exitosamente.";
			} else {
				//echo "Error al insertar el registro.";
			}			
		} else {							
			// Consulta SQL con placeholders
			$query = "
				UPDATE sesiones
				SET sesiones.total_sesion = sesiones.total_sesion + 1
				WHERE sesiones.paciente_id = ? 
				AND sesiones.protocolo_ter_id = ?
			";

			// Parámetros para la consulta
			$params = [
				$paciente_id,       // int
				$protocolo_ter_id   // int
			];

			// Ejecutar la consulta
			$resultado = $mysql->consulta_simple($query, $params);

			if ($resultado) {
				echo "Registro actualizado exitosamente.";
			} else {
				echo "Error al actualizar el registro.";
			}			
		}

			// Consulta SQL con placeholders
			$query = "
				UPDATE terapias
				SET terapias.estatus = ?
				WHERE terapias.paciente_id = ?
			";

			// Parámetros para la consulta
			$params = [
				'Activo',       // string
				$paciente_id    // int
			];

			// Ejecutar la consulta
			$resultado = $mysql->consulta_simple($query, $params);

			if ($resultado) {
				echo "Registro actualizado exitosamente.";
			} else {
				echo "Error al actualizar el registro.";
			}

			// Consulta SQL con placeholders
			$query = "
				UPDATE pacientes
				SET pacientes.estatus = ?
				WHERE pacientes.paciente_id = ?
			";

			// Parámetros para la consulta
			$params = [
				'Activo',       // string
				$paciente_id    // int
			];

			// Ejecutar la consulta
			$resultado = $mysql->consulta_simple($query, $params);

			if ($resultado) {
				echo "Registro actualizado exitosamente.";
			} else {
				echo "Error al actualizar el registro.";
			}	

			if ($umbral_new == 'ok') {
				// Consulta SQL con placeholders
				$query = "
					UPDATE metricas
					SET metricas.umbral = ?
					WHERE metricas.paciente_id = ?
				";

				// Parámetros para la consulta
				$params = [
					$umbral,        // string o numérico (dependiendo del tipo de dato en la base de datos)
					$paciente_id    // int
				];

				// Ejecutar la consulta
				$resultado = $mysql->consulta_simple($query, $params);

				if ($resultado) {
					echo "Registro actualizado exitosamente.";
				} else {
					echo "Error al actualizar el registro.";
				}
			}	
			
			$tabla_enc = "";		
		/// guarda las encuestas
		if (!empty($encuestas)) {	
			$tabla_enc ="
				<table style='width: 70%' class='table table-bordered'>
					<tr>
						<th>Clinimetria</th>
						<th>Capturado</th>
						<th>Resultado</th>
					</tr>
						";
										
			foreach ($encuestas as $valor) {
				//echo $valor."string";	
				
				$sql_bases = "
				SELECT
					base_encuesta_$valor.base_id,
					base_encuesta_$valor.paciente_id,
					base_encuesta_$valor.usuario_id,
					base_encuesta_$valor.f_captura,
					base_encuesta_$valor.h_captura,";	

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
						  base_encuesta_$valor.historico_id,
						  base_encuesta_$valor.empresa_id,
						  base_encuesta_$valor.f_captura,
						  base_encuesta_$valor.h_captura,";

					$insert_v ="values
						( $paciente_id,
						  $usuario_id,
						  $historico_id,
						  $empresa_id,
						  '$f_captura',
						  '$h_captura',";	
						$cnt =1;	 
						$sql_basesX = "";
						$wherex = "";
			    while($row_sem1 = mysqli_fetch_array($result_sem1)){
			        extract($row_sem1);
					$respuesta = 'pregunta_'.$pregunta_id;

					// se construye la qwuery para guardar las respuestas
					if ($tipo <> 'instrucciones' && $tipo <> 'titulo') {						
						if ($cnt_se1 <> $cnt) {
							$insert_c .="base_encuesta_$valor.respuesta_$pregunta_id,";
							$insert_v .="'".$$respuesta."',";
						} else {
							$insert_c .="base_encuesta_$valor.respuesta_$pregunta_id";
							$insert_v .="'".$$respuesta."'";
						}			
					}
					
					// estamos construyendo la consulta para sumar las respuestas y tener los resultados
					$sql_basesX .= "
					( SELECT DISTINCT respuestas.valor FROM respuestas WHERE respuestas.respuesta LIKE base_encuesta_$encuesta_id.respuesta_$pregunta_id and respuestas.encuesta_id = $encuesta_id )+";
					//echo $cnt." - ".$pregunta_id."<br>";
					if ( $cnt == 1) {
						//echo $cnt." - ".$pregunta_id."<br>";
						$wherex .= "AND base_encuesta_$valor.respuesta_$pregunta_id <>''";
					}

					$cnt ++;
				}		
					
					$insert = $insert_c.") ".$insert_v.")";
				    // echo $insert."<hr>";
					//$base_id = ejecutar_id($insert);
				    $result_insert = ejecutar($insert);				
					//echo $insert."<hr>";
					$sql_base_id ="
					SELECT
						max(base_encuesta_$valor.base_id) as base_id
					FROM	
						base_encuesta_$valor";
					$result_base_id = ejecutar($sql_base_id);
					$row_base_id = mysqli_fetch_array($result_base_id);
					extract($row_base_id);
					//echo $base_id."<hr>";

					// ------------------- se construye la consulta para sumar las respuestas y tener los resultados
					$sql_basesX = substr($sql_basesX, 0, -1);
					$sql_bases .= "
						$sql_basesX as total
					FROM
						base_encuesta_$encuesta_id
					WHERE
						base_encuesta_$encuesta_id.paciente_id = $paciente_id 
						$wherex
						AND base_encuesta_$valor.base_id = $base_id
					ORDER BY f_captura DESC";
					//echo $sql_bases."<hr>";
					$result_bases = ejecutar($sql_bases);
					$row_bases = mysqli_fetch_array($result_bases);
					extract($row_bases);
					//echo $total."<hr>";
					//echo $valor."<hr>";

					//-------------------- fin de la consulta para sumar las respuestas y tener los resultados
					if ($total_sesion !== 1 and $valor == 11) {
						$extra = " AND calificaciones.extra = 'ok'"; 
					}else{
						$extra = " AND calificaciones.extra <> 'ok'";
					}
					//--- poner los resultados en tablas de la encuesta
					if ($valor == 11) {
						$update = "
							UPDATE base_encuesta_11
							INNER JOIN historico_sesion
								ON base_encuesta_11.historico_id = historico_sesion.historico_id
							SET base_encuesta_11.total = 
								CASE
									WHEN historico_sesion.sesion = 1 THEN
										(SELECT DISTINCT respuestas.valor 
										FROM respuestas 
										WHERE respuestas.respuesta LIKE base_encuesta_11.respuesta_125 
										AND respuestas.encuesta_id = 11 
										LIMIT 1)
									ELSE
										(SELECT DISTINCT respuestas.valor 
										FROM respuestas 
										WHERE respuestas.respuesta LIKE base_encuesta_11.respuesta_127 
										AND respuestas.encuesta_id = 11 
										LIMIT 1)
								END
							WHERE 
								base_encuesta_11.paciente_id = $paciente_id AND
								((historico_sesion.sesion = 1 AND base_encuesta_11.respuesta_125 <> '') OR
								(historico_sesion.sesion > 1 AND base_encuesta_11.respuesta_127 <> ''));
						";
					}else{
						$update = "
							UPDATE base_encuesta_$valor
							set
							base_encuesta_$valor.total = $total
							where base_encuesta_$valor.base_id = $base_id
							";
							
					}
					//echo $update." xxx<hr>";
					$result_update = ejecutar($update);
					//-------------------- fin de la consulta con resultados

					$sql_clini = "
					SELECT DISTINCT
						base_encuesta_$valor.paciente_id, 
						base_encuesta_$valor.usuario_id, 
						base_encuesta_$valor.f_captura, 
						base_encuesta_$valor.h_captura,
						base_encuesta_$valor.total,
						(SELECT DISTINCT valor FROM calificaciones WHERE encuesta_id = $valor AND min <= base_encuesta_$valor.total and max >= base_encuesta_$valor.total $extra) as evaluacion,
						(SELECT DISTINCT color FROM calificaciones WHERE encuesta_id = $valor AND min <= base_encuesta_$valor.total and max >= base_encuesta_$valor.total $extra) as color
					FROM
						base_encuesta_$valor
					WHERE
						base_encuesta_$valor.paciente_id = $paciente_id AND
						base_encuesta_$valor.usuario_id = $usuario_id AND
						base_encuesta_$valor.f_captura = '$f_captura' AND 
						base_encuesta_$valor.h_captura = '$h_captura'";
					
						//echo $sql_clini;
						$result_valida = ejecutar($sql_clini);
						$cnt_valida = mysqli_num_rows($result_valida);
						$row_valida = mysqli_fetch_array($result_valida);
						extract($row_valida);
						$resultado = $total;

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
												<td style='background-color: $color'>$evaluacion</td>
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