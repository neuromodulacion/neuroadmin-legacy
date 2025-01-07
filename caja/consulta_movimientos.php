<?php
include('../functions/funciones_mysql.php');
include('../functions/functions.php');
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
extract($_SESSION);
//print_r($_SESSION);
 
extract($_POST);
//print_r($_POST);
// echo "<hr>";

 echo "<hr>";
//$aviso = stripslashes($_POST['aviso']); 

$f_captura = date("Y-m-d");
$h_captura = date("H:i:s");


switch ($tipo_consulta) {
	case 'abonos':
		?>
			<table style="width: 100%"  class="table table-bordered">
	  			<tr>
	  				<th colspan="4" align="center"><h2 align="center"><B>Abonos</B></h2></th>
	  			</tr>								  			
	  			<tr>
	  				<th style="text-align: center" >Fecha</th>
	  				<th style="text-align: center" >Hora</th>
	  				<th style="text-align: center" >Usuario</th>
	  				<th style="text-align: center" >Usuario Abona</th>
	  				<th style="text-align: center" >Importe</th>
	  			</tr>
	  			<?php
	  			
	  			switch ($gral) {
					  case 'unico':
				  			$sql_cob = "
								SELECT
								    abonos.abono_id,
								    abonos.usuario_id,
								    abonos.usuario_id_abona,
								    abonos.f_captura,
								    abonos.h_captura,
								    abonos.importe,
								    admin.nombre AS abona,
								    admin2.nombre AS usuario,
								    admin.empresa_id
								FROM
								    abonos
								    INNER JOIN admin ON abonos.usuario_id_abona = admin.usuario_id
								    INNER JOIN admin AS admin2 ON abonos.usuario_id = admin2.usuario_id
								WHERE
								    abonos.usuario_id = $usuario_idx
								    AND abonos.f_captura = '$fecha'	";						  
						  break;

					  case 'unico_total':
				  			$sql_cob = "
								SELECT
								    abonos.abono_id,
								    abonos.usuario_id,
								    abonos.usuario_id_abona,
								    abonos.f_captura,
								    abonos.h_captura,
								    abonos.importe,
								    admin.nombre AS abona,
								    admin2.nombre AS usuario,
								    admin.empresa_id
								FROM
								    abonos
								    INNER JOIN admin ON abonos.usuario_id_abona = admin.usuario_id
								    INNER JOIN admin AS admin2 ON abonos.usuario_id = admin2.usuario_id
								WHERE
								    abonos.usuario_id = $usuario_idx
								    AND month(abonos.f_captura) = '$mes'
								    AND year(abonos.f_captura) = '$anio'";							  
						  break;

					  case 'todos':
				  			$sql_cob = "
								SELECT
								    abonos.abono_id,
								    abonos.usuario_id,
								    abonos.usuario_id_abona,
								    abonos.f_captura,
								    abonos.h_captura,
								    abonos.importe,
								    admin.nombre AS abona,
								    admin2.nombre AS usuario,
								    admin.empresa_id
								FROM
								    abonos
								    INNER JOIN admin ON abonos.usuario_id_abona = admin.usuario_id
								    INNER JOIN admin AS admin2 ON abonos.usuario_id = admin2.usuario_id
								WHERE
								    abonos.f_captura = '$fecha'	";							  
						  break;

					  case 'todos_total':
				  			$sql_cob = "
								SELECT
								    abonos.abono_id,
								    abonos.usuario_id,
								    abonos.usuario_id_abona,
								    abonos.f_captura,
								    abonos.h_captura,
								    abonos.importe,
								    admin.nombre AS abona,
								    admin2.nombre AS usuario,
								    admin.empresa_id
								FROM
								    abonos
								    INNER JOIN admin ON abonos.usuario_id_abona = admin.usuario_id
								    INNER JOIN admin AS admin2 ON abonos.usuario_id = admin2.usuario_id
								WHERE
								    month(abonos.f_captura) = '$mes'
								    AND year(abonos.f_captura) = '$anio'";						  
						  break;
							  					  
				  }
	  			
	  			// if ($gral == 'unico') {
		  			// $sql_cob = "
						// SELECT
						    // abonos.abono_id,
						    // abonos.usuario_id,
						    // abonos.usuario_id_abona,
						    // abonos.f_captura,
						    // abonos.h_captura,
						    // abonos.importe,
						    // admin.nombre AS abona,
						    // admin2.nombre AS usuario,
						    // admin.empresa_id
						// FROM
						    // abonos
						    // INNER JOIN admin ON abonos.usuario_id_abona = admin.usuario_id
						    // INNER JOIN admin AS admin2 ON abonos.usuario_id = admin2.usuario_id
						// WHERE
						    // abonos.usuario_id = $usuario_idx
						    // AND abonos.f_captura = '$fecha'	";					  
				  // } else {
		  			// $sql_cob = "
						// SELECT
						    // abonos.abono_id,
						    // abonos.usuario_id,
						    // abonos.usuario_id_abona,
						    // abonos.f_captura,
						    // abonos.h_captura,
						    // abonos.importe,
						    // admin.nombre AS abona,
						    // admin2.nombre AS usuario,
						    // admin.empresa_id
						// FROM
						    // abonos
						    // INNER JOIN admin ON abonos.usuario_id_abona = admin.usuario_id
						    // INNER JOIN admin AS admin2 ON abonos.usuario_id = admin2.usuario_id
						// WHERE
						    // abonos.f_captura = '$fecha'	";					  
				  // }
				  
	  			
	  			

			     	//  echo $sql_cob."<hr>";
			     	$result_cob=ejecutar($sql_cob); 
			    										    	
					$cnt_cob = mysqli_num_rows($result_cob);
					
					if ($cnt_cob <>0) {
															     	
				    	while($row_cob = mysqli_fetch_array($result_cob)){
				    	extract($row_cob);	
						$f_captura = format_fecha_esp_dmy($f_captura);
				    	?>
				  			<tr>
				  				<td><?php echo $f_captura; ?></td> 
				  				<td><?php echo $h_captura; ?></td>
				  				<td><?php echo $usuario; ?></td> 
				  				<td><?php echo $abona; ?></td> 
				  				<td align="right">$&nbsp;<?php echo number_format($importe); ?></td>
				  			</tr>													
						<?php } 
					
					} else {  ?>
			  			<tr>
			  				<th style="text-align: center" colspan="4"><i>Sin Resultados</i></th> 
			  			</tr>													
						
					<?php } ?>
	  		</table>
		<?php
		break;
	
	case 'cobros': ?>
	
			<table  class="table table-bordered">
	  			<tr>
	  				<th colspan="4" align="center"><h2 align="center"><B>Cobros</B></h2></th>
	  			</tr>								  			
	  			<tr>
	  				<th style="text-align: center;" >Fecha</th>
	  				<th style="text-align: center" >Usuario</th>
	  				<th style="text-align: center" >Forma de pago</th>
	  				<th style="text-align: center" >Tipo</th>
	  				<th style="text-align: center" >Importe</th>
	  			</tr>
	  			<?php

	  			switch ($gral) {
					  case 'unico':
				  			$sql_cob = "
								SELECT
									cobros.cobros_id,
									cobros.usuario_id,
									cobros.tipo,
									cobros.doctor,
									cobros.protocolo_ter_id,
									cobros.f_pago,
									cobros.importe,
									cobros.f_captura,
									cobros.h_captura,
									cobros.otros,
									cobros.paciente_id,
									(
									SELECT
										CONCAT( pacientes.paciente, ' ', pacientes.apaterno, ' ', pacientes.amaterno ) AS paciente 
									FROM
										pacientes 
									WHERE
										pacientes.paciente_id = cobros.paciente_id 
									) AS paciente,
									cobros.empresa_id,
									admin.nombre 
								FROM
									cobros
									INNER JOIN admin ON cobros.usuario_id = admin.usuario_id 
								WHERE
									cobros.empresa_id = $empresa_id 
									AND cobros.f_captura = '$fecha'

									AND cobros.usuario_id = $usuario_idx
								ORDER BY
									cobros.f_captura DESC";	
									
								$users ="AND cobros.usuario_id = $usuario_idx";	
								
								$sql_doctor = "
								SELECT DISTINCT
									cobros.doctor
								FROM
									cobros
									INNER JOIN admin ON cobros.usuario_id = admin.usuario_id 
								WHERE
									cobros.empresa_id = $empresa_id 
									AND cobros.f_captura = '$fecha' 
									AND cobros.usuario_id = $usuario_idx
								GROUP BY 1
								ORDER BY
									cobros.doctor DESC";
										
							$sel_fecha ="
								AND cobros.f_captura = '$fecha'";	
																													  
						  break;

					  case 'unico_total':
				  			$sql_cob = "
								SELECT
									cobros.cobros_id,
									cobros.usuario_id,
									cobros.tipo,
									cobros.doctor,
									cobros.protocolo_ter_id,
									cobros.f_pago,
									cobros.importe,
									cobros.f_captura,
									cobros.h_captura,
									cobros.otros,
									cobros.paciente_id,
									(
									SELECT
										CONCAT( pacientes.paciente, ' ', pacientes.apaterno, ' ', pacientes.amaterno ) AS paciente 
									FROM
										pacientes 
									WHERE
										pacientes.paciente_id = cobros.paciente_id 
									) AS paciente,
									cobros.empresa_id,
									admin.nombre 
								FROM
									cobros
									INNER JOIN admin ON cobros.usuario_id = admin.usuario_id 
								WHERE
									cobros.empresa_id = $empresa_id 
								    AND month(cobros.f_captura) = '$mes'
								    AND year(cobros.f_captura) = '$anio'
									AND cobros.usuario_id = $usuario_idx
								ORDER BY
									cobros.f_captura DESC";	
								$users ="AND cobros.usuario_id = $usuario_idx";		
								
								
								$sql_doctor = "
								SELECT DISTINCT
									cobros.doctor
								FROM
									cobros
									INNER JOIN admin ON cobros.usuario_id = admin.usuario_id 
								WHERE
									cobros.empresa_id = $empresa_id 
								    AND month(cobros.f_captura) = '$mes'
								    AND year(cobros.f_captura) = '$anio'
									AND cobros.usuario_id = $usuario_idx
								GROUP BY 1
								ORDER BY
									cobros.doctor DESC";
																	
							$sel_fecha ="
								    AND month(cobros.f_captura) = '$mes'
								    AND year(cobros.f_captura) = '$anio'";								
																							  
						  break;

					  case 'todos':
				  			$sql_cob = "
								SELECT
									cobros.cobros_id,
									cobros.usuario_id,
									cobros.tipo,
									cobros.doctor,
									cobros.protocolo_ter_id,
									cobros.f_pago,
									cobros.importe,
									cobros.f_captura,
									cobros.h_captura,
									cobros.otros,
									cobros.paciente_id,
									(
									SELECT
										CONCAT( pacientes.paciente, ' ', pacientes.apaterno, ' ', pacientes.amaterno ) AS paciente 
									FROM
										pacientes 
									WHERE
										pacientes.paciente_id = cobros.paciente_id 
									) AS paciente,
									cobros.empresa_id,
									admin.nombre 
								FROM
									cobros
									INNER JOIN admin ON cobros.usuario_id = admin.usuario_id 
								WHERE
									cobros.empresa_id = $empresa_id 
									AND cobros.f_captura = '$fecha'
								ORDER BY
									cobros.f_captura DESC";	
									$users ="";	
									
								$sql_doctor = "
								SELECT DISTINCT
									cobros.doctor
								FROM
									cobros
									INNER JOIN admin ON cobros.usuario_id = admin.usuario_id 
								WHERE
									cobros.empresa_id = $empresa_id 
									AND cobros.f_captura = '$fecha'
								GROUP BY 1
								ORDER BY
									cobros.doctor DESC";	
																	
							$sel_fecha ="
								AND cobros.f_captura = '$fecha'";	
																							  
						  break;

					  case 'todos_total':
				  			$sql_cob = "
								SELECT
									cobros.cobros_id,
									cobros.usuario_id,
									cobros.tipo,
									cobros.doctor,
									cobros.protocolo_ter_id,
									cobros.f_pago,
									cobros.importe,
									cobros.f_captura,
									cobros.h_captura,
									cobros.otros,
									cobros.paciente_id,
									(
									SELECT
										CONCAT( pacientes.paciente, ' ', pacientes.apaterno, ' ', pacientes.amaterno ) AS paciente 
									FROM
										pacientes 
									WHERE
										pacientes.paciente_id = cobros.paciente_id 
									) AS paciente,
									cobros.empresa_id,
									admin.nombre 
								FROM
									cobros
									INNER JOIN admin ON cobros.usuario_id = admin.usuario_id 
								WHERE
									cobros.empresa_id = $empresa_id 
								    AND month(cobros.f_captura) = '$mes'
								    AND year(cobros.f_captura) = '$anio'
								ORDER BY
									cobros.f_captura DESC";	
								$users ="";	
								
								$sql_doctor = "
									SELECT DISTINCT
										cobros.doctor
									FROM
										cobros
										INNER JOIN admin ON cobros.usuario_id = admin.usuario_id 
									WHERE
										cobros.empresa_id = $empresa_id 
									    AND month(cobros.f_captura) = '$mes'
									    AND year(cobros.f_captura) = '$anio'
									GROUP BY 1
									ORDER BY
										cobros.doctor DESC";
										
							$sel_fecha ="
								    AND month(cobros.f_captura) = '$mes'
								    AND year(cobros.f_captura) = '$anio'";																									  
						  break;
							  					  
				  }

					//echo $sql_cob;
			     	$result_cob=ejecutar($sql_cob); 
			    	
					$cnt_cob = mysqli_num_rows($result_cob);
					$importet = 0;
					if ($cnt_cob <>0) {
				    	
				    	while($row_cob = mysqli_fetch_array($result_cob)){
				    	extract($row_cob);	
						$f_captura = format_fecha_esp_dmy($f_captura);

				    	$importet = $importet+$importe;
				    	?>
				  			<tr>
				  				<td  style="text-align: center" ><?php echo $f_captura." T ".$h_captura; ?></td> 
				  				<td><?php echo $nombre; ?></td>
				  				<td><?php echo $f_pago; ?></td> 
				  				<td><?php echo $tipo; ?></td>
				  				<td style="text-align: right">$&nbsp;<?php echo number_format($importe); ?></td>
				  			</tr>													
						
						<?php } 
					} else {  ?>
			  			<tr>
			  				<th style="text-align: center" colspan="6"><i>Sin Resultados</i></th> 
			  			</tr>													
						
					<?php } ?>
			  			<tr>
			  				<th colspan="4" style="text-align: right" >Total</th>
			  				<th style="text-align: right">$&nbsp;<?php echo number_format($importet); ?></th>
			  			</tr>
	  		</table>
	  		
			<hr>	

	    	<h3>Total</h3>	
	    	

		<?php	  		
	
					
			//echo $sql_doctor;
	     	$result_gral=ejecutar($sql_doctor); 
	    	$total=0;
			$cnt_gral = mysqli_num_rows($result_gral);
			$importet = 0;
			if ($cnt_gral <>0) {
		    	
		    	while($row_gral = mysqli_fetch_array($result_gral)){
		    	extract($row_gral);	
		    	//print_r($row_gral);    		
		    	?>
		    	<h2><?php echo $doctor; ?></h2>
		    	<table style="width: 300px" class="table table-bordered">
		    		<tr>
		    			<th style="text-align: center">Forma de pago</th>
		    			<th style="text-align: center">Importe</th>
		    		</tr>
						<?php
						$sql_canal = "	
							SELECT
								cobros.f_pago,
								sum(cobros.importe) as importex,
								admin.nombre 
							FROM
								cobros
								INNER JOIN admin ON cobros.usuario_id = admin.usuario_id 
							WHERE
								cobros.empresa_id = $empresa_id 
								$sel_fecha
								and cobros.doctor = '$doctor'
								$users
							GROUP BY 1
							ORDER BY
								cobros.f_pago ASC";
						// echo $sql_canal;
				     	$result_canal=ejecutar($sql_canal); 
				    	
						$cnt_canal = mysqli_num_rows($result_canal);
						$importet = 0;
						if ($cnt_canal <>0) {
					    	$importe_doct = 0;
					    	while($row_canal = mysqli_fetch_array($result_canal)){
					    	extract($row_canal);	
					    	//print_r($row_gral);
							$importe_doct = $importe_doct+$importex;
					    	?>
					    		<tr>
					    			<td style="text-align: left"><?php echo $f_pago; ?></td>    			
					    			<td style="text-align: right">$<?php echo number_format($importex); ?></td>
					    		</tr>	    	
					    	<?php
							}
						}
							
						?>	    		
					    		<tr>
					    			<td style="text-align: right"><b>Total</b></td>
					    			<td style="text-align: right">$<?php echo number_format($importe_doct); ?></td>	    			
					    		</tr>	    		
					    	</table>
					    	<hr>
										
						<?php
				
						 } 
				// $table.='
			    		// <tr>
			    			// <td style="text-align: right"><b>Total</b></td>    			
			    			// <td>$'.number_format($total).'</td>
			    		// </tr>		
					// </table>
					// <hr>';
				// echo $table;		 
				} else {  ?>
		  			<h1>Sin Resultados XX</h1>								
			
		<?php } 
		break;
	
	case 'retiros': ?>
		
		<table style="width: 100%" class="table table-bordered">
  			<tr>
  				<th colspan="4" align="center"><h2 align="center"><B>Retiros</B></h2></th>
  			</tr>								  			
  			<tr>
  				<th style="text-align: center" >Fecha</th>
  				<th style="text-align: center" >Usuario</th>
  				<th style="text-align: center" >Usuario Retira</th>
  				<th style="text-align: center" >Importe</th>
  			</tr>
  			<?php

	  			switch ($gral) {
					  case 'unico':
				  			$sql_cob = "
								SELECT
									retiros.retiros_id,
									retiros.usuario_id,
									retiros.usuario_id_retira,
									retiros.f_captura,
									retiros.h_captura,
									retiros.importe,
									admin.nombre as retiro,
									adminx.nombre as usuario,
									retiros.empresa_id 
								FROM
									retiros
									INNER JOIN admin ON retiros.usuario_id_retira = admin.usuario_id
									INNER JOIN admin as adminx  ON retiros.usuario_id = adminx.usuario_id
								WHERE
									retiros.empresa_id = $empresa_id
									AND retiros.f_captura = '$fecha'
									and retiros.usuario_id = $usuario_idx											
								ORDER BY retiros.f_captura desc	";						  
						  break;

					  case 'unico_total':
				  			$sql_cob = "
								SELECT
									retiros.retiros_id,
									retiros.usuario_id,
									retiros.usuario_id_retira,
									retiros.f_captura,
									retiros.h_captura,
									retiros.importe,
									admin.nombre as retiro,
									adminx.nombre as usuario,
									retiros.empresa_id 
								FROM
									retiros
									INNER JOIN admin ON retiros.usuario_id_retira = admin.usuario_id
									INNER JOIN admin as adminx  ON retiros.usuario_id = adminx.usuario_id
								WHERE
									retiros.empresa_id = $empresa_id
								    AND month(retiros.f_captura) = '$mes'
								    AND year(retiros.f_captura) = '$anio'
									and retiros.usuario_id = $usuario_idx											
								ORDER BY retiros.f_captura desc	";								  
						  break;

					  case 'todos':
				  			$sql_cob = "
								SELECT
									retiros.retiros_id,
									retiros.usuario_id,
									retiros.usuario_id_retira,
									retiros.f_captura,
									retiros.h_captura,
									retiros.importe,
									admin.nombre as retiro,
									adminx.nombre as usuario,
									retiros.empresa_id 
								FROM
									retiros
									INNER JOIN admin ON retiros.usuario_id_retira = admin.usuario_id
									INNER JOIN admin as adminx  ON retiros.usuario_id = adminx.usuario_id
								WHERE
									retiros.empresa_id = $empresa_id
									AND retiros.f_captura = '$fecha'											
								ORDER BY retiros.f_captura desc	";								  
						  break;

					  case 'todos_total':
				  			$sql_cob = "
								SELECT
									retiros.retiros_id,
									retiros.usuario_id,
									retiros.usuario_id_retira,
									retiros.f_captura,
									retiros.h_captura,
									retiros.importe,
									admin.nombre as retiro,
									adminx.nombre as usuario,
									retiros.empresa_id 
								FROM
									retiros
									INNER JOIN admin ON retiros.usuario_id_retira = admin.usuario_id
									INNER JOIN admin as adminx  ON retiros.usuario_id = adminx.usuario_id
								WHERE
									retiros.empresa_id = $empresa_id
								    AND month(retiros.f_captura) = '$mes'
								    AND year(retiros.f_captura) = '$anio'											
								ORDER BY retiros.f_captura desc	";							  
						  break;
							  					  
				  }  			
  														
	  			// if ($gral == 'unico') {
// 						    
		  			// $sql_cob = "
						// SELECT
							// retiros.retiros_id,
							// retiros.usuario_id,
							// retiros.usuario_id_retira,
							// retiros.f_captura,
							// retiros.h_captura,
							// retiros.importe,
							// admin.nombre as retiro,
							// adminx.nombre as usuario,
							// retiros.empresa_id 
						// FROM
							// retiros
							// INNER JOIN admin ON retiros.usuario_id_retira = admin.usuario_id
							// INNER JOIN admin as adminx  ON retiros.usuario_id = adminx.usuario_id
						// WHERE
							// retiros.empresa_id = $empresa_id
							// AND retiros.f_captura = '$fecha'
							// and retiros.usuario_id = $usuario_idx											
						// ORDER BY retiros.f_captura desc	";						    
// 						    				  
				  // } else {
		  			// $sql_cob = "
						// SELECT
							// retiros.retiros_id,
							// retiros.usuario_id,
							// retiros.usuario_id_retira,
							// retiros.f_captura,
							// retiros.h_captura,
							// retiros.importe,
							// admin.nombre as retiro,
							// adminx.nombre as usuario,
							// retiros.empresa_id 
						// FROM
							// retiros
							// INNER JOIN admin ON retiros.usuario_id_retira = admin.usuario_id
							// INNER JOIN admin as adminx  ON retiros.usuario_id = adminx.usuario_id
						// WHERE
							// retiros.empresa_id = $empresa_id
							// AND retiros.f_captura = '$fecha'											
						// ORDER BY retiros.f_captura desc	";						  
				  // }									
		     	 // echo $sql_cob."<hr>";
		     	$result_cob=ejecutar($sql_cob);
		    										    	
				$cnt_cob = mysqli_num_rows($result_cob);
				$importet = 0;
				if ($cnt_cob <>0) {
			    																 
		    		while($row_cob = mysqli_fetch_array($result_cob)){
				    	extract($row_cob);	
						$f_captura = format_fecha_esp_dmy($f_captura);
						$importet = $importet+$importe;
				    	?>
			  			<tr>
			  				<td><?php echo $f_captura; ?></td> 							  				
			  				<td><?php echo $usuario; ?></td> 
			  				<td><?php echo $retiro; ?></td>
			  				<td align="right">$&nbsp;<?php echo number_format($importe); ?></td>
			  			</tr>													
					<?php } 
				
				} else {  ?>
		  			<tr>
		  				<th style="text-align: center" colspan="4"><i>Sin Resultados</i></th> 
		  			</tr>													
					
				<?php } ?>
			  			<tr>
			  				<td colspan="3">Total</td> 
			  				<td align="right">$&nbsp;<?php echo number_format($importet); ?></td>
			  			</tr>									
  		</table>	
  		<?php	
		break;

	case 'pagos':
		?>
		<table  style="width: 100%"  class="table table-bordered">
  			<tr>
  				<th colspan="4" align="center"><h2 align="center"><B>Pagos</B></h2></th>
  			</tr>								  			
  			<tr>
  				<th style="text-align: center" >Fecha</th>
  				<th style="text-align: center" >Usuario</th>
  				<th style="text-align: center" >Forma de pago</th>
  				<th style="text-align: center" >Tipo</th>
  				<th style="text-align: center" >Importe</th>
  			</tr>
  			<?php

	  			switch ($gral) {
					  case 'unico':
				  			$sql_cob = "
								SELECT
									pagos.pagos_id,
									pagos.usuario_id,
									pagos.f_captura,
									pagos.h_captura,
									pagos.importe,
									pagos.tipo,
									pagos.f_pago,
									pagos.terapeuta,
									pagos.empresa_id,
									admin.nombre, 
									pagos.concepto 
								FROM
									pagos
									INNER JOIN admin ON pagos.usuario_id = admin.usuario_id 
								WHERE
									pagos.empresa_id = $empresa_id
									AND pagos.f_captura = '$fecha'
									AND pagos.f_pago = 'Efectivo'
									AND pagos.usuario_id = $usuario_idx													
								ORDER BY pagos.f_captura desc";						    
						    				  					  
						  break;

					  case 'unico_total':
				  			$sql_cob = "
								SELECT
									pagos.pagos_id,
									pagos.usuario_id,
									pagos.f_captura,
									pagos.h_captura,
									pagos.importe,
									pagos.tipo,
									pagos.f_pago,
									pagos.terapeuta,
									pagos.empresa_id,
									admin.nombre, 
									pagos.concepto 
								FROM
									pagos
									INNER JOIN admin ON pagos.usuario_id = admin.usuario_id 
								WHERE
									pagos.empresa_id = $empresa_id
								    AND month(pagos.f_captura) = '$mes'
								    AND year(pagos.f_captura) = '$anio'
									AND pagos.f_pago = 'Efectivo'
									AND pagos.usuario_id = $usuario_idx													
								ORDER BY pagos.f_captura desc";								  
						  break;

					  case 'todos':
				  			$sql_cob = "
								SELECT
									pagos.pagos_id,
									pagos.usuario_id,
									pagos.f_captura,
									pagos.h_captura,
									pagos.importe,
									pagos.tipo,
									pagos.f_pago,
									pagos.terapeuta,
									pagos.empresa_id,
									admin.nombre, 
									pagos.concepto 
								FROM
									pagos
									INNER JOIN admin ON pagos.usuario_id = admin.usuario_id 
								WHERE
									pagos.empresa_id = $empresa_id
									AND pagos.f_captura = '$fecha'
									AND pagos.f_pago = 'Efectivo'												
								ORDER BY pagos.f_captura desc";								  
						  break;

					  case 'todos_total':
				  			$sql_cob = "
								SELECT
									pagos.pagos_id,
									pagos.usuario_id,
									pagos.f_captura,
									pagos.h_captura,
									pagos.importe,
									pagos.tipo,
									pagos.f_pago,
									pagos.terapeuta,
									pagos.empresa_id,
									admin.nombre, 
									pagos.concepto 
								FROM
									pagos
									INNER JOIN admin ON pagos.usuario_id = admin.usuario_id 
								WHERE
									pagos.empresa_id = $empresa_id
								    AND month(pagos.f_captura) = '$mes'
								    AND year(pagos.f_captura) = '$anio'
									AND pagos.f_pago = 'Efectivo'												
								ORDER BY pagos.f_captura desc";							  
						  break;
							  					  
				  }  			
  			
	  			// if ($gral == 'unico') {
// 						    
		  			// $sql_cob = "
						// SELECT
							// pagos.pagos_id,
							// pagos.usuario_id,
							// pagos.f_captura,
							// pagos.h_captura,
							// pagos.importe,
							// pagos.tipo,
							// pagos.f_pago,
							// pagos.terapeuta,
							// pagos.empresa_id,
							// admin.nombre, 
							// pagos.concepto 
						// FROM
							// pagos
							// INNER JOIN admin ON pagos.usuario_id = admin.usuario_id 
						// WHERE
							// pagos.empresa_id = $empresa_id
							// AND pagos.f_captura = '$fecha'
							// AND pagos.f_pago = 'Efectivo'
							// AND pagos.usuario_id = $usuario_idx													
						// ORDER BY pagos.f_captura desc";						    
// 						    				  
				  // } else {
		  			// $sql_cob = "
						// SELECT
							// pagos.pagos_id,
							// pagos.usuario_id,
							// pagos.f_captura,
							// pagos.h_captura,
							// pagos.importe,
							// pagos.tipo,
							// pagos.f_pago,
							// pagos.terapeuta,
							// pagos.empresa_id,
							// admin.nombre, 
							// pagos.concepto 
						// FROM
							// pagos
							// INNER JOIN admin ON pagos.usuario_id = admin.usuario_id 
						// WHERE
							// pagos.empresa_id = $empresa_id
							// AND pagos.f_captura = '$fecha'
							// AND pagos.f_pago = 'Efectivo'												
						// ORDER BY pagos.f_captura desc";						  
				  // }	  			
		     	 // echo $sql_cob."<hr>";
		     	$result_cob=ejecutar($sql_cob); 
		    										    	
				$cnt_cob = mysqli_num_rows($result_cob);
				
				if ($cnt_cob <>0) {
			    											    	
			    	while($row_cob = mysqli_fetch_array($result_cob)){
			    	extract($row_cob);	
					$f_captura = format_fecha_esp_dmy($f_captura);
			    	//$f_captura = strftime("%e-%b-%Y",strtotime($f_captura));
			    	?>
			  			<tr>
			  				<td><?php echo $f_captura; ?></td>
			  				<td><?php echo $nombre; ?></td> 
			  				<td><?php echo $f_pago; ?></td> 
			  				<td><?php echo $tipo."<br>".$concepto; ?></td>
			  				<td align="right">$&nbsp;<?php echo number_format($importe); ?></td>
			  			</tr>													
					<?php } 
				
				} else {  ?>
		  			<tr>
		  				<th style="text-align: center" colspan="5"><i>Sin Resultados</i></th> 
		  			</tr>													
					
				<?php } ?>
					
  		</table>
  		<?php		
		break;
	
	case 'saldo_final':
		
		break;
					
}
