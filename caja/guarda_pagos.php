<?php
include('../functions/funciones_mysql.php');
session_start();
error_reporting(7);
iconv_set_encoding('internal_encoding', 'utf-8'); 
header('Content-Type: text/html; charset=UTF-8');
//date_default_timezone_set('America/Monterrey');
date_default_timezone_set('America/Mazatlan');
setlocale(LC_TIME, 'es_ES.UTF-8');
$_SESSION['time']=mktime();


$ruta = "../";
extract($_SESSION);
print_r($_SESSION);
 
extract($_POST);
print_r($_POST);
// echo "<hr>";

// echo "<hr>";
//$aviso = stripslashes($_POST['aviso']); 

$f_captura = date("Y-m-d");
$h_captura = date("H:i:s");

//echo $observaciones."<BR>";
//echo "<hr>";

	

switch ($tipo) {
	case 'Pago Medicos':

		foreach ($sesiones as $valor) {
	
			$update = "
				UPDATE historico_sesion
					SET
					historico_sesion.pago = 'Si'
				WHERE
					ISNULL(historico_sesion.pago) 
					AND historico_sesion.usuario_id = $terapeuta 
					AND historico_sesion.f_captura = '$valor'				
					";			
			 
			// echo $update."<hr>";
			$result_update = ejecutar($update);	
			//echo $result_update."<hr>";
				
		}
		
		break;
	
	default:
		
		$terapeuta = 0;
		
		break;
}		
		
		$insert = "
			INSERT IGNORE INTO pagos 
			( 	
				pagos.usuario_id,
				pagos.empresa_id,  
				pagos.f_captura, 
				pagos.h_captura, 
				pagos.importe, 
				pagos.tipo,
				pagos.concepto, 
				pagos.f_pago, 
				pagos.terapeuta,
				pagos.negocio
			)
				values
			( 
				$usuario_id,
				'$empresa_id',
				'$f_captura',
				'$h_captura',
				$importe,
				'$tipo',
				'$concepto',
				'$f_pago',
				$terapeuta,
				'$negocio'

			)
		";	
		// echo $insert."<hr>";
		$result_insert = ejecutar($insert);		

		if ($f_pago == "Efectivo") {
			$update = "
				update admin
				set
				admin.saldo = (admin.saldo-$importe)
				where admin.usuario_id = $usuario_id	
				";
			//echo $update;
			$result_update = ejecutar($update);		
		}
			
 header("Location: pagos.php?a=1");
 exit();			