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
  //print_r($_SESSION);
  
  //echo "<hr>";
  
include('../functions/email.php'); 


 
extract($_POST);
$ticket = mktime();	
// print_r($_POST);
//echo "<hr>";
if ($protocolo_ter_id == '') {
	$protocolo_ter_id = $protocolo_ter_id1;
}

if ($doctor == '') {
	$doctor = $doctor1;
}

$f_captura = date("Y-m-d");
$h_captura = date("H:i:s");

if ($paciente_id == '') {
	$paciente_id = 0;
}
if ($paciente_cons_id == '') {
	$paciente_cons_id = 0;
}


if ($tipo =='Renta Consultorio' || $tipo == 'Otros') {
	$doctor ='Neuromodulacion GDL';
}


switch ($tipo) {
	case 'Consulta Medica':
		$PriceListID = "1c47a12f-2719-4315-9bf9-18ad44817679"; // ALDANA		
		break;
	case 'Renta Consultorio':
		$PriceListID = "f7929bd7-a45b-4eef-b272-78bd36261754"; // Neuromodulacion		
		break;
	case 'Terapia':
		$PriceListID = "f7929bd7-a45b-4eef-b272-78bd36261754"; // Neuromodulacion		
		break;	
	case 'Otros':
		$PriceListID = "f7929bd7-a45b-4eef-b272-78bd36261754"; // Neuromodulacion		
		break;
		
}

switch ($doctor) {
	case 'Neuromodulacion GDL':
		$LocationID = "5110f104-2530-4727-9edb-cb3d172c8b1d"; // Neuromodulacion
		break;
	
	case 'Dr. Alejandro Aldana':
		$LocationID = "b644ac68-663a-45fe-875e-fa4aee3f77c9"; // ALDANA
		break;
		
	case 'Dra. Eleonora Ocampo':
		$LocationID = "8be4576e-d656-4d5c-a845-ccc535b57bb6";// Eleonora	
		break;		
		
	case 'Dr Capacitacion':
		$LocationID = "a790a1c9-fef8-47d7-8add-15a0089fe86c";// PRUEBA
		break;		
}

$insert = "
	INSERT IGNORE INTO cobros 
	( 	
		cobros.usuario_id, 
		cobros.tipo, 
		cobros.doctor, 
		cobros.paciente_consulta,
		cobros.consulta,
		cobros.protocolo_ter_id, 
		cobros.f_pago, 
		cobros.importe, 
		cobros.f_captura, 
		cobros.h_captura,
		cobros.otros,
		cobros.cantidad,
		cobros.protocolo,
		cobros.ticket,
		cobros.facturado,
		cobros.email,
		cobros.empresa_id,
		cobros.paciente_id,
		cobros.paciente_cons_id,
		req_factura
	)
		values
	( 
		$usuario_id,
		'$tipo',
		'$doctor',
		'$paciente_consulta',
		'$consulta',
		'$protocolo_ter_id',
		'$f_pago',
		$importe,
		'$f_captura',
		'$h_captura',
		'$otros',
		'$cantidad',
		'$protocolo',
		'$ticket',
		'no',
		'$email',
		'$empresa_id',
		'$paciente_id',
		'$paciente_cons_id',
		'$fact1'
	)
";	
echo "<hr>".$insert;
$result_insert = ejecutar($insert);

if ($f_pago == "Efectivo") {
	$update = "
		update admin
		set
		admin.saldo = (admin.saldo+$importe)
		where admin.usuario_id = $usuario_id	
		";
	echo "<hr>".$update;
	$result_update = ejecutar($update);			
}
				
if ($fact1 == 'Si') {
	//$correo = "admin@neuromodulaciongdl.com";
	$correo = "admin@neuromodulaciongdl.com";
	$nombre = "Administrador";
	$asunto = "Cliente solicita factura del ticket $ticket con RFC $rfc";
	$cuerpo_correo = "Cliente conticket no. $ticket y $rfc solicita la facturacion
    <h2>Detalles del Ticket</h2>
  	<div > 				    
	    <p><strong>Ticket:</strong>$ticket</p>
	    <p><strong>Razón Social:</strong>$cRazonSocial</p>
	    <p><strong>RFC:</strong>$cRFC</p>
	    <p><strong>Régimen:</strong>$aRegimen</p>
	    <p><strong>Correo Electronico:</strong>$email_address</p>		    				       				    
	    <p><strong>Nombre Calle:</strong>$cNombreCalle</p>
	    <p><strong>Número Exterior:</strong>$cNumeroExterior</p>
	    <p><strong>Número Interior:</strong>$cNumeroInterior</p>
	    <p><strong>Código Postal:</strong>$cCodigoPostal</p>
	    <p><strong>Colonia:</strong>$cColonia</p>
	    <p><strong>Ciudad:</strong>$cCiudad</p>
	    <p><strong>Estado:</strong>$cEstado</p>
	    <p><strong>País:</strong>$cPais</p>
	</div>		
	"; 
	
	//echo correo_electronico($correo,$asunto,$cuerpo_correo,$nombre,$empresa_id);
	$accion =  "RFC"; // "General"; //"Invitacion"; //   
	echo "<hr>";
	$mail = correo_electronico($correo,$asunto,$cuerpo_correo,$nombre,$empresa_id,$accion);	
}		
		

 header("Location: cobro.php?a=1&ticket=$ticket");			