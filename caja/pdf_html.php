<?php
session_start();

// Establecer el nivel de notificación de errores
error_reporting(E_ALL); // Reemplaza `7` por `E_ALL` para usar la constante más clara y recomendada

// Establecer la codificación interna a UTF-8 (ya no se utiliza `iconv_set_encoding`, sino `ini_set`)
ini_set('default_charset', 'UTF-8');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
// Configurar la cabecera HTTP con codificación UTF-8
header('Content-Type: text/html; charset=UTF-8');

// Configurar la zona horaria
date_default_timezone_set('America/Monterrey');

// Configurar la localización para manejar fechas y horas en español
setlocale(LC_TIME, 'es_ES.UTF-8');

// Asignar el tiempo actual a la sesión en formato de timestamp
$_SESSION['time'] = time(); 

extract($_SESSION);
extract($_GET);
extract($_POST);

//print_r($_SESSION);
$ruta = '../';

include($ruta.'functions/funciones_mysql.php');
include($ruta.'functions/functions.php');
include($ruta.'paciente/calendario.php');
include($ruta.'paciente/fun_paciente.php');
include($ruta.'functions/conexion_mysqli.php');

// Incluir el archivo de configuración y obtener las credenciales
$configPath = $ruta.'../config.php';

if (!file_exists($configPath)) {
	die('Archivo de configuración no encontrado.');
}

$config = require $configPath;

// Crear una instancia de la clase Mysql
$mysql = new Mysql($config['servidor'], $config['usuario'], $config['contrasena'], $config['baseDatos']);


function tildes($palabra) {
    //Rememplazamos caracteres especiales latinos minusculas
    $encuentra = array('&','<','>','¢','£','¥','€','©','®','™','§','†','‡','¶','•','…','±','¹','²','³','½','¼','¾','µ','°','√','∞','Ω','Σ','μ','←','→','↑','↓','↔','↵','⇐','⇒'
);
     $remplaza = array('&amp;','&lt','&gt','&cent','&pound','&yen','&euro','&copy','&reg','&trade','&sect','&dagger','&Dagger','&para','&bull','&hellip','&plusmn','&sup1','&sup2','&sup3','&frac12','&frac14','&frac34','&micro','&deg','&radic','&infin','&ohm','&sigma','&mu','&larr','&rarr','&uarr','&darr','&harr','&crarr','&lArr','&rArr'

);
    $palabra = str_replace($encuentra, $remplaza, $palabra);
return $palabra;
}

//$paciente_id = 26;

//$grafica = "image/imagen_$paciente_id.png";

//$ticket = 1712383079;

$sql = "
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
        cobros.ticket = ?
";
try {
    $result = $mysql->consulta($sql, [$ticket]);
    if ($result['numFilas'] > 0) {
        $row = $result['resultado'][0];
        extract($row);
    } else {
       // die("No se encontró el registro del ticket.");
    }
} catch (Exception $e) {
    die("Error en la consulta: " . $e->getMessage());
}

if (!empty($Invoice_ID)) {
    $clabe = substr($Invoice_ID, -8);
} else {
    $clabe = 'Sin información';
}

 
 
if ($tipo == 'Consulta Medica') {
	switch ($doctor) {
		case 'Dr. Alejandro Aldana':
			$logo = '
		            <img style="height: 150px; width: auto" src="../images/logo_aldana_g.jpg" alt="logo">	
			';	
			$fiscales = '
		        <h2><b>DR. JESÚS ALEJANDRO ALDANA LÓPEZ</b></h2>
		        <p style="font-size: 10px;">
					RFC: AALJ871226N11 Tel.: 33 3995 9901 / 33 3995 9904<br>
					AV DE LOS ARCOS No. 876, Col. JARDINES DEL BOSQUE CENTRO<br>
					C.P 44520 Guadalajara, Jalisco, México<br>
		        </p>	
			';	
			$color_th = "#0096AA";
			$color_td = "#EBF5FB";	
			$receptor = "#eee";					
			break;
		
		case 'Dra. Eleonora Ocampo':
			$logo = '
		            <img style="height: 150px; width: auto" src="../images/logo_eleonor.png" alt="logo">	
			';	
			$fiscales = '
		        <h2><b>DRA. ELEONORA OCAMPO CORONADO</b></h2>
		        <p style="font-size: 10px;">
					RFC: OACE871228767 Tel.: 33 3995 9901 / 33 3995 9904<br>
					AV DE LOS ARCOS No. 876, Col. JARDINES DEL BOSQUE CENTRO<br>
					C.P 44520 Guadalajara, Jalisco, México<br>
		        </p>	
			';
			$color_th = "#F3C2BC";
			$color_td = "#FFEFED";	
			$receptor = "#9CB8D6";						
			break;
		
		case 'Dr Capacitacion':
			$logo = '
		            <img style="height: 150px; width: auto" src="../images/logo_aldana_t.png" alt="logo">	
			';	
			$fiscales = '
		        <h2><b>DR. CAPACITACIÓN</b></h2>
		        <p style="font-size: 10px;">
					RFC: AALJ871226N11 Tel.: 33 3995 9901 / 33 3995 9904<br>
					AV DE LOS ARCOS No. 876, Col. JARDINES DEL BOSQUE CENTRO<br>
					C.P 44520 Guadalajara, Jalisco, México<br>
		        </p>	
			';
			$color_th = "#0096AA";
			$color_td = "#EBF5FB";
			$receptor = "#eee";								
			break;
		
		case 'Capacitacion Neuromodulacion':
			$logo = '
		            <img align="center" style="width: 100px" style="height: 150px; width: auto" src="../images/logo_aldana_t.png" alt="logo">	
			';	
			$fiscales = '
		        <h2><b>DR. CAPACITACIÓN</b></h2>
		        <p style="font-size: 10px;">
					RFC: AALJ871226N11 Tel.: 33 3995 9901 / 33 3995 9904<br>
					AV DE LOS ARCOS No. 876, Col. JARDINES DEL BOSQUE CENTRO<br>
					C.P 44520 Guadalajara, Jalisco, México<br>
		        </p>	
			';
			$color_th = "#0096AA";
			$color_td = "#EBF5FB";
			$receptor = "#eee";								
			break;				
	}
	

} else {
	$logo = '
            <img src="../images/logo_aldana_t.png" alt="logo">
            <h3>Neuromodulación GDL</h3>	
	';
	$fiscales = '
		<h2><b>NEUROMODULACION GDL</b></h2>
        <p style="font-size: 10px;">
            RFC: NGD240109G4A  Tel.: 33 1261 3701<br>
            AV DE LOS ARCOS No. 876, Col. JARDINES DEL BOSQUE CENTRO<br>
            C.P 44520<br>
            Guadalajara, Jalisco, México Régimen Fiscal: Ley General de Personas Morales<br>
        </p>	
	';	
	$color_th = "#0096AA";
	$color_td = "#EBF5FB";
	$receptor = "#eee";	
}




$sql = "
    SELECT
        pacientes.paciente_id, 
        pacientes.empresa_id,
        CONCAT(pacientes.paciente,' ',pacientes.apaterno,' ',pacientes.amaterno) as pacientes
    FROM
        pacientes
    WHERE
        pacientes.paciente_id = ?
";
try {
    $result = $mysql->consulta($sql, [$paciente_id]);
    if ($result['numFilas'] > 0) {
        $row = $result['resultado'][0];
        extract($row);
    } else {
       // die("No se encontró el paciente.");
    }
} catch (Exception $e) {
   // die("Error en la consulta de pacientes: " . $e->getMessage());
}

$hoy = date("d-m-Y");

$n_importe = numero_letra($importe); // $importe; //
$f_pago = format_fecha_esp_dmy($f_captura);

$paciente_consulta = $paciente_consulta ?? '';
$pacientes = $pacientes ?? '';

if ($bind == 'Si') {
	$text_bind = '<p align="center"><b>Obtén tu factura en:</b> https://factura.bind.com.mx  <b>Empresa:</b> 127792  <b>Referencia:</b> '.$clabe.'</p>';
}else {
	$text_bind = '';
}

// Validar y asignar valor basado en la lógica
if (!empty($pacientes)) {
    $paciente_info = $pacientes; // Usar el valor de $pacientes si no está vacío
} else {
    $paciente_info = $paciente_consulta; // Usar $paciente_consulta como valor alternativo
}

$cuerpo_pdf = '
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibo de Pago</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        img { width: auto; height: 100px; }
        .info-section h3, .info-section td { color: #FFF; text-align: center; background: #005157; }
        .receptor, .fecha-pago { background: '.$receptor.'; padding: 10px; }
		.totals-table th, .totals-table td, .payment-methods-table th, .payment-methods-table td { color: #FFF; background: '.$color_th.'; text-align: center; padding: 10px; }
        .totals-table td, .payment-methods-table td { color: #000; background: '.$color_td.';  text-align: center; }
        
                /* Ajusta más estilos según sea necesario */
    </style>
</head>
<body>
<br>
    <table>
        <tr>
            <td align="center" style="width: 30%">
                '.$logo.'
            </td>
            <td align="right">
                <table>
                    <tr>
                        <td class="info-section">
                            <h3>Recibo de pago</h3>
                        </td>
                    </tr>
                    <tr>
                        <td><b style="color: red">Folio:</b> <b>'.$ticket.'</b></td>
                    </tr>
                    <tr>
                    	<td>
                        '.$fiscales.'
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <br><br><br>
    <table>
        <tr>
            <td class="receptor"  style="width: 60%">
                <h4>Receptor</h4>
                <p>'.codificacionUTF($paciente_info).'</p>
            </td>
            <td class="fecha-pago">
                <h4>Fecha de Pago:</h4>
                <p>'.$f_pago.'</p>
            </td>
        </tr>
    </table>
    <br>
    <table class="totals-table">
        <tr>
            <th>Concepto</th>
            <th>Cantidad</th>
            <th>Descripción</th>
            <th>Precio unitario</th>
        </tr>
        <tr>
            <td><b>'.$tipo.'</b></td>
            <td>'.$cantidad.'</td>
            <td>'.codificacionUTF($consulta).'</td>
            <td> $ '.number_format($importe).'</td>
        </tr>
    </table>
 
	<br>  
    <table class="payment-methods-table">
        <tr>
            <th>Fecha de pago</th>
            <th>Forma de pago</th>
            <th>Moneda</th>
            <th>Total</th>
        </tr>
        <tr>
            <td>'.$f_pago.'</td>
            <td>'.$tipo.'</td>
            <td>MXN</td>
            <td> $ '.number_format($importe).'</td>
        </tr>
    </table>
    <hr>
    <br>
    <p style="font-size: 12px;">Tipo Comprobante: <b>Nota</b><br>Importe con letra: <b>'.$n_importe.' PESOS 00/100 M.N. </b><p>
	
    <table>
        <tr>
            <td class="receptor"  style="width: 100%">
                <h4 style="color: #005157">Notas:</h4>
                <p><b>'.codificacionUTF($consulta).'</b></p>
            </td>
        </tr>
    </table> 
    '.$text_bind.'
    <br>
</html>
';



// echo $cuerpo_pdf;

//Require composer autoload
require_once __DIR__ . '/../vendor/autoload.php';
// Create an instance of the class:
$mpdf = new \Mpdf\Mpdf();

// Write some HTML code:
$mpdf->WriteHTML($cuerpo_pdf);

// D descarga
// F guarda
// I imprime

// Output a PDF file directly to the browser
$mpdf->Output('Recibo_'.$ticket.'.pdf','I');

?>	
