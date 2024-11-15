<?php
	namespace TIMBRADORXPRESS\API;
	require __DIR__ . "/dev_PHP/class.conexion.php";
	use TIMBRADORXPRESS\API\Conexion;


session_start();
error_reporting(7);
iconv_set_encoding('internal_encoding', 'utf-8'); 
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Monterrey');
setlocale(LC_TIME, 'es_ES.UTF-8');
$_SESSION['time']=mktime();
// 
		// require_once "../vendor/autoload.php";
		// use UAParser\Parser;
$ruta = "../";
include($ruta.'functions/funciones_mysql.php');
		
extract($_POST);
//extract($_GET);
extract($_SESSION);
//print_r($_POST);
//$ahora = date("c");
$ahora = date("Y-m-d")."T".date("H-m-i");

$ticket = '1708395677';
$cRFC = 'SAAS7210041F2';

$sql ="
SELECT
	clientes_sat.cCodigoCliente,
	clientes_sat.cRFC 
FROM
	clientes_sat
WHERE
	clientes_sat.cRFC = '$cRFC'";

//echo "<hr>".$sql."<hr>";	
$result =ejecutar($sql); 
$cnt = mysqli_num_rows($result);

//print_r($row);
if ($cnt >= 1) {
	
	$update="
		UPDATE clientes_sat SET
		  cRazonSocial = '".utf8_encode($cRazonSocial)."', 
		  cRFC = '$cRFC', 
		  cNombreCalle = '".utf8_encode($cNombreCalle)."', 
		  cNumeroExterior = '".utf8_encode($cNumeroExterior)."', 
		  cNumeroInterior = '".utf8_encode($cNumeroInterior)."', 
		  cColonia = '".utf8_encode($cColonia)."', 
		  cCodigoPostal = '$cCodigoPostal', 
		  cCiudad = '".utf8_encode($cCiudad)."', 
		  cEstado = '".utf8_encode($cEstado)."', 
		  cPais = '".utf8_encode($cPais)."', 
		  aRegimen = '$aRegimen', 
		  email_address = '$email_address'
		WHERE clientes_sat.cRFC = '$cRFC';
		
	";
	//echo $update."<hr>";
	$result=ejecutar($update);
	
} else {
	
	$insert="
		INSERT INTO clientes_sat (
		  cRazonSocial, 
		  cRFC, 
		  cNombreCalle, 
		  cNumeroExterior, 
		  cNumeroInterior, 
		  cColonia, 
		  cCodigoPostal, 
		  cCiudad, 
		  cEstado, 
		  cPais, 
		  aRegimen, 
		  email_address
		)value(
		  '".utf8_encode($cRazonSocial)."', 
		  '$cRFC', 
		  '".utf8_encode($cNombreCalle)."', 
		  '".utf8_encode($cNumeroExterior)."', 
		  '".utf8_encode($cNumeroInterior)."', 
		  '".utf8_encode($cColonia)."', 
		  '$cCodigoPostal', 
		  '".utf8_encode($cCiudad)."', 
		  '".utf8_encode($cEstado)."', 
		  '".utf8_encode($cPais)."', 
		  '$aRegimen', 
		  '$email_address'
		)
	";
	//echo $insert."<hr>";	
	$result=ejecutar($insert);
}


$sql ="
SELECT
	clientes_sat.cCodigoCliente, 
	clientes_sat.cRazonSocial, 
	clientes_sat.cRFC, 
	clientes_sat.cNombreCalle, 
	clientes_sat.cNumeroExterior, 
	clientes_sat.cNumeroInterior, 
	clientes_sat.cColonia, 
	clientes_sat.cCodigoPostal, 
	clientes_sat.cCiudad, 
	clientes_sat.cEstado, 
	clientes_sat.cPais, 
	clientes_sat.aRegimen, 
	clientes_sat.email_address
FROM
	clientes_sat
WHERE
	clientes_sat.cRFC = '$cRFC'";

//echo $sql."<hr>";	
$result =ejecutar($sql); 
$cnt = mysqli_num_rows($result);
$row = mysqli_fetch_array($result);
 extract($row);
 
echo "<hr>";	

$sql ="
SELECT
	cobros.cobros_id, 
	cobros.usuario_id, 
	cobros.tipo, 
	cobros.doctor, 
	cobros.protocolo_ter_id, 
	cobros.f_pago, 
	cobros.importe as aImporte, 
	cobros.f_captura, 
	cobros.h_captura, 
	cobros.otros, 
	cobros.empresa_id, 
	cobros.cantidad as aUnidades, 
	cobros.protocolo, 
	cobros.ticket, 
	cobros.facturado
FROM
	cobros
WHERE
	cobros.ticket = $ticket";	
	
$result =ejecutar($sql); 
$row = mysqli_fetch_array($result);
extract($row);


$aCodConcepto = "65040";
$aSerie = "";
$aCodigoAgente = "(Ninguno)";
$aNumMoneda = "1";
$aTipoCambio = "1";

$aCodAlmacen = "1";
$aCodProdSer = "02";
$aUnidades = "1";

// $datos = array(
    // "cCodigoCliente" => $cCodigoCliente,
    // "cRazonSocial" => utf8_decode($cRazonSocial),
    // "cRFC" => utf8_decode($cRFC),
    // "cNombreCalle" => utf8_decode($cNombreCalle),
    // "cNumeroExterior" => utf8_decode($cNumeroExterior),
    // "cNumeroInterior" => utf8_decode($cNumeroInterior),
    // "cColonia" => utf8_decode($cColonia),
    // "cCodigoPostal" => utf8_decode($cCodigoPostal),
    // "cCiudad" => utf8_decode($cCiudad),
    // "cEstado" => utf8_decode($cRazonSocial),
    // "cPais" => utf8_decode($cRazonSocial),
    // "aRegimen" => $aRegimen,
    // "aCodConcepto" => $aCodConcepto,
    // "aSerie" => $aSerie,
    // "aCodigoAgente" => $aCodigoAgente,
    // "aNumMoneda" => $aNumMoneda,
    // "aTipoCambio" => $aTipoCambio,
    // "aImporte" => $aImporte,
    // "Movimientos" => array(
        // array(
            // "aCodAlmacen" => $aCodAlmacen,
            // "aCodProdSer" => $aCodProdSer,
            // "aUnidades" => $aUnidades,
            // "aPrecio" => $aImporte
        // )
    // )
// );

//echo $ahora;

$ahora = date('Y-m-d').'T'.date('H:i:s');
echo $ahora."<hr>";
//$rfc  = 'XAXX010101000';
$rfc  = 'SAAS7210041F2';
$nombre = $rfc;

$datos  = '
{
    "Comprobante":
    {
        "Version": "4.0",
        "Serie": "Prueba",
        "Folio": "98-011",
        "Fecha": "'.$ahora.'",
        "FormaPago": "03",
        "NoCertificado": "30001000000500003416",
        "CondicionesDePago": "NA",
        "SubTotal": "'.$aImporte.'",
        "Moneda": "MXN",
        "TipoCambio": "1",
        "Total": "'.$aImporte.'",
        "TipoDeComprobante": "I",
        "Exportacion": "01",
        "MetodoPago": "PUE",
        "LugarExpedicion": "72000",
        "CfdiRelacionados":
        {
            "TipoRelacion": "04",
            "CfdiRelacionado":
            [
                "df117db8-1446-47c4-b70f-46a25d8df051"
            ]
        },
        "Emisor":
        {
            "Rfc": "EKU9003173C9",
            "Nombre": "ESCUELA KEMPER URGATE",
            "RegimenFiscal": "601"
        },
        "Receptor":
        {
            "Rfc": "'.$rfc.'",
            "Nombre": "'.$cRazonSocial.'",
            "DomicilioFiscalReceptor": "72000",
            "RegimenFiscalReceptor": "616",
            "UsoCFDI": "S01"
        },
        "Conceptos":
        [
            {
                "ClaveProdServ": "85121502",
                "NoIdentificacion": "miclave",
                "Cantidad": "1",
                "ClaveUnidad": "E48",
                "Unidad": "Unidad de servicio",
                "Descripcion": "CONSULTA MEDICA DEL DIA '.$f_captura.'",
                "ValorUnitario": "1.00",
                "Importe": "1.00",
                "ObjetoImp": "02",
                "Impuestos":
                {
                    "Traslados":
                    [
                        {
                            "Base": "1.00",
                            "Impuesto": "002",
                            "TipoFactor": "Tasa",
                            "TasaOCuota": "0.160000",
                            "Importe": "0.16"
                        }
                    ],
   
                }
            }
        ],
        "Impuestos":
        {
            "TotalImpuestosRetenidos": "0.04",
            "TotalImpuestosTrasladados": "0.16",
            "Retenciones":
            [
                {
                    "Impuesto": "002",
                    "Importe": "0.04"
                }
            ],
            "Traslados":
            [
                {
                    "Base": "1.00",
                    "Impuesto": "002",
                    "TipoFactor": "Tasa",
                    "TasaOCuota": "0.160000",
                    "Importe": "0.16"
                }
            ]
        }
    },
    "CamposPDF":
    {
        "tipoComprobante": "FACTURA",
        "Comentarios": "Aquí van los comentarios de la factura."
    },
    "logo": ""
}';

echo $datos."<hr>";

	$opc = '9';



	# OBJETO DEL API DE CONEXION
	$url = 'https://dev.facturaloplus.com/ws/servicio.do?wsdl';
	$objConexion = new Conexion($url);

	# CREDENCIAL
	$apikey = 'eca7f6b50f974b87ad3ef90f01792074';
	// $opc = '';
// 
	// if (isset($_GET['opc']))
		// $opc = $_GET['opc'];

	switch($opc)
	{
		case 1: 
				$cfdi = file_get_contents('rsc/ejemplo_cfdi.xml');
				echo $objConexion->operacion_timbrar($apikey, $cfdi);
			break;
		case 2: 
				$cfdi = file_get_contents('rsc/ejemplo_cfdi.xml');
				echo $objConexion->operacion_timbrarTFD($apikey, $cfdi);
			break;
		case 3: 
				$cfdi = file_get_contents('rsc/ejemplo_cfdi.xml');
				echo $objConexion->operacion_timbrar3($apikey, $cfdi);
			break;
		case 4: 
				$cfdi = file_get_contents('rsc/ejemplo_cfdi40.xml');
				$keyPEM = file_get_contents('rsc/CSD_EKU9003173C9_key.pem');
				echo $objConexion->operacion_timbrarConSello($apikey, $cfdi, $keyPEM);

			break;
		case 5: 
				$txtB64 = base64_encode( file_get_contents('rsc/ejemplo_cfdi40.txt') );
				$keyPEM = file_get_contents('rsc/CSD_EKU9003173C9_key.pem');
				$cerPEM = file_get_contents('rsc/CSD_EKU9003173C9_cer.pem');
				echo $objConexion->operacion_timbrarTXT($apikey, $txtB64, $keyPEM, $cerPEM);
			break;
		case 6: 
				$txtB64 = base64_encode( file_get_contents('rsc/ejemplo_cfdi33.txt') );
				$keyPEM = file_get_contents('rsc/CSD_EKU9003173C9_key.pem');
				$cerPEM = file_get_contents('rsc/CSD_EKU9003173C9_cer.pem');
				$plantilla = '1';
				$logoB64 = base64_encode( file_get_contents('rsc/logo.png') );
				echo $objConexion->operacion_timbrarTXT2($apikey, $txtB64, $keyPEM, $cerPEM, $plantilla, $logoB64);
			break;
		case 7: 
				$txtB64 = base64_encode( file_get_contents('rsc/ejemplo_cfdi33.txt') );
				$keyPEM = file_get_contents('rsc/CSD_EKU9003173C9_key.pem');
				$cerPEM = file_get_contents('rsc/CSD_EKU9003173C9_cer.pem');
				echo $objConexion->operacion_timbrarTXT3($apikey, $txtB64, $keyPEM, $cerPEM);
			break;
		case 8: 
				$jsonB64 = base64_encode( $datos );
				$keyPEM = file_get_contents('rsc/CSD_EKU9003173C9_key.pem');
				$cerPEM = file_get_contents('rsc/CSD_EKU9003173C9_cer.pem');
				echo $objConexion->operacion_timbrarJSON($apikey, $jsonB64, $keyPEM, $cerPEM);
				echo "<hr>".$datos;
			break;
		case 9: 
				$jsonB64 = base64_encode( $datos );
				$keyPEM = file_get_contents('dev_PHP/rsc/CSD_EKU9003173C9_key.pem');
				$cerPEM = file_get_contents('dev_PHP/rsc/CSD_EKU9003173C9_cer.pem');
				$plantilla = '1';

				echo $objConexion->operacion_timbrarJSON2($apikey, $jsonB64, $keyPEM, $cerPEM, $plantilla, $nombre);
			break;
		case 10:
				$jsonB64 = base64_encode( $datos );
				$keyPEM = file_get_contents('dev_PHP/rsc/CSD_EKU9003173C9_key.pem');
				$cerPEM = file_get_contents('dev_PHP/rsc/CSD_EKU9003173C9_cer.pem');
				echo $objConexion->operacion_timbrarJSON3($apikey, $jsonB64, $keyPEM, $cerPEM);
			break;
		case 11:
			$jsonB64 = base64_encode( file_get_contents('rsc/ejemplo_cfdi33.json') );
			$keyPEM = file_get_contents('rsc/CSD_EKU9003173C9_key.pem');
			$cerPEM = file_get_contents('rsc/CSD_EKU9003173C9_cer.pem');
			$plantilla = 'retenciones';
			echo $objConexion->operacion_timbrarRetencionJSON($apikey, $jsonB64, $keyPEM, $cerPEM, $plantilla);
			break;
		case 12: 
				$cfdi = file_get_contents('rsc/ejemplo_cfdi.xml');
				echo $objConexion->operacion_timbrarRetencion($apikey, $cfdi);
			break;
		case 13: 
				echo $objConexion->operacion_consultar_creditos($apikey);
			break;
		case 14: 
				$uuid = '4a5dc24d-e0a9-4172-9fdd-38b2dfbd4435';
				$rfcEmisor = 'EKU9003173C9';
				$rfcReceptor = 'XAXX010101000';
				$total = 1.16;
				echo $objConexion->operacion_consultarEstadoSAT($apikey, $uuid, $rfcEmisor, $rfcReceptor, $total);
			break;
		case 15: 
				$uuid = '4a5dc24d-e0a9-4172-9fdd-38b2dfbd4435';
				$rfcEmisor = 'EKU9003173C9';
				$rfcReceptor = 'XAXX010101000';
				$total = 1.16;
				$keyCSD = base64_encode( file_get_contents('rsc/CSD_EKU9003173C9.key') );
				$cerCSD = base64_encode( file_get_contents('rsc/CSD_EKU9003173C9.cer') );
				$passCSD = '12345678a';
				echo $objConexion->operacion_cancelar($apikey, $keyCSD, $cerCSD, $passCSD, $uuid, $rfcEmisor, $rfcReceptor, $total);
			break;
		case 16: 
				$uuid = '4a5dc24d-e0a9-4172-9fdd-38b2dfbd4435';
				$rfcEmisor = 'EKU9003173C9';
				$rfcReceptor = 'XAXX010101000';
				$total = 1.16;
				$pfxB64 = base64_encode( file_get_contents('rsc/CSD_EKU9003173C9.pfx') );
				$passPFX = '12345678a';
				echo $objConexion->operacion_cancelarPFX($apikey, $pfxB64, $passPFX, $uuid, $rfcEmisor, $rfcReceptor, $total);
			break;
		case 17: 
				$keyPEM = file_get_contents('rsc/CSD01_AAA010101AAA_key.pem');
				$cerPEM = file_get_contents('rsc/CSD01_AAA010101AAA_cer.pem');
				echo $objConexion->operation_consultarAutorizacionesPendientes($apikey, $keyPEM, $cerPEM);
			break;
		case 18: 
				$keyPEM = file_get_contents('rsc/CSD01_AAA010101AAA_key.pem');
				$cerPEM = file_get_contents('rsc/CSD01_AAA010101AAA_cer.pem');
				$uuid = 'A2C2335B-552A-4CD4-A400-238443DBFC4B';
				$respuesta = 'Aceptar'; // 'Rechazar'
				echo $objConexion->operation_autorizarCancelacion($apikey, $keyPEM, $cerPEM, $uuid, $respuesta);
			break;
		case 19: 
				$uuid = '4a5dc24d-e0a9-4172-9fdd-38b2dfbd4435';
				$rfcEmisor = 'EKU9003173C9';
				$rfcReceptor = 'XAXX010101000';
				$total = 1.16;
				$keyCSD = base64_encode( file_get_contents('rsc/CSD_EKU9003173C9.key') );
				$cerCSD = base64_encode( file_get_contents('rsc/CSD_EKU9003173C9.cer') );
				$passCSD = '12345678a';
				$motivo = '02';
				$folioSustitucion = '';
				echo $objConexion->operacion_cancelar2($apikey, $keyCSD, $cerCSD, $passCSD, $uuid, $rfcEmisor, $rfcReceptor, $total, $motivo, $folioSustitucion);
			break;
		case 20: 
				$uuid = '4a5dc24d-e0a9-4172-9fdd-38b2dfbd4435';
				$rfcEmisor = 'EKU9003173C9';
				$rfcReceptor = 'XAXX010101000';
				$total = 1.16;
				$pfxB64 = base64_encode( file_get_contents('rsc/CSD_EKU9003173C9.pfx') );
				$passPFX = '12345678a';
				$motivo = '02';
				$folioSustitucion = '';
				echo $objConexion->operacion_cancelarPFX2($apikey, $pfxB64, $passPFX, $uuid, $rfcEmisor, $rfcReceptor, $total, $motivo, $folioSustitucion);
			break;
		case 21: 
				$uuid = 'd448212f-e428-41e2-ad23-ce41b3df7982';
				echo $objConexion->operacion_consultarCFDI($apikey, $uuid);
			break;
		default: header('Content-Type: text/html');
				echo 'OPERACION DESCONCIDA, DEFINA UNA OPERACIÓN VIA GET<br>';
				echo '1) timbrar<br>';
				echo '2) timbrar TFD<br>';
				echo '3) timbrar 3<br>';
				echo '4) timbrar TimbrarConSello<br>';
				echo '5) timbrar TXT (sólo XML)<br>';
				echo '6) timbrar TXT2 (XML y PDF)<br>';
				echo '7) timbrar TXT3 (XML y datos para PDF)<br>';
				echo '8) timbrar JSON (sólo XML)<br>';
				echo '9) timbrar JSON2 (XML y PDF)<br>';
				echo '10) timbrar JSON3 (XML y datos para PDF)<br>';
				echo '11) timbrar Retenciones JSON (XML y PDF)<br>';
				echo '12) timbrar Retenciones<br>';
				echo '13) consultar creditos<br>';
				echo '14) consultar estado SAT<br>';
				echo '15) cancelar<br>';
				echo '16) cancelarPFX<br>';
				echo '17) consultar autorizaciones pendientes<br>';
				echo '18) autorizar cancelación<br>';
				echo '19) cancelar2<br>';
				echo '20) cancelarPFX2<br>';
				echo '21) consultarCFDI<br>';
				echo '<br>p.e. http://localhost/../PHP/test.php?opc=5';
	}


// // Para convertirlo a JSON
// $jsonData = json_encode($datos, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
// echo $jsonData."<hr>";
// 
// // URL del webhook al que quieres enviar el JSON
// $webhookUrl = 'http://localhost/facturacion/dev_PHP/test.php?opc=8';
// // Inicializa cURL
// $ch = curl_init($webhookUrl);
// 
// // Configura las opciones de cURL para la petición
// curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
// curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    // 'Content-Type: application/json',
    // 'Content-Length: ' . strlen($jsonData))
// );
// 
// // Envía la petición y guarda la respuesta 
// $response = curl_exec($ch);
// 
// // Cierra el recurso cURL
// curl_close($ch);


// 
// // URL del webhook al que quieres enviar el JSON
// $webhookUrl = 'http://localhost/facturacion/dev_PHP/test.php?opc=10';
// 
// // Inicializa cURL
// $ch = curl_init($webhookUrl);
// 
// // Configura las opciones de cURL para la petición
// curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
// curl_setopt($ch, CURLOPT_POSTFIELDS, $datos); // Aquí cambia $jsonData por $datos
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    // 'Content-Type: application/json',
    // 'Content-Length: ' . strlen($datos))
// );
// 
// // Envía la petición y guarda la respuesta 
// $response = curl_exec($ch);
// 
// // Verifica si ocurrió algún error durante la petición
// if(curl_errno($ch)){
    // echo 'Curl error: ' . curl_error($ch);
// }
// 
// // Cierra el recurso cURL
// curl_close($ch);
// 
// echo $datos."<hr>";
// // Opcional: Maneja la respuesta
// echo $response."<hr>";
// 





$insert="
	INSERT INTO conceptos_sat (
	  aCodConcepto, 
	  aSerie, 
	  aCodigoAgente, 
	  aNumMoneda, 
	  aTipoCambio, 
	  aImporte, 
	  cCodigoCliente,
	  ticket
	) VALUES (
	  '$aCodConcepto', 
	  '$aSerie', 
	  '$aCodigoAgente', 
	  $aNumMoneda, 
	  $aTipoCambio, 
	  $aImporte, 
	  $cCodigoCliente,
	  $ticket
	)
";
	//echo $insert."<hr>";	
	$result=ejecutar($insert);

$sql ="
SELECT
	max( conceptos_sat.idConcepto ) AS idConcepto 
FROM
	conceptos_sat";

//echo $sql."<hr>";	
$result =ejecutar($sql); 
//$cnt = mysqli_num_rows($result);
$row = mysqli_fetch_array($result);
 extract($row);
// print_r($row);
// echo "<hr>";
	

$insert="
	INSERT INTO movimientos_sat (
	  aCodAlmacen, 
	  aCodProdSer, 
	  aUnidades, 
	  aPrecio, 
	  idConcepto
	) VALUES (
	  '$aCodAlmacen', 
	  '$aCodProdSer', 
	  $aUnidades, 
	  $aImporte, 
	  $idConcepto
	)
";
//	echo $insert."<hr>";	
	$result=ejecutar($insert);	
