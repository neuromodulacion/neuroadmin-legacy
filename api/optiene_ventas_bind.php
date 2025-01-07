+<?php
// Incluir las funciones MySQL necesarias para interactuar con la base de datos
include('../functions/funciones_mysql.php');

// Configurar el nivel de reporte de errores
error_reporting(7); // Mostrar errores, advertencias y avisos

// Establecer la codificación interna a UTF-8 (nota: esta función está en desuso y no tiene efecto en PHP 7.4 y superior)
iconv_set_encoding('internal_encoding', 'utf-8');

// Configurar el tipo de contenido a texto HTML con codificación UTF-8
header('Content-Type: text/html; charset=UTF-8');

// Establecer la zona horaria a "America/Monterrey"
date_default_timezone_set('America/Monterrey');

// Establecer la configuración regional a español (España) con UTF-8
setlocale(LC_TIME, 'es_ES.UTF-8');

// Registrar el timestamp actual en la sesión
$_SESSION['time'] = time(); 

// Eliminar todos los registros de la tabla "invoices_bind" antes de proceder a la inserción de nuevos datos
$delete = "
DELETE 
FROM invoices_bind";
$result_update = ejecutar($delete);

// Iniciar un bucle para realizar múltiples solicitudes a la API externa y obtener diferentes bloques de datos
for ($i = 0; $i < 14; $i++) { 
	// Calcular el valor de "skip" para la paginación en la API
	$skip = ($i * 100);
	
	// Configurar la URL de la API. Si es la primera iteración, se utiliza la URL base; de lo contrario, se agrega el parámetro de paginación "$skip".
	if ($i == 0) {
		$url = 'https://api.bind.com.mx/api/Invoices';
	} else {
		$url = 'https://api.bind.com.mx/api/Invoices?$skip=' . $skip;
	}
		 
	// Mostrar la URL que se está utilizando (para depuración)
	echo $url . '<hr>';

	// Iniciar una sesión cURL para realizar la solicitud a la API
	$curl = curl_init($url);
	
	// Clave de suscripción y token de autorización para la API
	$key = "neuromodulaciongdl";
	$authorization = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1bmlxdWVfbmFtZSI6Imxlb25hcmRvIHNhbnp8MTI3NzkyIiwiSW50ZXJuYWxJRCI6ImUzNzM4OWVkLTdmM2EtNDM0OS1iMmNmLTU3YTZmMDdjZDEwZCIsIm5iZiI6MTcxMzU0NTY3MiwiZXhwIjoxNzQ1MDgxNjcyLCJpYXQiOjE3MTM1NDU2NzIsImlzcyI6Ik1pbm50X1NvbHV0aW9uc19TQV9ERV9DViIsImF1ZCI6IkJpbmRfRVJQX0FQSV9Vc2VycyJ9.lA7OgjBx9QDh6dwMGkYeKdCa4eNTFlx7wtPy3gF7M_E";
	
	// Configurar los encabezados de la solicitud cURL
	$headers = array(
	    'Content-Type: application/json', 
	    'Cache-Control: no-cache', 
	    'Ocp-Apim-Subscription-Key: ' . $key, 
	    'Authorization: Bearer ' . $authorization
	);
	
	// Configurar opciones de cURL para realizar una solicitud GET
	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
	
	// Ejecutar la solicitud y almacenar la respuesta
	$resp = curl_exec($curl);
	
	// Cerrar la sesión cURL
	curl_close($curl);
	
	// Decodificar la respuesta JSON a un array asociativo de PHP
	$data = json_decode($resp, true);
	
	// Obtener los datos relevantes de la respuesta
	$valueArray = $data['value'];  // Datos principales
	$nextLink = $data['nextLink']; // Enlace para la siguiente página de resultados (no se utiliza en este código)
	$count = $data['count'];       // Número total de registros (no se utiliza en este código)
	
	// Recorrer cada valor del array y extraer los datos para insertar en la base de datos
	foreach ($valueArray as $value) {
	    // Extraer los campos necesarios de cada factura
	    $ID = $value['ID'];
	    $Serie = $value['Serie'];
	    $Date = $value['Date'];
	    $Number = $value['Number'];
	    $UUID = $value['UUID'];
	    $ExpirationDate = $value['ExpirationDate'];
	    $ClientID = $value['ClientID'];
	    $ClientName = $value['ClientName'];
	    $RFC = $value['RFC'];
	    $Cost = $value['Cost'];
	    $Subtotal = $value['Subtotal'];
	    $Discount = $value['Discount'];
	    $VAT = $value['VAT'];
	    $IEPS = $value['IEPS'];
	    $ISRRet = $value['ISRRet'];
	    $VATRet = $value['VATRet'];
	    $Total = $value['Total'];
	    $Payments = $value['Payments'];
	    $CreditNotes = $value['CreditNotes'];
	    $CurrencyID = $value['CurrencyID'];
	    $LocationID = $value['LocationID'];
	    $WarehouseID = $value['WarehouseID'];
	    $PriceListID = $value['PriceListID'];
	    $CFDIUse = $value['CFDIUse'];
	    $ExchangeRate = $value['ExchangeRate'];
	    $VATRetRate = $value['VATRetRate'];
	    $Comments = $value['Comments'];
	    $VATRate = $value['VATRate'];
	    $PurchaseOrder = $value['PurchaseOrder'];
	    $IsFiscalInvoice = $value['IsFiscalInvoice'] ? 1 : 0; // Convertir a 1 o 0
	    $ShowIEPS = $value['ShowIEPS'] ? 1 : 0;               // Convertir a 1 o 0
	    $Status = $value['Status'];
	
	    // Crear la consulta SQL para insertar los datos en la tabla "invoices_bind"
	    $insert = "
	    INSERT INTO invoices_bind (
	        ID, Serie, Date, Number, UUID, ExpirationDate, ClientID, ClientName, RFC, Cost, Subtotal, 
	        Discount, VAT, IEPS, ISRRet, VATRet, Total, Payments, CreditNotes, CurrencyID, 
	        LocationID, WarehouseID, PriceListID, CFDIUse, ExchangeRate, VATRetRate, Comments, 
	        VATRate, PurchaseOrder, IsFiscalInvoice, ShowIEPS, Status
	    ) VALUES (
	        '$ID', '$Serie', '$Date', '$Number', '$UUID', '$ExpirationDate', '$ClientID', '$ClientName', 
	        '$RFC', '$Cost', '$Subtotal', '$Discount', '$VAT', '$IEPS', '$ISRRet', '$VATRet', 
	        '$Total', '$Payments', '$CreditNotes', '$CurrencyID', '$LocationID', '$WarehouseID', 
	        '$PriceListID', '$CFDIUse', '$ExchangeRate', '$VATRetRate', '$Comments', '$VATRate', 
	        '$PurchaseOrder', '$IsFiscalInvoice', '$ShowIEPS', '$Status'
	    )";
	    
	    // Mostrar la consulta de inserción (para depuración)
	    echo $insert . "<hr>";
	    
	    // Ejecutar la consulta de inserción en la base de datos
	    $result_insert = ejecutar($insert);
	}
}

// Actualizar los datos en la tabla "pacientes_bind" basados en los datos recién insertados en "invoices_bind"
$update = "
UPDATE pacientes_bind
LEFT JOIN ( 
    SELECT ClientID, COUNT(*) AS ventas, SUM(total) AS total 
    FROM invoices_bind 
    GROUP BY ClientID 
) ib ON pacientes_bind.ID = ib.ClientID 
SET pacientes_bind.ventas = COALESCE(ib.ventas, 0),
pacientes_bind.total = COALESCE(ib.total, 0);
";

// Mostrar la consulta de actualización (para depuración)
echo $update . "<hr>";

// Ejecutar la consulta de actualización en la base de datos
$result_update = ejecutar($update);

