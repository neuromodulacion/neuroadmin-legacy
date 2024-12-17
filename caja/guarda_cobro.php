<?php
include('../functions/funciones_mysql.php');
session_start();

// Mostrar todos los errores
error_reporting(E_ALL);

// Ajustar charset y zona horaria
ini_set('default_charset', 'UTF-8');
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Monterrey');
setlocale(LC_TIME, 'es_ES.UTF-8');

// Asignar el tiempo actual a la sesión
$_SESSION['time'] = time();

$ruta = "../";
include('../functions/email.php'); 

// Tomar variables desde POST con control
$tipo = isset($_POST['tipo']) ? $_POST['tipo'] : '';
$doctor = isset($_POST['doctor']) ? $_POST['doctor'] : '';
$doctor1 = isset($_POST['doctor1']) ? $_POST['doctor1'] : '';
$protocolo_ter_id = isset($_POST['protocolo_ter_id']) ? $_POST['protocolo_ter_id'] : '';
$protocolo_ter_id1 = isset($_POST['protocolo_ter_id1']) ? $_POST['protocolo_ter_id1'] : '';
$paciente_consulta = isset($_POST['paciente_consulta']) ? $_POST['paciente_consulta'] : '';
$consulta = isset($_POST['consulta']) ? $_POST['consulta'] : '';
$f_pago = isset($_POST['f_pago']) ? $_POST['f_pago'] : '';
$importe = isset($_POST['importe']) ? floatval($_POST['importe']) : 0;
$otros = isset($_POST['otros']) ? $_POST['otros'] : '';
$cantidad = isset($_POST['cantidad']) ? $_POST['cantidad'] : '';
$protocolo = isset($_POST['protocolo']) ? $_POST['protocolo'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$empresa_id = isset($_POST['empresa_id']) ? $_POST['empresa_id'] : '';
$paciente_id = isset($_POST['paciente_id']) ? $_POST['paciente_id'] : 0;
$paciente_cons_id = isset($_POST['paciente_cons_id']) ? $_POST['paciente_cons_id'] : 0;
$fact1 = isset($_POST['fact1']) ? $_POST['fact1'] : 'no';
$usuario_id = isset($_SESSION['usuario_id']) ? $_SESSION['usuario_id'] : 0;

// Datos de facturación
$rfc = isset($_POST['rfc']) ? $_POST['rfc'] : '';
$cRazonSocial = isset($_POST['cRazonSocial']) ? $_POST['cRazonSocial'] : '';
$aRegimen = isset($_POST['aRegimen']) ? $_POST['aRegimen'] : '';
$email_address = isset($_POST['email_address']) ? $_POST['email_address'] : '';
$cNombreCalle = isset($_POST['cNombreCalle']) ? $_POST['cNombreCalle'] : '';
$cNumeroExterior = isset($_POST['cNumeroExterior']) ? $_POST['cNumeroExterior'] : '';
$cNumeroInterior = isset($_POST['cNumeroInterior']) ? $_POST['cNumeroInterior'] : '';
$cCodigoPostal = isset($_POST['cCodigoPostal']) ? $_POST['cCodigoPostal'] : '';
$cColonia = isset($_POST['cColonia']) ? $_POST['cColonia'] : '';
$cCiudad = isset($_POST['cCiudad']) ? $_POST['cCiudad'] : '';
$cEstado = isset($_POST['cEstado']) ? $_POST['cEstado'] : '';
$cPais = isset($_POST['cPais']) ? $_POST['cPais'] : '';

// Ajustes si las variables están vacías
if ($protocolo_ter_id == '') {
    $protocolo_ter_id = $protocolo_ter_id1;
}

if ($doctor == '') {
    $doctor = $doctor1;
}

if ($paciente_id == '') {
    $paciente_id = 0;
}
if ($paciente_cons_id == '') {
    $paciente_cons_id = 0;
}

if ($tipo == 'Renta Consultorio' || $tipo == 'Otros') {
    $doctor = 'Neuromodulacion GDL';
}

$f_captura = date("Y-m-d");
$h_captura = date("H:i:s");
$ticket = time();

// Definir PriceListID según el tipo
switch ($tipo) {
    case 'Consulta Medica':
        $PriceListID = "1c47a12f-2719-4315-9bf9-18ad44817679"; // ALDANA
        break;
    case 'Renta Consultorio':
    case 'Terapia':
    case 'Otros':
        $PriceListID = "f7929bd7-a45b-4eef-b272-78bd36261754"; // Neuromodulacion
        break;
    default:
        $PriceListID = '';
        break;
}

// Definir LocationID según el doctor
switch ($doctor) {
    case 'Neuromodulacion GDL':
        $LocationID = "5110f104-2530-4727-9edb-cb3d172c8b1d"; // Neuromodulacion
        break;
    case 'Dr. Alejandro Aldana':
        $LocationID = "b644ac68-663a-45fe-875e-fa4aee3f77c9"; // ALDANA
        break;
    case 'Dra. Eleonora Ocampo':
        $LocationID = "8be4576e-d656-4d5c-a845-ccc535b57bb6"; // Eleonora
        break;
    case 'Dr Capacitacion':
        $LocationID = "a790a1c9-fef8-47d7-8add-15a0089fe86c"; // PRUEBA
        break;
    default:
        $LocationID = '';
        break;
}

// Armado del INSERT
$insert = "
    INSERT IGNORE INTO cobros 
    (cobros.usuario_id, cobros.tipo, cobros.doctor, cobros.paciente_consulta,
     cobros.consulta, cobros.protocolo_ter_id, cobros.f_pago, cobros.importe, 
     cobros.f_captura, cobros.h_captura, cobros.otros, cobros.cantidad, cobros.protocolo, 
     cobros.ticket, cobros.facturado, cobros.email, cobros.empresa_id, cobros.paciente_id, 
     cobros.paciente_cons_id, req_factura)
    VALUES
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

// Ejecutar el insert
$result_insert = ejecutar($insert);

if ($f_pago == "Efectivo") {
    $update = "
        UPDATE admin
        SET admin.saldo = (admin.saldo+$importe)
        WHERE admin.usuario_id = $usuario_id
    ";
    $result_update = ejecutar($update);			
}

if ($fact1 == 'Si') {
    $correo = "admin@neuromodulaciongdl.com";
    $nombre = "Administrador";
    $asunto = "Cliente solicita factura del ticket $ticket con RFC $rfc";
    $cuerpo_correo = "
        Cliente con ticket no. $ticket solicita la facturación
        <h2>Detalles del Ticket</h2>
        <div>
            <p><strong>Ticket: </strong>$ticket</p>		
			<p>Cliente solicita Factura<br>
			<strong>Correo: </strong>$email</p>
        </div>
    ";
/*	<p><strong>Razón Social:</strong>$cRazonSocial</p>
	<p><strong>RFC:</strong>$rfc</p>
	<p><strong>Régimen:</strong>$aRegimen</p>
	<p><strong>Correo Electrónico:</strong>$email_address</p>
	<p><strong>Calle:</strong>$cNombreCalle</p>
	<p><strong>Número Exterior:</strong>$cNumeroExterior</p>
	<p><strong>Número Interior:</strong>$cNumeroInterior</p>
	<p><strong>Código Postal:</strong>$cCodigoPostal</p>
	<p><strong>Colonia:</strong>$cColonia</p>
	<p><strong>Ciudad:</strong>$cCiudad</p>
	<p><strong>Estado:</strong>$cEstado</p>
	<p><strong>País:</strong>$cPais</p>
    $accion = "RFC";   */
    $mail = correo_electronico($correo, $asunto, $cuerpo_correo, $nombre, $empresa_id, $accion);	
}

// Redirigir al final sin imprimir nada antes:
header("Location: cobro.php?a=1&ticket=$ticket");
exit;
