<?php
session_start();
error_reporting(7);
iconv_set_encoding('internal_encoding', 'utf-8'); 
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Monterrey');
setlocale(LC_TIME, 'es_ES.UTF-8');
$_SESSION['time']=time();

$ruta = "../";
include($ruta.'functions/funciones_mysql.php');
include($ruta.'functions/functions.php');

extract($_POST);
//extract($_GET);
extract($_SESSION);
//print_r($_POST);
//$ahora = date("c");
$ahora = date("Y-m-d")."T".date("H-m-i");

//$ticket = '1708395677';
//$cRFC = 'SAAS7210041F2';

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
		  cRazonSocial = '".codificacionUTF($cRazonSocial)."', 
		  cRFC = '$cRFC', 
		  cNombreCalle = '".codificacionUTF($cNombreCalle)."', 
		  cNumeroExterior = '".codificacionUTF($cNumeroExterior)."', 
		  cNumeroInterior = '".codificacionUTF($cNumeroInterior)."', 
		  cColonia = '".codificacionUTF($cColonia)."', 
		  cCodigoPostal = '$cCodigoPostal', 
		  cCiudad = '".codificacionUTF($cCiudad)."', 
		  cEstado = '".codificacionUTF($cEstado)."', 
		  cPais = '".codificacionUTF($cPais)."', 
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
		  '".codificacionUTF($cRazonSocial)."', 
		  '$cRFC', 
		  '".codificacionUTF($cNombreCalle)."', 
		  '".codificacionUTF($cNumeroExterior)."', 
		  '".codificacionUTF($cNumeroInterior)."', 
		  '".codificacionUTF($cColonia)."', 
		  '$cCodigoPostal', 
		  '".codificacionUTF($cCiudad)."', 
		  '".codificacionUTF($cEstado)."', 
		  '".codificacionUTF($cPais)."', 
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
echo $sql."<hr>";	
$result =ejecutar($sql); 
$cnt = mysqli_num_rows($result);
$row = mysqli_fetch_array($result);
if ($cnt >= 1) {
	extract($row);
}else{
	echo "No se encontraron datos";		
}	

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


echo "<hr>";
echo "Falta enviar los datos a la API de factura.com";




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
