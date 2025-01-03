<?php
// Iniciar la sesión del usuario
session_start();

// Configurar el nivel de reporte de errores (7 muestra errores y advertencias)
error_reporting(7);

// Establecer la codificación interna a UTF-8 para las funciones de conversión de cadenas
iconv_set_encoding('internal_encoding', 'utf-8');

// Enviar cabecera HTTP para especificar que el contenido es HTML con codificación UTF-8
header('Content-Type: text/html; charset=UTF-8');

// Establecer la zona horaria predeterminada
date_default_timezone_set('America/Monterrey');

// Configurar la localización en español para fechas y horas
setlocale(LC_TIME, 'es_ES.UTF-8');

// Guardar la hora actual en la sesión
$_SESSION['time'] = time();

// Definir la ruta base para acceder a otros archivos
$ruta = "../";


extract($_SESSION);
extract($_POST);
extract($_GET);
//print_r($_SESSION);
// 1. Capturamos la variable que viene por GET. 
//    Si no viene nada, por defecto usamos 'TMS' (o lo que tú consideres).
$tipo_terapia = isset($_GET['tipo_terapia']) ? $_GET['tipo_terapia'] : '';

$hoy = date("Y-m-d");
$ahora = date("H:i:00"); 
$anio = date("Y");
$mes_ahora = date("m");
$mes = date("m");
$dia = date("N");
$semana = date("W");
$titulo ="ANALISIS";




include($ruta.'functions/funciones_mysql.php');
include($ruta.'functions/fotografia.php');
//include($ruta.'uso.php');
include($ruta.'paciente/calendario.php');

include($ruta.'paciente/fun_paciente.php');
//uso($usuario_id);
//'..'.
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <html lang="es">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title><?php echo $titulo; ?></title>
    
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>   
    <!-- <script src="<?php echo $ruta; ?>js/jquery-3.3.1.min.js"></script>  -->    
    <!-- Favicon-->
    <link rel="icon" href="<?php echo $ruta.$icono; ?>" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="<?php echo $ruta; ?>plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="<?php echo $ruta; ?>plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="<?php echo $ruta; ?>plugins/animate-css/animate.css" rel="stylesheet" />
<!-- *************Tronco comun ******************** -->  


<!-- *************Tronco comun ******************** --> 
    <!-- Custom Css -->
    <link href="<?php echo $ruta; ?>css/style.css" rel="stylesheet">

    <!-- AdminTMS Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="<?php echo $ruta; ?>css/themes/all-themes.css" rel="stylesheet" />


		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>

		   
</head>

<body style="background-color: #fff; text-align: center;">
<script src="../highcharts/js/highcharts.js"></script>
<script src="../highcharts/js/highcharts-more.js"></script>
<script src="../highcharts/js/modules/exporting.js"></script>


	<h1 align="center">Analisis</h1>
	<hr>
	<!-- <form method="GET" action="analisis.php"> -->
	<form method="GET" action="test.php">
    <label for="tipo_terapia">Tipo de terapia:</label>
    <select name="tipo_terapia" id="tipo_terapia">
        <option value="TMS">Solo TMS</option>
        <option value="tDCS">Solo tDCS</option>
        <option value="ambas">TMS y tDCS</option>
    </select>
    
    <button type="submit">Consultar</button>
</form>
	<hr>
	<?php	
	if ($tipo_terapia <> 'TMS' && $tipo_terapia <> 'tDCS' && $tipo_terapia <> 'ambas') {
		echo "<h1>No se ha seleccionado un tipo de terapia.</h1>";
	}else{ ?>
		<h2>Resultados para: <?php echo $tipo_terapia; ?></h2>

	<div class="row">
		<div align="center" class="col-md-12">
			<h1>PHQ9 y GAD7 de <?php echo $tipo_terapia; ?></h1>
	  		<table style="width: 80%; font-size: 12px" class="table table-bordered">								  			
	  			<tr>
	  				<th colspan="5"  style="text-align: center" >DATOS</th>
	  				
	  				<th colspan="3" style="text-align: center" >PHQ9</th>
	  				
	  				<th colspan="3" style="text-align: center" >GAD7</th>	
	  				
	  				<th style="text-align: center" >Protocolos</th>  					  				
	  			</tr>
	  			<tr>
	  				<th style="text-align: center" >Cnt</th>
	  				<th style="text-align: center" ># Id</th>
	  				<th style="text-align: center" >Sexo</th>
	  				<th style="text-align: center" >Edad</th>
	  				<th style="text-align: center" >Diagnostico</th>
	  				
	  				<th style="text-align: center" >BASAL</th>
	  				<th style="text-align: center" >INTER</th>
	  				<th style="text-align: center" >FINAL</th>
	  				
	  				<th style="text-align: center" >BASAL</th>
	  				<th style="text-align: center" >INTER</th>
	  				<th style="text-align: center" >FINAL</th>	
	  				
	  				<th style="text-align: center" >Protocolos</th>  					  				
	  			</tr>
	  			<?php
	  			
				$delete = "DELETE FROM analisis_phq9_gad7";
				$result = ejecutar($delete);	  			
	  			
				$filtro_terapia = "";
				if ($tipo_terapia === 'TMS') {
					$filtro_terapia = "AND protocolo_terapia.terapia = 'TMS'";
				} elseif ($tipo_terapia === 'tDCS') {
					$filtro_terapia = "AND protocolo_terapia.terapia = 'tDCS'";
				} elseif ($tipo_terapia === 'ambas') {
					$filtro_terapia = "AND protocolo_terapia.terapia IN ('TMS', 'tDCS')";
				} else {
					// Por si el valor es desconocido; puedes setear un valor por defecto:
					$filtro_terapia = "AND protocolo_terapia.terapia = 'TMS'";
				}
				
				$sql_cobro = "
					SELECT DISTINCT
						pacientes.paciente_id,
						pacientes.f_nacimiento,
						pacientes.sexo,
						pacientes.diagnostico,
						( SELECT COUNT(*) AS total FROM base_encuesta_1 WHERE base_encuesta_1.paciente_id = pacientes.paciente_id ) AS phq,
						( SELECT COUNT(*) AS total FROM base_encuesta_2 WHERE base_encuesta_2.paciente_id = pacientes.paciente_id ) AS gad,
						protocolo_terapia.terapia 
					FROM
						pacientes
						INNER JOIN historico_sesion 
							ON pacientes.paciente_id = historico_sesion.paciente_id
						INNER JOIN protocolo_terapia 
							ON historico_sesion.protocolo_ter_id = protocolo_terapia.protocolo_ter_id 
					WHERE
						pacientes.empresa_id = 1
						$filtro_terapia
				";
				
				// echo $sql_cobro."<br>";
				$cnt_g = 1;
	  			$result_cob=ejecutar($sql_cobro);
		    	while($row_cob = mysqli_fetch_array($result_cob)){
			    	extract($row_cob);	
					$edad = obtener_edad_segun_fecha($f_nacimiento);
					
					//echo $phq."<hr>";
					
					if ($phq >= 3 && $gad >= 3) {
						

					$sql_PHQ9 = "
						SELECT DISTINCT
							historico_sesion.f_captura, 
							base_encuesta_1.total, 
							protocolo_terapia.terapia
						FROM
							pacientes
							INNER JOIN
							base_encuesta_1 ON pacientes.paciente_id = base_encuesta_1.paciente_id INNER JOIN historico_sesion
							ON 
								base_encuesta_1.paciente_id = historico_sesion.paciente_id AND
								base_encuesta_1.f_captura = historico_sesion.f_captura AND
								base_encuesta_1.h_captura = historico_sesion.h_captura
							INNER JOIN
							protocolo_terapia
							ON 
								historico_sesion.protocolo_ter_id = protocolo_terapia.protocolo_ter_id
						WHERE
							base_encuesta_1.respuesta_3 <> ''
							AND historico_sesion.paciente_id = $paciente_id
							$filtro_terapia
						ORDER BY
							historico_sesion.f_captura ASC
						LIMIT 3					  			
			  			";
						//echo $sql_PHQ9."<br>";
						$cnt_PHQ9 = 1;
			  			$result_PHQ9=ejecutar($sql_PHQ9);
				    	while($row_PHQ9 = mysqli_fetch_array($result_PHQ9)){				    	
					    	extract($row_PHQ9);					    	
					    	if ($cnt_PHQ9 == 1) {
								$basal_phq = $total;
							} 
					    	if ($cnt_PHQ9 == 2) {
								$inter_phq = $total;
							}							
					    	if ($cnt_PHQ9 == 3) {
								$final_phq = $total;
							}					    	

					    	$cnt_PHQ9++;					    	
				    	}

						// <tr>
							// <td>Protocolo</td>
							// <td>Cantidad</td>
						// </tr>				    	
				    						
					$tabla ="
					<table class='table table-bordered'>
					
					";
										
					$sql_terapia ="
					SELECT
						historico_sesion.paciente_id,
						protocolo_terapia.prot_terapia,
						COUNT(*) as cnt
					FROM
						historico_sesion
						INNER JOIN protocolo_terapia ON historico_sesion.protocolo_ter_id = protocolo_terapia.protocolo_ter_id 
					WHERE
						historico_sesion.paciente_id = $paciente_id 
						AND historico_sesion.f_captura <= '$f_captura'
						$filtro_terapia 
					GROUP BY
						1,2					
					";
			  			$result_terapia=ejecutar($sql_terapia);
				    	while($row_terapia = mysqli_fetch_array($result_terapia)){				    	
					    	extract($row_terapia);	

						$tabla .="
							<tr>
								<td>$prot_terapia</td>
								<td>$cnt</td>
							</tr>					
						";							

							
						}	
						
					$tabla .="
					</table>					
					";										
							
					//echo $tabla."<hr>";		
							
					$sql_GAD7 = "
					SELECT DISTINCT
						historico_sesion.f_captura,
						base_encuesta_2.total AS total_g,
						protocolo_terapia.terapia 
					FROM
						pacientes
						INNER JOIN base_encuesta_2 ON pacientes.paciente_id = base_encuesta_2.paciente_id
						INNER JOIN historico_sesion ON base_encuesta_2.paciente_id = historico_sesion.paciente_id 
							AND base_encuesta_2.f_captura = historico_sesion.f_captura 
							AND base_encuesta_2.h_captura = historico_sesion.h_captura
						INNER JOIN protocolo_terapia ON historico_sesion.protocolo_ter_id = protocolo_terapia.protocolo_ter_id 
					WHERE
						base_encuesta_2.respuesta_14 <> '' 
						AND base_encuesta_2.paciente_id = $paciente_id
						$filtro_terapia
					ORDER BY
						pacientes.paciente_id ASC,
						base_encuesta_2.f_captura ASC
						LIMIT 3				  			
			  			";
						//echo $sql_PHQ9."<br>";
						$final_gad = 0;
						$cnt_GAD7 = 1;
			  			$result_GAD7=ejecutar($sql_GAD7);
				    	while($row_GAD7 = mysqli_fetch_array($result_GAD7)){				    	
					    	extract($row_GAD7);					    	
					    	if ($cnt_GAD7 == 1) {
								$basal_gad = $total_g;
							} 
					    	if ($cnt_GAD7 == 2) {
								$inter_gad = $total_g;
							}							
					    	if ($cnt_GAD7 == 3) {
								$final_gad = $total_g;
							}					    	

					    	$cnt_GAD7++;					    	
				    	}					
				
						$basal_phq  = !empty($basal_phq)  ? $basal_phq  : 0;
						$inter_phq  = !empty($inter_phq) ? $inter_phq  : 0;
						$final_phq  = !empty($final_phq) ? $final_phq  : 0;
						$basal_gad  = !empty($basal_gad) ? $basal_gad  : 0;
						$inter_gad  = !empty($inter_gad)? $inter_gad  : 0;
						$final_gad  = !empty($final_gad)? $final_gad  : 0;
						
						
				
				$insert ="
				INSERT INTO analisis_phq9_gad7 (
					analisis_phq9_gad7.paciente_id,
					analisis_phq9_gad7.sexo,
					analisis_phq9_gad7.edad,
					analisis_phq9_gad7.basal_phq9,
					analisis_phq9_gad7.inter_phq9,
					analisis_phq9_gad7.final_phq9,
					analisis_phq9_gad7.basal_gad7,
					analisis_phq9_gad7.inter_gad7,
					analisis_phq9_gad7.final_gad7 
				)
				VALUES
					(
					$paciente_id,
					'$sexo',
					$edad,
					$basal_phq,
					$inter_phq,
					$final_phq,
					$basal_gad,
					$inter_gad,
					$final_gad
					)							
				";	
				//echo $insert."<hr>";				
				$result = ejecutar_id($insert);	
	  			?>
	  			<tr>
	  				<td style="text-align: center"><?php echo $cnt_g ; ?></td>
	  				<td style="text-align: center"><?php echo $paciente_id ; ?></td>
	  				<td style="text-align: center"><?php echo $sexo; ?></td>
	  				<td style="text-align: center"><?php echo $edad; ?></td>
	  				<td style="text-align: center"><?php echo $diagnostico; ?></td>
	  				
	  				<td style="text-align: center"><?php echo $basal_phq; ?></td>
	  				<td style="text-align: center"><?php echo $inter_phq; ?></td>
	  				<td style="text-align: center"><?php echo $final_phq; ?></td>
	  				
	  				<td style="text-align: center"><?php echo $basal_gad; ?></td>
	  				<td style="text-align: center"><?php echo $inter_gad; ?></td>
	  				<td style="text-align: center"><?php echo $final_gad; ?></td>
	  				
	  				<td style="text-align: center"><?php echo $tabla; ?></td>
	  			</tr>
	  			<?php 
					    	$basal_gad = '';
					    	$inter_gad = '';
					    	$final_gad = '';
					$cnt_g++;		
					}
										
				} ?>

  			</table>	

  		<?php
  		
  		$sql ="SET @rowindex := -1";
  		$result = ejecutar($sql);
		
  		$sql ="
		SELECT
			MAX( basal_phq9 ) AS Maximo_basal_phq9,
			SUBSTRING_INDEX( SUBSTRING_INDEX( GROUP_CONCAT( basal_phq9 ORDER BY basal_phq9 SEPARATOR ',' ), ',', 75 / 100 * COUNT(*)), ',', - 1 ) AS Cuartil_Superior_basal_phq9,
			(SUBSTRING_INDEX( SUBSTRING_INDEX( GROUP_CONCAT( basal_phq9 ORDER BY basal_phq9 SEPARATOR ',' ), ',', 50 / 100 * COUNT(*) + 1 ), ',', - 1 ) + 
			SUBSTRING_INDEX( SUBSTRING_INDEX( GROUP_CONCAT( basal_phq9 ORDER BY basal_phq9 SEPARATOR ',' ), ',', 50 / 100 * COUNT(*)), ',', - 1 )) / 2 AS Mediana_basal_phq9,
			SUBSTRING_INDEX( SUBSTRING_INDEX( GROUP_CONCAT( basal_phq9 ORDER BY basal_phq9 SEPARATOR ',' ), ',', 25 / 100 * COUNT(*)), ',', - 1 ) AS Cuartil_Inferior_basal_phq9,
			MIN( basal_phq9 ) AS Minimo_basal_phq9 
		FROM
			analisis_phq9_gad7
  		";
		// echo $sql."<hr>";
  		$result = ejecutar($sql);		
  		$row_basal_phq9 = mysqli_fetch_array($result);
		extract($row_basal_phq9);
		// print_r($row_basal_phq9);

  		$sql ="
		SELECT
			MAX( inter_phq9 ) AS Maximo_inter_phq9,
			SUBSTRING_INDEX( SUBSTRING_INDEX( GROUP_CONCAT( inter_phq9 ORDER BY inter_phq9 SEPARATOR ',' ), ',', 75 / 100 * COUNT(*)), ',', - 1 ) AS Cuartil_Superior_inter_phq9,
			(SUBSTRING_INDEX( SUBSTRING_INDEX( GROUP_CONCAT( inter_phq9 ORDER BY inter_phq9 SEPARATOR ',' ), ',', 50 / 100 * COUNT(*) + 1 ), ',', - 1 ) + 
             SUBSTRING_INDEX( SUBSTRING_INDEX( GROUP_CONCAT( inter_phq9 ORDER BY inter_phq9 SEPARATOR ',' ), ',', 50 / 100 * COUNT(*)), ',', - 1 )) / 2 AS Mediana_inter_phq9,
			SUBSTRING_INDEX( SUBSTRING_INDEX( GROUP_CONCAT( inter_phq9 ORDER BY inter_phq9 SEPARATOR ',' ), ',', 25 / 100 * COUNT(*)), ',', - 1 ) AS Cuartil_Inferior_inter_phq9,
			MIN( inter_phq9 ) AS Minimo_inter_phq9 
		FROM
			analisis_phq9_gad7
  		";
  		// echo $sql."<hr>";
  		$result = ejecutar($sql);		
  		$row_basal_phq9 = mysqli_fetch_array($result);
		extract($row_basal_phq9);
		// print_r($row_basal_phq9);		

  		$sql ="
		SELECT
			MAX( final_phq9 ) AS Maximo_final_phq9,
			SUBSTRING_INDEX( SUBSTRING_INDEX( GROUP_CONCAT( final_phq9 ORDER BY final_phq9 SEPARATOR ',' ), ',', 75 / 100 * COUNT(*)), ',', - 1 ) AS Cuartil_Superior_final_phq9,
			(SUBSTRING_INDEX( SUBSTRING_INDEX( GROUP_CONCAT( final_phq9 ORDER BY final_phq9 SEPARATOR ',' ), ',', 50 / 100 * COUNT(*) + 1 ), ',', - 1 ) + 
			SUBSTRING_INDEX( SUBSTRING_INDEX( GROUP_CONCAT( final_phq9 ORDER BY final_phq9 SEPARATOR ',' ), ',', 50 / 100 * COUNT(*)), ',', - 1 )) / 2 AS Mediana_final_phq9,
			SUBSTRING_INDEX( SUBSTRING_INDEX( GROUP_CONCAT( final_phq9 ORDER BY final_phq9 SEPARATOR ',' ), ',', 25 / 100 * COUNT(*)), ',', - 1 ) AS Cuartil_Inferior_final_phq9,
			MIN( final_phq9 ) AS Minimo_final_phq9 
		FROM
			analisis_phq9_gad7
  		";
  		// echo $sql."<hr>";
  		$result = ejecutar($sql);		
  		$row_basal_phq9 = mysqli_fetch_array($result);
		extract($row_basal_phq9);
		// print_r($row_basal_phq9);	
		
		/***************************************************************************************************************************************/
		
  		$sql ="
		SELECT
			MAX( basal_gad7 ) AS Maximo_basal_gad7,
			SUBSTRING_INDEX( SUBSTRING_INDEX( GROUP_CONCAT( basal_gad7 ORDER BY basal_gad7 SEPARATOR ',' ), ',', 75 / 100 * COUNT(*)), ',', - 1 ) AS Cuartil_Superior_basal_gad7,
			(SUBSTRING_INDEX( SUBSTRING_INDEX( GROUP_CONCAT( basal_gad7 ORDER BY basal_gad7 SEPARATOR ',' ), ',', 50 / 100 * COUNT(*) + 1 ), ',', - 1 ) + 
			SUBSTRING_INDEX( SUBSTRING_INDEX( GROUP_CONCAT( basal_gad7 ORDER BY basal_gad7 SEPARATOR ',' ), ',', 50 / 100 * COUNT(*)), ',', - 1 )) / 2 AS Mediana_basal_gad7,
			SUBSTRING_INDEX( SUBSTRING_INDEX( GROUP_CONCAT( basal_gad7 ORDER BY basal_gad7 SEPARATOR ',' ), ',', 25 / 100 * COUNT(*)), ',', - 1 ) AS Cuartil_Inferior_basal_gad7,
			MIN( basal_gad7 ) AS Minimo_basal_gad7 
		FROM
			analisis_phq9_gad7
  		";
		// echo $sql."<hr>";
  		$result = ejecutar($sql);		
  		$row_basal_gad7 = mysqli_fetch_array($result);
		extract($row_basal_gad7);
		// print_r($row_basal_gad7);

  		$sql ="
		SELECT
			MAX( inter_gad7 ) AS Maximo_inter_gad7,
			SUBSTRING_INDEX( SUBSTRING_INDEX( GROUP_CONCAT( inter_gad7 ORDER BY inter_gad7 SEPARATOR ',' ), ',', 75 / 100 * COUNT(*)), ',', - 1 ) AS Cuartil_Superior_inter_gad7,
			(SUBSTRING_INDEX( SUBSTRING_INDEX( GROUP_CONCAT( inter_gad7 ORDER BY inter_gad7 SEPARATOR ',' ), ',', 50 / 100 * COUNT(*) + 1 ), ',', - 1 ) + 
            SUBSTRING_INDEX( SUBSTRING_INDEX( GROUP_CONCAT( inter_gad7 ORDER BY inter_gad7 SEPARATOR ',' ), ',', 50 / 100 * COUNT(*)), ',', - 1 )) / 2 AS Mediana_inter_gad7,
			SUBSTRING_INDEX( SUBSTRING_INDEX( GROUP_CONCAT( inter_gad7 ORDER BY inter_gad7 SEPARATOR ',' ), ',', 25 / 100 * COUNT(*)), ',', - 1 ) AS Cuartil_Inferior_inter_gad7,
			MIN( inter_gad7 ) AS Minimo_inter_gad7 
		FROM
			analisis_phq9_gad7
  		";
  		// echo $sql."<hr>";
  		$result = ejecutar($sql);		
  		$row_basal_gad7 = mysqli_fetch_array($result);
		extract($row_basal_gad7);
		// print_r($row_basal_gad7);		

  		$sql ="
		SELECT
			MAX( final_gad7 ) AS Maximo_final_gad7,
			SUBSTRING_INDEX( SUBSTRING_INDEX( GROUP_CONCAT( final_gad7 ORDER BY final_gad7 SEPARATOR ',' ), ',', 75 / 100 * COUNT(*)), ',', - 1 ) AS Cuartil_Superior_final_gad7,
			(SUBSTRING_INDEX( SUBSTRING_INDEX( GROUP_CONCAT( final_gad7 ORDER BY final_gad7 SEPARATOR ',' ), ',', 50 / 100 * COUNT(*) + 1 ), ',', - 1 ) + 
			SUBSTRING_INDEX( SUBSTRING_INDEX( GROUP_CONCAT( final_gad7 ORDER BY final_gad7 SEPARATOR ',' ), ',', 50 / 100 * COUNT(*)), ',', - 1 )) / 2 AS Mediana_final_gad7,
			SUBSTRING_INDEX( SUBSTRING_INDEX( GROUP_CONCAT( final_gad7 ORDER BY final_gad7 SEPARATOR ',' ), ',', 25 / 100 * COUNT(*)), ',', - 1 ) AS Cuartil_Inferior_final_gad7,
			MIN( final_gad7 ) AS Minimo_final_gad7 
		FROM
			analisis_phq9_gad7
  		";
  		// echo $sql."<hr>";
  		$result = ejecutar($sql);		
  		$row_basal_gad7 = mysqli_fetch_array($result);
		extract($row_basal_gad7);
		// print_r($row_basal_gad7);			
					
  		?>	
				<h1>General</h1>
				<table style="width: 50%; font-size: 12px" class="table table-bordered">
					<tr>
						<th></th>
						<th>Basal PHQ9</th>	
						<th>Intermedia PHQ9</th>
						<th>Final PHQ9</th>	
						
						<th>Basal GAD7</th>	
						<th>Intermedia GAD7</th>
						<th>Final GAD7</th>											
					</tr>
					<tr>
						<td>Maxima</td>
						<td><?php echo $Maximo_basal_phq9; ?></td>
						<td><?php echo $Maximo_inter_phq9; ?></td>
						<td><?php echo $Maximo_final_phq9; ?></td>
						
						<td><?php echo $Maximo_basal_gad7; ?></td>
						<td><?php echo $Maximo_inter_gad7; ?></td>
						<td><?php echo $Maximo_final_gad7; ?></td>
					</tr>
					<tr>
						<td>Cuartil Superior</td>
						<td><?php echo $Cuartil_Superior_basal_phq9; ?></td>
						<td><?php echo $Cuartil_Superior_inter_phq9; ?></td>
						<td><?php echo $Cuartil_Superior_final_phq9; ?></td>
						
						<td><?php echo $Cuartil_Superior_basal_gad7; ?></td>
						<td><?php echo $Cuartil_Superior_inter_gad7; ?></td>
						<td><?php echo $Cuartil_Superior_final_gad7; ?></td>						
					</tr>	
					<tr>
						<td>Mediana</td>
						<td><?php echo $Mediana_basal_phq9; ?></td>
						<td><?php echo $Mediana_inter_phq9; ?></td>
						<td><?php echo $Mediana_final_phq9; ?></td>
						
						<td><?php echo $Mediana_basal_gad7; ?></td>
						<td><?php echo $Mediana_inter_gad7; ?></td>
						<td><?php echo $Mediana_final_gad7; ?></td>						
					</tr>	
					<tr>
						<td>Cuartil Inferior</td>
						<td><?php echo $Cuartil_Inferior_basal_phq9; ?></td>
						<td><?php echo $Cuartil_Inferior_inter_phq9; ?></td>
						<td><?php echo $Cuartil_Inferior_final_phq9; ?></td>
						
						<td><?php echo $Cuartil_Inferior_basal_gad7; ?></td>
						<td><?php echo $Cuartil_Inferior_inter_gad7; ?></td>
						<td><?php echo $Cuartil_Inferior_final_gad7; ?></td>						
					</tr>	
					<tr>
						<td>Minimo</td>
						<td><?php echo $Minimo_basal_phq9; ?></td>
						<td><?php echo $Minimo_inter_phq9; ?></td>
						<td><?php echo $Minimo_final_phq9; ?></td>
						
						<td><?php echo $Minimo_basal_gad7; ?></td>
						<td><?php echo $Minimo_inter_gad7; ?></td>
						<td><?php echo $Minimo_final_gad7; ?></td>						
					</tr>																	
				</table>
				
				
				
		<div id="container" style="height: 400px; margin: auto; min-width: 310px; max-width: 600px"></div>		
		<script type="text/javascript">
			$(function () {
			    $('#container').highcharts({
			
				    chart: {
				        type: 'boxplot'
				    },
				    
				    title: {
				        text: 'Analisis General PHQ9 y GAD7'
				    },
				    
				    legend: {
				        enabled: false
				    },
				
				    xAxis: {
				        categories: ['Basal PHQ9', 'Intermedia PHQ9', 'Final PHQ9', 'Basal GAD7', 'Intermedia GAD7', 'Final GAD7'],
				        title: {
				            text: 'Experiment No.'
				        }
				    },
				    
				    yAxis: {
				        title: {
				            text: 'Observations'
				        },
				        plotLines: [{
				            value: 15,
				            color: 'red',
				            width: 1,
				            label: {
				                text: 'Media teórica: 15',
				                align: 'center',
				                style: {
				                    color: 'gray'
				                }
				            }
				        }]  
				    },
				
				    series: [{
				        name: 'Observations',
				        data: [
				            [<?php echo $Minimo_basal_phq9; ?>, <?php echo $Cuartil_Inferior_basal_phq9; ?>, <?php echo $Mediana_basal_phq9; ?>, <?php echo $Cuartil_Superior_basal_phq9; ?>, <?php echo $Maximo_basal_phq9; ?>],
				            [<?php echo $Minimo_inter_phq9; ?>, <?php echo $Cuartil_Inferior_inter_phq9; ?>, <?php echo $Mediana_inter_phq9; ?>, <?php echo $Cuartil_Superior_inter_phq9; ?>, <?php echo $Maximo_inter_phq9; ?>],
				            [<?php echo $Minimo_final_phq9; ?>, <?php echo $Cuartil_Inferior_final_phq9; ?>, <?php echo $Mediana_final_phq9; ?>, <?php echo $Cuartil_Superior_final_phq9; ?>, <?php echo $Maximo_final_phq9; ?>],
				            [<?php echo $Minimo_basal_gad7; ?>, <?php echo $Cuartil_Inferior_basal_gad7; ?>, <?php echo $Mediana_basal_gad7; ?>, <?php echo $Cuartil_Superior_basal_gad7; ?>, <?php echo $Maximo_basal_gad7; ?>],
				            [<?php echo $Minimo_inter_gad7; ?>, <?php echo $Cuartil_Inferior_inter_gad7; ?>, <?php echo $Mediana_inter_gad7; ?>, <?php echo $Cuartil_Superior_inter_gad7; ?>, <?php echo $Maximo_inter_gad7; ?>],
				            [<?php echo $Minimo_final_gad7; ?>, <?php echo $Cuartil_Inferior_final_gad7; ?>, <?php echo $Mediana_final_gad7; ?>, <?php echo $Cuartil_Superior_final_gad7; ?>, <?php echo $Maximo_final_gad7; ?>]
				        ],
				        tooltip: {
				            headerFormat: '<em>Experiment No {point.key}</em><br/>'
				        }
				    }, {
				        name: 'Outlier',
				        color: Highcharts.getOptions().colors[0],
				        type: 'scatter',
				        data: [ // x, y positions where 0 is the first category
				            [1, 27],
				            [0, 24],
				            [0, 24],
				            [1, 21],
				            [0, 20],
				            [0, 19]
				        ],
				        marker: {
				            fillColor: 'white',
				            lineWidth: 1,
				            lineColor: Highcharts.getOptions().colors[0]
				        },
				        tooltip: {
				            pointFormat: 'Observation: {point.y}'
				        }
				    }]
				
				});
			});
		</script> 				
				
										
		</div>	
	</div>
	<?php } ?>