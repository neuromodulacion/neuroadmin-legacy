<?php
session_start();
error_reporting(7);
iconv_set_encoding('internal_encoding', 'utf-8'); 
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Mazatlan');
setlocale(LC_TIME, 'es_ES.UTF-8');
$_SESSION['time']=mktime();
extract($_SESSION);
//echo "<hr>$paciente_id hola<hr>";
extract($_GET);
extract($_POST);

include('../functions/funciones_mysql.php');

include('../paciente/calendario.php');

include('../paciente/fun_paciente.php');


require_once __DIR__ . '/../vendor/autoload.php';

$sql ="
	SELECT
		cobros.cobros_id, 
		cobros.usuario_id, 
		cobros.empresa_id, 
		cobros.protocolo_ter_id, 
		cobros.paciente_id, 
		cobros.tipo, 
		cobros.doctor, 
		cobros.paciente_consulta, 
		cobros.consulta, 
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
		cobros.req_factura, 
		cobros.Invoice_ID, 
		cobros.paciente_cons_id
	FROM
		cobros
	WHERE
		cobros.ticket = $ticket";
	//echo $sql;	
    $result=ejecutar($sql); 
    $row = mysqli_fetch_array($result);
    extract($row);	
// print_r($row);

 $clabe = substr($Invoice_ID, -8);

if ($tipo == 'Consulta Medica') {
	switch ($doctor) {
		case 'Dr. Alejandro Aldana':
			$logo = '
		            <img align="center" style="width: 100px" style="height: 150px; width: auto" src="../images/logo_aldana_g.jpg" alt="logo">	
			';	
			$fiscales = '
		        <h4><b>DR. JESÚS ALEJANDRO ALDANA LÓPEZ</b></h4>
		        <p style="font-size: 10px;">
					RFC: AALJ871226N11 Tel.: 33 3995 9901 / 33 3995 9904<br>
					AV DE LOS ARCOS No. 876, Col. JARDINES DEL BOSQUE CENTRO<br>
					C.P 44520 Guadalajara, Jalisco, México<br>
		        </p>	
			';	
				
			break;
		
		case 'Dra. Eleonora Ocampo':
			$logo = '
		            <img style="width: 100px" style="height: 150px; width: auto" src="../images/logo_eleonor.png" alt="logo">	
			';	
			$fiscales = '
		        <h4><b>DRA. ELEONORA OCAMPO CORONADO</b></h4>
		        <p style="font-size: 10px;">
					RFC: OACE871228767 Tel.: 33 3995 9901 / 33 3995 9904<br>
					AV DE LOS ARCOS No. 876, Col. JARDINES DEL BOSQUE CENTRO<br>
					C.P 44520 Guadalajara, Jalisco, México<br>
		        </p>	
			';
						
			break;
		
		case 'Dr Capacitacion':
			$logo = '
		            <img align="center" style="width: 100px" style="height: 150px; width: auto" src="../images/logo_aldana_g.jpg" alt="logo">	
			';	
			$fiscales = '
		        <h4><b>DR. CAPACITACIÓN</b></h4>
		        <p style="font-size: 10px;">
					RFC: AALJ871226N11 Tel.: 33 3995 9901 / 33 3995 9904<br>
					AV DE LOS ARCOS No. 876, Col. JARDINES DEL BOSQUE CENTRO<br>
					C.P 44520 Guadalajara, Jalisco, México<br>
		        </p>	
			';
							
			break;
		
		case 'Capacitacion Neuromodulacion':
			$logo = '
		            <img align="center" style="width: 100px" style="height: 150px; width: auto" src="../images/logo_aldana_g.jpg" alt="logo">	
			';	
			$fiscales = '
		        <h4><b>Capacitacion Neuromodulacion</b></h4>
		        <p style="font-size: 10px;">
					RFC: AALJ871226N11 Tel.: 33 3995 9901 / 33 3995 9904<br>
					AV DE LOS ARCOS No. 876, Col. JARDINES DEL BOSQUE CENTRO<br>
					C.P 44520 Guadalajara, Jalisco, México<br>
		        </p>	
			';
							
			break;			
	}
	

} else {

	$logo = '
            <img style="width: 80px" src="../images/logo_aldana_tc.png" alt="logo">
            <h4>Neuromodulación GDL</h4>	
	';
	$fiscales = '
		<h4><b>NEUROMODULACION GDL</b></h4>
        <p style="font-size: 10px;">
            RFC: NGD240109G4A  Tel.: 33 1261 3701<br>
            AV DE LOS ARCOS No. 876, Col. JARDINES DEL BOSQUE CENTRO<br>
            C.P 44520<br>
            Guadalajara, Jalisco, México Régimen Fiscal: Ley General de Personas Morales<br>
        </p>	
	';	
}
// Contenido HTML del ticket
$html = '
<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
            margin: 0;
            padding: 0;
        }
        .ticket {
            width: 100%;
            text-align: center;
            margin: 0;
            padding: 0;
        }
        .header {
            font-size: 12pt;
            margin-bottom: 5px;
        }
        .content {
            font-size: 10pt;
            margin: 0;
            padding: 3px;
            text-align: left;
        }
        .fecha {
            font-size: 8pt;
            margin: 0;
            padding: 3px;
            text-align: left;
        }		
        .footer {
            font-size: 8pt;
            margin-top: 5px;
        }
        hr {
            border: 1px solid #000;
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>
    <hr>
    <div align="left" class="ticket">
        <div class="header">'.$doctor.'<br>
        '.$logo.'</div>
        <div class="fecha">
			<p> 
	        Fecha: '.$f_captura.'<br> 
				Hora: '.$h_captura.'<br>
			</p>         
		</div>
        <div class="content"> 
			<hr>      	
            <p>'.$consulta.' : $ '.$importe.'</p>
            <p>Total: $ '.$importe.'</p>           
        </div>
        <div class="content">
        <hr>
         '.$fiscales.'	
        </div>
        <div class="footer">Gracias por su visita</div>
	        <hr><br> 
	        <p align="center">
	        	<b>Obtén tu factura en:</b> https://factura.bind.com.mx  <br>
	        	<b>Empresa:</b> 127792<br>
	            <b>Referencia:</b> '.$clabe.'</p>
	        <img style="width: 80%; padding-left: 10%" src="../images/codigo_qr_Bind.png" alt="logo">
        </div>
    </div>
    <hr>
</body>
</html>
';

// <pagebreak />
// echo $html;
// Crear instancia de mPDF con tamaño de página personalizado
$mpdf = new \Mpdf\Mpdf([
    'mode' => 'utf-8', 
    'format' => [58, 240], // Ancho: 58 mm, Alto: 100 mm (ajusta la altura según el contenido)
    'margin_left' => 0,
    'margin_right' => 10,
    'margin_top' => 0,
    'margin_bottom' => 0,
    'margin_header' => 0,
    'margin_footer' => 0
]);

// Escribir el HTML en el PDF
$mpdf->WriteHTML($html);
// D descarga
// F guarda
// I imprime
// Guardar el PDF en un archivo
$mpdf->Output('Ticket.pdf', 'I');
?>
